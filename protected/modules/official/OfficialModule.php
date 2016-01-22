<?php

class OfficialModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'official.models.*',
			'official.components.*',
		));

		$this->setComponents(array(
            'errorHandler' => array(
                'errorAction' => 'official/default/error'),
            'user' => array(
                'class' => 'OfficialWebUser',             
                'loginUrl' => Yii::app()->createUrl('official/default/login'),
            )
        ));
 
		Yii::app()->user->setStateKeyPrefix('_official');
	}

	public function beforeControllerAction($controller, $action)
	{
		$controller->layout = 'application.modules.official.views.layouts.main';
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
            $route = $controller->id . '/' . $action->id;
           // echo $route;
            $publicPages = array(
                'default/login',
                'default/getpwd',
                'default/setcode',
                'default/password',
                'default/error',
                'default/remote',
                'default/remotemessage',
            );
            if (Yii::app()->getModule('official')->user->isGuest && !in_array($route, $publicPages)){            
                Yii::app()->getModule('official')->user->loginRequired();                
            }else{
            	return true;
            }    
		}else{
			return false;
		}
			
	}
}
