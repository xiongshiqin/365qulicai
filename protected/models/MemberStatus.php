<?php

/**
 * This is the model class for table "{{member_status}}".
 *
 * The followings are the available columns in table '{{member_status}}':
 * @property integer $uid
 * @property string $regdate
 * @property string $regip
 * @property string $lastip
 * @property string $lastvisit
 * @property integer $visitnum
 */
class MemberStatus extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberStatus the static model class
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
		return '{{member_status}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('visitnum', 'numerical', 'integerOnly'=>true),
			// array('regdate, regip, lastip, lastvisit', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, regdate, regip, lastip, lastvisit, visitnum', 'safe', 'on'=>'search'),
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
			'member' => array(self::HAS_ONE, 'Member', '' , 'on' => 'member.uid = t.uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'regdate' => 'Regdate',
			'regip' => 'Regip',
			'lastip' => 'Lastip',
			'lastvisit' => 'Lastvisit',
			'visitnum' => 'Visitnum',
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
		$criteria->compare('regdate',$this->regdate,true);
		$criteria->compare('regip',$this->regip,true);
		$criteria->compare('lastip',$this->lastip,true);
		$criteria->compare('lastvisit',$this->lastvisit,true);
		$criteria->compare('visitnum',$this->visitnum);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}