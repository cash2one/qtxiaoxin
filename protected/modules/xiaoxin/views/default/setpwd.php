<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head> 
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit|ie-comp"> 
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/newstyle.css">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(function () {
            //检测IE
            if ($.browser.msie && $.browser.version == "6.0") {
                window.location.href = 'ie6update.html';
            };
        }); 
    </script>
    <style>
        .error_info{display: inline;}
    </style>
    <meta content="校信,蜻蜓校信,校信通,校讯通,家校互动,家校通,家校沟通" name="Keywords">
    <title>蜻蜓校信—国内首款基于老师家长关系的社交应用  免费家校沟通平台</title>
</head>
<body> 
    <a href="javascript:void(0)" class="gotop" style="display: none;"></a>
    <!--start of header-->
    <div class="headerBar">
        <div class="header clearfix">
            <ul class="nav right">
                <li><a href=" /xiaoxin/default/login">首页</a></li>
                <li class="function"><a href="#main2">功能</a></li>
                <li><a href="http://www.qtxiaoxin.com/activitiesList.aspx">活动</a></li>
                <li><a href="http://www.qtxiaoxin.com/video.aspx">视频教程</a></li>
                <li class="end"><a href="http://www.qthd.com/" target="_blank">关于蜻蜓</a></li>
            </ul>
            <h1><a href=" "><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/logo.png" title="蜻蜓校信" alt="蜻蜓校信"></a></h1>
        </div>
    </div> 
    <!--start of header--> 
        
     <!--start of main1-->
    <div class="main1">
        <!--start of login-->
        <div class="login">
            <img class="slogin" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/slogin.jpg"> 
            <!-- form -->
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'formBoxRegister',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation'=>false,
            )); ?>
            <!-- <form id="formBoxRegister" action="" method="post">  -->   
            <div id="ContentPlaceHolder1_panStep3"> 
                <script type="text/javascript">
                    $(function () {
                        $("#btnEditPwd").click(function () {
                            var pwd = $.trim($("#pwd").val());
                            if (pwd.length < 6 || pwd.length > 16) {
                                $(".red").text("新密码长度不少于6位,不超过16位"); 
                                return false;
                            }
                            var pwd2 = $("#newpwd").val();
                            if ($.trim(pwd) != $.trim(pwd2)) {
                                $(".red").text("两次输入密码不一致,请重新输入"); 
                                return false;
                            }
                            if (!checkPassword(pwd)) {
                                $(".red").text("请勿使用简单密码"); 
                                return false;
                            }
                            $(".red").text(""); 
                        });
                    });
                    function checkPassword(pwd) {
                        // 长度为6到16个字符
                        var reg = /^.{6,16}$/;
                        if (!reg.test(pwd)) {
                            return false;
                        }
                        // 全部重复
                        var repeat = true;
                        // 连续字符
                        var series = true; 
                        var len = pwd.length;
                        var first = pwd.charAt(0);
                        for (var i = 1; i < len; i++) {
                            repeat = repeat && pwd.charAt(i) == first;
                            series = series && pwd.charCodeAt(i) == pwd.charCodeAt(i - 1) + 1;
                        }
                        return !(repeat || series);
                    }
                </script>
                <!-- start of 重置密码 -->
                
                <!-- end of 重置密码 --> 
            </div> 
            <?php $this->endWidget(); ?>
             <!-- </form> -->
        </div>
        <!--end of login-->
         <!--start of slide-->
        <div class="slide">
            <span class="phone1"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/phone1.png"></span>
            <div class="phone2">
                <em class="phone2Line"></em>
                <em class="phone2Line"></em>
                <ul class="slideImg">
                    <li style="opacity: 0;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/slideImg6.jpg"></li>
                    <li style="opacity: 0;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/slideImg5.jpg"></li>
                    <li style="opacity: 0;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/slideImg4.jpg"></li>
                    <li style="opacity: 1;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/slideImg3.jpg"></li>
                    <li style="opacity: 0;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/slideImg2.jpg"></li>
                    <li style="opacity: 0;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/slideImg1.jpg"></li>
                </ul>
            </div>
        </div>
        <!--end of slide-->
        
    </div>
    <!--end of main1-->  
     <!--start of footer-->
    <div class="footer">
        <p><a href="http://www.qthd.com/contact.aspx" target="_blank">联系我们</a>｜<a href="http://www.qthd.com/position.aspx" target="_blank">招聘信息</a></p>
         <p> Copyright@2014 QT Interactive CO.,LTD.All Ringhts Reserved. 深圳蜻蜓互动科技有限公司 粤ICP备14007625号-2</p>
    </div>
    <!--end of footer--> 
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/input.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/index.js"></script>
    <script> 
        function loginSubmit(){
            var username =$("#username").val();
            var password =$("#password").val();
            if(username==""||password==""){
               $('.errorSpanTip').text('帐号密码不能为空');
            }else{
                $('#formBoxRegister').submit();
            }
            
        }
    </script>
</body>
</html>