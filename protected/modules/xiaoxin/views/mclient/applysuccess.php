 <?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0,width=device-width,user-scalable=no">  
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta content="yes" name="apple-mobile-web-app-capable" /> 
    <meta content="black" name="apple-mobile-web-app-status-bar-style" /> 
    <meta content="telephone=no" name="format-detection" />
    <meta name="renderer" content="webkit|ie-comp"> 
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/jquery-1.7.2.min.js" type="text/javascript"></script>
    <style>
        body,p,input,h1,h2,h3,h4,h5,h6,ul,li,dl,dt,dd,form{margin:0;padding:0;list-style:none;vertical-align:middle}body{background-color:#f9f8f8;font-family: "\5FAE\8F6F\96C5\9ED1","微软雅黑",helvetica,arial;color:#000;-webkit-user-select:none;-webkit-text-size-adjust:none;font-size:17px}header,section,footer,img{display:block;margin:0;padding:0}img{border:0}
        img {border:none;line-height:0;} 
        a img{border-width:0;vertical-align:middle}
        .box{margin: 0 auto; padding: 20px 8px; overflow: hidden;}
        .formBox{ width: 100%; text-align: left;} 
         /* 窗口宽度在640px以上, 999px以下 */
        @media screen and (max-width: 200px) {
             .statusBox a{width: 48%; } 
        }
        .linkBox{ vertical-align: middle; }
        .linkBox .applybg{ font-size: 16px; text-decoration: none; display: inline-block;  color: #24c1b1; cursor: default; }
        .linkBox .applybg img{ vertical-align: bottom; display: inline; margin-right: 10px;}
        .linkBox .applybg a{ vertical-align: bottom;  color: #24c1b1; text-decoration: none;}
        
    </style>
    <meta content="校信,蜻蜓校信,校信通,校讯通,家校互动,家校通,家校沟通" name="Keywords">
    <title>蜻蜓校信—国内首款基于老师家长关系的社交应用  免费家校沟通平台</title>
</head>
<body>  
    <!--start of main1-->
   <div class="box" style=" margin: 0 auto; padding: 20px 8px; overflow: hidden;">
        <!--start of login-->
        <div class="formBox" style="width: 100%; ">
            <div style="text-align: center; margin: 0 auto;">
                <?php if($success):?>
                <div style="width: 160px; margin: 20px auto; text-align: center;"><img style="text-align: center; margin: 0 auto;" width="50%" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/appPhoneBg.png"></div>
                <div style=" margin-top: 30px; font-size: 21px; color: #333333;">资料提交成功</div> 
                <div style=" margin-top: 30px; font-size: 16px; color: #999999; line-height: 30px;">
                    感谢您对蜻蜓班班的关注。<br> 您的资料已收到，<br> 我们会尽快安排试用帐号，并与您联系。
                </div>
                <?php else:?>
                  <div style="width: 160px; margin: 20px auto;"><img style="text-align: center; margin: 0 auto;" width="50%" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/appPhoneBgError.png"></div>
               
                <div style=" margin-top: 30px; font-size: 21px; color: #333333;">资料提交失败</div> 
                <div style=" margin-top: 30px; font-size: 16px; color: #999999; line-height: 30px;">
                    请检测您的网络是否通畅后，重新申请。<br>或直接拨打我们的热线申请。
                </div>
                <div class="linkBox" style="margin: 0 auto; width: 100%; margin-top: 60px; text-align: center;">
                    <div class="applybg">
                         <img  width="25px" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/appPhoneTelIoc.png">
                         <a href="tel://4001013838"> 400 101 3838 </a> 
                    </div>
                </div>
                <?php endif;?>
            </div> 
        </div>
   </div>
</body>
</html>