<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit|ie-comp">
     <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/jquery-1.7.2.min.js" type="text/javascript"></script>
     <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/searchSignStyle.css">
    <style>

    </style>
</head> 
<body>
    <div class="layout_div" style=" width: 680px;"> 
    <div class="layout_main" style="margin-top: 20%;  width: 680px;" >
        <div class="logo">
            <a href=""> <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/re-logo.png"></a>
        </div>
        <div class="layout_conrent">
            <div class="fromBox" style=" width: auto; padding: 20px;">
                <form  id="postFrom" action="" method="post">
                    <div class="title">修改绑定信息</div>
                    <table class="tableform" style="width: 100%;">
                        <tr>
                            <td width="50%"><span class="lable">学校：</span><?php echo ($class&&$class->s)?$class->s->name:'';?></td>
                            <td width="50%"><span class="lable">学生：</span><?php echo ($userinfo)?$userinfo->name:'';?>
                                <input type="hidden" value="<?php echo ($class)?$class->cid:'0';?>" name="cid"/>
                                <input type="hidden" value="<?php echo ($userinfo)?$userinfo->userid:'0';?>" name="userid"/>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="lable">班级：</span><?php echo ($class)?$class->name:'';?></td>
                            <td><span class="lable">学号：</span><?php echo ($ext)?$ext->studentid:'';?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><div style="border-bottom: 1px dashed #f1f1f1; margin-bottom: 15px; width: 100%">&nbsp;</div></td> 
                        </tr>
                        <?php if(count($guardians)):?>
                        <?php foreach($guardians as $k=>$val):?>
                        <tr>
                            <td colspan="2">
                                <div id="inputBox_<?php echo $val['userid'];?>" class="inputBox">
                                    <span class="lable"><i class="serialIco"><?php echo $k+1;?></i>已绑定帐号：</span>
                                    <input rel="accountInput" autocomplete="off" minlength="6" maxlength="12" type="text" usid="<?php echo $val['userid'];?>" dataval="<?php echo $val['account'];?>"  value="<?php echo $val['account'];?>" name="data[<?php echo $k;?>][account]">
                                    <input rel="accountInputId" type="hidden" value="<?php echo $val['userid'];?>" name="data[<?php echo $k;?>][userid]">
                                    <span class="lable">注册手机：</span>
                                    <input rel="mobilePhoneInput" type="text" maxlength="11" autocomplete="off" usid="<?php echo $val['userid'];?>" dataval="<?php echo $val['mobilephone'];?>" value="<?php echo $val['mobilephone'];?>" name="data[<?php echo $k;?>][mobilephone]">
                                    <input rel="errorInputAccount" type="hidden" value="0">
                                    <input rel="errorInputMobile" type="hidden" value="0">
                                    <span class="lable">密码：</span>
                                    <input type="password" autocomplete="off" rel="passwordInput" maxlength="16" usid="<?php echo $val['userid'];?>" value="******" name="data[<?php echo $k;?>][password]">
                                    <input rel="errorInputPassword" type="hidden" value="0">
                                </div>
                                <div class="inputBox_<?php echo $val['userid'];?>" style="margin-top: 5px;">
                                    <span class="errorTip red"></span>&nbsp;
                                </div>
                            </td>
                        </tr> 
                        <?php endforeach;?>
                        <?php endif;?>  
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"> 
                                <a class="btn btn-color1" id="postFormBtn" href="javascript:;">保存</a>
                                <a class="btn btn-color2" style="margin-right: 0;" href="<?php echo Yii::app()->createUrl('xiaoxin/default/searchaccount');?>">返回</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"> </td>
                        </tr>
                    </table>
                </form>
            </div>  
        </div>
    </div> 
</div>
    <script type="text/javascript">
        $(function(){
            $('#postFormBtn').click(function(){
                setTimeout(shubPost(),2000);
            });
            //表单提交验证
            function shubPost(){
                var formBox =$("#postFrom"),num = '0' ,mob = '0';
                var phoneNum='0';
                formBox.find('[rel=errorInputAccount]').each(function(e,v){
                    if($(this).val()==1){
                        num++;
                    }
                });
                formBox.find('[rel=errorInputPassword]').each(function(e,v){
                    if($(this).val()==1){
                        mob++;
                    }
                });
                formBox.find('[rel=errorInputMobile]').each(function(e,v){
                    if($(this).val()==1){
                        phoneNum++;
                    }
                });
                //alert(num+'--22--'+mob);
                if(num=='0'&&mob=='0'&&phoneNum=='0'){
                    $("#postFrom").submit();
                } 
            }
            var  accountUrl ="<?php echo Yii::app()->createUrl('xiaoxin/default/checkparentmobile');?>";
            var  mobileUrl ="<?php echo Yii::app()->createUrl('xiaoxin/default/checkparentmobile');?>";
            //验证帐号
            $('[rel=accountInput]').focusout(function(){
                var _this =$(this),
                usid = _this.attr('usid'), 
                dataval = $.trim(_this.attr('dataval')),
                account = $.trim(_this.val()),
                errorInfo = "您输入的帐号已使用"; 
                if(account!=""){ 
                    if(account.length >= 6 || account.length <=12){
                        if(dataval == account){ 
                        }else{
                            ajaxPostAccount(accountUrl,usid,account,errorInfo);
                             $(".inputBox_"+usid).find('.errorTip').text(''); 
                            $("#inputBox_"+usid).find('input[rel=errorInputAccount]').val('0');
                        }
                    }else{
                        $("#inputBox_"+usid).find('input[rel=errorInputAccount]').val('1');
                        $(".inputBox_"+usid).find('.errorTip').text('密码由6-12位数字或字符组合'); 
                    }

                }else{
                    $("#inputBox_"+usid).find('input[rel=errorInputAccount]').val('1');
                    $(".inputBox_"+usid).find('.errorTip').text('帐号不能为空'); 
                }                
            });
            
            //密码
            $('[rel=passwordInput]').focusout(function(){
                var _this =$(this),
                 usid = _this.attr('usid'),
                pval=_this.val();
                if(pval=="******"){ 
                }else{
                    if(pval==""){
                        $(".inputBox_"+usid).find('.errorTip').text('密码不能为空'); 
                        $("#inputBox_"+usid).find('input[rel=errorInputPassword]').val('1');
                    }else{
                         if(checkPassword(pval)){
                             $(".inputBox_"+usid).find('.errorTip').text(''); 
                            $("#inputBox_"+usid).find('input[rel=errorInputPassword]').val('0');
                         }else{
                            $("#inputBox_"+usid).find('input[rel=errorInputPassword]').val('1');
                            $(".inputBox_"+usid).find('.errorTip').text('密码由6-16位不同数字和字母组合');  
                         }
                    } 
                }
            });
            //验证手机
            $('[rel=mobilePhoneInput]').focusout(function(){
                var eg =/^((1)+\d{10})$/;
                var _this =$(this),
                usid = _this.attr('usid'), 
                dataval = $.trim(_this.attr('dataval')),
                mobph = $.trim(_this.val()),
                errorInfo = "您输入的手机已使用"; 
                if(mobph!="" ){ 
                    if(eg.test(mobph)){
                        $(".inputBox_"+usid).find('.errorTip').text('');
                        if(dataval == mobph){ 
                        }else{
                            ajaxPostMobile(mobileUrl,usid,mobph,errorInfo);
                        }
                    }else{
                        $("#inputBox_"+usid).find('input[rel=errorInputMobile]').val('1');
                        $(".inputBox_"+usid).find('.errorTip').text('你输入的注册手机格式不正确');  
                    } 
                }else{
                    $("#inputBox_"+usid).find('input[rel=errorInputMobile]').val('1');
                    $(".inputBox_"+usid).find('.errorTip').text('手机不能为空');
                }
            });
           
        });
        //帐号请求
        function ajaxPostAccount(urls,usid,account,errorInfo){
            $.getJSON(urls,{userid:usid,account:account},function(data){
                if(data.status){
                   var divBox = $("#inputBox_"+usid);
                   if(data.isBind=='1'){ 
                       $(".inputBox_"+usid).find('.errorTip').text(errorInfo);
                       divBox.find('input[rel=errorInputAccount]').val('1'); 
                   }else{
                      divBox.find('input[rel=errorInputAccount]').val('0');
                      divBox.find('input[rel=accountInput]').attr('dataval',account); 
                   }
                   
                }
            });
        }
        //手机请求
        function ajaxPostMobile(urls,usid,mobph,errorInfo){
            $.getJSON(urls,{userid:usid,mobilephone:mobph},function(data){
                if(data.status){
                    var divBox = $("#inputBox_"+usid);
                    if(data.isBind=='1'){
                        $(".inputBox_"+usid).find('.errorTip').text(errorInfo);
                        divBox.find('input[rel=errorInputMobile]').val('1'); 
                    }else{
                        divBox.find('input[rel=errorInputMobile]').val('0'); 
                        divBox.find('input[rel=mobilePhoneInput]').attr("dataval",mobph);
                    } 
                }
            });
        }
         function checkPassword(pwd) {
        // 长度为6到16个字符
            var reg = /^(([a-z]+[0-9]+)|([0-9]+[a-z]+))[a-z0-9]*$/i;
            //alert(reg.test(pwd));
            var len = pwd.length;
            if(len>=6&&len<=16){
                if (!reg.test(pwd)) {
                    return false;
                }else{
                    return true;
                }  
            }else{
               return false; 
            }
        }
    </script>
</body>
</html>