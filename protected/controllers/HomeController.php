<?php
/**
 * 个人中心
 *
 */
class HomeController extends Controller {
	public $layout = 'simple';
	
	public $_user = null;			//用户
	public $_self = false;			//是否是自己
	public $_uid;  // 被访问的uid

	public function filters(){
		return array(
			'accessControl',
			'init - list,apply,newsDetail',
			);
	}
	
	public function accessRules(){
		return array(
		  	  array('deny', // 仅登录用户有权限操作：create,update  
			            'actions'=>array('inviteFriends','myProfile'),  
			            'users'=>array('?'),  
			        ),  
		);
	}

	//初始化
	public function filterInit($filterChain){		
		$this->_uid = (int)Yii::app()->request->getParam('uid') ? (int)Yii::app()->request->getParam('uid') : Yii::app()->user->id;
		$this->_uid || $this->redirect($this->createUrl('/index/login') );
		
		$this->_loadMode();
		$this->_self = Yii::app()->user->id && (Yii::app()->user->id == $this->_user->uid);

		$filterChain->run(); 
	}
	
	// 关注的平台
	public function actionIndex(){	
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$criteria->condition = "t.uid = " . $this->_uid;
		$count = count(CompanyFollow::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$companies = CompanyFollow::model()->with('company')->findAll($criteria);

		$this->render('index',array(
				'companies'=>$companies,
				'pages'=>$pager,
				));	
	}


	// 点赞的活动
	public function actionMyActivity(){
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$criteria->condition = "t.uid = " . $this->_uid;
		$count = count(EventLike::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$events = EventLike::model()->with('event')->with('company')->findAll($criteria);

		$this->render('myActivity',array(
				'events'=>$events,
				'pages'=>$pager,
				));
	}
	
	// 获得的奖励 
	public function actionMyReward(){
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];

		// 用户参加的已中奖的活动id
		// $eids = LotteryAwardList::model()->findAllByAttributes(array('uid' => $this->_uid));
		// $eidsArr = array();
		// foreach($eids as $e){
		// 	$eidsArr[] = $e->eventid;
		// }
		// $eids = implode(',' , array_unique($eidsArr));	
		// $criteria->condition = "eventid in ($eids)";
		$criteria->condition = "t.uid = " . $this->_uid;
		$count = count(EventAwardLog::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria);

		$awards = EventAwardLog::model()->with('event')->with('company')->findAll($criteria);

		$this->render('myReward',array(
				'awards'=>$awards,
				'pages'=>$pager,
				));
	}

	// 发的帖子
	public function actionMyPosts(){
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$criteria->condition = "t.uid = " . $this->_uid;
		$count = count(GroupTopic::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$topics = GroupTopic::model()->findAll($criteria);

		$this->render('myPosts',array(
				'topics'=>$topics,
				'pages'=>$pager,
				));
	}

	// 关注 
	public function actionFollows(){
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$criteria->condition = "t.uid = " . $this->_uid;
		$count = count(Follow::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$follows = Follow::model()->with('fmember_info')->with('fmember_count')->findAll($criteria);

		$this->render('follows',array(
				'follows'=>$follows,
				'pages'=>$pager,
				));
	}

	// 粉丝
	public function actionFollowers(){
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$criteria->condition = "t.fuid = " . $this->_uid;
		$count = count(Follow::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$followers = Follow::model()->with('member_info')->with('member_count')->findAll($criteria);

		$this->render('followers',array(
				'followers'=>$followers,
				'pages'=>$pager,
				));
	}

	//邀请好友
	public function actionInviteFriends(){
		// 防止登录后可以访问别人的 '个人资料','邀请好友'
		if(Yii::app()->user->id != $this->_uid){
			$this->redirect($this->createUrl('/home/inviteFriends'));
		}
		//.邀请注册 此邀请码可以邀请注册并在自己邀请人里面显示 （普通投资人发放）
		// auth 为 array(HInvite::REG_4 , 发出邀请的用户id)；
		$auth = array(HInvite::REG_4 , Yii::app()->user->id);
		$auth = HInvite::encodeInvite($auth);
		$url = Yii::app()->request->hostInfo . $this->createUrl('/index/reg' , array('auth' => $auth));

		// 被我邀请的好友 
		$invited = Invite::model()->findAllByAttributes(array('uid' => $this->_uid));
		$this->render('inviteFriends' , array(
					'invited' => $invited,
					'url' => $url,
					));

	}

	public function actionAvatar(){
		$au = new HAvatar();
		//var_dump($au);exit('aaaa');
		if ( $re = $au->processRequest() ) {
			//Member::model()->updateCounters(array('avatarstatus'=>1), 'uid='.$uid);
			//$this->redirect($this->createUrl('test/avatar'));
			exit();
		}

		$urlCameraFlash = $au->renderHtml( Yii::app()->user->id );

		//客户端传来的图片刷新请求
		if ( isset($_REQUEST['autoFreshImg']) && $_REQUEST['autoFreshImg'] ){

			$p = new HComm();
			if ( $imgPath = $p->avatar(Yii::app()->user->id, 'm') ){
				echo $imgPath;
				exit;
			}
		}

		$this->render('myProfile', array(
				'urlCameraFlash'=>$urlCameraFlash,
				'tab' => 'modify_avatar',
				));
	}

	// 修改个人信息
	public function actionMyProfile(){
		// 防止登录后可以访问别人的 '个人资料','邀请好友'
		if(Yii::app()->user->id != $this->_uid){
			$this->redirect($this->createUrl('/home/myProfile'));
		}
		$tab = Yii::app()->request->getParam('tab' , 'base_info');

		$data = array('tab' => $tab); //传递过去的数据
		switch($tab){
			case 'base_info' : 
				if(!empty($_POST)){
					$memberInfo = MemberInfo::model()->findByPk($this->_uid);
					$memberInfo->gender = (int)Yii::app()->request->getParam('gender');
					$memberInfo->provinceid = (int)Yii::app()->request->getParam('provinceid');
					$memberInfo->resideprovince = AreaProvince::model()->findByAttributes(array('provinceid' => $memberInfo->provinceid))->pname;
					$memberInfo->residecityid = (int)Yii::app()->request->getParam('residecityid');
					$memberInfo->residecity = AreaCity::model()->findByAttributes(array('cityid' => $memberInfo->residecityid))->city;
					if($memberInfo->save()){
						$this->ajaxSucReturn('修改成功!');
					}
					$this->ajaxErrReturn('服务器正忙，请稍后重试!');
				}
				$member = Member::model()->with('info')->findByPk($this->_uid);
				$data['member'] = $member;
				break;
			case 'modify_pwd' :
				if(!empty($_POST)){
					$oldPwd = trim(Yii::app()->request->getParam('oldPwd'));
					$newPwd = trim(Yii::app()->request->getParam('newPwd'));
					$checkPwd = trim(Yii::app()->request->getParam('checkPwd'));
					$user = Member::model()->findByPk($this->_uid);
					if(! $user->validataPassword($oldPwd)){
						$this->ajaxErrReturn('oldPwd');
					}
					if(strlen($newPwd)<5 || strlen($newPwd)>16){
						$this->ajaxErrReturn('newPwd');
					}
					if($checkPwd != $newPwd){
						$this->ajaxErrReturn('checkPwd');
					}
					$password = $user->hash($newPwd , $user->salt);
					Member::model()->updateAll(array('password' => $password) , "uid = " . Yii::app()->user->id);
					$this->ajaxSucReturn('修改成功!');
				}
				break;
		}

		$this->render('myProfile' , $data);
		
	}

	// 实名认证
	public function actionRealnameAuth(){
		if(!empty($_POST)){
			// 插入用户信息表
			// 修改用户认证状态
			// 增加申请表记录
			$realname = trim(Yii::app()->request->getParam('realname'));
			$job = trim(Yii::app()->request->getParam('job'));
			$remark = trim(Yii::app()->request->getParam('remark'));
			MemberInfo::model()->updateByPk(Yii::app()->user->id  , array('realname' => $realname , 'job' => $job));
			Member::model()->updateByPk(Yii::app()->user->id , array('realstatus' => 1));

			$authApply = new AuthApply();
			$authApply->uid = Yii::app()->user->id;
			$authApply->type = 1;
			$authApply->remark = $remark;
			$authApply->save();

			$this->redirectMessage('已提交申请，请等待审核' , $this->createUrl('/home/index') , 'success' , '3');
		}
		$this->render('realnameAuth');
	}

	// 邮箱验证
	public function actionEmailAuth(){
		if(!empty($_POST)){
			$email = trim(Yii::app()->request->getParam('email'));
			
			// 往邮箱发送带有验证url的邮件
			$sendTo = $email;
			//邮件标题
			$subject = '来至理财派的邮箱验证';
			//邮件内容
			$checkEmailAuth = HComm::encodeAuth(array(Yii::app()->user->id , $sendTo)); // 加密是由用户id，邮箱组成的
			$checkEmailUrl = Yii::app()->request->hostInfo . $this->createUrl('/home/emailAuth',array('auth' => $checkEmailAuth , 'uid'=>Yii::app()->user->id));
			$body = "请点击下面的链接来完成您在理财派上的邮箱验证：<br/>" . $checkEmailUrl . "<br/><br/>请加入我们的官方投资交流群:230341007";
			$result = HComm::sendMail( $sendTo, $subject, $body );
			$this->redirectMessage('我们已向您的邮箱发送验证邮件，请尽快验证' , $this->createUrl('/home/index') , 'success' , '3');
		} else {
			$auth = Yii::app()->request->getParam('auth' , 0);
			if($auth) {
				$auth = HComm::decodeAuth($auth);
				$uid = $auth[0];
				$email = $auth[1];
				Member::model()->updateByPk($uid , array('email' => $email , 'emailstatus' => 1)); // 修改邮箱和邮箱验证状态
				$this->redirectMessage('验证成功...' , Yii::app()->createUrl('/index/index') , 'success' , '2');
			}
		}
		$this->render('emailAuth');
	}

	//加载主页个人信息
	private function _loadMode(){
		if($this->_user===null)
		{
			if($this->_uid)
			{
				$this->_user = Member::model()->with('count')->find(array(
					'condition'=>'t.uid=:uid',
					'params'=>array(':uid'=>$this->_uid),
					));
			}
			$this->_user || $this->redirectMessage('参数错误，主页不存在', Yii::app()->request->urlReferrer );
		}
		
		return $this->_user;	
	}

	// 私信
	/**
		站内信模块
	**/
	// 系统消息列表
	public function actionMsgList(){
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$criteria->condition = "uid = " . $this->_uid;
		$count = count(Message::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$msgs = Message::model()->findAll($criteria);

		$this->render('msgList',array(
				'msgs'=>$msgs,
				'pages'=>$pager,
				));	
	}

	// 系统消息详细 
	public function actionMsgDetail(){
		$mid = Yii::app()->request->getParam('mid');
		if( !$mid || !is_numeric($mid)){
			$this->redirectMessage('参数错误' , Yii::app()->request->urlReferrer);
		}

		$msg = Message::model()->findByPk($mid);
		
		// 消息设置成已读
		$msg->isview = 1;
		$msg->save();

		$this->render('msgDetail',array('msg' => $msg));
	} 

	// 系统消息全部设成已读
	public function actionMsgAllRead(){
		Message::model()->updateAll(array('isview'=>1) , "uid = " . Yii::app()->user->id);
		MemberCount::model()->updateByPk(Yii::app()->user->id , array('message' => 0));
		$this->ajaxSucReturn('操作成功');
 	}

	// 私信列表
	public function actionTalkList(){
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$criteria->condition = "uid = $this->_uid OR fuid = $this->_uid";
		$criteria->order = "lastreply desc";
		$count = count(Talk::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$talks = Talk::model()->findAll($criteria);

		$this->render('talkList',array(
				'talks'=>$talks,
				'pages'=>$pager,
				));	
	}

	// 写私信
	public function actionWriteTalk(){
		$fuid = Yii::app()->request->getParam('fuid');
		if(!$fuid || !is_numeric($fuid)){
			$this->redirectMessage('参数错误!', Yii::app()->request->urlReferrer);
		}
		$fuser = Member::model()->findByPk($fuid);

		$talk = new Talk();
		$uid = Yii::app()->user->id;
		$condition = "(uid = $uid and fuid = $fuid) OR (uid = $fuid and fuid = $uid)";
		
		$render = 'newTalk'; // 新私信会话 
		$data['fuser'] = $fuser;
		// 已存在会话
		if($talk->exists($condition)){
			$talk = Talk::model()->find($condition);
			$talkid = $talk->talkid;

			$talks = TalkReply::model()->findAll(array(
					'condition' => "talkid = $talkid",
					'limit' => Yii::app()->params['talk_pagesize'],  
					'order' => 'dateline desc',
					));
			// 查出来是时间倒序的，翻转
			$talks = arToArray($talks);
			$talks = array_reverse($talks);
			
			//未读消息清空
			$updateNum = Yii::app()->user->id == $talk->uid ? 'num' : 'fnum'; // 要清空的字段
			// 未读的消息数
			$talknum = $talk->$updateNum;
			Talk::model()->updateByPk($talkid , array($updateNum => 0));
			// member_count表私信数更新
			MemberCount::model()->findByPk(Yii::app()->user->id)->saveCounters(array('talknum' => -$talknum));
			$render = 'talking';
			$data['talks'] = $talks;
			$data['talkid'] =  $talkid;
		} 

		$this->render($render , $data);
	}

	// 发送消息	
	public function actionSendTalk(){
		$fuid = Yii::app()->request->getParam('fuid');
		if(!$fuid || !is_numeric($fuid)){
			$this->redirectMessage('参数错误!', Yii::app()->request->urlReferrer);
		}
		$talk = new Talk();
		$uid = Yii::app()->user->id;
		$condition = "(uid = $uid and fuid = $fuid) OR (uid = $fuid and fuid = $uid)";

		// 插入操作
		if(! empty($_POST)){
			$content = htmlspecialchars(trim($_POST['content']));
			$flag = true; // 记录当前发消息操作是新开的聊天窗口还是已存在的，新开的则刷新页面，已存在的返回json
			// 判断2者是否发起过会话
			if($talk->exists($condition)){
				$talk = $talk->find($condition);
			} else {
				$talk->uid = Yii::app()->user->id;
				$talk->fuid = $fuid;
				$flag = false;
			}
			$talk->content = $content;

			if($talk->save()){
				if(! $flag) {
					$this->redirect($this->createUrl('/home/writeTalk' , array('fuid' => $fuid)));
				}
				$url = $this->createUrl('/home/index' , array('uid'=>$uid));
				$username = Yii::app()->user->name;
				$avasrc = HComm::avatar($uid, 'm');
				$dateline = date('Y-m-d H:i:s' , $talk->dateline);
				$html = <<<EOF
				<li class="review review_right ";">
					<div class="groupL">
						<a href="{$url}">
							<img src="{$avasrc}" />
						</a>
						<p><?php echo {$username}</p>
					</div>
					<div class="bialog_box">
						<p>{$content}</p>
						<div class="report">
							<p>
								<cite><a href="">举报</a></cite>
								<?php {$dateline}?>
							</p>
						</div>
					</div>
					<div class="jiantou">&nbsp;</div>
				</li>
EOF;
				$this->ajaxSucReturn('',$html);
			}
			$this->ajaxErrReturn('服务器正忙，请稍后重试!');

		}
	}

	// 私信内容分页数据
	public function actionTalkData(){
		$page = Yii::app()->request->getParam('page' , 1);
		$pagesize = Yii::app()->params['talk_pagesize'];
		$talkid = Yii::app()->request->getParam('talkid');

		if(!$talkid || !is_numeric($talkid)) {
			$this->ajaxErrReturn('参数错误');
		}
		$talk = Talk::model()->findByPk($talkid);
		// 防止查看他人私信
		if($talk->uid !=  Yii::app()->user->id && $talk->fuid != Yii::app()->user->id){
			$this->ajaxErrReturn('非法操作!');
		}

		$talks = TalkReply::model()->findAll(array(
					'condition' => "talkid = $talkid",
					'limit' => $pagesize,  
					'offset' => ($page-1) * $pagesize,   //两条合并起来，则表示 limit 10 offset 1,或者代表了。limit 1,10  
					'order' => 'dateline desc',
					));

		// 查出来是时间倒序的，翻转
		$talks = arToArray($talks);
		$talks = array_reverse($talks);

		$html = '';
		 foreach($talks as $v){
		 	$review_right = (Yii::app()->user->id == $v['uid']) ? ' review_right ' : '';
		 	$url = $this->createUrl('/home/index' , array('uid' => $v['uid']));
		 	$avatar = HComm::avatar($v['uid'], 'm');
		 	$date = date('Y-m-d H:i:s' , $v['dateline']);
		 	$left = (Yii::app()->user->id == $v['uid']) ? '' : ' style="left:70px;" ';
		 	$username = $v['username'];
		 	$content = $v['content'];

			$html .= <<<EOF
				<li class="review $review_right">
					<div class="groupL">
						<a href="$url">
							<img src="$avatar" />
						</a>
						<p>$username</p>
					</div>
					<div class="bialog_box">
						<p>$content</p>
						<div class="report">
							<p>
								<cite><a href="">举报</a></cite>
								$date
							</p>
						</div>
					</div>
					<div class="jiantou" $left>&nbsp;</div>
				</li>
EOF;
		}
		$this->ajaxSucReturn('',$html);
	}

	// 设为已读
	public function actionIgnoreTalk(){
		$talkid = Yii::app()->request->getParam('talkid');
		if( !$talkid || !is_numeric($talkid)){
			$this->redirectMessage('参数错误' , Yii::app()->request->urlReferrer);
		}
		$talk = Talk::model()->findByPk($talkid);
		// 防止操作他人私信
		if($talk->uid !=  Yii::app()->user->id && $talk->fuid != Yii::app()->user->id){
			$this->ajaxErrReturn('非法操作');
		}
		$updateNum = Yii::app()->user->id == $talk->uid ? 'num' : 'fnum'; // 要清空的字段
		$num = $talk->$updateNum;
		// talk表待接收字段改为0
		Talk::model()->updateByPk($talkid , array($updateNum => 0));
		//member_count表待改消息更新
		MemberCount::model()->updateCounters(array('talknum' => 0-$num) , "uid = " . Yii::app()->user->id);
		$this->ajaxSucReturn('操作成功');
	}

}