<style>
    #message,.message{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; right: 20px; bottom:0px; display: none; z-index: 10000; border-radius: 5px;}
    #message .messageType,.message .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message .success,.message .success{  border: 1px solid #fbeed5; background-color: #e95b5f; color: #fbe4e5; }
    #message .error,.message .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
    .table td select{ width: 81px; }

</style>
<script type="text/javascript" src="/js/business/My97DatePicker/WdatePicker.js"></script>
<div class="box">
    <div class="tableBox">
        <form action="">
			<table class="tableForm searchForm" style="margin-bottom: 10px;">
			    <tr>
			        <td width="45px">月份：</td>
                    <td width="180px">
                        <input id="datepicker" class="Wdate"  readonly="readonly" onclick="WdatePicker({dateFmt:'yyyy-MM',maxDate:'<?php echo date('Y-m-d');?>'})" name="yearMonth" value="<?php echo Yii::app()->request->getParam('yearMonth');?>" style="width: 140px; height:32px;"/>
                    </td>
                    <td width="45px">
                        类型:
                    </td>
                    <td width="145px">
                        <select name="type" rel="detail_location">
                            <option value="0">姓名</option>
                            <option value="1">评分人</option>
                        </select>
                    </td>
                    <td width="45px">
                        姓名:
                    </td>
			        <td width="240px">
			            <input   value="" name="search" placeholder="请输入姓名" class="searchW260" style="width:220px;"  type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')" >
			        </td>
			        <td class="search">
			            <input type="submit" class="btn btn-primary" value="搜 索">
			        </td>
			    </tr>
			</table>
			</form>
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
            <tr style="background-color: #e8e8e8;">
                <th width="20%">姓名</th>
                <th width="15%">分数</th>
                <th width="20%">评分人</th>
                <th width="20%">年月</th>
                <th width="25%">更新时间</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($users['models'] as $k=>$v): ?>
                <tr>
                    <td><?php echo isset($v['userid'])?$v->getNameByUserId($v['userid']):'';?></td>
                    <td><?php echo isset($v['score'])?round($v['score'],2):'';?></td>
                    <td><?php echo isset($v['fromuserid'])?$v->getNameByUserId($v['fromuserid']):'';?></td>
                    <td><?php echo isset($v['scoredate'])?date('Y-m',strtotime($v['scoredate'])):'';?></td>
                    <td><?php echo isset($v['updatetime'])?$v['updatetime']:'';?></td>
                </tr>
            <?php endforeach; ?>
            <?php if( false == $users['models'] ):?>
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
<script type="text/javascript">

    $(function () {

       
    });
</script>


