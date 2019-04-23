<?php
/**
 * 第三方支付  公司
 *
 */
class BusinessController  extends Controller
{
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
        );
    }
    
    public function accessRules()
    {
        return array(
        	array('allow',
                'actions'=>array('view','index', 'list', 'news', 'captcha'),
            ),
            array('deny',
                'users'=>array('?'),
            ),
        );
    }
    
    //列表
	public function actionList(){
		//联合查询，查询出当前用户的公司
		$criteria = new CDbCriteria();  
		// $criteria->join = "JOIN k_business_service on t.bid=k_business_service.bid";  
		// $criteria->condition = "t.type = 1 AND t.status = 1 AND k_business_service.uid = ".Yii::app()->user->id;  
		$criteria->condition = "type = 1 AND status = 1";  

		$list = Business::model()->findAll($criteria); 
		$this->render('list', array('list'=>$list));
	}
    
    //首页
	public function actionIndex(){
		$id = (int)Yii::app()->request->getParam('id');
		$model = new Business();
		// 公司信息
		$business = $model->with('business_info')->with('business_service')->findByPk($id);
		//新闻信息
		$news = BusinessNews::model()->findAllByAttributes(array('bid'=>$id),array('limit'=>6));
		//业务员信息
		$members = BusinessService::model()->findAll(array(
				'condition'=>"status = 1 and  isadmin = 0 AND bid = ".$id,
				'order' => 'dateline desc',
				'limit' => '7',
				));
		//其他平台信息
		$companies = Company::model()->findAll(array(
			'condition' => "status = 2 and payid = ".$id,
			'limit' => 100,
			));

		$this->render('index',array(
			'business'=>$business,
			'news' => $news,
			'members' => $members,
			'companies' => $companies,
			));
	}
	
	//申请公司
	public function actionApply(){
		if(BusinessService::model()->exists(array('condition'=>'uid = '.Yii::app()->user->id))){
			$this->redirectMessage('您已经申请过其他支付平台或您已经是其他支付平台的业务员.', Yii::app()->request->urlReferrer);
		}

		if ( isset( $_POST['shortname'] ) ) {			
			$shortname = trim($_POST['shortname']);
			$name = trim($_POST['name']);
			$siteurl = trim($_POST['siteurl']);
			$address = trim($_POST['address']);
			$realname = trim($_POST['realname']);
			$mobile = trim($_POST['mobile']);
			$verifyCode = trim($_POST['verifyCode']);
			
			if (empty($shortname) || empty($name) || empty($siteurl) || empty($address) || empty($realname) || empty($mobile) || empty($verifyCode)) 
				$this->redirectMessage('请把信息填写完整', Yii::app()->request->urlReferrer);
			
			if ($this->createAction('captcha')->validate($verifyCode, true)) {
				$model = new Business();
				$model->attributes=array(
						'shortname'=> $shortname,
						'name'=> $name,
						);
				if ($model->validate() && $model->save()){
					$this->redirectMessage('申请成功，等待审核', $this->createUrl('business/index' , array('id' => $model->bid)) , 'success');	
				}
				$this->redirectMessage('信息错误', Yii::app()->request->urlReferrer);
			}	
		}
		$this->render('apply');
	}
	
	//新闻列表
	public function actionNews(){
		$id = (int)Yii::app()->request->getParam('id');
		if (empty($id))
			$this->redirectMessage('第三方平台', Yii::app()->request->urlReferrer);
		
		$business = Business::model()->findByPk($id);

		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$count = count(BusinessNews::model()->findAll()); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->addCondition("bid = ".$id);
		$news = BusinessNews::model()->findAll($criteria);
		
		$this->render('news', array(
			'news' => $news,
			'business' => $business,
			'pages'=>$pager,
			'bid' => $id,
			));
	}
	
	//新闻
	public function actionView(){
		$id = (int)Yii::app()->request->getParam('id');
		if(!$id){
			throw new CHttpException("您所访问的页面不存在!");
		}
		//文章内容
		$news = BusinessNews::model()->findByPk($id);
		
		//平台信息
		$business = Business::model()->findByPk($news->bid);
		
		//最新文章内容 
		$lastestNews = BusinessNews::model()->findAll(array(
							'condition'=>'bid = :bid',
							'params'=>array(':bid'=>$news->bid),
							'limit'=>7,
							'order'=>'dateline desc',
							));
		$this->render('view',array(
				'news' => $news,
				'business' => $business,
				'lastestNews' => $lastestNews,
				));
	}
	

	/**
	+
	* 业务员模块
	+
	**/
	//  申请加入业务员
	public function actionJoin(){
		$model = new BusinessService();
		$bid = (int)Yii::app()->request->getParam('bid');
		$service_info = $model->findByAttributes(array('bid'=>$bid));
		if($model->exists(array('condition'=>'uid = '.Yii::app()->user->id))){
			$this->redirectMessage('您已经是其他支付平台的业务员！', Yii::app()->request->urlReferrer);
		}
		if(isset($_POST) && !empty($_POST)){
			$model->bid = $bid;
			$model->mobile = $_POST['mobile'];
			$model->realname = $_POST['realname'];
			$model->qq = $_POST['qq'];
			$model->remark = $_POST['remark'];
			$model->status = 0;
			$model->isshow = 1;
			$model->pic = ' ';
			$model->department = 1;
			$model->isadmin = 0;
			$model->opuid = 0;
			if($model->save()){	
				$this->redirect($this->createUrl('/business/index',array('id'=>$bid)));
				exit();
			}
		}
		$this->render('join',array('service_info'=>$service_info));
	}

	
}