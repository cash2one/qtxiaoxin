<html>
<head> 
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit|ie-comp">
    <title><?php echo CHtml::encode(Yii::app()->name); ?></title>
    <link rel="shortcut icon" type="image/ico" href="<?php echo Yii::app()->request->baseUrl; ?>/image/favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/openRegister.css">
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
    <style> 
        .reminder{ width: 358px; background-color: #fff; border:1px solid #ccc; position: fixed; right:30px; top:30px; z-index: 100; box-shadow: 0 0 5px #ccc;
        -moz-box-shadow: 0 0 5px #ccc;-webkit-box-shadow: 0 0 5px #ccc;-o-box-shadow: 0 0 5px #ccc;-ms-box-shadow: 0 0 5px #ccc;}
        .reminderTit{ height:44px; line-height: 44px;font-family: "微软雅黑"; font-size: 17px; color: #fff; background:#169af5 url('/image/xiaoxin/reminderIco.png') no-repeat 15px 12px; padding-left:45px;}
        .reminder em.colse{ position: absolute; right:0; top:0; width:44px; height:44px; display: block; text-indent: -999em; overflow:hidden; font-family:"微软雅黑"; font-size: 20px; color: #FFF; cursor: pointer; font-style: normal;background:url('/image/xiaoxin/reminderIco.png') no-repeat center -68px;}
        .reminderCom{ font-size: 13px;font-family: "微软雅黑"; padding:20px;}
        .reminderCom span{ color: #f37112;}
    </style> 
</head>
<body>
    <!--start of reminder温馨提醒-->
    <div class="reminder" style=" display: none;">
        <em class="colse">x</em>
        <div class="reminderTit">温馨提醒</div>
        <div class="reminderCom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;各位尊敬的用户：
首先非常感谢您一直以来对“蜻蜓校信”的支持与关注， 新版本在10月15日上线以来，收到学校和家长提出的宝贵建议，对产品优化起到较好的促进作用，同时我们也对新功能进行了持续的完善升级，针对手机版、网页版将会定期推出新功能，不断为各位提供更好的产品体验与服务，希望您能一如既往的支持蜻蜓校信！
以下为蜻蜓校信最新产品发布动态：<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1、老师‘工具版’客户端将在近期上线，产品上线突破了传统家校产品在电脑端局限，真正实现移动互联的家校沟通，让老师轻松实现移动办公；全新界面体验，功能契合老师实际需求更实用。具体上线时间，请留意系统信息通知。<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2、IOS版本已通过苹果公司审核，将在11月13日（周四）开放下载，最新的版本号为3.301；您可以在‘蜻蜓互动’官网点击 “下载手机客户端”扫描二维码或在App Store搜索“蜻蜓校信”软件进行下载；另在IOS审核期间以短信方式的代发服务将在11月15日关闭。请知悉。<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3、安卓版本预计在本周内进行产品升级，最新版本号为2.413。您可以在‘蜻蜓互动’官网下方扫描二维码，或打开APP进行在线升级。<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;再次感谢您对“蜻蜓互动”的支持和关注！有您的肯定与认可蜻蜓互动会走得更远，持续为大家提供更优质的产品与服务！
客服电话：<span> 400-101-3838.</span></div>
    </div>
    <!--end of reminder温馨提醒--> 
    <!--start of header-->
    <div class="headerBar">
        <div class="header clearfix">
            <ul class="nav fright">
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/login');?>">首页</a></li>
                 <li class="function"><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/login');?>#main2">功能</a></li>
                <li><a href="http://service.qtxiaoxin.com/activitiesList.aspx">活动</a></li>
                <li><a href="http://service.qtxiaoxin.com/video.aspx">视频教程</a></li>
                <li class="end"><a href="http://www.qthd.com/" target="_blank">关于蜻蜓</a></li>
            </ul>
            <h1><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/login');?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/logo.png" title="蜻蜓校信" alt="蜻蜓校信"></a></h1>
        </div> 
    </div> 
    <!--start of header--> 
    <div class="layout_div" style=" padding-top: 100px;">
        <div class="layout_main">
            <h1 class="headTitle">欢迎您注册使用蜻蜓校信产品！</h1>
            <div class="layout_conrent">
                <div class="rSubBox fright">
                    <div class="imgBox">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/openregister/logo1.png">
                    </div>
                    <div class="imgBox">
                        <img width="160px;" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/erxiaoxin.png">
                        <h3>客户端下载</h3>
                    </div>
                    <ul>
                        <li>功能丰富，专业教育互动平台</li>
                        <li>互动形式多样，体验更佳</li>
                        <li>随时随地，自由沟通</li>
                    </ul>
                </div>
                <div class="mainBox"> 
                    <div class="step" style=" text-align: center; width: ">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/openregister/step2.png">
                    </div>
                    <div class="formBox openReginfo">
                        <form id="formBoxRegister" action="<?php echo Yii::app()->createUrl('xiaoxin/openregister/openreginfo');?>" method="post">
                            <h2>身份设定</h2>
                             <p>
                                <span class="title">您的姓名：</span>
                                <input type="text" placeholder="真实的名字便于家长了解" autocomplete="off" class="text" maxlength="8" name="name" id="name">
                                <input type="hidden" name="phone" value="<?php echo $phone?>">
                                <input type="hidden" name="uid" value="<?php echo $uid?>">
                             </p>
                            <p>
                                <span class="title">学校名称：</span> 
                                <input type="text" class="text" placeholder="真实的校名便于找到同校班级" maxlength="20" name="schoolName" autocomplete="off" id="schoolName">
                                <input id="schoolNameSid" type="hidden" name="sid" value="0">
                                <input id="schoolNameTure" type="hidden" name="sidddd" value="0">
                            </p>
                            <p class="error" style=" margin-bottom: 5px;" >
                                <span class="title">&nbsp;</span>
                                <span class="errorTextsname"></span>
                            </p> 
                            <h2 style=" margin-top: 0px;">密码设定</h2>
                            <p>
                                <span class="title">登录密码：</span>
                                <input type="password" placeholder="6-16位数字和字母组合" autocomplete="off" maxlength="16" class="text" name="password" id="password">
                            </p>
                            <p>
                                <span class="title">确认密码：</span>
                                <input type="password"  placeholder="再次确认密码" autocomplete="off" maxlength="16" class="text" name="pwdconfirm" id="pwdconfirm">
                            </p>
                            <p class="error">
                                <span class="title">&nbsp;</span>
                                <span class="errorText"></span>
                            </p> 
                            <p class="">
                                <span class="title">&nbsp;</span>
                                <a style=" width: 90px;" href="<?php echo Yii::app()->createUrl('xiaoxin/openregister/index')?>" class="btn btnColor2">返 回</a>
                                <a style=" width: 90px;" href="javascript:;" id="postFormBtn" class="btn btnColor1">提 交</a>
                            </p>
                        </form>
                    </div> 
                </div> 
            </div> 
        </div> 
    </div>
    <script>
        $(function(){ 
            $("#name,#password,#pwdconfirm").keydown(function(){
                $('.errorText').text('');
            }); 
            $("#schoolName").keydown(function(){
                $('.errorTextsname').text('');
            });
            $("#schoolName").focusout(function(){
                var urls= '<?php echo Yii::app()->createUrl("ajax/checkschool")?>'; 
                var sname =$.trim($("#schoolName").val());
                if(sname){
                    var str =ajaxSchoolPost(urls,sname);
                    if(str.status=='0'){
                        $("#schoolNameTure").val(0); 
                        $('.errorTextsname').text('该学校暂时不支持开放注册,请联系客服').css({color:"red"});
                    }else if(str.status=='2'){ 
                        $("#schoolNameTure").val(1); 
                        $("#schoolNameSid").val(str.sid);
                        $('.errorTextsname').text(' ').css({color:"#434343"});
                    }else{
                        $("#schoolNameTure").val(1); 
                        $('.errorTextsname').text(' ').css({color:"#434343"});
                    } 
                } 
            });
        });
        
        //修改密码enter
        $('#pwdconfirm').keydown(function(){
            var event=arguments.callee.caller.arguments[0]||window.event;//消除浏览器差异  
            if (event.keyCode == 13){
                $('#postFormBtn').click(); 
            }
        });
        $('#postFormBtn').click(function(){
            var egt = /[\u4e00-\u9fa5]/;
            var name = $('#name').val();
            var sname = $('#schoolName').val();
            var pwd = $('#password').val();
            var pwdconf = $('#pwdconfirm').val(); 
            var nameTure =$("#schoolNameTure").val();
            if(name){
                if(name.match(egt) !== null) {
                    if(sname){
                        if(sname.match(egt) !== null) { 
                            if(nameTure=='1'){
                                if(pwd){
                                    if(checkPassword(pwd)){
                                        if(pwdconf){
                                            if(pwd==pwdconf){
                                                $('#formBoxRegister').submit(); 
                                            }else{
                                              $('.errorText').text('您两次输入的密码不一致').css({color:"red"});  
                                            } 
                                        }else{
                                           $('.errorText').text('请再次输入密码').css({color:"red"});   
                                        } 
                                    }else{
                                       $('.errorText').text('密码为6-16位数字和字母组合').css({color:"red"}); 
                                    } 
                                }else{
                                   $('.errorText').text('请输入密码').css({color:"red"});   
                                }    
                            }else{
                                $('.errorTextsname').text('该学校暂时不支持开放注册,请联系客服').css({color:"red"});   
                            }
                        }else{
                            $('.errorText').text('请使用中文字填写学校名称').css({color:"red"});
                        }
                    }else{
                        $('.errorText').text('请输入学校名称').css({color:"red"});
                    }
                } else {
                  $('.errorText').text('请使用中文字填写姓名').css({color:"red"});
                }

                 
            }else{
               $('.errorText').text('请输入您的姓名').css({color:"red"});
            }
            
        });
        //验证 学校名
        function ajaxSchoolPost(url,sname){
            var str ="";
            $.ajax({  
                url:url,
                type : 'POST',
                data : {sname:sname},
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {
                    var date =$.parseJSON(mydata);
                    str = date; 
                },  
                error : function() { 
                    //str = "系统繁忙,请稍后再试";
                }  
            });
            return str;
        }
         function checkPassword(pwd) {
        // 长度为6到16个字符
            var reg = /^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;
            //alert(reg.test(pwd));
            var len = pwd.length;
            if(len>=6&&len<=16){
                if (!reg.test(pwd)) {
                    return false;
                }else{
                    return true;
                }  
            }else{
               return false; 
            }
        }
    </script>
</body>
</html>