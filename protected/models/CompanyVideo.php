<?php

/**
 * This is the model class for table "{{company_video}}".
 *
 * The followings are the available columns in table '{{company_video}}':
 * @property string $id
 * @property integer $cpid
 * @property string $title
 * @property string $url
 * @property string $source
 * @property integer $uid
 * @property integer $viewnum
 * @property string $dateline
 */
class CompanyVideo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyVideo the static model class
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
		return '{{company_video}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cpid, title, url, source', 'required'),
			// array('cpid, uid, viewnum', 'numerical', 'integerOnly'=>true),
			// array('title', 'length', 'max'=>50),
			// array('url, source', 'length', 'max'=>100),
			// array('dateline', 'length', 'max'=>10),
			// // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cpid, title, url, source, uid, viewnum, dateline', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'cpid' => 'Cpid',
			'title' => 'Title',
			'url' => 'Url',
			'source' => 'Source',
			'uid' => 'Uid',
			'viewnum' => 'Viewnum',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('viewnum',$this->viewnum);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->uid = Yii::app()->user->id;
				$this->dateline = time();
			}
		}
		return true;
	}
}