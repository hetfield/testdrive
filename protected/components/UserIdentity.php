<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        /** @var Users $record */
        $record = Users::model()->findByAttributes(array('Username'=>$this->username));

        if($record === null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;

        else if($record->Password !== crypt($this->password, 'newsaltfortest'))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$record->ID;
            $this->setState('Role', $record->Role);
            $this->setState('Languages', $record->Languages);
            $this->errorCode=self::ERROR_NONE;
        }
		return !$this->errorCode;
	}
}