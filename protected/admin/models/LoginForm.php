<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;
	public $verifyCode;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password, verifyCode', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
			 array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()), 
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			//'rememberMe'=>Yii::t('user',"Remember me next time"),  
            'username'=>Yii::t('user',"username or email"),  
            'password'=>Yii::t('user',"password"),  
            'verifyCode'=>Yii::t('user','Verification Code'),  
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if (! $this->hasErrors ()) {
			$this->_identity = new UserIdentity ( $this->username, $this->password );
			if ( $error = $this->_identity->authenticate ())
				if ( 1 == $error)
					$this->addError ( 'error', '后台没有这个帐号' );
				elseif ( 2 == $error)
					$this->addError ( 'error', '后台账号密码错误' );
				elseif ( 3 == $error)
					$this->addError ( 'error', '你的后台帐号还没有激活。请登陆邮箱,激活帐号' );
				else
					$this->addError ( 'error', '后台未知错误，请重试' );
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
