<div class="header">
<!--    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/index');?>">班级列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/apply');?>" class="focus">入班邀请</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/create');?>">创建班级</a></li>
            </ul>
        </div>  
    </div>-->
    <div class="titleText"><em class="inIco17"></em>我的班级</div>  
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
                显示并操作其他老师发送加入其班级或兴趣班的邀请信息.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box"> 
            <div class="classMemberBox" style="padding: 0;" >
                <div class="listTopTite">入班邀请</div> 
                <table class="table"> 
                    <tbody>
                        <tr class="tableHead">
                            <th width="20%"><div class="inilebox">班级名称</div></th>
                            <th width="15%">班主任</th> 
                            <th width="20%"><div class="inilebox">所在学校</div></th>
                            <th width="22%">邀请时间</th>
                            <th>操作</th>
                        </tr>
                        <?php if(count($data['datas'])): ?>
                        <?php foreach($data['datas'] as $teacher):?>
                        <tr>
                            <td><div class="inilebox"><?php echo $teacher['classname']; ?> </div></td>
                            <td><?php $master=UCQuery::loadTableRecord('tb_user',$teacher['master']); echo $master->name; ?></td>
                            <td><div class="inilebox"><?php $school = UCQuery::getSchoolByClassPk($teacher['cid']); echo $school->name; ?> </div> </td>
                            <td><?php echo date('Y年m月d日',strtotime($teacher['creationtime'])); ?></td>
                            <td class="operation">
                                <a href="<?php echo Yii::app()->createUrl('xiaoxin/class/accept/'.$teacher['id']);?>" data-bind="1">同意</a>
                                &nbsp;
                                <a href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('xiaoxin/class/refuse/'.$teacher['id']);?>" data-bind="0" rel="dele">拒绝</a>
                            </td> 
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="remindBox">
                                <td colspan="5" style=" padding: 0;">
                                    <div class="noContent" style="background: #FFF; padding-bottom: 20px;"> 
                                        <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                        <p>空空如也，没有任何数据</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table> 
            </div> 
        </div> 
    </div>
</div>
<div id="pager">    
    <?php    
        $this->widget('CLinkPager',array(    
            'header'=>'',    
            'firstPageLabel' => '首页',    
            'lastPageLabel' => '末页',    
            'prevPageLabel' => '上一页',    
            'nextPageLabel' => '下一页',    
            'pages' => $data['pager'],    
            'maxButtonCount'=>9    
            )    
        );    
    ?>    
</div>  
<div id="remindBox" class="popupBox"> 
    <div class="remindInfo"> 
        <div id="remindText" class="centent"> </div>
    </div>
    <div class="popupBtn">
        <a id="deleLink" href=""  class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskWeb('#remindBox')" class="btn btn-default">取 消</a>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $("[rel=dele]").click(function(){
            var remindText ="";
            var url = $(this).data('href');
            var bind = $(this).data('bind');
            if(parseInt(bind)==0){
                remindText ="是否拒绝该邀请";
            }else{
                remindText ="是否同意绝该邀请"
            }
            $('#remindText').empty();
            $('#remindText').append(remindText);
            $('#deleLink').attr('href',url);
            showPromptsRemind('#remindBox');
            
        });
    });
</script>
