<div id="orderBox_con_<?php echo $order; ?>" class="orderBox" style=" border-bottom: 1px solid #f1f1f1;">
    <div class="box" > 
        <table class="tableForm">
            <tr>
                <td class="td_label_ion">类 型* ：</td>
                <td>    
                    <div style="display: inline;">
                        <select name="ConType[<?php echo $order; ?>][type]" rel="con_type" order="<?php echo $order; ?>" id="con_type_<?php echo $order; ?>">
                            <option value="">--选择类型--</option>
                            <?php foreach(Contract::getTypeArr() as $tk=>$t){ ?>
                                <option value="<?php echo $tk; ?>"><?php echo $t; ?></option>
                            <?php } ?>
                        </select> 
                        &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" rel="dedelConType"  data-order="<?php echo $order; ?>" >删除合作类型</a>
                    </div>
                    <span class="Validform_checktip "></span>
                </td>
            </tr>
            <tr class="range_config_box range_config_box_<?php echo $order; ?>"  style="display:none;">
                <td></td>
                <td class="search">
                    <div style="display: inline;"> 
                        <select name="ConType[<?php echo $order; ?>][item]" data-order="<?php echo $order; ?>" rel="con_item" id="con_item_<?php echo $order; ?>">
                        </select> 
                    </div>
                    <span class="con_itemTip red" style="display: none;">请选择内容！</span>
                    <span class="Validform_checktip "></span>
                    <div id="informationBox_<?php echo $order; ?>" style=" display: inline-block;"></div>
                    <a href="javascript:void(0);" id="config_<?php echo $order; ?>" class="btn btn-primary" data-order="<?php echo $order; ?>" rel="range_config">配置范围</a> &nbsp;&nbsp; 
                    <a href="javascript:void(0);" class="btn btn-primary" data-order="<?php echo $order; ?>" data-href="<?php echo Yii::app()->createUrl('contract/contypepreview');?>" rel="viewWebStyle">预览广告</a>
                    
                </td> 
            </tr>
            <tr>
                <td></td>
                <td>
                     <!-- 结果预览 --> 
                    <div id="resultView_<?php echo $order; ?>" class="resultView" style="display: none; "> 
                    </div>
                     <p id="Tip_<?php echo $order; ?>" style="display: none;"><span style="margin-left: 0;" class="Validform_checktip Validform_wrong">请选择相应的内容，配置范围或选择时间！</span></p>
                </td>
            </tr> 
        </table> 
    </div>
    <div id="databox_<?php echo $order; ?>" class="inputDataBox" data-order="<?php echo $order; ?>"> 
    </div> 
</div>    
 
 



               