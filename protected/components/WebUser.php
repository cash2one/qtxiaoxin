<?php
/**
* @author panrj 2014-08-09
* 继承CWebUser组建
*/

class WebUser extends CWebUser
{
    private $model;
    public $loginUrl = array('/xiaoxin/default/login');
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

    public function getInstance()
    {
        if(!Yii::app()->user->isGuest){
          // $user = UCQuery::loadTableRecord('tb_user',Yii::app()->user->id);
            $user=Member::model()->findByPk(Yii::app()->user->id);
            return $user;
        }else{
            return (object)null;
        } 
    }

    public function getExtInstance()
    {
        if(!Yii::app()->user->isGuest){
            $ext=UserExt::getOrCreateByUserid(Yii::app()->user->id);
            return $ext;
        }else{
            return (object)null;
        } 
    }

    public function getLogo()
    {
        $default_photo = $this->defaultPhoto();
        if(Yii::app()->user->isGuest)
            return Yii::app()->request->baseUrl.$default_photo;
        $ext = $this->getExtInstance();
        return Yii::app()->request->baseUrl.$default_photo;//暂时不使用七牛的
        if($ext&&$ext->photo ){
            return STORAGE_QINNIU_XIAOXIN_TX.$ext->photo;
           // return $ext->photo?$ext->photo:Yii::app()->request->baseUrl.$default_photo;
        }else{
            return Yii::app()->request->baseUrl.$default_photo;
        }
    }


    
    public function getRealName()
    {
        if(Yii::app()->user->isGuest)
            return '匿名用户';
        $user = $this->getInstance();
        if($user && $user->name){
            return $user->name;
        }else{
            return $user->account;
        }
    }

    public function getIdentity()
    {
        if(Yii::app()->user->isGuest)
            return 0;
        if(isset($_SESSION[XIAOXIN_LOGIN_IDENTITY])){
            return $_SESSION[XIAOXIN_LOGIN_IDENTITY];
        }else{
            $cookie = Yii::app()->request->getCookies();
            $identity_cookie = $cookie[XIAOXIN_LOGIN_IDENTITY]?$cookie[XIAOXIN_LOGIN_IDENTITY]->value:0;
            if($identity_cookie){
                return $identity_cookie;
            }
            return 0;
        }
        // $user = $this->getInstance();
        // return $user->identity;
    }

    public function defaultPhoto()
    {
        if(Yii::app()->user->isGuest)
            return Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';
        $ext = $this->getExtInstance();
        $user = $this->getInstance();
        if($user->sex==0)
            return Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';
        if($user->sex==1)
            return Yii::app()->request->baseUrl.'/image/xiaoxin/man_pic.jpg';
        if($user->sex==2)
            return Yii::app()->request->baseUrl.'/image/xiaoxin/woman_pic.jpg';
    }

    /**
     * 扩展logout方法,用来销毁用户附加SESSION
     * panrj 2014-10-18
     */
    public function logout($destroySession=true)
    {
        if(isset($_SESSION[XIAOXIN_LOGIN_IDENTITY])){
            unset($_SESSION[XIAOXIN_LOGIN_IDENTITY]);
        }
        $cookie = Yii::app()->request->getCookies();
        unset($cookie[XIAOXIN_LOGIN_IDENTITY]);

        return parent::logout($destroySession);
    }
}