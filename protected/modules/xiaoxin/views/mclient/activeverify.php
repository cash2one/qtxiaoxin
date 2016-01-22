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
        .box{  padding: 20px 8px; overflow: hidden;}
        .formBox{ width: 100%;} 
        .formBox h1{ padding: 10px 0; }
        .formBox h2{font-size:20px; padding: 20px 0; text-align: left; font-weight: 100; }
        .error_info{display: inline;}
        .input{background: #FFFFFF; text-align: left; width: 98%; border: 1px solid #b2b2b2; font-size: 14px; margin-bottom: 15px; height: 40px; /*line-height: 40px;*/  }
        .input input{border: none; width: 98%; height: 40px;outline: none; font-size: 14px; padding-left:3px;}
        /* ------------- 身份选择------------------*/
        .statusBox{margin-bottom: 20px; position: relative; height: 38px; width: 100%;}
        .statusBox a{ display: block; color: #6E6E6E; text-decoration: none; position: relative; float: left; text-align: center; width: 49%; border: 1px solid #a6a6a6; height: 36px; margin: 0px;  line-height: 36px; font-size: 14px; }
        .statusBox a.status{ background: #169af5; border-color:#169af5; color: #FFFFFF;  }
        .statusBox a.status span{ margin-left: 30px; }
        .statusBox a.status em{float: left; top:-13px; left: 3px; width: 45px; height: 50px; position: absolute;   }
        .statusBox a.status em.teacher{background: url("/image/xiaoxin/login/statusIoc.png") no-repeat top;}
        .statusBox a.status em.parents{background: url("/image/xiaoxin/login/statusIoc.png") no-repeat bottom;}
        .statusBox a.last{ border-left: none;  }
        .errorMsg{ text-align: left;} 
        .errorCTip{text-align: left; }
        .statusBox a:hover{ text-decoration: none;  }
        .forgetpas .botton{ width: 98%; margin-top: 15px; }
        .forgetpas .botton .btn {width: 100%; display: inline-block; height: 40px; line-height: 40px; border: 0; border-radius: 3px; text-align: center; cursor: pointer;background-color: #24c1b1; color: #fff; font-family: "微软雅黑"; font-size: 16px;}
        /* 窗口宽度在640px以上, 999px以下 */
        @media screen and (max-width: 200px) {
             .statusBox a{width: 48%; } 
        }
        .linkBox{ vertical-align: middle; position: fixed; bottom: 15%; overflow: hidden; width: 100%;}
        .linkBox .applybg{ text-align: center; vertical-align: middle;  font-size: 16px; text-decoration: none; display: inline-block; color: #666666;  }
        .linkBox .applybg img{ vertical-align: middle;  display: inline; margin-right: 10px;}  
    </style>
    <meta content="校信,蜻蜓校信,校信通,校讯通,家校互动,家校通,家校沟通" name="Keywords">
    <title>蜻蜓校信—国内首款基于老师家长关系的社交应用  免费家校沟通平台</title>
</head>
<body style="  "> 
    <a href="javascript:void(0)" class="gotop" style="display: none;"></a>  
    <div class="box" style="padding: 20px 8px; overflow: hidden;">
        <!--start of login-->
        <div class="formBox" style="width: 100%; ">
             <!-- <h1 style=" text-align: left;">沟通<br/>是一种教育方式</h1>--> 
            <!-- form --> 
            <form id="formBoxRegister" action="<?php echo Yii::app()->createUrl('xiaoxin/mclient/activeverify');?>" method="post"> 
                <div id="ContentPlaceHolder1_panStep1" style=" height: 300px;">
                    <div class="forgetpas ">
                        <!-- <h2>验证邀请码 </h2>--> 
                        <div class="statusBox">
                            <a rel="selectStatus" href="javascript:void(0);" tip="0" class="status"><em class="teacher"></em><span>我是老师</span></a>
                            <!--<a rel="selectStatus" href="javascript:void(0);" tip="2" class="last  "><em class="parents"></em>我是学生</a>-->
                            <a rel="selectStatus" href="javascript:void(0);" tip="1" class="last"><em class="parents"></em><span>我是家长</span></a>
                            <input id="radioBoxValue" name="Activity[role]" type="hidden" value="0">
                        </div> 
                        <div class="input"> 
                            <input type="text" class="textInput" id="mobile"  placeholder="请输入邀请码"  name="Activity[code]" maxlength="15">
                        </div>
                        <div class="input"> 
                            <input type="password" id="code" maxlength="10"  placeholder="请输入邀请码密码" value="" name="Activity[password]" class="textInput">
                        </div>
                        <div  class="errorMsg errorCTip" style=" color: red;"></div>
                        <div class="botton">
                            <input type="button" id="btnCheckCode" value="提交验证" class="btn">
                        </div> 
                    </div> 
                </div>
                <div class="linkBox" style=" position: relative; margin: 0 auto; width: 100%; margin-top: 60px; text-align: center; overflow: hidden; ">
                    <a href="<?php echo Yii::app()->createUrl('xiaoxin/mclient/apply');?>" class="applybg"> 
                            <img  width="25px" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/appPhoneAiIoc.png">
                             我想试用 >
                    </a>
                </div>
            </div>
        </form>  
        <!-- </form> -->
        <!--end of login--> 
    </div>  
    <!--end of footer--> 
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/input.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/index.js"></script>
    <script type="text/javascript"> 
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
                    str = "系统繁忙,请稍后再试";
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
        function pstCode(){
            var eg =/^((1)+\d{10})$/;
            var code =$("#code").val();
            var mobile =$("#mobile").val();
            var role =$("#radioBoxValue").val();
            if(mobile==""){
                $('.errorCTip').text('邀请码不能为空！');
                return;
            }else{ 
                if(code==""){
                    $('.errorCTip').text('邀请码密码不能为空');
                    return;
                }else{
                    $('#formBoxRegister').submit();
                } 
            }
        }
        //提交 code 的enter
        $('#code,#mobile').keydown(function(){
            $('.errorCTip').text('');
            var event=arguments.callee.caller.arguments[0]||window.event;//消除浏览器差异  
            if (event.keyCode == 13){
                pstCode();
            }
        });
        //$("#mobile").keydown(function(){
            //$('.errorCTip').text('');
        //});
         
         
        //验证密码 
        function checkPassword(pwd) {
            // 长度为6到16个字符
            var reg = /^[a-zA-Z0-9].{6,16}$/;
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
           if(len<=9){ 
               return !(repeat || series);
             }else{ 
                 return (repeat || series); 
             }
        }
         function isPlaceholder(){
             var input = document.createElement('input');
             return 'placeholder' in input;
         }
        $(function(){
            if(!isPlaceholder()){
                if($("#mobile").val()=="" && $("#mobile").attr("placeholder")!=""){
                    $("#mobile").val($("#mobile").attr("placeholder"));
                }
                $("#mobile").focus(function(){
                    if($(this).val()==$(this).attr("placeholder")) $(this).val("");
                });
                $("#mobile").blur(function(){
                    if($(this).val()=="") $(this).val($(this).attr("placeholder"));
                });
            }
            $("#mobile").val('');
            $("#code").val('');

       })

    </script>
    <?php Yii::app()->msg->printMsg(); ?>
</body>
</html>