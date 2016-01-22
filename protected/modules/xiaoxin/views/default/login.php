<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head> 
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit|ie-comp">
    <title><?php echo CHtml::encode(Yii::app()->name); ?></title>
    <link rel="shortcut icon" type="image/ico" href="<?php echo Yii::app()->request->baseUrl; ?>/image/favicon.ico">
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
    <div class="reminder"  style="width:450px; display: none;">
        <em class="colse">x</em>
        <div class="reminderTit">产品更名公告</div>
        <div class="reminderCom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;尊敬的用户：<br/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;为了给用户提供更丰富、更便捷的服务，“蜻蜓校信”将自2015年3月 1日正式更名为“班班”。“班班”新增“班费”功能，系统更稳定，将为您带来更好的沟通体验。<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;全新“班班”安卓用户可自行升级使用；苹果用户可按系统提示重新下载后使用。目前新功能“班费”暂时只对安卓用户开放，苹果用户开通时间请留意后续的消息提示。<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;未及时升级或下载“班班”的用户，仍可正常使用“蜻蜓校信”。感谢新老用户的支持与关注。我们将一如既往为您提供更好的产品服务。
客服电话：<span> 400-101-3838</span>
<p style=" text-align: right;">深圳蜻蜓互动科技有限公司</p>
<p style=" text-align: right;">2015年2月26日</p></div>
    </div>
    <!--end of reminder温馨提醒-->
    <a href="javascript:void(0)" class="gotop" style="display: none;"></a>
    <!--start of header-->
    <div class="headerBar">
        <div class="header clearfix">
            <ul class="nav right">
                <li><a href=" /xiaoxin/default/login">首页</a></li>
                <li class="function"><a href="#main2">功能</a></li>
                <li><a href="http://service.qtxiaoxin.com/activitiesList.aspx">活动</a></li>
                <li><a href="http://service.qtxiaoxin.com/video.aspx">视频教程</a></li>
                <li class="end"><a href="http://www.qthd.com/" target="_blank">关于蜻蜓</a></li>
            </ul>
            <h1><a href=" "><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/logo.png" title="蜻蜓校信" alt="蜻蜓校信"></a></h1>
        </div> 
    </div>
    <!--start of header-->  
     <!--start of main1-->
     <div class="main1" style="overflow: hidden;">
        <div style=" margin-top: 80px; font-size: 14px;"> 
            <!--<marquee behavior="scroll" scrollamount="5" direction="left" align="middle" onMouseOut="this.start()" onMouseOver="this.stop()" >亲爱的各位用户：为了给大家提供更好的产品体验，原计划在10月15日上线的新版“蜻蜓校信”将会分批逐步上线，第一批上线的依次为<老师网页版>，<家长网页版>及<家长手机APP版>（安卓系统）。苹果手机的用户暂时会以短信的形式接收信息，待苹果官方审核通过后可下载使用，敬请留意近期系统信息通知！感谢您对蜻蜓校信的关注与支持。谢谢！如需咨询更多的具体详情可致电　400-101-3838　我们将竭诚为您服务！</marquee>-->
        </div>
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
                <div class="statusBox">
                    <a rel="selectStatus" href="javascript:void(0);" tip="1" class="status"><em class="teacher"></em>我是老师</a>
                    <!--<a rel="selectStatus" href="javascript:void(0);" tip="2" class="last  "><em class="parents"></em>我是学生</a>-->
                    <a rel="selectStatus" href="javascript:void(0);" tip="4" class="last"><em class="parents"></em>我是家长</a>
                    <input id="radioBoxValue" name="ULoginForm[role]" type="hidden" value="1">
                </div> 
                <div class="loginBar ">
                    <div class="input userName">
                        <span class="valueSpan" style="color: rgb(153, 153, 153); display: block;">请输入您的手机号或账号</span>
                        <input id="username" name="ULoginForm[username]" value="" type="text" maxlength="30" id="ContentPlaceHolder1_txtTelephone" class="textInput" size="11" autocomplete="off" value="<?php echo $model->username; ?>">
                    </div>
                    <div class="input password">
                        <span class="valueSpan" style="color: rgb(153, 153, 153);">请输入您的密码</span>
                        <input id="password" name="ULoginForm[password]" value=""  type="password" maxlength="16" id="ContentPlaceHolder1_txtPwd" class="textInput" autocomplete="off">
                    </div>
                    <div class="rememberme">
                        <a href="<?php echo Yii::app()->createUrl('xiaoxin/default/getpwd');?>" class="right green">忘记密码？</a> 
                        <!--<a href="<?php echo Yii::app()->createUrl('xiaoxin/default/activeverify');?>" class="right green" style="margin-right: 10px;">激活帐号</a>-->
                        <input id="rememberme" type="checkbox" name="rememberme" ><label for="rememberme">记住我</label>
                        <input id="remembermeHidden" type="hidden" name="ULoginForm[rememberMe]" value="0"> 
                    </div>
                    <div class="clearfix" style="padding:5px 0px;">  
                        <span class="errorSpan" style="color: #EE0000;">
                            <?php echo $form->error($model,'role',array('class'=>'error_info')); ?> 
                            <?php echo $form->error($model,'username',array('class'=>'error_info')); ?>  
                            <?php echo $form->error($model,'password',array('class'=>'error_info')); ?> 
                        </span>
                        <span class="errorSpan errorSpanTip"  style="color: #EE0000;"></span>
                    </div> 
                    <div class="botton">
                        <a onclick="return loginSubmit();" id="lbtnLogin" class="btn loginBtn" href="javascript:void(0);" style="float:left; background-color: #ff6c00;">
                            登　　录
                        </a>
<!--                        <a href="javascript:void(0)" class="btn blueBtn" onfocus="this.blur();">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/down.png" title="下载手机端" alt="下载手机端"  style="margin-top:7px;">
                         </a>-->
                        <!-- <a href="<?php echo Yii::app()->createUrl('xiaoxin/openregister/index')?>"  id="lbtnLogin" class="btn blueBtn"style="background-color: #18a535;">
                             老师注册
                        </a> -->
                    </div>
                  <!--   <div class="botton">
                        <a href="javascript:void(0)" class="btn blueBtn" onfocus="this.blur();" style=" margin-left: 0; height:30px; line-height: 40px; padding: 5px 0; width: 290px;">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/down.png" title="下载手机端" alt="下载手机端">
                         </a>
                    </div> -->
                </div> 
            <!-- </form> -->
            <?php $this->endWidget(); ?>
             <!-- form -->
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
        <div class="more"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/tel.jpg">
            <a href="javascript:void(0)">了解更多</a>
        </div>
    </div>
    <!--end of main1-->
     <!--start of main2-->
    <div id="main2" class="main2">
        <div class="double">
            <div class="content clearfix">
                <div class="conImg left"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/phone3.jpg"></div>
                <div class="detail right">
                    <h2>多平台支持，<br>满足不同用户需求</h2>
                    <p>支持网页、手机、平板等多种终端；<br>兼容Android、IOS等主流智能手机和平板操作系统；<br>覆盖网络、短信双通道。用户自主选择、自由切换。</p>
                </div>
            </div>
        </div>


        <div class="odd">
            <div class="content content4 clearfix">
                <div class="conImg right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/phone4.jpg"></div>
                <div class="detail left">
                    <h2>功能丰富，<br>专业教育互动平台</h2>
                    <p>家庭作业、学校通知、每日餐单、教育资讯、成绩管理……<br>丰富的专属教育行业功能版块，<br>操作界面清晰，简单易用。</p>
                </div>
            </div>
        </div>
        

        <div class="double">
            <div class="content content5 clearfix">                
                <div class="conImg left"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/phone5.jpg"></div>
                <div class="detail right">
                    <h2>互动形式多样，<br>体验更佳</h2>
                    <p>不局限于文字，图片、语音、视频、<br>数据等多媒体形式呈现，<br>交流更加生动、有趣。</p>
                </div>
            </div>
        </div>
        

        <div class="odd">
        <div class="content content6">
            <div class="conImg right"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/phone6.jpg"></div>
            <div class="detail left">
                <h2>随时随地，自由沟通</h2>
                <p>新型网络通讯技术，替代短信单一通道，<br>实现家长、老师实时互动交流，<br>沟通高效快捷。</p>
            </div>
        </div> 
        </div>
    </div>
    <!--end of main2--> 
    <!--start of download-->
    <div class="downloadBar" style=" display: none;">
        <div class="download clearfix" >
            <h3>客户端下载</h3>
            <div class="clearfix" style=" margin: 0 auto; width: 510px;">
               <!-- <dl class="downloadList left">
                    <dt><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/iphone.png" title="iphone" alt="iphone"></dt>
                    <dd><a class="icoApp" href="https://itunes.apple.com/us/app/you-jiao-xiao-xin-tong/id684150114?ls=1&mt=8" target="_blank">App Store</a></dd>
                    <dd><a class="icoyyb" href="http://www.qthd.com/upgrade/download.aspx?appkey=xxt_iphone&resolution=960_640" target="_blank">I0S越狱版</a></dd>
                </dl>--> 
                <dl class="downloadList left">
                    <dt><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/android.png" title="android" alt="android"></dt>
                    <dd><a class="icogfxz" href="<?php echo SITE_APP_DOWNLOAD_URL;?>" target="_blank">官方下载</a></dd>
                    <!---<dd><a class="icoWdj" href="http://www.wandoujia.com/apps/cn.youteach.xxt2" target="_blank">豌豆荚</a></dd> -->                  
                </dl> 

               <div class="code right"style=" width: 184px; margin: 0 auto;">
                    <h2>二维码下载</h2>
                    <img width="150" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/code.jpg" alt="code">
                </div>
            </div>
        </div>
    </div>    
    <!--end of download--> 
     <!--start of footer-->
    <div class="footer">
        <p><a href="http://www.qthd.com/about.aspx?type=lianxi" target="_blank">联系我们</a>｜<a href="http://www.qthd.com/joinus.aspx" target="_blank">招聘信息</a></p>
         <p> Copyright@2014 QT Interactive CO.,LTD.All Ringhts Reserved. 深圳蜻蜓互动科技有限公司 <a href="http://www.miibeian.gov.cn">粤ICP备14076064号-3</a></p>
    </div>
    <!--end of footer--> 
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/input.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/index.js"></script>
    <script type="text/javascript">
        //选择老师
        $("[rel=selectStatus]").click(function(){
            $(this).addClass('status');
            $(this).siblings('a').removeClass('status'); 
            $("#radioBoxValue").val($(this).attr('tip'));
        });
        //记住密码
        $("#rememberme").change(function(){
            var attrC =$(this).attr("checked");
            if(attrC=="checked"){
                $("#remembermeHidden").val('1');
            }else{
                 $("#remembermeHidden").val('0');
            }
        });
        function loginSubmit(){
            var username =$("#username").val();
            var password =$("#password").val();
            if(username==""||password==""){
               $('.errorSpanTip').text('用户名或密码不能为空');
               $('.error_info').text('');
            }else{
                
                $('#formBoxRegister').submit();
            } 
        }
        $('#password').keydown(function(){
            var event=arguments.callee.caller.arguments[0]||window.event;//消除浏览器差异  
            if (event.keyCode == 13){
                loginSubmit();
            }
        });
    </script>
     <script type="text/javascript">
        $(".reminder .colse").click(function(){ 
            $(this).parent('.reminder').hide();
        });
    </script>
    <?php Yii::app()->msg->printMsg(); ?>
</body>
</html>