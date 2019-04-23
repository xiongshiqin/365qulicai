<?php
/*
*私信控制器
*/
class TalkController extends Controller{
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
	
	//私信列表显示
	public function actionIndex(){
		$cri = new CDbCriteria();   //查询所有记录
		$talkModel=Talk::model();
		$talkInfo=$talkModel->findAll($cri);

		$this->render('index',array('talkInfo'=>$talkInfo));
	}
	//查看私信内容
	public function actionContentList($id){
		$criteria = new CDbCriteria();
		$talkReplyModel=TalkReply::model();
		$criteria->condition="talkid = $id";
		$criteria->order="dateline desc";		

		$total=count($talkReplyModel->findAll($criteria));
		$pager = new CPagination($total);  //实例化分页类
		$pager->pageSize = 5;   //设置每页显示条数
		$pager->applyLimit($criteria);
		$talkReplyInfo=$talkReplyModel->findAll($criteria);

		$this->render('content_list',array('talkReplyInfo'=>$talkReplyInfo,'pages'=>$pager));
	}
}