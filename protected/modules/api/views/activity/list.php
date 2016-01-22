
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
	<body>
		<div class="container" >
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/api/activity/bg1.jpg" alt="" class="again-img">

			<div class="awards-list">
				<div class="awards-list-c">
				<?php foreach($datas as $data): ?>
					<div class="tit"> <a ><?php echo $data['name']; ?></a></div>
					<table>
						<thead>
							<tr>
								<th style="width:30%;text-align:left;" >&nbsp;&nbsp;获奖者</th>
								<th  style="width:35%;">单位</th>
								<th style="width:35%;">获奖时间</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($data['records'] as $d):?>
							<tr>
								<td class="teacher-name"><?php echo substr(Member::model()->findByPk($d->mo->userid)->name,0,3).'老师'; ?></td>
								<?php $tsrelation = SchoolTeacherRelation::getSchoolTeachersRelation(array('teacher'=>$d->mo->userid));?>
								<td><?php echo $tsrelation?$tsrelation->s->name:''; ?></td>
								<td><?php echo date('m-d',strtotime($d->creationtime));?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
					<div class="more"> <a href="<?php echo Yii::app()->createUrl('api/activity/morelist',array("Userid"=>$userid,"Mgid"=>$data['mgid'])); ?>">更多名单</a></div>
				<?php endforeach; ?>
					
				</div>

			</div>
			<ul class="menu" >
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/view',array("Userid"=>$userid)); ?>" >活动</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/rule',array("Userid"=>$userid)); ?>">规则</a></li>
				<li><a class="active" href="<?php echo Yii::app()->createUrl('api/activity/list',array("Userid"=>$userid)); ?>">奖品</a></li>
				<li><a href="<?php echo Yii::app()->createUrl('api/activity/prize',array("Userid"=>$userid)); ?>">我的</a></li>
			</ul>
			
		</div>
		
		
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/zepto.min.js"></script> 
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/activity/main.js"></script> 
	</body>
</html>