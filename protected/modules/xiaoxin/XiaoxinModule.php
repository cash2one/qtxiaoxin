<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-10
 * Time: 上午9:17
 */

class XiaoxinModule extends CWebModule
{
    public function  init()
    {
        $this->setImport(
            array(
                "xiaoxin.model.*",
                "xiaoxin.components.*"
            )
        );

    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else
            return false;
    }
} 