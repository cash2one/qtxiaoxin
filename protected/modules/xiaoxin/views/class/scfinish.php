<div class="header"> 
    <div class="titleText"><em class="inIco17"></em>我的班级 > <?php echo $class->name; ?></div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
             <div class="box" style="padding: 15px 0;">
               批量添加学生完成操作.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box"> 
            <div class="listTopTite bBottom">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/class_step_3.png">
            </div> 
            <div class="formBox">
                <div class="classTableBox invtesBox" style="text-align: center;">
                    <h2>操作成功</h2>
                    <p>你已成功添加<?php echo $nums;?></span>位学生,成功邀请<?php echo $sendnums;?>位学生</p>
                    <div class="btnBox">
                        <a href="<?php echo Yii::app()->createUrl('xiaoxin/class/create?sid=' . $class->s->sid);?>" class="btn btn-raed" >重新创建</a>&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo Yii::app()->createUrl('xiaoxin/class/pinvite/' . $class->cid);?>" class="btn btn-default" >添加老师</a>&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo Yii::app()->createUrl('xiaoxin/class/students/'.$class->cid);?>" class="btn btn-default" >查看班级成员</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
$(function() {
    
});
</script>
