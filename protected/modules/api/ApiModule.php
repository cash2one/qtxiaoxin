<?php

class ApiModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'api.models.*',
			'api.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		$controller->layout = 'application.modules.api.views.layouts.main';
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			define ("XIAOXIN_CLIENT_TOOL_TEACHER_HELPER", "http://59.36.99.136/help_tool/");
			define ("XIAOXIN_CLIENT_TOOL_TEACHER_PROVISION", "http://www.qthd.com/userhelp/clause.html");
			define ("CDDS_CLIENT_TOOL_TEACHER_PROVISION", "http://www.qthd.com/userhelp/cddsclause.html");
			return true;
		}
		else
			return false;
	}
}
