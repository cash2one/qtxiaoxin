<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <td width="75px"> 商家名称：</td>
        <td width="170px">
            <?php $bid = isset($Advertisement['bid'])?$Advertisement['bid']:''; ?>
            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('class'=>'lag','empty' => '--选择商家--','options' => array($bid=>array('selected'=>true)))); ?>
        </td>

        <td width="75px"> 合同配置：</td>
        <td width="130px">
            <?php $type = isset($Advertisement['contype'])?$Advertisement['contype']:''; ?>
            <?php echo $form->dropDownList($model,'contype',Focus::getConTypeArr(),array('empty' => '--全部类型--','options' => array($type=>array('selected'=>true)))); ?>
        </td>
         <td width="75px">广告标题：</td>
        <td width="200px"><input class="searchW260"  style="width:180px;"  type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  name="Advertisement[title]" value="<?php if(isset($Advertisement['title'])){echo $Advertisement['title'];} ?>"></td>
        <td class="search"><input type="submit" class="btn btn-primary" value="搜 索"></td>
    </tr> 
</table>
<?php $this->endWidget(); ?>