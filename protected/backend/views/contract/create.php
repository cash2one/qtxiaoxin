<?php
/* @var $this ContractController */
/* @var $model Contract */

$this->breadcrumbs=array(
	'Contracts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Contract', 'url'=>array('index')),
	array('label'=>'Manage Contract', 'url'=>array('admin')),
);
?>

<!--<h1>Create Contract</h1>-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>