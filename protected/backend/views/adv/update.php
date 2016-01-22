<?php
/* @var $this AdvController */
/* @var $model Advertisement */

$this->breadcrumbs=array(
	'Advertisements'=>array('index'),
	$model->title=>array('view','id'=>$model->aid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Advertisement', 'url'=>array('index')),
	array('label'=>'Create Advertisement', 'url'=>array('create')),
	array('label'=>'View Advertisement', 'url'=>array('view', 'id'=>$model->aid)),
	array('label'=>'Manage Advertisement', 'url'=>array('admin')),
);
?>

<!--<h1>Update Advertisement <?php echo $model->aid; ?></h1>-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>