<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/baby/account/'.$child->userid);?>">首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/group/'.$child->userid);?>" class="focus">班级</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/parent/'.$child->userid);?>">家长</a></li>
            </ul>
        </div>  
    </div>
    <div class="titleText"><em class="inIco17"></em>我的孩子 > <span><?php echo $child->name; ?></span></div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box">
           <div class="classTableBox classMemberBox">
                <div class=" classInfoTitle ">
                    〓  已加入
                </div>
                <table class="table"> 
                    <tbody>
                        <tr class="tableHead">
                            <th width="18%"><div class="name" style="width: 140px;">班级名称</div></th>
                            <th width="25%">班主任</th>
                            <th width="20%">进班时间</th>
                            <th width="15%">操作</th>
                        </tr>
                        <?php if(count($groups)): ?>
                            <?php foreach($groups as $group): ?>
                                <tr>
                                    <?php $master = UCQuery::loadClass($group['cid'])->master; ?>
                                    <td><div class="name"><?php echo UCQuery::loadClass($group['cid'])->name; ?></div></td>
                                    <td><div class="name" style="width: auto;"><?php if($master){$teacher = UCQuery::loadUser($master); echo $teacher->mobilephone.'('.$teacher->name.')';} ?></div></td>
                                    <td><?php echo  date('Y年m月d日',strtotime($group['updatetime']?$group['updatetime']:$group['creationtime'])); ?></td>
                                    <td><a rel="dele" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/remove/'.$group['id']) ?>?child=<?php echo $child->userid; ?>">移除</a></td>
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
               <div class="classInfoTitle" style="display: none;">
                    〓 待加入
                </div>
                <table class="table table-hover" style="display: none;"> 
                    <tbody>
                        <tr class="tableHead">
                            <th width="20%"><div class="name" style="width: 140px;">班级名称</div></th>
                            <th width="25%">邀请人</th>
                            <th width="22%">邀请时间</th>
                            <th>操作</th>
                        </tr>
                        <?php if(count($applies)): ?>
                            <?php foreach($applies as $apply): ?>
                                <tr>
                                    <td><div class="name"><?php echo UCQuery::loadClass($apply['cid'])->name; ?></div></td>
                                    <td><div class="name" style="width: auto;"><?php $creater=$apply['creater']?UCQuery::loadUser($apply['creater']):''; echo $creater?$creater->mobilephone.'('.$creater->name.')':''; ?></div></td>
                                    <td><?php echo  date('Y年m月d日',strtotime($apply['updatetime']?$apply['updatetime']:$apply['creationtime'])); ?></td>
                                    <td><a href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/accept/'.$apply['id']) ?>?child=<?php echo $child->userid; ?>">同意</a>&nbsp;/&nbsp;<a href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/deny/'.$apply['id']) ?>?child=<?php echo $child->userid; ?>">拒绝</a></td>
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
            </div>
        </div>
    </div>
</div>
<div id="remindBox" class="popupBox"> 
    <div class="remindInfo"> 
        <div id="remindText" class="centent">是否退出当前班级？退出后将接收不到当前班级发的任何信息！</div>
    </div>
    <div class="popupBtn">
        <a id="deleLink" href=""  class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskWeb('#remindBox')" class="btn btn-default">取 消</a>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script> 
<script type="text/javascript">
    //删除操作
    $('[rel=dele]').click(function(){ 
        var url = $(this).data('href'); 
        $('#deleLink').attr('href',url);
        showPromptsRemind('#remindBox');
    });
</script>
