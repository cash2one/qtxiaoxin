<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <td width="45px"> 商家：</td>
        <td width="130px">
            <?php $bid = isset($Advertisement['bid'])?$Advertisement['bid']:''; ?>
            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('empty' => '--全部商家--','options' => array($bid=>array('selected'=>true)))); ?>
        </td>

        <td width="45px"> 属性：</td>
        <td width="130px">
            <?php $type = isset($Advertisement['contype'])?$Advertisement['contype']:''; ?>
            <?php echo $form->dropDownList($model,'contype',array('business'=>'商业广告','public'=>'开放广告'),array('empty' => '--全部属性--','options' => array($type=>array('selected'=>true)))); ?>
        </td>
         <td width="75px">广告标题：</td>
        <td width="260px"><input class="searchW260" style="width:240px;"  type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  name="Advertisement[title]" value="<?php if(isset($Advertisement['title'])){echo $Advertisement['title'];} ?>"></td>
        <td class="search"><input type="submit" class="btn btn-primary" value="搜 索"></td>
    </tr> 
</table>
<?php $this->endWidget(); ?>