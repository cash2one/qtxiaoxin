<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <td width="45px">商家：</td>
        <td width="130px">
            <?php $bid = isset($Information['bid'])?$Information['bid']:''; ?>
            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('empty' => '--全部商家--','options' => array($bid=>array('selected'=>true)))); ?>
        </td>

        <td width="45px">属性：</td>
        <td width="130px">
            <?php $type = isset($Information['contype'])?$Information['contype']:''; ?>
            <?php echo $form->dropDownList($model,'contype',array('business'=>'商业资讯','public'=>'开放资讯'),array('empty' => '--全部属性--','options' => array($type=>array('selected'=>true)))); ?>
        </td>
         <td width="75px">资讯标题：</td>
        <td width="260px"><input class="searchW260" style="width:240px;"  type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  name="Information[title]" value="<?php if(isset($Information['title'])){echo $Information['title'];} ?>"></td>
        <td class="search"><input type="submit" class="btn btn-primary" value="搜 索"></td>
    </tr> 
</table>
<?php $this->endWidget(); ?>