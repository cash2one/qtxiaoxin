<style type="text/css">
.btn{
    display: inline-block;
    padding: 10px 20px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 1.428571429;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
    background-image: none;
    border: 0px solid transparent;
    border-radius: 0px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}
.tableForm td.search .btn,.backtrack .btn{padding: 5px 15px;} 
.btn-default{
    color: #333;
    background-color: #ebebeb;
    border-color: #adadad;
}
.btn-default:hover{
     background-color: #f1f1f1;
     text-shadow: 0 0px 0 #fff;
}
.btn-default:hover{
     background-color: #335ea0;
     text-shadow: 0 0px 0 #fff;
     color: #fff;
}
.btn-primary {
    color: #fff;
    background-color: #335ea0; 
}
.loginBtn{
	float: right;
}
.loginBtn li a{ 
	text-decoration: none;
	display: inline-block;
	padding: 6px 12px;
	margin-bottom: 0;
	font-size: 14px;
	font-weight: normal;
	line-height: 1.428571429;
	text-align: center;
	white-space: nowrap;
	vertical-align: middle;
	cursor: pointer;
	background-image: none;
	border: 1px solid transparent;
	border-radius: 4px;
	-webkit-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	-o-user-select: none;
	user-select: none; 
	color: #fff;
	background-color: #f0ad4e;
	border-color: #eea236;
	margin-right: 300px;
}
</style>
<div id="headerbox"  style="height:68px; width: 100%; border-bottom: 5px solid #335ea0;  background:#ffffff; padding:10px 0 6px 0;">
    <div style="text-align: right; margin-right: 30px;">   
        <?php if(Yii::app()->user->isGuest){ ?>
            <div class="userInfo" style="display: inline; overflow: hidden; position: relative; margin-right: 0px; padding-right: 0;">
                <a style="margin-right: 0px; margin-top: 5px;" class="btn btn-primary" href="<?php echo Yii::app()->createUrl('site/login');?>">登 录</a>
            </div>
        <?php }else{ ?>
            <div class="userInfo" style="display: inline; overflow: hidden; position: relative;">
                <div class="pic"style="display: inline; position: relative;">
                    <img src="<?php echo Yii::app()->user->getLogo(); ?>" width="50" height="50">
                </div>
                <span class="userName"><?php echo Yii::app()->user->getRealName(); ?> </span><span class="colorRed">|</span><a class="userOute" href="<?php echo Yii::app()->createUrl('site/logout');?>">退出</a>
            </div>
                <!--<a style=" float: right; margin-right: 20px; margin-top: 5px;" class="btn btn-warning" href="<?php echo Yii::app()->createUrl('site/logout');?>">退出登录(<?php echo Yii::app()->user->getRealName(); ?>)</a>-->
        <?php } ?> 
    </div>
    <div style=" margin-right: 300px;font-size:24px;">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/logo.jpg">蜻蜓后台管理
    </div>  
</div> 