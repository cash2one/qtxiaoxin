<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html style="height: 100%; overflow: hidden; margin: 0; padding: 0; border: 0;">
<head> 
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit|ie-comp"> 
    <title><?php echo CHtml::encode(Yii::app()->name); ?></title>
    <link rel="shortcut icon" type="image/ico" href="<?php echo Yii::app()->request->baseUrl; ?>/image/favicon.ico">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/style.css">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/pegStyle.css" rel="stylesheet" type="text/css"/>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/common.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/cookie.js" type="text/javascript"></script>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/default/read.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/default/qqkf.css" rel="stylesheet" type="text/css"/> 
    <style>
        .reminderCom a{ display: block; }
        .reminderCom a:hover{ opacity: 0.8; }
    </style>
</head>

<body style="height: 100%; zoom:1; overflow: hidden; margin: 0; padding: 0; border: 0;">
    <div id="layoutBodyBox" class="layoutBodyBox"> 
        <?php include('sidebar.php'); ?>
        <div id="layoutBox" class="layoutBox">
            <?php echo $content; ?> 
        </div>
        
    </div> 
    <div class="qqkf" id="qqkf">
          <ul class="qq-list" > 
              <li>
                    <div class="q-person">
                        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=318602664&site=qq&menu=yes">客服QQ</a>
                    </div>
              </li>
              <li>
                    <div class="q-person">
                        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2050745544&site=qq&menu=yes">客服QQ</a>
                    </div>
              </li>
            
              <li>
                    <div class="q-person">
                        <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1919036624&site=qq&menu=yes">客服QQ</a>
                    </div>
              </li>
          </ul>
          <div class="qq-tit" ></div>
    </div>
    
    <?php if(Yii::app()->user->getIdentity()==1):?>
    <!--老师--> 
    <!-- 活动公告 -->
    <?php if(SchoolTeacherRelation::getAreaByUser(Yii::app()->user->id,1) && SchoolTeacherRelation::isSelfReg()): ?>
    <!--div id="reminderActive" class="reminder" style="bottom: 10px; display: none; width: 600px; display: none; background-color: transparent; border: none; -webkit-box-shadow: none;box-shadow:none;" >
        <em class="colse" style="z-index:1;">x</em>
        <div class="reminderCom" style="padding: 0; position: relative;"> 
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/christmasActive.png">
            <a href="<?php echo Yii::app()->createUrl('xiaoxin/activity/');?>" target="_blank" style="position: absolute; left: 180px; bottom: 40px;">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/activityLink.png">
            </a>
        </div>
    </div-->
    <?php endif; ?>
    <!--/活动公告-->

    <!--div id="reminderCookie" class="reminder" style="display: none;">
        <em class="colse">x</em>
        <div class="reminderTit">产品更名公告</div>
        <div class="reminderCom">
            <p>亲爱的用户：</p>
            <p class="indent">为了给用户提供更丰富、更便捷的服务，“蜻蜓校信”将自2015年3月 1日正式更名为“班班”。“班班”新增“班费”功能，系统更稳定，将为您带来更好的沟通体验。</p>
            <p class="indent">全新“班班”安卓用户可自行升级使用；苹果用户可按系统提示重新下载后使用。目前新功能“班费”暂时只对安卓用户开放，苹果用户开通时间请留意后续的消息提示。</p>
            <p class="indent">未及时升级或下载“班班”的用户，仍可正常使用“蜻蜓校信”。感谢新老用户的支持与关注。我们将一如既往为您提供更好的产品服务。 客服电话：<span>400-101-3838</span></p>
            <p style=" text-align: right;">深圳蜻蜓互动科技有限公司</p>
            <p style=" text-align: right;">2015年2月26日</p>
        </div>
    </div-->
    <div class="erweimaApp">
        <?php if(time()<strtotime('2015-01-13 00:00:00') && SchoolTeacherRelation::getAreaByUser(Yii::app()->user->id,1) && SchoolTeacherRelation::isSelfReg()): ?>
            <a href="javascript:;" rel="christmasActiveInfo">
                <img title="扫一扫参与活动获圣诞大礼" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/christmasTrees.png" >
            </a>
        <?php else: ?>
            <img width="150px;" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/erxiaoxin.png">
        <?php endif; ?>
    </div>
    <!--老师--> 

     <?php elseif (Yii::app()->user->getIdentity()==4):?>
     <!-- 家长-->
       <!--div id="reminderCookie" class="reminder" style="display: none;">
        <em class="colse">x</em>
        <div class="reminderTit">产品更名公告</div>
        <div class="reminderCom">
            <p>亲爱的用户：</p>
            <p class="indent">为了给用户提供更丰富、更便捷的服务，“蜻蜓校信”将自2015年3月 1日正式更名为“班班”。“班班”新增“班费”功能，系统更稳定，将为您带来更好的沟通体验。</p>
            <p class="indent">全新“班班”安卓用户可自行升级使用；苹果用户可按系统提示重新下载后使用。目前新功能“班费”暂时只对安卓用户开放，苹果用户开通时间请留意后续的消息提示。</p>
            <p class="indent">未及时升级或下载“班班”的用户，仍可正常使用“蜻蜓校信”。感谢新老用户的支持与关注。我们将一如既往为您提供更好的产品服务。 客服电话：<span>400-101-3838</span></p>
            <p style=" text-align: right;">深圳蜻蜓互动科技有限公司</p>
            <p style=" text-align: right;">2015年2月26日</p>
        </div>
    </div-->
    <!-- /家长-->
     <?php endif; ?>
    <input id="reminderCookieType" type="hidden" value="activeT_<?php echo (Yii::app()->user->id).'_'.Yii::app()->user->getIdentity(); ?>">
    <script type="text/javascript" >
        //提醒设置Cookie
        var cookieValue =$('#reminderCookieType').val();
        $(".reminder .colse").click(function(){ 
            //delCookie("reminderCookie");
            $(this).parent('.reminder').hide();
            setCookie('reminderCookie',cookieValue,'d365');
        });
      //显示活动
      //cookieType(cookieValue,'#reminderActive');
      //显示公告
      cookieType(cookieValue,'#reminderCookie');
      
      //活动按钮
       $('[rel=christmasActiveInfo]').click(function(){
           $("#reminderActive").show(); 
       }); 
       //cookie状态
       function cookieType(cookieValue,obj){
            var Val = getCookie("reminderCookie");
            if(Val==cookieValue){
                $(obj).hide();
            }else{
                $(obj).show();
            }
       }
       
        //根据浏览器大小控制网页大小
        var subR = 0; 
        function AutoHeight() {//根据浏览器大小控制网页大小
            var Height_Page = window.document.body.clientHeight;
            var Width_Page = window.document.body.clientWidth;
            var Height_Page_Using = document.documentElement.clientHeight;
            var Width_Page_Using = document.documentElement.clientWidth;
            if(getBrowser() == "msie7.0" || getBrowser() == "msie6.0" || getBrowser() == "msie5.0"){  
                //var Width_Sider = Sider.offsetWidth;
                //var Height_Crumb = Crumb.offsetHeight; 
                //若以上无效，则采用(主要是IE6.0，5.0需要)
                if(Height_Page > Height_Page_Using){
                    Height_Page = Height_Page_Using;
                }
               if(Width_Page > Width_Page_Using){
                    Width_Page = Width_Page_Using;
                }
                initPage(Height_Page,Width_Page); 
            }else{
                initPage(Height_Page,Width_Page);  
            }
        } 
        //页面初始化
        function  initPage(pageHeight,pageWidth){ 
            var Subnav = document.getElementById("subnavBox");
            var Layout = document.getElementById("layoutBox"); 
            var Menu = document.getElementById('menuBox');
            var SubmenuBoxR = document.getElementById('submenuBoxR');
            var ContentBox = document.getElementById('contentBox');
            var LayoutBody = document.getElementById('layoutBodyBox');
            subR = parseInt(pageWidth * 0.15); 
            if(pageWidth<=1200){ 
                if(subR<=167){
                    subR=167;
                } 
                if(getBrowser() == "msie7.0" || getBrowser() == "msie6.0" || getBrowser() == "msie5.0"){  
                    Layout.style.width='auto'; 
                }else{
                    Layout.style.width='951px';
                }
                LayoutBody.style.overflowX= "auto";
            }else{ 
                Layout.style.width='auto';
                LayoutBody.style.overflowX= "hidden";
            }  
            SubmenuBoxR.style.width=subR+'px';
            ContentBox.style.marginRight =(subR+20)+'px';
            LayoutBody.style.height = pageHeight+"px";
            var subnavH = Subnav.offsetHeight;
            if(subnavH > pageHeight){
                pageHeight = subnavH;
            } 
            var LayoutH = Layout.offsetHeight;
            if(LayoutH >pageHeight){ 
                pageHeight = LayoutH;
            }  
            if($('#submenuBoxR').data('viwe')=='show'){
                ContentBox.style.marginRight=(subR+20)+"px";
            }else{
                SubmenuBoxR.style.right='-'+subR+'px';
                ContentBox.style.marginRight="5px";
            }  
            Subnav.style.height = pageHeight+"px";
            Menu.style.height = pageHeight -186+"px";
            var showId =$(".promptMask").attr('id');
            if(showId){ 
                $("#"+showId).css('height', pageHeight+"px");
            } 
        }
        function getBrowser() {//浏览器判断
            var Sys = {};
            var ua = navigator.userAgent.toLowerCase();
            var re = /(msie|firefox|chrome|opera|version).*?([\d.]+)/;
            var m = ua.match(re);
			if(m&&m[1]){
				Sys.browser = m[1].replace(/version/, "'safari");
				Sys.ver = m[2];
				return Sys.browser + Sys.ver;
			}else{
				return '';
			}
        }
        AutoHeight();
        window.onresize = function() {//改变浏览器大小的时候触发
            AutoHeight();
//            var r = document.body.offsetWidth / window.screen.availWidth;
//            $(document.body).css("-webkit-transform","scale(" + r + ")");
        }
        window.onload = function() {//页面加载触发
            AutoHeight();
            safariOptimize($(".groupBox ul li a span,.selectListBox ul li a span")); 
        } 
        function safariOptimize(obj){
            var Sys = {}; 
            var ua = navigator.userAgent.toLowerCase(); 
            var s;  
            (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0; 
            if (Sys.safari){ 
               obj.css({
                   float: "right",
                   background: "url('/image/xiaoxin/checkedIco.png') no-repeat center",
                   width: "20px",
                   height: "16px"
               });
            } 
        }
        
        function onClickHide(player){
            var typeV = $(player).data("viwe");
            if(typeV=="show"){
                $(player).css({position:"absolute",width:subR+"px"});
                $(player).animate({right:"-"+subR+"px"},100);
                $("#contentBox").css('margin-right','5px');
                $(player).data("viwe","hide");
                $("#player").removeClass('playerOn').addClass('playerOff');
            }else{ 
                $(player).css({position:""});
                $(player).animate({right:"15px"},0); 
                $(player).data("viwe","show");
                $("#contentBox").css('margin-right',(subR+20)+'px');
                $("#player").removeClass('playerOff').addClass('playerOn');
            }
        }
         

        var qqContact=function(){
            var qTit=$('#qqkf');
            qTit.hover(function() {
                 $(this).find('.qq-list').show();
            }, function() {
                $(this).find('.qq-list').hide();
            });
        }
        qqContact();
    </script>
    <?php Yii::app()->msg->printMsg();?>
</body>
</html>
