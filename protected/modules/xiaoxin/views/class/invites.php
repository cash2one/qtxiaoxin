<div class="header">
<!--    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/view/'.$class->cid);?>">首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/teachers/'.$class->cid);?>" class="focus">成员</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/update/'.$class->cid);?>">设置</a></li>
            </ul>
        </div>  
    </div>-->
    <div class="titleText"><em class="inIco17"></em>我的班级 > <span><?php echo $class->name; ?></span></div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
               班级学生和老师成员列表及邀请或删除本班成员操作.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box" >
            <div class="headBox ">
                <div class="headNav">
                    <ul>
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/teachers/'.$class->cid);?>" >老师</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/students/'.$class->cid);?>" >学生</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/invites/'.$class->cid);?>" class="focus">已发邀请</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/deleted/'.$class->cid);?>">已移除</a></li>
                    </ul>
                </div>  
            </div>
            <div class="classMemberBox" > 
                <table class="table"> 
                    <tbody>
                        <tr class="tableHead">
                            <th width="20%"><div class="name" style="width: 140px;" >姓名</div></th>
                            <th width="15%">身份</th> 
                            <th width="18%">联系电话</th>
                            <th width="18%">邀请时间</th>
                            <th>操作</th>
                        </tr> 
                        <?php if(count($data['datas'])): ?>
                        <?php foreach($data['datas'] as $member): ?>
                        <tr>
                            <td><div class="name"><?php echo $member['name']; ?></div></td>
                            <td><?php echo $member['type']==1?'老师':'学生';?></td>
                            <td><?php echo $member['mobilephone']; ?></td>
                            <td><?php echo date('Y年m月d日',strtotime($member['creationtime'])); ?></td>
                            <td class="operation">
                                <a href="javascript:void(0);" data-mtype="<?php echo $member['type']==1?'老师':'学生';?>" data-href="<?php echo Yii::app()->createUrl('xiaoxin/class/giveupinvite/'.$class->cid);?>?tid=<?php echo $member['id']; ?>&ty=<?php echo $member['type']==1?'teacher':'student';?>" rel="dele">放弃邀请</a>
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
            </div>
        </div>
    </div>
</div> 
<div id="remindBox" class="popupBox"> 
    <div class="remindInfo"> 
        <div id="remindInfoT" class="centent"></div>
    </div>
    <div class="popupBtn">
        <a id="deleLink" href=""  class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskWeb('#remindBox')" class="btn btn-default">取 消</a>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $("[rel=dele]").click(function(){
            var url = $(this).data('href');
            var type =$(this).data('mtype');
            $("#remindInfoT").empty();
            $("#remindInfoT").append('确定放弃邀请当前'+type+"?");
            showPromptsRemind('#remindBox'); 
            $('#deleLink').attr('href',url);
        });
    });
</script>
