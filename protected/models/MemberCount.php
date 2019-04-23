<?php

/**
 * This is the model class for table "{{member_count}}".
 *
 * The followings are the available columns in table '{{member_count}}':
 * @property integer $uid
 * @property integer $credit
 * @property integer $credittotal
 * @property integer $gold
 * @property integer $talknum
 * @property integer $message
 * @property integer $invite
 * @property integer $follownum
 * @property integer $following
 * @property integer $p2pfollow
 * @property integer $p2pnum
 * @property integer $kanum
 */
class MemberCount extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberCount the static model class
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
		return '{{member_count}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('credit, credittotal, gold, talknum, message, invite, follownum, following, p2pfollow, p2pnum, kanum', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('uid, credit, credittotal, gold, talknum, message, invite, follownum, following, p2pfollow, p2pnum, kanum', 'safe', 'on'=>'search'),
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
			'business_service' => array(self::HAS_ONE, 'BusinessService', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'credit' => 'Credit',
			'credittotal' => 'Credittotal',
			'gold' => 'Gold',
			'talknum' => 'Talknum',
			'message' => 'Message',
			'invite' => 'Invite',
			'follownum' => 'Follownum',
			'following' => 'Following',
			'p2pfollow' => 'P2pfollow',
			'p2pnum' => 'P2pnum',
			'kanum' => 'Kanum',
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
		$criteria->compare('credit',$this->credit);
		$criteria->compare('credittotal',$this->credittotal);
		$criteria->compare('gold',$this->gold);
		$criteria->compare('talknum',$this->talknum);
		$criteria->compare('message',$this->message);
		$criteria->compare('invite',$this->invite);
		$criteria->compare('follownum',$this->follownum);
		$criteria->compare('following',$this->following);
		$criteria->compare('p2pfollow',$this->p2pfollow);
		$criteria->compare('p2pnum',$this->p2pnum);
		$criteria->compare('kanum',$this->kanum);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}