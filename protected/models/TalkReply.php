<?php

/**
 * This is the model class for table "{{talk_reply}}".
 *
 * The followings are the available columns in table '{{talk_reply}}':
 * @property integer $replyid
 * @property integer $talkid
 * @property integer $uid
 * @property string $username
 * @property string $content
 * @property integer $dateline
 */
class TalkReply extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TalkReply the static model class
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
		return '{{talk_reply}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('talkid, uid, username, content', 'required'),
			// array('talkid, uid, dateline', 'numerical', 'integerOnly'=>true),
			// array('username', 'length', 'max'=>16),
			// array('content', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('replyid, talkid, uid, username, content, dateline', 'safe', 'on'=>'search'),
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
			'replyid' => 'Replyid',
			'talkid' => 'Talkid',
			'uid' => 'Uid',
			'username' => 'Username',
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

		$criteria->compare('replyid',$this->replyid);
		$criteria->compare('talkid',$this->talkid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('dateline',$this->dateline);

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
}