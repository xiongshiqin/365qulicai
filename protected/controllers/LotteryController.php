<?php
/**
 * 转盘抽奖结果
 * @author porter 
 * 2014-11-27
 */
class LotteryController  extends Controller{
	// 转盘抽奖结果
	public function actionLotteryResult(){
		$lotid = Yii::app()->request->getParam('lotid');
		$lottery = Lottery::model()->findByPk($lotid);
		$eventLike = EventLike::model()->findByAttributes(array('uid' => Yii::app()->user->id , 'eventid' => $lottery->eventid));
		$event = Event::model()->findByPk($lottery->eventid);
		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn('needLogin' , $this->createUrl('/index/login'));
		}

		$now = time();
		if($lottery->starttime > $now){
			$this->ajaxErrReturn('亲，抽奖时间还没到哦~');
		}
		if($lottery->endtime < $now){
			$this->ajaxErrReturn('亲，抽奖已经结束了哦~');
		}
		if(! $eventLike){
			$this->ajaxErrReturn('请先点赞！');
		}
		// 一天可免费抽奖一次  没做
		$curLottery = 'free'; // 默认免费一天一次抽奖
		$lastLottery = LotteryLog::model()->find(array('order' => 'dateline desc'));
		if(date('Y-m-d') == date('Y-m-d' , $lastLottery['dateline'])){ // 如果今天已经抽过一次，则为消耗抽奖次数的抽奖
			$curLottery = 'times'; 
			if($eventLike->canlotterynum <= 0){
				$msg = '没有抽奖机会了哦~，请邀请好友获取抽奖机会！';
				if($lottery->awardchance == 0){
					$msg = '没有抽奖机会了，每个人只能有一次抽奖机会';
				}
				$this->ajaxErrReturn($msg);
			}
		}
		// 获取奖品等级数据
		$result = LotterySet::model()->findAll(array(
					"condition" => "lotid = $lotid",
					"order" => "id asc",
					));
		$awardNum = count($result); // 一共有几等奖
		$prize_arr = array();
		//判断当前登录用户是否是该活动的VIP,如果用户是第一次在该活动抽奖，则判断是否为vip限定抽取，否则都按普通用户
		$userIsVip = ($eventLike->vip == 1 && $eventLike->lotterynum <= 0);
		// 如果是vip 则把普通奖项的概率设成0 ，否则把vip的概率设成0
		// 将奖品按照0下标开始排序
		foreach($result as $v){
			// 如果当前奖项为vip限定抽取,且当前登录用户不是vip，则概率设置0
			// 或者当前奖项不是vip限定抽取，切当前登录用户是vip，则概率设置0
			if(($v->vip && !$userIsVip) || (!$v->vip && $userIsVip)){ 
				$v->probability = 0;
			} 
			$prize_arr[] = $v->attributes;
		}
		$arr = array();
		foreach($result as $key =>$val) {
			$arr[] = $val->probability;
		}
		$rid = $this->getRand($arr); //根据概率获取奖项id
		//判断当前奖品为中奖奖品,并且数量大于0,如果不是,继续随机
		while ($rid !== 'none' && $prize_arr[$rid]['awardnum'] <= 0) {
			// 如果全部都抽光了，则为未中奖 
			$total = 0;
			foreach($prize_arr as $v){
				$total += $v['awardnum'];
			}
			if($total <= 0){
				$rid = 'none';
			} else {
				$arr[$rid] = 0; // 如果当前奖项的奖品数量小于等于0，则将此奖项概率设为0
				$rid = $this->getRand($arr);
			}
		}
		
		if($event->lotterytype == 2){ // 获得转盘抽奖结果
			$result = array_merge($result , $this->rotaryResult($lottery->awardnum , $rid));
		} else if($event->lotterytype == 1){ // 砸金蛋抽奖结果
			$result = array_merge($result , $this->eggResult());
		} else if($event->lotterytype == 3){ // 翻版抽奖结果
			$result = array_merge($result , $this->turnResult($prize_arr , $rid));
		}

		$uid = Yii::app()->user->id;
		$username = Yii::app()->user->name;
		if($rid !== 'none'){
			$res = $prize_arr[$rid];
			$awardid = $res['awardid'];
			$awardname = $res['awardname'];
			$level = $rid;
		
			$result['prize'] = $res['awardname'];
			$result['hit'] = true;
		}else{
			$awardid = 0;
			$awardname = '未中奖';
			$level = 0;

			$result['prize'] = "未中奖";
			$result['hit'] = false;

			
		}
		$dateline = time();
		
		// 抽奖记录
		$lotteryLog = new LotteryLog();
		$lotteryLog->uid = $uid;
		$lotteryLog->username = $username;
		$lotteryLog->lotid = $lotid;
		$lotteryLog->level = $level;
		$lotteryLog->awardid = $awardid;
		$lotteryLog->awardname = $awardname;
		$lotteryLog->save();

		// 抽奖次数+1
		EventLike::model()->updateCounters(array('lotterynum'=> 1), 'uid=' . $uid . ' and eventid = ' . $lottery->eventid);

		// 如果为次数抽奖，则可抽奖次数-1
		if($curLottery == 'times'){
			EventLike::model()->updateCounters(array('canlotterynum'=> -1), 'uid=' . $uid . ' and eventid = ' . $lottery->eventid);
		}

		if($rid !== 'none'){
			$autogiving = 0; // 是否已完成并成功执行自动发放虚拟货币操作
			// 如果设定自动货币自动发奖且中的奖项为金币或红包，则直接发放
			$eventAward =  EventAward::model()->findByPk($res['awardid']);
			if($lottery->autogiving && $eventAward->awardtype != 1){
				/** api自动发奖约定4个参数
				类型  type	1红包  2金币
				值    money	50
				用户  username   lwx
				签名  sign	md5(key + type + money + username)
				**/
				//解析api 取出key和api地址
				$companyApi = CompanyApi::model()->findByPk($eventLike->p2pid);
				if($companyApi && $companyApi->lottery_api){
					$apiArr = explode("key=" , $companyApi->lottery_api);
					$api = $apiArr[0];
					
					$api_key = trim($apiArr[1]);
					$api_type = ($eventAward->awardtype==2) ? 1 : ($eventAward->awardtype==3 ? 2 : 0);
					$api_money = $eventAward->awardvalue;
					$api_username = CompanyFollow::model()->find("uid = $uid and cpid = " . $eventLike->p2pid )->p2pname;
					$api_sign = md5($api_key . $api_type . $api_money . $api_username);
					
					// 必须关联平台帐号才自动发奖
					$api .= "type=$api_type&money=$api_money&username=$api_username&sign=$api_sign";
					$curlResult = HCurl::newInstance()->url($api)->get();
					if($curlResult['data'] == 10 ){ // 返回10代表成功
						$autogiving = 1;
					}
				}
			}

			// 商品数减一
			LotterySet::model()->updateCounters(array('awardnum'=> -1), 'id=' . $res['id']);
			
			// 用户中奖记录
			$eventLike = EventLike::model()->findByAttributes(array('uid'=>Yii::app()->user->id,'eventid'=>$lottery->eventid));
			$log = unserialize($eventLike->log);
			$log[] = $awardname;
			$eventLike->log = serialize($log);
			$eventLike->save();			

			// 插入发放记录表
			$lotteryAwardList = new LotteryAwardList();
			$lotteryAwardList->eventid = $lottery->eventid;
			$lotteryAwardList->lotid = $lotid;
			$lotteryAwardList->uid = $uid;
			$lotteryAwardList->username = $username;
			$lotteryAwardList->awardid = $awardid;
			$lotteryAwardList->issend = $autogiving;
			$lotteryAwardList->awardname = $awardname;
			$lotteryAwardList->save();
			// 用户获奖数+1放在发放逻辑里面
		}
		$result['status'] = true;
		echo json_encode($result);
	}

	// 转盘抽奖的结果
	private function rotaryResult($awardnum , $rid){
		// 这里奖项是变动的，转盘也是变动的，所以角度直接用数组写出来而不是求出来
		$allAngles = array(//所有等级奖的角度
			3 => array(
				'win' => array( 270 , 180 , 90), // 中奖的角度
				'lost' => array(0), //未中奖的角度
				'one' => 360/4, // 一个扇形的角度
				'start' => 0, // 指针是否指向起点,偏离多少度(一般为半个扇形)
			),
			4 => array(
				'win' => array(288 , 216 , 144 , 72),
				'lost' => array(0),
				'one' => 360/5,
				'start' => 360/5/2,
			),
			5 => array(
				'win' => array(300 , 240 , 180 , 120 , 60),
				'lost' => array(0),
				'one' => 360/6,
				'start' => 360/6/2,
			),
		);
		$angles = $allAngles[$awardnum]; // 几个等级的奖的角度
		$randAngle = mt_rand(($angles['one']-20)/2 , ($angles['one']+20)/2); // 取得在特定扇形上中心20度的一个随机的角度
		// 得到奖项
		$result = array();
		if($rid === 'none'){ // 未中奖
			$angle = $randAngle + $angles['lost'][mt_rand(0 , count($angles['lost'])-1)];
		
		} else {
			$angle = $randAngle + $angles['win'][$rid];
		}
		//由于一等奖起始角度不是0度，所以angle要减去一半的OneSector,而且奖项是倒序排列的
		// $angle = 360 - ($angle-$angles['one']/2);
		$angle = 360 - $angle - $angles['start'];
		$result['angle'] = $angle;
		return $result;
	}

	// 砸金蛋结果
	private function eggResult(){
		return array();
	}

	// 翻牌结果
	private function turnResult($prize_arr , $rid){
		if($rid !== 'none'){
			unset($prize_arr[$rid]); //将中奖项从数组中剔除，剩下未中奖项 
		}
		ksort($prize_arr); // 对清楚了rid后的数组进行排序
		$pr = array();
		foreach($prize_arr as $v){
			$pr[] = $v['awardname']; 
		} 
		// 补齐6个牌子,一个牌子是翻开的奖项
		for($j=count($prize_arr);$j<5;$j++){
			$pr[] = "下次没准就能中哦";
		}
		shuffle($pr); //打乱数组顺序 
		$res['no'] = $pr; 
		return $res;
	}

	// 得到抽奖的随机数
	private function getRand($proArr) {
		$result = 'none';    
		//概率数组的总概率精度   
		// $proSum = array_sum($proArr); 
		$proSum = 10000;   
		//概率数组循环   
		foreach ($proArr as $key => $proCur) {   
			$proCur *= 100; // 两位小数的百分比乘以100，总和为10000  
			$randNum = round(mt_rand(1, $proSum));  
			if ($randNum <= $proCur) {   
				$result = $key;   
				break;   
			} else {   
				$proSum -= $proCur;   
			}         
		}   
		return $result; 
	}   
}