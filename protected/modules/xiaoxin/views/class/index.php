<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <!--<li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/index');?>" class="focus">班级列表</a></li>-->
                <!--<li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/apply');?>" >入班邀请</a></li>-->
                <!--<li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/create');?>">创建班级</a></li>-->
            </ul>
        </div>  
    </div>
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
                一览您任课的班级，加有班主任图戳的班级可点击进入管理界面。
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox"> 
        <div class="box" >
            <?php if(count($schools)):?>
            <?php foreach($schools as $school):?>
            <div class="listTopTite bBottom"><?php echo isset($school['name'])?$school['name']:'';?></div>
            <div class="classList">
                <ul>
                    <?php if(is_array($school['sys'])): ?>
                        <?php foreach($school['sys'] as $std): ?>
                            <li>
                                <?php  if($std['master']==$teacher->userid):?>
                                <a title="<?php echo $std['name']; ?>" href="<?php echo $std['master']==$teacher->userid ? Yii::app()->createUrl('xiaoxin/class/update/'.$std['cid']) : "javascript:;"; ?>">
                                    <div class="classItme " >
                                        <em class="<?php echo $std['type']==0?'classStd':'classIntr';?>"></em>
                                        <div class="classItmeInfo"> 
                                            <p class="cName"><?php echo $std['name']; ?></p>
                                            <p>类型：<?php echo $std['type']==0?'标准班':'兴趣班'; ?></p>
                                            <p>老师：<?php echo isset($teacherNumArr[$std['cid']])?$teacherNumArr[$std['cid']]:0;?></p>
                                            <p>学生：<?php echo $std['total']; ?></p>
                                        </div> 
                                        <em class="classMaster"></em> 
                                    </div> 
                                </a>
                                <?php else: ?>
                                    <a title="<?php echo $std['name']; ?>" style="cursor: default;">
                                        <div class="classItme " >
                                            <em class="<?php echo $std['type']==0?'classStd':'classIntr';?>"></em>
                                            <div class="classItmeInfo"> 
                                                <p class="cName"><?php echo $std['name']; ?></p>
                                                <p>类型：<?php echo $std['type']==0?'标准班':'兴趣班'; ?></p>
                                                <p>老师：<?php echo isset($teacherNumArr[$std['cid']])?$teacherNumArr[$std['cid']]:0;?></p>
                                                <p>学生：<?php echo $std['total']; ?></p>
                                            </div> 
                                        </div> 
                                    </a>
                                <?php endif; ?>                                
                            </li> 
                        <?php endforeach; ?>
                        <?php if($school['createtype'] == 1): ?>
                           <!-- <li>
                                <a class="addClass" title="创建班级" href="<?php echo Yii::app()->createUrl('xiaoxin/class/create',array('sid'=>$school['sid']));?>">
                                </a>
                            </li>-->
                        <?php endif;?>
                    <?php else: ?>
                        <?php if($school['createtype'] == 1): ?>
                          <!--    <li><a class="addClass" title="创建班级" href="<?php echo Yii::app()->createUrl('xiaoxin/class/create',array('sid'=>$school['sid']));?>"></a></li>-->
                        <?php else: ?>
                        <li style="float: none; width: auto; height: auto;">
                            <div class="noContent" style="background: #FFF; padding-bottom: 20px;">
                                <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                <p>空空如也，没有任何数据</p>
                            </div>
                        </li>
                        <?php endif;?>
                    <?php endif; ?> 

                </ul>
            </div>
            <?php endforeach;?>
            <?php else:?>
                <div class="noContent" style="background: #FFF; padding-bottom: 20px;">
                    <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                    <p>空空如也，没有任何数据</p>
                </div>
            <?php endif;?> 
        </div> 
    </div>
</div>
