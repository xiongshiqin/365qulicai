<?php
/**
 * 广告位轮播图
  * @author porter 
 */
Yii::import('zii.widgets.CPortlet');

class AdverSlide extends CPortlet
{

	public function init()
	{
		// $this->title=CHtml::encode(Yii::app()->user->name);
		parent::init();
	}	

	protected function renderContent()
	{
		$this->render('adverSlide');
	}
}