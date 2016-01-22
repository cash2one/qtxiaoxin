<div class="box"> 
    <div class="viweInfo" style="">
        <p><span >所属商家：</span><?php echo $model->getBusinessName(); ?></p>
        <p><span >创建日期：</span><?php echo $model->creationtime; ?></p>
        <p><span >创建人：</span><?php echo User::getUserName($model->uid); ?></p>
        <p><span>合同编号：</span><?php echo $model->contractid; ?></p>
        <?php if($model->checker){ ?>
        <p><span >审批人：</span><?php echo User::getUserName($model->checker); ?></p>
        <?php } ?>
        <p><span>状态：</span><?php echo $model->getStateName(); ?></p>
    </div>  
    <?php if($total){ ?>
    <div class="tableBox" style="width: 90%; overflow: hidden; ">
        <div style="overflow: hidden;">
            <table  class="table table-bordered table-hover">
                <thead >
                    <tr style="background-color: #e8e8e8;"> 
                        <th width="30%">标题</th>
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
                            <td><?php echo date('Y-m-d',strtotime($ar->startdate));?>&nbsp;至&nbsp;<?php echo date('Y-m-d',strtotime($ar->enddate));?></td>
                            <td><?php echo $ar->school; ?>所学校<?php echo $ar->person; ?>用户</td>
                            <td><?php echo AdvertisementLocation::getLoactionNameById($ar->alid); ?></td>
                            <th><a href="javascript:void(0);" rel="range_detail" data-href="<?php echo Yii::app()->createUrl('contract/rangedetail');?>" ty="adv" rid="<?php echo $ar->carid; ?>">查看范围</a></th>
                        </tr>
                    <?php } ?>
                    <?php foreach($focrels as $fr){ ?>
                        <tr>
                            <td><?php echo Focus::getFocTitle($fr->fid); ?></td>
                            <td>热点</td>
                            <td><?php echo date('Y-m-d',strtotime($fr->startdate));?>&nbsp;至&nbsp;<?php echo date('Y-m-d',strtotime($fr->enddate));?></td>
                            <td><?php echo $fr->school; ?>所学校<?php echo $fr->person; ?>用户</td>
                            <td></td>
                            <th><a href="javascript:void(0);" rel="range_detail" data-href="<?php echo Yii::app()->createUrl('contract/rangedetail');?>" ty="foc" rid="<?php echo $fr->cfrid; ?>">查看范围</a></th>
                        </tr>
                    <?php } ?>

                    <?php foreach($inforels as $info){ ?>
                        <tr>
                            <td><?php echo Information::getInfoTitle($info->iid); ?></td>
                            <td>资讯</td> 
                            <td><?php echo date('Y-m-d',strtotime($info->startdate)); ?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div> 
    <?php } ?>
    <?php if($model->state==2){ ?>
    <div style=" margin-top: 20px;">
        <a class="btn btn-default" href="<?php echo Yii::app()->createUrl('contract/delete/'.$model->cid);?>?returntype=doc">删除合同</a>
    </div> 
    <?php } ?>
    <div class="popupBox" style="width: 880px;">
        <div class="header">查看范围 <a href="javascript:void(0);" class="close" onclick="hidePormptMask('popupBox')" > </a></div>
        <div id="popupInfo" style="padding:20px; "> 
        </div> 
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="javascript:void(0);" class="btn btn-primary" onclick="hidePormptMask('popupBox')"> 取 消 </a> 
        </div>
    </div>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script>
    <script type="text/javascript">
        $(function(){
            //请求配置范围 
            function ajaxGetOptions(ajaxoptionsurl,rid,ty){//
                $.ajax({  
                    url: ajaxoptionsurl,   
                    type : 'POST',  
                    data : {ty:ty,rid:rid},  
                    dataType : 'text',  
                    contentType : 'application/x-www-form-urlencoded',  
                    async : false,  
                    success : function(mydata) {   
                        //console.log(mydata);
                        ajaxoptions = mydata;  
                       $("#popupInfo").append(ajaxoptions); 
                    },  
                    error : function() {  
                        // alert("calc failed");  
                    }  
                });
            }
            
            //查看配置范围 
            $("[rel=range_detail]").click(function(){
                var Dataherf = $(this).data('href'); 
                var rid = $(this).attr('rid'),ty = $(this).attr('ty');
                $("#popupInfo").empty();
                ajaxGetOptions(Dataherf,rid,ty);
                showPromptsIfon('popupBox');
            });
             
        });
    </script>
</div>