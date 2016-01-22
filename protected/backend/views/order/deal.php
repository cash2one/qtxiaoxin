<div class="box">
    <div class="viweInfo" style=" width: 100%; height: 330px;">
        <p><span class="TitleTextR">订单号：</span><?php echo $order->moid; ?></p>
        <p><span class="TitleTextR">下单时间：</span><?php echo date('Y-m-d H:i',strtotime($order->creationtime)); ?></p>
        <p><span class="TitleTextR">注册手机：</span><?php echo Member::getUserMobileByUserid($model->userid); ?></p>
        <?php if($model->type==0){?>
            <p><span class="TitleTextR">收货人：</span><?php echo (!isset($contacter ) && empty($contacter))?:$contacter; ?></p>
            <p><span class="TitleTextR">联系电话：</span><?php echo isset($order->mca)?$order->mca->phone:''; ?></p>
            <p><span class="TitleTextR">收货地址：</span><?php echo isset($order->mca)?$order->mca->address:''; ?></p>
            <p><span class="TitleTextR">状态：</span><?php echo $model->getState();?></p>
        <?php }?>
        <div>
            <span style="width: 70px; color: #999999; float: left;">商品信息：</span>
            <div class="issueListBox" style=" margin-left: 0px; padding-left: 70px;">
                <table class="table table-bordered">
                    <tr style="background-color: #e8e8e8;">
                        <th<?php if($model->type): ?> width="30%" <?php else: ?> width="50%"<?php endif; ?>>商品名称</th>
                        <th width="15%">商品类型</th>
                        <?php if($model->type): ?> <th width="20%">虚拟卡号</th><?php endif; ?>
                        <th width="20%">所属商家</th>
                    </tr>
                    <tr>
                        <td><?php echo $model->mgname; ?></td>
                        <td><?php echo $model->type?'虚拟':'实物';?></td>
                        <?php if($model->type): ?> <td><?php echo MallGoodsCard::getCardNumberByPk($model->mgcid); ?></td><?php endif; ?>
                        <td><?php echo $model->bname; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div style="text-align: center; margin-top: 30px;" >
        <?php if(!$model->type): ?>
            <a  class="btn btn-primary" <?php if($order->state==3){echo 'style="display: none;"'; }?> rel="dealIsOk" data-href="<?php echo Yii::app()->createUrl('order/deal/');?>?id=<?php echo URLencode($order->moid); ?>&st=<?php echo $order->state; ?>">
                <?php 
                    if($order->state==0){echo '确认资料';}
                    if($order->state==1){echo '确认发货';} 
                    if($order->state==2){echo '确认收货';}
                ?>
            </a>
        &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBoxViwe')" class="btn btn-primary"><?php echo $order->state==3?'取消':'取消'?></a>
    <?php else: ?>
        <a href="javascript:;" href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBoxViwe')" class="btn btn-primary">取消</a>
    <?php endif; ?>
    </div>

</div>

  
