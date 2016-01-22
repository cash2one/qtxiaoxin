<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>

        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">  
                  <th width="16%">账号名</th>
                  <th width="15%">真实姓名</th>
                  <th width="15%">联系电话</th>
                  <th width="20%">公司邮箱</th>
                  <th width="18%">创建时间</th>
                  <th width="8%">状态</th>
                  <th width="8%">操作</th> 
              </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?> 
                    <?php foreach($data['model'] as $user){?>
                        <tr>
                            <td><?php echo $user->username;?></td>
                            <td><?php echo $user->name;?></td>
                            <td><?php echo $user->mobile;?></td>
                            <td><?php echo $user->mail;?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($user->creationtime));?></td>
                            <td><?php echo $user->getDisableState(); ?></td>
                            <td><a href="<?php echo Yii::app()->createUrl('user/view/'.$user->uid);?>">查看</a></td>
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
        $( "#dateTime" ).datepicker({//日期控件
            defaultDate: "+1w", 
            changeYear: true,
            numberOfMonths: 1
        });
    </script>
</div>


  
