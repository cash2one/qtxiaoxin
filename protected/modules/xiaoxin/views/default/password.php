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
            <div class="box" style="padding: 15px 0;">
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
                        <li><a href="/xiaoxin/default/password" class="focus">修改密码</a></li>
                        <li><a href="/xiaoxin/default/mobile">手机绑定</a></li>
                    </ul>
                </div>  
            </div>
            <div class="formBox">
                <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'formBoxRegister',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
        )); ?>
                <!-- <form id="formBoxRegister" class="formBoxRegister" action="" method="post"> -->
                    <table class="tableForm">
                        <tbody>
                        <tr>
                            <td><div class="title">修改密码</div></td>
                        </tr> 
                        <tr>
                            <td>
                                <span class="inputTitle">原始密码：</span>
                                <div class="inputBox"><input id="oldPwd" class="mediumL" type="password" name="UChangePasswordForm[currentPassword]" datatype="*" nullmsg="请输入当前密码！" errormsg="请输入当前密码"></div>
                                <span class="ValidformTip Validform_checktip" ></span>
                                <span class="errorTip errorTipOldPwd" style=" display: none;" ></span> 
                                <div class="info" style="display: none;">请输入当前密码<span class="dec"><s class="dec1">◆</s><s class="dec2">◆</s></span></div>
                                <div class="infoTip   " style="display: inline-block;"><?php echo $form->error($model,'currentPassword', array('style'=>'display: inline;color: red;','rel'=>'currentPassword')); ?> </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="inputTitle">&nbsp;新 密 码：</span>
                                <div class="inputBox"><input id="Pwd" maxlength="16" class="mediumL" type="password" name="UChangePasswordForm[newPassword]" datatype="*6-16,pwd6-16"   nullmsg="请输入新密码！" errormsg="密码由6-16位不同数字和字母组合！"></div>
                                <span class="ValidformTip Validform_checktip" ></span>
                                <span class="errorTip errorTipPwd" style=" display: none;"></span> 
                                <div class="info" style="display: none;">密码由6-16位不同数字和字母组合！<span class="dec"><s class="dec1">◆</s><s class="dec2">◆</s></span></div>
                                <?php echo $form->error($model,'newPassword'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="inputTitle">确认密码：</span>
                                <div class="inputBox"><input id="newPwd" maxlength="20" class="mediumL" type="password" name="UChangePasswordForm[newPassword_repeat]" datatype="*" recheck="UChangePasswordForm[newPassword]" nullmsg="请再次输入您的密码！" errormsg="您两次输入的账号密码不一致！"></div>
                                <span class="ValidformTip Validform_checktip" ></span>
                                <span class="errorTip errorTipNewPwd" style=" display: none;" ></span> 
                                <div class="info" style="display: none;">请再次输入您的密码<span class="dec"><s class="dec1">◆</s><s class="dec2">◆</s></span></div>
                                <?php echo $form->error($model,'newPassword_repeat'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td> 
                                <span class="inputTitle" style="margin-left: 69px;"></span>
                                <!--<input type="submit" class="btn btn-raed"  value="确认修改">-->
                                <a id="btnEditPwd" href="javascript:void(0);" class="btn btn-raed">确认修改</a>
                            </td> 
                        </tr>
                        </tbody>
                    </table>  
                <!-- </form> -->
                 <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div> 
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
   //表单验证控件
    Validform.int("#formBoxRegister");
    $('input[type=password]').focus(function(){
        $('.infoTip').hide();
        $('.errorTip').removeClass('Validform_wrong').hide(); 
    });
    //修改密码
    $('#btnEditPwd').click(function(){ 
       $('#formBoxRegister').submit();
    });
   //修改密码enter
    $('#newPwd').keydown(function(){
       var event=arguments.callee.caller.arguments[0]||window.event;//消除浏览器差异  
       if (event.keyCode == 13){
           //setPwds(); 
           $('#formBoxRegister').submit();
       }
    });
//    function setPwds(){
//        var oldpwd =$.trim($('#oldPwd').val());
//        var pwd =  $.trim($('#Pwd').val());
//        var newpwd = $.trim($('#newPwd').val());
//        $('.ValidformTip').hide();
//        var f = checkPassword(pwd); 
//        if(oldpwd!=""){ 
//            if(pwd!=""){ 
//               if(pwd.length>16||pwd.length<6){ 
//                    $(".errorTipPwd").text("密码由6-16位不同数字和字母组合！").addClass('Validform_wrong').show();
//                    return;
//                }else{
//                    if(pwd!=newpwd){ 
//                        $('#newPwd').val('');
//                        $('.errorTipNewPwd').text('两次输入密码不一致！').addClass('Validform_wrong').show(); 
//                        return;
//                    }else{
//                        if(!f){ 
//                            $(".errorTipPwd").text("密码由6-16位不同数字和字母组合！").addClass('Validform_wrong').show();
//                            $('#newPwd').val('');
//                            $('#Pwd').val('');
//                            return;
//                        }else{
//                            //$('#formBoxRegister').submit();
//                           
//                        } 
//                    } 
//                } 
//            }else if(pwd==""){
//                $('.errorTipPwd').text('请输入新密码！').addClass('Validform_wrong').show();  
//            }
//        }else{
//            $('.errorTipOldPwd').text('请输入旧密码！').addClass('Validform_wrong').show();
//        }
//        
//    }
//    //验证密码 
//    function checkPassword(pwd) {
//        // 长度为6到16个字符
//         var reg = /^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;
//            //alert(reg.test(pwd));
//            var len = pwd.length;
//            if(len>=6&&len<=16){
//                if (!reg.test(pwd)) {
//                    return false;
//                }else{
//                    return true;
//                }  
//            }else{
//               return false; 
//            }
//           
////        var reg = /^[a-zA-Z0-9].{6,16}$/;
////        if (!reg.test(pwd)) {
////            return false;
////        }
////        // 全部重复
////        var repeat = true;
////        // 连续字符
////        var series = true; 
////        var len = pwd.length;
////        var first = pwd.charAt(0);
////        for (var i = 1; i < len; i++) {
////            repeat = repeat && pwd.charAt(i) == first;
////            series = series && pwd.charCodeAt(i) == pwd.charCodeAt(i - 1) + 1;
////        }
////        if(pwd<=9){  
////           return (repeat || series);
////        }else{ 
////           return !(repeat || series); 
////        }
//        
//    }
});
</script>