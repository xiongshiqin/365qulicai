<?php
/*
*帖子管理控制器
*/
class BusinessController extends Controller{
	public function filters(){
		return array(
			'accessControl',
			);
	}
	
	public function accessRules(){
		return array(
		  	  array('deny', 
			            'users'=>array('?'),  
			        ),  
		);
	}
	
	//所有帖子列表显示
	public function actionIndex(){
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$count = count(Business::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$business = Business::model()->with('business_info')->findAll($criteria);
		$this->render('index',array('business'=>$business,'pages'=>$pager));
	}

	//添加支付平台 
	public function actionEdit(){    // 此方法作废，现在不可用
		$bid = Yii::app()->request->getParam('bid');
		// $business = new Business(); //不能在后台添加business
		// if($bid){
			$business = Business::model()->with('business_info')->findByPk($bid);
		// }
		if(!empty($_POST)){
			$business->shortname = trim($_POST['shortname']);
			$business->name = trim($_POST['name']);
			if($business->save()){
				$this->redirect(array('/business/index'));
			}
		}
		$this->render('edit' , array('business' => $business));
	}

	//生成邀请平台入驻url
	public function actionInviteUrl(){
		// 获取当前第三方支付平台列表
		$business = Business::model()->findAll();
		if(!empty($_POST)){
			$uid = trim($_POST['uid']);
			$bid = $_POST['bid'];
			$vali_time = (int)$_POST['vali_time'];
			if($vali_time < 1){
				$vali_time = 1;
			}

			$inviteCode = new InviteCode();
			$inviteCode->uid = $uid;
			$inviteCode->pid = $bid;
			$inviteCode->class = 3;
			$inviteCode->code = $inviteCode->createInvite();
			// 这里有一个有效期限制，此处用dateline来表示，小于dateline表示可用
			$inviteCode->dateline = time() + $vali_time*24*3600;
			if($inviteCode->save()){
				$this->redirect(array('/business/urlList'));
			}
		}
		$this->render('inviteUrl' , array('business'=>$business));
	}

	// url列表
	public function actionUrlList(){
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		$criteria->condition ="class = 3";
		$count = count(InviteCode::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$codes = InviteCode::model()->findAll($criteria);
		$this->render('urlList',array('codes'=>$codes,'pages'=>$pager));
	}


}
