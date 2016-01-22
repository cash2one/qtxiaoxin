<?php
/* @var $this AdvController */
/* @var $model Advertisement */

$this->breadcrumbs=array(
	'Advertisements'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Advertisement', 'url'=>array('index')),
	array('label'=>'Manage Advertisement', 'url'=>array('admin')),
);
?> 
<?php $this->renderPartial('_form', array('model'=>$model)); ?>