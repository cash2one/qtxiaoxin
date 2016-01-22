<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Cambiar contraseña.';
?>
<style>
input:not([type]), input[type="color"], input[type="email"], input[type="number"], input[type="password"], input[type="tel"], input[type="url"], input[type="text"] {
    padding: 4px 5px;
    width: 200px;
}
</style>
<div class="box">
    <div class=" "> 
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'pwd-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
        )); ?>
 
        <table class="tableForm" width="100%;">
            <tbody>
                <tr>
                    <td class="td_label">
                        当前密码* ：
                    </td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->passwordField($model, 'currentPassword', array('rel'=>'currentPasswordInput','style'=>' ','datatype'=>'*','nullmsg'=>'不能为空！','errormsg'=>'')); ?>
                        </div>
                        <span class="Validform_checktip"></span>
                        <?php echo $form->error($model,'currentPassword', array('style'=>'display: inline;color: red;','rel'=>'currentPassword')); ?> 
                    </td>
                </tr>
                <tr>
                    <td class="td_label">
                       新密码* ： 
                    </td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->passwordField($model, 'newPassword', array('class'=>'span3','datatype'=>'*6-16','nullmsg'=>'请输入新密码！','errormsg'=>'密码范围在6~16位之间！')); ?>
                        </div>
                        <span class="Validform_checktip"></span>
                        <?php echo $form->error($model,'newPassword'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">
                        确认密码* ：
                    </td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->passwordField($model, 'newPassword_repeat', array('class'=>'span3','recheck'=>'ChangePasswordForm[newPassword]','datatype'=>'*','nullmsg'=>'请再次输入新密码！','errormsg'=>'您两次输入的账号密码不一致！')); ?>
                        </div>
                        <span class="Validform_checktip"></span>
                        <?php echo $form->error($model,'newPassword_repeat'); ?>
                    </td>
                </tr>
                <tr>
                    <td ></td>
                    <td>
                        <p style="height: 15px;"></p>
                        <?php echo CHtml::submitButton(' 保 存 ',array('class'=>'btn btn-primary')); ?>
                        &nbsp; &nbsp; &nbsp;
                        <!--<input type="reset" class="btn " value="重 置">-->
                    </td>
                </tr>
            </tbody>    
        </table> 
        <?php $this->endWidget(); ?>
    </div>
    <script type="text/javascript">
    $(function(){
        $('#pwd-form').Validform({//表单验证
            tiptype:2,
            showAllError:true,
            ignoreHidden:true,
            postonce:true,
            datatype:{//传入自定义datatype类型 ; 
                "tel-3" : /^(\d{3,4}-)?\d{7,8}$/
            }
        }); 
    });
    $("input[rel=currentPasswordInput]").focus(function(){
        $('[rel=currentPassword]').hide();
        $(this).val('');
    }); 
    </script>
</div>