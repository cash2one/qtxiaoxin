<?php

class UChangePasswordForm extends CFormModel
{
    public $currentPassword;
    public $newPassword;
    public $newPassword_repeat;
    private $_user;
  
    public function rules()
    {
        return array(
            array(
            'currentPassword', 'compareCurrentPassword'
            ),
            array(
            'currentPassword, newPassword, newPassword_repeat', 'required',
            'message'=>'{attribute}为必填项',
            ),
            array(
            'newPassword_repeat', 'compare',
            'compareAttribute'=>'newPassword',
            'message'=>'新密码和确认密码不一致',
            ),

        );
    }

    public function compareCurrentPassword($attribute,$params)
    {
        if( MainHelper::encryPassword($this->currentPassword) !== $this->_user->pwd)
        {
            $this->addError($attribute,'旧密码错误');
        }
    }

    public function init()
    {
        $this->_user = Yii::app()->user->getInstance();
    }

    public function attributeLabels()
    {
        return array(
            'currentPassword'=>'旧密码',
            'newPassword'=>'新密码',
            'newPassword_repeat'=>'确认密码',
        );
    }

    public function changePassword()
    {
        $pwd = MainHelper::encryPassword($this->newPassword);
        $this->_user->pwd = $pwd;
        $sql = "CALL php_xiaoxin_UpdateUserPwd('".$this->_user->userid."','".$pwd."')";
        $errors = UCQuery::updateTrans($sql);
        if(!$errors)
            return true;
        return false;
    }
}