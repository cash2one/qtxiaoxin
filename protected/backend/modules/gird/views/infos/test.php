<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>

        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              	<tr style="background-color: #e8e8e8;">
					<th width="25%">资讯标题</th>
                    <th width="20%">所属商家</th>
					<th width="12%">属性</th>
					<th width="10%">总浏览量</th>
					<th>操作</th> 
              	</tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])): ?> 
                    <?php foreach($data['model'] as $info): ?>
                        <tr>
                            <td><?php echo $info->title;?></td>
                            <td><?php echo Business::getBusinessName($info->bid);?></td>
                            <td><?php echo $info->bid?'商业资讯':'开放资讯'; ?></td>
                            <td class="link_color"><a href="<?php echo Yii::app()->createUrl('gird/infos/browse/'.$info->iid);?>"><?php echo $info->countBrowse();?></a></td>
                            <td><a href="<?php echo Yii::app()->createUrl('gird/infos/daily/'.$info->iid);?>">每日统计</a></td>
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


  
