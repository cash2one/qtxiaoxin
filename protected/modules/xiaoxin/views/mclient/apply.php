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
        .formBox h1{ padding: 10px 0; }
        .formBox h2{ padding: 20px 0; text-align: left; font-weight: 100; }
        .error_info{display: inline;}
        .input{ background: #fff; text-align: left; width: 98%; border: 1px solid #b2b2b2; font-size: 14px; margin-bottom: 15px; height: 40px; /*line-height: 40px;*/  }
        .input input{border: none; width: 98%; height: 40px;outline: none; font-size: 14px; padding-left:2px;}
        .statusBox a:hover{ text-decoration: none;  }
        .forgetpas .botton{ width: 98%; margin-top: 15px; }
        .forgetpas .botton .btn {width: 100%; display: inline-block; height: 40px; border-radius: 3px;  line-height: 40px; border: 0; text-align: center; cursor: pointer;background-color: #24c1b1; color: #fff; font-family: "微软雅黑"; font-size: 16px;}
        /* 窗口宽度在640px以上, 999px以下 */
        @media screen and (max-width: 200px) {
             .statusBox a{width: 48%; } 
        }
        .linkBox{ vertical-align: middle; width: 100%; }
        .linkBox .applybg{ text-align: center;  font-size: 16px;  display: inline-block; color: #666666;  }
        .linkBox .applybg img{vertical-align: bottom; display: inline; margin-right: 10px;} 
        .linkBox .applybg a{ vertical-align: bottom; color: #666666; text-decoration: none;}
    </style>
    <meta content="校信,蜻蜓校信,校信通,校讯通,家校互动,家校通,家校沟通" name="Keywords">
    <title>蜻蜓校信—国内首款基于老师家长关系的社交应用  免费家校沟通平台</title>
</head>
<body>  
    <!--start of main1-->
   <div class="box" style=" margin: 0 auto; padding: 20px 8px; overflow: hidden;">
        <!--start of login-->
        <div class="formBox" style="width: 100%; ">
            <form id='formBoxGrade' method="post" action="">
                <div id="ContentPlaceHolder1_panStep1" style=" "> 
                    <div class="forgetpas ">
                        <div class="input"> 
                            <input type="text" placeholder="请输入您的学校名称" name="ApplyTry[schoolname]" value="" id="sschoolname" class="textInput">
                        </div>
                        <div class="input"> 
                            <input type="text" placeholder="请输入您的姓名" name="ApplyTry[personname]" value="" id="spersonname"   class="textInput">
                        </div>
                        <div class="input"> 
                            <input type="text" placeholder="请输入您的职位" name="ApplyTry[job]" value="" id="sjob"  class="textInput">
                        </div>
                        <div class="input"> 
                            <input type="text" placeholder="请输入您的联系方式" name="ApplyTry[mobile]" value="" id="spmobile" maxlength="11"   class="textInput">
                        </div>
                        <div  class="errorMsg errorCTip" style=" color: red;"></div>
                        <div class="botton">
                            <input type="button" id="btnCheckCode" value="提交申请" class="btn">
                        </div>
                    </div>
                </div>
            </form>
            <div class="linkBox" style="margin: 0 auto; width: 100%; margin-top: 30px; text-align: center; ">
                <div class="applybg">
                    <img  width="25px" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/appPhoneTelIoc.png"> 
                    <a href="tel://4001013838"> 400 101 3838 </a>
                </div>
            </div>
        </div>
   </div>
     <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/input.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/index.js"></script>
    <script type="text/javascript">
        $(function(){
            
            $('#btnCheckCode').click(function(){ 
                var k='0';
                var box =$('#ContentPlaceHolder1_panStep1');
                box.find('input[type=text]').each(function(i,v){
                    var value= $(this).val();
                    if(value==""){
                       $(".errorCTip").text($(this).attr('placeholder')).show();
                       k++;
                       return false;
                    }else{
                        $(".errorCTip").hide();
                    }
                }); 
                if(k=='0'){
                    $("#formBoxGrade").submit();
                }
            });
            
        });
    </script>
</body>
</html>