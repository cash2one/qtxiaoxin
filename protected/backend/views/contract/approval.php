<div class="box"> 
    <div class="viweInfo" style="">
        <p><span class="leftTitle">所属商家：</span><?php echo $model->getBusinessName(); ?></p>
        <p><span class="leftTitle">创建日期：</span><?php echo date('Y-m-d',strtotime($model->creationtime)); ?></p>
        <p><span class="leftTitle">创建人：</span><?php echo User::getUserName($model->uid); ?></p>
        <p><span class="leftTitle">合同编号：</span><?php echo $model->contractid; ?></p>
        <?php if($model->checker){ ?>
        <p><span class="leftTitle">审批人：</span><?php echo User::getUserName($model->checker); ?></p>
        <?php } ?>
        <p><span class="leftTitle">状态：</span><?php echo $model->getStateName(); ?></p>
    </div>  
    <?php if($total){ ?>
    <div class="tableBox" style="width: 90%; overflow: hidden; ">
        <div style="overflow: hidden;">
            <table  class="table table-bordered table-hover">
                <thead >
                    <tr style="background-color: #e8e8e8;">
                        <th width="26%">标题</th>
                        <th width="6%">类别</th>
                        <th width="20%">投放时间</th>
                        <th width="15%">推广范围</th>
                        <th width="15%">位置</th>
                        <th>操作</th>
                   </tr>
                </thead>
                <tbody>
                    <?php foreach($advrels as $ar){ ?>
                        <tr>
                            <td><?php echo Advertisement::getAdvTitle($ar->aid); ?></td>
                            <td>广告</td>
                            <td><?php echo date('Y-m-d',strtotime($ar->startdate)); ?>&nbsp;至&nbsp;<?php echo date('Y-m-d',strtotime($ar->enddate)); ?></td>
                            <td><?php echo $ar->school; ?>所学校<?php echo $ar->person; ?>用户</td>
                            <td><?php echo AdvertisementLocation::getLoactionNameById($ar->alid); ?></td> 

                            <td>
                                <a href="javascript:void(0);" rel="range_view" data-href="<?php echo Yii::app()->createUrl('contract/contypepreview');?>" ty="adv" rid="<?php echo $ar->aid; ?>">预 览</a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0);" rel="range_detail" data-href="<?php echo Yii::app()->createUrl('contract/rangedetail');?>" ty="adv" rid="<?php echo $ar->carid; ?>">查看范围</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php foreach($focrels as $fr){ ?>
                        <tr>
                            <td><?php echo Focus::getFocTitle($fr->fid); ?></td>
                            <td>热点</td>
                            <td><?php echo date('Y-m-d',strtotime($fr->startdate)); ?>&nbsp;至&nbsp;<?php echo date('Y-m-d',strtotime($fr->enddate)); ?></td>
                            <td><?php echo $fr->school; ?>所学校<?php echo $fr->person; ?>用户</td>
                            <td></td>
                            <td>
                                <a href="javascript:void(0);" rel="range_view" data-href="<?php echo Yii::app()->createUrl('contract/contypepreview');?>" ty="foc" rid="<?php echo $fr->fid; ?>">预 览</a>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0);" rel="range_detail" data-href="<?php echo Yii::app()->createUrl('contract/rangedetail');?>" ty="foc" rid="<?php echo $fr->cfrid; ?>">查看范围</a>
                            </td>
                        </tr>
                    <?php } ?>

                    <?php foreach($inforels as $info){ ?>
                        <tr>
                            <td><?php echo Information::getInfoTitle($info->iid); ?></td>
                            <td>资讯</td> 
                            <td><?php echo date('Y-m-d',strtotime($info->startdate)); ?></td>
                            <td></td>
                            <td></td>
                             <td>
                                <a href="javascript:void(0);" rel="range_view" data-href="<?php echo Yii::app()->createUrl('contract/contypepreview');?>" ty="info" rid="<?php echo $info->iid; ?>">预 览</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
    <div style="margin-top: 20px;">
        <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('contract/setstate/'.$model->cid);?>?state=2">同意并发布</a>
        &nbsp;&nbsp;&nbsp;
        <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('contract/setstate/'.$model->cid);?>?state=3">拒绝申请</a>
        &nbsp;&nbsp;&nbsp;
        <a class="btn btn-default" href="javascript:void(0);" onclick="showPromptsIfonWeb('#popupBoxRemind')" >删除合同</a>
    </div> 
    <div id="popupBoxViwe" class="popupBox" style="width: 880px;">
        <div class="header">查看范围 <a href="javascript:void(0);" class="close" onclick="hidePormptMask('popupBox')" > </a></div>
        <div id="popupInfo" style="padding:20px; "> 
        </div> 
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="javascript:void(0);" class="btn btn-primary" onclick="hidePormptMask('popupBox')"> 取 消 </a> 
        </div>
    </div>
    <div id="popupViweWeb">
    <div id="popupBoxWeb" class="popupBox" style="margin-top: 0;">
        <div class="header">预览 <a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#popupBoxWeb')" > </a></div> 
        <div id="popupInfoWeb" style="padding: 10px; max-height: 530px; overflow-x: hidden; overflow-y: auto;" > </div> 
    </div>
<div id="popupRemind">
    <div id="popupBoxRemind" class="popupBox" style=" width: 380px; height: 190px; margin-top: 0;">
        <div class="header">删除提醒 <a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#popupBoxRemind')" > </a></div> 
        <div class="remindInfoBox"> 
            <div>&nbsp;&nbsp;温馨提醒，是否删除当前合同？</div>  
        </div>
        <div style="text-align: center; margin-top:20px;">
             <a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('contract/delete/'.$model->cid);?>?returntype=doc">确定</a>
         &nbsp;&nbsp;&nbsp;&nbsp;  <a class="btn btn-default" href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBoxRemind')">取消</a> 
        </div> 
    </div>
</div> 
</div>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script>
    <script type="text/javascript">
        $(function(){
            //配置信息请求
            function ajaxGetOptions(box,ajaxoptionsurl,rid,ty){//
                $.ajax({  
                    url: ajaxoptionsurl,   
                    type : 'POST',  
                    data : {ty:ty,rid:rid},  
                    dataType : 'text',  
                    contentType : 'application/x-www-form-urlencoded',  
                    async : false,  
                    success : function(mydata) { 
                        ajaxoptions = mydata;  
                       $(box).append(ajaxoptions); 
                    },  
                    error : function() {   
                    }  
                });
            }
           //查看内容广告、热点、资讯请求
            function ajaxGetweb(box,ajaxoptionsurl,rid,ty){//
                $.ajax({  
                    url: ajaxoptionsurl,   
                    type : 'POST',  
                    data : {ty:ty,tid:rid},  
                    dataType : 'text',  
                    contentType : 'application/x-www-form-urlencoded',  
                    async : false,  
                    success : function(mydata) {  
                        ajaxoptions = mydata;  
                       $(box).append(ajaxoptions); 
                    },  
                    error : function() {   
                    }  
                });
            }
            //查看配置信息
            $("[rel=range_detail]").click(function(){
                var Dataherf = $(this).data('href'),box = "#popupInfo"; 
                var rid = $(this).attr('rid'),ty = $(this).attr('ty');
                $(box).empty();
                ajaxGetOptions(box,Dataherf,rid,ty);
                showPromptsIfonWeb('#popupBoxViwe');
            });
            //查看内容广告、热点、资讯
            $("[rel=range_view]").click(function(){
                var Dataherf = $(this).data('href'),box = "#popupInfoWeb"; 
                var rid = $(this).attr('rid'),ty = $(this).attr('ty');
                $(box).empty();
                ajaxGetweb(box,Dataherf,rid,ty);
                showPromptsIfonWeb('#popupBoxWeb');
            });
        });
    </script>
</div>