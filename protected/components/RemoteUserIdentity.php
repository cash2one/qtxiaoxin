<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class RemoteUserIdentity extends CUserIdentity
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
    public function __construct($record,$role)
    {
        // conlog($record);
        $this->_id=$record->userid;
        $this->user=$record;
        $this->role=$role;
        $_SESSION[XIAOXIN_LOGIN_IDENTITY]=$role;
        // $this->uinstance=$record;
        // $this->username = $record->account;
        // $this->password = $record->pwd;
    }

    public function authenticate()
    {
            // conlog($this->uinstance);
            // $this->_id=$record->userid;
            // $this->user=$record;
            $this->errorCode=self::ERROR_NONE;
            return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}