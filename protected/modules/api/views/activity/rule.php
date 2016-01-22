
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
	<body>
		<div class="container" >
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/bg1.jpg" alt="" class="again-img">

			<div class="awards-list rule">
			
				    <div class="rule-c">
				    		<div class="rule-t">
				    			<h2>一 、活动时间：</h2>
				    			<p class="center">2014年12月22日-2015年1月12日</p>
				    		</div>
				    		<div class="rule-t">
				    			<h2>二 、活动规则：</h2>
				    			<ol >
				    				<li>活动期间，老师使用蜻蜓助手（网页端或手机端应用均可）向家长发送消息，家长以手机端应用接收消息，老师可获得相应青豆（具体以青豆获取规则计算）；</li>
				    				<li>50青豆可获得一次兑奖机会，网页端、手机端均可参与兑奖；</li>
				    				<li>打开圣诞袜可随机获得iphone6、移动电源、电影兑换券、10元充值卡、圣诞祝福等不同礼品；</li>
				    				<li>活动期间多次兑奖机会，更多参与更多好礼！</li>
				    			</ol>
				    		</div>
				    		<div class="rule-t">
				    			<h2>三 、青豆获取规则说明：</h2>
				    			<ol >
				    				<li>班级新增1个手机端应用家长用户，则该班班主任可获得20青豆；</li>
				    				<li>首次进入活动页可获得20青豆；</li>
				    				<li>日常使用功能青豆获取说明（见表格）<br/>
										老师在网页端或手机端应用进行以下操作均可获得相应青豆（例：布置作业功能，选择1位家长为1青豆，多位家长多青豆，每天最多可得30青豆）；<br/>
										青豆获取具体如下：
										<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/rule.jpg" alt="" ></p>
										<p>备注：老师发送信息后，家长以短信形式接收，则该操作不算青豆。</p>
				    				</li>
				    			</ol>
				    		</div>
				    		<div class="rule-t">
				    			<h2>四 、奖品发放：</h2>
				    			<ol  >
				    				<li>实物礼品将于活动结束后7个工作日内寄出，请及时在活动界面填写收货地址。</li>
				    				<li>虚拟礼品于兑换成功3日内发放，请按照提示提供相关正确信息。</li>
				    				<li>若您对活动有任何疑问或咨询，请联系400 101 3838。</li>
				    				
				    			</ol>
				    		</div>

				    </div>

			</div>
			<ul class="menu" >
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/view',array("Userid"=>$userid)); ?>#center" >活动</a></li>
				<li><a class="active" href="<?php echo Yii::app()->createUrl('api/activity/rule',array("Userid"=>$userid)); ?>">规则</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/list',array("Userid"=>$userid)); ?>">奖品</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/prize',array("Userid"=>$userid)); ?>">我的</a></li>
			</ul>
			
		</div>
		
		
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/zepto.min.js"></script> 
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/main.js"></script> 
	 
	</body>
</html>