<?php
/**
 * 评论模块 
 * @author porter 2014-12-25
 */
Yii::import('zii.widgets.CPortlet');

class CommentWidget extends CPortlet
{
	public $toid = null;
	public $type = 1;
	public function init()
	{
		parent::init();
	}	

	protected function renderContent()
	{
		// 评论数据
		$criteria = new CDbCriteria();
		$criteria->condition = "type = " . $this->type .  " and toid = " . $this->toid . " and parent_id = 0"; // 关注数排序
		$criteria->order = "dateline desc";
		$rows= 10;
		$count =  Comment::model()->count($criteria);
		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 
		$comm = Comment::model()->findAll($criteria);
		$comments = array();
		foreach($comm as $v){
			$row = $v->attributes;
			$reply = Comment::model()->findAll(array(
							'condition' => 'parent_id = ' . $row['cid'],
							'limit' => '6',
							'order' => 'dateline desc',
							));
			$row['reply'] = arToArray($reply);
			$comments[] = $row;
		}
		$this->render('commentWidget',array(
				'comments'=>$comments,
				'replynum' => $count,
				'pages' => $pager,
				));
	}
}