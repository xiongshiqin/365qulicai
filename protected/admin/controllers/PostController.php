<?php
/*
*帖子管理控制器
*/
class PostController extends Controller{
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
		$cri = new CDbCriteria();   //查询所有记录
		$grouppostModel=GroupPost::model();
		
		$total=count($grouppostModel->findAll($cri ));
		$pager = new CPagination($total);  //实例化分页类
		$pager->pageSize = 10;   //设置每页显示条数
		$pager->applyLimit($cri);
		$grouppostInfo=$grouppostModel->findAll($cri );

		$this->render('index',array('grouppostInfo'=>$grouppostInfo,'pages'=>$pager));
	}
	//删除帖子
	public function actionPost(){
		//$test=$_POST;
		//echo $test;
		//echo json_encode($test);
		//echo $test;
	}
}