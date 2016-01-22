<style>
   .radioBox{ }
   .radioBox label{ font-size: 14px; font-weight: 100;}
</style>
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
            <thead></thead>
            <tbody>
                <tr>
                    <td class="td_title_Long">所属商家* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('empty' => '--选择商家--','datatype'=>'*','nullmsg'=>'请选择商家！','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'bid'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 
                </tr>
                <tr>
                    <td class="td_title_Long">资讯分类* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->dropDownList($model,'ikid',InformationKind::getDataArr(),array('empty' => '--选择分类--','datatype'=>'*','nullmsg'=>'请选择分类！','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'ikid'); ?>
                        </div>
                        <div class="Validform_checktip " style=" display: inline;">
                            <input id="ytInformation_kindtop" type="hidden" value="" name="Information[kindtop]">
                            <span id="Information_kindtop" class="radioBox" >
                                &nbsp;&nbsp;<input rel="kindtop1"  id="Information_kindtop_0" <?php if($model->kindtop == 1){echo 'checked="checked"';}?> value="1" type="radio" name="Information[kindtop]"> 
                               <label for="Information_kindtop_0">置顶</label> &nbsp;&nbsp;
                               <input id="Information_kindtop_1" rel="kindtop0" value="0" <?php if($model->kindtop == 0){echo 'checked="checked"';}?> type="radio" name="Information[kindtop]"> 
                               <label for="Information_kindtop_1">不置顶</label>
                            </span> 
                        </div> 
                        <input id="countKindTop" type="hidden" value="<?php echo Information::countKindTop($model->ikid);?>">
                    </td> 
                </tr> 
                <tr>
                    <td class="td_title_Long">头条设置 ：</td>
                    <td>
                        <div style="display: inline;" > 
                            <?php echo $form->checkBox($model,'head',array()); ?>
                            <label for="Information_head" style=" font-weight: 100;">设为头条</label>
                            <?php echo $form->error($model,'ikid'); ?>
                        </div>
                        <span class="Validform_checktip "></span> 
                        <input id="ytInformation_headtop" type="hidden" value="" name="Information[headtop]">
                        <span id="Information_headtop" class="radioBox" style="display: none;">
                             &nbsp;&nbsp;<input id="Information_headtop_0" rel="headtop1" value="1" <?php if($model->headtop == 1){echo 'checked="checked"';}?> type="radio" name="Information[headtop]"> 
                            <label for="Information_headtop_0">置顶</label>&nbsp;&nbsp; 
                            <input id="Information_headtop_1" rel="headtop0" value="0" <?php if($model->headtop == 0){echo 'checked="checked"';}?> type="radio" name="Information[headtop]">
                            <label for="Information_headtop_1">不置顶</label>
                        </span> 
                        <input id="countTeadTop" type="hidden" value="<?php echo Information::countHeadTop();?>">  
                    </td> 
                </tr> 
                <tr>
                    <td class="td_title_Long">资讯来源 ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->textField($model,'source',array('style'=>'width:300px;','ignore'=>'ignore','datatype'=>'*1-10','nullmsg'=>'请选择输入资讯来源','errormsg'=>'资讯来源长度不大于10个字!')); ?>
                            <?php echo $form->error($model,'source'); ?>
                        </div>
                        <span class="Validform_checktip ">此处限制10字以内</span>
                    </td> 
                </tr>
                <tr>
                    <td class="td_title_Long">资讯标题* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->textField($model,'title',array('maxlength'=>'50','style'=>'width:300px;','datatype'=>'*1-20','nullmsg'=>'请输入资讯标题!','errormsg'=>'资讯标题长度不大于20个字!')); ?>
                            <?php echo $form->error($model,'title'); ?>
                        </div>
                        <span class="Validform_checktip ">此处限制20字以内</span>
                    </td> 
                </tr>
                <tr>
                    <td class="td_title_Long">外链地址 ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->textField($model,'url',array('style'=>'width:300px;','ignore'=>'ignore','datatype'=>'url','nullmsg'=>'请输入外链地址！','errormsg'=>'请输入真确的连接地址!')); ?>
                            <?php echo $form->error($model,'url'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 
                </tr>
                <tr>
                    <td class="td_label">资讯图片* ：</td>
                    <td>
                        <div style="display: inline;">
                            <?php if(!$model->isNewRecord){ ?>
                                <?php echo $form->fileField($model,'image',array('rel'=>'previewNewImage','onchange'=>'previewImg(this)')); ?>
                            <?php }else{ ?>
                                <?php echo $form->fileField($model,'image',array('rel'=>'previewNewImage','onchange'=>'previewImg(this)','datatype'=>'*','nullmsg'=>'请选择！','errormsg'=>'')); ?>
                            <?php }?>
                        </div>
                        <span class="Validform_checktip ">建议图片比例为100*80，仅支持JPG，PNG格式上传</span>
                        <div id="previewNewImage" class="previewMax_box"  style="width: 100px; height: 80px;"><img style="height: 80px;" src="<?php echo $model->image; ?>"></div>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">资讯大图* ：</td>
                    <td>
                        <div style="display: inline;">
                            <?php if(!$model->isNewRecord){ ?>
                                <?php echo $form->fileField($model,'bigimage',array('rel'=>'previewNewBigimage','onchange'=>'previewImg(this)')); ?>
                            <?php }else{ ?>
                                <?php echo $form->fileField($model,'bigimage',array('rel'=>'previewNewBigimage','onchange'=>'previewImg(this)','datatype'=>'*','nullmsg'=>'请选择！','errormsg'=>'')); ?>
                            <?php }?> 
                        </div>
                        <span class="Validform_checktip ">建议图片比例为560*290，仅支持JPG，PNG格式上传</span>
                        <div id="previewNewBigimage" class="previewMax_box" style="width: 485px; height: 190px;"><img style="height: 190px;" src="<?php echo $model->bigimage; ?>"></div>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">摘要*：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textField($model,'summery',array('maxlength'=>'60','datatype'=>'*1-30','nullmsg'=>'请输入摘要！','errormsg'=>'摘要长度不大于30字！')); ?>
                        </div>
                        <span class="Validform_checktip ">此处限制30字以内</span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">正文*：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textArea($model,'text',array('datatype'=>'*','nullmsg'=>'请输入正文！','errormsg'=>' ')); ?>
                        </div>
                        <span class="Validform_checktip " style=" margin-left: 0;"></span>
                    </td>
                </tr>
            </tbody>
            <tfoot></tfoot>
        </table>  
        
        <table class="tableForm">
            <thead></thead>
            <tbody>
                <tr>
                    <td class="td_title_Long"></td>
                    <td> 
                      <?php //echo CHtml::submitButton($model->isNewRecord ? '确 定' : '保 存',array('class'=>'btn btn-primary')); ?>
                    <?php if(!$model->isNewRecord){ ?>
                        <a id="sub_from" href="javascript:void(0);" class="btn btn-primary">保 存</a>
                        &nbsp;&nbsp;<a class="btn btn-default" href="<?php echo Yii::app()->createUrl('information/delete/'.$model->iid);?>"> 删 除 </a>
                    <?php }else{ ?>
                        <a id="sub_from" href="javascript:void(0);" class="btn btn-primary">创 建</a>
                    <?php } ?>
                    </td>

                </tr>
            </tbody>
            <tfoot></tfoot>
        </table> 
        <?php $this->endWidget(); ?> 
    </div><!-- form -->
    <div id="popupBoxR" class="popupBox" style=" width: 420px; height: 230px; margin-top: 0;">
        <div class="header">温馨提示 <a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#popupBoxR')" > </a></div>
        <div id="remindCenten" class="remindInfoBox"> </div>
        <div style="text-align: center; margin-top:20px;">
            <a class="btn btn-primary" href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBoxR')" >取消</a>
        </div>
    </div>
 </div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script> 
<script type="text/javascript">
  //表单验证
 $('#business-form').Validform({
    tiptype:2,
    showAllError:true,
    ignoreHidden:false,
    postonce:true,
    datatype:{//传入自定义datatype类型 ; 
        "tel-3" : /^(\d{3,4}-)?\d{7,8}$/
    },
    callback:function(data){ }
});
 //提交验证
$("#sub_from").click(function(){
    tinyMCE.triggerSave(true); 
    $("#business-form").submit();
});
//置顶操作
$("#Information_head").change(function(){
    var flag = document.getElementById('Information_head'); 
    if(flag.checked){
        $('#Information_headtop').show();
    }else{
        $('#Information_headtop').hide();
    }        
});
$('#Information_ikid').change(function(){ 
    $('input[rel=kindtop0]').attr('checked','checked'); 
    $('input[rel=kindtop1]').removeAttr('checked'); 
});
function kindTopAjax(obj,text,ikid){
    var url='<?php echo Yii::app()->createUrl('information/kindtop/');?>';
    var iid ='<?php echo $model->iid;?>'; 
    $.ajax({  
        url:url,   
        type : 'POST',
        data : {iid:iid,ikid:ikid},
        dataType : 'text',  
        contentType : 'application/x-www-form-urlencoded',  
        async : false,  
        success : function(mydata) {  
            if(parseInt(mydata)>=4){
                $('#remindCenten').empty();
                $('#remindCenten').append(text);
                showPromptsIfonWeb('#popupBoxR');
                $('input[rel=kindtop0]').attr('checked','checked');
                obj.removeAttr('checked');
            } 
        },  
        error : function() {  
                // alert("calc failed");  
        }  
    });
}
//判断资讯置顶条数
$('input[rel=kindtop1]').click(function(){
    var obj = $(this); 
    var text= '<div style="height: 65px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;资讯分类的每个类别仅能设置4个置顶，如需置顶，请先取消其他的置顶资讯</div>';
    var ikid = $('#Information_ikid').find('option:selected').val(); 
    if(ikid){
        kindTopAjax(obj,text,ikid);  
    } 
});
//判断头条置顶条数
$('input[rel=headtop1]').click(function(){  
    var text = '<div style="height: 65px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;头条仅能设置4个置顶，如需置顶，请先取消其他的置顶头条</div>';
    var headtop = $('#countTeadTop').val(); 
    if(parseInt(headtop)>=4){
        $('#remindCenten').empty();
        $('#remindCenten').append(text);
        showPromptsIfonWeb('#popupBoxR');
        $('input[rel=headtop0]').attr('checked','checked');
         $(this).removeAttr('checked');
    }  
}); 
//置顶初始化
if(document.getElementById('Information_head').checked){
    $('#Information_headtop').show();
}
//预览图
function previewImg(file){ 
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
</script>
