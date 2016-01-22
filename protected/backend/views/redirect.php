<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>Examples</title>
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/style.css"> 
<style type="text/css"> 
.layout_main {padding:30px; }
.seText { margin-top:100px;  width: 800px; }
.layout_main .aeBody{ text-align:left; padding-top:30px; padding-left: 259px; height: 194px; overflow: hidden;  }
.layout_main .head{ text-align: center; border-bottom: 1px solid #ccc; padding-bottom: 10px;   }
.layout_main .head h2{ font-size: 27px; }
.success{  background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/success.jpg') left center no-repeat; }
.error{  background: url('<?php echo Yii::app()->request->baseUrl; ?>/images/error.jpg') left center no-repeat; }
.layout_main .aeBody h2 { font-size: 24px; color: #669; margin:30px 0 30px 0; overflow: hidden; } 
.layout_main .aeBody a{ color: #37a;}
.layout_main .aeBody a:hover{ background: #fff; text-decoration: inherit; color:#669;}
</style>
<script type="text/javascript"> 
	function Jump(){
		window.location.href = '<?php echo $url;?>';
	}
	document.onload = setTimeout("Jump()" , <?php echo $delay;?>* 1000);
</script> 
</head>
<body> 
	 
	<div class="layout_main">
	<!-- seText -->
		<div class="seText msg_<?php echo $type == 'success' ? 'success' : 'error' ; ?>">
			<!-- head -->
			<div class="head"> 
				<h2 class="title">系统提示</h2>
			</div>
			<!-- /head --> 
			<!-- aeBody -->
			<div class="aeBody <?php echo $type == 'success' ? 'success' : 'error' ; ?>">
				<h2><?php echo $message;?></h2>
				<p>
					系统将在 <span class="warning"><?php echo $delay;?></span> 秒后自动跳转,如果不想等待,直接点击 
					<a class=" " href="<?php echo $url;?>">这里</a> 跳转
					<br/>
					或者 <a class=" " href="/admin.php">返回后台首页</a>
				</p>
			</div>		
			<!-- /aeBody -->

		</div>
		<!-- /seText -->
	</div> 

</body>
</html>
