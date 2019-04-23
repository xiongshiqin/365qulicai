<?php
/**
 * 用户中心菜单
 */
Yii::import('zii.widgets.CPortlet');

class HomeMenu extends CPortlet {
	public $_user=null;
	public $_self=false;
	public $selected = 'index';

	public $selectedArr=array(
		'index'=>' ',
		'myActivity'=>' ',
		'myReward'=>' ',
		'myPosts'=>' ',
		'inviteFriends'=>' ',
		'myProfile'=>' ',
		'follownum'=>'',
		'following'=>'',
		);

	protected function renderContent(){	
		$this->selectedArr[$this->selected] = ' class="selected" ';	
		
		$this->render('homeMenu');
	}
}