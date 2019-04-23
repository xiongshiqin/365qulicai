<?php

/**
 * This is the model class for table "{{event}}".
 *
 * The followings are the available columns in table '{{event}}':
 * @property integer $eventid
 * @property string $title
 * @property integer $uid
 * @property string $username
 * @property integer $p2pid
 * @property integer $status
 * @property integer $class
 * @property string $starttime
 * @property string $endtime
 * @property integer $likenum
 * @property integer $likegift
 * @property integer $lotterytype
 * @property integer $viewnum
 * @property integer $messagenum
 * @property integer $awardnum
 * @property integer $picnum
 * @property string $dateline
 */
class Event extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Event the static model class
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
		return '{{event}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, type,starttime,endtime,lotterytype,', 'required'),
			// array('uid, p2pid, status, class, likenum, likegift, lotterytype, viewnum, messagenum, awardnum, picnum', 'numerical', 'integerOnly'=>true),
			// array('title', 'length', 'max'=>50),
			// array('username', 'length', 'max'=>16),
			// array('starttime, endtime, dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('eventid, title, uid, username, p2pid, status, class, starttime, endtime, likenum, likegift, lotterytype, viewnum, messagenum, awardnum, picnum, dateline', 'safe', 'on'=>'search'),
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
			'event_field' => array(self::HAS_ONE,'EventField','eventid'),
			'company' => array(self::BELONGS_TO,'Company','' , 'on' => 't.p2pid = company.cpid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'eventid' => 'Eventid',
			'title' => 'Title',
			'uid' => 'Uid',
			'username' => 'Username',
			'p2pid' => 'P2pid',
			'status' => 'Status',
			'class' => 'Class',
			'starttime' => 'Starttime',
			'endtime' => 'Endtime',
			'likenum' => 'Likenum',
			'likegift' => 'Likegift',
			'lotterytype' => 'Lotterytype',
			'viewnum' => 'Viewnum',
			'messagenum' => 'Messagenum',
			'awardnum' => 'Awardnum',
			'picnum' => 'Picnum',
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

		$criteria->compare('eventid',$this->eventid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('p2pid',$this->p2pid);
		$criteria->compare('status',$this->status);
		$criteria->compare('class',$this->class);
		$criteria->compare('starttime',$this->starttime,true);
		$criteria->compare('endtime',$this->endtime,true);
		$criteria->compare('likenum',$this->likenum);
		$criteria->compare('likegift',$this->likegift);
		$criteria->compare('lotterytype',$this->lotterytype);
		$criteria->compare('viewnum',$this->viewnum);
		$criteria->compare('messagenum',$this->messagenum);
		$criteria->compare('awardnum',$this->awardnum);
		$criteria->compare('picnum',$this->picnum);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->uid = Yii::app()->user->id;
				$this->username = Member::model()->findByPk($this->uid)->username;	
				// 如果为不抽奖，则直接通过审核	
				if($this->lotterytype === 0){
					$this->status = 2;
					// 平台活动数+1
					Company::model()->updateCounters(array('event_num' => 1) , "cpid = " . $this->p2pid);
				}
				$this->dateline = time();	
			}

			// 如果添加新活动，则插入一条时间和当前活动时间一样的抽奖活动
		}
		return true;
	}
	
	protected function afterSave(){
		parent::afterSave();
		$eventField = new EventField();
		$eventField->eventid = $this->eventid;
		
		if(! $this->isNewRecord){
			$eventField = $eventField->findByPk($this->eventid);
		}

		$content = trim($_POST['content']); //防止内容为空没有插入eventField表数据
		$eventField->content = $content ? $content : '未设置';
		$eventField->save();

		// 如果添加新活动，则插入一条时间和当前活动时间一样的抽奖活动
		if($this->isNewRecord){
			// 插入event表后插入lottery表
			$lottery = new Lottery();
			$lottery->eventid = $this->eventid;
			$lottery->starttime = $this->starttime;
			$lottery->endtime = $this->endtime;
			$lottery->type = $this->type;
			$lottery->awardnum = 0;
			$lottery->awardchance = 0;  // 默认一人一次
			$lottery->awardprecondition = 1; //默认关注平台即可
			$lottery->save();
			// 这里没有平台活动数加一，加一操作放在审核通过时
		}
		return true;
	}
}