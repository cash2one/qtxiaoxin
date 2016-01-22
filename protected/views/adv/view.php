<?php
/* @var $this SiteController */
// echo "<pre>";
// var_dump($model);
?>
 <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">  
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<meta content="yes" name="apple-mobile-web-app-capable" /> 
<meta content="black" name="apple-mobile-web-app-status-bar-style" /> 
<meta content="telephone=no" name="format-detection" /> 
<title><?php echo $model->title; ?></title>
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/style.css">
<style type="text/css">
    .layoutMain { width: 96%; margin: 0 auto;}
    .header{ }
    .header .title{ font-size: 20px; font-weight: bold; padding-top:10px;  color: #000000; word-wrap : break-word; white-space:normal;}
    .header .datetime{ font-size: 16px; color: #a2a2a2; padding: 8px 0;  } 
    .info{ color: #000000;  font-size: 17px; word-wrap : break-word; white-space:normal; padding: 0; margin: 0 auto; line-height: 24px;}
</style>
</head>
<body>
    <div class="layoutMain">
    	<div class="header">
    		<h1 class="title"><?php echo $model->title; ?></h1>
    		<div class="datetime">
                <?php echo date('Y-m-d H:i',strtotime($model->creationtime));?>
            </div>
    	</div> 
    	<div class="info">
            <?php echo $model->text; ?>
    	</div>
    </div>
</body> 
</html>  