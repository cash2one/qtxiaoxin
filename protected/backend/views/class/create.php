<div class="box">
    <div class="form tableBox">
    	<form action="" id="business-form" method="post">
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td class="td_title_Long">班级名称* ：</td>
	                    <td>
	                        <div style="display: inline;">  
	                        	<input name="Class[name]"  class="input-large" maxlength="25" datatype="*1-20" nullmsg="班级名称不能为空！" errormsg="班级名称长度不能大于20个字！"type="text" class=" Validform_error">
	                        </div>
	                        <span class="Validform_checktip ">名称限制20个字符以内</span>
	                    </td>
	                </tr>
                    <tr>
                        <td class="td_title_Long">班级序号 ：</td>
                        <td>
                            <div style="display: inline;">
                                <input name="Class[seqno]" maxlength="25" style="width:300px" type="text" onkeyup="inputNumber(this);" onafterpaste="inputNumber(this);" />
                            </div>

                        </td>

                    </tr>
	                <tr>
	                    <td class="td_title_Long">学校* ：</td>
	                    <td>
	                        <div style="display: inline;"> 
	                            <select  name="Class[sid]" style="width:250px;" datatype="*" nullmsg="请选择学校！" id="selectsid" url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
					                <option  value="">全部</option>
                                    <?php foreach($schools as $k=>$v):?>
                                        <option value="<?php echo $k;?>" <?php if($sid==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                                    <?php endforeach;?>
					            </select>                                         
							</div>
							<span class="Validform_checktip "></span>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">年级* ：</td>
	                    <td>
	                        <div style="display: inline;"> 
	                           <select  name="grade" style="width:150px;" datatype="*" nullmsg="请选择年级！" id="selecttid">
	                           		<option value="">全部</option>
					            </select>                                                  
							</div>
							<span class="Validform_checktip "></span>
	                    </td> 
	                </tr>
	                 <tr>    
	                    <td class="td_title_Long">班主任 ：</td>
	                    <td>
	                        <div style="display: inline;">                                                                              
	                           <select id="selectmaster" name="Class[master]" style="width:150px;" datatype="*" nullmsg="请选择班主任！" ignore="ignore">
	                           		<option value="">请选择班主任</option>
					            </select>                                                  
							</div>
							<span class="Validform_checktip "></span>
	                    </td>
	                    
	                </tr>
	                <tr>
	                    <td class="td_title_Long">班级介绍 ：</td>
	                    <td>
	                        <div style="display: inline;"> 
	                           <textarea name="Class[info]"datatype="*0-100"  errormsg="班级介绍长度不大于100个字!" class="Validform_error" ignore="ignore"></textarea>
							</div>
							<span class="Validform_checktip "></span>
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
		                      
		                       <a id="sub_cancel" href="<?php echo Yii::app()->createUrl('class/index');?>" class="btn btn-default">取消</a>
		                </td>

	                </tr>
	            </tbody>
	            <tfoot></tfoot>
	        </table>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/selectautocomplete.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>

<script type="text/javascript">
	$(function(){
	 	$('#business-form').Validform({//表单验证
            tiptype:2,
            showAllError:true, 
            postonce:true,
			datatype:{//传入自定义datatype类型【方式二】;
				
				
			}
        }); 
		//删除提醒
	    $('[rel=deleLink] ').click(function(){
		        var urls = $(this).data('href');
	        $("#isOk").attr('href',urls);
	        	showPromptsIfonWeb('#popupBox');
		    });
		    // 自动补全
		    
		    var projectss =["深圳南山小学","深圳大学"];
		    //console.log (projectss);
		   // var projects = projectss.split(',');
		    searchAutocomplete("selectSchool",projectss);   

        if($("#selectsid").val()!=""){
            var url = $("#selectsid").attr('url'),datas =$("#selectsid").val();
             ajaxPost(url,datas);
        }else{ 
        }
		 //班级联动
	    $("#selectsid").change(function(){
	        var datas = $(this).val();
	        var url = $(this).attr('url'); 
            ajaxPost(url,datas);
            
	    }); 
        
        //请求
        function ajaxPost(url,datas){
            var option ='<option value="">全部</option><option value="interest">兴趣班</option>';
	        var teacherhtml='<option value="">请选择班主任</option>';
            if (datas) {
	            $.getJSON(url,{sid:datas,grade:1,teacher:1},function(mydata) {
                    if(mydata&&mydata.grades){
                        $.each(mydata.grades,function(i,v){
                            option=option+'<option value="'+i+'">'+v+'</option>';
                        });
                    }
	                $("#selecttid").html(option);
                    
                    if(mydata&&mydata.teachers){
                        $.each(mydata.teachers,function(i,v){
                            teacherhtml=teacherhtml+'<option value="'+i+'">'+v+'</option>';
                        });
                    }
                    $("#selectmaster").html(teacherhtml);
	            });
	         }else{

	         		$("#selecttid").html(option);
	         		$("#selectmaster").html(teacherhtml);
	         } 
        }
	});
		 
	
</script>
