<?php
class IndexController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'padding'=>0,
				'height'=>25, 
				'width'=> 80,
				'maxLength'=>4,
				'minLength'=>4,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionJoin(){
		$bid = Yii::app()->request->getParam('bid' , 0);
		$this->render('join' , array('bid'=>$bid));
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
			// 4个平台
		$companies = Company::model()->findAll(array(
						'condition' => 'isopen = 3',
						'order' => 'view_num desc',
						'limit' => 8,
						));

		foreach($companies as $key => $v){ // 去掉未设置头像的
			if(HComm::get_com_dir($v->cpid) == BASE_URL . Yii::app()->params['default_com_img']){
				unset($companies[$key]);
			}
		}
		
		// 活跃用户(带头像)
		$users = Member::model()->with('count')->findAll(array(
						'condition' => 'avatarstatus = 1',
						'order' => 't.uid desc',
						'limit' => '12',
						));
		$now = time();
		// 抽奖活动
		$lotteryEvents = Event::model()->with('company')->findAll(array(
						'condition' => "t.status = 2 and t.lotterytype != 0",
						'order' => ' t.viewnum desc',
						'limit' => 2,
						));

		// 活动公告
		$events = Event::model()->with('company')->findAll(array(
						'condition' =>"t.starttime < $now and t.endtime > $now and t.status = 2 and t.lotterytype = 0",
						'order' => 't.viewnum desc',
						'limit' => 9,
						));

		// 最近行业新闻
		$p2pNews = News::model()->findAll(array(
						'condition' => 't.classid in (201,204) and t.pic != "" and t.status = 1',
						'order' => 't.newsid desc',
						'limit' => 12,
						));
		$p2pNews = arToArray($p2pNews);
		$p2pNews[0]['title'] = HComm::truncate_utf8_string($p2pNews[0]['title'] , 18 , '...');
		$p2pNews[1]['title'] = HComm::truncate_utf8_string($p2pNews[1]['title'] , 18 , '...');
		
		$biaos = CompanyBiao::model()->with('company')->findAll(array(
								'order'=>'t.dateline desc',
								'limit' => 6,
								));

		$this->pageTitle = "365趣理财-中国互联网理财咨询首选";

		$this->render('index' , array(
				'companies' => $companies,
				'users' => $users,
				'events' => $events,
				'lotteryEvents'=>$lotteryEvents,
				'p2pNews' => $p2pNews,
				'biaos' => $biaos,
			));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	
	public function actionLogin(){
		
		if(!Yii::app()->user->isGuest)
			$this->redirect($this->createUrl('/p2p/list'));
			
		if(Yii::app()->user->hasFlash('success'))
			Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success')); 
		// if(Yii::app()->user->hasFlash('error'))
		// 	Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')); 
		
		$errs = array();
		$model=new LoginForm();
		if (! empty($_POST['LoginForm'])){
			$_POST['LoginForm']['username'] = strtolower($_POST['LoginForm']['username']);
			$model->attributes = $_POST['LoginForm'];

			 if($this->createAction('captcha')->validate($model->verifyCode, false))  {
			 	if ($model->validate() && $model->login()){
			 		// 如果有自己的平台，则跳转至平台首页
					// if($c = CompanyEmployee::model()->find("isadmin = 1 and uid = " . Yii::app()->user->id)){
					// 	$this->redirect($this->createUrl('/p2p/index' , array('cpid' => $c->cpid)));
					// }
					$this->redirect(Yii::app()->request->urlReferrer);
					
				}else {
					if ($model->hasErrors ()){
						$errs = $model->getErrors();
						Yii::app()->user->setFlash('error', $errs); 
					}
				}
			 	
			 }else{
			 	 Yii::app()->user->setFlash('verifyCode','验证码不对');  
			 }
		}
		$this->render('login', array('error'=>$errs));
	}

	// 判断验证码是否正确
	public function actionCheckCaptcha(){
		$cap = Yii::app()->request->getParam('cap');
		if(strtolower($this->createAction('captcha')->getVerifyCode()) == strtolower($cap)) {
			echo json_encode(true);
			exit();
		}
		echo json_encode(false);
		exit();
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionReg(){
		//$this->layout = 'special_main';
		// 解析各种邀请连接
		$auth = Yii::app()->request->getParam('auth');
		HInvite::inviteInit($auth);
		$cookie = Yii::app()->request->getCookies();
		// 开放免费注册
		// if(!isset($cookie['REG_1']) && !isset($cookie['REG_2']) && !isset($cookie['REG_3']) && !isset($cookie['REG_4']) && !isset($cookie['REG_5']) && !isset($cookie['REG_6']) ){
		// 	$this->redirectMessage("暂时只支持通过邀请链接进行注册，请继续关注理财派，谢谢！" , $this->createUrl("/p2p/list"));
		// }
		 
		if(!Yii::app()->user->isGuest)
			$this->redirect(array('p2p/list'));

		// 系统发放的注册连接，含有注册码
		$code = '';
		if($auth = Yii::app()->request->cookies['REG_6']){
			$code = HInvite::decodeInvite($auth);
			$code = $code[1];
		}

		$model = new Member('register');
		$errs = array();
		
		if (!empty($_POST['RegForm'])){
			$ip = HComm::getIP();
			if(! $ip) $ip=0; // 防止出现读不出来ip

			$sms = MsmSentLog::model()->find(array(
					'order'=>'dateline desc' ,
					'condition' => "ip = $ip and mobile =" . $_POST['RegForm']['mobile']));
			if ($sms->code != strtolower($_POST['RegForm']['mobile_code'])){
				Yii::app()->user->setFlash('mobileCode', '<img src="/html/images/gang.png"/>手机验证码错误'); 
				$this->redirect(Yii::app()->request->urlReferrer);
			}
			
			// 1.邀请平台 此邀请码可以注册并申请开通平台  （系统发放）
			// 2.邀请员工 此邀请码邀请的人可以注册并默认申请成为该公司员工 （平台管理员发放）
			// 3.邀请平台投资人  此邀请码可以注册并批量使用，默认关注该平台 （公司内部员工发放）
			// 4.邀请注册 此邀请码可以邀请注册并在自己邀请人里面显示 （普通投资人发放）
			// 5.邀请参加活动  此邀请码可以注册并跳转到活动页 （普通投资人发放）
			// 6.邀请注册 系统发放的可用来注册的连接，只能使用一次 (系统发放)
			$flag = false; // 标记是否由某种链接注册，且链接合法
			$jump = Yii::app()->request->urlReferrer; // 注册成功后默认跳转的页面
			if(isset($cookie['REG_1'])){ 
				$auth = $cookie['REG_1'];
				$auth = HInvite::decodeInvite($auth);
				if($cCode = InviteCode::model()->findByAttributes(array('code' => $auth[1] , 'class' => 2 , 'status' => 0))){
					$comInviteCode = new CHttpCookie('comInviteCode' , $auth[1]);
					$comInviteCode->expire = time() + 60*60*24;  //有限期1天
					Yii::app()->request->cookies['comInviteCode'] = $comInviteCode;
					$flag = true;
					$jump = $this->createUrl('/p2p/apply');
					unset($cookie['REG_1']); //注册码已使用，清除cookie
				}
			}
			else if(isset($cookie['REG_2'])){
				$auth = $cookie['REG_2'];
				$auth = HInvite::decodeInvite($auth);
				if($auth[0] == HInvite::REG_2 && Company::model()->exists("cpid = " . $auth[1])){
					$url = Yii::app()->request->hostInfo . $this->createUrl('/p2p/employeeApply');
					$jump = $url;
					$flag = true;
					// 申请成为员工后删除cookie
				}

			}
			else if(isset($cookie['REG_3'])){ 
				$auth = $cookie['REG_3'];
				$auth = HInvite::decodeInvite($auth);
				if($auth[0] == HInvite::REG_3 && Company::model()->exists("cpid = " . $auth[1])){
					//关注平台动作在注册之后发生
					$flag = true;
					//关注平台后删除cookie
				}
			}
			else if(isset($cookie['REG_4'])){
				$auth = $cookie['REG_4'];
				$auth = HInvite::decodeInvite($auth);
				if($auth[0] == HInvite::REG_4){
					$fromUser = $auth[1];
					// 邀请人邀请数加一
					MemberCount::model()->updateCounters(array('invite'=> 1), 'uid=' . $fromUser);
					$flag = true;
					//邀请人添加invite数据时删除cookie
				}
			}
			else if(isset($cookie['REG_5'])){
				$auth = $cookie['REG_5'];
				$auth = HInvite::decodeInvite($auth);
				$eventid = $auth[1];
				$fromUid = $auth[2];
				if($auth[0] == HInvite::REG_5 && Event::model()->exists("eventid = " . $auth[1])){
					$url = $this->createUrl('/event/p2pEventDetail' , array('eventid' => $auth[1]));
					$jump = $url;
					$flag = true;
				}
			}
			else if(isset($cookie['REG_6'])){ 
				$inviteCode = InviteCode::model()->findByAttributes(array('code' => trim($_POST['RegForm']['inviteCode']) , 'class' => 1 , 'status' => 0));
				if(! $inviteCode){
					Yii::app()->user->setFlash('inviteCode', '<img src="/html/images/gang.png"/>邀请码不存在或已使用!'); 
					unset(Yii::app()->request->cookies['regInvite']); //注册码已使用，清除cookie
					$this->redirect($jump);
				}
				$inviteCode->status = 1;
				$inviteCode->save();
				$flag = true;
				unset($cookie['REG_6']);
			}
			else if(isset($cookie['REG_7'])){ // 这里为第三方支付业务员发出的邀请，在注册平台逻辑中处理
				$jump = $this->createUrl('/p2p/apply');
				$flag = true;
			}
			// 现在开放注册。可不填邀请码
			$flag = true;

			if(!$flag){
				$this->redirectMessage("不合法的注册链接" , Yii::app()->request->urlReferrer);
			}
			$model->attributes=$_POST['RegForm'];
			
			if (!empty($_POST['RegForm']['email']) && !empty($_POST['RegForm']['mobile']) && !empty($_POST['RegForm']['username']) && !empty($_POST['RegForm']['password']) && $model->validate() &&  $model->save()) {
				// 往邮箱发送带有验证url的邮件
				$sendTo = trim($_POST['RegForm']['email']);
				//邮件标题
				$subject = '来至理财派的邮箱验证';
				//邮件内容
				$checkEmailAuth = HComm::encodeAuth(array($model->uid , $sendTo)); // 加密是由用户id，邮箱组成的
				$checkEmailUrl = Yii::app()->request->hostInfo . $this->createUrl('/home/emailAuth',array('auth' => $checkEmailAuth , 'uid'=>$model->uid));
				$body = "请点击下面的链接来完成您在理财派上的邮箱验证：<br/>" . $checkEmailUrl . "<br/><br/>请加入我们的官方投资交流群:230341007";
				$result = HComm::sendMail( $sendTo, $subject, $body );

				//login
				$identity=new UserIdentity($_POST['RegForm']['username'], $_POST['RegForm']['password']);
				if(! $identity->authenticate()) // edit by porter 条件取反了，加了个 ！
				    Yii::app()->user->login($identity);
				else
    				exit($identity->errorMessage) ;
    				
				HComm::updateCredit('register'); //更新积分

    				if(isset($cookie['REG_3'])){ 
					$auth = $cookie['REG_3'];
					$auth = HInvite::decodeInvite($auth);
	    				if($auth[0] == HInvite::REG_3 && Company::model()->exists("cpid = " . $auth[1])){
						// 关注该平台
						$companyFollow = new CompanyFollow();
						$companyFollow->cpid = $auth[1];
						$companyFollow->uid = Yii::app()->user->id;
						$companyFollow->save();
						unset($cookie['REG_3']); //注册码已使用，清除cookie
					}
				}
				else if(isset($cookie['REG_4'])){
					$auth = $cookie['REG_4'];
					$auth = HInvite::decodeInvite($auth);
					if($auth[0] == HInvite::REG_4){
						$fromUser = $auth[1];
						$invite = new Invite();
						$invite->uid = $fromUser;
						$invite->inviteuid = $model->uid;
						$invite->inviteusername = $model->username;
						$invite->save();

						HComm::updateCredit('invite_reg' , $fromUser); //更新积分
						unset($cookie['REG_4']); //注册码已使用，清除cookie
					}
				}

				$this->redirectMessage("我们已向您的邮箱发送验证邮件，请尽快验证" , $jump , 'success' , 3);
			}else {
				if ($model->hasErrors ()){
					$errs = $model->getErrors();
					Yii::app()->user->setFlash('error', $errs); 
				}
			}
			$this->refresh();
		}
		
		$this->render('reg', array('error'=>$errs , 'code' => $code));
	}



	// 忘记密码
	public function actionForgetPwd(){
		if(!empty($_POST)){
			$mobile = Yii::app()->request->getParam('mobile');
			$mobileCode = Yii::app()->request->getParam('mobile_code');
			
			// 验证手机是否存在数据库
			$user = Member::model()->find("mobile = '" . $mobile . "'");
			if(!$user){
				Yii::app()->user->setFlash('mobile' , '<img src="/html/images/gang.png"/>手机号不存在');
				$this->redirect(Yii::app()->request->urlReferrer);
			}

			$ip = HComm::getIP();
			if(! $ip) $ip=0; // 防止出现读不出来ip
			$sms = MsmSentLog::model()->find(array(
					'order'=>'dateline desc' ,
					'condition' => "ip = $ip and mobile =" . $mobile));
			if ($sms->code != strtolower($mobileCode)){
				Yii::app()->user->setFlash('mobile_code', '<img src="/html/images/gang.png"/>手机验证码错误'); 
				$this->redirect(Yii::app()->request->urlReferrer);
			}
			$this->render('setNewPwd' , array(
						'username' => $user->username,
						'secret' => base64_encode($mobile.'-'.$sms->code), //防止用户非法提交数据
						));
			exit();
			
		}
		$this->render('forgetPwd');
	}

	// 设置新密码
	public function actionSetNewPwd(){
		if(!empty($_POST)){
			$password = Yii::app()->request->getParam('password');
			$secret = Yii::app()->request->getParam('secret');  // 修改密码传递过来的是手机号和手机验证码组成的base64加密
			$decode = base64_decode($secret);
			$decode = explode('-' , $decode);
			$mobile = $decode[0];
			$mobileCode = $decode[1];

			// 验证手机验证码是否为正确
			$ip = HComm::getIP();
			if(! $ip) $ip=0; // 防止出现读不出来ip
			$sms = MsmSentLog::model()->find(array(
					'order'=>'dateline desc' ,
					'condition' => "ip = $ip and mobile =" . $mobile));
			if ($sms->code != strtolower($mobileCode)){
				$this->redirect(Yii::app()->request->urlReferrer);
			}

			if(strlen($password)<5 || strlen($password)>16){
				$this->redirectMessage("密码长度必须大于等于5小于等于16" , $this->createUrl('/index/forgetPwd'));
			}
			
			$user = $user = Member::model()->find("mobile = '" . $mobile . "'");
			$password = $user->hash($password , $user->salt);
			Member::model()->updateAll(array('password' => $password) , "mobile = '$mobile'");
			// 修改密码
			$this->redirectMessage("修改成功！" , $this->createUrl('/index/login') , 'success' ,'3');

 		}
 		$this->redirect(Yii::app()->request->urlReferrer);
	}
}
