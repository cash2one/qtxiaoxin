<?php
/* @var $this MallGoodsCardController */
/* @var $data MallGoodsCard */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('mgcid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->mgcid), array('view', 'id'=>$data->mgcid)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mgid')); ?>:</b>
	<?php echo CHtml::encode($data->mgid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('number')); ?>:</b>
	<?php echo CHtml::encode($data->number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('starttime')); ?>:</b>
	<?php echo CHtml::encode($data->starttime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endtime')); ?>:</b>
	<?php echo CHtml::encode($data->endtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sold')); ?>:</b>
	<?php echo CHtml::encode($data->sold); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('state')); ?>:</b>
	<?php echo CHtml::encode($data->state); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('creationtime')); ?>:</b>
	<?php echo CHtml::encode($data->creationtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatetime')); ?>:</b>
	<?php echo CHtml::encode($data->updatetime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deleted')); ?>:</b>
	<?php echo CHtml::encode($data->deleted); ?>
	<br />

	*/ ?>

</div>