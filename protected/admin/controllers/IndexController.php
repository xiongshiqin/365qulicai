<?php
/**
 * index
 * 首页 广场
 */
class IndexController extends Controller{	
	public function actions()
	{
		return array(
			'captcha'=>array(
				'class'=>'system.web.widgets.captcha.CCaptchaAction',
				'height'=>38,
				'width'=>55,
				'minLength'=>4,
				'maxLength'=>4
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
    
    public function accessRules()
    {
        return array(
        	array('allow',
                'actions'=>array('login', 'captcha'),
            ),
            array('deny',
                'users'=>array('?'),
            ),
        );
    }
    
	public function actionIndex(){
		$this->render('index');	
	}
	
	//用户
	public function actionUser(){
		$page=intval($_GET['page']);
		$page=$page ? $page : 1;
		$rows=10;
		$start=($page-1) * $rows;
		
		$criteria = new CDbCriteria();      
        $count = Member::model()->count($criteria); 
        
        $pager = new CPagination($count);    
        $pager->pageSize = $rows;         
		
		$users=Member::model()->findAll(array(
			'offset'=>$start,
			'limit'=>$rows,
			'order'=>'uid desc',
		));
		
		$this->render('user',array(
			'users'=>$users,
			'pages'=>$pager,
		));	
	}
	
	//积分
	public function actionCredit(){
		if (isset($_POST) && isset($_POST['content'])) {
			$id = intval($_POST['id']);//echoprint_r($_POST);echo Yii::app()->request->getParam('content');exit;
			$model = $id ? CreditRule::model()->findByPk($id) : new CreditRule();
			if ($_POST['content']) {
				$model->content = trim($_POST['content']);
			}
			$model->class = intval($_POST['class']);
			$model->num = intval($_POST['num']);
			
			$model->validate() && $model->save();
		}elseif (isset($_GET['id']) && $_GET['id']){
			CreditRule::model()->findByPk(intval($_POST['id']))->delete();
		}
		
		
		$creditList = CreditRule::model()->findAll(array(
			
		));
		
		$this->render('credit',array('creditList'=>$creditList));
	}
	
	
	public function actionLogin(){
		if(!Yii::app()->user->isGuest)
			$this->redirect(array('index/index'));
		
		if(Yii::app()->user->hasFlash('success'))
			Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success')); 
		if(Yii::app()->user->hasFlash('error'))
			Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')); 
			
		$model=new LoginForm();
		
		if (! empty($_POST['LoginForm'])){
			$model->attributes=$_POST['LoginForm'];
			
			if ($model->validate() && $model->login()){
				
				$this->redirect(Yii::app ()->user->returnUrl);
			}else {
				if ($model->hasErrors ()){
					$errs = $model->getErrors();
					Yii::app()->user->setFlash('error', $errs['error'][0]); 
				}
			}
			$this->refresh();
		}
				
		$this->renderPartial('login', array('model'=>$model) );
	}
	
	//退出
	public function actionLogout(){
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->user->loginUrl);
			
		Yii::app()->user->logout(0);
		
		if(Yii::app()->user->hasFlash('success'))
			Yii::app()->user->setFlash('success', Yii::app()->user->getFlash('success')); 
		if(Yii::app()->user->hasFlash('error'))
			Yii::app()->user->setFlash('error', Yii::app()->user->getFlash('error')); 
		
		$this->redirect(Yii::app()->user->loginUrl);
	}
	//邀请码
	public function actionInvitecode(){
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->user->loginUrl);
			
		if ($_POST) {
			$num = intval($_POST['num']);
			$num = $num <= 0 ? 5 : $num;
			$dateline = time();
			
			$invitecode = HComm::getInviteCode($num);
			
			$sql = 'INSERT INTO {{invite_code}} (code,dateline) VALUES';
			if (1==$num) {
				$sql .= "('".$invitecode."', $dateline)";
			}else {
				foreach ($invitecode as $key => $value) {
					$sql .= $key==0 ? "('".$value."', $dateline)" : ",('".$value."', $dateline)";
				}
			}
			$connection=Yii::app()->db; 
			$command=$connection->createCommand($sql);
			$command->execute();
		}
		
		$page=intval($_GET['page']);
		$page=$page ? $page : 1;
		$rows=30;
		$start=($page-1) * $rows;
		
		$criteria = new CDbCriteria();      
        $count = InviteCode::model()->count($criteria); 
        
        $pager = new CPagination($count);    
        $pager->pageSize = $rows;         
		
		$list = InviteCode::model()->findAll(array(
			'offset'=>$start,
			'limit'=>$rows,
			'order'=>'id ASC',
		));
		
		$this->render('invitecode', array(
			'list'=>$list,
			'pages'=>$pager,
		));
	}
}