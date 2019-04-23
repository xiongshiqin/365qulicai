<?php

/**
 * This is the model class for table "{{company_news}}".
 *
 * The followings are the available columns in table '{{company_news}}':
 * @property string $id
 * @property integer $cpid
 * @property string $title
 * @property string $content
 * @property integer $uid
 * @property integer $viewnum
 * @property integer $order
 * @property string $dateline
 */
class CompanyNews extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyNews the static model class
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
		return '{{company_news}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(', title, content', 'required'),
			// array('cpid, uid, viewnum, order', 'numerical', 'integerOnly'=>true),
			// array('title', 'length', 'max'=>50),
			// array('dateline', 'length', 'max'=>10),
			// // The following rule is used by search().
			// // Please remove those attributes that should not be searched.
			array('id, cpid, title, content, uid, viewnum, order, dateline', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO ,'Company','cpid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cpid' => 'Cpid',
			'title' => 'Title',
			'content' => 'Content',
			'uid' => 'Uid',
			'viewnum' => 'Viewnum',
			'order' => 'Order',
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
		$criteria->compare('cpid',$this->cpid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('viewnum',$this->viewnum);
		$criteria->compare('order',$this->order);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->viewnum = 1;
				$this->uid = Yii::app()->user->id;
				$this->order = 1;
				$this->dateline = time();
			}
		}
		return true;
	}
	
	protected function afterSave(){
		parent::afterSave();
		if($this->isNewRecord){
			// 公司公告数+1
			Company::model()->updateCounters(array('news_num' => 1) , 'cpid = ' . $this->cpid);
		}
		return true;
	}
}