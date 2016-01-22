<?php

class ChangePasswordForm extends CFormModel
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
        if( md5($this->currentPassword) !== $this->_user->password )
        {
            $this->addError($attribute,'旧密码错误');
        }
    }

    public function init()
    {
        $this->_user = User::model()->findByAttributes( array( 'username'=>Yii::app()->user->getName() ) );
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
        $this->_user->password = md5($this->newPassword);
        $this->_user->save();
        if( $this->_user->save())
            return true;
        return false;
    }
}