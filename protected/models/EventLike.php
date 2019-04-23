<?php

/**
 * This is the model class for table "{{event_like}}".
 *
 * The followings are the available columns in table '{{event_like}}':
 * @property string $id
 * @property integer $num
 * @property integer $eventid
 * @property integer $p2pid
 * @property integer $uid
 * @property string $username
 * @property integer $lotterynum
 * @property integer $canlotterynum
 * @property integer $vip
 * @property integer $invitenum
 * @property integer $inviteuid
 * @property string $log
 * @property string $dateline
 */
class EventLike extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EventLike the static model class
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
		return '{{event_like}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eventid, p2pid', 'required'),
			// array('num, eventid, p2pid, uid, lotterynum, canlotterynum, vip, invitenum, inviteuid', 'numerical', 'integerOnly'=>true),
			// array('username', 'length', 'max'=>16),
			// array('log', 'length', 'max'=>255),
			// array('dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, num, eventid, p2pid, uid, username, lotterynum, canlotterynum, vip, invitenum, inviteuid, log, dateline', 'safe', 'on'=>'search'),
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
			// 已经特别发放的奖品
			'special_awards' => array(self::HAS_MANY, 'EventAwardLog', '', 'on' => 'special_awards.type = 1 and special_awards.eventid = t.eventid and special_awards.uid = t.uid'),
			// 关注表，用于按 '参加活动次数' 排序
			'company_follow' => array(self::HAS_ONE, 'CompanyFollow', '', 'on' => 'company_follow.cpid = t.p2pid and company_follow.uid = t.uid'),
			// 点赞过的活动的信息
			'event' => array(self::HAS_ONE, 'Event', '', 'on' => 'event.eventid = t.eventid'),
			// 发布活动的平台信息
			'company' => array(self::HAS_ONE, 'Company', '', 'on' => 'company.cpid = t.p2pid'),
			// 中奖信息
			'lottery_award_list' => array(self::HAS_MANY, 'LotteryAwardList', '', 'on' => 'lottery_award_list.eventid = t.eventid and lottery_award_list.uid = t.uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'num' => 'Num',
			'eventid' => 'Eventid',
			'p2pid' => 'P2pid',
			'uid' => 'Uid',
			'username' => 'Username',
			'lotterynum' => 'Lotterynum',
			'canlotterynum' => 'Canlotterynum',
			'vip' => 'Vip',
			'invitenum' => 'Invitenum',
			'inviteuid' => 'Inviteuid',
			'log' => 'Log',
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
		$criteria->compare('num',$this->num);
		$criteria->compare('eventid',$this->eventid);
		$criteria->compare('p2pid',$this->p2pid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('lotterynum',$this->lotterynum);
		$criteria->compare('canlotterynum',$this->canlotterynum);
		$criteria->compare('vip',$this->vip);
		$criteria->compare('invitenum',$this->invitenum);
		$criteria->compare('inviteuid',$this->inviteuid);
		$criteria->compare('log',$this->log,true);
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
				if($this->exists("eventid = " . $this->eventid)){
					$this->num = $this->find(array(
							'condition' => "eventid = " . $this->eventid,
							'order' => 'num desc',
							))->num + 1;  // num为得到最后一个num+1
				} else {
					$this->num = 1;
				}
				$this->dateline = time();
			}
		}
		return true;
	}

	protected function afterSave(){
		parent::afterSave();
		if($this->isNewRecord){
			// 会员活动点赞数+1
			MemberCount::model()->findByPk($this->uid)->saveCounters(array('eventlikenum'=>1));
			// 活动点赞数+1
			Event::model()->findByPk($this->eventid)->saveCounters(array('likenum'=>1));
			// 公司关联表当前用户参加该公司活动次数+1
			// 如果关注了公司
			if($follow = CompanyFollow::model()->findByAttributes(array('uid' => $this->uid , 'cpid' => $this->p2pid))){
				$follow->saveCounters(array('join_event_num' =>1));
			}
		}
		return true;
	}
}