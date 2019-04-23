<?php

/**
 * This is the model class for table "{{like}}".
 *
 * The followings are the available columns in table '{{like}}':
 * @property string $id
 * @property string $itemid
 * @property integer $uid
 * @property string $username
 * @property integer $type
 * @property string $dateline
 * @property string $title
 */
class Like extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Like the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{like}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('username, title', 'required'),
			array('uid, type', 'numerical', 'integerOnly'=>true),
			array('itemid, dateline', 'length', 'max'=>10),
			array('username', 'length', 'max'=>16),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, itemid, uid, username, type, dateline, title', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'itemid' => 'Itemid',
			'uid' => 'Uid',
			'username' => 'Username',
			'type' => 'Type',
			'dateline' => 'Dateline',
			'title' => 'Title',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('itemid',$this->itemid,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('dateline',$this->dateline,true);
		$criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->uid = Yii::app()->user->id;
				$this->username = Yii::app()->user->name;
				$this->dateline = time();
			}
		}
		return true;
	}
	
	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
			if($this->type == 1 ){			
				$group = GroupTopic::model()->findByPk($this->itemid);
				$group->saveCounters(array('likenum'=>1));
				
			}elseif($this->type == 2 ){	
				$group = GroupPost::model()->findByPk($this->itemid);
				$group->saveCounters(array('likenum'=>1));
			}
			
			$creditType = ($this->type == 1) ? 'like_topic' : ($this->type == 2 ) ? 'like_post' : '';
			if ($creditType) {
				// HComm::updateCredit($creditType); 暂时没有点赞活动和评论
				// 游客也能点赞
				// $groupUser = GroupUser::model()->find(array(
				// 	'condition'=>'uid=:uid AND gid=:gid',
				// 	'params'=>array(':uid'=>Yii::app()->user->id, ':gid'=>$group->gid),
				// ));
				// $groupUser && $groupUser->saveCounters(array('credit'=>Yii::app()->params->credit[$creditType][2] * Yii::app()->params->credit[$creditType][3]));
			}		
		}
		return true;
	}
	
	public function add($type, $id){
		 
		if ($type == 'topic') {
			$type = 1;		
		}elseif ($type == 'post'){
			$type = 2;		
		}
		
		if (! $this->getLike($type, $id)) {
			Yii::app()->user->setFlash('ding' , true);
			$this->type = $type;
			$this->itemid = $id;
			$this->validate() && $this->save();
		}
		return true;
	}
	
	protected function getLike($type, $id){
		return Like::model()->find(array(
			'condition'=>'uid=:uid AND itemid=:itemid AND type=:type',
			'params'=>array(':uid'=>Yii::app()->user->id, ':itemid'=>$id, ':type'=>$type),
		));		
	}
	
}