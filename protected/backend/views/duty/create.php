<div class="box">
    <div class="form tableBox">
    	<form  id="business-form" action="" method="post">
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td class="td_title_Long">名称* ：</td>
	                    <td>
	                        <div style="display: inline;">  
	                        	<input name="Duty[name]" value="" maxlength="25"
                                       datatype="*1-20" nullmsg="职务名称不能为空！" errormsg="职务名称长度不能大于20个字！"
                                       type="text" class="input-large">
	                        </div>
	                        <span class="Validform_checktip ">名称限制20个字符以内</span>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">权限范围* ：</td>
		                    <td>
		                    	<div class="Validform_checktip" style="margin:0 0 10px 0"> <input type="checkbox" id="power-range-all"> <label for="power-range-all">全选</label></div>
		                        <div id="inputCheckbox" class="Validform_checktip power-range" style=" display: inline;margin-left:0;">
                                    <?php foreach($allApplication as $key=>$val):?>
		                            <span  class="power-range-span">
		                                <input id="power-range<?php echo $val['appid']?>" value="<?php echo $val['appid']?> " type="checkbox"name="applicationid[]">
		                                <label for="power-range<?php echo $val['appid']?>"><?php echo $val['name']?></label>
		                            </span> 
		                           <?php endforeach;?>
		                       		<span class="Validform_checktip "><span class="Validform_checktip " id="power-range-tip"></span></span>
		                        </div>  
		                    </td>
	                </tr>
	                <tr>
	                     <td class="td_title_Long">权限级别* ：</td>
		                    <td>
		                        <div class="Validform_checktip power-grade" style=" display: inline;margin-left:0;" >
		                            <span class="power-range-span">
		                                <input id="power-grade1"  checked="checked" type="radio" value="2"  name="Duty[isseeallclass]">
		                                <label for="power-grade1">全校</label>
		                            </span> 
		                            <span class="power-range-span">
		                                <input id="power-grade2"  type="radio" value="1"  name="Duty[isseeallclass]">
		                                <label for="power-grade2">年级</label>
		                            </span> 
		                            <span class="power-range-span">
		                                <input id="power-grade3" type="radio" value="0" name="Duty[isseeallclass]">
		                                <label for="power-grade3">班级</label>
		                            </span> 
		                     
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
	                    		<input type="submit" class="btn btn-primary" value="创 建" id="power-submit">&nbsp;&nbsp;
		                       <a id="sub_cancel" href="<?php echo Yii::app()->createUrl('duty/index');?>" class="btn btn-default">取消</a>
		                </td> 
	                </tr>
	            </tbody>
	            <tfoot></tfoot>
	        </table>
        </form>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
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
         //判断是否全部选中
       function inputChecked(oInputBox,allChecked){
           var _this ="#"+oInputBox;
           var _thisCheckedAll ="#"+allChecked;
           var oItmeList = $(_this).find('input[type=checkbox]');
           var InputChecked = $(_this).find('input[type=checkbox]:checked');
           if(oItmeList.length==InputChecked.length){
               $(_thisCheckedAll).attr('checked','checked');
           }else{
                $(_thisCheckedAll).removeAttr('checked');
           } 
       } 
       $(document).on('change','#inputCheckbox input[type=checkbox]',function(event){
           inputChecked('inputCheckbox','power-range-all');
       });
	  //全选与不选
      $('#power-range-all').on('change', function(event) {
      	     var _left=$(this);
      	     if ($(this).is(':checked')) {
      	     	_left.parent().next().find('input').attr('checked','checked');
      	     	$('#power-range-tip').removeClass('Validform_wrong').addClass('Validform_right').text('通过信息验证！')
      	     }else{
      	     	_left.parent().next().find('input').removeAttr('checked');
      	     	$('#power-range-tip').removeClass('Validform_right').addClass('Validform_wrong').text('请选择权限范围！')
      	     };
      });
      $('.power-range').on('click', 'input', function(event) {
      		 var _left=$(this),
      	     	 inputL=_left.parents('.power-range').find('input').length,
      	     	 inputCheckL=_left.parents('.power-range').find('input:checked').length;
      	     if (inputCheckL == inputL) {
      	     	$('#power-range-all').attr('checked','checked');
      	     }else{
      	     	$('#power-range-all').removeAttr('checked');
      	     };
      	     if (inputCheckL == 0) {
      	     	$('#power-range-tip').removeClass('Validform_right').addClass('Validform_wrong').text('请选择权限范围！')
      	     }else{
      	     	$('#power-range-tip').removeClass('Validform_wrong').addClass('Validform_right').text('通过信息验证！')
      	     };
      });

      //权限范围必选1个才能提交
      $('#power-submit').on('click', function(event) {
      	   var inputCheckL=$('.power-range').find('input:checked').length;
      	   if (inputCheckL == 0) {
      	   		$('#power-range-tip').removeClass('Validform_right').addClass('Validform_wrong').text('请选择权限范围！')
      	   		return false;
      	   }else{
      	   		$('#business-form').submit();
      	   };
      });
	})
</script>
