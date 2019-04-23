<?php
/**
 * 最热的讨论话题 
 * @author porter 2014-9-27
 */
Yii::import('zii.widgets.CPortlet');

class HottestTopics extends CPortlet
{
	public $gid = null;
	public function init()
	{
		parent::init();
	}	

	protected function renderContent()
	{
		$topics = GroupTopic::model()->findAll(array(
					'condition' => 'gid =  :gid',
					'params' => array(':gid'=>$this->gid),
					'order' => 'viewnum desc',
					'limit' => '6',
					));
		$this->render('hottestTopics',array('topics'=>$topics));
	}
}