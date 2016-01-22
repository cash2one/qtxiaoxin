 <div class="box">

    <div class="viweInfo" style="">
        <p><span class="leftTitle">广告标题：</span><?php echo $model->title; ?></p>
        <p><span class="leftTitle">广告摘要：</span><?php echo $model->summery; ?></p>
        <?php if($model->url){ ?>
            <p><span class="leftTitle">广告链接：</span><?php echo $model->url; ?></p>
        <?php }?>
        <div class="pic">
            <span style="width: 85px; color: #999999; float: left;">广告图片：</span>
            <img src="<?php echo $model->image; ?>">
        </div>
        <div class="tableBox" style=" overflow: hidden; ">
            <span style=" color: #999999; float: left;">广告文字：</span>
            <div style="margin-left: 85px; ">
                <?php echo $model->text; ?>
            </div> 
        </div>
    </div>  
</div>

