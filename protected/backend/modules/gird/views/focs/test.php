<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">
                  <th width="25%">热点标题</th>
                  <th width="18%">所属商家</th>
                  <th width="8%">类型</th>
                  <th width="12%">属性</th>
                  <th width="10%">总浏览量</th>
                  <th width="10%">总参与量</th>
                  <th>操作</th>
              </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?>
                    <?php foreach($data['model'] as $foc){?>
                      <tr>
                          <td><?php echo $foc->title;?></td>
                          <td><?php echo Business::getBusinessName($foc->bid);?></td>
                          <td><?php echo $foc->getTypeName($foc->type);?></td>
                          <td><?php echo $foc->bid?'商业热点':'开放热点'; ?></td>
                          <td class="link_color"><a href="<?php echo Yii::app()->createUrl('gird/focs/browse/'.$foc->fid);?>"><?php echo $foc->countBrowse();?></a></td>
                          <td class="link_color"><a href="<?php echo Yii::app()->createUrl('gird/focs/join/'.$foc->fid);?>"><?php echo $foc->countJoin();?></a></td>
                          <td><a href="<?php echo Yii::app()->createUrl('gird/focs/daily/'.$foc->fid);?>">每日统计</a>&nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl('gird/focs/answer/'.$foc->fid);?>" style="<?php  if($foc->getTypeName($foc->type)=="新闻"){ echo 'display:none;';};?>">问卷结果</a></td>
                      </tr>
                     <?php } ?>
                <?php }else {?>
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
 
