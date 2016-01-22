<div class="box"> 
    <div class="viweInfo" style="">
        <p><span class="leftTitle" >所属商家：</span><?php echo Business::getBusinessName($model->bid); ?></p>
        <p><span class="leftTitle">商品类型：</span><?php echo MallGoods::getGoodTypeName($model->type);?></p>
        <p><span class="leftTitle">商品分类：</span><?php echo MallGoodsKind::getMallGoodsKindName($model->mgkid);?></p>
        <p><span class="leftTitle">推荐设置：</span><?php echo $model->hot?'推荐':'非推荐'; ?></p>
        <p><span class="leftTitle">有效期：</span>
            <?php if($model->mallstarttime && $model->mallendtime){ echo date('Y-m-d',strtotime($model->mallstarttime)).' 至 '.date('Y-m-d',strtotime($model->mallendtime));}else{ echo '无'; } ?>
        </p>
        <p><span class="leftTitle">商品序号：</span><?php echo $model->sort==1000?'':$model->sort; ?></p>
        <p><span class="leftTitle">需要青豆：</span><?php echo $model->integration; ?></p>
        <p><span class="leftTitle">库存：</span><?php echo $model->number; ?></p>
        <p><span class="leftTitle">折扣值：</span><?php echo $model->discount; ?></p>
        <p><span class="leftTitle">兑换限制：</span><?php echo $model->quotas; ?></p>

        <p><span class="leftTitle">特卖活动：</span><?php echo $model->sale?'是':'否'; ?></p>
        <?php if($model->sale): ?>
        <p><span class="leftTitle">特卖时段：</span><?php echo date('Y-m-d H:i',strtotime($model->starttime)); ?>&nbsp;至&nbsp;<?php echo date('Y-m-d H:i',strtotime($model->endtime)); ?></p>
            <p><span class="leftTitle">特卖折扣：</span><?php echo $model->salediscount; ?></p>
            <p><span class="leftTitle">特卖数量：</span><?php echo $model->salenumber; ?></p>
        <?php endif; ?>
        <p><span class="leftTitle">标题：</span><?php echo $model->name; ?></p>
        <p><span class="leftTitle">简介：</span><?php echo $model->summery; ?></p>
        <p><span class="leftTitle">订购条件：</span><?php echo $model->condition; ?></p>
        <p><span class="leftTitle">兑换指引：</span><?php echo strip_tags($model->guide); ?></p>
        <p><span class="leftTitle">可见范围：</span><?php echo $model->visible>0?MallGoods::getVisibleArr()[$model->visible]:'老师家长均不可见'; ?></p>
        <?php $x = 0; foreach($subs as $sub): ?>
            <p><span class="leftTitle"><?php echo $x==0?'取货地址：':'&nbsp;'; ?></span><?php echo $sub->name . ', ' . $sub->address; ?></p>
        <?php $x++; endforeach; ?>
        <div class="picBox">
            <span class="titleL">上架区域：</span>
            <div class="content">
                <div class="checkRegionBox " style=" display: inline-block;">
                    <ul class="checkList">
                    <?php foreach(explode(",",$model->range) as $aid): ?> 
                        <li><input type="hidden" class="hide" name="MallGoods[aids][]" value="<?php echo $aid; ?>"><?php echo Area::getAreaNameWithCity($aid); ?></li>
                    <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="picBox">
            <span class="titleL">描述：</span>
            <div class="content">
                <?php echo $model->remark; ?>
            </div>
        </div>
        
        <div class="picBox">
            <span class="titleL">小图：</span>
            <div class="contentI" style=" width: 226px; height: 208px; " >
                <img src="<?php echo $model->image; ?>">
            </div>
        </div>
        
        <div class="picBox">
            <span class="titleL">大图：</span>
            <div class="contentI">
                <?php foreach($model->getGoodBigImages() as $bimg){ ?>
                <p><img src="<?php echo $bimg['url']; ?>"></p>
                <?php } ?>
            </div>
        </div>
    </div>  
</div>

