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
<body style=" min-height: 500px;"> 
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
            <h1><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/index');?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/logo.png" title="蜻蜓校信" alt="蜻蜓校信"></a></h1>
        </div>
    </div> 
    <!--start of header--> 
        
     <!--start of main1-->
    <div class="main1">
        <!--start of login-->
        <div class="login" style="top:18%">
            <img class="slogin" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/slogin.jpg"> 
            <!-- form --> 
            <form id="formBoxRegister" action="" method="post">
                <div id="ContentPlaceHolder1_panStep1" style=" "> 
                    <div class="forgetpas ">
                        <h2>激活用户 </h2>
                        <div class="statusBox">
                            <?php if($codeinfo->type==0):?> 
                            <a rel="selectStatus" href="javascript:void(0);" tip="1" class="status" style="cursor: default;"><em class="teacher"></em>我是老师</a>
                            <a rel="selectStatus" href="javascript:void(0);" tip="3" class="last"  style="cursor: default;"><em class="parents"></em>我是家长</a>
                            <?php else:?>
                            <a rel="selectStatus" href="javascript:void(0);" tip="1" class="" style="cursor: default;"><em class="teacher"></em>我是老师</a>
                            <!--<a rel="selectStatus" href="javascript:void(0);" tip="2" class="last  "><em class="parents"></em>我是学生</a>-->
                            <a rel="selectStatus" href="javascript:void(0);" tip="3" class="last status" style="cursor: default;"><em class="parents"></em>我是家长</a>
                            <?php endif;?>
                            <input id="radioBoxValue" name="Activeuser[type]" type="hidden" value="<?php echo $codeinfo->type;?>">
                        </div>
                        <div id="box_panStep1" class="userFomrBox">
                            <div class="input">
                                <?php if($student):?> 
                                    <div  style="height: 34px; line-height: 34px; padding-left: 5px;"class=" "><?php echo $student->name; ?></div>
                                    <input type="hidden" class="textInput" id="sname" name="Activeuser[name]" maxlength="10"   readonly="true" value="<?php echo $student->name; ?>">
                                <?php else: ?> 
                                    <?php if($codeinfo->type==0):?>
                                    <span class="valueSpan" style="color: rgb(153, 153, 153);">请输入姓名</span>
                                    <?php else:?>
                                     <span class="valueSpan" style="color: rgb(153, 153, 153);">请输入学生姓名</span>
                                    <?php endif; ?>
                                    <input type="text" class="textInput " id="sname" name="Activeuser[name]" maxlength="10">
                                <?php endif; ?>
                            </div> 
                            <?php if($codeinfo->type==0):?>
                            <?php else:?>
                                <div class="input">
                                    <span class="valueSpan" style="color: rgb(153, 153, 153);">请输入学生学号(非必填)</span>
                                    <input type="text" class="textInput" maxlength="20" id="studentid" name="Activeuser[studentid]" value="">
                                </div>
                            <?php endif; ?> 
                            <div class="input">
                                <span class="valueSpan" style="color: rgb(153, 153, 153);">请输入手机号（用作登录帐号）</span>
                                <input type="text" name="Activeuser[mobilephone]" value="" id="spmobile" maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" class="textInput">
                            </div>
                            <div class="input">
                                <span class="valueSpan"  style="color: rgb(153, 153, 153);">请设置登录密码</span>
                                <input type="password" maxlength="16" name="Activeuser[password]" id="sppwd" value="" class="textInput">
                            </div>
                            <div class="input">
                                <span class="valueSpan" style="color: rgb(153, 153, 153);">确认登录密码</span>
                                <input type="password"  name="Activeuser[password2]"   id="sppwdr" class="textInput">
                            </div>
                            <div  class="errorMsg errorCTip" style=" color: red;"></div>
                            <div class="botton">
                                <input type="button" id="btnCheckCode" value="激 活" class="btn">
                            </div>
                        </div> 
                        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/index');?>" class="loginText right">登录</a></p>
                    </div> 
                </div> 
            </div>
        </form>  
        <!-- </form> -->
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
     <div class="clearfix" style=" clear: both; height: 10px; width: auto;"></div>
    <div class="footer clearfix">
        <p><a href="http://www.qthd.com/contact.aspx" target="_blank">联系我们</a>｜<a href="http://www.qthd.com/position.aspx" target="_blank">招聘信息</a></p>
         <p> Copyright@2014 QT Interactive CO.,LTD.All Ringhts Reserved. 深圳蜻蜓互动科技有限公司 粤ICP备14007625号-2</p>
    </div>
    <!--end of footer--> 
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/input.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/index.js"></script>
    <script type="text/javascript"> 
        //提交 
       $("#btnCheckCode").click(function(){
           $('.errorCTip').text('');
            pstCode(); 
        });
        function pstCode(){
            var eg =/^((1)+\d{10})$/;
            var name = $.trim($("#sname").val());
            var mobile = $.trim($("#spmobile").val());
            var pwd =$.trim($("#sppwd").val());
            var pwdr =$.trim($("#sppwdr").val());
            var role =$.trim($("#radioBoxValue").val());
            var f = checkPassword(pwd);  
            if(name==""){
                $('.errorCTip').text('姓名不能为空');
                $("#sname").val('');
                return;
            }else{
                if(mobile!=""){
                    if(eg.test(mobile)){
                        if(pwd==""){
                            $('.errorCTip').text('密码不能为空');
                            return;
                        }else{  
                            if(pwd.length>16||pwd.length<6){ 
                                    $('.errorCTip').text('密码由6-16位数字字母或组合组成');
                                    return false;
                            }else { 
                                if(pwdr==""){
                                    $('.errorCTip').text('请再次输入密码');
                                }else{
                                    if(pwd==pwdr){
                                        if(!f) {
                                            $('.errorCTip').text('请勿使用简单密码'); 
                                        }else{
                                            $("#formBoxRegister").submit(); 
                                        }  
                                    }else{
                                        $("#spwdr").val('');
                                        $('.errorCTip').text('两次次输入的密码不一致');
                                    }
                                }   
                            } 
                        }
                    }else{
                        $('.errorCTip').text('您输入的手机号码格式不正确');
                    }
                }else{
                     $('.errorCTip').text('手机号码不能为空');
                } 
            }
        }
        //提交 code 的enter
        $('#pwdr').keydown(function(){
            $('.errorCTip').text('');
            var event=arguments.callee.caller.arguments[0]||window.event;//消除浏览器差异  
            if (event.keyCode == 13){
                pstCode();
            }
        });
        $("#smobile,#sname,#spwd,#spwdr").keydown(function(){
            $('.errorCTip').text('');
        }); 
        //验证密码 
        function checkPassword(pwd) {
            // 长度为6到16个字符
            var reg = /^[0-9a-zA-Z]{6,16}$/;
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
           if(pwd<=9){  
               return (repeat || series);
            }else{  
               return !(repeat || series); 
            }
        }
        $(function(){ 
            $("#spmobile").val('');
            $("#sppwd").val('');

        })
    </script>
    <?php Yii::app()->msg->printMsg(); ?>
</body>
</html>