<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8">
	<title>餐单管理</title>
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
	<div class="container"> 
		  <?php if(count($schools)>0): ?>
		  <div class="school">
		  		<div class="school-c">
			  		<div class="school-name">
			  			<?php echo $school?$school->name:''; ?>
			  		</div>
			  		<?php if(count($schools)>1): ?>
			  			<a href="<?php echo Yii::app()->createUrl('api/parent/schools/'.$uid).'?year='.$year.'&week='.$week; ?>" class="select-school">更换学校</a>
			  		<?php endif; ?>
		  		</div>
		  </div>
		  <div class="t-week" id="default-week">
			  	<div class="menu">
			  		<a href="<?php echo Yii::app()->createUrl('api/parent/foodmenu/?uid='.$uid).'&sid='.$school->sid.'&year='.$year.'&week='.($week-1); ?>" class="prev" data-action="prev"></a>
			  		<span class="time">
			  			第<?php echo $week; ?>周
			  		</span>
			  		<i class="date"><?php echo $startend[0]; ?> ~ <?php echo $startend[1]; ?></i>
			  		<a href="<?php echo Yii::app()->createUrl('api/parent/foodmenu/?uid='.$uid).'&sid='.$school->sid.'&year='.$year.'&week='.($week+1); ?>" class="next" data-action="next"></a>
			  	</div>
			  	<?php if(count($weekmenu)): ?>
			  	<ul class="menu-list " >
			  	<?php foreach($weekmenu as $item): ?>
			  		<li>
			  			<div class="t-day ">
			  				星期<?php echo MainHelper::ToChinaseNum($item['day']); ?>
			  			</div>
			  			<div class="t-day-c clearfix">
			  				<pre ><?php echo $item['text']; ?></pre>
			  			</div>
			  		</li>
			  	<?php endforeach; ?>
			  	</ul>
				<?php else: ?>
					<ul class="menu-list " >
					<li>暂无餐单</li>
					</ul>
				<?php endif;?>
		  </div>
		<?php else: ?>
		<div class="t-week" id="default-week">
			<ul class="menu-list " >
				<li>查询不到关联的孩子或学校</li>
			</ul>
		</div>
		<?php endif; ?>
	</div>
	<script src="/css/xiaoxin/parentPhone/js/zepto.min.js"></script>
	<!--<script src="/css/xiaoxin/parentPhone/js/main.js"></script>-->
</body>
</html>