<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr style="background-color: #e8e8e8;">  
                    <th width="6%">序号</th>
                    <th width="25%">商品名称</th>
                    <th width="8%">类型</th>
                    <th width="12%">所属分类</th>
                    <th width="15%">所属商家</th>
                    <th width="6%">状态</th>
                    <th width="8%">库存</th>
                    <th width="12%">创建时间</th>
                    <th>操作</th> 
                </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?> 
                    <?php foreach($data['model'] as $good){?>
                        <tr>
                            <td><?php echo $good->sort==0?'':$good->sort;?></td>
                            <td><?php echo $good->name;?></td>
                            <td><?php echo MallGoods::getGoodTypeName($good->type);?></td>
                            <td><?php echo MallGoodsKind::getMallGoodsKindName($good->mgkid);?></td>
                            <td><?php echo Business::getBusinessName($good->bid);?></td>
                            <td><?php echo $good->getDisableState();?></td>
                            <td>
                                <?php echo $good->number;?>
                                <?php if($good->type==1){echo '('.$good->countGoodsCards(true).')';} ?>
                                <?php if($good->showStockWarring()):?><span  title="有效库存不足"  class="markR"></span><?php endif; ?> 
                            </td>
                            <td><?php echo date('Y-m-d H:i',strtotime($good->creationtime)); ?></td>
                            <td><a href="<?php echo Yii::app()->createUrl('goods/view/'.$good->mgid);?>">查看</a></td>
                        </tr>
                    <?php } ?> 
                <?php }else {?>
                        <tr>
                            <td colspan="8" align="center" style=" font-size: 21px; padding: 100px 0;">
                                暂无数据
                            </td> 
                        </tr> 
                <?php } ?> 
            </tbody>
        <!--    <tfoot>
                <tr>
                    <td colspan="7">

                    </td>
                </tr>  
            </tfoot>-->
        </table>
        <div id="pager">    
            <?php    
                $this->widget('CLinkPager',array(    
                    'header'=>'',    
                    'firstPageLabel' => '首页',    
                    'lastPageLabel' => '末页',    
                    'prevPageLabel' => '上一页',    
                    'nextPageLabel' => '下一页',    
                    'pages' => $data['pages'],    
                    'maxButtonCount'=>9    
                    )    
                );    
            ?>    
        </div>  
    </div>
    <script type="text/javascript">
        $( "#dateTime" ).datepicker({
            defaultDate: "+1w", 
            changeYear: true,
            numberOfMonths: 1
        });
    </script>
</div>


  
