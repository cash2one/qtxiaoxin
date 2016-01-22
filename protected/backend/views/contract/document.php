<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">
                  <th width="25%">合同名称</th> 
                  <th width="25%">合同编号</th>
                  <th width="15%">所属商家</th>
                  <th width="10%">状态</th>
                  <th width="15%">创建时间</th> 
                  <th>操作</th>
              </tr>  
            </thead>
            <tbody>
            <?php if(count($data['model'])){  ?>
                <?php foreach($data['model'] as $con){?>
                  <tr>
                      <td><?php echo $con->name;?></td>
                      <td><?php echo $con->contractid;?></td>
                      <td><?php echo Business::getBusinessName($con->bid);?></td>
                      <td><?php echo $con->getStateName(); ?></td>
                      <td><?php echo date('Y-m-d H:i',strtotime($con->creationtime));?></td>
                      <?php if($con->state==1){ ?>
                          <td><a href="<?php echo Yii::app()->createUrl('contract/approval/'.$con->cid);?>">审批</a></td>
                      <?php }else{ ?>
                          <td><a href="<?php echo Yii::app()->createUrl('contract/docview/'.$con->cid);?>">查看</a></td>
                      <?php } ?>
                  </tr>
                <?php }}else{ ?>
                <tr>
                    <td colspan="6" align="center" style=" font-size: 21px; padding: 100px 0;">
                        暂无数据
                    </td> 
                </tr>
              <?php } ?> 
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
</div>
 
