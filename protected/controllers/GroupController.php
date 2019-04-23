<?php
class GroupController  extends Controller
{
	protected $_identidy = -2;  //默认小组身份为游客
	protected $_group = null;
	
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0x55FF00,
				'padding'=>0,
				'height'=>50, 
				'maxLength'=>4,
				'minLength'=>4,
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
			);
	}

	private function _init($gid=0){
		$this->_getGroup($gid);
		$this->_getIdentidy();

	}

	public function accessRules()
	{
		return array(
		
			array('allow',
				'actions'=>array('view','index','reply', 'list', 'hot', 'member', 'captcha' , 'like'),
				),
		
			array('deny',
				'users'=>array('?'),
				),
			);
	}
	
	public function actionIndex(){
		$this->_init();
		
		$rows=Yii::app()->params['postnum'];
		$condition = 'gid=:gid';
		$params = array(':gid'=>$this->_group->gid);

		$criteria = new CDbCriteria();    
		$criteria->condition = $condition;  
		$criteria->params = $params; 
		$count = GroupTopic::model()->count($criteria); 
		$pager = new CPagination($count);    
		$pager->pageSize = $rows;
		$pager->applyLimit($criteria);
		$criteria->order = 'dateline desc';

		$topic = GroupTopic::model()->findAll($criteria);

		
		$member = GroupUser::model()->findAll(array(
			'condition'=>'gid=:gid',
			'params'=>array(':gid'=>$this->_group->gid),
			'limit'=>8,
			'order'=>'dateline desc',
			));
		
		$manage = GroupUser::model()->findAll(array(
			'condition'=>'gid=:gid AND `identidy` >= 8',
			'params'=>array(':gid'=>$this->_group->gid),
			'order'=>'identidy desc',
			));

		$this->pageTitle = $this->_group->name . '_投资交流_理财派社区';

		$this->render('index', array(
			'topic'=>$topic,
			'member'=>$member,
			'manage'=>$manage,
			'pages' => $pager,
			));
	}
	
	public function  actionView(){
		$id = (int)Yii::app()->request->getParam('id');
		$topicid=intval($_GET['id']);		
		if($expandCpid = Yii::app()->request->getParam('cpid' , 0)){ // 是否为推广新闻连接进来的
			$cookie = new CHttpCookie('expandCpid' , $expandCpid);
			$cookie->expire = time() + 60*30;  //有限期30分钟
			Yii::app()->request->cookies['expandCpid'] = $cookie;
		}
		if (empty($topicid))
			$this->redirectMessage('参数错误，帖子不存在', Yii::app()->request->urlReferrer);
		
		$page=intval(Yii::app()->request->getParam('page'));
		$page=$page ? $page : 1;
		$rows=Yii::app()->params['postnum'];
		$start=($page-1) * $rows;
		
		$criteria = new CDbCriteria();  
		$criteria->condition = 'topicid=:topicid';
		$criteria->params = array(':topicid'=>$topicid);        
		$count = GroupPost::model()->count($criteria); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$post = GroupPost::model()->findAll(array(
			'condition'=>'topicid=:topicid',
			'params'=>array(':topicid'=>$topicid),
			'limit'=>$rows,
			'offset'=>$start,
			'order'=>'dateline asc',
			));
		
		$topic =GroupTopic::model()->findByPk($topicid);
		$cookies = Yii::app()->request->getCookies();
		if (! isset($cookies['topic'.$id])) {
			$topic->viewnum = $topic->viewnum + 1;
			$topic->save();	
			
			$cookie = new CHttpCookie('topic'.$id, 1);
			$cookie->expire = time()+60*5;  //5分钟增加浏览次数1次
			Yii::app()->request->cookies['topic'.$id] = $cookie;
		}
		
		
		$this->_init($topic->gid);
		
		$this->pageTitle = $topic->title . '_' . $this->_group->name . '_理财派社区';

		$this->render('view', array(
			'topic' => $topic,
			'post'=>$post,
			'pages'=>$pager,
			'page'=>$page,
			));
	}
	
	
	public function  actionList(){
		$this->render('list');
	}
	
	//热门
	public function  actionHot(){
		$topic = GroupTopic::model()->with('post')->findAll(array(
			'limit'=>10,
			'order'=>'dateline desc',
		));
		$group = Group::model()->findAll();

		$this->pageTitle = '网贷投资交流_理财派社区';
		
		$this->render('hot',array(
			'topic'=>$topic,
			'group'=>$group,
			));
	}
	
	//myGroup
	public function  actionMygroup(){
		// 我管理的小组 
		$manageGroup =  GroupUser::model()->with('group')->findAll(array(
				'condition'=>'identidy >=8 and uid=:uid',
				'params'=>array(':uid'=>Yii::app()->user->id),
				'order'=>'identidy desc',
				));

		//  我加入的小组
		$list = GroupUser::model()->with('group')->findAll(array(
			'condition'=>'uid=:uid',
			'params'=>array(':uid'=>Yii::app()->user->id),
			'order'=>'identidy desc',
			));
		
		$this->render('mygroup', array(
				'manageGroup' => $manageGroup,
				'list'=>$list,
				));
	}
	
	//回复
	public function  actionReply(){
		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn('needLogin');
		}
		$this->_init();

		if($this->_identidy < 1 ){
			$this->ajaxErrReturn('加入小组后才可回复');
		}
		if ($_POST) {
			$topicid = (int)Yii::app()->request->getParam('topicid');
			$this->_init();
			
			$content = HComm::Ahtmlspecialchars($_POST['content']);
			if ($content) {
				$model = new GroupPost();
				$model->topicid = $topicid;
				$model->gid = $this->_group->gid;
				$model->content = $content;
				
				if ($model->validate() && $model->save()) {
					HComm::updateCredit('reply_topic');
					GroupUser::model()->find(array(
						'condition'=>'uid=:uid AND gid=:gid',
						'params'=>array(':uid'=>Yii::app()->user->id, ':gid'=>$this->_group->gid),
						))->saveCounters(array('credit'=>Yii::app()->params['params_credit']['credit']['reply_topic'][2]));
					$this->ajaxSucReturn('添加成功' , $model);
				}
			}
		}
		$this->ajaxErrReturn('请把信息填写完整');
	}
	
	//发布话题
	public function  actionAdd(){
		$this->_init();
		if($this->_identidy < 1 ){
			$this->redirectMessage('加入小组后才可发贴' , Yii::app()->request->urlReferrer);
		}
		if ($_POST) {
			$title = HComm::Ahtmlspecialchars($_POST['title']);
			$content = htmlspecialchars($_POST['content']); // content好像没用
			$verifyCode = trim($_POST['verifyCode']);
			
			if ($title && $content && $verifyCode) {
				$model = new GroupTopic();
				if(  $this->createAction('captcha')->validate($verifyCode, true)){
					$model->attributes=array(
						'gid'=> $this->_group->gid,
						'title'=> $title,
						);
					if ($model->validate() && $model->save()) {
						//添加积分
						HComm::updateCredit('add_topic');
						GroupUser::model()->find(array(
							'condition'=>'uid=:uid AND gid=:gid',
							'params'=>array(':uid'=>Yii::app()->user->id, ':gid'=>$this->_group->gid),
							))->saveCounters(array('credit'=>Yii::app()->params['params_credit']['credit']['add_topic'][2]));

						$this->redirectMessage('添加成功', $this->createUrl('group/view', array('id'=>$model->topicid)) , 'success');
					}
				}else {
					$this->redirectMessage('验证码错误', Yii::app()->request->urlReferrer);
				}
			}
			$this->redirectMessage('请把信息填写完整', Yii::app()->request->urlReferrer);
		}
		
		$this->render('add');
	}
	
	// 编辑帖子
	public function actionEditTopic(){
		$this->_init();
		$id = (int)Yii::app()->request->getParam('id');
		$topic = GroupTopic::model()->findByPk($id);
		if(!$topic && $topic->uid != Yii::app()->user->id){
			$this->redirectMessage("只能编辑自己发表的帖子" , Yii::app()->request->urlReferrer);
		}
		if(!empty($_POST['postid'])){
			$postid = (int)$_POST['postid'];
			$content =HComm::Ahtmlspecialchars($_POST['content']);
			GroupPost::model()->updateByPk((int)$_POST['postid'] , array('content'=>$content));
			$this->redirectMessage("修改成功！" , $this->createUrl('/group/view' , array('id'=>$id)) , '3' , 'success');
			exit();
		}
		$post = GroupPost::model()->find(array(
			'condition'=>'topicid=' . $id,
			'order'=>'dateline asc',
			));

		$this->render("editTopic" , array(
				'post' => $post,
					));
	}

	public function  actionMember(){
		$this->_init();
		
		$member = GroupUser::model()->findAll(array(
			'condition'=>'gid=:gid AND `identidy` < 8',
			'params'=>array(':gid'=>$this->_group->gid),
			'limit'=>100,
			'order'=>'dateline desc',
			));
		
		$manage = GroupUser::model()->findAll(array(
			'condition'=>'gid=:gid AND `identidy` >= 8',
			'params'=>array(':gid'=>$this->_group->gid),
			'order'=>'identidy desc',
			));		
		
		$this->render('member', array(
			'member'=>$member,
			'manage'=>$manage,
			));
	}
	
	public function actionLike(){
		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn('needLogin');
		}
		$tid = (int)Yii::app()->request->getParam('tid');
		$pid = (int)Yii::app()->request->getParam('pid');
		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn('needLogin');
		}
		$Like = new Like;
		if ($tid) {			
			$re = $Like->add('topic', $tid);
		}elseif ($pid){
			$re = $Like->add('post', $pid);
		}
		if(Yii::app()->user->getFlash('ding')){
			$this->ajaxSucReturn();
		}
		$this->ajaxErrReturn('已经顶过了');
	}
	
	public function actionDel(){
		$postid = (int)Yii::app()->request->getParam('postid');
		$postid && $post = GroupPost::model()->findByPk($postid);
		$post && $this->_init($post->gid);
		if ($post->uid == Yii::app()->user->id || $this->_identidy>=8) {
			$post->del = 1;
			$post->save();
		}
		
		$this->redirect(Yii::app()->request->urlReferrer);
	}
	
	//创建
	public function actionCreate(){
		if ($_POST) {
			$name = HComm::Ahtmlspecialchars($_POST['name']);
			$info = HComm::Ahtmlspecialchars($_POST['info']);
			$verifyCode = trim($_POST['verifyCode']);
			
			if ($name && $info && $verifyCode) {
				$model=new Group();
				if(  $this->createAction('captcha')->validate($verifyCode, true)){
					$model->attributes=array(
						'name'=> $name,
						'info'=> $info,
						'class'=> 1,				
						);
					if ($model->validate() && $model->save()) {
						$this->redirectMessage('添加成功', $this->createUrl('group/index' , array('gid' => $model->gid)) , 'success');
					}
				}else {
					$this->redirectMessage('验证码错误', Yii::app()->request->urlReferrer);
				}
			}
			
			$this->redirectMessage('请把信息填写完整', Yii::app()->request->urlReferrer);
		}
		$this->render('create');
	}
	
	public function actionManage(){
		$this->_init();
		if ($_POST) {
			$this->_group->info = HComm::Ahtmlspecialchars($_POST['info']);
			$this->_group->save();
			$this->redirectMessage('更新成功', $this->createUrl('group/index',array('gid'=>$this->_group->gid)) , 'success');
		}
		
		$this->render('manage');
	}
	
	//join
	public function  actionJoin(){
		$this->_init();
		if ($this->_identidy == -2) {
			$groupuser = new GroupUser;
			$groupuser->join();
		}
		
		$this->redirect(Yii::app()->request->urlReferrer);
	}
	
	public function  actionUnJoin(){
		$this->_init();
		if ($this->_identidy >0 ) {
			$GroupUser = GroupUser::model()->find(array(
				'condition'=>'uid=:uid AND gid=:gid',
				'params'=>array(':uid'=>Yii::app()->user->id, ':gid'=>$this->_group->gid),
				));
			$GroupUser->delete();
		}
		$this->redirect(Yii::app()->request->urlReferrer);
	}
	
	// 踢出成员
	public function actionRemMember(){
		$this->_init();
		$muid = Yii::app()->request->getParam('muid');
		if(!$muid || !is_numeric($muid)){
			$this->redirectMessage('参数错误!' , Yii::app()->request->urlReferrer);
		}
		if($this->_identidy >= 9){
			$GroupUser = GroupUser::model()->find(array(
				'condition'=>'uid=:uid AND gid=:gid',
				'params'=>array(':uid'=>$muid, ':gid'=>$this->_group->gid),
				));
			$GroupUser->delete();
		}
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	// 设置副组长
	public function actionSetDeputyLeader(){
		$this->_init();
		$muid = Yii::app()->request->getParam('muid');
		if(!$muid || !is_numeric($muid)){
			$this->redirectMessage('参数错误!' , Yii::app()->request->urlReferrer);
		}
		if($this->_identidy >=9){
			if(GroupUser::model()->count("identidy = 8 and gid = " . $this->_group->gid) >= 4){
				$this->redirectMessage('副组长不能超过4个' , Yii::app()->request->urlReferrer);
			}
			GroupUser::model()->updateAll(array('identidy'=>8) , "uid = $muid and gid = " . $this->_group->gid);
		}
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	//查看小组是否存在
	private function _getGroup($gid = 0){
		$gid =  $gid ? $gid : (int)Yii::app()->request->getParam('gid');
		if($this->_group===null)
		{
			if($gid)
			{
				$this->_group = Group::model()->find(array(
					'condition'=>'gid=:gid',
					'params'=>array(':gid'=>$gid),
					));
			}
			$this->_group || $this->redirectMessage('参数错误，小组不存在', Yii::app()->request->urlReferrer);
		}
		return $this->_group;		
		
	}
	
	//获得身份
	private function _getIdentidy(){
		if (Yii::app()->user->id) {
			$identidy = GroupUser::model()->find(array(
				'select'=>'identidy',
				'condition'=>'uid=:uid AND gid=:gid',
				'params'=>array(':uid'=>Yii::app()->user->id, ':gid'=>$this->_group->gid),
				));
			$this->_identidy = isset($identidy->identidy) ? $identidy->identidy : $this->_identidy;
		}
	}
}