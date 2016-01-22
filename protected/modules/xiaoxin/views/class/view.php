<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/view/'.$class->cid);?>"  class="focus">首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/teachers/'.$class->cid);?>" >成员</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/update/'.$class->cid);?>">设置</a></li> 
            </ul>
        </div>  
    </div>
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
               显示本班基本信息资料.
            </div>
        </div>
    </div>

    <div id="contentBox" class="contentBox">
        <div class="box">
            <div class="classTableBox ">
                <div class="classInfoTitle">
                    〓 基本信息
                </div>
                <table class="table table-bordered">
                    <tbody> 
                        <tr>
                            <td class="classTitleTd">名 称</td>
                            <td><?php echo $class->name; ?></td> 
                        </tr>
                        <tr>
                            <td class="classTitleTd">类 型</td>
                            <td><?php echo $class->type?'兴趣班':'标准班级'; ?></td> 
                        </tr>
                    </tbody>
                </table>
                <div class="classInfoTitle">
                    〓 详细信息
                </div>
                 <table class="table table-bordered ">
                    <tbody> 
                        <tr>
                            <td class="classTitleTd">学 校</td>
                            <td><?php echo $school->name; ?></td> 
                        </tr>
                        <tr>
                            <td class="classTitleTd">年 级</td>
                            <td><?php echo $class->type==1?'兴趣班':($grade?$grade->name:'');?></td>
                        </tr>
                        <tr>
                            <td class="classTitleTd">创建日期</td>
                            <td><?php echo $class->creationtime; ?></td> 
                        </tr>
                    </tbody>
                </table>
                <div class="classInfoTitle">
                    〓班级成员
                </div>
                 <table class="table table-bordered">
                    <tbody> 
                        <tr>
                            <td class="classTitleTd">班主任</td>
                            <td><?php echo $master->name; ?></td> 
                        </tr>
                        <tr>  
                            <td class="classTitleTd">任课老师</td>
                            <td><?php echo $class->teachers; ?>人</td> 
                        </tr>
                        <tr>
                            <td class="classTitleTd">班级同学</td>
                            <td><?php echo $class->total; ?>人</td> 
                        </tr>
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
</div>
