<?php
/**
 * P2P平台 前台页面
 *
 */
class P2pController  extends Controller
{
	//public $layout = 'simple';
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
	
	public function filters(){
		return array(
			'accessControl',
			'accessCheck - list , myP2p , choiceBiao , newsNotice , apply , newsDetail , employeeApply',
			);
	}

	public function accessRules(){
		return array(
			
			array('allow',
				'actions'=>array('index', 'list' , 'choiceBiao' , 'newsDetail' , 'newsList' , 'albumDetail' , 'albumList' , 'biaoList' , 'voucher' , 'intro'),
			),
			
			array('deny',
				'users'=>array('?'),
			),
		);
	}
	public function filterAccessCheck($filterChain){
		$this->cpid = (int)Yii::app()->request->getParam('cpid');
		if (empty($this->cpid))
			$this->redirectMessage('第三方平台', Yii::app()->request->urlReferrer);
		
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


	// 平台导航页面
	public function actionList(){
		$this->layout = 'main';
		$criteria = new CDbCriteria();
		$criteria->addCondition("isopen=3");
		$rows= Yii::app()->user->isGuest ? 60 : (Yii::app()->user->cpid ? 60 : 59);
		$count = count(Company::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = ' follow_num desc'; // 关注数排序

		$companies = Company::model()->findAll($criteria);
		
		$this->pageTitle = 'P2P网贷平台导航_p2p网贷平台排名_理财派 ';

		$this->render('list',array(
				'companies'=>$companies,
				'tab' => 'all',
				'pages'=>$pager,
				));
	}
	
	// 我关注的平台
	public function actionMyP2p(){
		$this->layout = 'main';
		
		// 我管理的公司
		$myCompany = new Company();
		if($emp = CompanyEmployee::model()->find('uid = ' . Yii::app()->user->id)){
			$myCompany = Company::model()->findByPk($emp->cpid);
		}

		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];

		$criteria->condition = "t.uid = " . Yii::app()->user->id;
		$count = count(CompanyFollow::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 
		
		//我关注的公司
		$cfollows = CompanyFollow::model()->with('company')->findAll($criteria);
		$companies = array();
		// 转成模板中遍历的格式
		foreach($cfollows as $v){
			$companies[] = $v->company;
		}
		
		$this->render('list',array(
				'companies'=>$companies,
				'myCompany' => $myCompany,
				'tab' => 'my',
				'pages'=>$pager,
				));	
	}

	// 申请入驻
	public function actionApply(){
		if(CompanyEmployee::model()->exists(array('condition'=>'uid = '.Yii::app()->user->id))){
			$this->redirectMessage('您已经申请过平台入驻.', $this->createUrl('/p2p/list'));
		}

		// 通过申请链接进来的，保存邀请码进入COOKIE有效期7天
		if($code = Yii::app()->request->getParam('code')){
			$code = trim($code);
			if(InviteCode::model()->exists("class = 2 and code = '$code'")){
				$cookie = new CHttpCookie('comInviteCode' , $code);
				$cookie->expire = time() + 60*60*24*7;  //有限期7天 
				Yii::app()->request->cookies['comInviteCode'] = $cookie;
			}
		}
		$code = isset(Yii::app()->request->cookies['comInviteCode']) ? Yii::app()->request->cookies['comInviteCode'] : '';
		if(isset(Yii::app()->request->cookies['REG_7'])){ // 判断是否存在第三方业务员邀请,第三方邀请的优先级高于系统发放的
			$REG_7 = Yii::app()->request->cookies['REG_7'];
			$codeArr = HInvite::decodeInvite($REG_7);
			$code = isset($codeArr[1]) ? $codeArr[1] : '';
		}
		if ( isset( $_POST['name'] ) ) {			
			$name = trim($_POST['name']);
			$siteurl = trim($_POST['siteurl']);
			$resideprovinceid = trim($_POST['resideprovinceid']);
			$cityid = trim($_POST['cityid']);
			$operation_name = trim($_POST['operation_name']);
			$operation_mobile = trim($_POST['operation_mobile']);
			$onlinetime = strtotime($_POST['onlinetime']);
			$invite = trim($_POST['invite']);
			
			if (empty($name) || empty($siteurl) || empty($operation_name) || empty($operation_mobile) || empty($invite)) 
				$this->redirectMessage('请把信息填写完整', Yii::app()->request->urlReferrer);

			$inviteCode = InviteCode::model()->findByAttributes(array("code" => $invite));

			$model = new Company();
			
			if(!$inviteCode){ // 验证第三方平台的邀请码
				$this->redirectMessage('您输入的邀请码有误', Yii::app()->request->urlReferrer);
			} else {
				if($inviteCode->class == 3){ //表示为第三方支付业务员邀请
					$model->payment = Business::model()->findByPk($inviteCode->pid)->shortname;
					$model->payid = $inviteCode->pid;
					$model->invite_uid = $inviteCode->uid;
					// 第三方支付平台接入数加一
					Business::model()->updateCounters(array('p2pnum'=>1) , "bid = " . $model->payid);
					unset(Yii::app()->request->cookies['REG_7']);
					unset(Yii::app()->request->cookies['comInviteCode']);
				}
			}
			
			$model->name = $name;
			$model->cityid = $cityid;
			$model->siteurl = $siteurl;
			$model->resideprovinceid = $resideprovinceid;
			$model->onlinetime = $onlinetime;
			//$model->payment = Business::model()->findByPk($inviteCode->pid)->shortname; 没有第三方支付了
			
			if ($model->validate() && $model->save()){
				// 更新第三方支付的接入平台数属性
				// Business::model()->findByPk($inviteCode->pid)->saveCounters(array('p2pnum'=>1));
				
				// 更新邀请码信息
				$inviteCode->inviteid = $model->cpid;
				$inviteCode->status = 1;
				$inviteCode->save();

				// $this->redirectMessage('申请成功，等待审核', $this->createUrl('p2p/list') , 'success');	
				$this->redirect($this->createUrl('/p/p2p/info' , array('cpid' => $model->cpid)));
			}
		}
		$this->render('apply' , array('code' => isset($code)?$code:$inviteCode->code));
	}
	
	// 设置公司logo
	public function actionSetComLogo(){ // 此方法暂时抛弃 2014-12-06 申请后直接跳转至后台基本信息
		if(! empty($_POST)){
			$this->redirectMessage('申请成功，请完善资料后申请审核', $this->createUrl('p2p/list') , 'success' , 5);
		}
		$this->renderWithId('setComLogo');
	}

	// 关注平台
	public function actionFollow(){
		$this->render('follow');
	}
	
	// 平台首页
	public function actionIndex(){
		// 公司基本信息
		$company = Company::model()->findByPk($this->cpid);

		// 访问次数+1
		$cookies = Yii::app()->request->getCookies();
		if (! isset($cookies['company'.$company->cpid])) {
			$company->view_num = $company->view_num + 1;
			$company->save();	
			
			$cookie = new CHttpCookie('company'.$company->cpid, 1);
			$cookie->expire = time()+60*5;  //5分钟增加浏览次数1次
			Yii::app()->request->cookies['company'.$company->cpid] = $cookie;
		}

		// 平台活动列表
		$events = Event::model()->findAll(array(
				'condition' => "status = 2 and p2pid = " . $this->cpid,
				'limit' => 3,
				'order' => 'dateline desc',
			));

		// 新闻公告列表
		$news = CompanyNews::model()->findAll(array(
				'condition' => 'cpid = '.$this->cpid,
				'limit' => 6,
				'order' => 'dateline desc',
				));

		// 发表播报
		$biaos = CompanyBiao::model()->findAll(array(
				'condition' => 'cpid = '.$this->cpid,
				'limit' => 6,
				'order' => 'dateline desc',
				));

		// 宣传视频
		$videos = CompanyVideo::model()->findAll(array(
				'condition' => 'cpid = '.$this->cpid,
				'limit' => 2,
				'order' => 'dateline desc',
				));
		// 宣传相册
		$albums = CompanyPic::model()->findAll(array(
				'condition' => 'album = 2 and cpid = '.$this->cpid,
				'limit' => 3,
				'order' => 'dateline desc',
				));

		// 客服人员
		$services = CompanyService::model()->findAll(array(
				'condition' => ' status = 1 and cpid = '.$this->cpid,
				'limit' => 6,
				'order' => 'dateline desc',
				));

		// 粉丝
		$fens = CompanyFollow::model()->findAll(array(
				'condition' => 'cpid = '.$this->cpid,
				'limit' => 8,
				'order' => 'dateline desc',
				)
			);

		// 最新平台新闻
		$lastestNews = News::model()->findAll(array(
					'condition' => "status = 1 and pid = " . $this->cpid,
					'order' => 'dateline desc',
					'limit' => '3',
					));


		$this->pageTitle = $company->name . "平台档案_" . $company->name . "官网资料_p2p网贷平台档案_ " . $company->name . "平台主页_理财派";

		$this->render('index',array(
			'company'=>$company,
			'events' => $events,
			'news' => $news,
			'biaos' => $biaos,
			'videos' => $videos,
			'albums' => $albums,
			'services' => $services,
			'fens' => $fens,
			'lastestNews' => $lastestNews,
			'comid' => $this->cpid
			));
	}

	//查看公司大地图
	public function actionBigMap(){
		//echo 1; exit;
		//部分公司信息
		$company = Company::model()->find(array(
			'select'	=> 'name,resideprovince,city,address,lat,lng',
			'condition' => 'cpid=:cpid',
			'params'	=> array(':cpid'=>$this->cpid),
			));

		$this->render('bigmap',array(
			'company'=>$company,
			));
	}

	// 选标
	public function actionChoiceBiao(){
		$this->layout = 'main';
		$tab = Yii::app()->request->getParam('tab' , 'all');
		if($tab != 'all'){
			$this->redirect(array('/index/login'));
		}
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		if($tab == 'my'){
			$cps = CompanyFollow::model()->findAll( "uid = " . Yii::app()->user->id);
			$cpids = array(0);
			foreach($cps as $v){
				$cpids[] = $v->cpid;
			}
			$cpids = implode(',' , $cpids);
			// 找出我关注的公司的id
			$criteria->condition = "t.cpid in ($cpids)";
		} else if($tab == 'like'){
			$biaoLikes = BiaoLike::model()->findAll( "uid = " . Yii::app()->user->id);
			$bids = array(0);
			foreach($biaoLikes as $v){
				$bids[] = $v->biaoid;
			}
			$bids = implode(',' , $bids);
			// 找出我关注的公司的id
			$criteria->condition = "t.id in ($bids)";
		} else if($tab == 'all'){
			$criteria->condition = '1 = 1';
		}
		$criteria->condition .= " and company.isopen = 3";
		$count = count(CompanyBiao::model()->with('company')->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 't.datelinepublish desc';

		$biaos = CompanyBiao::model()->with('company')->findAll($criteria);

		$this->pageTitle = 'P2P网贷平台发标预告_P2P网贷平台最新发标预告_理财派选标';

		$this->renderWithId('choiceBiao',array(
				'biaos'=>$biaos,
				'tab' => $tab,
				'pages'=>$pager,
				));
	}

	// 新闻公告
	public function actionNewsNotice(){
		$this->layout = 'main';
		$tab = Yii::app()->request->getParam('tab' , 'all');

		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		if($tab == 'my'){
			$cps = CompanyFollow::model()->findAll( "uid = " . Yii::app()->user->id);
			$cpids = array(0);
			foreach($cps as $v){
				$cpids[] = $v->cpid;
			}
			$cpids = implode(',' , $cpids);
			// 找出我关注的公司的id
			$criteria->condition = "t.cpid in ($cpids)";
		} else{
			$criteria->condition = "1 = 1";
		}
		$criteria->condition .= " and company.isopen = 3";
		$count = count(CompanyNews::model()->with('company')->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 't.dateline desc';

		$news = CompanyNews::model()->with('company')->findAll($criteria);

		$this->pageTitle = '理财派_平台新闻_P2P新闻_理财资讯';

		$this->renderWithId('newsNotice',array(
				'news'=>$news,
				'tab' => $tab,
				'pages'=>$pager,
				));
	}

	/**
	+
	*   新闻模块
	+
	**/
	// 发表列表页
	public function actionBiaoList(){
		$criteria = new CDbCriteria();
		$criteria->condition = "t.cpid = " . $this->cpid;
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyVideo::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 't.dateline desc';

		$biaos = CompanyBiao::model()->with('company')->findAll($criteria);

		$company = Company::model()->findByPk($this->cpid);

		$this->renderWithId('biaoList',array(
				'biaos'=>$biaos,
				'pages'=>$pager,
				'company' => $company,
				));
	}
	
	/**
	+
	*   新闻模块
	+
	**/
	// 新闻列表页
	public function actionNewsList(){
		$criteria = new CDbCriteria();
		$criteria->condition = "pid = " . $this->cpid;
		$rows=Yii::app()->params['postnum'];
		$count = count(News::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';

		$news = News::model()->findAll($criteria);

		$company = Company::model()->findByPk($this->cpid);

		$this->renderWithId('newsList',array(
				'news'=>$news,
				'pages'=>$pager,
				'company' => $company,
				));
	}

	// 新闻详细页
	public function actionNewsDetail(){
		$id = Yii::app()->request->getParam('id');
		if(!$id){
			throw new CHttpException("您所访问的页面不存在!");
		}
		$news = CompanyNews::model()->findByPk($id);

		// 访问次数+1
		$cookies = Yii::app()->request->getCookies();
		if (! isset($cookies['newsDetail'.$id])) {
			$news->viewnum = $news->viewnum + 1;
			$news->save();	
			
			$cookie = new CHttpCookie('newsDetail'.$id, 1);
			$cookie->expire = time()+60*5;  //5分钟增加浏览次数1次
			Yii::app()->request->cookies['newsDetail'.$id] = $cookie;
		}

		$company =  Company::model()->findByPk($news->cpid);

		$this->pageTitle = $news->title . '_理财派';

		$this->render('newsDetail',array(
				'news' => $news,
				'company' => $company,
				));
	}

	/**
	+
	*   新闻模块
	+
	**/
	// 视频列表
	public function actionVideoList(){
		$criteria = new CDbCriteria();
		$criteria->condition = "cpid = " . $this->cpid;
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyVideo::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';

		$videos = CompanyVideo::model()->findAll($criteria);

		$company = Company::model()->findByPk($this->cpid);

		$this->renderWithId('videoList',array(
				'videos'=>$videos,
				'pages'=>$pager,
				'company' => $company,
				));
	}

	/**
	+
	*   相册模块
	+
	**/
	// 相册列表
	public function actionAlbumList(){
		$criteria = new CDbCriteria();
		$criteria->condition = "album = 2 and cpid = " . $this->cpid;
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyPic::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';

		$albums = CompanyPic::model()->findAll($criteria);

		$company = Company::model()->findByPk($this->cpid);

		$this->renderWithId('albumList',array(
				'albums'=>$albums,
				'pages'=>$pager,
				'company' => $company,
				));
	}

	// 公司证件
	public function actionOthersInfo(){
		$company = Company::model()->findByPk($this->cpid);	
		$do = Yii::app()->request->getParam('do' , 'ptjj');
		if(!$do) $do = 'ptjj';

		$others = array( // 为tab对应的数据库字段
			'ptjj' => 'info' , // 平台简介
			'tdjs' => 'team', // 团队介绍
			'zzzm' => 'voucher', // 资质证明
			'lxwm' => 'contact_us' , //联系我们
			'sfqk' => 'charge', //收费情况
			);
		$doNames = array(
			'ptjj' => '平台简介', 
			'tdjs' => '团队介绍', 
			'zzzm' => '公司证件', 
			'lxwm' => '联系我们' , 
			'sfqk' => '管理费用', 
			);

		$company = Company::model()->with('company_info')->findByPk($this->cpid);

		$this->renderWithId('othersInfo' , array(
					'company' => $company,
					'do' => $others[$do],
					'select' => $do,
					'doName' => $doNames[$do],
					));
	}

	// 图片详细页
	public function actionAlbumDetail(){
		$company = Company::model()->findByPk($this->cpid);
		$albumid = Yii::app()->request->getParam('albumid');
		if(!is_numeric($albumid)){
			$this->redirectMessage('参数错误' , Yii::app()->request->urlReferrer);
		}

		$albums = CompanyPic::model()->findAll(array(
						"condition" => "album = 2 and cpid = " . $this->cpid,
						"order" => 'dateline desc',
						));

		$this->renderWithId('albumDetail' , array(
					'albums' => $albums,
					'company' => $company,
					'albumid' => $albumid,
						));
	}

	// 申请成为员工页面
	public function actionEmployeeApply(){
		$auth = Yii::app()->request->getParam('iauth');

		if(CompanyEmployee::model()->exists("uid = " . Yii::app()->user->id)){
			$this->redirectMessage("您已经是其他平台的员工!" , Yii::app()->request->urlReferrer);
		}
		// 将auth存入cookie
		if(isset($auth)) {
			$cookie = new CHttpCookie('inviteEmployee', $auth);
			$cookie->expire = time()+3600*12;  //cookie有效时间12表小时
			Yii::app()->request->cookies['inviteEmployee'] = $cookie;
		}
		$cookies = Yii::app()->request->getCookies();
		$cpid = 0;
		if (isset($cookies['REG_2'])) {
			$auth = HInvite::decodeInvite($cookies['REG_2']);
			$cpid = $auth[1];
		} else {
			$this->redirectMessage('只能通过平台发放的链接进行员工申请' , Yii::app()->request->urlReferrer);
		}

		// 插入操作
		$companyEmployee = new CompanyEmployee();
		if($companyEmployee->exists("uid = " . Yii::app()->user->id)){
			$this->redirectMessage("您已经是其他平台的员工!" , Yii::app()->request->urlReferrer);
		}

		$companyEmployee->cpid = $cpid;
		$companyEmployee->uid = Yii::app()->user->id;
		$companyEmployee->username = Yii::app()->user->name;
	
		if($companyEmployee->save()){
			unset($cookies['REG_2']);
		}

		$userinfo = Member::model()->with('info')->findByPk(Yii::app()->user->id);

		$this->redirectMessage("申请成功，请等待管理员审核...." , $this->createUrl('/p2p/index' , array('cpid'=>$cpid)) ,3 , 'success');
	}


	// 视频页面
	public function actionVideo(){
		
		$this->render('video');
	}
	
	// 图片列表
	public function actionPics(){
		$this->render('pics');
	}
	
	// 图片页面
	public function actionPic(){
		
		$this->render('pic');
	}
	
	// 资质证明
	public function actionAboutUs(){
		
		$this->render('aboutus');
	}
	
	// 信息内容页
	public function actionInfo(){
		
		$this->render('info');
	}

}