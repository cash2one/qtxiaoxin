<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>圣诞活动</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no,minimum-scale=1.0,maximum-scale=1.0">
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/api/activity/main.css" rel="stylesheet" type="text/css"/>
	</head>
	<body style="background:#EAF5FB;" id="body" >
		<div class="container">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/begin-img.jpg" alt="" style="z-index:9997;">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/tit1.png" alt="" class="begin-tit">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/tit2.png" alt="" class="begin-c">
			<div class="db-btn" >
				<a href="http://shop.qtxiaoxin.com/api.aspx?uid=<?php echo $userid; ?>" class="btn btn-danger btn-radius return-band " >回到商城</a>
				<a href="<?php echo Yii::app()->createUrl('api/activity/view',array("Userid"=>$userid)); ?>#center" class="btn btn-danger btn-radius join" >立即参与</a>
			</div>
		</div>
	 
	</body>
</html>