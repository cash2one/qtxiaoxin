<div class="box"> 
    <div class="viweInfo" style="">
    	<p><span class="leftTitle">售出状态：</span><?php echo MallGoodsCard::getCardSoldState($model->sold);?></p>
    	<p><span class="leftTitle">使用状态：</span><?php echo MallGoodsCard::getCardStateName($model->state);?></p>
        <p><span class="leftTitle">有效期：</span><?php echo $model->starttime;?>&nbsp;至&nbsp;<?php echo $model->endtime;?></p>
        <p><span class="leftTitle" >所属商家：</span><?php echo Business::getBusinessName($model->mg->bid); ?></p>
        <p><span class="leftTitle">所属商品：</span><?php echo MallGoods::getMallGoodsName($model->mgid);?></p>
        <p><span class="leftTitle">虚拟卡号：</span><?php echo $model->number;?></p>
    </div>  
</div>

