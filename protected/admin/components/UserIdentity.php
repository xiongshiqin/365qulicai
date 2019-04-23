<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {
	private $_id;
	/**
	 * const ERROR_NONE=0;
	 * const ERROR_USERNAME_INVALID=1;
	 * const ERROR_PASSWORD_INVALID=2;
	 * const ERROR_UNKNOWN_IDENTITY=100;
	 */
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * 
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		$user = Admins::model()->find('username=?', array($this->username));
		$this->errorCode=self::ERROR_NONE;
		
		if($user === null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if (! $user->validataPassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else {
			$this->_id = $user->id;
			$this->username = $user->username;
			$this->errorCode=self::ERROR_NONE;
		}
		
		return $this->errorCode;//==self::ERROR_NONE;
	}
	
	public function getId(){
		return $this->_id;
	}
}