<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <td width="45px"> 商家：</td>
        <td width="130px">
            <?php $bid = isset($Focus['bid'])?$Focus['bid']:''; ?>
            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('empty' => '--全部商家--','options' => array($bid=>array('selected'=>true)))); ?>
        </td>
        <td width="45px"> 类型：</td>
        <td width="130px">
            <?php $type = isset($Focus['type'])?$Focus['type']:''; ?>
            <?php echo $form->dropDownList($model,'type',Focus::getTypeArr(),array('empty' => '--全部类型--','options' => array($type=>array('selected'=>true)))); ?>
        </td>

        <td width="45px"> 属性：</td>
        <td width="130px">
            <?php $cty = isset($Focus['contype'])?$Focus['contype']:''; ?>
            <?php echo $form->dropDownList($model,'contype',array('business'=>'商业热点','public'=>'开放热点'),array('empty' => '--全部属性--','options' => array($cty=>array('selected'=>true)))); ?>
        </td>
        <td width="75px">热点标题：</td>
        <td width="260px"><input class="searchW260" style="width:240px;" type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  name="Focus[title]" value="<?php if(isset($Focus['title'])){echo $Focus['title'];} ?>"></td>
        <td class="search"><input type="submit" class="btn btn-primary" value="搜索"></td>
    </tr> 
</table>
<?php $this->endWidget(); ?>