<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class RemoteAccountIdentity extends CUserIdentity
{
    private $_id;
    private $user;
    public $uinstance;
    public $role;

    /**
     * Constructor.
     * @param string $username username
     * @param string $password password
     * @param string $role role
     */
    public function __construct($record)
    {
        // conlog($record);
        $this->_id=$record->acid;
        $this->user=$record;
        foreach ($record->attributes as $key => $value) {
            $this->setState($key,$value);
        }
        // $this->setState('infoid', $record->infoid);
        // $this->setState('logintime', $record->logintime);
    }

    public function authenticate()
    {
        $this->errorCode=self::ERROR_NONE;
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}