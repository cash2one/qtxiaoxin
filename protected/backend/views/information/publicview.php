<div class="box"> 
    <div class="viweInfo" style="">
        <p><span class="leftTitle">资讯分类：</span><?php echo InformationKind::getInfoKindName($model->ikid);?></p>
        <p><span class="leftTitle">头条设置：</span><?php if($model->head){echo "是";}else{echo "否";} ?><?php if($model->kindtop){echo "（置顶）";}else{echo " ";} ?></p>
        <p><span class="leftTitle">资讯来源：</span><?php echo $model->source; ?></p>
        <p><span class="leftTitle">起始时间：</span><?php echo date('Y-m-d',strtotime($model->getPublicInfoStartdate())); ?></p>
        <p><span class="leftTitle">标题：</span><?php echo $model->title; ?></p>
        <p><span class="leftTitle">链接：</span><?php echo $model->url; ?></p>
        <p><span class="leftTitle">描述：</span><?php echo $model->summery; ?></p>
        <div class="picBox">
            <span class="titleL">内容：</span>
            <div class="contentS">
                <?php echo $model->text; ?>
            </div>
        </div>  
        <div class="picBox">
            <span class="titleL">小图：</span>
            <div class="contentI" style=" width: 226px; height: 208px; " >
                <p style=" width: 226px; height: 208px; "><img src="<?php echo $model->image; ?>"></p>
            </div>
        </div>
        
        <div class="picBox">
            <span class="titleL">大图：</span>
            <div class="contentI" style=" width: 640px; height: 300px; " >
                <p>
                    <img src="<?php echo $model->bigimage; ?>">
                </p>
            </div>
        </div>
        
    </div>  
</div>

