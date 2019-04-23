<?php

/**
 * This is the model class for table "{{group_topic}}".
 *
 * The followings are the available columns in table '{{group_topic}}':
 * @property integer $topicid
 * @property integer $gid
 * @property string $title
 * @property integer $uid
 * @property string $username
 * @property integer $del
 * @property string $ip
 * @property integer $replynum
 * @property integer $viewnum
 * @property integer $likenum
 * @property string $addtime
 * @property string $dateline
 */
class GroupTopic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GroupTopic the static model class
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
		return '{{group_topic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('topicid, gid, uid, del, replynum, viewnum, likenum', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),
			array('username', 'length', 'max'=>16),
			array('ip, addtime, dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('topicid, gid, title, uid, username, del, ip, replynum, viewnum, likenum, addtime, dateline', 'safe', 'on'=>'search'),
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
			'post' => array(self::HAS_MANY, 'GroupPost', 'topicid'),
			'group' => array(self::BELONGS_TO, 'Group', 'gid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'topicid' => 'Topicid',
			'gid' => 'Gid',
			'title' => 'Title',
			'uid' => 'Uid',
			'username' => 'Username',
			'del' => 'Del',
			'ip' => 'Ip',
			'replynum' => 'Replynum',
			'viewnum' => 'Viewnum',
			'likenum' => 'Likenum',
			'addtime' => 'Addtime',
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

		$criteria->compare('topicid',$this->topicid);
		$criteria->compare('gid',$this->gid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('del',$this->del);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('replynum',$this->replynum);
		$criteria->compare('viewnum',$this->viewnum);
		$criteria->compare('likenum',$this->likenum);
		$criteria->compare('addtime',$this->addtime,true);
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
				$this->ip =  HComm::ip2int(Yii::app()->request->userHostAddress);
				$this->addtime = $this->dateline = time();
				$this->del = 0;
			}
		}
		return true;
	}
	
	protected function afterSave(){
		if ($this->isNewRecord) {
			parent::afterSave();
			$GroupPost = new GroupPost;
			$GroupPost->topicid	= $this->topicid;		
			$GroupPost->title	= HComm::Ahtmlspecialchars($_POST['title']);
			$GroupPost->istopic	= 1;
			$GroupPost->gid	= $this->gid;
			$GroupPost->content	= HComm::Ahtmlspecialchars($_POST['content']);
			$GroupPost->validate() && $GroupPost->save();
		}
	}
}