<?php
/* @var $this MallGoodsCardController */
/* @var $model MallGoodsCard */

$this->breadcrumbs=array(
	'Mall Goods Cards'=>array('index'),
	$model->mgcid=>array('view','id'=>$model->mgcid),
	'Update',
);

$this->menu=array(
	array('label'=>'List MallGoodsCard', 'url'=>array('index')),
	array('label'=>'Create MallGoodsCard', 'url'=>array('create')),
	array('label'=>'View MallGoodsCard', 'url'=>array('view', 'id'=>$model->mgcid)),
	array('label'=>'Manage MallGoodsCard', 'url'=>array('admin')),
);
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>