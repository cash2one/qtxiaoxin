<?php

// 这里使用了一个扩展，故定义了一个别名
Yii::setPathOfAlias('ext', dirname(__FILE__).'/../extensions');
// 下面是分离前后台需要增加的
$backend=dirname(dirname(__FILE__));
$frontend=dirname($backend);
Yii::setPathOfAlias('backend', $backend);
require($backend.'/config/DatabaseConfig.php');
date_default_timezone_set("PRC");
// 下面是通用配置
return array(
    'basePath' => $frontend,
    'controllerPath' => $backend.'/controllers',
    'viewPath' => $backend.'/views',
    'runtimePath' => $backend.'/runtime',
    'name'=>'后台管理',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.extensions.*',
		'application.extensions.helper.*',
		'backend.components.*',
		'backend.models.*',
		'backend.models.base.*',
		'backend.models.member.*',
		'application.backend.models.official.*',
		'backend.extensions.*',
		'backend.modules.srbac.controllers.SBaseController',
		'application.modules.xiaoxin.models.*',
		
	),

	'modules'=>array(
		//  Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
 			'generatorPaths'=>array(
						'ext.dwz.gii.module.templates.dwz.module',
				), 
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'gird' => array('class'=>'backend.modules.gird.GirdModule',),
		'srbac'=>
			array(
				'class'=>'backend.modules.srbac.SrbacModule',
				// Your application's user class (default: User)
				"userclass"=>"User",
				// Your users' table user_id column (default: userid)
				"userid"=>"uid",
				// your users' table username column (default: username)
				"username"=>"username",
				// If in debug mode (default: false)
				// In debug mode every user (even guest) can admin srbac, also
				//if you use internationalization untranslated words/phrases
				//will be marked with a red star
				"debug"=>false,
				// The number of items shown in each page (default:15)
				"pageSize"=>16,
				// The name of the super user
				"superUser" =>"超级管理员",
				//The css file to use
				//"css"=>"srbac_red.css", // must be in srbac css folder
				//The layout to use
				"layout"=>"backend.views.layouts.main",
				//The not authorized page
				"notAuthorizedView"=>"backend.views.site.error403",
				// The always allowed actions
				"alwaysAllowed"=>array(
					'SiteLogin','SiteLogout','SiteIndex','SiteError',
				),
				// The operationa assigned to users
				"userActions"=>array(
					"Show","View","List"
				),
				// The number of lines of the listboxes
				"listBoxNumberOfLines" => 10,
				// The path to the custom images relative to basePath (default the srbac images path)
				//"imagesPath"=>"../images",
				//The icons pack to use (noia, tango)
				"imagesPack"=>"tango",
				// Whether to show text next to the menu icons (default false)
				"iconText"=>true,
			)
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class'=>'WebUser',
		),
		// 'request'=>array( 
  //           'class' => 'CmsCHttpRequest',
  //       ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<modules>/<controller>/<action>',
				'<modules:\w+>/<controller:\w+>/<action:\w+>/<id:\w+>'=>'<modules>/<controller>/<action>',
				'<modules:\w+>/<controller:\w+>/<action:\w+>'=>'<modules>/<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		//   MySQL database
		'db'=>DatabaseConfig::dbInfo(),
		// 'db'=>DatabaseConfig::memberinfo(),
		'db_member'=>DatabaseConfig::memberinfo(),
        'db_msg'=>DatabaseConfig::msgInfo('xw_sms'),//手机验证短信库
        'db_msg_qtxx'=>DatabaseConfig::msgInfo('xw_sms'),//校信通知短信库
        'db_xiaoxin'=>DatabaseConfig::xiaoxin(),
        'db_official'=>DatabaseConfig::official(),//公众号数据库

		'authManager'=>array(
			'class'=>'backend.modules.srbac.components.SDbAuthManager',
			'connectionID'=>'db',
			'itemTable'=>'srbac_items',
			'assignmentTable'=>'srbac_assignments',
			'itemChildTable'=>'srbac_itemchildren',
		), 

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'msg' => array(
			'class' => 'application.extensions.emessage.EMessage'
		),

		'Smtpmail'=>array(
            'class'=>'application.extensions.smtpmail.PHPMailer',
            'Host'=>"smtp.163.com",
            'Username'=>'qingtinghd@163.com',
            'Password'=>'qingtinghudong',
            'Mailer'=>'smtp',
            'Port'=>25,
            'SMTPAuth'=>true, 
        ),
		
		'cache'=>DatabaseConfig::cacheInfo(),
		
		//'couchbase'=>DatabaseConfig::couchbaseInfo(),
        
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				// array(
				// 	'class'=>'CFileLogRoute',
				// 	'levels'=>'trace',
	   //              //级别为trace
	   //              'categories'=>'system.db.CDbCommand',
	   //              'logFile'=> 'query.log',  
				// ),
				// array(  
		  //           'class'=>'CDbLogRoute',  
		  //           'connectionID'=>'db',  
		  //           'levels'=>'trace',  
		  //           'logTableName' => 'sql_querylogs',  
		  //           'categories'=>'system.db.CDbCommand',  
		  //       ),  
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
	   //配置连接的IP、端口、以及相应的数据库
        'memcache'=>DatabaseConfig::nativeCacheInfo(),
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'loginType'=>'',
		'xxschoolid'=>'xiaoxinschoolcookie',
		'platform' => 'backend',
	),
);