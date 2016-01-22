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
                            <td><?php echo $b->getDisableState(); ?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($b->creationtime));?></td> 
                            <td><a href="<?php echo Yii::app()->createUrl('business/view/'.$b->bid);?>">查看</a></td>
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
        <div id="pager" style="  margin-top: 30px;">    
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
    
</div>
