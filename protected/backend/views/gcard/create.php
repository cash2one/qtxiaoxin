<?php
/* @var $this MallGoodsCardController */
/* @var $model MallGoodsCard */

$this->breadcrumbs=array(
	'Mall Goods Cards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MallGoodsCard', 'url'=>array('index')),
	array('label'=>'Manage MallGoodsCard', 'url'=>array('admin')),
);
?> 
<?php $this->renderPartial('_form', array('model'=>$model)); ?>