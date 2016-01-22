<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/My97DatePicker/WdatePicker.js"></script>
<div class="box">
    <div class="tableBox">
    
        <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>'',
        'method'=>'get',
        )); ?>
        <table class="tableForm searchForm" style="margin-bottom: 10px;"> 
            <tbody valign="middle">
                <tr valign="middle">
                    <td width="45px" valign="middle">日期：</td>
                    <td width="295px">
                        <input id="sTimeIput" class="Wdate" type="text" style="width:120px;" readonly="readonly" onclick="WdatePicker({maxDate:'#F{$dp.$D(\'eTimeIput\')||\'2080-10-01\'}',dateFmt:'yyyy-MM-dd'})" name="ClientLogSchoolRelation[sdate]" value="<?php if(isset($ClientLogSchoolRelation['sdate'])){echo $ClientLogSchoolRelation['sdate'];} ?>">
                        &nbsp;至&nbsp;
                        <input id="eTimeIput" class="Wdate" type="text" style="width:120px;" readonly="readonly" onclick="WdatePicker({minDate:'#F{$dp.$D(\'sTimeIput\')}',maxDate:'2080-10-01',dateFmt:'yyyy-MM-dd'})" name="ClientLogSchoolRelation[edate]" value="<?php if(isset($ClientLogSchoolRelation['edate'])){echo $ClientLogSchoolRelation['edate'];} ?>">
                    </td>
                    <td width="45px"> 城市：</td>
                    <td width="130px">
                        <?php $cid = isset($ClientLogSchoolRelation['cid'])?$ClientLogSchoolRelation['cid']:''; ?>
                        <?php echo $form->dropDownList($model,'cid',Area::getCityArr(),array('empty' => '--全部城市--','options' => array($cid=>array('selected'=>true)))); ?>
                    </td>

                    <td width="45px"> 区域：</td>
                    <td width="130px">
                        <?php $aid = isset($ClientLogSchoolRelation['aid'])?$ClientLogSchoolRelation['aid']:''; ?>
                        <?php echo $form->dropDownList($model,'aid',Area::getAreaArr(),array('empty' => '--全部区域--','options' => array($aid=>array('selected'=>true)))); ?>
                    </td>

                    <td width="45px"> 年级：</td>
                    <td width="130px">
                        <?php $gid = isset($ClientLogSchoolRelation['gid'])?$ClientLogSchoolRelation['gid']:''; ?>
                        <?php echo $form->dropDownList($model,'gid',Grade::getGradeArr(),array('empty' => '--全部年级--','options' => array($gid=>array('selected'=>true)))); ?>
                    </td>
                    <td class="search"><input type="submit" class="btn btn-primary" value=" 搜 索 "></td>
                </tr>
            </tbody>

        </table> 
        <?php $this->endWidget(); ?>

        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">  
                  <th width="15%">注册手机</th>
                  <th width="15%">城市</th>
                  <th width="10%">区域</th>
                  <th width="15%">学校</th>
                  <th width="10%">年级</th>
                  <th>浏览时间</th>
              </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])): ?> 
                    <?php foreach($data['model'] as $log): ?>
                        <tr>
                            <td><?php echo $log->getMobilephone();?></td>
                            <td><?php echo $log->cname;?></td>
                            <td><?php echo $log->aname;?></td>
                            <td><?php echo $log->sname;?></td>
                            <td><?php echo $log->gname;?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($log->creationtime));?></td>
                        </tr>
                    <?php endforeach; ?> 
                <?php else: ?>
                        <tr>
                            <td colspan="8" align="center" style=" font-size: 21px; padding: 100px 0;">
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


  
