<?php

/**
 * This is the model class for table "{{company_follow}}".
 *
 * The followings are the available columns in table '{{company_follow}}':
 * @property string $id
 * @property integer $uid
 * @property string $username
 * @property integer $cpid
 * @property integer $type
 * @property string $p2pname
 * @property integer $inviteuid
 * @property integer $invitenum
 * @property integer $name_status
 * @property integer $invester
 * @property integer $like_event_num
 * @property integer $join_event_num
 * @property string $dateline
 */
class CompanyFollow extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyFollow the static model class
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
		return '{{company_follow}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, cpid', 'required'),
			// array('uid, cpid, type, inviteuid, invitenum, name_status, invester, like_event_num, join_event_num', 'numerical', 'integerOnly'=>true),
			// array('username', 'length', 'max'=>16),
			// array('p2pname', 'length', 'max'=>50),
			// array('dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, username, cpid, type, p2pname, inviteuid, invitenum, name_status, invester, like_event_num, join_event_num, dateline', 'safe', 'on'=>'search'),
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
			'company' => array(self::HAS_ONE,'Company' , '' , 'on' => 'company.cpid = t.cpid'),
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
			'username' => 'Username',
			'cpid' => 'Cpid',
			'type' => 'Type',
			'p2pname' => 'P2pname',
			'inviteuid' => 'Inviteuid',
			'invitenum' => 'Invitenum',
			'name_status' => 'Name Status',
			'invester' => 'Invester',
			'like_event_num' => 'Like Event Num',
			'join_event_num' => 'Join Event Num',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('cpid',$this->cpid);
		$criteria->compare('type',$this->type);
		$criteria->compare('p2pname',$this->p2pname,true);
		$criteria->compare('inviteuid',$this->inviteuid);
		$criteria->compare('invitenum',$this->invitenum);
		$criteria->compare('name_status',$this->name_status);
		$criteria->compare('invester',$this->invester);
		$criteria->compare('like_event_num',$this->like_event_num);
		$criteria->compare('join_event_num',$this->join_event_num);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->username = Member::model()->findByPk($this->uid)->username;
				$this->dateline = time();
			}
		}
		return true;
	}

	protected function afterSave(){
		parent::afterSave();
		if($this->isNewRecord){
			// 会员关注平台数+1
			MemberCount::model()->findByPk($this->uid)->saveCounters(array('p2pnum'=>1));
			// 公司的被关注数+1
			Company::model()->findByPk($this->cpid)->saveCounters(array('follow_num'=>1));
		}
		return true;
	}

	public function afterDelete(){
		parent::afterDelete();
		// 会员关注平台数-1
		MemberCount::model()->findByPk($this->uid)->saveCounters(array('p2pnum'=> -1));
		// 公司的被关注数-1
		Company::model()->findByPk($this->cpid)->saveCounters(array('follow_num'=> -1));
		return true;
	}
}