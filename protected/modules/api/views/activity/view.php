
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>圣诞活动</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="format-detection" content="telephone=no" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no,minimum-scale=1.0,maximum-scale=1.0">
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/api/activity/main.css" rel="stylesheet" type="text/css"/>
	</head>
	<body >
		<div class="container" id="awards">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/activity.jpg" alt="" >
			<div class="loading" id="loading"></div>
			<?php if(count($latest)): ?>
			<div class="adward-msg">
				<marquee behavior="scroll" direction="left" scrollamount="3">
				<?php foreach($latest as $d):?>
					<?php $tsrelation = SchoolTeacherRelation::getSchoolTeachersRelation(array('teacher'=>$d->mo->userid));?>
					<span>恭喜<?php echo $tsrelation?$tsrelation->s->name:''; ?><?php echo substr($name = Member::model()->findByPk($d->mo->userid)->name,0,3); ?>老师成功兑换了<?php echo $d->mg->name; ?></span>
				<?php endforeach; ?>
				</marquee>
			</div>
			
			 <a href="<?php echo Yii::app()->createUrl('api/activity/list',array("Userid"=>$userid)); ?>" class="more-msg">更多</a>
			<?php endif; ?>
			<!--   <a name="center" style="position:absolute;width: 13%;top: 23%;left: 43%;cursor:default;">&nbsp;</a> -->
			<div class="awards-box awards-box1">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/shoes3.png" alt="" >
			</div>
			<div class="awards-box awards-box2">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/shoes1.png" alt="" >
			</div>
			<div class="awards-box awards-box3">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/shoes2.png" alt="" >
			</div>
			<div class="awards-box awards-box4">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/shoes1.png" alt="" >
			</div>
			<div class="awards-box awards-box5">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/shoes3.png" alt="" >
			</div>

			<div class="score "><a class="btn btn-danger btn-radius ">您有<span id="score"><?php echo $user->bean; ?></span>个青豆</a></div>

			<ul class="menu">
				<li><a class="active" href="<?php echo Yii::app()->createUrl('api/activity/view',array("Userid"=>$userid)); ?>" >活动</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/rule',array("Userid"=>$userid)); ?>">规则</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/list',array("Userid"=>$userid)); ?>">奖品</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/prize',array("Userid"=>$userid)); ?>">我的</a></li>
			</ul>
			<div class="promptBox" id="promptBox">
				<a href="javascript:;" class="close" data-action="close"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/close.png" alt="" ></a>
				<div class="blessing" id="prompt-c">
					<p class="awards-img"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/shoes3.png" alt="" ></p>
					<p class="open-awards"><a href="javascript:;" data-isclick="true" data-action="open" data-href="<?php echo Yii::app()->createUrl('api/activity/draw',array("Userid"=>$userid)); ?>" id="getOpen">立即打开</a></p>
					<p class="p1">需要<span class="red">50</span>个青豆</p>
				<!-- 	<p class="p1" style="margin-top:3%;">已有<span class="red">322</span>个礼物被打开。</p> -->
				</div>
				<div class="blessing zf get-awards" id="zf"></div>
				<div class="blessing get-awards " id="getAwards">
					
				</div>
				<div class="blessing zf get-awards " id="firstAwards" style="display:none;">
					<p class="center">首次登录赠送<span class="red"><?php echo $bean; ?>青豆</span>！</p><p class="center"><a href="javascript:;" data-action="close" class="confirm">确定</a></p>
				</div>
				
			</div>
			<div class="mask"></div>
			<input type="hidden" value="<?php echo Yii::app()->createUrl('api/activity/address').'?Userid='.$userid;?>" id="getAddUrl">

			<input type="hidden" value="<?php echo $firsttime;?>" id="firstView">
		</div>
		
		
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/zepto.min.js"></script> 
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/main.js"></script> 
	    <script>
		    $(function(){
		    	activity.awardV();
		    })
	    </script>
	</body>
</html>