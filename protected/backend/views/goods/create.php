<?php
/* @var $this GoodsController */
/* @var $model MallGoods */

$this->breadcrumbs=array(
	'Mall Goods'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List MallGoods', 'url'=>array('index')),
	array('label'=>'Manage MallGoods', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model, 'province_list'=>$province_list)); ?>