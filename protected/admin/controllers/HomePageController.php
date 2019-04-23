<?php
/*
*首页管理控制器
*/
class HomePageController extends Controller{
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
		$biao_ids = implode(',' , array('1'));
		$this->render('index',array(
					'biao_ids' => $biao_ids,
					));
	}
}