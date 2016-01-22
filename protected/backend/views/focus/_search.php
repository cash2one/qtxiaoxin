<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <td width="75px"> 商家名称：</td>
        <td width="170px">
            <?php $bid = isset($Focus['bid'])?$Focus['bid']:''; ?>
            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('class'=>'lag','empty' => '--全部商家--','options' => array($bid=>array('selected'=>true)))); ?>
        </td>
        <td width="45px"> 类型：</td>
        <td width="130px">
            <?php $type = isset($Focus['type'])?$Focus['type']:''; ?>
            <?php echo $form->dropDownList($model,'type',Focus::getTypeArr(),array('empty' => '--全部类型--','options' => array($type=>array('selected'=>true)))); ?>
        </td>

        <td width="75px"> 合同配置：</td>
        <td width="130px">
            <?php $type = isset($Focus['contype'])?$Focus['contype']:''; ?>
            <?php echo $form->dropDownList($model,'contype',Focus::getConTypeArr(),array('empty' => '--全部类型--','options' => array($type=>array('selected'=>true)))); ?>
        </td>
        <td width="75px">热点标题：</td>
        <td width="180px"><input class="searchW260" style="width:160px;" type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  name="Focus[title]" value="<?php if(isset($Focus['title'])){echo $Focus['title'];} ?>"></td>
        <td class="search"><input type="submit" class="btn btn-primary" value="搜索"></td>
    </tr> 
</table>
<?php $this->endWidget(); ?>