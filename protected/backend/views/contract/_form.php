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
            <input type="hidden" id="submitcon_input" name="submitcon" value=''>
            <thead></thead>
            <tbody>
                <tr>
                    <td class="td_label">合同名称* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->textField($model,'name',array('size'=>20,'maxlength'=>20,'datatype'=>'*','nullmsg'=>'合同名称不能为空！','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'name'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">所属商家* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('empty' => '--选择商家--','datatype'=>'*','nullmsg'=>'请选择商家！','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'bid'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 
                </tr>
                <tr>
                    <td class="td_label">合同编号* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->textField($model,'contractid',array('size'=>20,'maxlength'=>20,'datatype'=>'*','nullmsg'=>'合同编号不能为空！','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'contractid'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>
                
            </tbody>
            <tfoot></tfoot>
        </table> 
        <div id="contentTypeBox" style=" display: none; border: 1px solid #f1f1f1; padding: 0px; margin-top: 20px;"> 
            <div class="navCrumb">合作类型</div>
            <div id="contentBox" > 
            </div>
            <div style="padding: 20px 0;" ><a href="javascript:void(0);" class="addTtpe" style="margin:10px 95px;">增加合作类型</a></div>
        </div>
        <table class="tableForm">
            <tr>
                <td class="td_label"></td>
                <td> 
                    <p style="height: 20px;"></p>
                     <a class="btn btn-primary" href="javascript:void(0);" rel="submitForm" data-submitcon="0">创 建</a>&nbsp;&nbsp;&nbsp;&nbsp;
                     <a class="btn btn-primary" href="javascript:void(0);" rel="submitForm" data-submitcon="1">创建并提交</a>
                    <?php if(!$model->isNewRecord){ ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default" href="<?php echo Yii::app()->createUrl('adv/delete/'.$model->aid);?>">删 除</a>
                    <?php } ?> 
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span id="tipForm" style="display: none;"  class="Validform_checktip Validform_wrong" >请至少添加一个合作类型！</span> 
                </td> 
            </tr>
        </table>
        <?php $this->endWidget(); ?> 
    </div><!-- form -->
    <div id="popupViwe" style="overflow: hidden;">
        <div id="popupBoxViwe" class="popupBox" style="width:880px; margin-top: 0;">
            <div class="header">配置范围 <a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#popupBoxViwe')" > </a></div>
            <div id="popupInfo"  class="infoBox"  style="padding-left:20px; height: 620px; font-size: 12px; overflow: hidden;">
                <span class="Validform_checktip Validform_loading" > 正在加载数据...</span>
            </div>
        </div>
    </div>
</div>
<div id="popupViweWeb">
    <div id="popupBoxWeb" class="popupBox" style="margin-top: 0;">
        <div class="header">预 览 <a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#popupBoxWeb')" > </a></div> 
        <div id="popupInfoWeb"  style="padding: 10px; max-height: 530px; overflow-x: hidden; overflow-y: auto;" > 
             <span class="Validform_checktip Validform_loading" > 正在加载数据...</span> 
        </div> 
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script>
<script type="text/javascript">
$(function(){
    var myDate = new Date();
    var y = myDate.getYear(); //获取当前年份(2位)
    var yy =  myDate.getFullYear();//获取完整的年份(4位,1970-????)
    var m = myDate.getMonth()+1; //获取当前月份(0-11,0代表1月)
    var d = myDate.getDate(); //获取当前日(1-31) 
    var t = myDate.getTime(); //获取当前时间(从1970.1.1开始的毫秒数)
    var tm = myDate.getHours(); //获取当前小时数(0-23)
    var ts = myDate.getMinutes(); //获取当前分钟数(0-59)
    if(m<10){
        m ='0'+m;
    }
    if(d<10){
       d='0'+d; 
    }
    var dateTime = yy +'-'+ m + '-'+ d; //日期
    //表单验证
    var Valid = $('#business-form').Validform({
        tiptype:2,
        showAllError:true,
        ignoreHidden:true,
        //postonce:true,
        datatype:{//传入自定义datatype类型 ; 
            "tel-3" : /^(\d{3,4}-)?\d{7,8}$/
        },
        callback:function(data){ 
            var orderCunet = $("#contentBox").find('.orderBox').length;
            var databox = $("#contentBox").find(".inputDataBox");  
            var boxP =databox.length;
            var dataS = databox.find('.datainput').length; 
             if(orderCunet<1){
                $("#tipForm").show();
                return false;
            }else{
                var databox = $("#contentBox").find(".inputDataBox");  
                var boxP =databox.length;
                var dataS = databox.find('.datainput').length; 
                if(boxP==dataS && boxP>0){
                    $("[rel=submitForm]").attr("disabled","disabled");
                    return true;
                }else{  
                    return false;
                }
            }
        }
    });
    //创建并提交事件
    $("[rel=submitForm]").click(function(){ 
        var val = $(this).data('submitcon');
        var orderCunet = $("#contentBox").find('.orderBox').length;
        var databox = $("#contentBox").find(".inputDataBox");  
        var boxP =databox.length;
        var dataS = databox.find('.datainput').length; 
         if(orderCunet<1){ 
            //$("#tipForm").show(); 
        }else{
            var databox = $("#contentBox").find(".inputDataBox"); 
            var boxP =databox.length;
            var dataS = databox.find('.datainput').length; 
            if(boxP==dataS && boxP>0){  
            }else{  
                databox.each(function(e,v){
                    var o = $(this).data('order');
                    if($(this).find('.datainput').length<1){ 
                       $("#Tip_"+o).show(); 
                    } 
                }); 
            }
        } 
        if(val=="1"){
            $("#submitcon_input").val('1'); 
        }else{
            $("#submitcon_input").val(''); 
        } 
        Valid.resetStatus();
        $("#business-form").submit();
    });
    
    var regionValue = '';//记录区域 城市id
    var schoolValue = '';//记录学校 班级id
    
    var ajaxoptions = '';
    var ajaxoptionsurl = "<?php echo Yii::app()->createUrl('contract/getoptions');?>";
    var ajaxcontentsurl = "<?php echo Yii::app()->createUrl('contract/getcontent');?>";
    function ajaxGetOptions(bid,ty){//
        $.ajax({  
            url: ajaxoptionsurl,   
            type : 'POST',  
            data : {type:ty,bid:bid},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {   
                console.log(mydata);
                ajaxoptions = mydata;  
                // $(this).parents("table").append(str); 
            },  
            error : function() {  
                // alert("calc failed");  
            }  
        });
    }
    
//添加合作类型请求
function ajaxGetContent(order){//
    $.ajax({  
        url: ajaxcontentsurl,   
        type : 'POST',  
        data : {order:order},  
        dataType : 'text',  
        contentType : 'application/x-www-form-urlencoded',  
        async : false,  
        success : function(mydata) {
            //$("#contentBox").empty();
        	$("#contentBox").append(mydata); 
        },  
        error : function() {  
        }  
    });
} 
 var orderFlag = $("#contentBox").find('.orderBox').length;
//添加合作类型
$(document).on('click', ".addTtpe",function(){ 
    orderFlag += 1;
    ajaxGetContent(orderFlag);//添加合作类型请求
    $("#tipForm").hide();
});

//请求配置页面
ajaxranconurl = "<?php echo Yii::app()->createUrl('contract/rangeconfig');?>";
ajaxranconhtml = "";
function ajaxGetRangeConfig(order){//
    $.ajax({  
        url: ajaxranconurl,   
        type : 'POST',  
        data : {order:order},  
        dataType : 'text',  
        contentType : 'application/x-www-form-urlencoded',  
        async : false,  
        success : function(mydata) {   
            ajaxranconhtml = mydata;
            //alert(ajaxranconhtml);
            $("#popupViwe .popupBox .infoBox").html('');
            $("#popupViwe .popupBox .infoBox").html(ajaxranconhtml); 
        },  
        error : function() {  
        }  
    });
}

ajaxareaurl = "<?php echo Yii::app()->createUrl('range/cityarea');?>";
ajaxareahtml = "";
function ajaxGetArea(cid){//请求城市区域
    $.ajax({  
        url: ajaxareaurl,   
        type : 'POST',  
        data : {cid:cid},  
        dataType : 'text',  
        contentType : 'application/x-www-form-urlencoded',  
        async : false,  
        success : function(mydata) {   
            ajaxareahtml = mydata;
        },  
        error : function() {  
        }  
    });
}

ajaxgradeurl = "<?php echo Yii::app()->createUrl('range/schooltypegrade');?>";
ajaxgradehtml = "";
function ajaxGetGrade(stid){//请求学校年纪
    $.ajax({  
        url: ajaxgradeurl,   
        type : 'POST',  
        data : {stid:stid},  
        dataType : 'text',  
        contentType : 'application/x-www-form-urlencoded',  
        async : false,  
        success : function(mydata) {   
            ajaxgradehtml = mydata;
        },  
        error : function() {  
        }  
    });
} 

//删除合作类型
$(document).on('click','[rel=dedelConType]',function(){
    var orderV = $(this).data('order');
    $('#orderBox_con_'+orderV).remove();
});

//获取配置页面
$(document).on('click','[rel=range_config]',function(){
    var order = $(this).data('order');
    var contype = $("#con_type_"+order).find('option:selected').val();
    var conitem = $("#con_item_"+order).find('option:selected').val();
    regionValue = '';
    schoolValue = '';
    if(contype=="adv"){
       $(this).siblings(".con_itemTip").text("请选择相应的广告!"); 
    }else{
       $(this).siblings(".con_itemTip").text("请选择相应的热点!");
    }
    if(conitem){ 
        $(this).siblings(".con_itemTip").hide();
        showPromptsIfonWeb("#popupBoxViwe");
        ajaxGetRangeConfig(order);
        if(contype!="adv"){
            $('#detail_location_Box_'+order).hide();
        }
    }else{ 
        $(this).siblings(".con_itemTip").show();
    }  
    
}); 

// 选择商家清空合作类型
$("#Contract_bid").change(function(){
   $("#tipForm").hide();
   $(".orderBox").remove();
   orderFlag = 0;
   var val = $(this).find('option:selected').val();
    $(".resultView").empty();
    $(".inputDataBox").empty();
    $("[rel=con_type]").val("");
    $("[rel=con_item]").empty();
   if(val){
       $("#contentTypeBox").show();
   }else{
       $("#contentTypeBox").hide();
   }
    ajaxGetContent(orderFlag); 
   $(".range_config_box").hide();
}); 

//选择合作类型
 $(document).on('change',"[rel=con_type]" ,function(){ 
	var bid = $("#Contract_bid").val();
	var order = $(this).attr('order');
	var type = $(this).val();
    var text = $(this).find('option:selected').text();
    $("#resultView_"+order).hide(); 
    $("#resultView_"+order).empty();
    $("#databox_"+order).empty();
    $("#con_item_"+order).parent().siblings(".con_itemTip").hide();
    var foption ='<option value="">--请选择'+text+'--</option>';
	if(bid){
        if(type){
            ajaxGetOptions(bid,type);
            $("#con_item_"+order).empty();
            $("#con_item_"+order).append(foption+ajaxoptions);
            if(type=="info"){ 
                var inputTime ='<span>起始时间：</span><input name="ConType['+order+'][contype]" type="hidden" value="'+type+'"><input nid ="mationTime" rel="dataeinput" name="ConType['+order+'][sdate]" type="text" class=" "  style="width:120px;" value="">';
                $("#informationBox_"+order).append(inputTime).css('display','inline-block');
                $("#config_"+order).hide();
                $("input[nid='mationTime']").datebox({
                    value:dateTime,
                    showSeconds: false
                });
                $(".combo-text").attr({readonly:'readonly',rel:'textDatetime'});
            }else{
               $("#databox_"+order).empty();
               $("#config_"+order).show();
               $("#informationBox_"+order).empty().hide();
            }      
            $(".range_config_box_"+order).show(); 
            $(".range_config_box_"+order).find("[rel=viewWebStyle]").text("预览"+text);
        }else{
            $("#con_item_"+order).empty();
            $("#con_item_"+order).append(foption);
            $(".range_config_box_"+order).hide();
        } 
	}else{
		alert("请选择商家");
	}
	
});
//选择内容
$(document).on('change','[rel=con_item]',function(){
   var order = $(this).data('order');
   var tid = $(this).find('option:selected').val();
   $(this).parent().siblings(".con_itemTip").hide();
   $("#resultView_"+order).hide(); 
   $("#resultView_"+order).empty(); 
   $("#databox_"+order).empty();
   var type = $("#con_type_"+order).find('option:selected').val();
   if(type=="info"){ 
       $("#Tip_"+order).hide();
       $("#databox_"+order).append('<input name="ConType['+order+'][objid]" type="hidden" value="'+tid+'"><div class="datainput" style="display:none;"></div>');
       $("#tipForm").hide();
   }
}); 
    //弹框 配置范围 处理 js
    //选择城市
    $("[rel=detail_city]").live('click',function(){
        var cid = $(this).data('value');
        $(this).siblings('a').removeClass("check");
        $(this).addClass("check");
        ajaxGetArea(cid);
        $("[rel=detail_city_area]").show();
        $("[rel=detail_city_area]").html(ajaxareahtml); 
    });
    //学校性质
    $("[rel=detail_schooltype]").live('click',function(){
        var stid = $(this).data('value');
        $(this).siblings('a').removeClass("check");
        $(this).addClass("check");
        ajaxGetGrade(stid);
        $("[rel=detail_schooltype_grade]").show();
        $("[rel=detail_schooltype_grade]").html(ajaxgradehtml); 
    });
   
    //选择区域
    $(document).on('click','.itmeRegion',function(event){ 
        event.preventDefault();
        var dtaval = $(this).data('value') , textinfo = $(this).text(),cityName = $(this).data('city');
        if(regionValue.indexOf(dtaval,',') > -1){ 
        }else{
            if(dtaval==''){ 
            }else{
                 regionValue+=dtaval+',';
            } 
            var srt = '<li>'+ textinfo+' - '+ cityName +'<a href="javascript:void(0);" class="closeIoc closeRegion" data-value="'+dtaval+ '" rel="'+dtaval +'"></a></li>';
            $(this).parent('.regionBox').siblings('div').find('.checkRegionBox ul').append(srt);
        }
        $("#findResultBox").hide();
        $("#query_result").empty();
        $('[rel=contype_query]').removeAttr("disabled");
        event.stopPropagation();
    });
    //选择年级
    $(document).on('click','.itmeSchool',function(event){
        event.preventDefault();
        var dtaval = $(this).data('value') , textinfo = $(this).text(),schoolName = $(this).data('school');
        if(schoolValue.indexOf(dtaval,',') > -1){ 
        }else{
            if(dtaval==''){ 
            }else{
                schoolValue+= dtaval+','; 
            }
            var srt = '<li>'+textinfo +' - '+ schoolName +'<a href="javascript:void(0);" class="closeIoc closeSchool" data-value="'+dtaval+ '" rel="'+ dtaval +'"></a></li>';
            $(this).parent('.schoolclassBox').siblings('div').find('.checkSchoolclassBox ul').append(srt);
            $("#findResultBox").hide();
            $("#query_result").empty();
            $('[rel=contype_query]').removeAttr("disabled");
        } 
    });
    //删除选中区域 
    $(document).on('click','.closeSchool',function(){
        var itmeVal = $(this).data('value');
        $(this).parent('li').remove();
        s = schoolValue.replace(itmeVal+',',"");
        schoolValue = s; 
        $("#findResultBox").hide();
        $("#query_result").empty();
        $('[rel=contype_query]').removeAttr("disabled");
    });
    //删除选中年级
    $(document).on('click','.closeRegion',function(){
        var itmeVal = $(this).data('value');
        $(this).parent('li').remove();
        var s = regionValue.replace(itmeVal+',',"");
        regionValue = s;
        $("#findResultBox").hide();
        $("#query_result").empty();
        $('[rel=contype_query]').removeAttr("disabled");
    });
    //城市区域全选
    $(document).on('click','.cityAll',function(){
        var dataV1 = $(this).data('value');
        $(this).parent('.regionBox').find('a[rel="'+ dataV1 +'"]').click();
        $('[rel=contype_query]').removeAttr("disabled");
    });
    //学校班级全选
    $(document).on('click','.schoolAll',function(){
        var dataV2 = $(this).data('value');
        $(this).parent('.schoolclassBox').find('a[rel="'+ dataV2 +'"]').click();
        $("#findResultBox").hide();
        $("#query_result").empty();
        $('[rel=contype_query]').removeAttr("disabled");
    });
    
  
    //获取配置查询结果页面
    $(document).on('click','[rel=contype_query]',function(){
        var order = $(this).data('order'); 
        var business = $("#Contract_bid").find('option:selected').val();
        var contype = $("#con_type_"+order).find('option:selected').val();
        var objid = $("#con_item_"+order).find('option:selected').val();// 
        var sdate = $("[name='stime']").val();  
        var edate = $("[name='etime']").val();
        var location ="";
        if(contype=="adv"){
            var location = $("#detail_location_"+order).find('option:selected').val(); 
        }else{
            location=" ";  
        }
        var region = regionValue.substring(0,regionValue.length-1);
        var schools = schoolValue.substring(0,schoolValue.length-1);
        var areas = region;
        var grades = schools;
        if(sdate==""||edate == ""){
            alert("请选择起止时间！");
        }else{ 
            if(location==""){
                alert("请选择广告位置");
            }else{
               if(areas==""||grades==""){
                   alert("请选择广告区域和学校年级！");
               }else{
                   $("#query_result").html('<span class="Validform_checktip Validform_loading" > 正在加载数据...</span>');
                   $(this).attr("disabled","disabled");
                   $("#findResultBox").show();
                  ajaxQueryConfig(order,sdate,edate,location,areas,grades,business,contype,objid); 
               }
           }  
        } 
        //alert(sdate +"---"+ edate +"---"+ location +"---"+ areas +"---"+ grades +"---"+ business +"---"+ contype +"---"+ objid);    
    });
    //查询结果
    ajaxqueryurl = "<?php echo Yii::app()->createUrl('contract/query');?>";
    ajaxqueryhtml = "";
    function ajaxQueryConfig(order,sdate,edate,location,areas,grades,business,contype,objid){ 
        $.ajax({  
            url: ajaxqueryurl,   
            type : 'POST',  
            data : {order:order,sdate:sdate,edate:edate,location:location,areas:areas,grades:grades,business:business,contype:contype,objid:objid},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : true,  
            success : function(mydata) {   
                ajaxqueryhtml = mydata; 
                $("#query_result").empty(); 
                $("#query_result").append(ajaxqueryhtml); 
            },  
            error : function() {  
            }  
        });
    }
    //选择学校 年级  可用广告
    //var myObject = eval('(' + myJSONtext + ')'); 
    $(document).on('change','input[rel=allCheck]',function(){
        var parentBox = $(this).parents('tr.check'); 
        if($(this).attr("checked")){ 
            parentBox.find('.color1').append('<span></span>'); 
            parentBox.find('input.allCheck').attr("checked","true"); 
        }else{
            parentBox.find('input.allCheck').attr('checked', false);
            parentBox.find('.color1').find('span').remove(); 
        } 
    });
    //选择学校 年级  部分可用广告
    $(document).on('change','input[rel=partCheck]',function(){ 
        var parentBox = $(this).parents('tr.check');
        if($(this).attr("checked")){ 
            parentBox.find('.color2').append('<span></span>');
            parentBox.find('input.partCheck').attr("checked",true); 
        }else{
            parentBox.find('input.partCheck').attr('checked', false);
            parentBox.find('.color2').find('span').remove();
        }
        
    });
    //选择全部学校 年级  部分可用广告
    $(document).on('change','input[rel=partCheckBox]',function(){ 
        var parentBox = $('input.partCheck');
        if($(this).attr("checked")){  
            $('input[rel=partCheck]').attr('checked',true);
            parentBox.parent('.color2').append('<span></span>');
            parentBox.attr("checked",true); 
        }else{
            $('input[rel=partCheck]').attr('checked',false);
            parentBox.attr('checked', false);
            parentBox.parent('.color2').find('span').remove();
        }
    });
     //选择全部学校 年级 可用广告
    $(document).on('change','input[rel=allCheckBox]',function(){ 
        var parentBox = $('input.allCheck');
        if($(this).attr("checked")){  
            $('input[rel=allCheck]').attr('checked',true);
            parentBox.parent('.color1').append('<span></span>');
            parentBox.attr("checked",true); 
        }else{
            $('input[rel=allCheck]').attr('checked',false);
            parentBox.attr('checked', false);
            parentBox.parent('.color1').find('span').remove();
        }
    });
    //热点学校全选
    $(document).on('change','input[rel=allFocCheckBox]',function(){
        if($(this).attr("checked")){  
            $('input[rel=schoolFocCheck]').attr('checked',true); 
        }else{
            $('input[rel=schoolFocCheck]').attr('checked',false); 
        }
    }); 
   //热点保存数据 
    $(document).on('click','[rel=severFocData]',function(){ 
        var order = $(this).data('order');
        var sdate = $("[name='stime']").val();  
        var edate = $("[name='etime']").val();
        var location = $("#detail_location_"+order).find('option:selected').val();
        var locationText = $("#detail_location_"+order).find('option:selected').text();
        var contype = $("#con_type_"+order).find('option:selected').val();
        var objid = $("#con_item_"+order).find('option:selected').val(); 
        var ids = $("#grade_ids").val();
        var inputItme = $("#tab_box_"+order);
        var schoolIdList = inputItme.find('input[rel="schoolFocCheck"]:checked');
        var schoolId = '',count = 0,personCount = 0; 
        schoolIdList.each(function(index, el) { 
           var iSid = $(this).data('sid');
           var person = $(this).attr('person');
           if(schoolId.indexOf(iSid,',') > -1){
           }else{
                schoolId += iSid+ ',';
                personCount = parseInt(personCount)+ parseInt(person);
                count++;
           } 
        }); 
        schoolId = schoolId.substring(0,schoolId.length-1);
        var  sId = '<input name="ConType['+order+'][school_ids]" type="checkbox" value="'+schoolId+'" checked="checked" />';
        var pkPt = '<input type="hidden" name="ConType['+order+'][sdate]" value="'+sdate+'">'
                +'<input type="hidden" name="ConType['+order+'][edate]" value="'+edate+'">'
                +'<input type="hidden" name="ConType['+order+'][location]" value="'+location+'">'
                +'<input type="hidden" name="ConType['+order+'][contype]" value="'+contype+'">'
                +'<input type="hidden" name="ConType['+order+'][objid]" value="'+objid+'">'
                +'<input type="hidden" name="ConType['+order+'][grade_ids]" value="'+ids+'">';
        var resultPt ="";
         if(count){
            resultPt= '<p><span>投放时间：</span>'+sdate+'至 '+ edate + '</p>' 
                        +'<p><span>推广范围：</span>已选择共'+ count +'所学校 约'+ personCount +'位用户</p>';
            $("#databox_"+order).empty();
            $("#databox_"+order).append('<div class="datainput" style="display:none;">'+ pkPt + sId +'</div>'); 
            $("#Tip_"+order).hide();
        }else{
            resultPt ='<p id="Tip'+order+'">请重新配置范围</p>';
        }
        $("#resultView_"+order).show();
        $("#resultView_"+order).empty();
        $("#resultView_"+order).append(resultPt);
        hidePormptMask('popupBox');
        
    });
    
    //广告保存数据 
    $(document).on('click','[rel=severData]',function(){
        var order = $(this).data('order');
        var sdate = $("[name='stime']").val();  
        var edate = $("[name='etime']").val();
        var location = $("#detail_location_"+order).find('option:selected').val();
        var locationText = $("#detail_location_"+order).find('option:selected').text();
        var contype = $("#con_type_"+order).find('option:selected').val();
        var objid = $("#con_item_"+order).find('option:selected').val(); 
        var inputItme = $("#tab_box_"+order);
        var schoolIdList = inputItme.find('input.schoolCheck:checked');
        var list =  inputItme.find('input[rel="classId"]:checked');
        var schoolId ='';
        var li =''; 
        var count = 0;
        var personCount = 0;
        schoolIdList.each(function(index, el) { 
           var iSid = $(this).data('sid');
           var flags =inputItme.find('input[sid=sid_'+iSid+']:checked').length;
           if(schoolId.indexOf(iSid,',') > -1){
           }else{
                if(flags){
                    //alert(flags);
                    schoolId += iSid+ ',';
                    count++;
                }
           } 
        });
        list.each(function(index, el) { 
           var ival = $(this).attr('value');
           var person =$(this).attr('person');
           if(ival){
                li += ival+ ','; 
                personCount = parseInt(personCount)+ parseInt(person);
           } 
        }); 
        if(li){
            li = li.substring(0,li.length-1);
            var  sCId = '<input name="ConType['+order+'][result]" type="hidden" value="'+li+'" />';
        }
        schoolId =schoolId.substring(0,schoolId.length-1); 
        var  sId = '<input name="ConType['+order+'][school_ids]" type="hidden" value="'+schoolId+'"/>'; 
        var pkPt ='<input type="hidden" name="ConType['+order+'][sdate]" value="'+sdate+'">'
                +'<input type="hidden" name="ConType['+order+'][edate]" value="'+edate+'">'
                +'<input type="hidden" name="ConType['+order+'][location]" value="'+location+'">'
                +'<input type="hidden" name="ConType['+order+'][contype]" value="'+contype+'">'
                +'<input type="hidden" name="ConType['+order+'][objid]" value="'+objid+'">'; 
        var resultPt ="";
        if(count){
            resultPt= '<p><span>投放时间：</span>'+sdate+'至 '+ edate + '</p>'
                        +'<p><span>位置：</span>' + locationText + '</p>'
                        +'<p><span>推广范围：</span>已选择共'+ count +'所学校 约'+ personCount +'位用户</p>';
            $("#databox_"+order).empty();
            $("#databox_"+order).append('<div class="datainput" style="display:none;">'+ pkPt + sCId + sId +'</div>');
            $("#Tip_"+order).hide();
        }else{
            resultPt ='<p id="Tip'+order+'">请重新配置范围</p>';
        }
        $("#resultView_"+order).empty();
        $("#resultView_"+order).show(); 
        $("#resultView_"+order).append(resultPt);
        hidePormptMask('popupBox'); 
    });
    
    //请求 热点  内容 详情
    function ajaxGetWebInfo(ajaxoptionsurl,rid,ty){//
        $.ajax({  
            url: ajaxoptionsurl,   
            type : 'POST',  
            data : {ty:ty,tid:rid},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {  
                ajaxoptions = mydata;  
               $("#popupInfoWeb").append(ajaxoptions); 
            },  
            error : function() {   
            }  
        });
    }
    // 查看广告 热点  内容
    $(document).on('click','[rel=viewWebStyle]',function(){
        var order = $(this).data('order'),dataUrl = $(this).data('href');
        var avdFocId = $("#con_item_"+order).find('option:selected').val(); 
        if(avdFocId){
             var type = $("#con_type_"+order).find('option:selected').val();
            $("#popupInfoWeb").empty();
            ajaxGetWebInfo(dataUrl,avdFocId,type);
            showPromptsIfonWeb('#popupBoxWeb');
        }else{
            $("#popupInfoWeb").empty();
            $("#popupInfoWeb").append('<h3 style="text-align: center;margin-top:30px;">请选择相应的内容</h3>');
            showPromptsIfonWeb('#popupBoxWeb');
        } 
    });
    //优化广告
    $(document).on('change','[rel=detail_location],input[rel=textDatetime],input[name=etime]',function(){ 
         $("#findResultBox").hide();
         $("#query_result").empty();
         $('[rel=contype_query]').removeAttr("disabled");
    });
//    $(document).on('click','.itmeSchool ,input[rel=textDatetime],input[name=etime]',function(){ 
//         $("#findResultBox").hide();
//         $("#query_result").empty();
//    });
}); 
 
</script>