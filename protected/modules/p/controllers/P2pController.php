<?php
/**
 * P2P平台 后台页面
 *
 */
class P2pController  extends Controller
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
			// 'accessCheck + index,news,newsAdd,newsEdit,newsDel,biaos,biaosAdd,biaosEdit,info ,ads,employee,employeeEdit,employee',
			'accessCheck - newsDel,empSetAdmin,employeeDel , biaosDel',
			);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('@'),
				),
			);
	}

	public function filterAccessCheck($filterChain){
		$this->cpid = (int)Yii::app()->request->getParam('cpid');
		if (empty($this->cpid))
			$this->redirectMessage('第三方平台', Yii::app()->request->urlReferrer);
		
		if(Yii::app()->user->isGuest)
				$this->redirect(array('/index/login'));
			
		if(! CompanyEmployee::model()->exists("status = 1 and cpid = " . $this->cpid . " and uid = " . Yii::app()->user->id)){
			throw new CHttpException("非法操作!");
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
	
	
	// 首页
	public function actionIndex(){

		$this->_menu_select = 'index';
		$company = Company::model()->findByPk($this->cpid);
		if(!$company){
			$this->redirectMessage("参数错误" , Yii::app()->request->urlReferrer);
		}

		// 生成邀请链接
		$baseUrl = Yii::app()->request->hostInfo . $this->createUrl('/index/reg');
 		// 2.邀请员工 此邀请码邀请的人可以注册并默认申请成为该公司员工 （平台管理员发放）
 		// auth 为 array(HInvite::REG_2 , 公司id);
		$auth = array(HInvite::REG_2 , $this->cpid);
		$iauth = HInvite::encodeInvite($auth);
		$empUrl = $baseUrl .  '&auth=' . $iauth;
		// 3.邀请平台投资人  此邀请码可以注册并批量使用，默认关注该平台 （公司内部员工发放）
		// auth 为array(HInvite::REG_3 , 公司id);
		$auth = array(HInvite::REG_3 , $this->cpid);
		$auth = HInvite::encodeInvite($auth);
		$followUrl = $baseUrl . '&auth=' . $auth;

		// 申请完成进度
		//基本资料6项 名称 网址 地址 月利率 周期 第三方支付
		// $need6 = "info is not null and mainbissness is not null and team is not null and voucher is not null and contact_us is not null and cpid = " . $this->cpid;
		$need6 = "address is not null and capital is not null and profitlow is not null and profithigh is not null and cyclelow is not null and cyclehigh is not null and cpid = " . $this->cpid;
		$step = array(
			'base' => Company::model()->exists($need6),
			'service' => CompanyService::model()->exists("cpid = " . $this->cpid),
			'news' => News::model()->exists("pid = " . $this->cpid),
			'biao' => CompanyBiao::model()->exists("cpid = " . $this->cpid),
			'album' => CompanyPic::model()->exists("album=2 and cpid = " . $this->cpid),
			);

		// 系统公告
		$notice = News::model()->findAll( array(
				'condition' => "classid = '301'",
				'order' => 't.order asc',
				));
		$this->renderWithId('index', array(
				'_menu_select'=>'index',
				'company' => $company,
				'empUrl' => $empUrl,
				'followUrl' => $followUrl,
				'notice' => $notice,
				'step' => $step,
				));
	}

	// 公司申请开通
	public function actionApplyOpen(){
		Company::model()->updateByPk($this->cpid , array('isopen' => 2));
		$this->redirect(Yii::app()->request->urlReferrer);
	}
	/**
	+-----------------------------------------
	*	自定义广告/图片模块
	+-----------------------------------------
	**/
	public function actionAds(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("cpid = ".$this->cpid);
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyAdPic::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';

		$ads = CompanyAdPic::model()->findAll($criteria);

		$this->renderWithId('ads',array(
				'ads' => $ads,
				'pages' => $pager,
				));
	}
	
	public function actionAdsEdit(){
		$id = Yii::app()->request->getParam('id');
		$adPic = new CompanyAdPic();
		if($id){
			$adPic = $adPic->findByPk($id);
		} 

		if(isset($_POST)&&!empty($_POST)){
			// 一个位置只能有一个启用的广告
			if($adPic->isNewRecord&&$adPic->exists("status = 1 and cpid=:cpid and place=:place",array(':cpid'=>$this->cpid,':place'=>$_POST['place']))){
				$this->redirectMessage('一个广告位最多只能有一个启用状态的广告.', $this->createUrl('/p/p2p/ads',array('cpid'=>$this->cpid)));
			}
			$adPic->cpid = $this->cpid;
			$adPic->place = $_POST['place'];
			$adPic->title = trim($_POST['title']);
			$adPic->picurl = trim($_POST['picurl']);
			$adPic->url = trim($_POST['url']);
			$adPic->order = (int)$_POST['order'];
			if($adPic->save()){
				$this->redirect($this->createUrl('/p/p2p/ads',array('cpid'=>$this->cpid)));
			}
		}
		$this->renderWithId('adsEdit',array('adPic'=>$adPic));
	}

	// 删除自助广告      
	public function actionAdsDel(){
		$id = $_POST['id'];
		$model = new CompanyAdPic();
		if(empty($id)){
			$this->ajaxErrReturn('非法操作!');
		}

		$ads = $model->findByPk($id);
		if($ads->delete()){
			$this->ajaxSucReturn('删除成功!');
		}
	}

	// 启用/禁用广告
	public function actionAdsChangeStatus(){
		$place = Yii::app()->request->getParam('place');
		$id = Yii::app()->request->getParam('id');
		$ads = CompanyAdPic::model()->findByPk($id);
		if($ads->status == 1){
			$ads->status = 0;
		} else {
			if($ads->exists("status = 1 and place = $place and cpid = ".$this->cpid)){
				$this->ajaxErrReturn('同一个广告位只能有一个启用状态的广告!');
			}
			$ads->status = 1;
		}
		if($ads->save()){
			$this->ajaxSucReturn('操作成功!');
		}
	}
	/**
	+-----------------------------------------
	*	宣传相册模块
	+-----------------------------------------
	**/
	public function actionAlbum(){
		$albumtype = 2;
		$criteria = new CDbCriteria();
		$criteria->addCondition("album = $albumtype and cpid = ".$this->cpid);
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyPic::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';

		$albums = CompanyPic::model()->findAll($criteria);

		$this->renderWithId('album',array(
				'albums'=>$albums,
				'pages' => $pager,
				'type' => $albumtype,
				));
	}

	// 添加/修改相册
	public function actionAlbumEdit(){

		$id = Yii::app()->request->getParam('id');

		$album = new CompanyPic();

		if($id){
			$album = $album->findByPk($id);
		}

		if(isset($_POST)&& !empty($_POST)){
			$album->url = trim($_POST['url']);
			$album->picname = trim($_POST['picname']); 
			$album->album = $_POST['album'];  
			$album->cpid = $this->cpid;
			if($album->save()){
				$this->redirect($this->createUrl('/p/p2p/album',array('cpid'=>$this->cpid , 'type'=>$album->album)));
			}
		}

		$this->renderWithId('albumEdit',array('album'=>$album));
	}

	// 删除相册
	public function actionAlbumDel(){
		$id = $_POST['id'];
		$model = new CompanyPic();
		if(empty($id)){
			$this->ajaxErrReturn('非法操作!');
		}

		$album = $model->findByPk($id);
		if($album->uid != Yii::app()->user->id){
			$this->ajaxErrReturn('只能删除自己发表的新闻!');
		}

		if($album->delete()){
			$this->ajaxSucReturn('删除成功!');
		}
	}

	/**
	+-----------------------------------------
	*	发标模块
	+-----------------------------------------
	**/

	// 发表播报
	public function actionBiaos(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("cpid = ".$this->cpid);
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyBiao::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'datelinepublish desc';

		$biaos = CompanyBiao::model()->findAll($criteria);

		$this->renderWithId('biaos',array(
				'biaos'=>$biaos,
				'pages' => $pager,
				));
	}

	// 发标 / 修改标
	public function actionBiaosEdit(){
		$biaos = new CompanyBiao();
		// 区分当前操作为新增还是修改
		if($id = Yii::app()->request->getparam('id')){
			$biaos = $biaos->findByPk($id);
		} 
		if(isset($_POST)&&!empty($_POST)){
			$biaos->title        = trim($_POST['title']);
			$biaos->money        = (int)($_POST['money']);
			$biaos->profityear   = round(trim($_POST['profityear']), 2);  //年利率,存入数据库的字段，保留2位小数
			$profityear          = trim($_POST['profityear']);			  //计算万元收益变量
			$biaos->timelimit    = (int)trim($_POST['timelimit']);        //周期
			$biaos->interestrate = round( $biaos->profityear/12, 2);      //月利率为年化/12,存入数据库的字段，保留2位小数
			$biaos->award        = round(trim($_POST['award']), 2);		  //奖励,存入数据库的字段，保留2位小数
			$award               = trim($_POST['award']);				  //计算万元收益变量
			$biaos->itemtype     = (int)($_POST['itemtype']);			  //标种
			
			//获取预期万元收益
			$biaos->expectprofit = Htender::expectprofit($profityear, $award, $biaos->itemtype, $biaos->timelimit);

			$biaos->datelinepublish = strtotime($_POST['datelinepublish']);
			$biaos->repaymenttype =  (int)($_POST['repaymenttype']);
			$biaos->cpid = $this->cpid;

			if($biaos->isNewRecord){
				$biaos->cpname = Company::model()->findByPk($this->cpid)->name;
				$biaos->uid = Yii::app()->user->id;
				$biaos->dateline = time();
			}
			if($biaos->save()){
				$this->redirect($this->createUrl('/p/p2p/biaos',array('cpid'=>$this->cpid)));
			}	
		}

		$this->renderWithId('biaosEdit',array('biaos'=>$biaos));
	}

	// 删除标
	public function actionBiaosDel(){
		$id = $_POST['id'];
		$model = new CompanyBiao();
		if(empty($id)){
			$this->ajaxErrReturn('非法操作!');
		}

		$biao = $model->findByPk($id);
		if($biao->uid != Yii::app()->user->id){
			$this->ajaxErrReturn('只能删除自己发布的标!');
		}

		if($biao->delete()){
			$this->ajaxSucReturn('删除成功!');
		}
	}
	
	public function actionCustomer(){
		
		$this->renderWithId('customer');
	}
	
	/**
	+--------------------------
	* 员工管理模块
	+--------------------------
	**/
	public function actionEmployee(){
		if(($emp = CompanyEmployee::model()->find("uid = " . Yii::app()->user->id)) && $emp->isadmin != 1){ // 员工管理只允许管理员入内
			$this->redirectMessage("员工管理只允许管理员入内" , Yii::app()->request->urlReferrer);
		}
		$criteria = new CDbCriteria();
		$criteria->addCondition("status != -1 and cpid = ".$this->cpid); // and isadmin !=1 
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyEmployee::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';
		$employees = CompanyEmployee::model()->findAll($criteria);
		
		$this->renderWithId('employee', array(
			'employees' => $employees,
			'pages'=>$pager,
			));
	}

	public function actionEmployeeEdit(){

		$id = Yii::app()->request->getParam('id');

		if(! $id){
			$this->redirectMessage('参数错误' , Yii::app()->request->urlReferrer);
		}
		$employee = CompanyEmployee::model()->findByPk($id);
		if(isset($_POST)&& !empty($_POST)){
			$employee->realname = trim($_POST['realname']);
			$employee->cpid = $this->cpid;
			$employee->department = $_POST['department'];
			
			if($employee->save()){
				$this->redirect($this->createUrl('/p/p2p/employee',array('cpid'=>$this->cpid)));
			}
		}

		$this->renderWithId('employeeEdit',array('employee'=>$employee));
	}
	
	// 设置审核状态
	public function actionEmpSetStatus(){
		$id = Yii::app()->request->getParam('id');
		$status = Yii::app()->request->getParam('status');
		if(!in_array($status,array(1,-1))){
			throw new ExceptionClass("非法操作!");
		}
		$employee = CompanyEmployee::model()->findByPk($id);

		if($status == 1){  // 如果成为员工，则修改个人管理平台信息
			Member::model()->updateByPk($employee->uid , array('cpid' => $this->cpid));
		}
		$employee->status = $status;
		if($employee->save()){
			$this->ajaxSucReturn();
		}
		$this->ajaxErrReturn('服务器正忙，请稍后重试!');
	}

	// 删除员工
	public function actionEmployeeDel(){
		$id = $_POST['id'];
		$model = new CompanyEmployee();
		if(empty($id)){
			$this->ajaxErrReturn('非法操作!');
		}

		$employee = $model->findByPk($id);
		if($employee->uid != Yii::app()->user->id){
			echo json_encode(array('status'=>false,'msg'=>'只能删除自己公司的员工!'));
		}

		if($employee->updateByPk($id , array('status' => -1))){
			// 修改个人管理平台信息
			Member::model()->updateByPk(Yii::app()->user->id , array('cpid' => 0));
			echo json_encode(array('status'=>true,'msg'=>'删除成功!'));
		}
	}

	// 设置为管理员
	public function actionEmpSetAdmin(){
		$id = Yii::app()->request->getParam('id');
		$employee = CompanyEmployee::model()->findByPk($id);
		$employee->isadmin = 1;
		if($employee->save()){
			echo json_encode(array('status'=>true));
			exit();
		}
		echo json_encode(array('status'=>false,'msg'=>'服务器正忙，请稍后重试!'));
	}
	/**
	+--------------------------
	* 基本信息模块
	+--------------------------
	**/
	public function actionInfo(){

		$company = Company::model()->findByPk($this->cpid);
		if(isset($_POST)&& !empty($_POST)){
			$company->address = htmlspecialchars(trim($_POST['address']));
			$company->capital = htmlspecialchars(trim($_POST['capital']));
			$company->profitlow = round(($_POST['profitlow']) ,2);
			$company->profithigh = round(($_POST['profithigh']) , 2);
			$company->cyclelow = htmlspecialchars(trim($_POST['cyclelow']));
			$company->cyclehigh = htmlspecialchars(trim($_POST['cyclehigh']));
			$company->weixin = htmlspecialchars(trim($_POST['weixin']));
			$company->qq = htmlspecialchars(trim($_POST['qq']));
			$company->host = (int)$_POST['host'];

			if($company->save()){
				Yii::app()->user->setFlash('saveBaseInfo' , '修改成功!');
				// 如果没有填写平台简介跳转至平台简介，顺序引导，未做
				$this->redirect($this->createUrl('/p/p2p/info',array('cpid'=>$this->cpid)));
			}
		}
		$this->renderWithId('info',array('company'=>$company));
	}

	// 公司其他信息
	public function actionOtherInfo(){
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
			'zzzm' => '资质证明', 
			'lxwm' => '联系我们' , 
			'sfqk' => '收费情况', 
			);
		$content = CompanyInfo::model()->findByPk($this->cpid)->$others[$do];

		if($_POST){
			$content = Yii::app()->request->getParam('content' , '');
			if(CompanyInfo::model()->updateAll(array($others[$do] => $content) , "cpid = " . $this->cpid)){
				Yii::app()->user->setFlash('otherInfoSuccess' , '设置成功!');
			} 
		}
		$this->renderWithId('otherInfo' , array(
					'do' => $do,
					'doName' => $doNames[$do],
					'content' => $content,
					));
	}
	
	/**
	+--------------------------
	* 客服模块
	+--------------------------
	**/
	public function actionService(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("cpid = ".$this->cpid); // 排除已经删除了的
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyService::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';
		$service = CompanyService::model()->findAll($criteria);
		
		$this->renderWithId('service', array(
			'service' => $service,
			'pages'=>$pager,
			));
	}

	// 编辑客服
	public function actionServiceEdit(){
		$id = Yii::app()->request->getParam('id');
		$service = new CompanyService();
		if(!empty($id)){
			$service = $service->findByPk($id);
		}
		if(isset($_POST)&& !empty($_POST)){
			$service->nickname = trim($_POST['nickname']);
			$service->qq = $_POST['qq'];
			$service->cpid = $this->cpid;
			$service->status = intval($_POST['status']);
			if($service->save()){
				$this->redirect($this->createUrl('/p/p2p/service',array('cpid'=>$this->cpid)));
			}
		}
		$this->renderWithId('serviceEdit',array('service'=>$service));
	}

	// 删除客服
	public function actionServiceDel(){
		$id = $_POST['id'];
		$model = new CompanyService();
		if(empty($id)){
			echo json_encode(array('status'=>false,'msg'=>'非法操作!'));
		}

		$service_info = $model->findByPk($id);
		if(CompanyInfo::model()->findByPk($this->cpid)->uid != Yii::app()->user->id){
			echo json_encode(array('status'=>false,'msg'=>'只能删除自己平台的客服!'));
		}

		if($service_info->deleteByPk($id)){
			echo json_encode(array('status'=>true,'msg'=>'删除成功!'));
		}
	}

	// 通过客服申请 
	public function actionServicePass(){
		$id = Yii::app()->request->getParam('id');
		$model = new CompanyService();
		if(empty($id)){
			$this->redirectMessage(404, Yii::app()->request->urlReferrer);
		}

		$service_info = $model->findByPk($id);
		if(CompanyInfo::model()->findByPk($this->cpid)->uid != Yii::app()->user->id){
			$this->redirectMessage(404, Yii::app()->request->urlReferrer);
		}

		if($service_info->updateByPk($id,array('status'=>1))){
			$this->redirect($this->createUrl('/p/p2p/service',array('cpid'=>$this->cpid)));
		}
		$this->redirectMessage(500, Yii::app()->request->urlReferrer);
	}

	
	/**
	+-----------------------------------------
	*	新闻/公告模块
	+-----------------------------------------
	**/
	// 添加新闻/公告
	public function actionNewsAdd(){
		if(isset($_POST)&&!empty($_POST)){
			$model = new CompanyNews();
			$model = new News();
			$model->title = trim($_POST['title']);
			$model->classid = $_POST['classid'];
			$model->pid = $this->cpid;
			$model->pname = Company::model()->findByPk($this->cpid)->name;
			$model->content = trim($_POST['content']);
			$model->status = 1;
			if($model->save()){
				$this->redirect($this->createUrl('/p/p2p/news',array('cpid'=>$this->cpid)));
			}	
		}
		$this->renderWithId('newsAdd');
	}

	// 编辑新闻
	public function actionNewsEdit(){
		
		$id = Yii::app()->request->getParam('newsid');
		$model = new News();
		$news = $model->findByPk($id);

		if(isset($_POST)&& !empty($_POST)){
			$news->title = trim($_POST['title']);
			$news->classid = $_POST['classid'];
			$news->content = trim($_POST['content']);
			if($news->save()){
				$this->redirect($this->createUrl('/p/p2p/news',array('cpid'=>$this->cpid)));
			}
		}

		$this->renderWithId('newsEdit',array('news'=>$news));
	}

	// 删除新闻
	public function actionNewsDel(){
		$id = $_POST['id'];
		$model = new CompanyNews();
		if(empty($id)){
			echo json_encode(array('status'=>false,'msg'=>'非法操作!'));
		}

		$news_info = $model->findByPk($id);
		if($news_info->uid != Yii::app()->user->id){
			echo json_encode(array('status'=>false,'msg'=>'只能删除自己发表的新闻!'));
		}

		if($news_info->delete()){
			echo json_encode(array('status'=>true,'msg'=>'删除成功!'));
		}
	}

	// 新闻/公告列表页
	public function actionNews(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("pid = ".$this->cpid);
		$rows=Yii::app()->params['postnum'];
		$count = count(News::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';
		$news = News::model()->findAll($criteria);
		
		$this->renderWithId('news', array(
			'news' => $news,
			'pages'=>$pager,
			));

	}
	
	/**
	+--------------------------
	* 宣传图片模块
	+--------------------------
	**/
	public function actionPics(){
		
		$this->renderWithId('pics');
	}
	
	public function actionUpload(){
		
		$this->render('upload');
	}
	
	/**
	+--------------------------
	* 宣传图片模块
	+--------------------------
	**/
	public function actionVideo(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("cpid = ".$this->cpid);
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyVideo::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 'dateline desc';
		$video = CompanyVideo::model()->findAll($criteria);
		
		$this->renderWithId('video', array(
			'video' => $video,
			'pages'=>$pager,
			));
	}

	// 编辑视频
	public function actionVideoEdit(){
		$id = Yii::app()->request->getParam('id');
		$video = new CompanyVideo();
		if(!empty($id)){
			$video = $video->findByPk($id);
		}
		if(isset($_POST)&& !empty($_POST)){
			$video->title = trim($_POST['title']);
			$video->url = trim($_POST['url']);
			// 找到Url的来源网站
			preg_match("/^(http:\/\/)?([^\/]+)/i", trim($_POST['url']), $matches); 
			$video->source = $matches[2];
			$video->cpid = $this->cpid;
			if($video->save()){
				$this->redirect($this->createUrl('/p/p2p/video',array('cpid'=>$this->cpid)));
			}
		}
		$this->renderWithId('videoEdit',array('video'=>$video));
	}

	// 删除视频
	public function actionVideoDel(){
		$id = $_POST['id'];
		$model = new CompanyVideo();
		if(empty($id)){
			echo json_encode(array('status'=>false,'msg'=>'非法操作!'));
		}

		$video_info = $model->findByPk($id);
		if($video_info->uid != Yii::app()->user->id){
			echo json_encode(array('status'=>false,'msg'=>'只能删除自己发表的新闻!'));
		}

		if($video_info->delete()){
			echo json_encode(array('status'=>true,'msg'=>'删除成功!'));
		}
	}

	/**
	+--------------------------
	* 粉丝模块
	+--------------------------
	**/
	public function actionFans(){
		$order = Yii::app()->request->getParam('order','invitenum');
		$criteria = new CDbCriteria();
		$criteria->addCondition("cpid = ".$this->cpid);
		$criteria->order = $order . ' desc';
		$rows=Yii::app()->params['postnum'];
		$count = count(CompanyFollow::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$fans = CompanyFollow::model()->findAll($criteria);
		
		$this->renderWithId('fans', array(
			'fans' => $fans,
			'pages'=>$pager,
			'order' =>$order,
			));
	}

	/**
	+--------------------------
	* 接口管理
	+--------------------------
	**/
	public function actionApi(){
		if(($emp = CompanyEmployee::model()->find("uid = " . Yii::app()->user->id)) && $emp->department != 2){ // 如果不是技术部的不能进入
			$this->redirectMessage("接口管理只允许技术部进入" , Yii::app()->request->urlReferrer);
		}
		$companyApi = CompanyApi::model()->findByPk($this->cpid);
		if(! $companyApi){ // 如果不存在此公司的api信息，则插入一条到数据库
			$companyApi =  new CompanyApi();
			$companyApi->cpid = $this->cpid;
			$companyApi->save();
		}
		$this->renderWithId('api' , array(
				'companyApi' => $companyApi,
				));
	}

	// 设置api地址
	public function actionSetApi(){
		if(($emp = CompanyEmployee::model()->find("uid = " . Yii::app()->user->id)) && $emp->department != 2){ // 如果不是技术部的不能进入
			$this->redirectMessage("接口管理只允许技术部进入" , Yii::app()->request->urlReferrer);
		}
		$name = $_POST['name'];
		$val = trim($_POST['val']);
		if(!$name || !$val){
			$this->ajaxErrReturn("无效参数!");
		}
		CompanyApi::model()->updateByPk($this->cpid , array($name => $val));
		$this->ajaxSucReturn('设置成功!');	
	}

	// 接口调试
	public function actionApiTest(){
		if(($emp = CompanyEmployee::model()->find("uid = " . Yii::app()->user->id)) && $emp->department != 2){ // 如果不是技术部的不能进入
			$this->redirectMessage("接口管理只允许技术部进入" , Yii::app()->request->urlReferrer);
		}
		$declare = array(
			'relate_api' => array(
					'name' => '关联平台', // 抽奖名称
					'rule' => '传入手机号获取该手机对应的账户名', // 抽奖规则
					'args' => array('phone'), // 抽奖参数
					),
			'user_check' => array(
					'name' => '检测账户是否存在',
					'rule' => '传入用户填入的关联平台账户名，检测该用户名是否在第三方p2p平台存在',
					'args' => array('username'),
					),
			'lottery_api' => array(
					'name' => '活动自动发放红包/金币',
					'rule' => '抽奖活动自动发放红包/金币，传入类型，红包/金币值，用户名，返回10代表成功',
					'args' => array('type' , 'money' , 'username'),
					),
			);
		$companyApi = CompanyApi::model()->findByPk($this->cpid);
		if(! $companyApi){ // 防止新公司直接输入api调试地址
			$this->redirect($this->createUrl('/p/p2p/api' , array('cpid' => $this->cpid)));
		}
		$this->renderWithId('apiTest' , array(
					'declare' => json_encode($declare),
					'unjsonDeclare' => $declare,
					'companyApi' => $companyApi,
					));

	}

	// 访问api返回的结果
	public function actionApiResult(){
		// curlxxx
		$api = Yii::app()->request->getParam('api');
		$api_type = Yii::app()->request->getParam('api_type');
		if(! $api){
			$this->ajaxErrReturn("参数错误!");
		}
		$apiArr = explode('?key=' , $api);
		$api = $apiArr[0];
		$key = isset($apiArr[1]) ? $apiArr[1] : '';

		switch($api_type){
			case 'relate_api' : {
					$phone = Yii::app()->request->getParam('phone');
					$sign = md5($phone . $key);
					$api .= "?phone=$phone&sign=$sign";
				} break;
			case 'user_check' : {
					$username = Yii::app()->request->getParam('username');
					$sign = md5($username . $key);
					$api .= "?username=$username&sign=$sign";
				} break;
			case 'lottery_api' : {
					$type = Yii::app()->request->getParam('type');
					$money = Yii::app()->request->getParam('money');
					$username = Yii::app()->request->getParam('username');
					$sign = md5($key . $type . $money . $username );
					$api .= "?type=$type&money=$money&username=$username&sign=$sign";
				} break;
		}
		$curlResult = HCurl::newInstance()->url($api)->get();
		$this->ajaxSucReturn('' , $curlResult['data']);
	}
	/**
	+--------------------------
	* 联系我们
	+--------------------------
	**/
	public function actionSetComCoords(){
		$lat = $_POST['lat'];
		$lng = $_POST['lng'];
		if(Company::model()->updateByPk($this->cpid,array('lat'=>$lat,'lng'=>$lng))){
			echo json_encode(array('status'=>true, 'msg'=> "设置成功！"));
			exit();
		}
		echo json_encode(array('status'=>true , 'msg' => "操作失败!"));
	}


	// 联系我们
	public function actionContact(){
		$company = Company::model()->findByPk($this->cpid);

		if($company->lat=='0' && $company->lng=='0'){
			$json=file_get_contents("http://api.map.baidu.com/geocoder/v2/?ak=E4805d16520de693a3fe707cdc962045on&output=json&address=".$company ->city);
			$pos_arr=json_decode($json,true);	
			$company ->lat=$pos_arr['result']['location']['lat'];   //获取 经度
			$company ->lng=$pos_arr['result']['location']['lng'];  //获取纬度
		}		

		$this->renderWithId('contact',array('company'=>$company));
	}

	// 系统公告详细页
	public function actionNoticeView(){
		$newsid = Yii::app()->request->getParam('newsid');
		$notice = News::model()->findByPk($newsid);
		$this->renderWithId('noticeView' , array(
					'notice' => $notice,
					));

	}
}