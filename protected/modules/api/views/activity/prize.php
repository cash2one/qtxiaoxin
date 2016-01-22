
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

			<div class="awards-list">
				<div class="awards-list-c">
						<table>
						<thead >
							<tr  class="price">
								<th style="width:40%;text-align:left;">&nbsp;&nbsp;&nbsp;奖品</th>
								<th  style="width:35%;">获奖时间</th>
								<th style="width:25%;">备注</th>
							</tr>
						</thead>
						<tbody class="price-body" id="priceBody">
							<?php foreach($prizes as $prize): ?>
							<tr>
								<td class="teacher-name"><?php echo $prize['name']; ?></td>
								<td><?php echo $prize['time'];?></td>
								<td><a href="<?php echo $prize['address'];?>" data-type="<?php echo $prize['type'];?>" data-tip="<?php echo $prize['remark'];?>" data-phone="<?php echo $prize['phone'];?>">详情</a></td>
							</tr>
						<?php endforeach;?>
						</tbody>
					</table>
					
				</div>
			
			</div>
			<ul class="menu" >
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/view',array("Userid"=>$userid)); ?>#center" >活动</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/rule',array("Userid"=>$userid)); ?>">规则</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/list',array("Userid"=>$userid)); ?>">奖品</a></li>
				<li><a class="active"  href="<?php echo Yii::app()->createUrl('api/activity/prize',array("Userid"=>$userid)); ?>">我的</a></li>
			</ul>
			
			<div class="promptBox" id="priceBox">
				<a href="#" class="close" data-action="close"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/close.png" alt="" ></a>
				<div class="blessing get-awards price-cont " id="price-c"></div>
				
			</div>
			<div class="mask"></div>
		</div>
		
		
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/zepto.min.js"></script> 
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/main.js"></script>
	    <script>
		    $(function(){
		    	activity.myPrive();
		    })
	    </script> 
	</body>
</html>