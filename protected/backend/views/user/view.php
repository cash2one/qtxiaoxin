<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->uid)),
	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->uid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>
 
<div class="box"> 
<div class="viweInfo" style="">
        <div class="pic">
            <img width="120px;" height="120px;" src="<?php echo $model->logo; ?>">
        </div>
        <p><span>账号名：</span><?php echo $model->username; ?></p>
        <p><span>真实姓名：</span><?php echo $model->name; ?></p> 
        <p><span>联系电话：</span><?php echo $model->mobile; ?></p>
        <p><span>邮箱：</span><?php echo $model->mail; ?></p>
        <p><span>QQ：</span><?php echo $model->qq; ?></p>
    </div>   
</div>

