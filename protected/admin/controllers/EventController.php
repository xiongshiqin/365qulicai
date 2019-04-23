<?php
/*
*活动控制器
*/
class EventController extends Controller{
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
		$cri = new CDbCriteria();   //查询所有记录
		$eventModel=Event::model();

		$total=$eventModel->count();  //总数		
		$pager = new CPagination($total);  //实例化分页类
		$pager->pageSize = 10;   //设置每页显示条数
		$pager->applyLimit($cri);

		$evenInfo=$eventModel->findAll($cri);

		$this->render('index',array('evenInfo'=>$evenInfo,'pages'=>$pager));
	}
	/* 编辑 */
	public function actionEdit($id){
		$evenModel=Event::model();
		$eventInfo=$evenModel->findByPk($id);

		if(isset($_POST['Event'])){
			$data=$_POST['Event'];
			$data['dateline']=strtotime($_POST['Event']['dateline']);
			$res=$eventInfo->updateByPk($id,$data);

			/* 修改关联event_field表 */
			$data_event_field=$_POST['EventField'];
			$event_fieldModel=EventField::model();
			$res1=$event_fieldModel->updateByPk($id,$data_event_field);

			if($res || $res1){
				echo json_encode(array('status'=>1,'info'=>'活动修改成功','url'=>Yii::app()->params['url'].'event/index'));
		    		exit();
			}else{
				echo json_encode(array('status'=>0,'info'=>'活动修改失败','url'=>Yii::app()->params['url'].'event/index'));
		    		exit();
			}
		}
		$this->render('edit',array('eventInfo'=>$eventInfo));
	}

	/* 修改活动状态 */
	public function actionModifyStatus(){
		$value=$_POST['value'];
		$eventid=$_POST['eventid'];
		$data['status']=$value;
		$evenModel=Event::model();
		$res=$evenModel->updateByPk($eventid,$data);
		if($res){
			if($value == 2){ // edit by porter at 2014年11月13日 17:32:19
				// 平台活动数+1
				$cpid = Event::model()->findByPk($eventid)->p2pid;
				Company::model()->updateCounters(array('event_num' => 1) , "cpid = $cpid");
			}
			echo 1;
		}else{
			echo 2;
		}
	}
}
