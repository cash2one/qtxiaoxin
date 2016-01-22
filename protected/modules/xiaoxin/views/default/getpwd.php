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
            <h1><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/index');?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/logo.png" title="蜻蜓校信" alt="蜻蜓校信"></a></h1>
        </div>
    </div> 
    <!--start of header--> 
        
     <!--start of main1-->
    <div class="main1">
        <!--start of login-->
        <div class="login" style="top:26%;">
            <img class="slogin" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/slogin.jpg"> 
            <!-- form --> 
            <form id="formBoxRegister" action="<?php echo Yii::app()->createUrl('xiaoxin/default/setpwd');?>" method="post"> 
                <div id="ContentPlaceHolder1_panStep1" style=""> 
                    <div class="forgetpas ">
                        <h2>重置密码 </h2>
                        <div class="statusBox">
                            <a rel="selectStatus" href="javascript:void(0);" tip="1" class="status"><em class="teacher"></em>我是老师</a>
                            <!--<a rel="selectStatus" href="javascript:void(0);" tip="2" class="last  "><em class="parents"></em>我是学生</a>-->
                            <a rel="selectStatus" href="javascript:void(0);" tip="3" class="last"><em class="parents"></em>我是家长</a>
                            <input id="radioBoxValue" name="ULoginForm[role]" type="hidden" value="1">
                        </div> 
                        <div class="input" style=" margin-bottom: 5px;">
                            <span class="valueSpan" style="color: rgb(153, 153, 153);">请输入注册手机号</span>
                            <input type="text" class="textInput telInput" id="mobile" maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                            <!--<input type="button" class="btn" onclick="settime(this)" value="获取验证码">--> 
                            <a id="btnGetVerifyCode" style=" line-height: 33px; text-decoration: none;" class="btn" href="javascript:void(0);">获取验证码</a>
                            
                        </div>
                        <div style="margin-bottom: 5px; color: #999999; text-align: right;">验证码30分钟内有效</div>
                        <div class="input">
                            <span class="valueSpan" style="color: rgb(153, 153, 153);">请输入验证码</span>
                            <input type="text" id="code" class="textInput">
                        </div>
                        <div  class="errorMsg errorCTip" style=" color: red;"></div>
                        <div class="botton">
                            <input type="button" id="btnCheckCode" value="提交验证码" class="btn">
                        </div>
                        <p><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/index');?>" class="loginText right">登录</a></p>
                    </div> 
                </div>
                <div id="ContentPlaceHolder1_panStep2" style=" display: none;" >
                    <div class="forgetpas ">
                        <h2>重置密码</h2>
                        <div class="input">
                            <span class="valueSpan" style="color: rgb(153, 153, 153);">请输入新密码</span>
                            <input type="password" class="textInput" id="pwd" maxlength="16">
                        </div>
                        <div class="input">
                            <span class="valueSpan" style="color: rgb(153, 153, 153);">确认新密码</span>
                            <input type="password" name="User[pwd]" class="textInput" id="newpwd" maxlength="16">
                        </div>
                        <div class="errorTip errorMsg " style=" color: #999999;">密码由6-16位不同数字和字母组合</div>
                        <div class="botton">
                            <input id="userId" name="User[uid]" type="hidden" name="" value="">
                            <input type="button" id="btnEditPwd" value="修改密码" class="btn">
                        </div>
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
         var urls ="<?php echo Yii::app()->createUrl('xiaoxin/default/sendcode');?>";
         var urly ="<?php echo Yii::app()->createUrl('xiaoxin/default/getpwd');?>"; 
        //计时器
        var countdown = 60;
        var off =true;
        function settime(val) { 
            if(!off){
              return;
            }
            if (countdown == 0) {  
                //val.removeAttribute("disabled");	
                val.text("获取验证码"); 
                //val.value="免费获取验证码"; 
                val.css({background:'#39a9f6',color:"#ffffff"});
                countdown = 60; 
                return;
            } else { 
                //val.setAttribute("disabled",'disabled'); 
                val.text("(" + countdown + "s)后重新获取"); 
                //val.value="（" + countdown + "）后再次获取";
                countdown--; 
            } 
            setTimeout(function() { 
                settime(val);
            },1000); 
         }
         //
         function ajaxPost(url,mobile,code,role){
            var str ="";
            $.ajax({  
                url:url,   
                type : 'POST',
                data : {ty:'pwd',mobile:mobile,code:code,role:role },
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {
                    str = mydata; 
                },  
                error : function() { 
                    str = "系统繁忙，请稍后再试";
                }  
            });
            return str;
        } 
         //选择老师
        $("[rel=selectStatus]").click(function(){
            $(this).addClass('status');
            $(this).siblings('a').removeClass('status'); 
            $("#radioBoxValue").val($(this).attr('tip'));
        });
        //提交 
       $("#btnCheckCode").click(function(){
           $('.errorCTip').text('');
            pstCode(); 
        });
        //
        function pstCode(){
            var eg =/^((1)+\d{10})$/;
            var code =$("#code").val();
            var mobile =$("#mobile").val();
            var role =$("#radioBoxValue").val();
            if(mobile==""){
                $('.errorCTip').text('手机号不能为空');
                return;
            }else{
                if(eg.test(mobile)){
                    if(code==""){
                        $('.errorCTip').text('验证码不能为空');
                        return;
                    }else{
                        var str =ajaxPost(urly,mobile,code,role);
                        //console.log(str);
                        var dataObj=eval( "("+ str +")" );
                        if(dataObj.state=="success"){
                            $("#ContentPlaceHolder1_panStep1").hide();
                            $("#ContentPlaceHolder1_panStep2").show();
                            $("#userId").val(dataObj.msg);
                        }else{
                            $('.errorCTip').text(dataObj.msg);
                        } 
                    }
                }else{
                    $('.errorCTip').text('您输入的手机号码格式不正确');
                }
                 
            }
        }
        //提交 code 的enter
        $('#code').keydown(function(){
            $('.errorCTip').text('');
            var event=arguments.callee.caller.arguments[0]||window.event;//消除浏览器差异  
            if (event.keyCode == 13){
                pstCode();
            }
        });
        $("#mobile").keydown(function(){
            $('.errorCTip').text('');
        });
        
        //获取验证码
        $('#btnGetVerifyCode').click(function(){ 
            var mobile =$("#mobile").val();
            var eg =/^((1)+\d{10})$/;
            var role =$("#radioBoxValue").val();
            if(countdown == 60){
                if(mobile!=""){
                    if(eg.test(mobile)){ 
                        var str =ajaxPost(urls,mobile,'',role);
                        if(str=="success"){
                           $(this).css({background:'#cccccc',color:"#999999"});
                           settime($(this)); 
                        }else{
                          $('.errorCTip').text(str);  
                        }
                    }else{
                        $('.errorCTip').text('请输入正确的手机号码');
                    } 
                }else{
                  $('.errorCTip').text('手机号不能为空');  
                }
            } 
        });
        
        //修改密码
        $('#btnEditPwd').click(function(){ 
            setPwds(); 
        });
        //修改密码enter
        $('#newpwd').keydown(function(){
            var event=arguments.callee.caller.arguments[0]||window.event;//消除浏览器差异  
            if (event.keyCode == 13){
                setPwds(); 
            }
        });
       function setPwds(){
            var pwd =  $.trim($('#pwd').val());
            var newpwd = $.trim($('#newpwd').val());
            var f = checkPassword(pwd); 
            if(pwd!=""){
                if(pwd.length>16||pwd.length<6){ 
                    $('.errorTip').text('密码由6-16位不同数字和字母组合').css("color",'red'); 
                }else{
                    if(pwd!=newpwd){
                        $('#newpwd').val('');
                        $('.errorTip').text('两次输入密码不一致').css("color",'red'); 
                    }else{
                        if(!f){
                                $(".errorTip").text("密码由6-16位不同数字和字母组合").css("color",'red'); 
                         }else{
                                $('#formBoxRegister').submit();
                        } 
                    } 
                } 
             }else if(pwd==""||newpwd==""){
                 $('.errorTip').text('请输入密码').css("color",'red'); 
             }
        } 
        //验证密码 
        function checkPassword(pwd) {
            // 长度为6到16个字符
            var reg = /^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;
            //alert(reg.test(pwd));
            if (!reg.test(pwd)) {
                return false;
            }else{
                return true;
            }
            //return false;
            // 全部重复
//            var repeat = true;
//            // 连续字符
//            var series = true; 
           // var len = pwd.length;
//            var first = pwd.charAt(0);
//            for (var i = 1; i < len; i++) {
//                repeat = repeat && pwd.charAt(i) == first;
//                series = series && pwd.charCodeAt(i) == pwd.charCodeAt(i - 1) + 1;
//            }
           
        }
    </script>
</body>
</html>