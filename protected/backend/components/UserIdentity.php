<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    private $user;
    public function authenticate()
    {
        $record=User::model()->findByAttributes(array('username'=>$this->username,'deleted'=>0,'isnewuser'=>0));
        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($record->password!==md5($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$record->uid;
            $this->user=$record;
            // $this->setState('title', $record->title);
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->username;
    }

    public function getInstance()
    {
        return $this->user;
    }

    public function getUser()
    {
        return $this->user;
    }
 
    public function setUser(CActiveRecord $user)
    {
        $this->user=$user->attributes;
    }
}