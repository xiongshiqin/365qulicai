<?php

/**
 * This is the model class for table "{{credit_log}}".
 *
 * The followings are the available columns in table '{{credit_log}}':
 * @property integer $id
 * @property integer $uid
 * @property integer $ruleid
 * @property integer $num
 * @property integer $gold
 * @property string $content
 * @property string $dateline
 */
class CreditLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CreditLog the static model class
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
		return '{{credit_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, ruleid, content, dateline', 'required'),
			array('uid, ruleid, num, gold', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>100),
			array('dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, ruleid, num, gold, content, dateline', 'safe', 'on'=>'search'),
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
			'ruleid' => 'Ruleid',
			'num' => 'Num',
			'gold' => 'Gold',
			'content' => 'Content',
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
		$criteria->compare('ruleid',$this->ruleid);
		$criteria->compare('num',$this->num);
		$criteria->compare('gold',$this->gold);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}