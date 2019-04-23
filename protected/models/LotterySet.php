<?php

/**
 * This is the model class for table "{{lottery_set}}".
 *
 * The followings are the available columns in table '{{lottery_set}}':
 * @property string $id
 * @property integer $lotid
 * @property string $awardid
 * @property string $awardname
 * @property integer $probability
 * @property integer $awardnum
 * @property integer $vip
 * @property string $dateline
 */
class LotterySet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LotterySet the static model class
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
		return '{{lottery_set}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('awardid, awardnum, probability', 'required'),
			// array('lotid,  awardnum, vip', 'numerical', 'integerOnly'=>true),
			// array('awardid, dateline', 'length', 'max'=>10),
			// array('awardname', 'length', 'max'=>20),
			// // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, lotid, awardid, awardname, probability, awardnum, vip, dateline', 'safe', 'on'=>'search'),
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
			'event_award'=>array(self::HAS_ONE, 'EventAward' , '' , 'on' => 't.awardid=event_award.awardid'),
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
			'awardid' => 'Awardid',
			'awardname' => 'Awardname',
			'probability' => 'Probability',
			'awardnum' => 'Awardnum',
			'vip' => 'Vip',
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
		$criteria->compare('awardid',$this->awardid,true);
		$criteria->compare('awardname',$this->awardname,true);
		$criteria->compare('probability',$this->probability);
		$criteria->compare('awardnum',$this->awardnum);
		$criteria->compare('vip',$this->vip);
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
			$this->awardname = EventAward::model()->findByPk($this->awardid)->awardname;
		}
		return true;
	}
}