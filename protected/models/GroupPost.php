<?php

/**
 * This is the model class for table "{{group_post}}".
 *
 * The followings are the available columns in table '{{group_post}}':
 * @property string $postid
 * @property integer $topicid
 * @property integer $gid
 * @property string $title
 * @property integer $uid
 * @property string $username
 * @property string $content
 * @property integer $istopic
 * @property integer $likenum
 * @property integer $del
 * @property string $ip
 * @property string $dateline
 */
class GroupPost extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GroupPost the static model class
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
		return '{{group_post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content', 'required'),
			array('topicid, gid, uid, istopic, likenum, del', 'numerical', 'integerOnly'=>true),
			array('postid, ip, dateline', 'length', 'max'=>10),
			array('title', 'length', 'max'=>50),
			array('username', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('postid, topicid, gid, title, uid, username, content, istopic, likenum, del, ip, dateline', 'safe', 'on'=>'search'),
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
			'postid' => 'Postid',
			'topicid' => 'Topicid',
			'gid' => 'Gid',
			'title' => 'Title',
			'uid' => 'Uid',
			'username' => 'Username',
			'content' => 'Content',
			'istopic' => 'Istopic',
			'likenum' => 'Likenum',
			'del' => 'Del',
			'ip' => 'Ip',
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

		$criteria->compare('postid',$this->postid,true);
		$criteria->compare('topicid',$this->topicid);
		$criteria->compare('gid',$this->gid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('istopic',$this->istopic);
		$criteria->compare('likenum',$this->likenum);
		$criteria->compare('del',$this->del);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	protected function beforeSave(){
		parent::beforeSave();
		if ($this->isNewRecord)  {
			$this->uid=Yii::app()->user->id;
			$this->username=Yii::app()->user->name;
			$this->ip=HComm::ip2int(Yii::app()->request->userHostAddress);
			$this->dateline=time();
		}
		return true;
	}
	
	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
			if($this->istopic != 1 ){			
				GroupTopic::model()->updateByPk($this->topicid, array('dateline'=>time()));
				GroupTopic::model()->findByPk($this->topicid)->saveCounters(array('replynum'=>1));
				Group::model()->findByPk($this->gid)->saveCounters(array('postnum'=>1));

			}else {			
				Group::model()->findByPk($this->gid)->saveCounters(array('topicnum'=>1));
				MemberCount::model()->findByPk(Yii::app()->user->id)->saveCounters(array('postnum'=>1));
			}
		}
		return true;
	}
}