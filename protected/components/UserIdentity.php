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
    public $role;

    /**
     * Constructor.
     * @param string $username username
     * @param string $password password
     * @param string $role role
     */
    public function __construct($username,$password,$role)
    {
        $this->username=$username;
        $this->password=$password;
        $this->role=$role;

        // //记cookie以防用session导致记住我功能失效
        // $cookie = new CHttpCookie(XIAOXIN_LOGIN_IDENTITY, $role);
        // $cookie->expire = time()+60*60*24*30;  //有限期30天
        // Yii::app()->request->cookies[XIAOXIN_LOGIN_IDENTITY]=$cookie;
        //记session以防浏览器禁用cookie
        $_SESSION[XIAOXIN_LOGIN_IDENTITY]=$role;
    }

    public function authenticate()
    {
        $is_mobile = is_numeric($this->username) && strlen($this->username)==11;
    	if($is_mobile){
    		$type = 'mobilephone';
    	}else{
    		$is_email = CheckHelper::IsMail($this->username);
    		if($is_email){
    			$type = 'email';
    		}else{
    			$type = 'account';
    		}
    	}
        // $sql = "CALL php_xiaoxin_GetTeacherByAttributes('". $this->username ."','". $type ."')";
        // $sql = "CALL php_xiaoxin_GetUserByAttributes('". $this->username ."','". $type ."','". $this->role ."')";
        // $record = UCQuery::queryRow($sql);
        $record = Member::getUniqueMember($this->username,$this->role,$type);
        if($record===null){
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }else if($record->pwd!=MainHelper::encryPassword($this->password)){
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        }else{
            $record->lastlogintime = date("Y-m-d H:i:s");
            $record->lastloginip = Yii::app()->request->getUserHostAddress();
            $record->save(); 
            
            $this->_id=$record->userid;
            $this->user=$record;
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}