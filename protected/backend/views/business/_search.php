
<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr>
        <td style="width:75px;">商家名称：</td>
        <td width="260px"><input style="width: 240px;" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  type="text" name="Business[name]" value="<?php if(isset($Business['name'])){echo $Business['name'];} ?>"></td>

        <td width="45px"> 类型：</td>
        <td width="130px">
            <?php $mall = isset($Business['mall'])?$Business['mall']:''; ?>
            <select name="Business[mall]" id="Business_mall">
                <option value="">--全部--</option>
                <option value="0" <?php if($mall=='0'){?>selected="selected"<?php } ?> >普通商家</option>
                <option value="1" <?php if($mall=='1'){?>selected="selected"<?php } ?> >商城商家</option>
            </select>
        </td>
        <td width="45px"> 状态：</td>
        <td width="130px">
            <?php $state = isset($Business['state'])?$Business['state']:''; ?>
            <select name="Business[state]" id="Business_state">
                <option value="">--全部--</option>
                <option value="0" <?php if($state=='0'){?>selected="selected"<?php } ?> >下架</option>
                <option value="1" <?php if($state=='1'){?>selected="selected"<?php } ?> >上架</option>
            </select>
        </td>
    	<td class="search"><input type="submit" class="btn btn-primary" value="搜索"></td>
    </tr> 
</table>
<?php $this->endWidget(); ?>