<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>

        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              	<tr style="background-color: #e8e8e8;">
					<th width="20%">卡号</th>
					<th width="20%">商品名称</th>
					<th width="18%">所属商家</th>
                    <th width="8%">有效期</th>
					<th width="8%">售出状态</th>
					<th width="8%">使用状态</th>
					<th width="12%">创建时间</th>
					<th>操作</th> 
              	</tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])): ?> 
                    <?php foreach($data['model'] as $card): ?>
                        <tr>
                            <td><?php echo $card->number;?></td>
                            <td><?php echo MallGoods::getMallGoodsName($card->mgid,'card');?></td>
                            <td><?php echo Business::getBusinessName($card->mg->bid);?></td>
                            <td><?php echo $card->checkCardEff()?'未过期':'已过期';?></td>
                            <td><?php echo MallGoodsCard::getCardSoldState($card->sold);?></td>
                            <td><?php echo MallGoodsCard::getCardStateName($card->state);?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($card->creationtime)); ?></td>
                            <td> 
                            	<?php if($card->sold==0): ?>
                                <a href="<?php echo Yii::app()->createUrl('gcard/update/'.$card->mgcid);?>">编辑</a>
                            	<?php else: ?>
                                <a href="<?php echo Yii::app()->createUrl('gcard/detail/'.$card->mgcid);?>">查看</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>  
                <?php else: ?>
                        <tr>
                            <td colspan="7" align="center" style=" font-size: 21px; padding: 100px 0;">
                                暂无数据
                            </td> 
                        </tr> 
                <?php endif; ?>  
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


  
