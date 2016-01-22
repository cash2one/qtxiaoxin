
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
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/api/activity/main.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
		<div class="container" >
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/bg1.jpg" alt="" class="again-img">

			<div class="awards-list rule">
			
				    <div class="rule-c">
				    		<div class="rule-t">
				    			<h2>电影通兑券说明</h2>
				    			<ol >
				    				<li>电影兑换券不适用首映场、明星见面会、情人节（2月14日）、平安夜（12月24日）、圣诞节（12月25日）、大年三十、大年初一等特殊节日的场次，不适用贵宾厅、情侣厅、巨幕厅等特殊影厅；</li>
				    				<li>凭手机接收的验证码短信，在影院前台选座出票；</li>
				    				<li>如兑换非约定范围类的影片和国家电影局限价发行影片，需按照影城提示补足差价；</li>
				    			</ol>
				    		</div>
				    		<div class="rule-t" >
				    			<ol style="list-style:none;">
				    				<li>
<div style="margin-bottom:8px">MCL洲立影城罗湖店<br/>
中影百誉东门店<br/>
中影UL城市影院莲塘店<br/>
保利影城大中华店<br/>
中影今典电影城<br/></div>
<div style="margin-bottom:8px">中影益田假日影城<br/>
深圳达梦国际影城<br/>
创意港国际影城<br/>
中影UL城市影城坪山店<br/>
中影国际影城欢乐海岸店<br/></div>
<div style="margin-bottom:8px">华夏星光国际影城<br/>
中影UL城市影院西丽店<br/>
华影信和影城<br/>
深圳百川国际影城<br/>
华夏君盛影城<br/></div>
<div style="margin-bottom:8px">中影UL城市影院前海店<br/>
金逸影城碧海城店<br/>
中影星美国际影城<br/>
金逸影城建安店<br/> 
百誉国际影城公明店<br/></div>
<div style="margin-bottom:8px">环星电影新安店<br/>
南国艺恒影城沙井店<br/>
中影南国影城宝安店<br/>
星美影城宏发店<br/>
金逸影城沙井店<br/></div>
<div style="margin-bottom:8px">德金国际影城<br/>
中影UL城市影院宝安店<br/>
中影UL城市影院福永店<br/>
新华银兴国际影城<br/>
深圳星晨国际影城<br/></div>
<div style="margin-bottom:8px">中影UL城市影院乐尚店<br/>
星河电影城松岗店<br/>
中影飞尚百誉国际影城<br/>
嘉乐影城固戍店<br/>
艾美银河UV国际影城<br/></div>
<div style="margin-bottom:8px">百誉电影城大浪店<br/>
深圳横店影城<br/>
金逸影城民治店<br/>
华夏太古国际影城金銮店<br/>
金逸影城龙华东环店<br/></div>
<div style="margin-bottom:8px">金逸影城观澜店<br/>
华夏嘉熙业国际影城<br/>
星美国际影城观澜店<br/>
盛达国际影城<br/>
百誉国际影城龙岗店<br/></div>
<div style="margin-bottom:8px">嘉年华国际影城<br/>
南国艺恒影城坂田店<br/>
博纳国际影城龙岗店<br/>
华夏太古国际影城万科红店<br/>
深圳一帆影城<br/></div>
<div style="margin-bottom:8px">星烨南岭国际影城 <br/>
米高梅影城横岗店<br/>
中影UL城市影院坪地店<br/></div>

</li>
				    				
				    			</ol>
				    		</div>
				    		

				    </div>

			</div>
			<ul class="menu" >
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/view',array("Userid"=>$userid)); ?>#center" >活动</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/rule',array("Userid"=>$userid)); ?>">规则</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/list',array("Userid"=>$userid)); ?>">奖品</a></li>
				<li><a class="active" href="<?php echo Yii::app()->createUrl('api/activity/prize',array("Userid"=>$userid)); ?>">我的</a></li>
			</ul>
			
		</div>
		
		
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/zepto.min.js"></script> 
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/main.js"></script> 
	 
	</body>
</html>