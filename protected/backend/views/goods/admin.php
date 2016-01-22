<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>

        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr style="background-color: #e8e8e8;">  
                    <th width="5%">序号</th>
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
                            <td rel="state_<?php echo $good->mgid; ?>"><?php echo $good->getDisableState();?></td>
                            <td>
                                <?php echo $good->number;?>
                                <?php if($good->type==1){echo '('.$good->countGoodsCards(true).')';} ?>
                                <?php if($good->showStockWarring()):?><span title="有效库存不足" class="markR"></span><?php endif; ?>
                            </td>
                            <td><?php echo date('Y-m-d H:i',strtotime($good->creationtime)); ?></td>
                            <td>
                            <?php if($good->b->state==1): ?> 
                                <a href="javascript:void(0);" rel="set_state" data-mgid="<?php echo $good->mgid; ?>" data-href="<?php echo Yii::app()->createUrl('goods/setdisable/'.$good->mgid);?>"><?php echo $good->getDisableState(true);?></a>
                                 &nbsp;&nbsp;
                            <?php endif; ?> 
                                <span style="display: inline-block;">
                                    <a <?php if($good->state==1): echo 'style="display:none"'; endif ?> rel="editBnt"  href="<?php echo Yii::app()->createUrl('goods/update/'.$good->mgid);?>">编辑</a>
                                </span> 
                               <a href="<?php echo Yii::app()->createUrl('goods/detail/'.$good->mgid);?>" <?php if($good->state==0): echo 'style="display:none"'; endif ?> class="set_state_<?php echo $good->mgid; ?>">查看</a>
                            </td>
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
        //日期控件
        $( "#dateTime" ).datepicker({
            defaultDate: "+1w", 
            changeYear: true,
            numberOfMonths: 1
        });
        //商品下架使用操作
        $("[rel=set_state]").click(function(){
            url = $(this).data("href");
            aid = $(this).data("mgid");
            obj = $(this);
            $.ajax({  
                url:url,   
                type : 'POST',
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {   
                    var show_data =mydata;  
                    obj.text(show_data); 
                    if(show_data == '下架'){
                        state = '上架';
                         obj.parent('td').find('[rel=editBnt]').hide();
                         $(".set_state_"+ aid).show();
                    }else{
                        state = '下架';
                        obj.parent('td').find('[rel=editBnt]').show();
                        $(".set_state_"+ aid).hide();
                    }
                    $("[rel=state_"+ aid + "]").text(state); 
                },  
                error : function() {  
                        // alert("calc failed");  
                }  
            });
        })
    </script>
</div>


  
