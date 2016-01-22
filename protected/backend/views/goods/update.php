<?php
/* @var $this GoodsController */
/* @var $model MallGoods */

$this->breadcrumbs=array(
	'Mall Goods'=>array('index'),
	$model->name=>array('view','id'=>$model->mgid),
	'Update',
);

$this->menu=array(
	array('label'=>'List MallGoods', 'url'=>array('index')),
	array('label'=>'Create MallGoods', 'url'=>array('create')),
	array('label'=>'View MallGoods', 'url'=>array('view', 'id'=>$model->mgid)),
	array('label'=>'Manage MallGoods', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'subs'=>$subs, 'province_list'=>$province_list)); ?>