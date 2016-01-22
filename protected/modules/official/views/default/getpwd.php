<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>重置密码</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/official/base.css">
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/official/ui.css">
	    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/official/login.css">
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/jquery.js"></script>
	    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/login.js"></script>

		<!-- html5.js for IE less than 9 -->
		<!--[if lt IE 9]>
			<script src="js/html5.js"></script>
			
		<![endif]-->
	
		<!-- css3-mediaqueries.js for IE less than 9 -->
		<!--[if lt IE 9]>
			<script src="js/css3-mediaqueries.js"></script>
		<![endif]-->

		<!-- IE8以下的浏览器提示更新 -->
	    <!--[if lt IE 8]>
		    <div id="ie6-warning">您正在使用 Internet Explorer 8以下的浏览器，在本页面的显示效果可能有差异。建议您升级到 <a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank">Internet Explorer 8、9、10、11</a> 或以下浏览器： <a href="http://www.mozillaonline.com/" target="_blank">Firefox</a> / <a href="http://www.google.com/chrome/?hl=zh-CN">Chrome</a> / <a href="http://www.apple.com.cn/safari/" target="_blank">Safari</a> / <a href="http://www.operachina.com/" target="_blank">Opera</a>
		    </div>
	    <![endif]-->
	</head>
	<body>
		<div class="header-config" >
			<div class="header">
				<div class="logo">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/login/logo.png" alt=""><span>——公众号管理平台</span>
				</div>
				<div class="login-status">
					<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/login/tel.png" alt="">
				</div>
			</div>
		</div>
		<div class="container">
			 <div class="content">
			 	 <div class="tip">
			 	 	<h1>蜻蜓校信公众平台</h1>
			 	 	<p>帮助机构建立老师、学校、家长间的桥梁</p>
			 	 </div>
			 	 <form class="form-horizontal" method="post" id="formBoxRegister" action="<?php echo Yii::app()->createUrl('official/default/password');?>">
				 	 <div class="login find-pass" id="ContentPlaceHolder1_panStep1">
			 	    	<div class="tit">找回密码</div>
						  <div class="control-group">
						    <div class="controls">
						      <div class="user">
						      	<span>手机号</span>
						      	<input type="text"  id="mobile" placeholder="请输入手机号码" class="input-large " maxlength="11" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
						      	<a  id="btnGetVerifyCode" class="btn getpass" href="javascript:;">获取验证码</a>

						      </div>
						      <div class="getpass-tip">验证码30分钟内有效</div>
						    </div>
						  </div>
						  <div class="control-group">
						    <div class="controls">
						      <div class="pass">
							      <span>验证码</span>
							      <input type="text" placeholder="请输入验证码" class="input-large"  id="code">
						      </div>
						    </div>
						  </div>
						  <div class="control-group" style="margin:0;">
						    <div class="controls error" ></div>
						  </div>
						  <div class="control-group forget">
						    <div class="controls" >
						     	<a href="javascript:;" class="btn btn-warning login-btn" id="btnCheckCode">提交验证码</a>
						    </div>
						  </div>

						  <div class="control-group " >
						    <div class="controls" style="text-align:right;">
						     	<a href="<?php echo Yii::app()->createUrl('official/default/login');?>" class="return-login" >登录</a>
						    </div>
						  </div>
				 	 </div>
				 	  <div class="login find-pass" id="ContentPlaceHolder1_panStep2" style="display:none;">
				 	    	  <div class="tit">重置密码</div>
							  <div class="control-group">
							    <div class="controls">
							      <div class="user">
							      	<span>请输入新密码</span>
							      	<input type="password"  id="pwd" name="newPwd" placeholder="请输入新密码" maxlength="16" class="input-large ">
							      </div>
							    </div>
							  </div>
							  <div class="control-group">
							    <div class="controls">
							      <div class="pass">
								      <span>确认新密码</span>
								      <input type="password" placeholder="确认新密码" name="newPwdRepeat" id="newpwd" maxlength="16" class="input-large"  >
							      </div>
							      <div style="margin-top:10px;">密码由6-16位不同数字和字母组合</div>
							    </div>
							  </div>
							  <div class="control-group" style="margin:0;">
							    <div class="controls error" ></div>
							  </div>
							  <div class="control-group forget">
							    <div class="controls" >
							    	<input id="userId" name="User[uid]" type="hidden" name="" value="">
							     	<a href="javascript:;" class="btn btn-warning login-btn" id="btnEditPwd">修改密码</a>
							    </div>
							  </div>
				 	 </div>
				 </form>
			</div>	
		</div>
		<div class="footer">
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/login/logo1.png" alt="" class="foot-logo">
			<a href="http://www.qthd.com/">蜻蜓互动</a>
			<a href="http://www.qtxiaoxin.com">关于蜻蜓校信</a>
			<a href="http://www.qthd.com/contact.aspx">联系我们</a>
			<a href="http://www.miibeian.gov.cn/state/outPortal/loginPortal.action" >|&nbsp;&nbsp;深圳蜻蜓互动科技有限公司 粤ICP备14076064号-3</a>
		</div>

		<script>
		    var getPass=function(){
		    	var urls ="<?php echo Yii::app()->createUrl('official/default/setcode');?>";
		    	var urlcheck ="<?php echo Yii::app()->createUrl('official/default/getpwd');?>";
		    	var off =true,
		    		countdown = 60;

		    	 //获取验证码
		        $('#btnGetVerifyCode').click(function(){ 
		        	var _left=$(this);
		            var mobile =$("#mobile").val();
		            var eg =/^((1)+\d{10})$/;
		            if(countdown == 60){
		                if(mobile!=""){
		                    if(eg.test(mobile)){ 
		                        var str =ajaxPost(urls,mobile,'');
		                        if(str.state=="success"){
		                           _left.css({background:'#cccccc',color:"#999999"});
		                           settime(_left); 
		                        }else{
		                          $('.error').text(str.msg);  
		                        }
		                    }else{
		                        $('.error').text('请输入正确的手机号码');
		                    } 
		                }else{
		                  $('.error').text('手机号不能为空');  
		                }
		            } 
		        });
 				$("#btnCheckCode").click(function(){  
 					
			          pstCode(); 
			    });
			    $("#mobile").keydown(function(){
		            $('.error').text('');
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
		        //提交 code 的enter
		        $('#code').keydown(function(){
		            $('.error').text('');
		            var event=arguments.callee.caller.arguments[0]||window.event;//消除浏览器差异  
		            if (event.keyCode == 13){
		                pstCode();
		            }
		        });
				function settime(val) { 
		            if(!off){
		              return;
		            }
		            if (countdown == 0) {  
		                //val.removeAttribute("disabled");	
		                val.text("获取验证码"); 
		                //val.value="免费获取验证码"; 
		                val.css({background:'#00ABA9',color:"#fff"});
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
		        
		        function pstCode(){
		            var eg =/^((1)+\d{10})$/;
		            var code =$("#code").val();
		            var mobile =$("#mobile").val();
		            if(mobile==""){
		                $('.error').text('手机号不能为空');

		                return false;
		            }else{
		                if(eg.test(mobile)){
		                    if(code==""){
		                        $('.error').text('验证码不能为空');
		                        return;
		                    }else{
		                        var str =ajaxPost(urlcheck,mobile,code);
		                        // var dataObj=eval( "("+ str +")" );
		                        if(str.state=="success"){
		                            $("#ContentPlaceHolder1_panStep1").hide();
		                        	$("#ContentPlaceHolder1_panStep2").show();
		                            $("#userId").val(str.msg);
		                        }else{
		                            $('.error').text(str.msg);
		                        } 
		                    }
		                }else{
		                    $('.error').text('您输入的手机号码格式不正确');
		                }
		                 
		            }
		        }
		        function setPwds(){
		            var pwd =  $.trim($('#pwd').val());
		            var newpwd = $.trim($('#newpwd').val());
		            var f = checkPassword(pwd); 
		            if(pwd!=""){
		                if(pwd.length>16||pwd.length<6){ 
		                    $('.error').text('密码由6-16位不同数字和字母组合').css("color",'red'); 
		                }else{
		                    if(pwd!=newpwd){
		                        $('#newpwd').val('');
		                        $('.error').text('两次输入密码不一致').css("color",'red'); 
		                    }else{
		                        if(!f){
		                                $(".error").text("密码由6-16位不同数字和字母组合").css("color",'red'); 
		                         }else{
		                                $('#formBoxRegister').submit();
		                        } 
		                    } 
		                } 
		             }else if(pwd==""||newpwd==""){
		                 $('.error').text('请输入密码').css("color",'red'); 
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
		        }
		         function ajaxPost(url,mobile,code){
		            var str ="";
		            $.ajax({  
		                url:url,   
		                type : 'POST',
		                data : {ty:'pwd',mobile:mobile,code:code},
		                dataType : 'JSON',  
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
		    }
			$(function(){
				getPass();
			})
		</script>
        <?php Yii::app()->msg->printMsg();?>
	</body>
</html>
