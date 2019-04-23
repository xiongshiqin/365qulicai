<?php

/**
 * This is the model class for table "{{company_api}}".
 *
 * The followings are the available columns in table '{{company_api}}':
 * @property integer $cpid
 * @property string $relate_api
 * @property string $lottery_api
 */
class CompanyApi extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyApi the static model class
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
		return '{{company_api}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cpid', 'required'),
			// array('cpid', 'numerical', 'integerOnly'=>true),
			// array('relate_api, lottery_api', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cpid, relate_api, user_check, lottery_api', 'safe', 'on'=>'search'),
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
			'relate_api' => 'Relate Api',
			'user_check' => 'User Check',
			'lottery_api' => 'Lottery Api',
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
		$criteria->compare('relate_api',$this->relate_api,true);
		$criteria->cpmpare('user_check',$this->user_check,true);
		$criteria->compare('lottery_api',$this->lottery_api,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->relate_api = '';
				$this->user_check ='';
				$this->lottery_api = '';
			}
		}
		return true;
	}
}