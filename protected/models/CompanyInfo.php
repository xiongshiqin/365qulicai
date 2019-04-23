<?php

/**
 * This is the model class for table "{{company_info}}".
 *
 * The followings are the available columns in table '{{company_info}}':
 * @property integer $cpid
 * @property string $info
 * @property string $mainbissness
 * @property string $team
 * @property string $voucher
 * @property string $contact_us
 * @property string $charge
 * @property integer $uid
 * @property string $boss_name
 * @property string $boss_mobile
 * @property string $operation_name
 * @property string $operation_mobile
 * @property string $dateline
 */
class CompanyInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyInfo the static model class
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
		return '{{company_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('info, mainbissness, uid, dateline', 'required'),
			// array('uid', 'numerical', 'integerOnly'=>true),
			// array('boss_name, operation_name', 'length', 'max'=>20),
			// array('boss_mobile, operation_mobile', 'length', 'max'=>12),
			// array('dateline', 'length', 'max'=>10),
			// array('team, voucher, contact_us, charge', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cpid, info, mainbissness, team, voucher, contact_us, charge, uid, boss_name, boss_mobile, operation_name, operation_mobile, dateline', 'safe', 'on'=>'search'),
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
			'cpid' => 'Cpid',
			'info' => 'Info',
			'mainbissness' => 'Mainbissness',
			'team' => 'Team',
			'voucher' => 'Voucher',
			'contact_us' => 'Contact Us',
			'charge' => 'Charge',
			'uid' => 'Uid',
			'boss_name' => 'Boss Name',
			'boss_mobile' => 'Boss Mobile',
			'operation_name' => 'Operation Name',
			'operation_mobile' => 'Operation Mobile',
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

		$criteria->compare('cpid',$this->cpid);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('mainbissness',$this->mainbissness,true);
		$criteria->compare('team',$this->team,true);
		$criteria->compare('voucher',$this->voucher,true);
		$criteria->compare('contact_us',$this->contact_us,true);
		$criteria->compare('charge',$this->charge,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('boss_name',$this->boss_name,true);
		$criteria->compare('boss_mobile',$this->boss_mobile,true);
		$criteria->compare('operation_name',$this->operation_name,true);
		$criteria->compare('operation_mobile',$this->operation_mobile,true);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}