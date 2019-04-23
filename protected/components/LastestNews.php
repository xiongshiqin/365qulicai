<?php
/**
 * 最近6条新闻 
 * @author porter 2014-9-24
 */
Yii::import('zii.widgets.CPortlet');

class LastestNews extends CPortlet
{
	public $cpid = null;
	public $type = 'company';
	public $skin = 'list';
	public function init()
	{
		parent::init();
	}	

	protected function renderContent()
	{
		$condition = "status = 1";
		if($this->type == 'company'){ // 默认为公司新闻
			if($this->cpid) { //如果设置了cpid ，则为具体公司的新闻 ， 否则为所有公司的最新新闻
				$condition .= " and pid =" . $this->cpid;
			} else { 
				$condition .= " and pid != 0";
			}
		} else {
			$condition .= " and pid = 0 and classid != '301'";
		}

		$render = 'lastestNews';
		$limit = 10;
		if($this->skin != 'list'){
			$render = 'picNewsList';
			$limit = 5;
			$condition .= " and pic != ''";
		}
		$newses = News::model()->findAll(array(
					'condition' => $condition,
					'order' => 'dateline desc',
					'limit' => $limit,
					));
		$this->render($render , array('newses'=>$newses));
	}
}