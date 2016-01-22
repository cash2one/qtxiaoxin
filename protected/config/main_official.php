<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here. 
date_default_timezone_set("PRC");
require('DatabaseConfig.php');

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'蜻蜓校信公众号',
	'defaultController'=>'official/default',
    'language'=>'zh_cn',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.backend.models.base.*',
		'application.backend.models.member.*',
		'application.backend.models.official.*',
		'application.backend.models.*',
        'application.modules.xiaoxin.models.*',
		// 'application.backend.modules.member.models.*',
		// 'application.modules.api.models.*',
		'application.components.*',
		'application.extensions.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'api',
		'xiaoxin',
		'official',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class'=>'WebUser',
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<modules>/<controller>/<action>',
				'<modules:\w+>/<controller:\w+>/<action:\w+>'=>'<modules>/<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

				// 'http://gzh.local'=>'official/default/index',
				// 'http://gzh.test'=>'official/default/index',
				// 'http://gzh.local'=>'official/default/index',

				'http://<module:\w+>.local.com/' => '<module>/default',
				'http://<module:\w+>.local.com/<controller:\w+>' => '<module>/<controller>/',
				'http://<module:\w+>.local.com/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
				'http://<module:\w+>.local.com/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',

				'http://<module:\w+>.test.com/' => '<module>/default',
				'http://<module:\w+>.test.com/<controller:\w+>' => '<module>/<controller>/',
				'http://<module:\w+>.test.com/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
				'http://<module:\w+>.test.com/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
			),
		),
		
		'db'=>DatabaseConfig::dbinfo(),
		'db_member'=>DatabaseConfig::memberinfo(),
		'db_credits'=>DatabaseConfig::db_credits(),
		'db_old'=>DatabaseConfig::oldDbInfo(),
        'db_xiaoxin'=>DatabaseConfig::xiaoxin(),
        'db_msg'=>DatabaseConfig::msgInfo('xw_sms'),//手机验证短信库
        'db_msg_qtxx'=>DatabaseConfig::msgInfo('qtxx_sms'),//校信通知短信库
        'db_official'=>DatabaseConfig::official(),//公众号数据库
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'msg' => array(
			'class' => 'application.extensions.emessage.EMessage'
		),

		'cache'=>DatabaseConfig::cacheInfo(),
		// 'log'=>array(
		// 	'class'=>'CLogRouter',
		// 	'routes'=>array(
		// 		// array(
		// 		// 	'class'=>'CFileLogRoute',
		// 		// 	'levels'=>'error, warning',
		// 		// ),
		// 		// // uncomment the following to show log messages on web pages
				
		// 		// array(
		// 		// 	'class'=>'CWebLogRoute',
		// 		// ),
		// 		array(  
		//             'class'=>'CDbLogRoute',  
		//             'connectionID'=>'db',  
		//             'levels'=>'trace',  
		//             'logTableName' => 'sql_querylogs',  
		//             'categories'=>'system.db.CDbCommand',  
		//         ),  
				
		// 	),
		// ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'platform' => 'fronted',
        'memcache'=>DatabaseConfig::nativeCacheInfo()
	),
);