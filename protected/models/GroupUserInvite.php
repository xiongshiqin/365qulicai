<?php

/**
 * This is the model class for table "{{group_user_invite}}".
 *
 * The followings are the available columns in table '{{group_user_invite}}':
 * @property integer $id
 * @property integer $gid
 * @property integer $invite_uid
 * @property string $invite_username
 * @property integer $uid
 * @property string $username
 * @property integer $status
 * @property string $optime
 * @property string $dateline
 */
class GroupUserInvite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GroupUserInvite the static model class
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
		return '{{group_user_invite}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, gid, invite_uid, invite_username, uid, username', 'required'),
			array('id, gid, invite_uid, uid, status', 'numerical', 'integerOnly'=>true),
			array('invite_username, username', 'length', 'max'=>16),
			array('optime, dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, gid, invite_uid, invite_username, uid, username, status, optime, dateline', 'safe', 'on'=>'search'),
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
			'gid' => 'Gid',
			'invite_uid' => 'Invite Uid',
			'invite_username' => 'Invite Username',
			'uid' => 'Uid',
			'username' => 'Username',
			'status' => 'Status',
			'optime' => 'Optime',
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
		$criteria->compare('gid',$this->gid);
		$criteria->compare('invite_uid',$this->invite_uid);
		$criteria->compare('invite_username',$this->invite_username,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('optime',$this->optime,true);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}