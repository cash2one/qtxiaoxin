<div class="box">
    <div class="form tableBox">
    	<form action="" id="formBoxRegister" method="post">
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td class="td_title_Long">分组名称* ：</td>
	                    <td>
	                        <div style="display: inline;">  
	                        	<input name="Group[name]" class="input-large" size="10" maxlength="25" datatype="*1-20" nullmsg="分组名称不能为空！" errormsg="分组名称长度不能大于20个字！"type="text">
	                        </div>
	                        <span class="Validform_checktip ">名称限制20个字符以内</span>
	                    </td>
	                </tr>
	               
	                <tr>
	                    <td class="td_title_Long">所在学校*：</td>
	                    <td>
	                        <div style="display: inline;">
                                <select  name="Group[sid]" style="width:250px;" datatype="*" nullmsg="请选择学校！" id="class_school" url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
                                    <option  value="">全部</option>
                                    <?php foreach($schools as $k=>$v):?>
                                        <option value="<?php echo $k;?>" <?php if($sid==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                                    <?php endforeach;?>
                                </select>
							</div>
							<span class="Validform_checktip schoolTip"></span>
							<span id="schoolTipS" class="Validform_checktip Validform_wrong" style="display: none;">请选择学校！</span>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">创建者*：</td>
	                    <td>
	                        <div style="display: inline;">
                                <select name="Group[creater]" id="teacherselect" datatype="*" nullmsg="请选择创建者！" >
					                <option value="">全部</option>
					                <?php if(is_array($teachers)): foreach($teachers as $k=>$val):?>
					                    <option value="<?php echo $k;?>" ><?php echo $val;?></option>
					                <?php endforeach;?>
					                <?php endif;?>
					            </select>
							</div>
							<span class="Validform_checktip "></span>
							<span id="schoolTipS" class="Validform_checktip Validform_wrong" style="display: none;">请选择创建者！</span>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">分组类型*：</td>
	                    <td>
	                        <div style="display: inline;">
                                <select  name="Group[type]" style="width:120px;" datatype="*" nullmsg="请选择分组类型！" id="grouptype" >
                                    <option  value="0">学生组</option>
                                    <option  value="1">老师组</option>

                                </select>
							</div>
							<span class="Validform_checktip "></span>
	                    </td>
	                </tr>
	                
	            </tbody>
	        </table>
		
            <table class="tableForm">
                <tbody>
                	<tr>
                		<td class="td_title_Long">成员名单：</td>
                	</tr>
                    <tr>
                        <td>  
                            <div class="memberBox">
                                <ul id="memberList">
                                    <li class="memberBtn"><a rel="addUserBtn" href="javascript:void(0);" ><em class="addBtnIco"></em> 添加成员</a></li> 
                                </ul>
                            </div>
                            <div id="cuntUserCheck" class="cuntMember" >已选择了<span class="red">0</span>人
                                <span id="cuntTip" style="display: none;" class="Validform_checktip Validform_wrong">至少添加一个成员</span></div>
                            <span class="Validform_checktip" ></span>
                            <div id="cacheBox" style="display: none;"> 
                            </div>
                        </td>
                    </tr> 
                </tbody>
            </table>
            <table class="tableForm">
                <tbody>
                	<tr>
                		<td class="td_title_Long">指定访问人：</td>
                	</tr>
                    <tr>
                        <td>  
                            <div class="memberBox">
                                <ul id="memberVisitList">
                                    <li class="memberBtn"><a rel="addVisitUserBtn" href="javascript:void(0);" ><em class="addBtnIco"></em> 添加成员</a></li> 
                                </ul>
                            </div>
                            <div id="cuntUserVisitCheck" class="cuntMember" >已选择了<span class="red">0</span>人
                                <span id="cuntVisitTip" style="display: none;" class="Validform_checktip Validform_wrong">至少添加一个成员</span></div>
                            <span class="Validform_checktip" ></span>
                            <div id="cacheVisitBox" style="display: none;"> 
                            </div>
                        </td>
                    </tr> 
                </tbody>
            </table>
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td> 
	                    		 <input id="submitForm" type="button" class="btn btn-primary"  value="创 建">
	                    		&nbsp;&nbsp; 
	                    		 <input id="visitVal" type="hidden" value="0">
		                       <a id="sub_cancel" href="<?php echo Yii::app()->createUrl('group/index');?>" class="btn btn-default">取消</a>
		                </td>

	                </tr>
	            </tbody>
	            <tfoot></tfoot>
	        </table>
        </form>
    </div>
</div>
<div class="popupBox" style="width:640px;" >
    <div class="header">添加成员 <a href="javascript:void(0);" class="close" onclick="hidePormptMask('popupBox')" > </a></div>
    <div id="popupInfo"> 
		 <div id="select_member"> 

        </div> 
         <div class="popupBtn" style="text-align:center;margin:20px 0 10px;">
            <a id="saveMemberBtn" href="javascript:void(0);"  class="btn btn-primary">确 定</a>&nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0);" onclick="hidePormptMask('popupBox')" class="btn btn-default">取 消</a>
        </div>
    </div> 
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script>
<script type="text/javascript">
	$(function(){
	 	$('#formBoxRegister').Validform({//表单验证
            tiptype:2,
            showAllError:true, 
            postonce:true,
			datatype:{//传入自定义datatype类型【方式二】;
				
				
			}
        }); 

	 	//年级联动
	    $("#class_school").change(function(){
	        var datas = $(this).val();
	        var url = $(this).attr('url');
	        var selectid = $('#teacherselect');
	        var option ='<option value="">全部</option>';
	        if (datas) {
	            $.getJSON(url,{sid:datas,teacher:1},function(mydata) {
	                if(mydata&&mydata.teachers){
	                    $.each(mydata.teachers,function(i,v){
	                        option=option+'<option value="'+i+'">'+v+'</option>';
	                    });
	                }
	                selectid.html(option);
	            });
	        }else{
	            selectid.html(option);
	        }
	    });
    
         //指定访问人请求数据
	    function jaxaAddVisitMember(tid,sid,ty){  
	        var url = "<?php echo Yii::app()->createUrl('group/getmember');?>";
	        $.ajax({  
	            url:url,   
	            type : 'POST',
	            data : {tid:tid,ty:ty,sid:sid},
	            dataType : 'text',  
	            contentType : 'application/x-www-form-urlencoded',  
	            async : false,  
	            success : function(mydata) {   
	                var show_data =mydata;
	                $("#cacheVisitBox").empty();
	                $("#popMember").empty();
	                $("#popMember").append(show_data); 
	            },  
	            error : function() {  
	                    // alert("calc failed");  
	            }  
	        });
	    } 
	     //请求数据
	    function jaxaAddMember(tid,sid,ty){  
	        var url = "<?php echo Yii::app()->createUrl('group/getmember');?>";
	        $.ajax({  
	            url:url,   
	            type : 'POST',
	            data : {tid:tid,ty:ty,sid:sid},
	            dataType : 'text',  
	            contentType : 'application/x-www-form-urlencoded',  
	            async : false,  
	            success : function(mydata) {   
	                var show_data =mydata;
	                $("#cacheBox").empty();
	                $("#popMember").empty();
	                $("#popMember").append(show_data); 
	            },  
	            error : function() {  
	                    // alert("calc failed");  
	            }  
	        });
	    }
	     
	    //指定访问人请求数据
	    function jaxaAddVisitUers(sid,ty){ 
	        var url = "<?php echo Yii::app()->createUrl('group/member');?>";
	        $.ajax({  
	            url:url,   
	            type : 'POST',
	            data : {sid:sid,ty:ty},
	            dataType : 'text',  
	            contentType : 'application/x-www-form-urlencoded',  
	            async : false,  
	            success : function(mydata) {   
	                var show_data =mydata;
	                $("#select_member").empty();
	                $("#select_member").append(show_data);
	                showPromptsIfon('popupBox');
	            },  
	            error : function() {  
	                    // alert("calc failed");  
	            }  
	        });
	    }
	     //请求数据
	    function jaxaAddUers(sid,ty){ 
	        var url = "<?php echo Yii::app()->createUrl('group/member');?>";
	        $.ajax({  
	            url:url,   
	            type : 'POST',
	            data : {sid:sid,ty:ty},
	            dataType : 'text',  
	            contentType : 'application/x-www-form-urlencoded',  
	            async : false,  
	            success : function(mydata) {   
	                var show_data =mydata;
	                $("#select_member").empty();
	                $("#select_member").append(show_data);
	                showPromptsIfon('popupBox');
	            },  
	            error : function() {  
	                    // alert("calc failed");  
	            }  
	        });
	    }
	    //改变学校
	    $("#class_school").change(function(){
	        $("#memberList").find('.userCheck').remove();
	        $('#schoolTipS').hide();
	        $('.schoolTip').show();
	    });
	    
	    //弹出选择面板
	    $("[rel=addUserBtn]").live('click',function(){ 
	        var sid = $("#class_school").find('option:selected').val();
	        var ty = $('#grouptype').val();
	        if(sid==""){
	             $('#schoolTipS').show();
	             $('.schoolTip').hide();
	         }else{
	           jaxaAddUers(sid,ty);
	           //var userCheck = $("#memberList").html();
	           //$('#cacheBox').append(userCheck); 
	       //$('#cacheBox').find('.memberBtn').remove();
	           $('#cuntTip').hide(); 
	         }
	         $("#visitVal").val('0');
	    });
	    
	    //指定访问人弹出选择面板
	    $("[rel=addVisitUserBtn]").live('click',function(){ 
	         var sid = $("#class_school").find('option:selected').val();
	         var ty = '1';
	         if(sid==""){
	             $('#schoolTipS').show();
	             $('.schoolTip').hide();
	         }else{
	           jaxaAddVisitUers(sid,ty);
	           //var userCheck = $("#memberVisitList").html();
	          // $('#cacheVisitBox').append(userCheck); 
	          // $('#cacheVisitBox').find('.memberBtn').remove();
	           $('#cuntVisitTip').hide(); 
	         }
	         $("#visitVal").val('1');
	    });
	    
	    //选择班级
	    $('#teacher_class').live('change',function(){
	        var ty = $('#grouptype').val();
	        var tid = $("#teacher_class").find('option:selected').val();
	        var sid = $("#class_school").find('option:selected').val();
	        if($("#visitVal").val()=="1"){
	            jaxaAddVisitMember(tid,sid,1);
	        }else{
	            jaxaAddMember(tid,sid,ty);
	        }
	      
	        //alert($("#visitVal").val()); 
	    }); 
	    
	    //添加成员
	    $('[rel=chekedItime]').live('click',function(){
	        var usid = $(this).data('usid');
	        var type = $(this).attr('uit');
	        var name = $(this).data('name');

	        //$(".userCheck_"+usid).parent('li').remove();
	        if($("#visitVal").val()=="1"){//指定访问人
	            $(".userChecks_"+usid).parent('li').remove();
	            if(parseInt(type)==0){
	                var itme ='<li class="userCheck"><em class="userIco"></em><span>'+name+'</span><a rel="deleItime" class="deleIco" href="javascript:void(0);"></a><input checked="checked" id="checkboxs_'+usid+'" class="userChecks_'+usid+'" type="checkbox" style="display: none;" name="Group[accessids][]" value="'+usid+'"></li>';
	                $(this).parent('li').addClass('checked');
	                $("#cacheVisitBox").append(itme);
	                $(this).attr('uit',1);
	            }else{
	                $(this).attr('uit',0);
	                $(this).parent('li').removeClass('checked');
	                $("#checkboxs_"+usid).parent('li').remove();
	            } 
	        }else{
	            $(".userCheck_"+usid).parent('li').remove();
	            if(parseInt(type)==0){
	                var itme ='<li class="userCheck"><em class="userIco"></em><span>'+name+'</span><a rel="deleItime" class="deleIco" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+usid+'" class="userCheck_'+usid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+usid+'"></li>';
	                $(this).parent('li').addClass('checked');
	                $("#cacheBox").append(itme);
	                $(this).attr('uit',1);
	            }else{
	                $(this).attr('uit',0);
	                $(this).parent('li').removeClass('checked');
	                $("#checkbox_"+usid).parent('li').remove();
	            } 
	        }
	    }); 
	    
	    //保存选中
	    $('#saveMemberBtn').live('click',function(){
	        if($("#visitVal").val()=="1"){//指定访问人保存选中
	            var box = $("#cacheVisitBox").html();
	            $("#memberVisitList .memberBtn").before(box);
	            var cunt =$("#memberVisitList").find('li').length - 1;
	            hidePormptMask('popupBox');
	            $('#cuntUserVisitCheck').find('span.red').html(cunt);
	            $("#cacheVisitBox").empty();
	        }else{
	            var box = $("#cacheBox").html();
	            $("#memberList .memberBtn").before(box);
	            var cunt =$("#memberList").find('li').length - 1;
	            hidePormptMask('popupBox');
	            $('#cuntUserCheck').find('span.red').html(cunt);
	            $("#cacheBox").empty();
	        }
	    }); 
	    
	    //删除成员
	    $('#memberList [rel=deleItime]').live('click',function(){
	        $(this).parent('li').remove(); 
	        var cunt =$("#memberList").find('li').length - 1;
	        $('#cuntUserCheck').find('span.red').html(cunt);  
	    });
	    
	    $('#memberVisitList [rel=deleItime]').live('click',function(){
	        $(this).parent('li').remove(); 
	        var cunt =$("#memberVisitList").find('li').length - 1;
	        $('#cuntUserVisitCheck').find('span.red').html(cunt); 
	    });
	    
	    $('#submitForm').click(function(){
	        var cunt =$("#memberList").find('li').length;
	        if(cunt>1){
	            $('#formBoxRegister').submit();
	        }else{
	            $('#cuntTip').show();
	        } 
	    });
	});
		 
	
</script>
