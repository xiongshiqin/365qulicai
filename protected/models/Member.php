<?php

/**
 * This is the model class for table "{{member}}".
 *
 * The followings are the available columns in table '{{member}}':
 * @property integer $uid
 * @property string $username
 * @property string $password
 * @property integer $status
 * @property string $salt
 * @property string $mobile
 * @property string $email
 * @property integer $emailstatus
 * @property integer $avatarstatus
 * @property integer $realstatus
 * @property integer $mobilestatus
 * @property integer $groupid
 */
class Member extends CActiveRecord
{
	public $password_repeat;
	public $mobile_code;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Member the static model class
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
		return '{{member}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('status, emailstatus, avatarstatus, realstatus, mobilestatus, groupid', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>16),
			array('password', 'length', 'max'=>32),
			array('salt', 'length', 'max'=>4),
			// array('mobile', 'length', 'max'=>12),
			array('email', 'length', 'max'=>50),
			
			array('mobile', 'match', 'pattern'=>'/^1[2|3|4|56|7||8|9]\d{9}$/', 'message'=>'请输入正确的11位手机号码'),
			//array('agree', 'required', 'on'=>'register'),
			array('mobile', 'required', 'on'=>'register'),
			//array('mobile_code', 'required', 'on'=>'register'),
			array('password_repeat', 'compare', 'compareAttribute'=>'password', 'on'=>'register'),
			array('username', 'unique', 'on'=>'register', 'message'=>'这个用户名已经被人使用了'), //用户名唯一
			array('mobile', 'unique', 'on'=>'register', 'message'=>'这个手机号已经被人使用了'), //手机号唯一

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
			'info' => array(self::HAS_ONE, 'MemberInfo', 'uid'),
			'member_status' => array(self::HAS_ONE, 'MemberStatus', 'uid'),
			'count' => array(self::HAS_ONE, 'MemberCount', 'uid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => 'Uid',
			'username' => 'Username',
			'password' => 'Password',
			'status' => 'Status',
			'salt' => 'Salt',
			'mobile' => 'Mobile',
			'cpid' => 'Cpid',
			'email' => 'Email',
			'emailstatus' => 'Emailstatus',
			'avatarstatus' => 'Avatarstatus',
			'realstatus' => 'Realstatus',
			'mobilestatus' => 'Mobilestatus',
			'groupid' => 'Groupid',
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('cpid',$this->cpid,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('emailstatus',$this->emailstatus);
		$criteria->compare('avatarstatus',$this->avatarstatus);
		$criteria->compare('realstatus',$this->realstatus);
		$criteria->compare('mobilestatus',$this->mobilestatus);
		$criteria->compare('groupid',$this->groupid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function primaryKey(){
		return 'uid';
	}
	
	/**
	 * 验证密码
	 * @param string $password
	 */
	public function validataPassword($password){
		return $this->hash($password, $this->salt) === $this->password;
	}
	
	//hash md5
	public function hash($password, $salt){
		return md5($password . md5($salt));
	}
	
	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->mobilestatus = 1;
				$this->salt = $this->random(4);
				$this->password = $this->hash($this->password, $this->salt);
				if(in_array($this->mobile , Yii::app()->params['empMobiles'])){ // 测试的手机不入库
					$this->mobile = 0;
				}
			}
		}
		return true;
	}
	
	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
		    	$inviteuid = Yii::app()->request->cookies['inviteuid'] ;
		    	
		    	$MemberCount = new MemberCount;
		    	$MemberCount->uid = $this->uid;
		    	$MemberCount->save();
		    	
		    	$MemberInfo = new MemberInfo;
		    	$MemberInfo->uid = $this->uid;
		    	$MemberInfo->save();
		
		    	$MemberStatus = new MemberStatus;
		    	$MemberStatus->uid = $this->uid;
		    	$MemberStatus->regdate = $MemberStatus->lastvisit = time();
		    	$MemberStatus->regip = $MemberStatus->lastip = HComm::ip2int(Yii::app()->request->userHostAddress);
		    	$MemberStatus->visitnum = 1;
		    	$MemberStatus->save();
		}
	}
	
	//随机数
	protected function random($length, $numeric = 0) {
		$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $seed{mt_rand(0, $max)};
		}
		return $hash;
	}
}