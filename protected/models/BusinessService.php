<?php

/**
 * This is the model class for table "{{business_service}}".
 *
 * The followings are the available columns in table '{{business_service}}':
 * @property string $id
 * @property integer $bid
 * @property integer $uid
 * @property string $username
 * @property string $nickname
 * @property string $realname
 * @property string $mobile
 * @property integer $qq
 * @property integer $status
 * @property integer $isshow
 * @property string $pic
 * @property integer $department
 * @property integer $isadmin
 * @property integer $opuid
 * @property string $deltime
 * @property string $dateline
 */
class BusinessService extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BusinessService the static model class
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
		return '{{business_service}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bid', 'required'),
			array('bid, uid, qq, status, isshow, department, isadmin, opuid', 'numerical', 'integerOnly'=>true),
			array('id, nickname, deltime, dateline', 'length', 'max'=>10),
			array('username, realname', 'length', 'max'=>16),
			array('mobile', 'length', 'max'=>12),
			array('pic', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, bid, uid, username, nickname, realname, mobile, qq, status, isshow, pic, department, isadmin, opuid, deltime, dateline,remark', 'safe', 'on'=>'search'),
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
			'member_count' => array(self::HAS_ONE, 'MemberCount', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bid' => 'Bid',
			'uid' => 'Uid',
			'username' => 'Username',
			'nickname' => 'Nickname',
			'realname' => 'Realname',
			'mobile' => 'Mobile',
			'qq' => 'Qq',
			'status' => 'Status',
			'isshow' => 'Isshow',
			'pic' => 'Pic',
			'department' => 'Department',
			'isadmin' => 'Isadmin',
			'opuid' => 'Opuid',
			'deltime' => 'Deltime',
			'dateline' => 'Dateline',
			'remark' => 'Remark',
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
		$criteria->compare('bid',$this->bid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('qq',$this->qq);
		$criteria->compare('status',$this->status);
		$criteria->compare('isshow',$this->isshow);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('department',$this->department);
		$criteria->compare('isadmin',$this->isadmin);
		$criteria->compare('opuid',$this->opuid);
		$criteria->compare('deltime',$this->deltime,true);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->uid = Yii::app()->user->id;
				$this->username = Yii::app()->user->name;
				$this->dateline = time();
			}
		}
		return true;
	}
	
}