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
        <div class="box">
            <div class="headBox ">
                <div class="headNav">
                    <ul>
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/teachers/'.$class->cid);?>" >老师</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/students/'.$class->cid);?>" >学生</a></li>
                      <!--   <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/invites/'.$class->cid);?>">已发邀请</a></li> -->
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/deleted/'.$class->cid);?>" class="focus">已移除</a></li>
                    </ul>
                </div>  
            </div>
            <div class="classMemberBox" >
                <table class="table"> 
                    <tbody>
                        <tr class="tableHead">
                            <th width="20%"><div class="name" style="width: 140px;">姓名</div></th>
                            <th width="15%">身份</th> 
                            <th width="20%">手机号码</th>
                            <th width="20%">移除时间</th> 
                        </tr>
                        <?php if(count($data['datas'])): ?>
                        <?php foreach($data['datas'] as $member): ?>
                        <tr>
                            <td><div class="name"><?php echo $member['name']; ?></div></td>
                            <td><?php echo $member['type']==1?'老师':'学生';?></td>
                            <td><?php echo $member['type']==1?$member['mobilephone']:UCQuery::getStudentGuradianMobile($member['userid']); ?></td>
                            <td><?php echo date('Y年m月d日',strtotime($member['updatetime'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="remindBox">
                                <td colspan="4" style=" padding: 0;">
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
