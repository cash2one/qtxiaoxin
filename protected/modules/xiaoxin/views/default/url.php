<div class="header">
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <div id="player" class="player" onclick="onClickHide('#submenuBoxR')"></div>
        </div>
        <div class="paneBox">
            <div class="pheader">功能说明</div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
    	<p><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/index');?>">首页页面</a></p>
    	<p><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/login');?>">登陆页面</a></p>
    	<p><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/account');?>">基本信息</a></p>
    	<p><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/password');?>">设置密码</a></p>
    	<p><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/mobile');?>">手机绑定</a></p>
        <p>---------------------------------------------------------------------------------------------------</p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/index');?>">我的班级-班级列表</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/view');?>">我的班级-班级首页（详情）</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/teachers');?>">我的班级-成员-老师</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/pinvite');?>">我的班级-成员-老师邀请（添加）</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/item');?>">我的班级-成员-老师-科目设置(ajax请求页面)</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/students');?>">我的班级-成员-学生</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/sinvite');?>">我的班级-成员-学生邀请（添加学生）</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/apply');?>">我的班级-成员-待确认邀请</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/deleted');?>">我的班级-成员-已删除邀请</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/supload');?>">我的班级-成员-批量添加学生-上传</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/simport');?>">我的班级-成员-批量添加学生-导入</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/update');?>">我的班级-设置（修改）</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/create');?>">我的班级-创建班级</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/invites');?>">我的班级-入班邀请</a></p>
        <p>---------------------------------------------------------------------------------------------------</p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/group/index');?>">自定义分组-列表</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/group/create');?>">自定义分组-创建</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/group/update');?>">自定义分组-修改</a></p>
        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/group/member');?>">自定义分组-添加成员(ajax请求页面)</a></p>
   	</div>
</div>

    