<div class="header"> 
    <div class="titleText"><em class="inIco17"></em>我的孩子</div>  
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
                点亮徽标,可以将功能添加到快捷功能列表中，方便您的使用.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox"> 
        <div class="box" style="padding: 20px;"> 
            <div class="classList">
                <ul>
                    <?php if(count($students)): ?>
                        <?php foreach($students as $student): ?>
                            <li>
                                <a href="<?php echo Yii::app()->createUrl('xiaoxin/baby/account/'.$student['child']); ?>">
                                    <div class="classItme " >
                                        <div style="overflow: hidden; width:42px;height:42px; float: left;">
                                            <img src="<?php echo UCQuery::getStudentPhotoByUserid($student['child']); ?>" style="width:40px;height:40px">
                                        </div>
                                        <!-- <em class="classStd"></em> -->
                                        <div class="classItmeInfo"> 
                                            <p class="cName"><?php echo $student['name']; ?></p>
                                            <p>性别：<?php echo UCQuery::getUserSex($student['sex']); ?></p>
                                            <p>年龄：<?php echo MainHelper::getAge($student['birthday']); ?>岁</p>
                                        </div>
                                    </div> 
                                </a>
                            </li> 
                        <?php endforeach; ?>
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
