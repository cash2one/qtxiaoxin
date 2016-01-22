<style>
   .tip{color: #999999; }
</style>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/My97DatePicker/WdatePicker.js"></script>
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
        <input type="hidden" id="ajaxsubform" value="<?php echo Yii::app()->createUrl('focus/getsubform');?>">
        <div style="border: 1px solid #f1f1f1; padding: 0px 0 50px 0; margin-top: 20px;">
            <div class="navCrumb">编辑标题简介</div>
            <div class="box">
                <table class="tableForm">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <td class="td_label">标题* ：</td>
                            <td>
                                <div style="display: inline;"> 
                                    <?php echo $form->textField($model,'title',array('size'=>35,'maxlength'=>35,'datatype'=>'*1-30','nullmsg'=>'热点标题不能为空！','errormsg'=>'热点标题长度不能大于30个字！')); ?>
                                    <?php echo $form->error($model,'title'); ?>
                                </div>
                                <span class="Validform_checktip ">此处限制30字以内</span>
                            </td>
                        </tr> 
                        <tr>
                            <td  class="td_label">图片* ：</td>
                            <td>
                                <div style="display: inline;">
                                    <?php if(!$model->isNewRecord){ ?>
                                        <!-- 编辑 修改-->
                                        <?php echo $form->fileField($model,'image',array('rel'=>'previewNew','onchange'=>'preview(this)')); ?>
                                     <?php }else{ ?>
                                         <?php echo $form->fileField($model,'image',array('rel'=>'previewNew','onchange'=>'preview(this)','datatype'=>'*','nullmsg'=>'热点图片不能为空！','errormsg'=>'')); ?>
                                    <?php }?>
                                    <?php echo $form->error($model,'image'); ?> 
                                </div>
                                <span class="Validform_checktip ">建议图片比例为560*290，仅支持JPG，PNG格式上传</span>
                                <div id="previewNew" class="preview_box" style="width: 300px;"><img src="<?php echo $model->image; ?>"></div>
                            </td>
                        </tr>
                        <tr>
                            <td class="td_label">摘要* ：</td>
                            <td>
                                <div style="display: inline;"> 
                                    <?php echo $form->textField($model,'summery',array('size'=>20,'maxlength'=>256,'datatype'=>'*1-30','nullmsg'=>'广告摘要不能为空！','errormsg'=>'热点摘要长度不能大于30个字！')); ?>
                                    <?php echo $form->error($model,'summery'); ?>
                                </div>
                                <span class="Validform_checktip ">此处限制30字以内</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="td_label">投放时间* ：</td>
                            <td>
                                <div style="display: inline;"> 
                                    <?php echo $form->textField($model,'startdate',array('readonly'=>'readonly',"onclick"=>'WdatePicker({isShowClear:false,dateFmt:"yyyy-MM-dd HH:mm:ss"})','style'=>'width: 180px; height:auto;','datatype'=>'*','nullmsg'=>'起始时间不能为空!','errormsg'=>'','class'=>'Wdate')); ?>
                                    &nbsp;至&nbsp;
                                    <?php echo $form->textField($model,'enddate',array('readonly'=>'readonly',"onclick"=>'WdatePicker({isShowClear:false,dateFmt:"yyyy-MM-dd HH:mm:ss"})','style'=>'width: 180px; height:auto;','datatype'=>'*','nullmsg'=>'结束时间不能为空!','errormsg'=>'','class'=>'Wdate')); ?>
                                </div>
                                <span class="Validform_checktip"></span>
                            </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
        </div>
        <div style="border: 1px solid #f1f1f1; padding: 0px; margin-top: 20px;">
            <div class="navCrumb">编辑内容</div>
            <div class="box">
                <table class="tableForm">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <td class="td_label">热点类型* ：</td>
                            <td>
                                <div style="display: inline;"> 
                                    <?php echo $form->dropDownList($model,'type',Focus::getTypeArr(),array('datatype'=>'*','nullmsg'=>'请选择类型！','errormsg'=>'')); ?>
                                    <?php echo $form->error($model,'type'); ?>
                                </div>
                                <span class="Validform_checktip "></span>
                            </td>
                        </tr>
                        <tr class="box_issue" style=" display: none;">
                            <td width="80px;">赠送青豆*：</td>
                            <td>
                                <?php echo $form->dropDownList($model,'point', $model->getPointItemList(),array('class'=>'','options' => array($model->getFocPoint()=>array('selected'=>true)))); ?>
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div> 
            <!-- 文章类型 -->
            <div class="box_new" >
                <div class="box">
                    <table class="tableForm">
                        <thead></thead>
                        <tbody>
                            <tr> 
                                <td class="td_label">正文*：</td>
                                <td>
                                    <div style="width: 100%; height: auto; border: 1px solid #f1f1f1;">
                                        <?php echo $form->textArea($model,'text'); ?> 
                                    </div>
                                    <div class="contentTip Validform_checktip Validform_wrong" style="display: none;"> 内容不能为空！</div>
                                </td> 
                            </tr>
                        </tbody>
                    </table> 
                </div>
            </div>
             <!-- 问卷类型 -->
            <div class="box_issue" style="width: 100%; display: none;" >
                <div id="result" > 
                </div>
                <div style=" padding-bottom: 20px;">
                    <a href="javascript:void(0);" style="margin:10px 105px;" id="new_acrivity">增加问题</a>
                </div>
            </div>
             <div class="box_url">
                <div class="box">
                    <table class="tableForm">
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td class="td_label">链接地址* ：</td>
                                <td>
                                    <div style="display: inline;"> 
                                        <?php echo $form->textField($model,'url',array('size'=>30,'maxlength'=>50,'datatype'=>'url', 'nullmsg'=>'不能为空！', 'errormsg'=>'请输入正确的链接地址！')); ?>
                                        <?php echo $form->error($model,'url'); ?>
                                    </div>
                                    <span class="Validform_checktip "></span>
                                </td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
        <div class="box" tyle=" margin-top: 20px;">
            <table class="tableForm">
                <thead></thead>
                <tbody>    
                    <tr>
                        <td class="td_label"></td>
                        <td>
                            <a href="javascript:void(0);" id="sub_from" class="btn btn-primary">创 建</a>
                            <?php //echo CHtml::submitButton($model->isNewRecord ? '创建' : '保存',array('class'=>'btn btn-primary')); ?>
                            <?php if(!$model->isNewRecord){ ?>
                                &nbsp;&nbsp;&nbsp;<a class="btn btn-default" href="<?php echo Yii::app()->createUrl('business/delete/'.$model->bid);?>">删 除</a>
                            <?php } ?> 
                        </td> 
                    </tr>
                </tbody>
                <tfoot></tfoot>
            </table>  
        </div>
<?php $this->endWidget(); ?>
<!-- form --> 
<script type="text/javascript">  
    //表单验证
    var Valid = $('#business-form').Validform({//表单验证
        tiptype:2,
        showAllError:true,
        ignoreHidden:true,
        postonce:true,
        datatype:{//传入自定义datatype类型 ; 
            "tel-3" : /^(\d{3,4}-)?\d{7,8}$/
        },
        callback:function(data){ 
            var strBox = $("#Focus_type").find("option:selected").val(); 
            if(strBox==0){ 
                var content = tinyMCE.get('Focus_text').getContent(); 
                if(content.length>0){
                    $("#sub_from").attr("disabled","disabled");
                    return true;
                }else{  
                    return false;
                }
            }else if(strBox==1){ 
                var inputBox = $("#result"),flags= 0,flagt= 0,flagtL=0 ,flagsL=0; 
                inputBox.find('input[rel=t]:visible').each(function(k,v){
                    var rel = v.value; 
                    if(rel==""){ 
                       flagt++;
                    }else if(rel.length>50){ 
                      flagtL++;
                    } 
                });
                inputBox.find('input[rel=title]').each(function(k,v){
                    var rels = v.value; 
                    if(rels==""){ 
                        flagt++;
                    }else if(rels.length>50){ 
                        flagsL++;
                    } 
                }); 
                if(flags == 0 && flagt == 0 && flagsL == 0 && flagtL== 0){ 
                    $("#sub_from").attr("disabled","disabled");
                    return true; 
                }else{  
                    return false;   
                }
            } 
        }
    }); 
   //优化验证体验
    $(document).click(function(e){
        var strBox = $("#Focus_type").find("option:selected").val();
        if($(e.target).eq(0).is('body')){ 
        }else{ 
            if(strBox==0){
                var content = tinyMCE.get('Focus_text').getContent();
                if(content.length>0){
                    $(".contentTip").hide();
                }
            }else if(strBox==1){
                var inputBox = $("#result"),flags= 0,flagt= 0;
                inputBox.find('input[rel=t]').each(function(k,v){
                    var rel = v.value; 
                    if(rel==""){ 
                    }else if(rel.length>50){ 
                        $(this).parents('td').find('.tipWrong').show();
                        $(this).parents('td').find('.tipB').hide();
                    }else{
                        $(this).parents('td').find('.tipWrong').hide();
                        $(this).parents('td').find('.tipB').hide();
                    } 
                });
                inputBox.find('input[rel=title]').each(function(k,v){
                    var rels = v.value; 
                    if(rels==""){ 
                    }else if(rels.length>50){ 
                        $(this).parents('td').find('.tipWrong').show();
                        $(this).parents('td').find('.tip').hide();
                    }else{
                        $(this).parents('td').find('.tipWrong').hide();
                        $(this).parents('td').find('.tipB').hide();
                    } 
                });
            } 
        }
    });
    //表单提交验证
    $("#sub_from").click(function(){
        var strBox = $("#Focus_type").find("option:selected").val(); 
        if(strBox==0){ 
            var content = tinyMCE.get('Focus_text').getContent(); 
            if(content.length>0){ 
                $(".contentTip").hide(); 
            }else{ 
                $(".contentTip").show();  
            }
        }else if(strBox==1){ 
            var inputBox = $("#result"); 
            inputBox.find('input[rel=t]:visible').each(function(k,v){
                var rel = v.value; 
                if(rel==""){
                   $(this).parents('td').find('.tipB').show(); 
                }else if(rel.length>50){ 
                    $(this).parents('td').find('.tipWrong').show();
                    $(this).parents('td').find('.tipB').hide(); 
                }else{
                    $(this).parents('td').find('.tipWrong').hide();
                    $(this).parents('td').find('.tipB').hide();
                } 
            });
            inputBox.find('input[rel=title]').each(function(k,v){
                var rels = v.value; 
                if(rels==""){
                    $(this).parents('td').find('.tipB').show(); 
                }else if(rels.length>50){ 
                    $(this).parents('td').find('.tipWrong').show();
                    $(this).parents('td').find('.tipB').hide(); 
                }else{
                    $(this).parents('td').find('.tipWrong').hide();
                    $(this).parents('td').find('.tipB').hide();
                } 
            }); 
        }
       Valid.resetStatus();
       $("#business-form").submit(); 
    });
    var showItem ='';//全局计数变量 
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
     
     //选择是新闻 还是问卷 
    $("#Focus_type").change(function(event) { 
            var typeVal = $(this).find("option:selected").val();
            if(typeVal==0){
                $('.box_issue').hide();
                $('.box_url').hide(); 
                $('.box_new').show(); 
            }else if(typeVal==1){
                $('.box_issue').show();
                 $('.box_url').hide(); 
                $('.box_new').hide();
                ajaxNewQuestion('question',1);
            }else  if(typeVal==2){
                $('.box_issue').hide();
                $('.box_url').show(); 
                $('.box_new').hide();
            }
    });
    //默认是新闻 还是问卷 
    if($("#Focus_type").find("option:selected").val()==0){
        $('.box_issue').hide();
        $('.box_url').hide(); 
        $('.box_new').show(); 
    }else if($("#Focus_type").find("option:selected").val()==1){
       $('.box_issue').show();
       $('.box_url').hide(); 
       $('.box_new').hide();
   }else if($("#Focus_type").find("option:selected").val()==2){
       $('.box_issue').hide();
       $('.box_url').show(); 
       $('.box_new').hide();
   } 
    function ajaxNewQuestion(ty,q){//添加问题ajax请求
        $.ajax({  
            url: $("#ajaxsubform").val(),   
            type : 'POST',  
            data : {type:ty,qnum:q},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {   
                var show_data =mydata;  
                $("#result").append(show_data); 
            },  
            error : function() {  
              alert("calc failed");  
            }  
        });
    }
    function ajaxNewItem(ty,q,t){////添加选项ajax请求
        $.ajax({  
            url: $("#ajaxsubform").val(),   
            type : 'POST',  
            data : {type:ty,qnum:q,tnum:t},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {   
              showItem =mydata;  
              // $(this).parents("table").append(str); 
            },  
            error : function() {  
                alert("calc failed");  
            }  
        });
    }

    //增加选项
    $(document).on('click', '.new_option', function(event) {
        event.preventDefault(); 
        var ty = "item";
        var q = $(this).parents("table").attr("rel"); 
        var t=1;  
        t += $(this).parents("table").find('tr input[rel=t]').length; 
        if(t<=10){
            $(this).parents("table").find(".deleInput").hide(); 
            ajaxNewItem(ty,q,t)
            $(this).parents("table").append(showItem);
        }else{
            $(this).siblings('.newOptionTip').addClass('red');
            // $(this).siblings('.newOptionTip').hide(5000);
        }
		 
	});

    //删除选项
	$(document).on('click', '.deleInput', function(event) {
            $(this).parents("tr").prev('tr').find('.deleInput').show();
            $(this).parents('tr').remove(); 
	});

    //添加新问题
	$(document).on('click', '#new_acrivity', function(event){ 
            var ty = "question";
            var q = 1;
            q += $("#result").find('table').length;
            $(".delequestion").hide(); 
         // $('.box_issue .box').append(htmlta);
            ajaxNewQuestion(ty,q);
            $("#result").last('table').find('delequestion').show();

	});

    //删除问题
	$(document).on('click', '.delequestion', function(event) {
            $(this).parents('table').remove();
            $("#result table").last().find('.delequestion').show(); 
	});
     //问答题
    $(document).on('click','.typeOption input[type="radio"]',function(){
        if($(this).val()=="2"){
            $(this).parents('.typeOption').find('.new_option').hide(); 
            $(this).parents('tr').siblings('.inputBox').hide();
            $(this).parents('tr').siblings('.textareaBox').show();
            $(this).parents('.typeOption').find('.newOptionTip ').hide();
        }else{
            $(this).parents('tr').siblings('.textareaBox').hide();
            $(this).parents('tr').siblings('.inputBox').show();
            $(this).parents('.typeOption').find('.new_option').show();
            $(this).parents('.typeOption').find('.newOptionTip ').show();
        }
    });
    </script>
</div>