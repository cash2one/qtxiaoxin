<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/backend/config/main.php';


// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
require_once(dirname(__FILE__).'/protected/config/Constants.php');

function conlog($msg='')
{
	echo "<pre>";
	print_r($msg);
	exit;
}
function D($msg){
    echo "<pre>";
    print_r($msg);
    exit;
}

require_once($yii);

Yii::createWebApplication($config)->run();
