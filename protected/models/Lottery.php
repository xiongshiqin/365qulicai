<?php

/**
 * This is the model class for table "{{lottery}}".
 *
 * The followings are the available columns in table '{{lottery}}':
 * @property integer $lotid
 * @property integer $eventid
 * @property integer $type
 * @property integer $awardnum
 * @property integer $starttime
 * @property integer $endtime
 * @property integer $vip
 * @property integer $autogiving
 * @property integer $awardchance
 * @property integer $awardprecondition
 * @property integer $ifmessage
 * @property string $dateline
 */
class Lottery extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Lottery the static model class
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
		return '{{lottery}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eventid', 'required'),
			// array('eventid, type, awardnum, starttime, endtime, vip, autogiving, awardchance, awardprecondition, ifmessage', 'numerical', 'integerOnly'=>true),
			// array('dateline', 'length', 'max'=>10),
			// // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('lotid, eventid, type, awardnum, starttime, endtime, vip, autogiving, awardchance, awardprecondition, ifmessage, dateline', 'safe', 'on'=>'search'),
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
			'lotid' => 'Lotid',
			'eventid' => 'Eventid',
			'type' => 'Type',
			'awardnum' => 'Awardnum',
			'starttime' => 'Starttime',
			'endtime' => 'Endtime',
			'vip' => 'Vip',
			'autogiving' => 'Autogiving',
			'awardchance' => 'Awardchance',
			'awardprecondition' => 'Awardprecondition',
			'ifmessage' => 'Ifmessage',
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

		$criteria->compare('lotid',$this->lotid);
		$criteria->compare('eventid',$this->eventid);
		$criteria->compare('type',$this->type);
		$criteria->compare('awardnum',$this->awardnum);
		$criteria->compare('starttime',$this->starttime);
		$criteria->compare('endtime',$this->endtime);
		$criteria->compare('vip',$this->vip);
		$criteria->compare('autogiving',$this->autogiving);
		$criteria->compare('awardchance',$this->awardchance);
		$criteria->compare('awardprecondition',$this->awardprecondition);
		$criteria->compare('ifmessage',$this->ifmessage);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->awardprecondition = 2; // 现在必须关联平台才能抽奖，因为有自动发奖功能，需要被关联平台的p2pname
				$this->dateline = time();
			}
		}
		return true;
	}
}