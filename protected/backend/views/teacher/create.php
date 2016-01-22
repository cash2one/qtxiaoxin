<div class="box">
    <div class="form tableBox">
    	<form action="" id="business-form" method="post">
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td class="td_title_Long">教师姓名* ：</td>
	                    <td>
	                        <div style="display: inline;">  
	                        	<input  name="Teacher[name]" class="input-large" maxlength="20" datatype="*1-10" nullmsg="教师姓名不能为空！" errormsg="教师姓名长度不能大于10个字！"type="text" >
	                        </div>
	                        <span class="Validform_checktip ">教师姓名限制10个字符以内</span>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">绑定手机* ：</td>
	                    <td>
	                        <div style="display: inline;">  
	                        	<input  data-href="<?php echo Yii::app()->createUrl('range/checkteachermobile');?>" name="Teacher[mobilephone]" class="input-large" maxlength="11" datatype="phone" nullmsg="手机号码不能为空！" errormsg="请输入正确的手机号码！" type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
	                        </div>
	                        <span class="Validform_checktip Validform_phone"></span>
	                    </td>
	                </tr>

	                 <tr>
	                    <td class="td_title_Long">部门 ：</td>
	                    <td class="search">
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long"></td>
	                    <td class="search formList">
                    		<ul class="partSub">
                    			<li>
                    				<div style="display: inline;">
	                    				<span class="laberName">学校：</span><select name="sid[]" class="selectsid input-small"   url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
	                    				<option value="">全部</option>
                                            <?php foreach($schools as $k=>$v):?>
                                                <option value="<?php echo $k;?>" <?php if($sid==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                                            <?php endforeach;?>
										</select><span class="span1 laberName">部门：</span>
                                        <select name="did[]" class="selecttid input-xsmall">
                                        <option value="">全部</option>
                                        <?php if($dids):?>
                                            <?php foreach($dids as $k=>$v):?>
                                                    <option value="<?php echo $k;?>" ><?php echo $v;?></option>
                                            <?php endforeach;?>
                                        <?php endif;?>
										</select>
                                        <span class="span1 laberName">职务：</span>
                                        <select class="selectDuty" name="duty[]" url="<?php echo Yii::app()->createUrl('teacher/getgrade' );?>">
                                            <<option value="" class="optionId">设置职务</option>
                                            <?php foreach($allDuty as $key=>$val):?>
                                                <option value="<?php echo $val['dutyid']?>"><?php echo $val['name'];?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <div class="gradeClass" style="display: none;">
                                            <span class="span1 laberName">年级：</span>
                                            <select class="gradeSelect" name="grade[]">
                                             </select>
                                        </div>
                                        <a href="javascript:;" class="btn btn-primary" rel="delPart"  style="display:none;">删除</a>
                                    </div>
									 <span class="Validform_checktip "></span>
                    			</li>
                    		</ul>
                    		<a href="#" class="btn btn-primary add-btn" rel="addPart">添加</a>
	                       
	                    </td>
	                </tr>
                    <tr>
                        <td class="td_title_Long">班级 ：</td>
                        <td class="search">
                        </td>
                    </tr>
                    <tr>
                        <td class="td_title_Long"></td>
                        <td class="search formList">
                            <ul class="partSub_class" style=" list-style: outside none none;padding: 0;">
                                <li style="margin-bottom: 15px;">
                                    <div style="display: inline;">
                                        <span class="laberName">学校：</span><select name="classsid[]" class="selectclasssid input-small"   url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
                                            <option value="">全部</option>
                                            <?php foreach($schools as $k=>$v):?>
                                                <option value="<?php echo $k;?>" <?php if($sid==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                                            <?php endforeach;?>
                                        </select><span class="span1 laberName" style="margin-left:20px;">班级：</span>
                                        <select name="cid[]" class="selectcid input-xsmall">
                                            <option value="">请选择班级</option>
                                            <?php if(is_array($classs)):?>
                                                <?php foreach($classs as $k=>$v):?>
                                                    <option value="<?php echo $k;?>" ><?php echo $v;?></option>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </select>
                                        <span class="span1 laberName" style="margin-left:20px;">科目：</span>
                                        <select class="selectsubjet" name="subject[]" >
                                            <option value="" class="optionId">请选择科目</option>
                                            <option value="0" class="optionId">班主任</option>
                                            <?php foreach($subjects as $key=>$val):?>
                                                <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                            <?php endforeach;?>
                                        </select>

                                        <a href="javascript:;" class="btn btn-primary" rel="delPart"  style="display:none;">删除</a>
                                    </div>
                                    <span class="Validform_checktip "></span>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary add-btn" rel="addClass">添加</a>

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
		                       <a id="sub_cancel" href="<?php echo Yii::app()->createUrl('teacher/index');?>" class="btn btn-default">取消</a>
		                </td>

	                </tr>
	            </tbody>
	            <tfoot></tfoot>
	        </table>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js" ></script>
<script type="text/javascript">
	$(function(){
		
	 	var demo=$('#business-form').Validform({//表单验证
            tiptype:2,
            showAllError:true, 
            postonce:true,
			datatype:{//传入自定义datatype类型【方式二】;
				'phone':function(gets,obj,curform,regxp){
					var reg=/^((1)+\d{10})$/;
					var urls=obj.data('href');
					// var errmsg=obj.attr('errormsg');
					if(reg.test(gets)){
						$.getJSON(urls, {mobilephone: gets}, function (mydata) {
							if(mydata.isBind == 1){

								obj.parent().siblings('.Validform_phone').find('.Validform_checktip').addClass('Validform_wrong').text('该手机已绑定');
								demo.setStatus('posting');
								return false;
								
							}else{
								demo.setStatus('normal');
								return true;
							}
	                	});

					}else{

						return false;
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
			var html=$('.partSub').find('li');
        	if (html.length == 0) {
				html.find('[rel=delPart]').hide();
			}else{
				html.find('[rel=delPart]').show();
			};
			$(this).prev().append($(html[0]).clone());
            var lastHtml=$(this).parent().find('li').last();
			lastHtml.find('.selecttid .optionId').attr('selected','selected').siblings().removeAttr('selected');
            lastHtml.find('.gradeClass').hide();
            lastHtml.find('.selectDuty option').removeAttr('selected');
		});
        //添加操作
        $(document).on('click', 'a[rel=addClass]', function(event) {
            var html=$('.partSub_class').find('li');
            if (html.length == 0) {
                html.find('[rel=delPart]').hide();
            }else{
                html.find('[rel=delPart]').show();
            };
            $(this).prev().append($(html[0]).clone());
            var lastHtml=$(this).parent().find('li').last();
            lastHtml.find('.selecttid .optionId').attr('selected','selected').siblings().removeAttr('selected');
            lastHtml.find('.gradeClass').hide();
            lastHtml.find('.selectDuty option').removeAttr('selected');
        });

        //年级联动1
		$(document).on('change', '.selectsid', function(event) {
			var _left=$(this);
            var datas = $(this).val();
            var url = $(this).attr('url');
            var option = '<option value="">全部</option>';
            _left.find('option:selected').attr('selected','selected').siblings().removeAttr('selected');
            if (datas) {
                $.getJSON(url, {sid: datas, department: 1}, function (mydata) {
                    if (mydata && mydata.departments) {
                        $.each(mydata.departments, function (i, v) {
                            option = option + '<option value="' + i + '">' + v + '</option>';
                        });
                    }
                    _left.siblings(".selecttid").html(option);
                });
            } else {
               _left.siblings(".selecttid").html(option);
            }
		});
        //年级联动1
        $(document).on('change', '.selectclasssid', function(event) {
            var _left=$(this);
            var datas = $(this).val();

            var url = $(this).attr('url');
            var option = '<option value="">请选择班级</option>';
            var option_subject = '<option value="">请选择科目</option>';
            var option_subject =option_subject+ '<option value="0">班主任</option>';
            _left.find('option:selected').attr('selected','selected').siblings().removeAttr('selected');
            if (datas) {
                $.getJSON(url, {sid: datas, subject: 1,"class":1}, function (mydata) {
                    if (mydata && mydata.classs) {
                        $.each(mydata.classs, function (i, v) {
                            option = option + '<option value="' + i + '">' + v + '</option>';
                        });
                    }
                    if (mydata && mydata.subjects) {
                        $.each(mydata.subjects, function (i, v) {
                            option_subject = option_subject + '<option value="' + i + '">' + v + '</option>';
                        });
                    }
                    _left.siblings(".selectcid").html(option);
                    _left.siblings(".selectsubjet").html(option_subject);
                });
            } else {
                _left.siblings(".selecttid").html(option);
                _left.siblings(".selectsubjet").html(option_subject);
            }
        });
        
        $(document).on('change', '.selectDuty', function(event) {
            var _left=$(this);
            var datas = $(this).val();
            var schooid =_left.siblings('.selectsid').val(); 
            var url = $(this).attr('url');
            var option = '';
            if(schooid!=""){
                $.getJSON(url, {schoolid: schooid, duty: datas}, function (mydata) {
                    if (mydata.state=="1") {
                        _left.siblings(".gradeClass").css('display',"inline");
                        var jsonval = $.parseJSON(mydata.gradeArr);
                        $.each(jsonval, function (i, v) {
                            option = option + '<option value="' + i + '">' + v + '</option>';
                        });
                        _left.siblings(".gradeClass").find('.gradeSelect').html(option);
                    }else{
                         _left.siblings(".gradeClass").hide();
                    } 
                });
            }else{
                alert("请选择学校！ ");
            } 
        });
       
	});
		 
</script>
