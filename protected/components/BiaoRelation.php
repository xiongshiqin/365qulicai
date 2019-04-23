<?php
/**
 * 感兴趣的标的关注关系
 */
Yii::import('zii.widgets.CPortlet');

class BiaoRelation extends CPortlet
{

	public $relation = null;
	public $biaoid = null;
	public $cpid = null;

	public function init()
	{
		$this->relation = 0;
		$uid = Yii::app()->user->id;
		if(BiaoLike::model()->exists("biaoid = $this->biaoid and uid = $uid")){
			$this->relation = 1;
		}
		parent::init();
	}	

	protected function renderContent()
	{
		$this->render('biaoRelation');
	}
}