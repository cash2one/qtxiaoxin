<?php
/**
* @author panrj 2014-11-26
* 继承CWebUser组建
*/

class OfficialWebUser extends CWebUser
{
    private $model;
    public $loginUrl = array('/official/default/login');
    public $authTimeout = 86400;
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
        if(!Yii::app()->getModule('official')->user->isGuest){
            $user=Account::model()->findByPk(Yii::app()->getModule('official')->user->id);
            return $user;
        }else{
            return (object)null;
        }
    }

    public function getName()
    {
        if(!Yii::app()->getModule('official')->user->isGuest){
            $user=Account::model()->findByPk(Yii::app()->getModule('official')->user->id);
            return $user->mobile;
        }else{
            return 'Guest';
        }
    }

    /**
     * 获取登陆对象的安全属性值
     * @param string $property
     * @return string
     */
    public function getUserValue( $property=false )
    {
        $user = $this->getInstance();

        if (true == $user && true == $property && true == isset($user->$property)) {
            return $user->$property;
        } else {
            return '';
        }
    }

    /**
     * 获取自助登陆公众号账户的资料信息
     * add safe property check and function param by ld 2014-12-4
     * @param string $property
     * @return StdClass
     */
    public function getInfo( $property = false )
    {
        if (! Yii::app()->getModule('official')->user->isGuest) {
            $user = $this->getInstance();
            if (true == $property && true == isset($user->info->$property) ) {
                return $user->info->$property;
            } else if (true == $property) {
                    return '';
                } else {
                    return $user->info;
                }
        } else {
            return (object) null;
        }
    }
}