<?php

/**
 * This is the model class for table "{{invite_code}}".
 *
 * The followings are the available columns in table '{{invite_code}}':
 * @property integer $id
 * @property integer $uid
 * @property string $code
 * @property integer $class
 * @property integer $status
 * @property string $dateline
 */
class InviteCode extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InviteCode the static model class
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
		return '{{invite_code}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, uid, code, class, status, dateline,inviteid,pid', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'code' => 'Code',
			'class' => 'Class',
			'status' => 'Status',
			'dateline' => 'Dateline',
			'inviteid' => 'Inviteid',
			'pid' => 'pid'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('class',$this->class);
		$criteria->compare('status',$this->status);
		$criteria->compare('dateline',$this->dateline,true);
		$criteria->compare('inviteid',$this->inviteid);
		$criteria->compare('pid',$this->pid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				if(! isset($this->uid)){ // 此处因为后台有支付平台业务员生成的invoteCode，所以这里需要判断uid和dateline，日后不需要可以删掉
					$this->uid = Yii::app()->user->id;
				}
				$this->status = 0;
				if(! isset($this->dateline)){
					$this->dateline = time();
				}
			}
		}
		return true;
	}
	
	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
			// $BusinessInfo = new BusinessInfo();
			// $BusinessInfo->bid = $this->bid;
			// $BusinessInfo->siteurl = trim($_POST['siteurl']);
			// $BusinessInfo->address = trim($_POST['address']);
			// $BusinessInfo->save();
			
			// $BusinessService = new BusinessService();
			// $BusinessService->bid = $this->bid;
			// $BusinessService->realname = trim($_POST['realname']);
			// $BusinessService->mobile = trim($_POST['mobile']);
			// $BusinessService->status = 1;
			// $BusinessService->isadmin = 1;
			// $BusinessService->save();
		}
		return true;
	}


	//创建唯一邀请码
	public function createInvite(){
		//return base64_encode(time().Yii::app()->user->id);
		$invite = '';
		for($i=0;$i<6;$i++){
			$invite .= chr(mt_rand(65,90));
		}
		return $invite;
	}

	// 生成业务员邀请平台入驻url，只有后台调用，不用可删除
	public function inviteUrl($code){
		// 有效期5天
		$auth =  HInvite::encodeInvite(array(HInvite::REG_7 , $code));
		$baseUrl = "http://www.licaipi.com/index.php?r=/index/reg";
                        return $baseUrl . '&auth=' . $auth;
	}
}
