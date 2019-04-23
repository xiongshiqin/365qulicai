<?php
/**
 * 会员与会员的关注关系
 * @author porter 2014-9-24
 */
Yii::import('zii.widgets.CPortlet');

class CompanyRelationship extends CPortlet
{

	public $relation = null;
	public $hasApi = false;
	public $cpid = null;

	public function init()
	{
		// 默认为没有关注
		$this->relation = 1;
		// 正关注他
		$follow = CompanyFollow::model()->find("uid = :uid and cpid = :cpid",array(':uid'=>Yii::app()->user->id , ':cpid'=>$this->cpid));
		if($follow){  //关注平台
			$this->relation = 2;
		}
		if($follow && strlen($follow->p2pname) > 0){ // 关联平台
			$this->relation = 3;
		}


		if(($comApi = CompanyApi::model()->findByPk($this->cpid)) && $comApi->user_check){
			$this->hasApi = true; 
		}

		parent::init();
	}	

	protected function renderContent()
	{
		$this->render('companyRelationship');
	}
}