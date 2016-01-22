<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;"> 
    <tbody valign="middle">
        <tr valign="middle">
        	<td width="45px" valign="middle">类型：</td>
        	<td width="150px">
        		<?php $send = isset($Message['send'])?$Message['send']:''; ?>        		
        		<select name="Message[send]" style="width:110px;" datatype="*" nullmsg="全部类型" id=" ">
                    <option value="">-- 全部类型 --</option>
                    <option value="1" <?php if($send==1){echo "selected";}?>>未发布</option>
                    <option value="2" <?php if($send==2){echo "selected";}?>>已发布</option>
                    <option value="4" <?php if($send==4){echo "selected";}?>>封贴</option>
                </select>
        	</td>
            <td width="45px" valign="middle" align="left">标题：</td>
            <td width="200px"><input type="text" style="width:160px;" name="Message[title]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($Message['title'])){echo $Message['title'];} ?>"></td>
            <td width="80px" valign="middle" align="left">公众号ID：</td>
            <td width="200px"><input type="text" style="width:160px;" name="Message[openid]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($Message['openid'])){echo $Message['openid'];} ?>"></td>
            <td class="search"><input type="submit" class="btn btn-primary" value=" 搜 索 "></td>
        </tr>
    </tbody>

</table> 
<?php $this->endWidget(); ?>