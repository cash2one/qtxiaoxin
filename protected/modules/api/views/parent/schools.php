<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<title>选择学校</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no">
	<meta http-equiv="Cache-Control" content="max-age=0">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no" />
	<meta name="Description" content="">
	<meta name="Keywords" content="">
	<link rel="stylesheet" href="/css/xiaoxin/parentPhone/css/main.css">
	</head>
<body >
	<div class="container" style="background:#EFEFF4;"> 
		  <?php if(count($schools)): ?>
			  <ul class="school-list">
			  	<?php foreach($schools as $school): ?>
			  			<li><a href="<?php echo Yii::app()->createUrl('api/parent/foodmenu/?uid='.$uid).'&sid='.$school->sid.'&year='.$year.'&week='.$week; ?>"><?php echo $school->name; ?></a></li>
		  		<?php endforeach; ?>
			  </ul>
		<?php else: ?>
			暂无学校
		<?php endif; ?>
		  
	</div>
	<script src="/css/xiaoxin/parentPhone/js/zepto.min.js"></script>
	<!--<script src="/css/xiaoxin/parentPhone/js/main.js"></script>-->
</body>
</html>