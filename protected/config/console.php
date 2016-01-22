<?php
// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
date_default_timezone_set("PRC");
require('DatabaseConfig.php');
return array (
        'basePath' => dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . '..',
        'name' => 'My Console Application',
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
        'components' => array (
                // Main DB connection
            'db'=>DatabaseConfig::dbinfo(),
            'db_xiaoxin'=>DatabaseConfig::xiaoxin(),
            'db_member'=>DatabaseConfig::memberinfo(),
            'db_msg'=>DatabaseConfig::msgInfo(),
            'db_official'=>DatabaseConfig::official(),//公众号数据库
            
                'cache'=>DatabaseConfig::cacheInfo(),
                'log' => array (
                        'class' => 'CLogRouter',
                        'routes' => array (
                                array (
                                        'class' => 'CFileLogRoute',
                                        'levels' => 'error, warning'
                                ) 
                        ) 
                ) 
        ) 
);