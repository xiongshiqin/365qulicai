<?php
/**
 * 后台个人资料菜单
 */
Yii::import('zii.widgets.CPortlet');

class ManageMenu extends CPortlet {
	
	public $selected=array();
	
	protected function renderContent(){		
		$this->render('manageMenu');
	}
}