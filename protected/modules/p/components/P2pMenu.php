<?php
/**
 * P2P后台菜单 beyond_dream  
 */
Yii::import('zii.widgets.CPortlet');

class P2pMenu extends CPortlet
{
	public $p2pid = null;
	public $selected = null;

	//菜单选中状态 $str
	public function getSelected($str){
		return (isset($this->selected) && $this->selected === $str) ? ' class="selected"' : '';
	}
	
	protected function renderContent()
	{
		$this->render('p2pMenu');
	}
}