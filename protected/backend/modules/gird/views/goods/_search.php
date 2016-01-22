<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;"> 
    <tbody valign="middle">
        <tr valign="middle">
            <td width="45px"> 商家：</td>
            <td width="130px">
                <?php $bid = isset($MallGoods['bid'])?$MallGoods['bid']:''; ?>
                <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('empty' => '--全部商家--','options' => array($bid=>array('selected'=>true)))); ?>
            </td>

            <td width="45px"> 类型：</td>
            <td width="130px">
                <?php $type = isset($MallGoods['type'])?$MallGoods['type']:''; ?>
                <?php echo $form->dropDownList($model,'type',MallGoods::getGoodTypeArr(),array('empty' => '--全部类型--','options' => array($type=>array('selected'=>true)))); ?>
            </td> 
            <td width="75px" valign="middle">商品名称：</td>
            <td width="260px"><input type="text" style="width:240px;" name="MallGoods[name]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($MallGoods['name'])){echo $MallGoods['name'];} ?>"></td>
            <td class="search"><input type="submit" class="btn btn-primary" value=" 搜 索 "></td>
        </tr>
    </tbody>

</table> 
<?php $this->endWidget(); ?>