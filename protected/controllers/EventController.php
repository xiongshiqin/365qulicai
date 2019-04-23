<?php
/**
* 优惠活动
*
*/
class EventController  extends Controller
{
	public function actions(){
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0x55FF00,
				'padding'=>0,
				'height'=>50, 
				'maxLength'=>4,
				'transparent'=>true,
			),

			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function filters(){ 
		return array(
			'accessControl',
		);
	}

	public function accessRules(){
		return array(
			
			// array('allow',
			// 'actions'=>array('p2pEvents'),
			// ),
			
			// array('deny',
			// 'users'=>array('?'),
			// ),
		);
	}

	// p2p优惠活动
	public function actionP2pEvents(){
		$tab = Yii::app()->request->getParam('tab' , 'all');
		$type = Yii::app()->request->getParam('type' , 0); // 活动类型

		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$data = array();

		if($tab == 'mine'){ //  我关注的平台
			$p2ps = CompanyFollow::model()->findAllByAttributes(array('uid' => Yii::app()->user->id));
			$p2pids = array(0); // 写发个0防止为空报错
			foreach($p2ps as $v){
				$p2pids[] = $v->attributes['cpid'];
			}
			$p2pids = implode(',' , $p2pids);
			$criteria->condition = "t.status = 2 and t.p2pid in ($p2pids)";
		} else if($cpid = Yii::app()->request->getParam('cpid' , 0)){ // 特定平台
			$company = Company::model()->findByPk($cpid);
			$criteria->condition = "t.status = 2 and t.p2pid = $cpid";
			$data['company'] = $company;
		} else {  // 全部平台 
			$criteria->condition = "t.status = 2";
		}
		if($type){ // 活动类型过滤
			$criteria->condition .= " and t.type = $type";
		}
		// 活动时间开始时间需要小于当前时间，结束时间需要大于当前时间
		// $now = time();
		// $criteria->condition .= " and t.starttime < $now  and t.endtime > $now";
		// 如果有搜索内容，则结果为搜索结果
		if(! empty($_POST['cpname'])){
			$cpname = trim($_POST['cpname']);
			// 找到平台名称中有$cpname的平台，再查找这些平台的活动信息
			$cps = Company::model()->findAll("match(t.name) against ('$cpname' in boolean mode)");
			$p2pids = array(0);
			foreach($cps as $v){
				$p2pids[] = $v->attributes['cpid'];
			}
			$p2pids = implode(',' , $p2pids);
			$criteria->condition = "t.status = 2 and t.p2pid in ($p2pids)";
		}

		$criteria->condition .= " and company.isopen = 3";
		$count = count(Event::model()->with('company')->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 't.dateline desc';

		$events = Event::model()->with('company')->findAll($criteria);

		$this->pageTitle = 'P2P网贷活动_P2P网贷薅羊毛_网贷薅羊毛_理财派活动';

		$this->render('p2pEvents',array_merge($data,array(
				'events'=>$events,
				'pages'=>$pager,
				'tab' => $tab,
				'type' => $type,
				'cpname' => isset($_POST['cpname']) ? $_POST['cpname'] : '',
				)));

	}

	// p2p优惠活动详情页
	public function actionP2pEventDetail(){
		//$this->layout="simple";
		$eventid = Yii::app()->request->getParam('eventid');
		$auth = Yii::app()->request->getParam('auth');
		HInvite::inviteInit($auth);
		$uid = 0; // 未登录
		if(Yii::app()->user->id){
			$uid = Yii::app()->user->id;
		}
		// 活动信息
		$event = Event::model()->findByPk($eventid);

		if($uid != $event->uid && $event->status != 2){ // 活动发布者可以预览活动
			$this->redirectMessage('活动尚未发布!' , $this->createUrl('event/p2pEvents'));
		}

		// 访问次数+1
		$cookies = Yii::app()->request->getCookies();
		if (! isset($cookies['p2pEventDetail' . $eventid])) {
			Event::model()->updateCounters(array('viewnum' => 1) , "eventid = $eventid");  // 这种方法防止触发了model的aftersave事件
			$event->viewnum += 1;
			
			$cookie = new CHttpCookie('p2pEventDetail' . $eventid, 1);
			$cookie->expire = time()+60*5;  //5分钟增加浏览次数1次
			Yii::app()->request->cookies['p2pEventDetail' . $eventid] = $cookie;
		}

		// 抽奖信息
		$lottery = Lottery::model()->findByAttributes(array('eventid' => $eventid));

		//邀请参加活动  此邀请码可以注册并跳转到活动页 （普通投资人发放）
		// auth 为 array(HInvite::REG_5 , 活动id);
		$auth = HInvite::encodeInvite(array(HInvite::REG_5 , $eventid , Yii::app()->user->id));
		$inviteUrl = HComm::sinaurl(Yii::app()->request->hostInfo . $this->createUrl('/event/p2pEventDetail',array('eventid'=>$eventid , 'auth' => $auth)));

		// 奖励发放记录
		$eventAwardLog = EventAwardLog::model()->findAll(array(
					'condition' => 'eventid = ' . $eventid,
					'order' => 'dateline desc',
					'limit' => 6,
						));

		//最近点赞的人
		$eventLike = EventLike::model()->findAll(array(
					'condition' => 'eventid = '. $eventid,
					'order' => 'dateline desc',
					'limit' => 8,
						));


		//活动奖品
		$lotterySet = LotterySet::model()->with('event_award')->findAll(array(
					'condition' => "lotid = " . $lottery->lotid,
					'order' => 'id asc',
						));
		//联系活动主办方000
		$companyServices = CompanyService::model()->findAll(array(
					'condition' => "cpid = :cpid",
					'params' => array(':cpid' => Event::model()->findByPk($eventid)->p2pid),
						));

		//中奖人名单
		$lotteryAwardList = LotteryAwardList::model()->findAll(array(
					'condition' => 'lotid = ' . $lottery->lotid,
					'order' => 'dateline desc',
					'limit' => 8,
						));

		$company = Company::model()->findByPk($event->p2pid);

		// 当前登录人与该平台的关系
		$myInfo = EventLike::model()->findByAttributes(array('uid' => $uid , 'eventid' => $eventid));
		$render = $event->lotterytype ==0 ? 'noLotteryEvent' : 'p2pEventDetail';

		$this->pageTitle = '【' . $company->name . '】' . $event->title . '_平台活动_网贷薅羊毛_理财派';

		$this->render($render,array(
				'event' => $event,
				'inviteUrl' => $inviteUrl,
				'eventAwardLog' => $eventAwardLog,
				'eventLike' => $eventLike,
				'lotterySet' => $lotterySet,
				'lottery' => $lottery,
				'myInfo' => $myInfo,
				'companyServices' => $companyServices,
				'lotteryAwardList' => $lotteryAwardList,
				'company' => $company,
			));
	}

	// p2p活动点赞
	public function actionLikeEvent(){
		$eventid = Yii::app()->request->getParam('eventid');
		$uid = Yii::app()->user->id;

		$event = Event::model()->findByPk($eventid);
 
		if(! $uid){
			$this->ajaxErrReturn('needLogin');
		}

		if($event->status != 2){ // 活动发布者可以预览活动
			$this->ajaxErrReturn('活动尚未发布!');
		}

		if(EventLike::model()->exists("uid = $uid and eventid = $eventid")){
			$this->ajaxErrReturn('您已经赞过了!');
		}

		$lottery = Lottery::model()->findByAttributes(array('eventid' => $eventid)); // 一个event只能有一个lottery
		// 判断活动抽奖条件，即为点赞条件0,点赞即可(登陆即可点赞)，1.必须关注平台，2.必须关联账号
		$follow =  CompanyFollow::model()->find("uid = $uid and cpid = " . $event->p2pid);
		if($lottery->awardprecondition == 1 || $lottery->awardprecondition == 0){ // 现在强制关注平台
			if(! $follow){
				$this->ajaxErrReturn('请先关注该平台');
			}
		}
		else if($lottery->awardprecondition == 2){
			if(!$follow || !$follow->p2pname){
				$this->ajaxErrReturn('必须关联此平台帐号才可点赞');
			}
		}

		$eventLike = new EventLike();
		$eventLike->eventid = $eventid;
		$eventLike->p2pid = $event->p2pid;
		if($eventLike->save()){
			$cookie = Yii::app()->request->getCookies();
			if(isset($cookie['REG_5'])){
				$auth = HInvite::decodeInvite($cookie['REG_5']);
				$eventid = $auth[1];
				$fromUser = $auth[2];
				if(Yii::app()->user->id != $fromUser){
					// 邀请人邀请数加一,邀请人抽奖次数+1，删除cookie
					EventLike::model()->updateCounters(array('invitenum'=> 1), 'uid=' . $fromUser);
					// 判断活动类型，一人一次 还是 邀请一人即增加一次抽奖机会
					if($lottery->awardchance == 1){ // 邀请一次既增加一次
						EventLike::model()->updateCounters(array('canlotterynum'=> 1), 'uid=' . $fromUser);
					}
					HComm::updateCredit('invite_event' , $fromUser); //邀请人更新积分
				}
				unset($cookie['REG_5']);
			}
			HComm::updateCredit('like_event'); //更新积分，点赞活动

			$this->ajaxSucReturn('操作成功!');
		}
		$this->ajaxErrReturn('服务器正忙,请稍后重试!');
	}
}