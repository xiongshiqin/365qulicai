<?php

Yii::import('zii.widgets.CPortlet');

class BusinessMenu extends CPortlet
{
	public $selected;
	public function init()
	{
		$this->id = (int)Yii::app()->request->getParam('id');
		parent::init();
	}

	//菜单选中状态 $str
	public function getSelected($str){
		return (isset($this->selected) && $this->selected === $str) ? ' class="selected"' : '';
	}

	protected function renderContent()
	{
		$this->render('businessMenu');
	}
}