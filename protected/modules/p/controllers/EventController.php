<?php
/**
 * p2p平台 后台 活动模块
 *
 */
class EventController  extends Controller
{
	public $layout = '//layouts/simple';
	private $_menu_select = null;
	private $cpid;
	
	public function actions()
	{
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
	
	public function filters()
	{
		return array(
			'accessControl',
			'accessCheck - awardDel,awardIssueDo,awardSpecialIssue,setVip',
			);
	}


	public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('*'),
				),
			);
	}

	public function filterAccessCheck($filterChain){
		$this->cpid = (int)Yii::app()->request->getParam('cpid');
		if (empty($this->cpid))
			$this->redirectMessage('参数错误', Yii::app()->request->urlReferrer);
		
		if(Yii::app()->user->isGuest)
				$this->redirect(array('/index/login'));
			
		if(! CompanyEmployee::model()->exists("status = 1 and cpid = " . $this->cpid . " and uid = " . Yii::app()->user->id)){
			$this->redirectMessage('非法操作', Yii::app()->request->urlReferrer);
		}
		$filterChain->run(); //加参数filterChain和这句话，才会再执行完filter后继续执行下面的action
	}


	/**
	* 将当前公司id 参数传递到视图中 
	*@param string $view 渲染的视图名
	*@param array $args 传递过去的参数 默认为空
	**/
	protected function renderWithId($view,$args=array()){
		$cpidArr = array('cpid'=>$this->cpid);
		$args = array_merge($cpidArr,$args);
		return $this->render($view,$args);
	}
	
	
	// 活动列表
	public function actionEventList(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("status != -1 and p2pid = ".$this->cpid);
		$rows=Yii::app()->params['postnum'];
		$count = count(Event::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';

		$events = Event::model()->findAll($criteria);

		$this->renderWithId('eventList',array(
				'events' => $events,
				'pages' => $pager,
				));
	}

	// 添加活动 
	public function actionAddEvent(){
		$event = new Event();
		$eventid = Yii::app()->request->getParam('eventid',null);
		$manage =  Yii::app()->request->getParam('manage' , 0);
		$type = Yii::app()->request->getParam('type' , 'notice');

		if($eventid){
			$event = $event->with('event_field')->findByPk($eventid);
		}

		if(isset($_POST) && !empty($_POST)){
			$event->p2pid = $this->cpid;
			$event->title = trim($_POST['title']);
			// $event->type = (int)$_POST['type'];
			$event->type = 1; //暂时没有活动类型
			$event->starttime = strtotime($_POST['starttime']);
			$event->endtime = strtotime($_POST['endtime']);
			$event->lotterytype = (int)$_POST['lotterytype'];
			if($event->save()){
				if($manage){
					$this->redirect($this->createUrl('/p/event/eventList',array('cpid'=>$this->cpid)));
				} else {
					$this->redirect($this->createUrl('/p/event/setAward',array('cpid'=>$this->cpid,'eventid'=>$event->eventid)));
				}
			}
		}
		if($type == 'notice'){ // 此为活动公告 , 默认为修改
			$manage = 1;
		}
		$this->renderWithId('addEvent',array(
					'event'=>$event,
					'manage' => $manage,
					'type' => $type,
				));
	}

	// 活动的发布操作
	public function actionEventRelease(){
		$eventid = Yii::app()->request->getParam('eventid');

		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}

		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException('非法操作!');
		}
		Event::model()->updateByPk($eventid,array('status'=>1));
		$this->redirect($this->createUrl('/p/event/eventList',array('cpid'=>$this->cpid)));
	}

	// 活动的删除操作
	public function actionEventDel(){
		$eventid = Yii::app()->request->getParam('eventid');

		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			$this->ajaxErrReturn('权限不够！');
		}

		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			$this->ajaxErrReturn('非法操作!');
		}
		Event::model()->updateByPk($eventid,array('status'=>-1));
		$this->ajaxSucReturn();
	}

	// 设置奖品
	public function actionSetAward(){
		$eventid = Yii::app()->request->getParam('eventid');

		//如果活动不存在，则跳转至发布活动页面
		if(! $eventid){
			$this->redirect($this->createUrl('/p/event/addEvent' , array('cpid' => $this->cpid)));
		}
		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}

		$award = new EventAward(); // 修改操作
		if($awardid = Yii::app()->request->getParam('awardid')){
			$award = $award->findByPk($awardid);
		}
		$awards = EventAward::model()->findAll("eventid = $eventid");

		$this->renderWithId('setAward',array(
				'awards' => $awards,
				'award' => $award,
				'event' => Event::model()->findByPk($eventid),
				'manage' => Yii::app()->request->getParam('manage' , 0),
				));
	}

	//  奖项增加/修改
	public function actionAwardEdit(){
		$id = Yii::app()->request->getParam('id');
		$eventid = Yii::app()->request->getParam('eventid');

		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}

		$award = new EventAward();
		if($id){
			$award = $award->findByPk($id);
		}

		if(isset($_POST)&&!empty($_POST)){
			$award->eventid = $eventid;
			$award->awardname = trim($_POST['awardname']);
			$award->awardtype = (int)$_POST['awardtype'];
			$award->awardvalue = (int)$_POST['awardvalue'];
			$award->awardpic = trim($_POST['awardpic']);
			$award->num = (int)$_POST['num'];
			if($award->save()){
				$this->redirect($this->createUrl('/p/event/setAward',array('cpid'=>$this->cpid,'eventid'=>$eventid,'manage' => Yii::app()->request->getParam('manage' , 0))));
			}
		}
		
		$this->render('awardEdit',array(
				'cpid'=>$this->cpid ,
				'event' => Event::model()->findByPk($eventid),
				'awardid'=>$id,
				'award' => $award,
				'manage' => Yii::app()->request->getParam('manage' , 0),
				));	

	}

	// 删除奖品
	public function actionAwardDel(){
		$awardid = Yii::app()->request->getParam('awardid');
		$eventid = Yii::app()->request->getParam('eventid');

		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}

		if(Event::model()->findByPk($eventid)->status == 2){
			$this->ajaxErrReturn("该活动已通过审核，不可删除奖品!");
		}
		$model = new EventAward();
		if(empty($awardid)){
			$this->ajaxErrReturn('非法操作!');
		}

		$award = EventAward::model()->findByPk($awardid);

		if(LotterySet::model()->exists("awardid = $awardid")){
			$this->ajaxErrReturn('删除奖品前需删除使用该奖品的奖项');
		}

		if(Event::model()->findByPk($eventid)->uid != Yii::app()->user->id){
			$this->ajaxErrReturn('只能删除自己活动的奖品!');
		}

		if($award->delete()){
			$this->ajaxSucReturn('删除成功!');
		}
	}

	// 奖项设置 
	public function actionLotteryAward(){
		$eventid = Yii::app()->request->getParam('eventid');
		//如果活动不存在，则跳转至发布活动页面
		if(! $eventid){
			$this->redirect($this->createUrl('/p/event/addEvent' , array('cpid' => $this->cpid)));
		}

		$awards = EventAward::model()->findAll("eventid = " . $eventid);
		// 如果奖品数量小于3，则继续设置奖品
		if(EventAward::model()->countByAttributes(array('eventid' => $eventid)) < 3){
			$this->redirectMessage('奖品数量必须大于3' , $this->createUrl('/p/event/setAward' , array('cpid' => $this->cpid , 'eventid' => $eventid)));
		}

		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}

		$lotteryAwards = null;
		// 当前有多少奖项,默认为3
		$lev = 3; 
		if($lottery = Lottery::model()->findByAttributes(array('eventid'=>$eventid))){
			// 如果奖项不足5个，用空数据补满5个
			$lotteryAwards = LotterySet::model()->findAllByAttributes(array('lotid'=>$lottery->lotid));
			$lev = count($lotteryAwards)>3?count($lotteryAwards):3;
			for($i=count($lotteryAwards);$i<5;$i++){
				$lotteryAwards[$i] = new LotterySet();
			}
		}

		$render = 'lotteryAward';

		if(Event::model()->findByPk($eventid)->status == 2){
			$render = "publishedLotteryAwardEdit";
		}
		$this->renderWithId($render,array(
				'awards'=>$awards,
				'event' => Event::model()->findByPk($eventid),
				'lottery' => $lottery,
				'lotteryAwards' => $lotteryAwards,
				'chinanum' => array('一','二','三','四','五','六','七'),
				'lev' => $lev,
				'manage' => Yii::app()->request->getParam('manage' , false),
				));
	}

	//奖项新增/修改
	public function actionLotteryAwardEdit(){
		$eventid = Yii::app()->request->getParam('eventid');

		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}

		if(Event::model()->findByPk($eventid)->status == 2){
			$this->redirectMessage('该活动已经通过审核,不可编辑', Yii::app()->request->urlReferrer);
		}

		$lottery = Lottery::model()->findByAttributes(array('eventid' => $eventid)); //一个events一个lottery
		if(isset($_POST) && !empty($_POST)){
			// lev获取修改后有几条奖项
			$lev = Yii::app()->request->getParam('lev'); 
			//获取传过来的奖项，查询数据库，新增的执行新增/删除操作，否则修改
			$lotteryAttrs = Yii::app()->request->getParam('lottery');
			//去除没有概率或数量的无效奖项
			foreach($lotteryAttrs as $k=>$v){
				// 如果概率为空，代表没有这奖项，否则如果数量大于奖品的库存数量，则给出错误提示
				if($v['probability'] <=0){
					unset($lotteryAttrs[$k]);
				} else if($v['awardnum'] > EventAward::model()->findByPk($v['awardid'])->num){
					$this->redirectMessage('奖项概率必须大于0，数量必须小于等于该奖品数量' , Yii::app()->request->urlReferrer);
				}
			}
			// 数据库中存在的奖项数量

			$existsLotteryNum = LotterySet::model()->count("lotid = " . $lottery->lotid);
			if($lev >= $existsLotteryNum){
				// 单条修改
				for($i=0; $i<$existsLotteryNum; $i++){
					$lotterySet = LotterySet::model()->findByPk($lotteryAttrs[$i]['id']);
					$lotterySet->awardid = $lotteryAttrs[$i]['awardid'];
					$lotterySet->probability = round($lotteryAttrs[$i]['probability'] , 2);
					$lotterySet->awardnum = $lotteryAttrs[$i]['awardnum'];
					$lotterySet->vip = $lotteryAttrs[$i]['vip'];
					$lotterySet->save();
				}
				// 插入
				for($j=$existsLotteryNum;$j<$lev;$j++){
					$lotterySet = new LotterySet();
					$lotterySet->awardid = $lotteryAttrs[$j]['awardid'];
					$lotterySet->lotid = $lottery->lotid;
					$lotterySet->probability = round($lotteryAttrs[$j]['probability'] , 2); // 对概率精度保留位小数
					$lotterySet->awardnum = $lotteryAttrs[$j]['awardnum'];
					$lotterySet->vip = $lotteryAttrs[$j]['vip'];
					$lotterySet->save();
				}
			// 删除多余的
			} else { 
				for($i=$existsLotteryNum-1;$i>=$lev;$i--){
					LotterySet::model()->deleteByPk($lotteryAttrs[$i]['id']);
				}
			}

			//修改抽奖信息
			$lottery->vip = $_POST['vip'];
			$lottery->starttime = strtotime($_POST['starttime']);
			$lottery->endtime = strtotime($_POST['endtime']);
			// $lottery->awardchance = $_POST['awardchance'];
			$lottery->awardchance = 1; // 暂时只能邀请一人获得一次机会
			$lottery->autogiving = (int)$_POST['autogiving'];
			$lottery->awardprecondition = $_POST['awardprecondition'];
			
			$event = Event::model()->findByPk($eventid);
			$lottery->type = $event->type;
			$lottery->awardnum = count($lotteryAttrs);
			$lottery->eventid = $event->eventid;

			if($lottery->save()){
				// 跳转到活动列表
				$this->redirect($this->createUrl('/p/event/eventList',array('cpid'=>$this->cpid)));
			}
		}
	}

	//已发布活动的奖项修改
	public function actionPublishedLotteryAwardEdit(){
		$eventid = Yii::app()->request->getParam('eventid');

		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}

		$lottery = Lottery::model()->findByAttributes(array('eventid' => $eventid)); //一个events一个lottery
		if(isset($_POST) && !empty($_POST)){
			
			//获取传过来的奖项，查询数据库，新增的执行新增/删除操作，否则修改
			$lotteryAttrs = Yii::app()->request->getParam('lottery');
			//检测概率设置是否正确
			foreach($lotteryAttrs as $k=>$v){
				// 如果这两项其中一项为空，则表示没有当前奖项
				if($v['probability'] <=0 || $v['awardnum'] > EventAward::model()->findByPk($v['awardid'])->num){
					$this->redirectMessage('奖项概率必须大于0，数量必须小于等于该奖品数量' , Yii::app()->request->urlReferrer);
				}
			}

			// 数据库中存在的奖项数量
			for($i=0; $i<count($lotteryAttrs); $i++){
				$lotterySet = LotterySet::model()->findByPk($lotteryAttrs[$i]['id']);
				$lotterySet->probability = round($lotteryAttrs[$i]['probability'] , 2);
				$lotterySet->awardnum = $lotteryAttrs[$i]['awardnum'];
				$lotterySet->vip = $lotteryAttrs[$i]['vip'];
				$lotterySet->save();
			}
		
			//修改抽奖信息
			$lottery->starttime = strtotime($_POST['starttime']);
			$lottery->endtime = strtotime($_POST['endtime']);
			$lottery->autogiving = (int)$_POST['autogiving']; 
			$lottery->vip = $_POST['vip'];

			if($lottery->save()){
				// 跳转到活动列表
				$this->redirect($this->createUrl('/p/event/eventList',array('cpid'=>$this->cpid)));
			}
		}
	}

	// 奖品发放列表
	public function actionAwardIssue(){
		$eventid = Yii::app()->request->getParam('eventid');
		$tab = Yii::app()->request->getParam('tab' , 'all');
		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}
		if(! empty($_POST)){
			$aids = Yii::app()->request->getParam('aids' , array(0));
			$aids = implode(',' , $aids);
			LotteryAwardList::model()->updateAll(array('issend' => 1) , "id in ($aids)");
		}

		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		if($tab == 'sent'){
			$criteria->condition = "issend = 1 and eventid = " . $eventid;
		} else if($tab == 'unsent'){
			$criteria->condition = "issend = 0 and eventid = " . $eventid;
		} else {
			$criteria->condition = "eventid = " . $eventid;
		}
		$count = count(LotteryAwardList::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';

		$awards = LotteryAwardList::model()->findAll($criteria);

		$this->renderWithId('awardIssue',array(
				'awards'=>$awards,
				'event' => Event::model()->findByPk($eventid),
				'pages'=>$pager,
				'tab' => $tab,
				'manage' => 1,
				));
	}

	// 发奖列表导出excel
	public function actionAwardIssueExcel(){
		$eventid = Yii::app()->request->getParam('eventid');
		$tab = Yii::app()->request->getParam('tab' , 'all');
		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}
		$criteria = new CDbCriteria();
		if($tab == 'sent'){
			$criteria->condition = "issend = 1 and eventid = " . $eventid;
		} else if($tab == 'unsent'){
			$criteria->condition = "issend = 0 and eventid = " . $eventid;
		} else {
			$criteria->condition = "eventid = " . $eventid;
		}
		$criteria->order = 'dateline asc';

		$awards = LotteryAwardList::model()->findAll($criteria);
		
		$title = array('编号' , '名称' , '平台关联帐号' , '中奖奖品' , '中奖时间' , '操作');
		$data = array();
		foreach($awards as $v){
			$follow = CompanyFollow::model()->find("uid = $v->uid and cpid = " .$this->cpid);
			$row = array();
			$row[] = $v->id;
			$row[] = $v->username;
			$row[] = isset($follow->p2pname)?$follow->p2pname : '';
			$row[] = $v->awardname;
			$row[] = date('Y-m-d H:i:s' , $v->dateline);
			$row[] = $v->issend ? '已发放' : '未发放';

			$data[] = $row;
		}
		$fileName = '奖品发放记录';
		$newExcel = HComm::exportExcel( $fileName, $title, $data );
		exit;
	}

	// 奖品发放操作
	public function actionAwardIssueDo(){
		$id = Yii::app()->request->getParam('id');

		$lotteryAwardList = LotteryAwardList::model()->findByPk($id);
		$event = Event::model()->findByPk($lotteryAwardList->eventid);

		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != $event->uid){
			throw new CHttpException(500,'服务器内部错误');
		}
		$lotteryAwardList->issend = 1;

		if($lotteryAwardList->save()){
			// 插入event_award_log表
			$eventAwardLog = new EventAwardLog();
			$eventAwardLog->eventid = $event->eventid;
			$eventAwardLog->title = $event->title;
			$eventAwardLog->uid = $lotteryAwardList->uid;
			$eventAwardLog->username = $lotteryAwardList->username;
			$eventAwardLog->awardid = $lotteryAwardList->awardid;
			$eventAwardLog->type = 2;
			$eventAwardLog->save();

			$this->ajaxSucReturn('发放成功!');
		}
		$this->ajaxErrReturn('服务器正忙，请稍后重试!');
	}

	// 活动成员管理  这个是特别奖品发放
	public function actionSpecialAwardIssue(){
		$eventid = Yii::app()->request->getParam('eventid');

		$starttime = strtotime(Yii::app()->request->getParam('starttime' , 0));// 开始点赞时间默认一周前
		$endtime = strtotime(Yii::app()->request->getParam('endtime' , date('Y-m-d H:i:s'))); // 结束点赞时间  默认当前
		$startInvite = Yii::app()->request->getParam('startInvite' , 0); // 最少邀请人数
		$endInvite = Yii::app()->request->getParam('endInvite' , ''); // 最多邀请人数
		$isSend = Yii::app()->request->getParam('isSend' , 0); // 是否已经发放
		$isVip = Yii::app()->request->getParam('isVip' , 0); // 是否是vip
		$username = Yii::app()->request->getParam('username' , ''); // 用户名
		$order = Yii::app()->request->getParam('order' , 'invitenum'); // 排序
		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}
		// 活动奖品信息
		$awards = EventAward::model()->findAllByAttributes(array('eventid' => $eventid));

		$condition = "t.eventid = $eventid";

		if(!!($starttime)){
			$condition .= " and t.dateline > $starttime";
		}
		if(!!($endtime)){
			$condition .= " and t.dateline < $endtime";
		}
		if(!!($startInvite)){
			$condition .= " and t.invitenum >= $startInvite";
		}
		if(is_numeric($endInvite)){
			$condition .= " and t.invitenum <= $endInvite";
		}
		if(!!($isSend)){
			// 查出发过奖的用户id ，再用in 或not in 来过滤
			$users = EventAwardLog::model()->findAllByAttributes(array('eventid' => $eventid , 'type' => 1));
			$rows=array(0);
			foreach($users as $user) {
			    $rows[] = $user->uid;
			}
			$uids = implode(',' , array_unique($rows));
			// 已发放奖励的
			if($isSend == 1){
				$condition .= " and t.uid in ($uids)";
			} else if($isSend ==2) {
				$condition .= " and t.uid not in ($uids)";
			}
		}
		if(!!($isVip)){ // 增加 '不限' , 所以要-1
			$condition .= " and t.vip = " . ($isVip-1);
		}
		if(!!($username)){
			$condition .= " and match(company_follow.p2pname) against ('$username' in boolean mode)";
		}
		$companyFollow = null;
		$pre = 't.'; // 排序前缀
		if($order == 'join_event_num'){ // 关注表的字段
			$pre = 'company_follow.';
		}
		// 点赞成员信息 没有按照join_event_num时不联查companyFollow表
		$eventLikes = EventLike::model()->with('special_awards')->with('company_follow')->findAll(array(
					'condition' => $condition,
					'order' => $pre . $order . ' desc', 
						));

		$this->renderWithId('specialAwardIssue' , array(
					'awards' => $awards,
					'event' => Event::model()->findByPk($eventid),
					'eventLikes' => $eventLikes,
					'order' => $order,
					'starttime' => $starttime,
					'endtime' => $endtime,
					'startInvite' =>$startInvite,
					'endInvite' => $endInvite,
					'isSend' => $isSend,
					'isVip' => $isVip,
					'username' =>$username,
					'manage' => 1,
					));
	}

	// 活动成员管理
	public function actionEventMemberSet(){
		$eventid = Yii::app()->request->getParam('eventid');
		$username = Yii::app()->request->getParam('username' , ''); // 用户名
		$tab = Yii::app()->request->getParam('tab' , '');
		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}
		// 活动奖品信息
		$awards = EventAward::model()->findAllByAttributes(array('eventid' => $eventid));

		$condition = "t.eventid = $eventid";

		if(!!($username)){
			$condition .= " and match(company_follow.p2pname) against ('$username' in boolean mode)";
		}
		if($tab == 'vip'){
			$condition .= " and t.vip = 1";
		}
		// 点赞成员信息 没有按照join_event_num时不联查companyFollow表
		$eventLikes = EventLike::model()->with('company_follow')->findAll(array(
					'condition' => $condition,
					'order' => 't.dateline desc', 
						));

		$this->renderWithId('eventMemberSet' , array(
					'awards' => $awards,
					'eventLikes' => $eventLikes,
					'event' => Event::model()->findByPk($eventid),
					'tab' => $tab,
					'username' =>$username,
					'manage' => 1,
					));
	}

	// 特别奖品发放
	public function actionAwardSpecialIssue(){
		$eventid = Yii::app()->request->getParam('eventid');
		$uid = Yii::app()->request->getParam('uid');
		$awardid = Yii::app()->request->getParam('awardid');

		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}

		if(EventAward::model()->findByPk($awardid)->num <= 0 ){
			$this->ajaxErrReturn('奖品数量不足');
		}
		// 插入event_award_log表
		$eventAwardLog = new EventAwardLog();
		$eventAwardLog->eventid = $eventid;
		$eventAwardLog->title = Event::model()->findByPk($eventid)->title;
		$eventAwardLog->uid = $uid;
		$eventAwardLog->username = Member::model()->findByPk($uid)->username;
		$eventAwardLog->awardid = $awardid;
		$eventAwardLog->type = 1;
		if($eventAwardLog->save()){
			// 奖品数量-1
			EventAward::model()->updateCounters(array('num'=> -1), 'awardid=' . $awardid);

			// 用户获奖增加获奖记录
			$eventLike = EventLike::model()->findByAttributes(array('uid'=>$uid,'eventid'=>$eventid));
			$log = unserialize($eventLike->log);
			$log[] = $eventAwardLog->awardname;
			$eventLike->log = serialize($log);
			$eventLike->save();

			$this->ajaxSucReturn('操作成功' , $eventAwardLog->awardname);
		}

		$this->ajaxErrReturn('服务器正忙，请稍后重试');
	}

	// 设置vip
	public function actionSetVip(){
		$id = Yii::app()->request->getParam('id');
		$vip = Yii::app()->request->getParam('vip');

		$eventid = EventLike::model()->findByPk($id)->eventid;
		// 如果当前操作人不是该活动的发布者，则无权进行此操作
		if(Yii::app()->user->id != Event::model()->findByPk($eventid)->uid){
			throw new CHttpException(500,'服务器内部错误');
		}

		if(EventLike::model()->updateByPk($id,array('vip' => $vip))){
			$data = "<a onclick='setVip($id , 0);'>Vip 取消</a>";
			if($vip == 0){
				$data = "<a onclick='setVip($id , 1);'>设成vip</a>";	
			}
			$this->ajaxSucReturn('操作成功' , $data);
		}
		$this->ajaxErrReturn('服务器正忙，请稍后重试');
	}
}