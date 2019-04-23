<?php
class AuthController extends Controller{
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
	
	public function actionIndex(){
		$criteria = new CDbCriteria();
		$criteria->condition = "t.status = 0";
		$authApplyModel=AuthApply::model(); 	
		$criteria->order='t.dateline asc';		
		$tatal=$authApplyModel->count();  //记录总数
		$pager = new CPagination($tatal); 
		$pager->pageSize = 10;   //设置每页显示条数          
		$pager->applyLimit($criteria); 

		$applies=$authApplyModel->with('member')->with('member_info')->findAll($criteria);


		$this->render('index',array(
			'applies'=>$applies,
			'pages'=>$pager,
		));
	}
	
	/* 编辑平台 */
	public function actionEdit($id){
		$authApply=AuthApply::model();
		$apply=$authApply->findByPk($id);

		if(isset($_POST['Company'])){   //post提交数据
			$data=$_POST['Company'];
			$data['vip_time']=strtotime($_POST['Company']['vip_time']);  //VIP到期时间
			$data['resideprovinceid']=$_POST['resideprovinceid'];  //省ID
			$data['cityid']=$_POST['cityid'];   //市ID

			$dataInfo=$_POST['CompanyInfo'];  //信息表
			$company_infoModel=CompanyInfo::model();

			$modify_company_info_res=$company_infoModel->updateByPk($cpid,$dataInfo);
			$modify_company_res=$companyModel->updateByPk($cpid,$data);

			if($modify_company_info_res||$modify_company_res){
				echo json_encode(array('status'=>1,'info'=>'平台修改成功','url'=>Yii::app()->params['url'].'company/index'));
		    		exit();
			}else{
				echo json_encode(array('status'=>0,'info'=>'平台修改失败','url'=>Yii::app()->params['url'].'company/index'));
		    		exit();
			}
		}

		$this->render('edit',array('companyInfo'=>$companyInfo));
	}

	/* 修改是否开通 */
	public function actionStatus(){
		$value=$_POST['value'];
		$id=$_POST['id'];
		$data['status']=$value;
		$authApply=AuthApply::model();
		$res=$authApply->updateByPk($id,$data);
		// 修改申请信息状态后修改用户实名认证状态,此处个人信息验证状态为0 ，1 ， 2
		$uid = AuthApply::model()->findByPk($id)->uid;
		Member::model()->updateByPk($uid , array('realstatus'=>$value+1));
		if($res){
			echo 1;
		}else{
			echo 2;
		}		
	}

	/* 平台信息显示 */
	public function actionShowInfo($id){
		$authApply=AuthApply::model()->findByPk($id);
		$this->render('show_info',array('authApply'=>$authApply));
	}
}