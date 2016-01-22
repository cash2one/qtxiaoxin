<div class="box">
    <div class="tableBox">
    <?php include('bus_search.php'); ?> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              	<tr style="background-color: #e8e8e8;">
					<th width="20%">卡号</th>
					<th width="20%">商品名称</th>
					<th width="15%">所属商家</th>
					<th width="10%">售出状态</th>
					<th width="10%">使用状态</th>
					<th width="">操作</th> 
              	</tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])): ?> 
                    <?php foreach($data['model'] as $card): ?>
                        <tr>
                            <td><?php echo $card->number;?></td>
                            <td><?php echo MallGoods::getMallGoodsName($card->mgid);?></td>
                            <td><?php echo Business::getBusinessName($card->mg->bid);?></td>
                            <td><?php echo MallGoodsCard::getCardSoldState($card->sold);?></td>
                            <td class="state_<?php echo $card->mgcid; ?>"><?php echo MallGoodsCard::getCardStateName($card->state);?></td>
                            <td>
                            	<a href="<?php echo Yii::app()->createUrl('gcard/busdetail/'.$card->mgcid);?>">查看</a>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <a rel="setstate" style=" <?php if($card->sold==0){ echo 'display:none;'; }?>" href="javascript:void(0);" data-idi="<?php echo $card->mgcid; ?>" data-href="<?php echo Yii::app()->createUrl('gcard/setstate/'.$card->mgcid);?>"><?php if($card->state==0): ?>设为已使用<?php else: ?>设为未使用<?php endif; ?></a>
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
        //日期控件
        $( "#dateTime" ).datepicker({
            defaultDate: "+1w", 
            changeYear: true,
            numberOfMonths: 1
        });
        //设置使用状态
        $('[rel=setstate]').click(function(){ 
            var obj =$(this);
            var urls = obj.data('href');
            var idi = obj.data('idi'); 
            $.ajax({  
                url: urls,   
                type : 'POST',  
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {
                    if(mydata=="设为已使用"){
                       obj.text(mydata);
                       $('.state_'+idi).text('未使用');
                    }else{
                       obj.text(mydata);
                       $('.state_'+idi).text('已使用');
                    } 
                    
                },  
                error : function() {  
                }  
            });   
        });
        
    </script>
</div>


  
