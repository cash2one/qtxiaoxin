<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr>
    	<td width="45px">状态：</td>
        <td width="130px">
            <?php $state = isset($Contract['state'])?$Contract['state']:'';  ?>
            <select name="Contract[state]" id="Contract_state">
                <option value="">--全部状态--</option>
                <?php if($this->getAction()->getId()!='document'){ ?>
                    <option value="0" <?php if($state=='0'){?>selected="selected"<?php } ?> >未提交</option>
                <?php } ?>
                <option value="1" <?php if($state=='1'){?>selected="selected"<?php } ?> >待审批</option>
                <option value="2" <?php if($state=='2'){?>selected="selected"<?php } ?>>已通过</option>
                <option value="3" <?php if($state=='3'){?>selected="selected"<?php } ?>>未通过</option>
            </select>
        </td>
        
        <td width="45px"> 商家：</td>
        <td width="170px">
            <?php $bid = isset($Contract['bid'])?$Contract['bid']:''; ?>
            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('class'=>'lag','empty' => '--全部商家--','options' => array($bid=>array('selected'=>true)))); ?>
        </td>
        <td width="75px">合同编号：</td>
        <td width="200px"><input class="searchW260" style="width:180px;" type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  name="Contract[contractid]" value="<?php if(isset($Contract['contractid'])){echo $Contract['contractid'];} ?>"></td>
    	<td class="search"><input type="submit" class="btn btn-primary" value="搜索"></td>
    </tr> 
</table>
<?php $this->endWidget(); ?>