<?php

/**
 * This is the model class for table "{{company_pic}}".
 *
 * The followings are the available columns in table '{{company_pic}}':
 * @property string $id
 * @property integer $cpid
 * @property string $picname
 * @property string $url
 * @property integer $album
 * @property integer $uid
 * @property integer $viewnum
 * @property integer $replynum
 * @property string $dateline
 */
class CompanyPic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyPic the static model class
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
		return '{{company_pic}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cpid, picname, url', 'required'),
			// array('cpid, album, uid, viewnum, replynum', 'numerical', 'integerOnly'=>true),
			// array('picname', 'length', 'max'=>20),
			// array('url', 'length', 'max'=>100),
			// array('dateline', 'length', 'max'=>10),
			// // The following rule is used by search().
			// // Please remove those attributes that should not be searched.
			array('id, cpid, picname, url, album, uid, viewnum, replynum, dateline', 'safe', 'on'=>'search'),
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
			'picname' => 'Picname',
			'url' => 'Url',
			'album' => 'Album',
			'uid' => 'Uid',
			'viewnum' => 'Viewnum',
			'replynum' => 'Replynum',
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
		$criteria->compare('picname',$this->picname,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('album',$this->album);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('viewnum',$this->viewnum);
		$criteria->compare('replynum',$this->replynum);
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