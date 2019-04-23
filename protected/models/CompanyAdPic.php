<?php

/**
 * This is the model class for table "{{company_ad_pic}}".
 *
 * The followings are the available columns in table '{{company_ad_pic}}':
 * @property string $id
 * @property string $title
 * @property integer $cpid
 * @property string $picurl
 * @property string $place
 * @property string $url
 * @property integer $status
 * @property integer $order
 * @property integer $viewnum
 * @property string $dateline
 */
class CompanyAdPic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyAdPic the static model class
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
		return '{{company_ad_pic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('title, cpid, picurl, place, url', 'required'),
			// array('cpid, status, order, viewnum', 'numerical', 'integerOnly'=>true),
			// array('title, picurl, url', 'length', 'max'=>100),
			// array('place', 'length', 'max'=>8),
			// array('dateline', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, cpid, picurl, place, url, status, order, viewnum, dateline', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'cpid' => 'Cpid',
			'picurl' => 'Picurl',
			'place' => 'Place',
			'url' => 'Url',
			'status' => 'Status',
			'order' => 'Order',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('cpid',$this->cpid);
		$criteria->compare('picurl',$this->picurl,true);
		$criteria->compare('place',$this->place,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('order',$this->order);
		$criteria->compare('viewnum',$this->viewnum);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->url = (strtolower(substr($this->url,0,5)) == 'http:')?$this->url:'http://'.$this->url; // 标准化url
				$this->dateline = time();
			}
		}
		return true;
	}
}