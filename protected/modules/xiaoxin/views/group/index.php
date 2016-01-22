<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/group/index');?>" class="focus">分组列表</a></li> 
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/group/create');?>">创建分组</a></li>
            </ul>
        </div>  
    </div>
    <div class="titleText"><em class="inIco18"></em>自定义分组</div>  
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 20px 0;">
                提供以分组的方式区分联系人，方便您便捷的发布消息。
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox"> 
        <div class="box"> 
            <div class="listTopTite bBottom">学生分组</div>
            <div class="classList">
                <ul>
                <?php if(count($students)): ?> 
                <?php foreach ($students as $student): ?>   
                    <li>
                        <a title="<?php echo $student['name'].'&nbsp;'.
                            (isset($student['shares'])?('('.$student['createname'].'&nbsp;共享给我的分组)'):'');?>"
                           <?php if(isset($student['shares'])):?> href="javascript:void(0);" style="cursor: default;">
                                <div class="classItme " >
                                    <em class="groupPs"></em>
                                    <div class="classItmeInfo"> 
                                        <p class="cName"><?php echo $student['name']; ?></p>
                                        <p>学校：<?php echo $student['schoolname'];?></p>
                                        <p>成员：<?php echo $student['member']; ?>人</p> 
                                    </div>
                                    <em class="groupMaster"></em> 
                                </div> 
                            </a>
                           <?php else:?>
                                href="<?php echo Yii::app()->createUrl('xiaoxin/group/update/'.$student['gid']);?>">
                                 <div class="classItme " >
                                <em class="groupPs"></em>
                                <div class="classItmeInfo"> 
                                    <p class="cName"><?php echo $student['name']; ?></p>
                                    <p>学校：<?php echo $student['schoolname'];?></p>
                                    <p>成员：<?php echo $student['member']; ?>人</p> 
                                </div> 
                            </div> 
                        </a>
                        <?php endif;?>  
                    </li> 
                <?php endforeach;?>
                <?php else: ?>
                    <li style="float: none; width: auto; height: auto;">
                        <div class="noContent" style="background: #FFF; padding-bottom: 20px;"> 
                            <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                            <p>空空如也，没有任何数据</p>
                        </div>
                    </li>
                <?php endif; ?>
                </ul>
            </div>
            <div class="listTopTite bBottom">老师分组</div> 
            <div class="classList">
                <ul> 
                    <?php if(count($teachers)): ?> 
                    <?php foreach ($teachers as $teacher): ?>   
                        <li>
                            <a title="<?php echo $teacher['name'].'&nbsp;'.(isset($teacher['shares'])?('('.$teacher['createname'].'&nbsp;共享给我的分组)'):''); ?>"
                            <?php if(isset($teacher['shares'])):?>
                                href="javascript:void(0);"
                                style="cursor: default;">
                                <div class="classItme " >
                                    <em class="groupPs"></em>
                                    <div class="classItmeInfo"> 
                                        <p class="cName"><?php echo $teacher['name']; ?></p>
                                        <p>学校：<?php echo $teacher['schoolname'];?></p>
                                        <p>成员：<?php echo $teacher['member']; ?>人</p> 
                                    </div>
                                    <em class="groupMaster"></em>
                                </div> 
                            </a>
                            <?php else:?>
                               href="<?php echo Yii::app()->createUrl('xiaoxin/group/update/'.$teacher['gid']);?>">
                               <div class="classItme " >
                                    <em class="groupPs"></em>
                                    <div class="classItmeInfo"> 
                                        <p class="cName"><?php echo $teacher['name']; ?></p>
                                        <p>学校：<?php echo $teacher['schoolname'];?></p>
                                        <p>成员：<?php echo $teacher['member']; ?>人</p> 
                                    </div> 
                                </div> 
                            </a>
                            <?php endif;?>
                                
                        </li> 
                    <?php endforeach;?>
                    <?php else: ?>
                        <li style="float: none; width: auto; height: auto;">
                            <div class="noContent" style="background: #FFF; padding-bottom: 20px;"> 
                                <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                <p>空空如也，没有任何数据</p>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div> 
    </div>
</div>