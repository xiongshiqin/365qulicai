<?php

/**
 * This is the model class for table "{{business_info}}".
 *
 * The followings are the available columns in table '{{business_info}}':
 * @property string $id
 * @property string $bid
 * @property string $siteurl
 * @property string $address
 * @property string $telephone
 * @property string $fax
 * @property integer $uid
 * @property string $username
 * @property string $weibo
 * @property string $weixin
 * @property string $info
 * @property string $mainbissness
 */
class BusinessInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BusinessInfo the static model class
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
		return '{{business_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bid, siteurl, address', 'required'),
			array('uid', 'numerical', 'integerOnly'=>true),
			array('bid', 'length', 'max'=>10),
			array('siteurl', 'length', 'max'=>50),
			array('address, weibo, weixin', 'length', 'max'=>100),
			array('telephone, fax, username', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bid, siteurl, address, telephone, fax, uid, username, weibo, weixin, info, mainbissness', 'safe', 'on'=>'search'),
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
			'business'=>array(self::HAS_ONE, 'Business', 'bid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bid' => 'Bid',
			'siteurl' => 'Siteurl',
			'address' => 'Address',
			'telephone' => 'Telephone',
			'fax' => 'Fax',
			'uid' => 'Uid',
			'username' => 'Username',
			'weibo' => 'Weibo',
			'weixin' => 'Weixin',
			'info' => 'Info',
			'mainbissness' => 'Mainbissness',
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

		$criteria->compare('bid',$this->bid,true);
		$criteria->compare('siteurl',$this->siteurl,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('weibo',$this->weibo,true);
		$criteria->compare('weixin',$this->weixin,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('mainbissness',$this->mainbissness,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->uid = Yii::app()->user->id;
				$this->username = Yii::app()->user->name;
			}
		}
		return true;
	}
}