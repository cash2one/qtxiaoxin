<div class="header">
	<div class="logo">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/logo.png" alt=""><span>——公众号管理平台</span>
	</div>
	<div class="login-status">
		<div class="author-wrapper">
			<div class="author clearfix">
					<div class="author-img">
						<img src="<?php echo Yii::app()->getModule('official')->user->getInfo('logo').'?imageView2/1/w/50/h/50';?>" alt="" onerror="javascript:this.src='<?php echo Yii::app()->request->baseUrl; ?>/image/official/person-one.jpg';this.onerror=null;">
					</div>
					<ul class="author-msg">
					    <li class="name"><?php echo Yii::app()->getModule('official')->user->getInfo('openname'); ?></li>
					    <li class="time">上次登录：<?php echo Message::defaultTime(Yii::app()->getModule('official')->user->getUserValue('logintime')); ?></li>
					
					</ul>
					<div class="exit">
						<a href="<?php echo Yii::app()->createUrl('/official/default/logout'); ?>">退出</a>
					</div>
			</div>
		</div>
	</div>
</div>
