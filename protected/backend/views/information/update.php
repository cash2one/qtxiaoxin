<?php
/* @var $this InformationController */
/* @var $model Information */

$this->breadcrumbs=array(
	'Informations'=>array('index'),
	$model->title=>array('view','id'=>$model->iid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Information', 'url'=>array('index')),
	array('label'=>'Create Information', 'url'=>array('create')),
	array('label'=>'View Information', 'url'=>array('view', 'id'=>$model->iid)),
	array('label'=>'Manage Information', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>