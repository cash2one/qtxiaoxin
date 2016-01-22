<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
    <div class="box"> 
        <!--<div class="box_top"><b class="pl15">表单</b></div>-->
        <div class="box_center">
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'user-form',
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation'=>false,
                'htmlOptions'=>array('enctype'=>'multipart/form-data'),
            )); ?>
            <table class="tableForm" width="100%" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr> 
                        <td class="td_label">账号名* ：</td>
                        <td class="">
                            <div style="display: inline;">  
                                <!-- 编辑修改 -->
                                <?php if(!$model->isNewRecord){ ?>
                                    <input id="nameUid" type="hidden" value="<?php echo $model->uid;?>">
                                    <?php echo $form->textField($model,'username',array('style'=>'width: 200px;','class'=>'readInput','size'=>30,'maxlength'=>20,'readonly'=>'readonly')); ?>
                                <?php }else{ ?>
                                    <?php echo $form->textField($model,'username',array('style'=>'width: 200px;','size'=>30,'maxlength'=>20,'datatype'=>'*','nullmsg'=>'账号名不能为空！','errormsg'=>'')); ?> 
                                <?php }?>
                            </div>
                            <span id="Validform_form" class="Validform_checktip "></span>
                            <span id="Validform_ajx" class="Validform_checktip Validform_wrong" style="display: none;">账号名已使用！</span>
                            <?php echo $form->error($model,'username'); ?> 
                        </td>
                    </tr>

                    <tr>
                        <td class="td_label">账号类型* ：</td>
                        <td>
                            <div style="display: inline;"> 
                                    <?php echo $form->dropDownList($model,'type',User::getTypeArr(),array('empty' => '--选择分类--','datatype'=>'*','nullmsg'=>'请选择类型！','errormsg'=>'')); ?>
                                <?php echo $form->error($model,'type'); ?>
                            </div>
                            <span class="Validform_checktip "></span>
                        </td>
                    </tr>

                    <tr>
                        <td class="td_right">真实姓名* ：</td>
                        <td class="">
                            <div style="display: inline;">
                                <?php echo $form->textField($model,'name',array('style'=>'width: 200px;','size'=>30,'maxlength'=>20,'datatype'=>'*','nullmsg'=>'真实姓名不能为空！','errormsg'=>'')); ?>
                            </div>
                            <span class="Validform_checktip "></span>
                            <?php echo $form->error($model,'name'); ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="td_right">头像 ：</td>
                        <td class=""> 
                            <div style="display: inline;"> 
                                <?php echo $form->fileField($model,'logo',array('rel'=>'previewNew','onchange'=>'preview(this)')); ?>
                                <?php echo $form->error($model,'logo'); ?> 
                            </div>
                            <span class="Validform_checktip ">建议图片比例为120*120，仅支持JPG，PNG格式上传</span>
                            <div id="previewNew" class="preview_box"  ><img src="<?php echo $model->logo; ?>"></div>
                        </td>
                    </tr> 
                    <tr> 
                        <td class="td_right">联系电话* ：</td>
                        <td class="">
                            <div style="display: inline;">
                                <?php echo $form->textField($model,'mobile',array('style'=>'width: 200px;','size'=>45,'maxlength'=>20,'datatype'=>'m|tel-3','nullmsg'=>'联系方式不能为空！','errormsg'=>'请输入正确的联系方式(手机或电话)！')); ?>
                            </div>
                            <span class="Validform_checktip "></span>
                            <?php echo $form->error($model,'mobile'); ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="td_right">公司邮箱* ：</td> 
                        <td class="">
                            <div style="display: inline;">
                                <?php echo $form->textField($model,'mail',array('style'=>'width: 200px;','size'=>45,'maxlength'=>64,'datatype'=>'e','nullmsg'=>'公司邮箱不能为空！','errormsg'=>'请输入正确的公司邮箱地址！')); ?>
                            </div>
                            <span class="Validform_checktip "></span>
                            <?php echo $form->error($model,'mail'); ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="td_right">QQ ：</td>
                        <td class="">
                             <div style="display: inline;">
                                <?php echo $form->textField($model,'qq',array('style'=>'width: 200px;','size'=>45,'maxlength'=>20,'ignore'=>'ignore','datatype'=>'n6-16','nullmsg'=>'','errormsg'=>'请输入正确QQ号！')); ?>
                             </div>
                             <span class="Validform_checktip "></span>
                                <?php echo $form->error($model,'qq'); ?>
                        </td>
                    </tr> 
                    <tr>
                        <td class="td_right"></td>
                        <td class="">
                            <p style="height: 20px;"></p>
                            <a href="javascript:void(0);" rel="postFrom" class="btn btn-primary"><?php echo $model->isNewRecord ? '创 建' : ' 保 存 '; ?></a>
                            <?php //echo CHtml::submitButton($model->isNewRecord ? '创 建' : ' 保 存 ',array('class'=>'btn btn-primary')); ?>
                            <input id="rightOrWrong" type="hidden" value="0">
                        </td>
                     </tr> 
           </tbody></table>
           <?php $this->endWidget(); ?>
        </div>

</div> 
<script type="text/javascript">
    //预览图
    function preview(file){ 
        var preview = $("#"+file.id).attr('rel'); 
        var prevDiv = document.getElementById(preview);
        var perHtml = prevDiv.innerHTML; 
        var size = file.size / 1024;  
        if(size>10){
            alert("附件不能大于10M");
        }else{ 
            var filepath = file.value;  
            var re = /(\\+)/g; 
            var filename=filepath.replace(re,"#"); 
            var one=filename.split("#"); 
            var two=one[one.length-1]; 
            var three=two.split("."); 
            var last=three[three.length-1]; 
            var tp ="jpg,gif,bmp,JPG,GIF,BMP,png";
            var rs=tp.indexOf(last); 
            if(rs>=0){
                if (file.files && file.files[0]){ 
                var reader = new FileReader();
                reader.onload = function(evt){
                prevDiv.innerHTML = '<img src="' + evt.target.result + '" />';
                }	  
                reader.readAsDataURL(file.files[0]);
            }else { 
                prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
            }
            }else{
                file.value = '';
                prevDiv.innerHTML = perHtml;
                alert("您选择的上传文件不是有效的图片文件！");
                return false;
            }
        } 
    }
  
$(function(){
    $("#User_username").change(function(){ 
        var name = $(this).val(); 
        var ajaxurl ="<?php echo Yii::app()->createUrl('user/userexsit');?>";
        if(name){
            $.ajax({  
                url: ajaxurl,   
                type : 'POST',  
                data : {username:name},  
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',
                async :false,  
                success : function(mydata) {
                     if(mydata>0){
                         $('#rightOrWrong').val(1);
                         $("#Validform_form").hide();
                         $("#Validform_ajx").show();
                     }else{
                         $("#Validform_ajx").hide();
                         $("#Validform_form").show();
                         $('#rightOrWrong').val(0);
                     }
                },  
                error : function() { 
                }  
            });
        }else{
            $("#Validform_ajx").hide();
            $("#Validform_form").show();
        }
    })

  var Valid = $('#user-form').Validform({//表单验证
        tiptype:2,
        showAllError:true,
        ignoreHidden:true,
        postonce:true,
        datatype:{//传入自定义datatype类型 ; 
            "tel-3" : /^(\d{3,4}-)?\d{7,8}$/
        },
        callback:function(data){
            var vaule = $('#rightOrWrong').val();
            if(vaule=='0'){ 
                return true;
            }else{ 
                return false;
            }
        }
    }); 
    $("[rel=postFrom]").click(function(){
        Valid.resetStatus();
        $('#user-form').submit(); 
    });
});


</script>
