<?php

/**
 * This is the model class for table "{{event_award_log}}".
 *
 * The followings are the available columns in table '{{event_award_log}}':
 * @property string $id
 * @property integer $eventid
 * @property string $title
 * @property integer $uid
 * @property string $username
 * @property integer $awardid
 * @property string $awardname
 * @property integer $type
 * @property integer $dateline
 */
class EventAwardLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EventAwardLog the static model class
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
		return '{{event_award_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eventid, title, uid, username', 'required'),
			// array('eventid, uid, awardid, type, dateline', 'numerical', 'integerOnly'=>true),
			// array('title, awardname', 'length', 'max'=>20),
			// array('username', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, eventid, title, uid, username, awardid, awardname, type, dateline', 'safe', 'on'=>'search'),
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
			'event' => array(self::HAS_ONE, 'Event', '', 'on' => 'event.eventid = t.eventid'),
			// 通过活动查出平台信息，不能单独使用，需连查 event 后再用 company
			'company' => array(self::HAS_ONE, 'Company', '', 'on' => 'company.cpid = event.p2pid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'eventid' => 'Eventid',
			'title' => 'Title',
			'uid' => 'Uid',
			'username' => 'Username',
			'awardid' => 'Awardid',
			'awardname' => 'Awardname',
			'type' => 'Type',
			'dateline' => 'Dateline',
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
		$criteria->compare('eventid',$this->eventid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('awardid',$this->awardid);
		$criteria->compare('awardname',$this->awardname,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('dateline',$this->dateline);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->awardname = EventAward::model()->findByPk($this->awardid)->awardname;
				$this->dateline = time();
			}
		}
		return true;
	}

	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
		    	// 用户获奖数+1
			MemberCount::model()->updateCounters(array('awardnum' => 1) , 'uid = ' . $this->uid);
		}
	}
}