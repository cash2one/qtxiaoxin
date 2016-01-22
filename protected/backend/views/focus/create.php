<?php
/* @var $this FocusController */
/* @var $model Focus */

$this->breadcrumbs=array(
	'Focuses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Focus', 'url'=>array('index')),
	array('label'=>'Manage Focus', 'url'=>array('admin')),
);
?>

<!--<h1>Create Focus</h1>-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>