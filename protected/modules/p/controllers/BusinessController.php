<?php
/**
 * 公司 后台页面
 *
 */
class BusinessController  extends Controller
{
	private $id; // 保存当前访问的第三方平台id
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
			'accessCheck + index,buzIntro,news,member,checkMem,invite,inviteApply',
			);
	}

	//  如果执行下面这几个action ，则要判断当前的business是否为当前登录的用户管理的
	public function filterAccessCheck($filterChain){
		$this->id = (int)Yii::app()->request->getParam('id');
		if(! BusinessService::model()->exists("bid = " . $this->id . " and uid = " . Yii::app()->user->id)){
			throw new CHttpException("非法操作!");
		}
		$filterChain->run(); //加参数filterChain和这句话，才会再执行完filter后继续执行下面的action
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('*'),
			),
		);
	}
	
	/**
	+
	*   基本信息模块
	+
	**/
	// 显示公司基本信息
	public function actionIndex(){
		$model = new Business();
		$business_info = $model->with('business_info')->findByPk($this->id);
		if(isset($_POST) && !empty($_POST)){
			$business_info->shortname = $_POST['shortname'];
			$business_info->name = $_POST['name'];
			if($business_info->save()){
				$this->redirect($this->createUrl('/p/business/index',array('id'=>$business_info->bid)));
			}
		}
	
		$this->render('index', array('business_info'=>$business_info));
	}

	// 公司简介
	public function actionBuzIntro(){
		$business_info = BusinessInfo::model()->findByAttributes(array('bid'=>$this->id));
		if(isset($_POST) && !empty($_POST)){
			$business_info->info = $_POST['info'];
			$business_info->mainbissness = $_POST['mainbisness'];
			if($business_info->save()){
				$this->redirect($this->createUrl('/p/business/buzIntro', array('id'=>$this->id)));
			}
		}
		$this->render('buz_intro',array('business_info'=>$business_info));
	}

	public function actionSetWeixin(){
		//文件保存路径 
		$savepath = date('Y/m/d',time());

		//调用扩展
		$avatar = $this->Widget('application.extensions.avatar.avatar', array(
		//'uploadurl' => '.',
		//'upload' => '/uploads/',
		'savepath'  => $savepath,
		'max_size'  => 300000,
		'fileElementName' => $_REQUEST['id'],
		'file_ext' => 'image',
		'type' => 'image',
		'iscut' => true,
		'thumbname' => 'avatar',
		'cutsize' => array('212'=>array(212,212),'big'=>array(112,112),'middle'=>array(48,48),'small'=>array(36,36),'micro'=>array(24,24)),
		));
		echo $avatar->Fileupload();
	}
	/**
	+
	*   新闻模块
	+
	**/
	//新闻
	public function actionNews(){
		$id = $this->id = (int)Yii::app()->request->getParam('id');
		if (empty($id))
			$this->redirectMessage('第三方平台', Yii::app()->request->urlReferrer);
		
		$criteria = new CDbCriteria();
		$rows     = Yii::app()->params['postnum'];
		$count    = count(BusinessNews::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->addCondition("bid = ".$id);
		$news = BusinessNews::model()->findAll($criteria);
		
		$this->render('news', array(
			'news'  => $news,
			'pages' => $pager,
			'comId' => $id,
			));
	}
	
	// 添加新闻
	public function actionNewsAdd(){
		$model = new BusinessNews();
		$id = $comId = $_REQUEST['comId'];
		if ( isset( $_POST['NewsForm'] ) ) {
			$model->attributes = $_POST['NewsForm'];
			$model-> bid = $comId;
			$model->uid = Yii::app()->user->id;
			$model->username = Yii::app()->user->name;
			$model->viewnum = 1;
			$model->order = 1;
			$model->dateline = time();
			if ($model->save() ) {
				$this->redirect($this->createUrl('/p/business/news',array('id'=>$comId)));
			}
		}
		$this->render( 'news_add', array ( 'model' => $model ,'comId'=>$comId,  ) );
	}

	// 修改新闻
	public function actionNewsEdit($id){

		$model = new BusinessNews(); 
		$news_info = $model -> findByPk($id);

		if(isset($_POST['NewsForm'])){
			foreach($_POST['NewsForm'] as $_k => $_v){
				$news_info -> $_k = $_v;
			}

			if($news_info -> save()){
				$this -> redirect($this->createUrl('/p/business/news',array('id'=>$news_info->bid)));
			}
		}else{
			$this ->render('news_edit', array('news_info'=>$news_info));
		}
	}

	// 删除新闻
	public function actionNewsDel(){
		$id = $_POST['id'];
		$model = new BusinessNews();
		if(empty($id)){
			$this->ajaxErrReturn('非法操作!');
		}

		$news_info = $model->findByPk($id);
		if($news_info->uid != Yii::app()->user->id){
			$this->ajaxErrReturn('只能删除自己发表的新闻!');
		}

		if($news_info->delete()){
			$this->ajaxSucReturn('删除成功!');
		}
	}

	/**
	+
	*  人员模块
	+
	**///人员
	public function actionMember(){
		$status = Yii::app()->request->getParam('status'); // 过滤条件，是申请中还是业务人员
		if($status == null){
			$status = 0;
		}
		if(!$this->id){
			throw new CHttpException('此页面不存在');
		}

		$criteria=new CDbCriteria;
		$criteria->addCondition("bid = ".$this->id);
		$criteria->addCondition("status = ".$status);
		$criteria->addCondition("isshow = 1");

		$rows=Yii::app()->params['postnum'];
		// $rows = 1;
		$count = BusinessService::model()->count($criteria); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$members = BusinessService::model()->findAll($criteria);

		$this->render('member',array(
			'members'=>$members,
			'pages' => $pager,
			'status' => $status,
			'id' => $this->id,
			));
	}

	// 审核人员
	public function actionCheckMem(){
		$field = $_POST['field'];
		$val = $_POST['val'];
		$sid = $_POST['sid'];
		// 检测当前操作的对象是否为自己的
		if(BusinessService::model()->findByAttributes(array('bid'=>$this->id , 'isadmin'=>1))->uid != Yii::app()->user->id){
			$this->ajaxErrReturn('非法操作!');
		}
		if(!in_array($field,array('status','isshow'))){
			throw new ExceptionClass("hacker deny!");
		}

		$member_info = BusinessService::model()->findByPk($sid);
		$member_info->$field = $val;
		if($member_info->save()){
			$this->ajaxSucReturn('操作成功!');
		}

	}

	/**
	+
	*   邀请码模块
	+
	**/
	//邀请码
	public function actionInvite(){
		$status = Yii::app()->request->getParam('status');
		if($status == null){
			$status = 0;
		}

		$criteria = new CDbCriteria;
		$criteria->addCondition("status = $status and uid = " . Yii::app()->user->id);
		$rows = Yii::app()->params['postnum'];
		$count = InviteCode::model()->count($criteria); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$invites = InviteCode::model()->findAll($criteria);

		$render = 'invite';
		if($status == 1){
			$render = 'invite_used';
		}
		$this->render($render,array(
			'invites'=>$invites,
			'pages' => $pager,
			'comId' =>$this->id,
			));
	}

	// 申请邀请码
	public function actionInviteApply(){
		$model = new InviteCode();
		if($model->countByAttributes( array('uid'=>Yii::app()->user->id,'status'=>0)) >= 3){
			$this->ajaxErrReturn('您还有3条以上的可用邀请码!');
		} 

		$model->code = $model->createInvite();
		$code = $model->createInvite();
		while($model->countByAttributes(array('code'=>$code)) >= 1){
			$code = $model->createInvite();
		}
		$model->code = $code;
		$model->class = 2;
		$model->pid = $this->id;
		if($model->save()){
			$this->ajaxSucReturn('操作成功!');
		}
		$this->ajaxErrReturn('服务器正忙，请稍后重试!');
	}
	
}