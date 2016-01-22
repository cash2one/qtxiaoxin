<div class="sidebar">
	<ul id="nav">
		<li class="nav1 <?php if(Yii::app()->getController()->id === 'center'): ?>active<?php endif; ?>"><a href="<?php echo Yii::app()->createUrl('/official/center/index'); ?>" ><span class="border-icon"><i></i></span><span class="icon"> <i></i></span>个人中心</a></li>
		<li class="nav2 <?php if(Yii::app()->getController()->id === 'publish'): ?>active<?php endif; ?>"><a href="<?php echo Yii::app()->createUrl('/official/publish/index'); ?>"><span class="border-icon"><i></i></span><span class="icon"> <i></i></span>发布消息</a></li>
		<li class="nav3 <?php if(Yii::app()->getController()->id === 'message'): ?>active<?php endif; ?>"><a href="<?php echo Yii::app()->createUrl('/official/message/index'); ?>"><span class="border-icon"><i></i></span><span class="icon"> <i></i></span>消息管理</a></li>
        <?php if(OfficialInfo::OPEN_TYPE_SYSTEM == Yii::app()->getModule('official')->user->getinfo('opentype')): ?>
		<li class="nav4 <?php if(Yii::app()->getController()->id === 'forward' &&  OfficialInfo::OPEN_TYPE_SYSTEM == Yii::app()->getModule('official')->user->getinfo('opentype')): ?>active<?php endif; ?>"><a href="<?php echo Yii::app()->createUrl('/official/forward/index'); ?>"><span class="border-icon"><i></i></span><span class="icon"> <i></i></span>消息转载</a></li>
        <?php endif; ?>
	</ul>
</div>