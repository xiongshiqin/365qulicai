<?php

/**
 * This is the model class for table "{{talk}}".
 *
 * The followings are the available columns in table '{{talk}}':
 * @property string $talkid
 * @property integer $uid
 * @property string $username
 * @property integer $fuid
 * @property string $fusername
 * @property string $content
 * @property integer $total
 * @property integer $fnum
 * @property integer $num
 * @property string $lastreply
 * @property string $dateline
 */
class Talk extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Talk the static model class
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
		return '{{talk}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, fuid, content', 'required'),
			// array('uid, fuid, total, fnum, num', 'numerical', 'integerOnly'=>true),
			// array('username, fusername', 'length', 'max'=>16),
			// array('content', 'length', 'max'=>255),
			// array('lastreply, dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('talkid, uid, username, fuid, fusername, content, total, fnum, num, lastreply, dateline', 'safe', 'on'=>'search'),
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
			'talkid' => 'Talkid',
			'uid' => 'Uid',
			'username' => 'Username',
			'fuid' => 'Fuid',
			'fusername' => 'Fusername',
			'content' => 'Content',
			'total' => 'Total',
			'fnum' => 'Fnum',
			'num' => 'Num',
			'lastreply' => 'Lastreply',
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

		$criteria->compare('talkid',$this->talkid,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('fuid',$this->fuid);
		$criteria->compare('fusername',$this->fusername,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('total',$this->total);
		$criteria->compare('fnum',$this->fnum);
		$criteria->compare('num',$this->num);
		$criteria->compare('lastreply',$this->lastreply,true);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			// 如果是新会话
			if ($this->isNewRecord) { 
				$this->username = Member::model()->findByPk($this->uid)->username;
				$this->fusername = Member::model()->findByPk($this->fuid)->username;
				$this->total = 1;
				$this->num = 0;
				$this->fnum = 1;
				$this->dateline = time();
			}
			// 否则待接收数+1 , 总数+1
			else{
				$this->total += 1;
				if(Yii::app()->user->id == $this->uid){ // 如果会话是自己发起的
					$this->fnum += 1;
				} else {
					$this->num += 1;
				}
			}
			$this->lastreply = time();
		}
		return true;
	}

	protected function afterSave(){
		parent::afterSave();
		// 插入talk_reply表
		$reply = new TalkReply();
		$reply->talkid = $this->talkid;
		$reply->uid = Yii::app()->user->id;
		$reply->username = Yii::app()->user->name;
		$reply->content = $this->content;
		$reply->save();
		// member_count表 私信数+1
		if(Yii::app()->user->id == $this->uid){ // 如果会话是自己发起的
			MemberCount::model()->findByPk($this->fuid)->saveCounters(array('talknum' =>1));
		} else {
			MemberCount::model()->findByPk($this->uid)->saveCounters(array('talknum' =>1));
		}
		return true;
	}
}