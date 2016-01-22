<?php
/* @var $this BusinessController */
/* @var $model Business */

$this->breadcrumbs=array(
	'Businesses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Business', 'url'=>array('index')),
	array('label'=>'Create Business', 'url'=>array('create')),
	array('label'=>'Update Business', 'url'=>array('update', 'id'=>$model->bid)),
	array('label'=>'Delete Business', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->bid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Business', 'url'=>array('admin')),
);
?>

<!--<h1>View Business #<?php //echo $model->bid; ?></h1>-->
<div class="box">
    <div class="viweInfo" style="">
        <p><span class="leftTitle">商家LOGO：</span> <img width="130" height="100" src="<?php echo $model->logo; ?>"></p>
        <div class="pic">   
            <p><span class="leftTitle" >商家大图：</span><img width="640" height="300" src="<?php echo $model->image; ?>"></p>  
        </div>
        <p><span class="leftTitle">商家名称：</span><?php echo $model->name; ?></p>
        <p><span class="leftTitle">商家类型：</span><?php echo $model->getMallDataName(); ?></p>
        <p><span class="leftTitle">负责人：</span><?php echo $model->contacter; ?></p>
        <p><span class="leftTitle">企业电话：</span><?php echo $model->phone; ?></p>
        <p><span class="leftTitle">商家地址：</span><?php echo $model->address; ?></p>
        <?php $x = 0; foreach($addrs as $addr): ?>
            <p><span class="leftTitle"><?php echo $x==0?'分店信息：':'&nbsp;'; ?></span><?php echo $addr->name . ', ' . $addr->address; ?></p>
        <?php $x++; endforeach; ?>
        <div>
            <span style="width: 85px; color: #999999; float: left;"  class="leftTitle">介绍：</span>
            <div style=" margin-left: 85px;"><?php echo $model->introduction; ?></div>
        </div>
    </div>   
</div>
