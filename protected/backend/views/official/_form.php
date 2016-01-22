<div class="box"> 
    <!--<div class="box_top"><b class="pl15">表单</b></div>-->
    <div class="box_center tableBox">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'user-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
        )); ?>
        <table class="tableForm " width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td class="td_label">登录手机* :</td>
                    <td class="">
                        <div style="display: inline;">
                            <?php if(!$official->isNewRecord):?>
                            <input id="mobileSerd" type="hidden" value="<?php echo $account->mobile; ?>" />
                             <?php endif; ?>
                            <?php echo $form->textField($account,'mobile',array('style'=>'width: 200px;','size'=>30,'maxlength'=>11,'datatype'=>'phone','nullmsg'=>'手机号不能为空！','errormsg'=>'手机号格式不正确')); ?>
                        </div>
                        <span class="Validform_checktip vTip"></span>
                        <span id="vTipId" class="Validform_checktip Validform_wrong" style="display: none;"></span>
                    </td>
                </tr>

                <tr>
                    <td class="td_label">公众号ID* :</td>
                    <td class="">
                        <div style="display: inline;">
                            <?php if(!$official->isNewRecord):?>
                                <span><?php echo $official->openid; ?></span>
                            <?php else:?> 
                                <?php echo $form->textField($official,'openid',array('style'=>'width: 200px;','size'=>30,'maxlength'=>10,'datatype'=>'zimusuzi','nullmsg'=>'ID号不能为空！','errormsg'=>'ID号为6-10位字符（英文、数字）组成')); ?> 
                                <span>&nbsp;&nbsp;一次设置，不可重复</span>
                            <?php endif; ?>
                        </div>
                        
                        <span class="Validform_checktip vTipOpenid"></span>
                        <span id="vTipOpenid" class="Validform_checktip Validform_wrong" style="display: none;"></span>
                        <?php echo $form->error($official,'openid'); ?>
                    </td>
                </tr>

                <tr>
                    <td class="td_label">公众号名称 * ：</td>
                    <td class="">
                        <div style="display: inline;">
                            <?php echo $form->textField($official,'openname',array('style'=>'width: 200px;','size'=>45,'maxlength'=>10,'datatype'=>'jigou','nullmsg'=>'机构名称不能为空！','errormsg'=>'名称为6-10位字符（英文、数字、中文）组成 ')); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                         <?php echo $form->error($official,'openname'); ?>
                    </td>
                </tr> 
                
                <tr> 
                    <td class="td_label" style="width:100px">公众号类型* ：</td>
                    <td class=""> 
                        <div style="display: inline;">
                            <select name="OfficialInfo[opentype]" style="width:150px;" datatype="*" nullmsg="公众号类型必须选择" id=" ">
                                <option value="2" <?php if($official->opentype==2){echo "selected";}?>>普通公众号</option>
                                <option value="1" <?php if($official->opentype==1){echo "selected";}?>>系统公众号</option>
                                
                            </select>      
                        </div>
                        <span class="Validform_checktip "></span>
                        <?php echo $form->error($official,'freqid'); ?>
                    </td>
                </tr>
                <tr> 
                    <td class="td_label">发送限制* ：</td>
                    <td class=""> 
                        <div style="display: inline;">
                            <?php if(!isset($official->freqid) && !$official->freqid) $official->freqid = 3; ?>
                            <?php echo $form->dropDownList($official,'freqid',SendFreq::getDataArr(),array( 'empty' => '--选择发送限制--','datatype'=>'*','nullmsg'=>'请选择发送限制!','errormsg'=>'')); ?>
                            <?php echo $form->error($official,'freqid'); ?>   
                        </div>
                        <span class="Validform_checktip "></span>
                        <?php echo $form->error($official,'freqid'); ?>
                    </td>
                </tr>

                <tr>
                    <td class="td_label">公众号头像 ：</td>
                    <td class=""> 
                        <!--div style="display: inline;">
                            <?php //echo $form->fileField($official,'logo',array('rel'=>'previewNew','onchange'=>'preview(this)')); ?>
                            <?php //echo $form->error($official,'logo'); ?>
                        </div>

                        <span class="Validform_checktip ">建议图片比例为120*120，仅支持JPG，PNG格式上传</span>
                        <div id="previewNew" class="preview_box"><img src="<?php //echo $official->logo; ?>"></div-->

                        <div class="userPic fleft " style="width:70px;height:70px;vertical-align: middle;text-align: center;border: 1px solid #DBDBDA;">
                            <img style="vertical-align: middle;max-width: 100%;" id="uploadImg" src="<?php echo $official->logo.'?imageView2/1/w/70/h/70'; ?>" onerror="javascript:this.src='<?php echo Yii::app()->request->hostInfo.'/image/xiaoxin/default_pic.jpg'; ?>'" /><i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                        </div>

                        <div class="userBtnBox" style="margin-left: 80px;">
                         <!--    <p>你可以选择一张png/jpg图片（180*180）作为头像</p>
                            <div id="filePopule">
                                <input type="file" name="Account[phototmp]" id="fileUserPic" class="btn" value="相册选择">
                            </div> -->
                            <div id="container" >
                                <p>仅支持JPG，PNG格式上传（180*180）</p>
                                <input type="hidden" id="domain" value="<?php echo STORAGE_QINNIU_XIAOXIN_TX; ?>">
                                <input type="hidden" id="uptoken_url"  value="<?php echo Yii::app()->request->baseurl;?>/index.php/ajax/gettoken?type=tx">
                                <a class="btn btn-default" id="pickfiles" href="#" >                                    
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <sapn>选择文件</sapn>
                                </a>
                            </div>
                            <input type="hidden" name="OfficialInfo[logo]" id="file_upload_tmp" value='<?php echo $official->logo; ?>'>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td class="td_label">公众号介绍* ：</td> 
                    <td class="">
                        <div style="display: inline;">
                            <?php echo $form->textarea($official,'summary',array('style'=>'width: 400px;','size'=>45,'maxlength'=>200,'datatype'=>'*1-200','nullmsg'=>'机构介绍不能为空！','errormsg'=>'机构介绍不能大于200个字')); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                        <?php echo $form->error($official,'summary'); ?>
                    </td>
                </tr>

                
                <tr>
                    <td class="td_label"></td>
                    <td class="">
                        <p style="height: 30px;"></p>
                        <?php echo CHtml::submitButton($official->isNewRecord ? '创 建' : ' 保 存 ',array('class'=>'btn btn-primary')); ?>
                    </td>
                 </tr> 
       </tbody></table>
       <?php $this->endWidget(); ?>
    </div> 

<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/main.css"> 
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/highlight/highlight.css">
<!--<link href="<?php //echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/uploadify/uploadify.css" rel="stylesheet" type="text/css"/>
<script src="<?php //echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/uploadify/jquery.uploadify.min.js?ver=<?php //echo rand(0,9999);?>" type="text/javascript"></script>-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/plupload/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/qiniu.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/highlight/highlight.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/main.js"></script>

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
            $('#user-form').Validform({//表单验证
                tiptype:2,
                showAllError:true,
                ignoreHidden:true,
                postonce:true,
                datatype:{//传入自定义datatype类型 ;
                    'phone': /^((1)+\d{10})$/,
                    'zimusuzi':/^[A-Za-z0-9]{6,10}$/,
                    'jigou':/^[\u4E00-\u9FA5A-Za-z0-9]{6,10}$/
                }
            });  
            var uid='<?php echo Yii::app()->user->id; ?>'; 
            updataLoadImg(uid);
        }); 
        $('#Account_mobile').keydown(function(){ 
              $('.vTip').show();
              $('#vTipId').hide(); 
        });
        $('#OfficialInfo_openid').keydown(function(){
              $('.vTipOpenid').show();
              $('#vTipOpenid').hide();
        }); 
        //手机触发
        $('#Account_mobile').focusout(function(){            
            var ajaxurlPhones ="<?php echo Yii::app()->createUrl('ajax/uniqueaccount');?>"; 
            var vale = $(this).val();
            var reg = /^((1)+\d{10})$/;
            var hidden =$('#mobileSerd').val();
            if(hidden != "" && vale != hidden){
                if(reg.test(vale)){
                  ajaxPostPhone(vale,ajaxurlPhones);
                }   
            } 
        });
        //id触发
         $('#OfficialInfo_openid').focusout(function(){
            var ajaxurlOpenid ="<?php echo Yii::app()->createUrl('ajax/uniqueofficial');?>";
            var vale = $(this).val();
            if(vale){
                ajaxPostOpenid(vale,ajaxurlOpenid);
            } 
        });
        //手机验证
        function ajaxPostPhone(val,ajaxurlPhone){
            $.ajax({  
                url:ajaxurlPhone,   
                type : 'POST',
                data:{mobile:val},
                dataType : 'text',
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {  
                    var show_data =$.parseJSON(mydata); 
                    if(show_data.state=='0'){
                        $('.vTip').show();
                    }else{
                        $('.vTip').hide();
                        $('#vTipId').show().text(val+' 该手机号已使用');
                        $('#Account_mobile').val('');
                    }
                },  
                error : function() {  
                   // $("#popupInfo").html("加载出错");  
                }  
            });
        } 

        //id验证
        function ajaxPostOpenid(val,ajaxurlOpenid){
            $.ajax({  
                url:ajaxurlOpenid,   
                type : 'POST',
                data:{openid:val},
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {   
                    var show_data =$.parseJSON(mydata);
                     if(show_data.state=='0'){
                         $('.vTipOpenid').show();
                     }else{
                        $('.vTipOpenid').hide();
                        $('#vTipOpenid').show().text(val+' 该公众号Id已存在');
                        $('#OfficialInfo_openid').val('');
                     }
                },  
                error : function() {  
                   // $("#popupInfo").html("加载出错");  
                }  
            });
        } 
</script>
</div> 