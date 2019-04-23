<?php

class DefaultController extends Controller
{
	public $layout = 'simple';
	
	public function actionIndex()
	{
		$member = GroupUser::model()->findAll(array(
			'order'=>'dateline desc',
		));
		
		$this->render('index', array(
			'member'=>$member,
		));
	}
}