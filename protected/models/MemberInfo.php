<?php

/**
 * This is the model class for table "{{member_info}}".
 *
 * The followings are the available columns in table '{{member_info}}':
 * @property integer $uid
 * @property string $realname
 * @property integer $gender
 * @property string $qq
 * @property string $weixin
 * @property string $resideprovince
 * @property integer $provinceid
 * @property integer $residecityid
 * @property string $residecity
 * @property string $sign
 */
class MemberInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberInfo the static model class
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
		return '{{member_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gender, provinceid, residecityid', 'numerical', 'integerOnly'=>true),
			array('realname, weixin', 'length', 'max'=>100),
			array('qq', 'length', 'max'=>10),
			array('resideprovince, residecity, sign', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, realname, gender, mobile, qq, weixin, resideprovince, provinceid, residecityid, residecity, sign', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'realname' => 'Realname',
			'gender' => 'Gender',
			'qq' => 'Qq',
			'weixin' => 'Weixin',
			'resideprovince' => 'Resideprovince',
			'provinceid' => 'Provinceid',
			'residecityid' => 'Residecityid',
			'residecity' => 'Residecity',
			'sign' => 'Sign',
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('qq',$this->qq,true);
		$criteria->compare('weixin',$this->weixin,true);
		$criteria->compare('resideprovince',$this->resideprovince,true);
		$criteria->compare('provinceid',$this->provinceid);
		$criteria->compare('residecityid',$this->residecityid);
		$criteria->compare('residecity',$this->residecity,true);
		$criteria->compare('sign',$this->sign,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}