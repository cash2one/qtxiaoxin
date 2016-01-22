<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/ajaxfileupload.js"></script>
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
                <?php if(!$model->isNewRecord): ?>
                <tr>
                    <td class="td_title_Long">出售状态 ：</td>
                    <td>
                        <?php echo MallGoodsCard::getCardSoldState($model->sold);?>
                    </td> 
                </tr>
                <tr>
                    <td class="td_title_Long">使用状态 ：</td>
                    <td>
                        <?php echo MallGoodsCard::getCardStateName($model->state);?>
                    </td> 
                </tr>
                <?php endif; ?>
                 <?php if($model->isNewRecord): ?>
                <tr>
                    <td class="td_title_Long">所属商家* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(true),array('empty' => '--选择商家--','datatype'=>'*','nullmsg'=>'请选择商家！','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'bid'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 
                </tr>
                <tr>
                    <td class="td_title_Long">所属商品* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->dropDownList($model,'mgid',MallGoods::getDataArr('card'),array('empty' => '--选择商品--','datatype'=>'*','nullmsg'=>'请选择商品！','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'mgid'); ?>
                        </div>
                        <span id="Validform_mgid" class="Validform_checktip "></span>
                    </td> 
                </tr>
                <?php else:?>
                <tr>
                    <td class="td_title_Long">所属商家* ：</td>
                    <td><?php echo Business::getBusinessName($model->mg->bid);?></td>
                </tr>
                <tr>
                    <td class="td_title_Long">所属商品* ：</td>
                    <td><?php echo MallGoods::getMallGoodsName($model->mgid,'card');?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td class="td_title_Long">有效起始时间*：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textField($model,'starttime',array('readonly'=>'readonly',"onclick"=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss"})','style'=>'width: 180px; height:auto;','datatype'=>'*','nullmsg'=>'起始时间不能为空!','errormsg'=>'输入的时间有误！','class'=>'Wdate','rel'=>'stime')); ?>
                            <?php echo $form->error($model,'starttime'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>
                <tr>
                    <td class="td_title_Long">有效结束时间*：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textField($model,'endtime',array('readonly'=>'readonly',"onclick"=>'WdatePicker({dateFmt:"yyyy-MM-dd HH:mm:ss"})','style'=>'width: 180px; height:auto;','datatype'=>'*','nullmsg'=>'结束时间不能为空!','errormsg'=>'输入的时间有误！','class'=>'Wdate','rel'=>'etime')); ?>
                            <?php echo $form->error($model,'endtime'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>
                
                <tr style="<?php if(!$model->isNewRecord){ echo 'display:none;'; }?> ">
                    <td class="td_title_Long">创建方式*：</td>
                    <td>
	                    <div style="display: inline;"> 
		                    <select id="MallGoodsCard_create_type" name="create_type">
		                    	<option value='1'>单个导入</option>
		                    	<option value='2'>批量导入</option>
		                    	<option value='3'>自动生成</option>
		                    </select>
		                </div>
		                <span class="Validform_checktip "></span>
                    </td>
                </tr> 
            </tbody>
            <tfoot></tfoot>
        </table> 
        <div <?php if($model->isNewRecord){echo 'id ="createBox_1" class="createBox" style="display: block;"';}?> > 
            <table class="tableForm">
                <thead></thead>
                <tbody>
                    <tr>
                        <td class="<?php if($model->isNewRecord){echo 'td_label';}else{ echo 'td_title_Long';}?>">虚拟卡号*：</td>
                        <td>
                            <div style="display: inline;">
                                <?php echo $form->textField($model,'number',array('datatype'=>'car','nullmsg'=>'请输入卡号！','errormsg'=>'卡号由1~15位字符组成（数字、字母），区分大小写！')); ?>
                                 <?php if($model->isNewRecord): echo '<span class="remind">输入卡号后，请点击确定完成导入！</span>'; endif; ?> 
                            </div> 
                            <?php echo $form->error($model,'number'); ?>
                            <span id="Validform_r"  class="Validform_checktip "></span>
                            <span id="Validform_ajx" class="Validform_checktip" style=" display: none;"></span>
                            <p style="color:#777777;">卡号由1~15位字符组成（数字、字母），区分大小写</p>
                            <input id="rightOrWrong" type="hidden" value="1">
                        </td>
                    </tr> 
                </tbody>
                <tfoot></tfoot>
            </table>
        </div>
        <div id="createBox_2" class="createBox" > 
            <table class="tableForm">
               <thead></thead>
               <tbody>
                   <tr>
                       <td>
                            <div class="fileBox box_file" style="display: inline;" >
                               <input id="fileXls" class="file" nullmsg="请上传文件！"  errormsg=""  name="batchfile" rel="fileName" type="file" onchange="addfile(this)" datatype="*" >
                                 批量导入 
                           </div>
                           <span id="Validform_file"  class="Validform_checktip ">&nbsp;&nbsp;<a  href="<?php echo Yii::app()->createUrl('gcard/export');?>">下载格式模版 </a></span>
                           <input type="hidden" id="fileChecktip" value="0" />
                           <span id="Validform_filed" style="display: none;"  class="Validform_checktip Validform_wrong">请选择文件</span>
                       </td>
                       <td> 
                       </td>
                   </tr>
                   <tr>
                       <td class="fileNamebox" style=" padding-top: 15px; display: none;">
                           <span id="upfileloading" class="Validform_checktip Validform_loading" >正在验证数据...</span>
                           <div id="result"></div>
                       </td>
                       <td> 
                       </td>
                   </tr> 
                    </tbody>
               <tfoot></tfoot>
           </table>
        </div>
        <div id="createBox_3" class="createBox" > 
            <table class="tableForm">
               <thead></thead>
               <tbody>
                   <tr>
                       <td class="td_label">生成数量*：</td>
                       <td>
                           <div style="display: inline;">
                               <input style="width: 150px;" type="text" name="create_num" value="" datatype="nZ" nullmsg="不能为空！" errormsg="只能输入正整数！" >
                               <span class="remind">输入数量后，请点击确定完成导入！</span>
                           </div>
                           <span class="Validform_checktip "></span>
                       </td>
                   </tr>
                    </tbody>
               <tfoot></tfoot>
           </table>
        </div>
        <table class="tableForm">
            <thead></thead>
            <tbody>
                <tr>
                    <td class="td_title_Long"></td>
                    <td>
                        <p style="height: 30px;"></p> 
                        <a href="javascript:void(0);" class="btn btn-primary" rel="postFrom"><?php if($model->isNewRecord){ echo '确  定'; }else {echo '保 存';}?></a>
                        <input type="hidden" id="mgcid" value="<?php echo $model->mgcid; ?>">
                        <?php //echo CHtml::submitButton($model->isNewRecord ? '确 定' : '保 存',array('class'=>'btn btn-primary')); ?>
                        <?php if(!$model->isNewRecord){ ?> 
                             &nbsp;&nbsp;<a class="btn btn-default" href="<?php echo Yii::app()->createUrl('gcard/delete/'.$model->mgcid);?>"> 删 除 </a>
                        <?php } ?>  
                    </td> 
                </tr>
            </tbody>
            <tfoot></tfoot>
        </table> 
        <?php $this->endWidget(); ?> 
    </div><!-- form --> 
 </div>
<script type="text/javascript"> 
var Valid = $('#business-form').Validform({//表单验证
    tiptype:2,
    showAllError:true,
    ignoreHidden:true,
    postonce:true,
    datatype:{//传入自定义datatype类型 ; 
        "tel-3" : /^(\d{3,4}-)?\d{7,8}$/,
        "car"   : /^[0-9a-zA-Z]{1,15}$/,
        "nZ"    : /^(0|[1-9][0-9]*)$/
    },
    callback:function(data){ 
        if($('#rightOrWrong').val()== '0'){
            return false;
        }else{ 
            if($("#MallGoodsCard_create_type").find('option:selected').val()=="2"){
                if($('#usefullInput').val()=="1"){ 
                   alert("请重新选择有效数据文件上传！");
                   return false; 
                }else{ 
                  $('[rel=postFrom]').attr('disabled','disabled');
                    return true;
                } 
            }else{
                $('[rel=postFrom]').attr('disabled','disabled');
                return true; 
            } 
        }
    }
}); 

 //选择商家 请求该商家的所有商品
 ajaxgoodsurl = "<?php echo Yii::app()->createUrl('range/goodlist');?>";
$("#MallGoodsCard_bid").change(function(){
	var bid = $(this).find('option:selected').val();
    var default_option = '<option value="">--选择商品--</option>';
    $('#Validform_mgid').find('span').removeClass().text('');
    $('#Validform_mgid').find('span').addClass("Validform_checktip");
	$.ajax({  
        url: ajaxgoodsurl,   
        type : 'POST',  
        data : {bid:bid},  
        dataType : 'text',  
        contentType : 'application/x-www-form-urlencoded',  
        async : false,  
        success : function(mydata) {
            $("#MallGoodsCard_mgid").empty(); 
            var html = default_option + mydata;
        	$("#MallGoodsCard_mgid").append(html); 
            $('#result').empty(); 
            $("#fileChecktip").val(0);
            $("#Validform_file").find('span').remove();
        },  
        error : function() {  
        }  
    });
});
var goodsid ="" ;
//根据商品选商家 
ajaxbidurl = "<?php echo Yii::app()->createUrl('range/goodbid');?>";
$("#MallGoodsCard_mgid").change(function(){ 
	goodsid = $(this).find('option:selected').val(); 
	if(goodsid){
		$.ajax({  
            url: ajaxbidurl,   
            type : 'POST',  
            data : {mgid:goodsid},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {
            	 $("#MallGoodsCard_bid option[value="+ mydata +"]").attr("selected","selected");
                 $('#MallGoodsCard_bid').blur();
                 $('#result').empty();
                 $("#fileChecktip").val(0);
                 $("#Validform_file").find('span').remove();
                 if($('#MallGoodsCard_number').val()){
                    $('#MallGoodsCard_number').blur(); //判断卡号是否可用
                 } 
            }, 
            error : function() {  
            }  
        });
	}
});
//卡号验证是否可用
var ajaxurl = "<?php echo Yii::app()->createUrl('gcard/checknum');?>";
$('#MallGoodsCard_number').blur(function(){
    var bid = $('#MallGoodsCard_mgid').find('option:selected').val();
    var code =$(this).val();
    var mgcid = $("#mgcid").val();
    if(bid && code){
        $('#Validform_r').hide();
        $('#Validform_ajx').removeClass('Validform_wrong');
        $('#Validform_ajx').addClass('Validform_loading').text('正在加载数据..').show();
        $.ajax({  
            url: ajaxurl,   
            type : 'POST',  
            data : {bid:bid,code:code,mgcid:mgcid},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',
            async :false,  
            success : function(mydata) { 
                if(mydata<=0){
                    $('#rightOrWrong').val(1); 
                    $('#Validform_r').show();
                    $('#Validform_ajx').hide();
                    //$('#Validform_r').find('.Validform_checktip').addClass('Validform_right').text('该卡号可以使用');
                }else{ 
                    $('#rightOrWrong').val(0);
                    $('#Validform_r').hide();
                    $('#Validform_ajx').removeClass('Validform_loading');
                    $('#Validform_ajx').addClass('Validform_wrong').text('该卡号已经被使用').show();
                }
            },  
            error : function() { 
            }  
        });
    }
});

//提示
$('select[name=create_type]').change(function(){
    var Val = $(this).find('option:selected').val();
    $('.createBox').hide();
    $("#createBox_"+Val).show();
});
//切换创建方式
var typeVal = $('select[name=create_type]').find('option:selected').val();
if(typeVal){//创建方式初始化
    $('.createBox').hide();
    $("#createBox_"+typeVal).show();
}//
//文件上传  
function ajaxFileUpload(){
    var ajaxurlUpload = '<?php echo Yii::app()->createUrl('gcard/upload');?>'+'?bid='+goodsid;
    $('#result').empty();
    $.ajaxFileUpload({
        url:ajaxurlUpload ,//需要链接到服务器地址
        secureuri:false,
        fileElementId:'fileXls',//文件选择框的id属性
        dataType: 'text', //服务器返回的格式，可以是json
        success: function (data, status) { //相当于java中try语句块的用法 
            $('#result').html(data);
            $('#upfileloading').hide(); 
            $("#fileChecktip").val(1);
            $('[rel=postFrom]').removeAttr('disabled'); 
        },
        error: function (data, status, e) {//相当于java中catch语句块的用法 
            $('#result').html("上传出错！");
            $('#upfileloading').hide();
            $('[rel=postFrom]').removeAttr('disabled');
        }
    }); 
}
//预览文件
function addfile(file){ 
    if(goodsid){ 
        var size = file.size / 1024;
        if(size>10){
            alert("附件不能大于10M");
        }else{ 
            var filepath = file.value;  
            var re = /(\\+)/g; 
            var filename = filepath.replace(re,"#"); 
            var one=filename.split("#"); 
            var two=one[one.length-1]; 
            var three=two.split("."); 
            var last=three[three.length-1]; 
            var tp ="xls,xlsx";
            var rs=tp.indexOf(last); 
            if(rs>=0){
                if (file.files && file.files[0]){
                    $("#Validform_filed").hide();
                    ajaxFileUpload();
                    $('.fileNamebox').show();
                    $('#upfileloading').show();
                    $('[rel=postFrom]').attr('disabled','disabled');
                }else {  
                    //prevDiv.innerHTML = perHtml; 
                }
            }else{
                file.value = '';
                //prevDiv.innerHTML = perHtml;
                alert("您选择的上传文件不是有效的excel文件！");
                return false;
            }
        }
    }else{
      file.value = '';
      alert("请先选择所属商品!");
    } 
}
//ie判断 文件上传方式
if ((navigator.userAgent.indexOf('MSIE') >= 0)){  
     $(".box_file").empty();
     $(".box_file").removeClass('fileBox');
     $('.box_file').append('<input id="fileXls" rel="fileName" nullmsg="请上传文件！"  errormsg="" name="batchfile" style="width:auto;" type="file" onchange="addfile(this)" datatype="*" >');
}
 
//表单提交
$('[rel=postFrom]').click(function(){
    if($("#fileChecktip").val()=='1'){
         Valid.ignore("#fileXls"); 
    }else{
         Valid.unignore("#fileXls"); 
         $("#Validform_filed").show();
    }
    Valid.resetStatus(); 
    $("#business-form").submit(); 
});
 
</script>