<?php

/**
 * This is the model class for table "{{group}}".
 *
 * The followings are the available columns in table '{{group}}':
 * @property integer $gid
 * @property string $name
 * @property integer $class
 * @property string $nickname
 * @property string $info
 * @property integer $status
 * @property integer $jointype
 * @property integer $addtype
 * @property integer $viewtype
 * @property integer $isreview
 * @property integer $follownum
 * @property integer $postnum
 * @property integer $topicnum
 * @property integer $credit
 * @property string $dateline
 */
class Group extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Group the static model class
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
		return '{{group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, info', 'required'),
			array('gid, class, status, jointype, addtype, viewtype, isreview, follownum, postnum, topicnum, credit', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>25),
			array('nickname, dateline', 'length', 'max'=>10),
			array('info', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('gid, name, class, username, nickname, info, status, jointype, addtype, viewtype, isreview, follownum, postnum, topicnum, credit, dateline', 'safe', 'on'=>'search'),
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
			'gid' => 'Gid',
			'name' => 'Name',
			'class' => 'Class',
			'nickname' => 'Nickname',
			'info' => 'Info',
			'status' => 'Status',
			'jointype' => 'Jointype',
			'addtype' => 'Addtype',
			'viewtype' => 'Viewtype',
			'isreview' => 'Isreview',
			'follownum' => 'Follownum',
			'postnum' => 'Postnum',
			'topicnum' => 'Topicnum',
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

		$criteria->compare('gid',$this->gid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('class',$this->class);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('jointype',$this->jointype);
		$criteria->compare('addtype',$this->addtype);
		$criteria->compare('viewtype',$this->viewtype);
		$criteria->compare('isreview',$this->isreview);
		$criteria->compare('follownum',$this->follownum);
		$criteria->compare('postnum',$this->postnum);
		$criteria->compare('topicnum',$this->topicnum);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->dateline = time();
			}
		}
		return true;
	}
	
	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
			$GroupUser = new GroupUser;
			$GroupUser->gid = $this->gid;
			$GroupUser->identidy = 9;
			$GroupUser->status = 1;
			$GroupUser->save();
		}
		return true;
	}
}