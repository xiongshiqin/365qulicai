<?php
/**
 * 视频播放器 
 * @author porter 2014-9-24
 */
Yii::import('zii.widgets.CPortlet');

class VideoPlayer extends CPortlet
{

	public $url = null;
	public function init()
	{
		// $this->title=CHtml::encode(Yii::app()->user->name);
		parent::init();
	}	

	protected function renderContent()
	{
		$this->render('videoPlayer');
	}
}