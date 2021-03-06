<?php

/**
 * This is the model class for table "{{lottery_log}}".
 *
 * The followings are the available columns in table '{{lottery_log}}':
 * @property integer $id
 * @property integer $uid
 * @property string $username
 * @property integer $lotid
 * @property integer $level
 * @property integer $awardid
 * @property string $awardname
 * @property integer $dateline
 */
class LotteryLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LotteryLog the static model class
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
		return '{{lottery_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, username, lotid, level, awardid, awardname', 'required'),
			// array('uid, lotid, level, awardid, dateline', 'numerical', 'integerOnly'=>true),
			// array('username, awardname', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, username, lotid, level, awardid, awardname, dateline', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'username' => 'Username',
			'lotid' => 'Lotid',
			'level' => 'Level',
			'awardid' => 'Awardid',
			'awardname' => 'Awardname',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('lotid',$this->lotid);
		$criteria->compare('level',$this->level);
		$criteria->compare('awardid',$this->awardid);
		$criteria->compare('awardname',$this->awardname,true);
		$criteria->compare('dateline',$this->dateline);

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