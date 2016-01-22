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
        /* ------------- 身份选择------------------*/
        .statusBox{ margin-bottom: 20px; position: relative; height: 38px; width: 100%;}
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
        .forgetpas .botton .btn {width: 100%; display: inline-block; height: 40px; line-height: 40px; border: 0; text-align: center; cursor: pointer;background-color: #24c1b1; color: #fff; font-family: "微软雅黑"; font-size: 16px;}
        /* 窗口宽度在640px以上, 999px以下 */
        @media screen and (max-width: 200px) {
             .statusBox a{width: 48%; } 
        }
        .linkBox{ vertical-align: middle; width: 100%;  }
        .linkBox .applybg{  text-align: center;  font-size: 16px; display: inline-block; text-decoration: none;  color: #666666; cursor: default; }
        .linkBox .applybg img{ vertical-align: bottom; display: inline; margin-right: 10px;}
         .linkBox .applybg a{ vertical-align: bottom; color: #666666; text-decoration: none;}
    </style>
    <meta content="校信,蜻蜓校信,校信通,校讯通,家校互动,家校通,家校沟通" name="Keywords">
    <title>蜻蜓校信—国内首款基于老师家长关系的社交应用  免费家校沟通平台</title>
</head>
<body>  
    <!--start of main1-->
   <div class="box" style=" margin: 0 auto; padding: 20px 8px; overflow: hidden;">
        <!--start of login-->
        <div class="formBox" style="width: 100%; min-height: 600px;">
            <!--<h1 style=" text-align: left;">沟通<br/>是一种教育方式</h1>-->
            <!-- form --> 
            <form id="formBoxRegister" action="" method="post">
                <div id="ContentPlaceHolder1_panStep1" style=" "> 
                    <div class="forgetpas ">
                        <!--<h2>激活用户 </h2>-->
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
                                    <input type="text" placeholder="<?php if($codeinfo->type==0):?>请输入姓名 <?php else:?>请输入学生姓名<?php endif; ?>" class="textInput " id="sname" name="Activeuser[name]" maxlength="10">
                                <?php endif; ?> 
                            </div>
                            <?php if($codeinfo->type==0):?>
                            <?php else:?>
                                <div class="input"> 
                                    <input type="text" class="textInput" placeholder="请输入学生学号（非必填）" maxlength="20" id="studentid" name="Activeuser[studentid]" maxlength="10">
                                </div>
                            <?php endif; ?> 
                            <div class="input"> 
                                <input type="text" placeholder="请输入手机号（用作登录帐号）" name="Activeuser[mobilephone]" value="" id="spmobile" maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" class="textInput">
                            </div>
                            <div class="input"> 
                                <input type="password" placeholder="请设置登录密码" maxlength="16" name="Activeuser[password]" id="sppwd" value="" class="textInput">
                            </div>
                            <div class="input"> 
                                <input type="password" placeholder="确认登录密码"  name="Activeuser[password2]"   id="sppwdr" class="textInput">
                            </div>
                            <div  class="errorMsg errorCTip" style=" color: red;"></div>
                            <div class="botton">
                                <input type="button" id="btnCheckCode" value="激 活" class="btn">
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div>
        </form> 
        <div class="linkBox" style="margin: 0 auto; width: 100%; margin-top: 60px; text-align: center; ">
            <div class="applybg">
                 <img width="25px" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/appPhoneTelIoc.png"> 
                <a href="tel://4001013838"> 400 101 3838 </a> 
            </div>
        </div>
        <!-- </form> -->
        <!--end of login--> 
    </div> 
    <!--end of main1--> 
     <!--start of footer-->
      
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