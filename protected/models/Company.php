<?php

/**
 * This is the model class for table "{{company}}".
 *
 * The followings are the available columns in table '{{company}}':
 * @property string $cpid
 * @property string $name
 * @property string $companyname
 * @property string $siteurl
 * @property integer $status
 * @property string $capital
 * @property string $legalperson
 * @property string $resideprovince
 * @property integer $resideprovinceid
 * @property string $city
 * @property integer $cityid
 * @property string $onlinetime
 * @property string $address
 * @property string $payment
 * @property integer $payid
 * @property integer $host
 * @property string $telphone
 * @property double $profitlow
 * @property double $profithigh
 * @property integer $isopen
 * @property double $lat
 * @property double $lng
 * @property string $weixin
 * @property string $weibo
 * @property string $qq
 * @property integer $event_num
 * @property integer $member_num
 * @property integer $view_num
 * @property integer $video_num
 * @property integer $pic_num
 * @property integer $isvip
 * @property string $vip_time
 * @property integer $uid
 * @property string $dateline
 * @property string $opentime
 */
class Company extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Company the static model class
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
		return '{{company}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			// array('status, resideprovinceid, cityid, payid, host, isopen, event_num, member_num, view_num, video_num, pic_num, isvip, uid', 'numerical', 'integerOnly'=>true),
			// array('profitlow, profithigh, lat, lng', 'numerical'),
			// array('name, resideprovince, city, payment, telphone', 'length', 'max'=>20),
			// array('companyname, siteurl, address, weixin, weibo, qq', 'length', 'max'=>50),
			// array('capital, legalperson, onlinetime, vip_time, dateline, opentime', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cpid, name, companyname, siteurl, status, capital, legalperson, resideprovince, resideprovinceid, city, cityid, onlinetime, address, payment, payid, host, telphone, profitlow, profithigh, isopen, lat, lng, weixin, weibo, qq, event_num, member_num, view_num, video_num, pic_num, isvip, vip_time, uid, dateline, opentime', 'safe', 'on'=>'search'),
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
			'company_info'=>array(self::HAS_ONE, 'CompanyInfo', 'cpid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cpid' => 'Cpid',
			'name' => 'Name',
			'companyname' => 'Companyname',
			'siteurl' => 'Siteurl',
			'status' => 'Status',
			'capital' => 'Capital',
			'legalperson' => 'Legalperson',
			'resideprovince' => 'Resideprovince',
			'resideprovinceid' => 'Resideprovinceid',
			'city' => 'City',
			'cityid' => 'Cityid',
			'onlinetime' => 'Onlinetime',
			'address' => 'Address',
			'payment' => 'Payment',
			'payid' => 'Payid',
			'invite_uid' => 'Invite Uid',
			'host' => 'Host',
			'telphone' => 'Telphone',
			'profitlow' => 'Profitlow',
			'profithigh' => 'Profithigh',
			'cyclelow' => 'Cyclelow',
			'cyclehigh' => 'Cyclehigh',
			'isopen' => 'Isopen',
			'lat' => 'Lat',
			'lng' => 'Lng',
			'weixin' => 'Weixin',
			'weibo' => 'Weibo',
			'qq' => 'Qq',
			'event_num' => 'Event Num',
			'member_num' => 'Member Num',
			'view_num' => 'View Num',
			'video_num' => 'Video Num',
			'pic_num' => 'Pic Num',
			'isvip' => 'Isvip',
			'vip_time' => 'Vip Time',
			'uid' => 'Uid',
			'dateline' => 'Dateline',
			'opentime' => 'Opentime',
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

		$criteria->compare('cpid',$this->cpid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('companyname',$this->companyname,true);
		$criteria->compare('siteurl',$this->siteurl,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('capital',$this->capital,true);
		$criteria->compare('legalperson',$this->legalperson,true);
		$criteria->compare('resideprovince',$this->resideprovince,true);
		$criteria->compare('resideprovinceid',$this->resideprovinceid);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('cityid',$this->cityid);
		$criteria->compare('onlinetime',$this->onlinetime,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('payment',$this->payment,true);
		$criteria->compare('payid',$this->payid);
		$criteria->compare('invite_uid' , $this->invite_uid);
		$criteria->compare('host',$this->host);
		$criteria->compare('telphone',$this->telphone,true);
		$criteria->compare('profitlow',$this->profitlow);
		$criteria->compare('profithigh',$this->profithigh);
		$criteria->compare('cyclelow',$this->cyclelow);
		$criteria->compare('cyclehigh',$this->cyclehigh);
		$criteria->compare('isopen',$this->isopen);
		$criteria->compare('lat',$this->lat);
		$criteria->compare('lng',$this->lng);
		$criteria->compare('weixin',$this->weixin,true);
		$criteria->compare('weibo',$this->weibo,true);
		$criteria->compare('qq',$this->qq,true);
		$criteria->compare('event_num',$this->event_num);
		$criteria->compare('member_num',$this->member_num);
		$criteria->compare('view_num',$this->view_num);
		$criteria->compare('video_num',$this->video_num);
		$criteria->compare('pic_num',$this->pic_num);
		$criteria->compare('isvip',$this->isvip);
		$criteria->compare('vip_time',$this->vip_time,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('dateline',$this->dateline,true);
		$criteria->compare('opentime',$this->opentime,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->siteurl = (strtolower(substr($this->siteurl,0,5)) == 'http:')?$this->siteurl:'http://'.$this->siteurl; // 标准化url
				$this->status = 0;
				$this->uid = Yii::app()->user->id;
				$this->news_num = 0;
				if(! isset($this->payment)){
					$this->payment = '';
				}
				// 设置默认经纬度
				$this->lat = 0;
				$this->lng =0; 
				$this->address = '';
				$this->cyclelow = '';
				$this->cyclehigh = '';
				// 首选支付平台
				$this->dateline = time();
			}
			$this->resideprovince = AreaProvince::model()->findByAttributes(array('provinceid' => $this->resideprovinceid))->pname;
			$this->city = AreaCity::model()->findByAttributes(array('cityid' => $this->cityid))->city;
		}
		return true;
	}
	
	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
			// 添加公司信息 
			$companyInfo = new CompanyInfo();
			$companyInfo->cpid = $this->cpid;
			$companyInfo->uid = $this->uid;
			$companyInfo->dateline = time();
			$companyInfo->info = ''; 
			$companyInfo->mainbissness = '';
			$companyInfo->operation_name = trim($_POST['operation_name']);
			$companyInfo->operation_mobile = trim($_POST['operation_mobile']);
			$companyInfo->save();

			// 当前用户添加为公司管理员
			$companyEmployee = new CompanyEmployee();
			$companyEmployee->cpid = $this->cpid;
			$companyEmployee->uid = $this->uid;
			$companyEmployee->username = Yii::app()->user->name;
			$companyEmployee->nickname = Yii::app()->user->name;
			$companyEmployee->realname = MemberInfo::model()->findByPk($this->uid)->realname;
			$companyEmployee->isadmin = 1;
			$companyEmployee->status = 1;
			$companyEmployee->department = 3; // 默认是运营部的
			$companyEmployee->opuid = $this->uid;
			$companyEmployee->dateline =time();
			$companyEmployee->save();

			// 默认关注当前平台
			$companyFollow = new CompanyFollow();
			$companyFollow->uid = $this->uid;
			$companyFollow->cpid = $this->cpid;
			$companyFollow->type = 1;
			$companyFollow->save();

			// 管理员修改个人平台信息
			Member::model()->updateByPk(Yii::app()->user->id , array('cpid' => $this->cpid));
			Yii::app()->user->setState("cpid", $this->cpid);
		}
		return true;
	}
}