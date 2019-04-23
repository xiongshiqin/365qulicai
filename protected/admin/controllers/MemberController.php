<?php
/*
*后台会员控制器
*/
class MemberController extends Controller{
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
	
	public function actionIndex(){     //会员列表显示
		$memberMode=Member::model();
		$cri = new CDbCriteria();   //查询所有记录
		$total = $memberMode->count();   //总条数
		$pager = new CPagination($total);  //实例化分页类
		$pager->pageSize = 10;   //设置每页显示条数
		$pager->applyLimit($cri);
		$memberInfo=$memberMode->findAll($cri );  //查询总数
		//p($memberInfo);

		$data=array(
			'memberInfo'=>$memberInfo,
			'pages'	=> $pager,
		);
		$this->render('index',$data);
	}
	/* 编辑会员 */
	public function actionEdit($uid){
		$memberModel=Member::model();
		$member=$memberModel->findByPk($uid);


		if(isset($_POST['Member'])){    /* post提交 */
			
			/* 修改会员表 */
			$member->attributes=$_POST['Member'];
			$member_res=$member->save();   //此时save是修改

			/* 修改会员计数表 */
			$memberCount = MemberCount::model()->findByPk($uid);
			$memberCount->attributes=$_POST['MemberCount'];
		    	$memberCount_res=$memberCount->save();

		    	/* 修改会员信息表 */
		    	$memberInfo = MemberInfo::model()->findByPk($uid);
			$memberInfo->attributes=$_POST['MemberInfo'];
			$memberInfo->provinceid=$_POST['provinceid'];
			$memberInfo->residecityid=$_POST['residecityid'];
		    	$memberInfo_res=$memberInfo->save();

		    	if($member_res || $memberCount_res || $memberInfo_res){
		    		echo json_encode(array('status'=>1,'info'=>'会员修改成功','url'=>Yii::app()->params['url'].'member/index'));
		    		exit();
		    	}else{
		    		echo json_encode(array('status'=>0,'info'=>'会员修改失败','url'=>Yii::app()->params['url'].'member/index'));
		    		exit();
		    	}
		}

		
		$this->render('edit',array('memberModel'=>$member));
	}
}