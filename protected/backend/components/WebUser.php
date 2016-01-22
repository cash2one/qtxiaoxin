<?php
/**
* @author panrj 2014-06-05
* 继承CWebUser组建
*/

class WebUser extends CWebUser
{
    public $authTimeout=1800;
    public function __get($name)
    {
        if ($this->hasState('__userInfo')) {
            $user=$this->getState('__userInfo',array());
            if (isset($user[$name])) {
                return $user[$name];
            }
        }
 
        return parent::__get($name);
    }
 
    // public function login($identity, $duration) {
    //     $this->setState('__userInfo', $identity->getUser());
    //     parent::login($identity, $duration);
    // }

    public function getLogo()
    {
        if(Yii::app()->user->isGuest)
            return Yii::app()->request->baseUrl.'/image/user_pic.jpg';
        $user = User::model()->loadByPk(Yii::app()->user->id);
        if($user->logo){
            return $user->logo;
        }else{
            return Yii::app()->request->baseUrl.'/image/user_pic.jpg';
        }
    }
    
    public function getRealName()
    {
        if(Yii::app()->user->isGuest)
            return '匿名用户';
        $user = User::model()->loadByPk(Yii::app()->user->id);
        if($user->name){
            return $user->name;
        }else{
            return $user->username;
        }
    }
}