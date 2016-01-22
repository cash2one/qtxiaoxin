<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">  
                  <th width="15%">订单号</th>
                  <th width="20%">商品名称</th>
                  <th width="12%">所属商家</th>
                  <th width="9%">商品类型</th>
                  <th width="12%">下单时间</th>
                  <th width="11%">注册手机</th>
                  <th width="11%">状态</th> 
                  <th>操作</th> 
              </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])): ?> 
                    <?php $mgkArr = MallGoodsKind::getDataArr(); ?>
                    <?php foreach($data['model'] as $order): ?>
                        <tr>
                            <td><?php echo $order->moid;?></td>
                            <td><?php echo $order->mgname;?></td>
                            <td><?php echo $order->bname;?></td>
                            <td><?php echo $order->type?'虚拟':'实物';?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($order->creationtime));?></td>
                            <td><?php echo Member::getUserMobileByUserid($order->userid);?></td>
                            <td><?php echo $order->getState();?></td>
                            <td class="search">
                                <a rel="orderIsOK" <?php if($order->state!=3 && $order->type==0){ echo 'class="btn btn-primary"';} ?> href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('order/deal/');?>?id=<?php echo URLencode($order->moid); ?>"><?php echo $order->getOprate();?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?> 
                <?php else: ?>
                    <tr>
                        <td colspan="9" align="center" style=" font-size: 21px; padding: 100px 0;">
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
<div id="popupViwe" style="overflow: hidden;">
    <div id="popupBoxViwe" class="popupBox" style="width:780px; margin-top: 0;">
        <div class="header">订单详情 <a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#popupBoxViwe')" > </a></div>
        <div id="popupInfo"  class="infoBox"  style="padding-left:0px; height: 450px; font-size: 12px; overflow: hidden;">
            <span class="Validform_checktip Validform_loading" > 正在加载数据...</span>
        </div>
    </div>
</div>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script> 
    <script type="text/javascript">
        $( "#dateTime" ).datepicker({
            defaultDate: "+1w", 
            changeYear: true,
            numberOfMonths: 1
        });
        $("[rel=orderIsOK]").click(function(){//用户上架下架操作
            url = $(this).data("href");
            obj = $(this);
            showPromptsIfonWeb('#popupBoxViwe');
            $.ajax({  
                url:url,   
                type : 'POST',
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                    async : false,  
                success : function(mydata) {   
                        var show_data =mydata; 
                        //alert(show_data);
                        $("#popupInfo").html(show_data); 
                        //$(".deleted_"+obj.data('uid')).text(show_data);
                },  
                error : function() {  
                         $("#popupInfo").html("加载出错");  
                }  
            });
    });
    $("[rel=dealIsOk]").live('click',function(){//用户上架下架操作
            url = $(this).data("href"); 
            $.ajax({  
                url:url,   
                type : 'POST',
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {  
                    if(mydata=="success"){
                        window.location.reload();
                    }
                },  
                error : function() {  
                     alert("calc failed");  
                }  
            });
    });
    </script>
</div>


  
