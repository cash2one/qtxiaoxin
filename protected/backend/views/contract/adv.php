<!-- 广告位查询 -->
<div class="box">
    <div style="border: 1px solid #f1f1f1; padding: 0px; margin-top: 20px;">
        <div class="navCrumb">广告位查询</div> 
        <div class="box">
            <form>
                <table class="tableForm">
                    <tr>
                       <td class="td_label">日 期* ：</td> 
                       <td class="dateBox"> 
                           <input rel="dataeinput" id="stime_1" name="stime" type="text" style="width:120px;" value=""> 
                           <span>&nbsp;至 &nbsp;</span> 
                           <input rel="dataeinput" type="text" id="etime_1" name="etime" style="width:120px;" value=""> 
                        </td> 
                    </tr>
                    <tr> 
                       <td>位 置* ：</td>
                       <td>
                            <select name="location" id="detail_location_1" rel="detail_location">
                                <option value="">--选择类型--</option>
                                <?php foreach(AdvertisementLocation::getLoactionArr() as $tk=>$t){ ?>
                                   <option value="<?php echo $tk; ?>"><?php echo $t; ?></option>
                                <?php } ?>
                            </select>
                        </td> 
                    </tr> 
                   <tr class="search_condition_tab_region"> 
                        <td class="td_label">区 域* ：</td>
                        <td class="search_condition_container_region">
                            <div  style="margin-bottom: 10px;">
                                <!--<a href="javascript:void(0);">全部</a> &nbsp;&nbsp;--> 
                                <?php foreach(Area::getCityArr() as $ck=>$cv){ ?>
                                    <a href="javascript:void(0);" data-value="<?php echo $ck; ?>"  rel="detail_city">&nbsp;<?php echo $cv; ?> </a>
                                    &nbsp;&nbsp;
                                <?php } ?>
                            </div>
                            <div class="regionBox"  rel="detail_city_area" style=" border: 1px solid #bbcedc; border-bottom: none;  padding:10px 10px; display: none;">

                            </div>
                            <div style=" border: 1px solid #bbcedc; padding:10px 10px; background-color:#f5f5f5;">
                                <div>已选条件：</div>
                                <div class="checkRegionBox " style=" display: inline-block;">
                                    <ul class="checkList"> 
                                    </ul>
                                </div>
                            </div>
                        </td> 
                    </tr> 
                    <tr class="search_condition_container_schooltype" > 
                       <td class="td_label">学校性质* ：</td>
                       <td>
                           <div style="margin-bottom: 10px;">
                               <!--<a href="javascript:void(0);">全部</a> &nbsp;&nbsp;-->
                               <?php foreach(SchoolType::getSchoolTypeArr() as $stk=>$stv){ ?>
                                   <a href="javascript:void(0);" data-value="<?php echo $stk; ?>"  rel="detail_schooltype">&nbsp;<?php echo $stv; ?> </a> &nbsp;&nbsp;
                               <?php } ?>
                           </div>
                           <div class="schoolclassBox" rel="detail_schooltype_grade" style=" border: 1px solid #bbcedc; border-bottom: none; padding:10px 10px; display: none; "> 
                           </div>
                           <div style=" border: 1px solid #bbcedc; padding:10px 10px; background-color:#f5f5f5; ">
                                <div>已选条件：</div>
                                <div class="checkSchoolclassBox"  style=" display: inline-block;">
                                    <ul class="checkList">

                                    </ul> 
                               </div>
                           </div>
                       </td> 
                    </tr>
                    <tr>
                       <td>
                           <p style="height: 20px;"></p>
                           <a href="javascript:void(0);" class="btn btn-primary" rel="location_query" >查  询</a>
                       </td>
                       <td></td>
                   </tr>
                   <tr id="location_tr" style="display: none">
                       <td class="td_label">查询结果：</td>
                       <td> 
                           <div id="location_result" style="display:inline-table;">
                               
                           </div>
                       </td>
                   </tr>  
                </table>
            </form> 
        </div>
    </div>

    <div style="border: 1px solid #f1f1f1; padding: 0px; margin-top: 20px;">
        <div class="navCrumb">学校广告位情况查询</div>
        <div class="box"> 
            <!-- 学校情况查询 -->
            <form>
               <table class="tableForm">
                   <tr>
                       <td class="td_label">日 期* ：</td> 
                       <td class="dateBox"> 
                           <input rel="dataeinput" id="stime_2" name="stime1" type="text" class=" "  style="width:120px;" value=""> 
                           <span>&nbsp;至 &nbsp;</span> 
                           <input rel="dataeinput" id="etime_2" type="text" name="etime1" class=" " style="width:120px;" value=""> 
                        </td> 
                   </tr>
                   <tr>
                       <td>地区：</td>
                       <td>
                           <select id="school_city" rel="<?php echo Yii::app()->createUrl('range/schoolarea');?>">
                               <option value="">--选择城市--</option>
                                <?php foreach(Area::getCityArr() as $ck=>$cv){ ?>
                                    <option value="<?php echo $ck; ?>"><?php echo $cv; ?></option> 
                                 <?php } ?>
                           </select>
                           &nbsp;&nbsp;&nbsp;&nbsp;
                           <select id="school_area" rel="<?php echo Yii::app()->createUrl('range/schoollist');?>">
                               <option value="">--选择区域--</option>
                            </select>
                       </td>
                       
                   </tr>
                    <tr>
                       <td>学校性质：</td>
                       <td>
                           <select id="school_type" rel="<?php echo Yii::app()->createUrl('range/schoollist');?>">
                               <option value="">--选择学校类别--</option>
                               <?php foreach(SchoolType::getSchoolTypeArr() as $stk=>$stv){ ?>
                                    <option value="<?php echo $stk; ?>"><?php echo $stv; ?></option>
                               <?php } ?>
                           </select>
                           &nbsp;&nbsp;&nbsp;&nbsp;

                           <select id="schoolId" >
                               <option value="">--选择学校--</option>
                               <?php foreach(School::getDataArr() as $sk=>$sv): ?>
                                  <option value="<?php echo $sk; ?>"><?php echo $sv; ?></option>
                               <?php endforeach; ?>
                           </select>
                       </td>
                   </tr> 
                   <tr>
                       <td>
                           <p style="height: 20px;"></p>
                           <a href="javascript:void(0);" class="btn btn-primary" rel="school_query" >查  询</a></td>
                       <td></td>
                   </tr>
                   <tr id="school_tr" style="display: none">
                       <td class="td_label">查询结果：</td>
                       <td> 
                           <div id="school_result" style="display: inline-block;" ></div> 
                       </td>
                   </tr>  
               </table>
            </form>
        </div>
    </div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/jquery.easyui.min.js"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript">
$(function () { 
     //时间输入框只读 日期控件兼容  
    $("input[name='stime']").datebox({
        onSelect: function (date) {
            $("#location_tr").hide();
            $("#location_result").empty();
            $('[rel=location_query]').removeAttr('disabled');
        }
    });
    $("input[name='etime']").datebox({
        onSelect: function (date) { 
            $("#location_tr").hide();
            $("#location_result").empty();
            $('[rel=location_query]').removeAttr('disabled');
        }
    });
    $("input[name='stime1']").datebox({
        onSelect: function (date) {
            $("#school_tr").hide();
            $("#school_result").empty();
            $('[rel=school_query]').removeAttr('disabled');
        }
    });
    $("input[name='etime1']").datebox({
        onSelect: function (date) {
            $(".school_tr").hide();
            $("#school_result").empty();
            $('[rel=school_query]').removeAttr('disabled');
        }
    }); 
    $(".combo-text").attr({readonly:'readonly',rel:'textDatetime'});
    
    //位置查询优化 
   $(document).on('change','[rel=detail_location]',function(){
       $("#location_tr").hide();
       $("#location_result").empty();
       $('[rel=location_query]').removeAttr('disabled');
    });
    
    $(document).on('change','#schoolId ',function(){
        //$("#school_tr").hide();
        $("#school_result").empty();
        $('[rel=school_query]').removeAttr('disabled');
    });
    var regionValue = ',';
    var schoolValue = ',';
    
    ajaxloctionurl = "<?php echo Yii::app()->createUrl('contract/locationquery');?>";
    ajaxloctionhtml = "请求出错！";
    function ajaxLocation(sdate,edate,location,areas,grades,business,contype,objid){ 
        $.ajax({  
            url: ajaxloctionurl,   
            type : 'POST',  
            data : {sdate:sdate,edate:edate,location:location,areas:areas,grades:grades,business:business,contype:contype,objid:objid},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async :true,  
            success : function(mydata) {   
                ajaxloctionhtml = mydata; 
                $("#location_result").empty();
                $("#location_result").append(ajaxloctionhtml); 
                //regionValue = '';
                //schoolValue = '';
            },  
            error : function() { 
                $("#location_result").empty();
                $("#location_result").append(ajaxloctionhtml);
            }  
        });
    }

    ajaxschoolurl = "<?php echo Yii::app()->createUrl('contract/schoolquery');?>";
    ajaxschoolhtml = "请求出错！";
    function ajaxSchool(sdate,edate,sid,st){ 
        $.ajax({  
            url: ajaxschoolurl,   
            type : 'POST',  
            data : {sdate:sdate,edate:edate,sid:sid,st:st},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : true,  
            success : function(mydata) {   
                ajaxschoolhtml = mydata; 
                $("#school_result").empty();
                $("#school_result").append(ajaxschoolhtml);  
            },  
            error : function() {  
                $("#school_result").empty();
                $("#school_result").append(ajaxschoolhtml);
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
     
    //选择城市
    $("[rel=detail_city]").live('click',function(){
       var cid = $(this).data('value'); 
        ajaxGetArea(cid);
        $("[rel=detail_city_area]").show();
        $("[rel=detail_city_area]").html(ajaxareahtml);
    });
    //学校性质
    $("[rel=detail_schooltype]").live('click',function(){
        var stid = $(this).data('value');
        ajaxGetGrade(stid);
        $("[rel=detail_schooltype_grade]").show();
        $("[rel=detail_schooltype_grade]").html(ajaxgradehtml);
    });
    //选择区域
    $(document).on('click','.itmeRegion',function(event){ 
        event.preventDefault();
        var dtaval = $(this).data('value') , textinfo = $(this).text(),cityName = $(this).data('city');
        if(regionValue.indexOf(','+dtaval+',',',') > -1){ 
        }else{ 
            regionValue+=dtaval+','; 
            var srt = '<li>'+ textinfo+' - '+ cityName +'<a href="javascript:void(0);" class="closeIoc closeRegion" data-value="'+dtaval+ '" rel="'+dtaval +'"></a></li>';
            $(this).parent('.regionBox').siblings('div').find('.checkRegionBox ul').append(srt);
            $('[rel=location_query]').removeAttr('disabled');
        }
        event.stopPropagation();
    });
    //选择年纪
    $(document).on('click','.itmeSchool',function(event){
        event.preventDefault();
        var dtaval = $(this).data('value') , textinfo = $(this).text(),schoolName = $(this).data('school');
        if(schoolValue.indexOf(','+dtaval+',',',') > -1){ 
        }else{ 
            schoolValue+= dtaval+','; 
            var srt = '<li>'+textinfo +' - '+ schoolName +'<a href="javascript:void(0);" class="closeIoc closeSchool" data-value="'+dtaval+ '" rel="'+ dtaval +'"></a></li>';
            $(this).parent('.schoolclassBox').siblings('div').find('.checkSchoolclassBox ul').append(srt);
            $('[rel=location_query]').removeAttr('disabled');
        } 
    });
    //删除选中 
    $(document).on('click','.closeSchool',function(){
        var itmeVal = $(this).data('value');
        $(this).parent('li').remove();
        s = schoolValue.replace(itmeVal+',',"");
        schoolValue = s;
        $("#location_result").empty();
         $('[rel=location_query]').removeAttr('disabled');
    });
    //删除选中 
    $(document).on('click','.closeRegion',function(){
        var itmeVal = $(this).data('value');
        $(this).parent('li').remove();
        var s = regionValue.replace(itmeVal+',',"");
        regionValue = s; 
        $("#location_result").empty();
         $('[rel=location_query]').removeAttr('disabled');
    });
    //城市区域全选
    $(document).on('click','.cityAll',function(){
        var dataV1 = $(this).data('value');
        $(this).parent('.regionBox').find('a[rel="'+ dataV1 +'"]').click();
    });
    //学校班级全选
    $(document).on('click','.schoolAll',function(){
        var dataV2 = $(this).data('value');
        $(this).parent('.schoolclassBox').find('a[rel="'+ dataV2 +'"]').click();
    });
    
    
   // 查询广告位占用情况
    $(document).on('click','[rel=location_query]',function(){  
        var sdate = $("input[name='stime']").val();
        var edate = $("input[name='etime']").val();
        var location= $("#detail_location_1").find('option:selected').val();
        var region = regionValue.substring(1,regionValue.length-1);
        var schools = schoolValue.substring(1,schoolValue.length-1); 
        var areas = region;
        var grades = schools;
        //alert(areas+"--------"+grades); 
        if(sdate==""|| edate == ""){
            alert("请选择起止时间！");
        }else{ 
            if(location==""){
                alert("请选择广告位置");
            }else{
               if(areas==""||grades==""){
                   alert("请选择广告区域和学校年级！");
               }else{
                   $(this).attr('disabled','disabled');
                   $("#location_tr").show(); 
                   $("#location_result").empty();
                   $("#location_result").append('<span class="Validform_checktip Validform_loading" > 正在加载数据...</span>');
                   ajaxLocation(sdate,edate,location,areas,grades); 
               }
           }  
        } 
    });
    
    // 查询学校广告位 占用使用情况
    $(document).on('click','[rel=school_query]',function(){ 
        var sdate = $("input[name='stime1']").val();
        var edate = $("input[name='etime1']").val();
        var sid = $("#schoolId").find("option:selected").val();
        var st = $("#school_type").find("option:selected").val();
        if(sdate==""|| sdate == ""){
            alert("请选择起止时间！");
        }else{
            if(sid){
                 $(this).attr('disabled','disabled');
                 $("#school_tr").show();
                 $("#school_result").empty();
                 $("#school_result").append('<span class="Validform_checktip Validform_loading" > 正在加载数据...</span>');
                 ajaxSchool(sdate,edate,sid,st);
            }else{
                 alert("请选择学校！");
            }
        } 
    });
    //选择城市
    $("#school_city").change(function(){
    	var cid = $(this).val();
    	var ajaxurl = $(this).attr('rel');
         $(".school_tr").hide();
         $("#school_result").empty(); 
         $('[rel=school_query]').removeAttr('disabled');
        var default_option = '<option value="">--选择区域--</option>';
        var default_option1 = '<option value="">--选择学校--</option>'; 
    	if(cid){
    		$.ajax({  
	            url: ajaxurl,   
	            type : 'POST',  
	            data : {cid:cid},  
	            dataType : 'text',  
	            contentType : 'application/x-www-form-urlencoded',  
	            async : false,  
	            success : function(mydata) {
		            $("#school_area").empty();
		            // $("#school_grade").empty(); 
		            $("#schoolId").empty(); 
		            var html = default_option + mydata;
	            	$("#school_area").append(html);
                    $("#schoolId").append(default_option1);
	            },  
	            error : function() {  
	            }  
	        });
    	}else{
            $("#school_area").empty();
            $("#school_area").append(default_option);; 
        }
    })
    //选择学校
    $("#school_area").change(function(){
    	var aid = $(this).val();
    	var stid = $("#school_type").val();
    	var ajaxurl = $(this).attr('rel');
        $("#school_result").empty();
        $(".school_tr").hide();
        $('[rel=school_query]').removeAttr('disabled');
        var default_option = '<option value="">--选择学校--</option>';
    	if(aid && stid){
    		$.ajax({  
	            url: ajaxurl,   
	            type : 'POST',  
	            data : {aid:aid,stid:stid},  
	            dataType : 'text',  
	            contentType : 'application/x-www-form-urlencoded',  
	            async : false,  
	            success : function(mydata) {
		            $("#schoolId").empty(); 
		            var html = default_option + mydata;
	            	$("#schoolId").append(html); 
	            },  
	            error : function() {  
	            }  
	        });
    	}else{
          $("#schoolId").empty();
          $("#schoolId").append(default_option); 
        }
    })
    //选择学校类别 
    $("#school_type").change(function(){
    	var stid = $(this).val();
    	var aid = $("#school_area").val();
    	var ajaxurl = $(this).attr('rel');
         $(".school_tr").hide();
         $("#school_result").empty();
         $('[rel=school_query]').removeAttr('disabled');
         var default_option = '<option value="">--选择学校--</option>';
    	if(aid && stid){
    		$.ajax({  
	            url: ajaxurl,   
	            type : 'POST',  
	            data : {aid:aid,stid:stid},  
	            dataType : 'text',  
	            contentType : 'application/x-www-form-urlencoded',  
	            async : false,  
	            success : function(mydata) {
		            $("#schoolId").empty(); 
		            var html = default_option + mydata;
	            	$("#schoolId").append(html);
                    
	            },  
	            error : function() {  
	            }  
	        });
    	}else{
            $("#schoolId").empty();
            $("#schoolId").append(default_option);
        }
    });
 });
</script>
</div>