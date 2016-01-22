 <h3><?php echo $model->title; ?></h3> 
<div class="prompt">
      <img src="<?php echo $model->image; ?>">
 </div>
   <div class="centent">  
        <p><?php echo $model->summery; ?></p>
        <?php if($model->url){ ?>
            <p><span class="leftTitle">广告链接：</span><?php echo $model->url; ?></p>
        <?php }?> 
        <div class="tableBox" style=" table-layout:fixed; word-break: break-all; overflow:hidden; "> 
            <?php echo $model->text; ?> 
        </div>
         
    </div>  
    