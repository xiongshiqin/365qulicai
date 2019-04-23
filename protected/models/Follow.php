<?php

/**
 * This is the model class for table "{{follow}}".
 *
 * The followings are the available columns in table '{{follow}}':
 * @property integer $fid
 * @property integer $uid
 * @property string $username
 * @property integer $fuid
 * @property string $fusername
 * @property string $realname
 * @property string $mobile
 * @property string $groupid
 * @property string $dateline
 */
class Follow extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Follow the static model class
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
		return '{{follow}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid,fuid,', 'required'),
			// array('uid, fuid', 'numerical', 'integerOnly'=>true),
			// array('username, fusername, realname', 'length', 'max'=>16),
			// array('mobile', 'length', 'max'=>12),
			// array('groupid', 'length', 'max'=>11),
			// array('dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('fid, uid, username, fuid, fusername, realname, mobile, groupid, dateline', 'safe', 'on'=>'search'),
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
			// uid得到的用户信息
			'member_count' => array(self::HAS_ONE,'MemberCount' , '' , 'on' => 'member_count.uid = t.uid'),
			'member_info' => array(self::HAS_ONE,'MemberInfo' , '' , 'on' => 'member_info.uid = t.uid'),
			// fuid得到的用户信息
			'fmember_count' => array(self::HAS_ONE,'MemberCount' , '' , 'on' => 'fmember_count.uid = t.fuid'),
			'fmember_info' => array(self::HAS_ONE,'MemberInfo' , '' , 'on' => 'fmember_info.uid = t.fuid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fid' => 'Fid',
			'uid' => 'Uid',
			'username' => 'Username',
			'fuid' => 'Fuid',
			'fusername' => 'Fusername',
			'realname' => 'Realname',
			'mobile' => 'Mobile',
			'groupid' => 'Groupid',
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

		$criteria->compare('fid',$this->fid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('fuid',$this->fuid);
		$criteria->compare('fusername',$this->fusername,true);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('groupid',$this->groupid,true);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->realname = '';
				$this->mobile = 0;
				$this->groupid= 0;
				$this->username = Member::model()->findByPk($this->uid)->username;
				$this->fusername = Member::model()->findByPk($this->fuid)->username;
				$this->dateline = time();
				
			}
		}
		return true;
	}

	protected function afterSave(){  
		parent::afterSave();
		if($this->isNewRecord){
			// 粉丝+1
			MemberCount::model()->updateCounters(array('following'=> 1), 'uid=' . $this->fuid);
			// 关注+1
			MemberCount::model()->updateCounters(array('follownum'=> 1), 'uid=' . $this->uid);
		}
		return true;  
	}  

	public function afterDelete(){
		parent::afterDelete();
		// 粉丝-1
		MemberCount::model()->updateCounters(array('following'=> -1), 'uid=' . $this->fuid);
		// 关注-1
		MemberCount::model()->updateCounters(array('follownum'=> -1), 'uid=' . $this->uid);
		return true;
	}

}