<div class="box"> 
    <div class="viweInfo" style="">
        <p><span class="leftTitle" >所属商家：</span><?php echo $model->getBusinessName(); ?></p>
        <p><span class="leftTitle">广告标题：</span><?php echo $model->title; ?></p>
        <p><span class="leftTitle">广告摘要：</span><?php echo $model->summery; ?></p>
        <?php if($model->url){ ?>
            <p><span class="leftTitle">广告链接：</span><?php echo $model->url; ?></p>
        <?php }?>
        <div class="pic">
            <span style="width: 85px; color: #999999; float: left;">广告图片：</span>
            <img width="250" height="100" src="<?php echo $model->image; ?>">
        </div>
        <div class="tableBox" style=" overflow: hidden; ">
            <span style=" color: #999999; float: left;">广告文字：</span>
            <div style="margin-left: 85px;">
                <?php echo $model->text; ?>
            </div> 
        </div>
         
    </div>  
    <?php if($model->countConAdvRelation()){ ?>
    <div class="tableBox" style="width: 90%; overflow: hidden; ">
        <span style="width: 85px; color: #999999; float: left;">配置合同：</span>
        <div style=" overflow: hidden;">
            <table  class="table table-bordered table-hover">
                <thead>
                    <tr style="background-color: #e8e8e8;">
                        <th>合同编号</th>
                        <th>投放时间</th>
                   </tr>
                </thead>
                <tbody>
                    <?php foreach($model->getConAdvRelation() as $car){ ?>
                        <tr>
                            <td><?php echo $car->c->contractid; ?></td>
                            <td><?php echo date('Y-m-d',strtotime($car->startdate));  ?>&nbsp;至&nbsp;<?php echo date('Y-m-d',strtotime($car->enddate)); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div> 
    <?php } ?>
</div>

