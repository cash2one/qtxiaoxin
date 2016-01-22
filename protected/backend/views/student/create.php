<div class="box">
    <div class="form tableBox">
    	<form action="" id="business-form" method="post">
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td class="td_title_Long">学生姓名* ：</td>
	                    <td>
	                        <div style="display: inline;">  
	                        	<input name="Student[name]" class="input-large" maxlength="20" datatype="*1-10" nullmsg="学生姓名不能为空！" errormsg="学生姓名长度不能大于10个字！"type="text" >
	                        </div>
	                        <span class="Validform_checktip ">学生姓名限制10个字符以内</span>
	                    </td>
	                </tr>
	                 <tr>
	                    <td class="td_title_Long">监护人* ：</td>
	                    <td class="search">
	                    </td>
	                </tr>
               
	                <tr>
	                    <td class="td_title_Long"></td>
	                    <td class="search formList">
                    		<ul class="partSub partSuc">
                    			<li>
                    				<div style="display: inline;"> 
	                    				<span class="laberName">称谓：</span>
                                        <input  data-href="" name="role[]" class="input-small" ignore="ignore" maxlength="10" datatype="callName" nullmsg="" placeholder="请输入与学生的关系" errormsg="称谓名称长度不能大于3个字！" type="text" >
                                        <span class="span1 laberName">手机：</span>
	                    				<input  data-href="<?php echo Yii::app()->createUrl('range/checkteachermobile');?>" name="mobilephone[]" class="input-small" maxlength="11" datatype="phone" nullmsg="手机号码不能为空！" errormsg="请输入正确的手机号码！" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
                                        <a href="javascript:;" class="btn btn-primary" rel="delPart" style="display:none;">删除</a>
									</div>
                                    <span class="Validform_checktip Validform_phone"></span>
                    			</li>
                    		</ul>
                    		<a href="#" class="btn btn-primary add-btn" rel="addPart">添加</a> 
	                    </td>
	                </tr>
 					<tr>
	                    <td class="td_title_Long">班级* ：</td>
	                    <td class="search">
	                    </td>
	                </tr>
               
	                <tr>
	                    <td class="td_title_Long"></td>
	                    <td class="search formList">
                    		<ul class="partSub">
                    			<li>
                    				<div style="display: inline;">
	                    				<span class="laberName">学校：</span>
                                        <select name="schoolId[]" class="selectsid input-small"  datatype="*" nullmsg="请选择学校！" url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
                                           <option value="">全部</option>
                                            <?php foreach($schools as $k=>$v):?>
                                            <option value="<?php echo $k;?>" <?php if($sid==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <span class="span1 laberName" >班级：</span>
                                        <select name="classId[]" class="selecttid input-xsmall" datatype="*" nullmsg="请选择班级！">
                                            <?php if(!count($classs)) echo '<option value="">全部</option>';?>  
                                            <?php foreach($classs as $k=>$v):?>
                                                <option value="<?php echo $k;?>" <?php if($cid==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <a href="javascript:;" class="btn btn-primary" rel="delPart"  style="display:none;">删除</a>
									</div>
									 <span class="Validform_checktip "></span>
                    			</li>
                    		</ul>
                    		<a href="#" class="btn btn-primary add-btn" rel="addPart">添加</a>
	                       
	                    </td>
	                </tr>
	            </tbody>
	        </table>
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	            	<tr>
	                    <td></td>
	                    <td></td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long"></td>
	                    <td> 
	                    	   <input type="submit" class="btn btn-primary" value="创 建">&nbsp;&nbsp;
		                       <a id="sub_cancel" href="<?php echo Yii::app()->createUrl('student/index');?>" class="btn btn-default">取消</a>
		                </td>
	                </tr>
	            </tbody>
	            <tfoot></tfoot>
	        </table>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
<script type="text/javascript">
	$(function(){
		
	 	var demo=$('#business-form').Validform({//表单验证
            tiptype:2,
            showAllError:true, 
            postonce:true,
			datatype:{//传入自定义datatype类型【方式二】;
				'phone':function(gets,obj,curform,regxp){
					var reg=/^((1)+\d{10})$/;
					//var urls=obj.data('href');
					// var errmsg=obj.attr('errormsg');
					if(reg.test(gets)){  
                        return true;
					}else{ 
					   return false;
					}
				},
				'callName':function(gets,obj,curform,regxp){
					if(gets.length > 10 ){
						return false;
					}else{
						 return true;
					}
				}
			}
        }); 

        //删除操作
		$(document).on('click', 'a[rel=delPart]', function(event) {
			var liDe=$(this).parents('ul').find('li');
			if (liDe.length == 2) {
				liDe.find('a[rel=delPart]').hide();
			}
			$(this).parents('li').remove();
		});  

		//添加操作
		$(document).on('click', 'a[rel=addPart]', function(event) {
			var html=$(this).parent().find('li');
        	if (html.length == 0) {
				html.find('[rel=delPart]').hide();
			}else{
				html.find('[rel=delPart]').show();
			};
			$(this).prev().append($(html[0]).clone());
			if($(this).prev().hasClass('partSuc')){
				$('.partSuc li').last().find('input[type=text]').val('');
			}
		}); 

		//年级联动1
		$(document).on('change', '.selectsid', function(event) { 
			var _left=$(this);
            var datas = _left.val();
            var url = _left.attr('url');
            var option ='';
            var num = 0;
            var option = '<option value="">全部</option>';
            _left.find('option:selected').attr('selected','selected').siblings().removeAttr('selected');
            if (datas){ 
                $.getJSON(url, {sid: datas, class: 1}, function (mydata) {
                    if (mydata && mydata.classs) {
                        $.each(mydata.classs, function (i, v) {
                            option = option + '<option value="' + i + '">' + v + '</option>';
                            num++;
                        }); 
                        _left.siblings(".selecttid").html(option); 
                    } 
                    if(num>0){  
                    }else{
                        option = '<option value="">全部</option>';
                        _left.siblings(".selecttid").html(option);
                    }  
                });
            } else {
                option = '<option value="">全部</option>';
               _left.siblings(".selecttid").html(option);
            }
		}); 
	});
		 
</script>
