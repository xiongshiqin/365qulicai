<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_cpid;
	public $user;
	/**
	 * const ERROR_NONE=0;
	 * const ERROR_USERNAME_INVALID=1;
	 * const ERROR_PASSWORD_INVALID=2;
	 * const ERROR_UNKNOWN_IDENTITY=100;
	 */
	public function authenticate() {
    	$this->errorCode=self::ERROR_NONE;    	
		$user = Member::model()->find('username=?', array($this->username));
		
		if($user === null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if (! $user->validataPassword($this->password))
			
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else {
			$this->_id = $user->uid;
			$this->username = $user->username;
			$this->errorCode=self::ERROR_NONE;
			$this->setState('cpid',$user->cpid);
		}
		return $this->errorCode; //==self::ERROR_NONE;
	}
	
	public function getId(){
		return $this->_id;
	}
 	
}