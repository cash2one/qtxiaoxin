<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/businessList.css">
<div class="box">
    <div class="busBox">
        <?php include('_search.php'); ?>
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">  
                  <th width="30%">商家名称</th>
                  <th width="10%">类型</th>
                  <th width="12%">负责人</th>
                  <th width="12%">联系电话</th>
                  <th width="10%">状态</th>
                  <th width="15%">创建时间</th>
                  <th>操作</th> 
              </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?> 
                    <?php foreach($data['model'] as $b){?>
                        <tr>
                            <td><?php echo $b->name;?></td>
                            <td><?php echo $b->mall?'商城商家':'普通商家'; ?></td>
                            <td><?php echo $b->contacter;?></td>
                            <td><?php echo $b->phone;?></td>
                            <td class="typeOption"><?php echo $b->getDisableState(); ?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($b->creationtime));?></td> 
                            <td>
                                <a class="viewLink" <?php if($b->state==0): ?>style="display: none;"<?php endif; ?> href="<?php echo Yii::app()->createUrl('business/view/'.$b->bid);?>">查看</a>
                                <a class="updateLink" <?php if($b->state==1): ?>style="display: none;"<?php endif; ?> href="<?php echo Yii::app()->createUrl('business/update/'.$b->bid);?>">编辑</a>
                                &nbsp;&nbsp;
                                <?php if($b->mall): ?>
                                    <a rel="DisableState" href="javascript:;" data-uid="<?php echo $b->uid; ?>" data-href="<?php echo Yii::app()->createUrl('business/setdisable/'.$b->bid);?>"><?php echo $b->getDisableState(true);?></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?> 
                <?php }else {?>
                        <tr>
                            <td colspan="7" align="center" style=" font-size: 21px; padding: 100px 0;">
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
    </div>
    <div class="popupBox" style="width: 450px; height: 250px">
        <div class="header">温馨提示 <a href="javascript:void(0);" class="close" onclick="hidePormptMask('popupBox')" > </a></div>
        <div id="popupInfo" style=" font-size: 14px; padding:40px 10px 30px 10px;"> 
            <span style="width: 30px; display: inline-block;"></span>温馨提示，该商家有商品正在售卖，不能进行下架操作，请先确认该商家所属商品已全部下架或删除！
        </div>
        <div style="text-align: center; padding:20px 0;" >
            <a href="javascript:void(0);" class="btn btn-primary" onclick="hidePormptMask('popupBox')">取 消</a>
        </div>
    </div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script>
    <div id="pager" style=" margin-top: 30px;">    
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
<script type="text/javascript">
    $("[rel=DisableState]").click(function(){//用户上架下架操作
        url = $(this).data("href");
        obj = $(this);
        $.ajax({  
            url:url,   
            type : 'POST',
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {   
                    var show_data =mydata;
                    if(show_data=='warning'){
                        showPromptsIfon('popupBox')
                       // alert('该商家有商品正在售卖，不能进行下架操作！');
                    }else if(show_data=="下架"){
                         obj.text("下架");
                         obj.siblings('.viewLink').show();
                         obj.siblings('.updateLink').hide();
                         obj.parent('td').parent('tr').find('.typeOption').text("上架");
                    }else{
                        obj.parent().parent().find().text("下架");
                        obj.text("上架");
                        obj.siblings('.updateLink').show();
                        obj.siblings('.viewLink').hide();
                        obj.parent('td').parent('tr').find('.typeOption').text("下架");
                    } 
                    //$(".deleted_"+obj.data('uid')).text(show_data);
            },  
            error : function() {  
                    // alert("calc failed");  
            }  
        });
    })
</script>
</div>
