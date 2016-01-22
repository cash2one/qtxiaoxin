<div class="box">
    <div class="form tableBox">
    	<form action="" id="business-form" method="post">
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td class="td_title_Long">学校名称* ：</td>
	                    <td>
	                        <div style="display: inline;">  
	                        	<input size="10" name="School[name]" maxlength="20" datatype="*1-15" nullmsg="学校名称不能为空！" errormsg="学校名称长度不能大于15个字！" name="Business[name]" id="Business_name" type="text" class="Validform_error">
	                        </div>
	                        <span class="Validform_checktip ">名称限制20个字符以内</span>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">类型* ：</td>
		                    <td>
		                        <div class="Validform_checktip " style=" display: inline;margin-left:0;">
		                            <input id="ytInformation_kindtop" type="hidden" value="" name="Information[kindtop]">
		                            <span  >
		                                &nbsp;&nbsp;
                                        <?php foreach($types as $k=>$v):?>
		                                <input id="Information_kindtop_0" value="<?php echo $k;?>" type="checkbox"  name="selecttype[]" datatype="need2" nullmsg="请选择您的类型！">
		                                <label for="Information_kindtop_0"><?php echo $v;?></label>
		                               &nbsp;&nbsp;
                                        <?php endforeach;?>
                                      
		                            </span> 
		                       		<span class="Validform_checktip "></span>
		                        </div>  
		                        <input id="countKindTop" type="hidden" value="12">
		                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">城市* ：</td>
	                    <td>
	                        <div style="display: inline;"> 
	                            <select id="queryprovince" name="city" style="width:150px;" datatype="*" nullmsg="请选择城市！">
					               <!-- <option value="">全部</option> 必须要填城市-->
                                    <?php if(is_array($citys)) foreach($citys as $k=>$v):?>
					                <option value="<?php echo $k;?>"><?php echo $v;?></option>
                                    <?php endforeach;?>
					            </select>                                               
							</div>
							<span class="Validform_checktip "></span>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">地区* ：</td>
	                    <td>
	                        <div style="display: inline;"> 
	                           <select name="School[aid]" style="width:150px;" datatype="*" nullmsg="请选择地区！">
					               <!-- <option  value="">全部</option>-->
					                <option  value="1">深圳职业技术学院</option>
					            </select>                                                  
							</div>
							<span class="Validform_checktip "></span>
	                    </td>
	                </tr>
                    <tr>
                        <td class="td_title_Long">套餐* ：</td>
                        <td>
                            <div style="display: inline;"> 
	                           <select name="School[duty]" style="width:150px;" datatype="*" nullmsg=" " id=" ">
					                <option  value="">全部</option>
                                    <option value="1">AB套餐</option>
                                    <option value="2">C套餐</option>
					            </select>                                                  
							</div>
							<span class="Validform_checktip "></span>
                            <div style=" color:#999; margin-top: 10px; ">
                                ddddddddddddd
                            </div>
                        </td>
                    </tr>
	            </tbody>
	        </table>

	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td class="td_title_Long"></td>
	                    <td> 
	                    		<input type="submit" class="btn btn-primary" value="创 建">&nbsp;&nbsp; 
		                      
		                       <a id="sub_cancel" href="/admin.php/school/index" class="btn btn-default">取消</a>
		                </td>

	                </tr>
	            </tbody>
	            <tfoot></tfoot>
	        </table>
        </form>
    </div>
</div>
<script type="text/javascript">
	$(function(){
	 $('#business-form').Validform({//表单验证
            tiptype:2,
            showAllError:true, 
            postonce:true,
			datatype:{//传入自定义datatype类型【方式二】;
				"need2":function(gets,obj,curform,regxp){
					var need=1,
						numselected=curform.find("input[name='"+obj.attr("name")+"']:checked").length;
					return  numselected >= need ? true : "请至少选择"+need+"项！";
				},
				
				"max2":function(gets,obj,curform,regxp){
					var atmax=2,
						numselected=curform.find("input[name='"+obj.attr("name")+"']:checked").length;
						
					if(numselected==0){
						return false;
					}else if(numselected>atmax){
						return "最多只能选择"+atmax+"项！";
					}
					return  true;
				}
				
			}
        }); 
		 //城市地区联动
   $(document).on('change','#queryprovince',function() {
       ajaxareaurl = "<?php echo Yii::app()->createUrl('range/schoolarea');?>";
        var cityid = $(this).find("option:selected").val(); 
        if (cityid) {
            $.ajax({  
                url:ajaxareaurl,
                type : 'Get',
                data : {cid:cityid},  
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {
                    var option ='<option value="">全部</option>';
                    mydata=$.parseJSON(mydata);
                    if(mydata.status=='1'){ 
                        var str=[];
                        $("#querycity").html('');
                        $("#queryarea").html(option);
                        $.each(mydata.data,function(i,v){
                             str.push('<option value="'+v.aid+'">'+v.name+'</option>');
                        });
                        $("#querycity").html(option +str.join('')); 
                    }
                }   
            });
        }else{
            var option ='<option value="">全部</option>';
            $("#querycity").html(option);
            $("#querycity").val('');

        }
   });
    //城市地区联动
   $(document).on('change','#querycity',function() {
        var ajaxareaurl = "<?php echo Yii::app()->createUrl('range/schoolarea');?>"; 
        var cityid = $(this).find("option:selected").val(); 
        if (cityid) {
            $.ajax({  
                url:ajaxareaurl,
                type : 'Get',
                data : {cid:cityid},  
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {
                   var option ='<option value="">全部</option>';
                   mydata=$.parseJSON(mydata);
                   if(mydata.status=='1'){ 
                        var str=[];
                        $("#queryarea").html('');
                        $.each(mydata.data,function(i,v){
                             str.push('<option value="'+v.aid+'">'+v.name+'</option>');
                        }); 
                        $("#queryarea").html(option +str.join('')); 
                    }
                }   
            });
        }else{
            var option ='<option value="">全部</option>';
            $("#queryarea").html(option);
            $("#queryarea").val('');

        }
   });
		 
	})
</script>
