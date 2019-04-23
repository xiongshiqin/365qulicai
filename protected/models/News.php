<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property integer $newsid
 * @property integer $classid
 * @property integer $status
 * @property integer $uid
 * @property string $username
 * @property integer $pid
 * @property string $pname
 * @property string $title
 * @property string $pic
 * @property string $summary
 * @property string $content
 * @property integer $viewnum
 * @property integer $repaynum
 * @property integer $order
 * @property integer $verifytime
 * @property integer $dateline
 */
class News extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return News the static model class
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
		return '{{news}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('classid', 'required'),
			array('classid, status, uid, pid, viewnum, replynum, order, verifytime, dateline', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>16),
			array('pname, title', 'length', 'max'=>50),
			array('pic, summary', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('newsid, classid, status, uid, username, pid, pname, title, pic, summary, content, viewnum, replynum, order, verifytime, dateline', 'safe', 'on'=>'search'),
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
			'newsid' => 'Newsid',
			'classid' => 'Classid',
			'status' => 'Status',
			'uid' => 'Uid',
			'username' => 'Username',
			'pid' => 'Pid',
			'pname' => 'Pname',
			'title' => 'Title',
			'pic' => 'Pic',
			'summary' => 'Summary',
			'content' => 'Content',
			'viewnum' => 'Viewnum',
			'replynum' => 'Replynum',
			'order' => 'Order',
			'verifytime' => 'Verifytime',
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

		$criteria->compare('newsid',$this->newsid);
		$criteria->compare('classid',$this->classid);
		$criteria->compare('status',$this->status);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('pid',$this->pid);
		$criteria->compare('pname',$this->pname,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('pic',$this->pic,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('viewnum',$this->viewnum);
		$criteria->compare('repaynum',$this->repaynum);
		$criteria->compare('order',$this->order);
		$criteria->compare('verifytime',$this->verifytime);
		$criteria->compare('dateline',$this->dateline);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				if(! isset($this->status)){
					$this->status = 0;
				}
				if(!isset($this->uid)){
					$this->uid = Yii::app()->user->id;
					$this->username = Yii::app()->user->name;
				}
				if(!isset($this->pid)){
					$this->pid = 0;
					$this->pname = '';
				}
				$this->dateline = time();
			}
		}
		return true;
	}
}