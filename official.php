<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';

$config=dirname(__FILE__).'/protected/config/main_official.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once(dirname(__FILE__).'/protected/config/Constants.php');

function conlog($msg='')
{
    echo "<pre>";
    print_r($msg);
    exit;
}
function D($msg='')
{
    echo "<pre>";
    print_r($msg);
    exit;
}
function V($msg='')
{
    echo "<pre>";
    var_dump($msg);
    exit;
}
require_once($yii);
Yii::createWebApplication($config)->run();

