<?php

// change the following paths if necessary
// $yii=dirname(__FILE__).'/../yii/framework/yii.php';
// $config=dirname(__FILE__).'/protected/config/main.php';

// // remove the following lines when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);
// // specify how many levels of call stack should be shown in each log message
// defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// function conlog($msg='')
// {
// 	echo "<pre>";
// 	print_r($msg);
// 	exit;
// }
function D($msg='') {
 	echo "<pre>";
 	print_r($msg);
 	exit;
 }
// require_once($yii);
// Yii::createWebApplication($config)->run();

defined('YII_DEBUG') or define('YII_DEBUG',true);
// including Yii
$yii=dirname(__FILE__).'/../../../yii/framework/yii.php';
require_once($yii);
// we'll use a separate config file
$configFile=dirname(dirname(__FILE__)).'/config/console.php';
// creating and running console application
Yii::createConsoleApplication($configFile)->run();
?>