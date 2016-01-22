<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/textareas.js"></script>
<div class="box">
    <div class="form tableBox">
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'business-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?> 
        <?php echo $form->errorSummary($model); ?>
        <table class="tableForm"> 
            <tbody>
                <tr>
                    <td class="td_label" style="width: 20px;">广告标题* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->textField($model,'title',array('size'=>25,'maxlength'=>25,'datatype'=>'*1-15','nullmsg'=>'广告标题不能为空！','errormsg'=>'广告标题不能超过15个字！')); ?>
                            <?php echo $form->error($model,'title'); ?>
                        </div>
                        <span class="Validform_checktip ">此处限制15字以内</span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">广告摘要* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->textField($model,'summery',array('size'=>20,'maxlength'=>256,'datatype'=>'*1-30','nullmsg'=>'广告摘要不能为空！','errormsg'=>'广告摘要不能超过30个字！')); ?>
                            <?php echo $form->error($model,'summery'); ?>
                        </div>
                        <span class="Validform_checktip ">此处限制30字以内</span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">外链地址 ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->textField($model,'url',array('size'=>30,'maxlength'=>50,'ignore'=>'ignore','datatype'=>'url', 'nullmsg'=>' ','errormsg'=>'请输入正确的链接地址！')); ?>
                            <?php echo $form->error($model,'url'); ?>
                        </div>
                        <span class="Validform_checktip"></span>
                    </td>
                </tr>
                <tr>
                    <td  class="td_label">广告图片* ：</td>
                    <td>
                        <div style="display: inline;">
                            <?php if(!$model->isNewRecord){ ?>
                                <!-- 编辑 修改-->
                                <?php echo $form->fileField($model,'image',array('rel'=>'previewNew','onchange'=>'preview(this)')); ?>
                             <?php }else{ ?>
                                 <?php echo $form->fileField($model,'image',array('rel'=>'previewNew','onchange'=>'preview(this)','datatype'=>'*','nullmsg'=>'广告图片不能为空！','errormsg'=>'')); ?>
                            <?php }?>
                            <span style="color: #999;"></span>
                            <?php echo $form->error($model,'image'); ?>
                        </div>
                        <span class="Validform_checktip ">建议图片比例为75*60，仅支持JPG，PNG格式上传</span>
                        <div id="previewNew" class="preview_box" style="width: 75px; height: 60px;"><img src="<?php echo $model->image; ?>"></div>
                    </td>
                </tr>
                <tr>
                    <td  class="td_label">内容 *：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50,'datatype'=>'*','nullmsg'=>'内容不能为空！','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'text'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td> 
                        <a href="javascript:void(0);" id="sub_from" class="btn btn-primary">创 建</a>
                        <?php //echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存',array('class'=>'btn btn-primary')); ?>
                        <?php if(!$model->isNewRecord){ ?>
                            &nbsp;&nbsp;&nbsp;<a class="btn btn-default" rel="deleLink" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('business/delete/'.$model->bid);?>">删 除</a>
                        <?php } ?>
                         &nbsp;&nbsp;<a href="javascript:void(0);" onclick="showPrompts('popupBox','Advertisement_title','Advertisement_text')" class="btn  btn-default">预 览</a>
                    </td> 
                </tr>
            </tbody>
            <tfoot></tfoot>
        </table> 
        <?php $this->endWidget(); ?> 
     </div><!-- form -->
<div class="popupBox">
    <div class="header">广告预览 <a href="javascript:void(0);" class="close" onclick="hidePormptMask('popupBox')" > </a></div>
    <div id="popupInfo">  
    </div> 
</div>
<div id="popupBox" class="popupBox">
    <div id="popupInfo" style="padding: 30px;">
        <div class="centent">温馨提示：是否删除当前广告？</div>
    </div>
    <div style="text-align: center;">
        <a id="isOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
    </div>
</div>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script>
    <script type="text/javascript">
         //删除提醒
        $('[rel=deleLink] ').click(function () {
            var urls = $(this).data('href');
            $("#isOk").attr('href', urls);
            showPromptsIfonWeb('#popupBox');
        });
        //提交验证
        $("#sub_from").click(function(){
            tinyMCE.triggerSave(true); 
            $("#business-form").submit();
        });
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
                var tp ="jpg,JPG,png,PNG";
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
            $('#business-form').Validform({//表单验证
                tiptype:2,
                showAllError:true, 
                postonce:true,
                datatype:{//传入自定义datatype类型 ; 
                    "tel-3" : /^(\d{3,4}-)?\d{7,8}$/
                }
            }); 
        }); 
    </script>
</div>