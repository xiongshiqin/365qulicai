<?php
/*
*邀请码控制器
*/
class InviteCodeController extends Controller{
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
	
	/* 邀请码列表显示 */
	public function actionIndex(){
		$cri = new CDbCriteria();   //查询所有记录
		$inviteCodeModel=InviteCode::model();
		$status=isset($_GET['status'])?$_GET['status']:0;
		$class=isset($_GET['class'])?$_GET['class']:1;
		$cri ->condition="status=$status and class=$class";

		$total=count($inviteCodeModel->findAll($cri));		
		$pager = new CPagination($total);  //实例化分页类
		$pager->pageSize = 10;   //设置每页显示条数
		$pager->applyLimit($cri);

		$inviteCodeInfo=$inviteCodeModel->findAll($cri);
		$this->render('index',array('inviteCodeInfo'=>$inviteCodeInfo,'pages'=>$pager,'class'=>$class,'status'=>$status));
	}
	/* 申请邀请码 */
	public function actionApply(){
		$class=$_POST['class'];
		for($i=0;$i<5;$i++){
			$model = new InviteCode();
			$code = $model->createInvite();
			while($model->countByAttributes(array('code'=>$code)) >= 1){
				$code = $model->createInvite();
			}
			$model->code = $code;
			$model->class=$class;
			$save_res=$model->save();	
		}
		if($save_res){
			echo json_encode(array('status'=>true,'msg'=>'操作成功!'));
			exit();
		}

		echo json_encode(array('status'=>false,'msg'=>'服务器正忙，请稍后重试!'));
	}
}