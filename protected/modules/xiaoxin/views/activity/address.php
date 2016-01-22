
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
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/activity.css" rel="stylesheet" type="text/css"/>
	</head>
	<body class="address">
		<div class="container" >
			<form action="" method="post" id="form">
				<div class="input-list">
					<div class="tit"><h1>收货地址<?php echo isset($address['contacter'])?'信息':'填写';?></h1></div>
					<ul>
						<li>
							<div class="input-tit <?php echo isset($address['contacter'])?'deletetop':''; ?>">
								收&nbsp;&nbsp;件&nbsp;&nbsp;人：
							</div>
							<div class="input-i">
								<?php if(isset($address['contacter'])): echo $address['contacter']; ?>
								<?php else: ?>
								<input type="text" name="Address[contacter]"  placeholder="请输入名称" class="input-name"/>
								<?php endif; ?>
							</div>
						</li>
						<li>
							<div class="input-tit <?php echo isset($address['contacter'])?'deletetop':''; ?>">
								地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：
							</div>
							<div class="input-i">
								<?php if(isset($address['contacter'])): echo $address['address']; ?>
								<?php else: ?>
								<textarea name="Address[address]" rows="4" placeholder="请输入地址" class="input-add"></textarea>
								<?php endif; ?>
							</div>
						</li>
						
						<li>
							<div class="input-tit <?php echo isset($address['contacter'])?'deletetop':''; ?>">
								联系电话：
							</div>
							<div class="input-i">
								<?php if(isset($address['contacter'])): echo $address['phone']; ?>
								<?php else: ?>
									<input type="text" name="Address[phone]" class="input-tel"  placeholder="请输入电话" />
								<?php endif; ?>
							</div>
						</li>
						<li >
							<div class="input-tit ">
								
							</div>
							<div class="input-i red" id="form-error" style="font-size:16px;"> 
							   &nbsp;
							</div>
						</li>
						<?php if(!isset($address['address'])): ?>
						<li class="last">
							<a href="javascript:;" class="submit-btn"  id="submitBtn">提交</a>

						</li>
						<?php endif; ?>
					</ul>
				</div>
			</form>
			<ul class="menu" >
				<li><a href="<?php echo Yii::app()->createUrl('xiaoxin/activity/view',array("Userid"=>$userid)); ?>#center" >活动</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('xiaoxin/activity/rule',array("Userid"=>$userid)); ?>">规则</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('xiaoxin/activity/list',array("Userid"=>$userid)); ?>">奖品</a></li>
				<li><a class="active"  href="<?php echo Yii::app()->createUrl('xiaoxin/activity/prize',array("Userid"=>$userid)); ?>">我的</a></li>
			</ul>
		</div>

	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/jquery-1.9.1.js"></script> 
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/activity.js"></script> 
	     <script>
		    $(function(){
		    	activity.msg();
		    })
	    </script> 
	</body>
</html>
