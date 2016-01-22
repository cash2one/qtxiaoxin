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
                        <img width="150px;" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/erxiaoxin.png">
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
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/openregister/step3.png">
                    </div>
                    <div class="formBox successBox"> 
                        <div class="successInfo"> 注册成功 </div>
                        <p class="info">你需要先创建一个班级，才能使用我们的功能哦！</p>
                        <div class="successBtnBox">
                            <a href="<?php echo $url;?>" id="linkBtn" class="btn btnColor1">创建一个班级(5)</a> 
                        </div>
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> 
    <script>
        $(function(){
            settime($('#linkBtn')); 
        }); 
             //计时器
            var countdown = 10;
            var off =true;
            function settime(val) { 
                if(!off){
                  return;
                }
                if (countdown == 0) {  
                    ///val.removeAttribute("disabled");
                    //val.css({background:'#ffffff',color:"#333333"});  
                    val.text("创建一个班级"); 
                    //countdown = 5; 
                     window.location.href="<?php echo $url;?>";
                    return;
                } else { 
                    //val.css({background:'#cccccc',color:"#ffffff",cursor: "default",borderColor:'#adadad'});  
                    val.text("创建一个班级（"+countdown+"）"); 
                    countdown--; 
                } 
                setTimeout(function() { 
                    settime(val);
                },1000); 
            }
    </script>
</body>
</html>