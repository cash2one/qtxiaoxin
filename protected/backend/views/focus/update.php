<?php
/* @var $this FocusController */
/* @var $model Focus */

$this->breadcrumbs=array(
	'Focuses'=>array('index'),
	$model->title=>array('view','id'=>$model->fid),
	'Update',
);

$this->menu=array(
	array('label'=>'List Focus', 'url'=>array('index')),
	array('label'=>'Create Focus', 'url'=>array('create')),
	array('label'=>'View Focus', 'url'=>array('view', 'id'=>$model->fid)),
	array('label'=>'Manage Focus', 'url'=>array('admin')),
);
?>

<!--<h1>Update Focus <?php echo $model->fid; ?></h1>-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>