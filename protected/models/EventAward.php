<?php

/**
 * This is the model class for table "{{event_award}}".
 *
 * The followings are the available columns in table '{{event_award}}':
 * @property string $awardid
 * @property string $eventid
 * @property integer $awardtype
 * @property integer $awardvalue
 * @property string $awardname
 * @property string $awardpic
 * @property integer $num
 * @property string $dateline
 */
class EventAward extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EventAward the static model class
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
		return '{{event_award}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('awardtype , awardname , num', 'required'),
			// array('awardtype, awardvalue, num', 'numerical', 'integerOnly'=>true),
			// array('eventid, dateline', 'length', 'max'=>10),
			// array('awardname', 'length', 'max'=>50),
			// array('awardpic', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('awardid, eventid, awardtype, awardvalue, awardname, awardpic, num, dateline', 'safe', 'on'=>'search'),
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
			'awardid' => 'Awardid',
			'eventid' => 'Eventid',
			'awardtype' => 'Awardtype',
			'awardvalue' => 'Awardvalue',
			'awardname' => 'Awardname',
			'awardpic' => 'Awardpic',
			'num' => 'Num',
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

		$criteria->compare('awardid',$this->awardid,true);
		$criteria->compare('eventid',$this->eventid,true);
		$criteria->compare('awardtype',$this->awardtype);
		$criteria->compare('awardvalue',$this->awardvalue);
		$criteria->compare('awardname',$this->awardname,true);
		$criteria->compare('awardpic',$this->awardpic,true);
		$criteria->compare('num',$this->num);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->dateline = time();
			}
		}
		return true;
	}
}