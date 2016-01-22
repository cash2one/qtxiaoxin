<?php $order=0; ?>
<?php foreach($advs as $adv){$order++; ?>
<div id="orderBox_con_<?php echo $order;  ?>" class="orderBox orderBoxCon" style="border-bottom: 1px solid #f1f1f1;" rel="conrelation" ty="adv" rid="<?php echo $adv->carid; ?>">
    <div class="box" > 
        <table class="tableForm">
            <tr>
                <td class="td_label_ion">类 型* ：</td>
                <td>    
                    <div style="display: inline;">
                        <span>广告</span> 
                        &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" rel="dedelConType"  data-order="<?php echo $order; ?>" >删除合作类型</a>
                    </div>
                    <span class="Validform_checktip "></span>
                </td>
            </tr>
            <tr class="range_config_box_<?php echo $order; ?>">
                <td></td>
                <td class="search">
                    <div style="display: inline;"> 
                        <span><?php echo Advertisement::getAdvTitleById($adv->aid); ?></span>
                        <!--<option value="<?php echo $adv->aid; ?>"><?php echo Advertisement::getAdvTitleById($adv->aid); ?></option>-->
                         
                    </div>
                    <span class="Validform_checktip "></span>
                    <!--<a href="javascript:void(0);" class="btn btn-primary" data-order="<?php echo $order; ?>" rel="range_config">配置范围</a>--> 
                    &nbsp;&nbsp;  
                    <a href="javascript:void(0);"  class="btn btn-primary" data-href="<?php echo Yii::app()->createUrl('contract/contypepreview');?>"  data-order="<?php echo $order; ?>" ty="adv" tid="<?php echo $adv->aid; ?>"  rel="viewWebInfo">预览广告</a>
                    
                </td> 
            </tr>
            <tr>
                <td></td>
                <td>
                    <div id="resultView_<?php echo $order; ?>" class="resultView">
                        <!-- 结果预览 -->
                        <p><span>投放时间：<?php echo date('Y-m-d',strtotime($adv->startdate)); ?></span>&nbsp;至&nbsp;<?php echo date('Y-m-d',strtotime($adv->enddate)); ?></p>
                        <p><span>位置：</span><?php echo AdvertisementLocation::getLoactionNameById($adv->alid); ?></p>
                        <p>
                            <span>推广范围：</span>已选择共<?php echo $adv->school; ?>所学校 约<?php echo $adv->person; ?>位用户 
                            &nbsp;&nbsp; &nbsp;&nbsp; 
                            <a href="javascript:void(0);" rel="updateView" data-href="<?php echo Yii::app()->createUrl('contract/rangedetail');?>" ty="adv" rid="<?php echo $adv->carid; ?>" >查看范围</a>
 
                        </p>
                    </div>
                </td>
            </tr> 
        </table> 
    </div>
   <!--  <div id="databox_<?php echo $order; ?>">
        
    </div> -->
</div>    
<?php } ?>


<?php foreach($focs as $foc){$order++; ?>
    <div id="orderBox_con_<?php echo $order;  ?>" class="orderBox orderBoxCon" style=" border-bottom: 1px solid #f1f1f1;" rel="conrelation" ty="foc" rid="<?php echo $foc->cfrid; ?>">
    <div class="box" > 
        <table class="tableForm">
            <tr>
                <td class="td_label_ion">类 型* ：</td>
                <td>    
                    <div style="display: inline;"> 
                        <span>热点</span> 
                        &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" rel="dedelConType"  data-order="<?php echo $order; ?>" >删除合作类型</a>
                    </div>
                    <span class="Validform_checktip "></span>
                </td>
            </tr>
            <tr class="range_config_box_<?php echo $order; ?>">
                <td></td>
                <td class="search">
                    <div style="display: inline;"> 
                        <span><?php echo Focus::getFocTitle($foc->fid); ?></span>
                    </div>
                    <span class="Validform_checktip "></span>
                    <!--<a href="javascript:void(0);" class="btn btn-primary" data-order="<?php echo $order; ?>" rel="range_config">配置范围</a>-->
                    &nbsp;&nbsp;
                    <a href="javascript:void(0);"  class="btn btn-primary" data-href="<?php echo Yii::app()->createUrl('contract/contypepreview');?>"  data-order="<?php echo $order; ?>" ty="foc" tid="<?php echo $foc->fid; ?>"  rel="viewWebInfo">预览热点</a>
                    
                </td> 
            </tr>
            <tr>
                <td></td>
                <td>
                    <div id="resultView_<?php echo $order; ?>" class="resultView">
                        <!-- 结果预览 -->
                        <p><span>投放时间：<?php echo date('Y-m-d',strtotime($foc->startdate));  ?></span>&nbsp;至&nbsp;<?php echo date('Y-m-d',strtotime($foc->enddate)); ?></p>
                        <p><span>推广范围：</span>已选择共<?php echo $foc->school; ?>所学校 约<?php echo $foc->person; ?>位用户  
                            &nbsp;&nbsp; &nbsp;&nbsp;  
                            <a href="javascript:void(0);" rel="updateView" data-href="<?php echo Yii::app()->createUrl('contract/rangedetail');?>" ty="foc" rid="<?php echo $foc->cfrid; ?>" >查看范围</a> 
                        </p> 
                    </div>
                </td>
            </tr> 
        </table> 
    </div>
   <!--  <div id="databox_<?php echo $order; ?>"> 
    </div> -->
</div>    
<?php } ?>

<?php foreach($infos as $info){$order++; ?>
    <div id="orderBox_con_<?php echo $order;  ?>" class="orderBox orderBoxCon" style=" border-bottom: 1px solid #f1f1f1;" rel="conrelation" ty="info" rid="<?php echo $info->cirid; ?>">
    <div class="box" > 
        <table class="tableForm">
            <tr>
                <td class="td_label_ion">类 型* ：</td>
                <td>    
                    <div style="display: inline;"> 
                        <span>资讯</span> 
                        &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" rel="dedelConType"  data-order="<?php echo $order; ?>" >删除合作类型</a>
                    </div>
                    <span class="Validform_checktip "></span>
                </td>
            </tr>
            <tr class="range_config_box_<?php echo $order; ?>">
                <td></td>
                <td class="search">
                    <div style="display: inline;"> 
                        <span><?php echo Information::getInfoTitle($info->iid); ?></span>
                    </div>
                    <span class="Validform_checktip "></span>
                    &nbsp;&nbsp;
                    <a href="javascript:void(0);"  class="btn btn-primary" data-href="<?php echo Yii::app()->createUrl('contract/contypepreview');?>"  data-order="<?php echo $order; ?>" ty="info" tid="<?php echo $info->iid; ?>"  rel="viewWebInfo">预览资讯</a>
                    
                </td> 
            </tr>
            <tr>
                <td></td>
                <td>
                    <div id="resultView_<?php echo $order; ?>" class="resultView">
                        <!-- 结果预览 -->
                        <p><span>起始时间：<?php echo date('Y-m-d',strtotime($info->startdate));  ?></span></p>
                    </div>
                </td>
            </tr> 
        </table> 
    </div>
</div>    
<?php } ?>
