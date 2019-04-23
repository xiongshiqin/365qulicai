<?php

/**
 * This is the model class for table "{{company_employee}}".
 *
 * The followings are the available columns in table '{{company_employee}}':
 * @property integer $id
 * @property integer $cpid
 * @property integer $uid
 * @property string $username
 * @property string $nickname
 * @property string $qq
 * @property integer $status
 * @property integer $isshow
 * @property string $pic
 * @property integer $department
 * @property integer $isadmin
 * @property integer $opuid
 * @property string $deltime
 * @property string $dateline
 */
class CompanyEmployee extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyEmployee the static model class
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
		return '{{company_employee}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cpid, uid, username,', 'required'),
			// array('cpid, uid, status, isshow, department, isadmin, opuid', 'numerical', 'integerOnly'=>true),
			// array('username', 'length', 'max'=>16),
			// array('nickname', 'length', 'max'=>8),
			// array('qq', 'length', 'max'=>11),
			// array('pic', 'length', 'max'=>50),
			// array('deltime, dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cpid, uid, username, nickname, qq, status, isshow, pic, department, isadmin, opuid, deltime, dateline', 'safe', 'on'=>'search'),
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
			'cpid' => 'Cpid',
			'uid' => 'Uid',
			'username' => 'Username',
			'nickname' => 'Nickname',
			'qq' => 'Qq',
			'status' => 'Status',
			'isshow' => 'Isshow',
			'pic' => 'Pic',
			'department' => 'Department',
			'isadmin' => 'Isadmin',
			'opuid' => 'Opuid',
			'deltime' => 'Deltime',
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
		$criteria->compare('cpid',$this->cpid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('qq',$this->qq,true);
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
				$this->opuid = 0;
				$this->realname = '';
				$this->pic = '';
				$this->dateline = time();
			}
			$this->nickname = '';
			$this->qq = 0;
		}
		return true;
	}
}