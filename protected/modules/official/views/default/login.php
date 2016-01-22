<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>登录页面</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/official/base.css">
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/official/ui.css">
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/official/login.css">
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/jquery.js"></script>
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/login.js"></script>

		<!-- html5.js for IE less than 9 -->
		<!--[if lt IE 9]>
			<script src="js/html5.js"></script>
			
		<![endif]-->
	
		<!-- css3-mediaqueries.js for IE less than 9 -->
		<!--[if lt IE 9]>
			<script src="js/css3-mediaqueries.js"></script>
		<![endif]-->

		<!-- IE8以下的浏览器提示更新 -->
	    <!--[if lt IE 8]>
		    <div id="ie6-warning">您正在使用 Internet Explorer 8以下的浏览器，在本页面的显示效果可能有差异。建议您升级到 <a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank">Internet Explorer 8、9、10、11</a> 或以下浏览器： <a href="http://www.mozillaonline.com/" target="_blank">Firefox</a> / <a href="http://www.google.com/chrome/?hl=zh-CN">Chrome</a> / <a href="http://www.apple.com.cn/safari/" target="_blank">Safari</a> / <a href="http://www.operachina.com/" target="_blank">Opera</a>
		    </div>
	    <![endif]-->
	</head>
	<body>
		<div class="header-config" >
			<div class="header">
				<div class="logo">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/login/logo.png" alt=""><span>——公众号管理平台</span>
				</div>
				<div class="login-status">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/login/tel.png" alt="">
				</div>
			</div>
		</div>
		<div class="container">
			 <div class="content">
			 	 <div class="tip">
			 	 	<h1>蜻蜓校信公众平台</h1>
			 	 	<p>帮助机构建立老师、学校、家长间的桥梁</p>
			 	 </div>
			 	 <div class="login">
			 	    <div class="tit">账户登录</div>
			 	 	<form class="form-horizontal" id="login-submit" method="post">
						  <div class="control-group">
						    <div class="controls">
						      <div class="user">
						      	<span>用户</span>
						      	<input type="text" name="OfficialLoginForm[username]" placeholder="用户名" class="input-large " >
						      </div>
						      
						    </div>
						  </div>
						  <div class="control-group">
						    <div class="controls">
						      <div class="pass">
							      <span>密码</span>
							      <input type="password" name="OfficialLoginForm[password]"  placeholder="密码" class="input-large" >
						      </div>
						    </div>
						  </div>
						  <div class="control-group" style="margin:0;">
						    <div class="controls error" >
                               <?php echo $model->getError('block'); ?>
                               <?php echo $model->getError('password'); ?>
						    </div>
						  </div>
						  <div class="control-group forget">
						    <div class="controls" >
						      <label class="checkbox">
						        <input type="checkbox">记住我 <a href="<?php echo Yii::app()->createUrl('official/default/getpwd');?>" class="forget-btn">忘记密码？</a>
						      </label>
						     	<a href="javascript:;" class="btn btn-warning login-btn" >登&nbsp;&nbsp;录</a>
						    </div>
						  </div>
					</form>
			 	 </div>
			 </div>
		</div>
		<div class="footer">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/login/logo1.png" alt="" class="foot-logo">
			<a href="http://www.qthd.com/">蜻蜓互动</a>
			<a href="http://www.qtxiaoxin.com">关于蜻蜓校信</a>
			<a href="http://www.qthd.com/contact.aspx">联系我们</a>
			<a href="http://www.miibeian.gov.cn/state/outPortal/loginPortal.action" >|&nbsp;&nbsp;深圳蜻蜓互动科技有限公司 粤ICP备14076064号-3</a>
		</div>
        <?php Yii::app()->msg->printMsg();?>
	</body>
</html>
