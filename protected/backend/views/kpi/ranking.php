<style>
    #message,.message{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; right: 20px; bottom:0px; display: none; z-index: 10000; border-radius: 5px;}
    #message .messageType,.message .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message .success,.message .success{  border: 1px solid #fbeed5; background-color: #e95b5f; color: #fbe4e5; }
    #message .error,.message .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
    .table td select { width: 81px; }
    .datepicker-box {
        padding: 10px 0;
    }
</style>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/My97DatePicker/WdatePicker.js"></script>
<div class="box">
    <div class="datepicker-box">
        <form method="GET" action="">
            <label for="datepicker">月份:</label>
            <input id="datepicker" class="Wdate" readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM'})" name="month" value="<?php if(isset($param['month'])): echo $param['month'];else: echo date('Y-m');endif;?>" style="width: 180px; height:27px;color:#666;font-size:12px;"/>
            <button type="submit" id="selectButton" class="btn btn-primary btn-xs" style="padding: 3px 10px;">查询</button>
            <input name='cvs'type="hidden" id="cvsValue" />
            <button id="exportButton" type="submit" class="btn btn-primary btn-xs" style="padding: 3px 10px;">导出</button>
        </form>
        <script type="text/javascript">
            $("#exportButton").click(function(){
                $('#cvsValue').val('1');
            });
            $("#selectButton").click(function(){
                $('#cvsValue').val('0');
            });
        </script>
    </div>
    <div class="tableBox">
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
            <tr style="background-color: #e8e8e8;">
                <th width="20%">排名</th>
                <th width="15%">姓名</th>
                <th width="20%">平均分</th>
                <th width="20%">被评次数</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users['models'] as $k=>$v): ?>
                <tr>
                    <td><?php echo isset($users['pages'])&& $users['pages'] instanceof CPagination?$users['pages']->getOffset()+$k+1:$k+1;?></td>
                    <td><?php echo isset($v['user']['name'])?$v['user']['name']:'';?></td>
                    <td><?php echo isset($v['score'])?round($v['score'],2):'';?></td>
                    <td><?php echo isset($v['fromuserid'])?$v['fromuserid']:'';?></td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($users['models'])):?>
                <tr>
                    <td colspan="6" align="center" style=" font-size: 21px; padding: 100px 0;">
                        暂无数据
                    </td>
                </tr>
            <?php endif;?>
            </tbody>
        </table>

        <div id="pager" style="  margin-top: 30px;">
           <?php
           $this->widget('CLinkPager',array(
                   'header' => '',
                   'firstPageLabel' => '首页',
                   'lastPageLabel' => '末页',
                   'prevPageLabel' => '上一页',
                   'nextPageLabel' => '下一页',
                   'pages' => $users['pages'],
                   'maxButtonCount' => 9,
                   'htmlOptions'=>array(
                       'class'=>'what',   //包含分页链接的div的class
                   )
               )
           );
           ?>
        </div>
    </div>
</div>
<div id="popupBox" class="popupBox">
    <div id="popupInfo" style="padding: 30px;">
        <div class="centent">温馨提示：是否删除当前老师？</div>
    </div>
    <div style="text-align: center;">
        <a id="isOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
    </div>
</div>

<script type="text/javascript"
        src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script>



