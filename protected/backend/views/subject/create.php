<div class="box">
    <div class="form tableBox">
    	<form action="" id="business-form" method="post">
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td class="td_title_Long">科目名称* ：</td>
	                    <td>
	                        <div style="display: inline;">  
	                        	<input name="Subject[name]" class="input-large" size="10" maxlength="25" datatype="*1-20" nullmsg="科目名称不能为空！" errormsg="科目名称长度不能大于20个字！"type="text">
	                        </div>
	                        <span class="Validform_checktip ">名称限制20个字符以内</span>
	                    </td>
	                </tr>
	               
	                <tr>
	                    <td class="td_title_Long">学校* ：</td>
	                    <td>
	                        <div style="display: inline;">
                                <select  name="Subject[schoolid]" style="width:250px;" datatype="*" nullmsg="请选择学校！" id="selectsid" url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
                                    <option  value="">全部</option>
                                    <?php foreach($schools as $k=>$v):?>
                                        <option value="<?php echo $k;?>" <?php if($sid==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                                    <?php endforeach;?>
                                </select>
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
		                       <a id="sub_cancel" href="<?php echo Yii::app()->createUrl('subject/index');?>" class="btn btn-default">取消</a>
		                </td>

	                </tr>
	            </tbody>
	            <tfoot></tfoot>
	        </table>
        </form>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript">
	$(function(){
	 	$('#business-form').Validform({//表单验证
            tiptype:2,
            showAllError:true, 
            postonce:true,
			datatype:{//传入自定义datatype类型【方式二】;
				
				
			}
        }); 
	});
		 
	
</script>
