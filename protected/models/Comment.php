<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $cid
 * @property integer $toid
 * @property integer $uid
 * @property string $username
 * @property integer $parent_id
 * @property string $content
 * @property integer $status
 * @property integer $dateline
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
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
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('toid, content', 'required'),
			array('toid, uid, parent_id, status, dateline', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>16),
			array('content', 'length', 'max'=>3000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cid, toid, uid, username, parent_id, content, status, dateline', 'safe', 'on'=>'search'),
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
			'cid' => 'Cid',
			'toid' => 'Toid',
			'uid' => 'Uid',
			'username' => 'Username',
			'parent_id' => 'Parent',
			'content' => 'Content',
			'type' => 'Type',
			'likenum' => 'Likenum',
			'dislikenum' => 'Dislikenum',
			'status' => 'Status',
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

		$criteria->compare('cid',$this->cid);
		$criteria->compare('toid',$this->toid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('likenum',$this->likenum,true);
		$criteria->compare('dislikenum',$this->dislikenum,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('dateline',$this->dateline);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->uid = Yii::app()->user->id;
				$this->username = Yii::app()->user->name;
				$this->status = 1;
				$this->dateline = time();
			}
		}
		return true;
	}

	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
			if($this->type == '1'){
				News::model()->updateCounters(array('replynum' => 1) , "newsid = " . $this->toid);
			} else if($this->type == '2'){
				Event::model()->updateCounters(array('replynum' => 1) , 'eventid = ' . $this->toid);
			}
		}
		return true;
	}
}