<?php

/**
 * This is the model class for table "{{business}}".
 *
 * The followings are the available columns in table '{{business}}':
 * @property string $bid
 * @property string $shortname
 * @property string $name
 * @property integer $type
 * @property integer $status
 * @property integer $p2pnum
 * @property integer $membernum
 * @property string $vrify_time
 * @property string $dateline
 */
class Business extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Business the static model class
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
		return '{{business}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shortname, name', 'required'),
			array('type, status, p2pnum, membernum', 'numerical', 'integerOnly'=>true),
			array('bid, shortname, vrify_time, dateline', 'length', 'max'=>10),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('bid, shortname, name, type, status, p2pnum, membernum, vrify_time, dateline', 'safe', 'on'=>'search'),
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
			'business_info'=>array(self::HAS_ONE, 'BusinessInfo', '' , 'on' => 't.bid = business_info.bid'),
			'business_service'=>array(self::HAS_ONE,'BusinessService','bid','on'=>'business_service.isadmin = 1'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	 public function attributeLabels()
	{
		return array(
			'bid' => 'Bid',
			'shortname' => 'Shortname',
			'name' => 'Name',
			'type' => 'Type',
			'status' => 'Status',
			'p2pnum' => 'P2pnum',
			'membernum' => 'Membernum',
			'vrify_time' => 'Vrify Time',
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

		$criteria->compare('bid',$this->bid,true);
		$criteria->compare('shortname',$this->shortname,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);
		$criteria->compare('p2pnum',$this->p2pnum);
		$criteria->compare('membernum',$this->membernum);
		$criteria->compare('vrify_time',$this->vrify_time,true);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getUrl()
	{
		return Yii::app()->createUrl('business/index', array(
			'id'=>$this->bid,
			'title'=>$this->shortname,
		));
	}
	
	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->status = 1;
				$this->dateline = time();
			}
		}
		return true;
	}
	
	protected function afterSave(){
		parent::afterSave();
		$BusinessService = new BusinessService();
		$BusinessInfo = new BusinessInfo();
		if (!$this->isNewRecord) { // edit by porter 新增和修改Business表都会联动这2个表
			$BusinessInfo = $BusinessInfo->findByAttributes(array('bid'=>$this->bid));
			$BusinessInfo->telephone = $_POST['telephone'];
			$BusinessInfo->fax = $_POST['fax'];
			$BusinessInfo->weibo = $_POST['weibo'];
			$BusinessInfo->logo = $_POST['logo'];
			$BusinessInfo->weixin = $_POST['weixin'];
			
			$BusinessService = $BusinessService->findByAttributes(array('bid'=>$this->bid,'isadmin'=>1));
		}else { //否则插入info标的时候初始化这两条信息

			$BusinessInfo->info = ' ';
			$BusinessInfo->mainbissness= ' ';
			$BusinessInfo->logo = ' ';

			$BusinessService->pic = ' ';
			// $BusinessService->opuid = Yii::app()->user->id;
			$BusinessService->opuid = 0;
		}
		$BusinessInfo->bid = $this->bid;
		$url = trim($_POST['siteurl']);
		$BusinessInfo->siteurl = (strtolower(substr($url,0,5)) == 'http:')?$url:'http://'.$url; // 标准化url
		$BusinessInfo->address = trim($_POST['address']);
		$BusinessInfo->save();

		$BusinessService->bid = $this->bid;
		$BusinessService->realname = isset($_POST['realname']) ? trim($_POST['realname']) : '';
		$BusinessService->mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : 0;
		$BusinessService->status = 1;
		$BusinessService->isadmin = 1;
		$BusinessService->save();
		return true;
	}
}