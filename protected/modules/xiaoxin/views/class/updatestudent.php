<div class="header">
<!--    <div class="headBox fright">
        <div class="headNav">
            <ul>
               <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/view/'.$class->cid);?>">首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/teachers/'.$class->cid);?>" class="focus" >成员</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/update/'.$class->cid);?>">设置</a></li>
            </ul>
        </div>  
    </div>-->
    <div class="titleText"><em class="inIco17"></em>我的班级 > <?php echo $class->name; ?>  </div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
               编辑学生信息.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box">
            <div class="listTopTite bBottom"><?php echo $student->name;?> 学生信息</div> 
            <div class="formBox">
                <form id="formBoxRegister" action="" method="post">
                    <table class="tableForm" >
                        <tbody> 
                            <tr> 
                                <td>
                                    <span class="inputTitle">学 号：</span>
                                    <div class="inputBox"><input placeholder="请输入学生的学号" type="text" name="studentid" value="<?php echo $studentid;?>" class="medium" onkeyup="phone(this);" maxlength="20"></div>
                                </td>
                            </tr>
                            <?php if(is_array($guardians)&&count($guardians)):?>
                            <tr>
                                <td class="guardiansListBox">
                                    <span class="inputTitle fleft" style="margin-top: 5px;">家 长：</span> 
                                    <?php foreach($guardians as $k=>$val):?>
                                    <div class="itmeBox" style="margin-left: 52px; margin-bottom: 15px;">
                                        <div class="inputBox"><input placeholder="请输入与学生的关系" type="text" name="name[]" maxlength="10" value="<?php echo $val->role;?>" class="medium" onkeyup="inputBlank(this);"></div>
                                        <div class="inputBox">
                                            <input placeholder="请输入联系手机号" maxlength="11" type="text" name="mobilephone[]" onkeyup="inputNumber(this);" value="<?php echo $val->guardian0?$val->guardian0->mobilephone:'';?>" class="mediumL" datatype ="phone" nullmsg="请输入联系手机号！" errormsg="输入的手机号不正确!">
                                            <a rel="delPart" href="javascript:void(0);" style="<?php echo $k==0?'display: none':'';?>;">删 除</a>
                                        </div> 
                                        <span class="Validform_checktip" ><span class="Validform_checktip" ></span></span>
                                        <input type="hidden" name="id[]" value="<?php echo $val->id;?>"/>
                                    </div> 
                                    <?php endforeach;?> 
                                </td> 
                            </tr>
                          
                        <?php else:?>
                            <tr>
                                <td class="guardiansListBox">
                                    <span class="inputTitle fleft" style="margin-top: 5px;">家 长：</span>
                                    <div class="itmeBox" style="margin-left: 52px; margin-bottom: 15px;">
                                        <div class="inputBox"><input placeholder="请输入与学生的关系(限3字)" type="text" name="name[]" maxlength="10" class="medium" onkeyup="inputBlank(this);">
                                        </div>
                                        <div class="inputBox">
                                            <input placeholder="请输入联系手机号"  name="mobilephone[]" maxlength="11" type="text" class="mediumL" datatype ="phone" onkeyup="inputNumber(this);" nullmsg="请输入联系手机号！" errormsg="输入的手机号不正确!">
                                            <a href="javascript:void(0);" rel="delPart" style="display: none;" >删 除</a>
                                        </div> 
                                        <span class="Validform_checktip" ><span class="Validform_checktip" ></span></span>
                                        <input type="hidden" name="id[]" value=" "/> 
                                    </div> 
                                </td> 
                            </tr>
                        <?php endif;?>
                            <tr>
                                <td>
                                    <span class="inputTitle" style="margin-left: 48px;"></span>
                                    <a href="javascript:void(0);" rel="addPart" class="btn btn-default" > 添 加</a>
                                </td> 
                            </tr>
                            <tr>
                                <td>
                                    <span class="inputTitle" style="margin-left: 48px;"></span>
                                    <input type="submit"  class="btn btn-raed" value="保 存"/>
                                    <input type="hidden" value="<?php echo $student->userid;?>" name="student"/> 
                                </td> 
                            </tr>
                        </tbody>
                    </table>
                </form>
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
    //添加操作
    $(document).on('click', 'a[rel=addPart]', function(event) { 
        var html=$(".guardiansListBox").find('.itmeBox');
         if (html.length >=1) {
              html.find('a[rel=delPart]').show();
         }
        $(".guardiansListBox").append($(html[0]).clone());
        $(".guardiansListBox .itmeBox").last().find('input[type=hidden]').val('');
        $(".guardiansListBox .itmeBox").last().find('input[type=text]').val('');  
    });
     //删除操作
    $(document).on('click', 'a[rel=delPart]', function(event) {
        var liDe=$(this).parents('.guardiansListBox').find('.itmeBox');
        if (liDe.length == 2) {
            liDe.find('a[rel=delPart]').hide();
        }
        $(this).parents('.itmeBox').remove();
    });  
});
</script>