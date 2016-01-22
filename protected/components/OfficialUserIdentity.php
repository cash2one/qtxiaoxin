<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class OfficialUserIdentity extends CUserIdentity
{

    const ERROR_OFFICIAL_BLOCK = 201;

    private $_id;

    private $user;

    /**
     * Constructor.
     *
     * @param string $username
     *            username
     * @param string $password
     *            password
     * @param string $role
     *            role
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate()
    {
        $record = Account::model()->findByAttributes(array(
            'mobile' => $this->username,
            'deleted' => 0
        ));
        if ($record === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            
            $officia = OfficialInfo::getOfficialNoBlock($record->infoid);
            
            if (false == isset($officia['block']) && false == isset($officia['deleted'])) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
                
                return false;
            }
            
            if (OfficialInfo::NOT_BLOCK == $officia['block'] && OfficialInfo::NOT_DELETE == $officia['deleted']) {
                
                if ($record->pwd != MainHelper::encryPassword($this->password)) {
                    $this->errorCode = self::ERROR_PASSWORD_INVALID;
                } else {
                    $record->logintime = date("Y-m-d H:i:s");
                    $record->lastip = Yii::app()->request->getUserHostAddress();
                    $record->save();
                    
                    $this->_id = $record->acid;
                    foreach ($record->attributes as $key => $value) {
                        $this->setState($key,$value);
                    }
                    // $this->setState('infoid', $record->infoid);
                    // $this->setState('logintime', $record->logintime);
                    $this->user = $record;
                    $this->errorCode = self::ERROR_NONE;
                }
                return ! $this->errorCode;
            } else 
                if (OfficialInfo::BLOCK == $officia['block']) {
                    $this->errorCode = self::ERROR_OFFICIAL_BLOCK;
                    return false;
                } else {
                    $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                    return false;
                }
        }
    }

    public function getId()
    {
        return $this->_id;
    }
}