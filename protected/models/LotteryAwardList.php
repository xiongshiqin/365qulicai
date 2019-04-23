<?php

/**
 * This is the model class for table "{{lottery_award_list}}".
 *
 * The followings are the available columns in table '{{lottery_award_list}}':
 * @property string $id
 * @property integer $lotid
 * @property integer $eventid
 * @property integer $uid
 * @property string $username
 * @property integer $awardid
 * @property string $awardname
 * @property integer $issend
 * @property string $sendtime
 * @property string $dateline
 */
class LotteryAwardList extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LotteryAwardList the static model class
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
		return '{{lottery_award_list}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lotid, eventid, uid, username, awardid, awardname', 'required'),
			// array('lotid, eventid, uid, awardid, issend', 'numerical', 'integerOnly'=>true),
			// array('username', 'length', 'max'=>16),
			// array('awardname', 'length', 'max'=>20),
			// array('sendtime, dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lotid, eventid, uid, username, awardid, awardname, issend, sendtime, dateline', 'safe', 'on'=>'search'),
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
			'lotid' => 'Lotid',
			'eventid' => 'Eventid',
			'uid' => 'Uid',
			'username' => 'Username',
			'awardid' => 'Awardid',
			'awardname' => 'Awardname',
			'issend' => 'Issend',
			'sendtime' => 'Sendtime',
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
		$criteria->compare('lotid',$this->lotid);
		$criteria->compare('eventid',$this->eventid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('awardid',$this->awardid);
		$criteria->compare('awardname',$this->awardname,true);
		$criteria->compare('issend',$this->issend);
		$criteria->compare('sendtime',$this->sendtime,true);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->dateline = time();
			}else{
				
			}
		}
		return true;
	}
}