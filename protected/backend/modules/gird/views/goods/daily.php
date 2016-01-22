<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/My97DatePicker/WdatePicker.js"></script>
<div class="box"> 
    <div class="viweInfo" style="">
        <p><span class="leftTitle" >所属商家：</span><?php echo Business::getBusinessName($model->bid); ?></p>
        <p><span class="leftTitle">物品类型：</span><?php echo MallGoods::getGoodTypeName($model->type);?></p>
        <p><span class="leftTitle">商品名称：</span><?php echo $model->name; ?></p>
        <p><span class="leftTitle">总浏览量：</span><?php echo $model->countBrowse();?></p>
        <p><span class="leftTitle">总兑换量：</span><?php echo $model->countBuy();?></p>
        <p><span class="leftTitle">总评论数：</span><?php echo $model->countComment();?></p>
    </div>  

    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>'',
        'method'=>'get',
        )); ?>
        <div class="picBox">
            <span class="titleL">每日统计：</span>
            <div class="contentS">
                 <input id="sTimeIput" class="Wdate" type="text" readonly="readonly" onclick="WdatePicker({maxDate:'#F{$dp.$D(\'eTimeIput\')||\'2080-10-01\'}',dateFmt:'yyyy-MM-dd'})" style="width:120px;" name="ClientLogSchoolRelation[sdate]"  value="<?php if(isset($ClientLogSchoolRelation['sdate'])){echo $ClientLogSchoolRelation['sdate'];} ?>">
                &nbsp;至&nbsp;
                <input id="eTimeIput" class="Wdate" type="text" readonly="readonly" onclick="WdatePicker({minDate:'#F{$dp.$D(\'sTimeIput\')}',maxDate:'2080-10-01',dateFmt:'yyyy-MM-dd'})" style="width:120px;" name="ClientLogSchoolRelation[edate]"  value="<?php if(isset($ClientLogSchoolRelation['edate'])){echo $ClientLogSchoolRelation['edate'];} ?>">
                &nbsp;&nbsp;&nbsp;<input type="submit" style="padding: 5px 15px;" class="btn btn-primary" value=" 搜 索 ">
            </div>
        </div> 
    <?php $this->endWidget(); ?>
 
    <div class="picBox" style="margin-top: 20px;">
            <span class="titleL"> </span>
            <div class="contentS">
                <div class="tableBox" style="width: 90%; overflow: hidden; "> 
                    <table  class="table table-bordered table-hover">
                        <thead >
                            <tr style="background-color: #e8e8e8;">
                                <th width="12%">日期</th>
                                <th width="12%">浏览量</th>
                                <th width="12%">兑换量</th>
                                <th>评论数</th>
                           </tr>
                        </thead>
                        <tbody>
                            <?php if(count($logs)){ ?>
                                <?php foreach($logs as $log){ ?>
                                    <tr>
                                        <td><?php echo $log->date; ?></td>
                                        <td><?php echo $log->browse; ?></td>
                                        <td><?php echo $log->buy; ?></td>
                                        <td><?php echo $log->commemt; ?></td>
                                    </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                    <tr>
                                        <td colspan="5" align="center" style=" font-size: 21px; padding: 100px 0;">
                                            暂无数据
                                        </td> 
                                    </tr> 
                            <?php } ?>
                        </tbody>
                    </table>
                </div> 
            </div>
    </div> 
</div>

