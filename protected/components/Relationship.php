<?php
/**
 * 会员与会员的关注关系
 * @author porter 2014-9-24
 */
Yii::import('zii.widgets.CPortlet');

class Relationship extends CPortlet
{

	public $relation = null;
	public $fuid = null;

	public function init()
	{
		// 关注状态分为5种 0-我自己 1-未关注 2-已关注  3-正关注我 4-互相关注
		$this->relation = 0;
		$muid = Yii::app()->user->id;
		// 是否是我自己
		if($this->fuid != $muid){
			$this->relation =1;
		}
		// 我是否关注他
		if(Follow::model()->exists("uid = :uid and fuid = :fuid",array(':uid'=>$muid , ':fuid'=>$this->fuid))){
			$this->relation += 1;
		}
		//他是否关注我
		if(Follow::model()->exists("uid = :fuid and fuid = :uid",array(':uid'=>$muid , ':fuid'=>$this->fuid))){
			$this->relation +=2;
		}
		parent::init();
	}	

	protected function renderContent()
	{
		$this->render('relationship');
	}
}