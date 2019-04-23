<?php

/**
 * This is the model class for table "{{group_user}}".
 *
 * The followings are the available columns in table '{{group_user}}':
 * @property string $id
 * @property integer $gid
 * @property integer $uid
 * @property string $username
 * @property integer $identidy
 * @property integer $status
 * @property integer $topicnum
 * @property integer $postnum
 * @property integer $credit
 * @property string $dateline
 */
class GroupUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GroupUser the static model class
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
		return '{{group_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('gid, uid, username', 'required'),
			array('gid, uid, identidy, status, topicnum, postnum, credit', 'numerical', 'integerOnly'=>true),
			array('id, dateline', 'length', 'max'=>10),
			array('username', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, gid, uid, username, identidy, status, topicnum, postnum, credit, dateline', 'safe', 'on'=>'search'),
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
            'group'=>array(self::BELONGS_TO, 'Group', 'gid'),
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
			'uid' => 'Uid',
			'username' => 'Username',
			'identidy' => 'Identidy',
			'status' => 'Status',
			'topicnum' => 'Topicnum',
			'postnum' => 'Postnum',
			'credit' => 'Credit',
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
		$criteria->compare('gid',$this->gid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('identidy',$this->identidy);
		$criteria->compare('status',$this->status);
		$criteria->compare('topicnum',$this->topicnum);
		$criteria->compare('postnum',$this->postnum);
		$criteria->compare('credit',$this->credit);
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
	
	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
			Group::model()->findByPk($this->gid)->saveCounters(array('follownum'=>1));
		}
		return true;
	}
	
	protected function beforeDelete(){
		if (parent::beforeDelete()) {
			Group::model()->findByPk($this->gid)->saveCounters(array('follownum'=>-1));
		}
		return true;
	}

	public function Join($gid=0, $identidy=1){
		$gid = ($gid) ? $gid : (int)Yii::app()->request->getParam('gid');
		if(empty($gid)){
			return false;
		}
		$this->gid = $gid;
		$this->validate() && $this->save();
	}
	
}