
<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">
                  <th width="30%">广告标题</th>
                  <th width="20%">所属商家</th>
                  <th width="20%">合同配置</th>
                  <th width="20%">创建时间</th>
                  <th>操作</th>
              </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?> 
                    <?php foreach($data['model'] as $adv){?>
                      <tr>
                          <td><?php echo $adv->title;?></td>
                          <td><?php echo $adv->getBusinessName();?></td>
                          <td><?php if($adv->countConAdvRelation()){echo "已配置";}else{echo "未配置";} ?></td>
                          <td><?php echo date('Y-m-d H:i',strtotime($adv->creationtime));?></td>
                          <td><a href="<?php echo Yii::app()->createUrl('adv/view/'.$adv->aid);?>">查看</a></td>
                      </tr>
                     <?php } ?>
                <?php }else {?>
                    <tr>
                        <td colspan="5" align="center" style=" font-size: 21px; padding: 100px 0;">
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
 
