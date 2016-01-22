<div class="header"> 
<div class="titleText"><em></em>账号设置</div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 20px 0;">
                点亮徽标,可以将功能添加到快捷功能列表中，方便您的使用.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox account">
        <div class="box">
            <div class="headBox ">
                <div class="headNav">
                    <ul>
                        <li><a href="/xiaoxin/default/account">基本信息</a></li>
                        <li><a href="/xiaoxin/default/password" >修改密码</a></li>
                        <li><a href="/xiaoxin/default/mobile" class="focus">手机绑定</a></li>
                    </ul>
                </div>  
            </div>
            <div class="formBox">
                <form id="formBoxRegister" action="" method="post">
                    <table id="verifyMobileF" class="tableForm">
                        <tbody>
                        <tr>
                            <td><div class="title">第一步：验证当前手机</div></td>
                        </tr> 
                        <tr>
                            <td>
                                <span class="inputTitle">当前手机：</span>
                                <div class="inputBox">
                                    <input id="passwordF" rel="mobile" class="mediumL" type="text" name="password" datatype="*s6-18" nullmsg="请输入当前手机号！" maxlength="11" errormsg="请输入正确的手机号！" placeholder="请输入当前手机号"/>
                                    <a href="<?php echo Yii::app()->createUrl('xiaoxin/default/findmobile');?>" class="messageLink">号码丢失</a>
                                </div>
                                <span class="tipB Validform_checktip " ></span> 
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <span class="inputTitle">短信验证：</span>
                                <div class="inputBox">
                                    <input class="mediumL" rel="code" id="verifyCode" type="text" name="userpassword" placeholder="请输入验证码"    nullmsg=" 验证码不能为空！" errormsg=""/>
                                    <a rel="postVerifyCode" tid="0" class="btn btn-default" href="javascript:void(0);" >发送验证短信</a>
                                </div>
                                <span class="tipB Validform_checktip" ></span> 
                                <span id="verifyCodeTip" style="display: none;" class="Validform_checktip Validform_wrong" >验证码不正确！</span>
                                <div style="padding-left: 75px; margin-top: 5px; color: #999999;">验证码30分钟内有效</div>
                            </td>
                        </tr>
                        <tr>
                            <td> 
                                <span class="inputTitle" style="margin-left: 69px;"></span>
                                <!--<input id="userVerifyCode" type="hidden" value="">--> 
                                <a rel="nextRevamp" href="javascript:void(0);" class="btn btn-raed">下一步</a>
                            </td> 
                        </tr> 
                        </tbody>
                    </table>
                    
                    <table id="verifyMobileN" class="tableForm" style="display: none;">
                        <tbody>
                        <tr>
                            <td><div class="title">第二步：验证新号码</div></td>
                        </tr> 
                        <tr>
                            <td>
                                <span class="inputTitle">&nbsp;新 手 机：</span>
                                <div class="inputBox">
                                    <input rel="mobile" id="AccountF" class="mediumL" type="text" maxlength="11" placeholder="请输入新手机号" name="Account[mobile]" datatype="*" recheck="userpassword" nullmsg="请输入新手机号！" errormsg="请输入正确的手机号！"/>
                                </div>
                                <span class="Validform_checktip tipN"></span> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="inputTitle">短信验证：</span>
                                <div class="inputBox">
                                    <input id="verifyCodeN" rel="code" class="mediumL" type="text" name="userpassword" placeholder="请输入验证码" datatype="*n6-18"   nullmsg="请输入验证码！" errormsg="验证码不正确！"/>
                                    <a rel="postVerifyCodeN" tid="0" class="btn btn-default" href="javascript:void(0);">发送验证短信</a>
                                </div>
                                <span class="Validform_checktip tipN"></span>
                                <span id="verifyCodeTipN" style="display: none;" class="Validform_checktip Validform_wrong" >验证码不正确！</span>
                                <div style="padding-left: 75px; margin-top: 5px; color: #999999;">验证码30分钟内有效</div>
                            </td>
                        </tr>
                        <tr>
                            <td> 
                                <span class="inputTitle" style="margin-left: 65px;"></span>
                                <input id="userVerifyCodeN" type="hidden" value="">
                                <a rel="revampOK" tid="0" href="javascript:void(0);" class="btn btn-raed">完 &nbsp; 成</a>
                            </td> 
                        </tr>
                        </tbody>
                    </table>  
                </form>
            </div>
        </div>
    </div>
</div> 
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/placeholders.js" type="text/javascript"></script>
<script type="text/javascript"> 
//ty:(new,old),mobile: 
//ty:(new,old),mobile:,code:
$(function() { 
    //表单验证控件
    //Validform.int("#formBoxRegister");
    //inoput 表单placeholder 提醒
    placeholders.int('formBoxRegister',true);
    //发请求获取验证码
    function ajaxPost(url,ty,mobile,code){
        var str ="";
        $.ajax({  
            url:url,   
            type : 'POST',
            data : {ty:ty,mobile:mobile,code:code},
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {
                str = mydata; 
            },  
            error : function() {  
                // alert("calc failed");  
                str = "系统繁忙,请稍后再试";
            }  
        });
        return str;
    }
    $('input[rel=mobile],input[rel=code]').live('focus',function(e){
        $('#verifyCodeTip').hide();
        $('#verifyCodeTipN').hide();
    });
    $('input[rel=mobile]').live('focusout',function(e){
         var rel = $(this).val();
         //var eg =/^(((13[0-9]{1})|159|153|156|186|(18[0-9]{1}))+\d{8})$/;
         var eg = /^((1)+\d{10})$/; 
         if(rel==""){
            $(this).parents('td').find('.tipB').addClass('Validform_wrong').text('电话号码不能为空！');
         }else if(eg.test(rel)&&rel.length==11){
             $(this).parents('td').find('.tipB').removeClass('Validform_wrong').text('') ; 
         }else{
            $(this).parents('td').find('.tipB').addClass('Validform_wrong').text('电话号码格式不正确'); 
         } 
    });
    //计时器
    var countdown = 60;
    var off =true;
    function settime(val) { 
        if(!off){
          return;
        }
        if (countdown == 0) {  
            //val.removeAttribute("disabled");
            val.css({background:'#ffffff',color:"#333333"});  
            val.text("免费获取验证码"); 
            countdown = 60; 
            return;
        } else { 
            val.css({background:'#cccccc',color:"#ffffff",cursor: "default",borderColor:'#adadad'}); 
            //val.setAttribute("disabled", true); 
            val.text("（" + countdown + "）后再次获取验证码"); 
            countdown--; 
        } 
        setTimeout(function() { 
            settime(val);
        },1000); 
    } 
   //旧手机发送验证码请求
   $('[rel=postVerifyCode]').click(function(){ 
        if(parseInt(countdown)==60){ 
            var sendurl = "<?php echo Yii::app()->createUrl('xiaoxin/default/sendcode');?>";
            var eg =/^((1)+\d{10})$/;
            var mobile =$('#passwordF').val();
            if(mobile==""){
                $('#verifyCodeTip').text('电话号码不能为空！').show(); 
            }else if(eg.test(mobile)&&mobile.length==11){
                
                $('#verifyCodeTip').text('').hide(); 
                var code = ajaxPost(sendurl,'old',mobile,''); 
                if(code=='success'){
                    settime($(this));
                }else{
                    $('.tipB').hide();
                    $('#verifyCodeTip').text(code+'！').show(); 
                }  
            }else{
                $('.tipB').hide();
                $('#verifyCodeTip').text('电话号码格式不正确！').show(); 
            }
        }else{ 
        }   
    });
    
    //下一步
    $('[rel=nextRevamp]').click(function(){ 
        var checkurl = "<?php echo Yii::app()->createUrl('xiaoxin/default/checkcode');?>";
        var mobile =$('#passwordF').val();
        var verifyCode = $('#verifyCode').val();
        if(mobile!=""){ 
            //alert(ajaxPost(checkurl,'old',mobile,verifyCode));
            var eg =/^((1)+\d{10})$/; 
            if(eg.test(mobile)&&mobile.length==11){ 
                if(verifyCode!=""){
                    var codeS = ajaxPost(checkurl,'old',mobile,verifyCode) ;
                    if(codeS=='success'){
                        off=false;
                        countdown = 60; 
                        $('#verifyMobileF').hide();
                        $('#verifyMobileN').show(); 
                        $('#verifyCodeTip').hide();
                    }else{  
                        $('#verifyCodeTip').text(codeS).show(); 
                    }
                }else{
                     $('#verifyCodeTip').text('请输入验证码验证！').show();
                } 
            }else{ 
                $('#verifyCodeTip').text("电话号码格式不正确!").show(); 
            }
            $('.tipB').hide();
        }else{
            $('#verifyCodeTip').text('请输入手机号获取验证码！').show(); 
        } 
    });
    
   //新手机发送验证码请求
   $('[rel=postVerifyCodeN]').click(function(){  
        if(parseInt(countdown)==60){
            off =true;
            var sendurl = "<?php echo Yii::app()->createUrl('xiaoxin/default/sendcode');?>";
            var eg =/^((1)+\d{10})$/;
            var mobile =$('#AccountF').val();
            if(mobile==""){
                $('#verifyCodeTipN').text('电话号码不能为空！').show();  
             }else if(eg.test(mobile)&&mobile.length==11){ 
                $('#verifyCodeTipN').text('').hide(); 
                var code = ajaxPost(sendurl,'new',mobile,''); 
                if(code=='success'){  
                    settime($(this));
                }else{
                    $('#verifyCodeTipN').text(code+'！').show(); 
                }
             }else{
                $('.tipN').hide();
                $('#verifyCodeTipN').text('电话号码格式不正确！').show(); 
             }
        } 
   });
   $('[rel=revampOK]').click(function(){
        var tid = $(this).attr('tid');
        var checkurl = "<?php echo Yii::app()->createUrl('xiaoxin/default/checkcode');?>";
        var verifyCodeN = $('#verifyCodeN').val();
        var mobile = $('#AccountF').val();
        if(mobile==""){
            $('#verifyCodeTipN').text('请输入手机号发送验证码验证！').show();
            $('.tipN').hide();
        }else{
            var eg =/^((1)+\d{10})$/;
            if(eg.test(mobile)&&mobile.length==11){ 
                if(verifyCodeN!=""){
                    var codeS = ajaxPost(checkurl,'new',mobile,verifyCodeN) ; 
                    if(codeS=='success'){  
                       $('#verifyCodeTip').hide();
                       if(parseInt(tid)==0){
                           $(this).attr('tid',1);
                           $('#formBoxRegister').submit();
                       }
                    }else{ 
                        $('#verifyCodeTipN').text(codeS).show(); 
                    }
                }else{
                    $('#verifyCodeTipN').text('请输入验证码验证！').show();
                }
            }else{ 
                $('#verifyCodeTipN').text("电话号码格式不正确！").show(); 
            }
            $('.tipN').hide();
        } 
   });
});
</script> 