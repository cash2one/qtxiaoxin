<?php $item_char = array('1'=>'A','2'=>'B', '3'=>'C','4'=>'D','5'=>'E','6'=>'F','7'=>'G','8'=>'H','9'=>'I','10'=>'J')?>
<tr class="inputBox">
    <td class="td_label"><?php echo $item_char[$tnum]; ?>选项</td> 
	<td>
		<div style="display: inline;">
			<input rel="t" size="100" maxlength="80"  name="FocusQuestion[<?php echo $qnum; ?>][item][<?php echo $tnum; ?>]" type="text" value="" datatype="*1-50" nullmsg="不能为空！" errormsg="不得多于50个字！">
		</div>
        <span class="Validform_checktip">选项限制50字以内</span>
        <span style="display: none;"  class="tipB Validform_checktip Validform_wrong">不能为空！</span>
        <span style="display: none;" class="tipWrong Validform_checktip Validform_wrong">&nbsp;只能输入50字以内！</span>
        
		<?php if($tnum>2){ ?>
			<a href="javascript:void(0);" class="deleInput">删 除</a> 
		<?php } ?> 
	</td>
</tr>

 

