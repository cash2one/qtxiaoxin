<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr style="background-color: #e8e8e8;">  
                    <th width="16%">公众号ID</th>
                    <th width="19%">公众号名称</th>
                    <th width="10%">公众号类型</th>
                    <th width="16%">登录手机</th>
                    <th width="8%">发送等级</th>
                    <th width="12%">创建时间</th>
                    <th>操作</th> 
                </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?> 
                    <?php foreach($data['model'] as $offic){?>
                        <tr>
                            <td><a href="<?php echo Yii::app()->createUrl('official/update/'.$offic->infoid); ?>"><img width="30px;" height="30px;" id="uploadImg" src="<?php echo $offic->logo.'?imageView2/1/w/70/h/70'; ?>" onerror="javascript:this.src='<?php echo Yii::app()->request->hostInfo.'/image/xiaoxin/default_pic.jpg'; ?>'" /><span style="margin-left: 15px; color: #333;"><?php echo $offic->openid;?></span></a></td>
                            <td><?php echo $offic->openname;?></td>
                            <td><?php echo $offic->opentype==1?'系统':'普通';?></td>
                            <td><?php echo OfficialInfo::getOfficialAccount($offic->infoid)->mobile;?></td>
                            <td><?php echo OfficialInfo::getSendLevel($offic->freqid);?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($offic->creationtime)); ?></td>
                            <td>
                                <a rel="setPwdBlock" href="javascript:;" mobile="<?php echo OfficialInfo::getOfficialAccount($offic->infoid)->mobile;?>" data-href="<?php echo Yii::app()->createUrl('official/resetpwd/'.$offic->infoid); ?>">重置密码</a>&nbsp;&nbsp;

                                <?php if($offic->block == 2){ ?>
                                    <a href="javascript:;" data-href="<?php echo Yii::app()->request->baseUrl . '/index.php/official/default/remote?infoid='.$offic->infoid; ?>" id="goFront_<?php echo $offic->infoid;?>" style="text-decoration: line-through">进入前端</a>&nbsp;&nbsp;
                                <?php }else{ ?>
                                    <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/official/default/remote?infoid='.$offic->infoid; ?>" data-href="<?php echo Yii::app()->request->baseUrl . '/index.php/official/default/remote?infoid='.$offic->infoid; ?>" id="goFront_<?php echo $offic->infoid;?>">进入前端</a>&nbsp;&nbsp;
                                <?php } ?>

                                <a rel="lockOfficial" id="official_<?php echo $offic->infoid; ?>" sid="<?php echo $offic->infoid; ?>" types="<?php echo $offic->block ;?>"  href="javascript:;" data-href="<?php echo Yii::app()->createUrl('official/setblock/'.$offic->infoid);?>"><?php echo $offic->block==1?"封号":"解封"?></a>&nbsp;&nbsp;
                                <a rel="deleOfficial" href="javascript:;" data-href="<?php echo Yii::app()->createUrl('official/delete/'.$offic->infoid); ?>">删除</a>
                            </td>
                        </tr>
                    <?php } ?> 
                <?php }else {?>
                        <tr>
                            <td colspan="6" align="center" style=" font-size: 21px; padding: 100px 0;">
                                暂无数据
                            </td> 
                        </tr> 
                <?php } ?> 
            </tbody>
        <!--    <tfoot>
                <tr>
                    <td colspan="7">

                    </td>
                </tr>  
            </tfoot>-->
        </table>
        <div id="pager">    
            <?php    
                $this->widget('CLinkPager',array(    
                    'header'=>'',    
                    'firstPageLabel' => '首页',    
                    'lastPageLabel' => '末页',    
                    'prevPageLabel' => '上一页',    
                    'nextPageLabel' => '下一页',    
                    'pages' => $data['pages'],    
                    'maxButtonCount'=>9    
                    )    
                );    
            ?>    
        </div>  
    </div>
    <div id="popupBox" class="popupBox" style="display: none;"> 
        <div id="popupInfo" style="padding:20px 30px;"> 
            <div class="centent">温馨提示：是否删除当前公众号？删除公众号后将会把该公众号所关联的数据一并删除!</div>
      </div>
        <div style="text-align: center;">
            <a id="deleIsOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
            <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
        </div>
    </div>
    <div id="popupBoxSetPwd" class="popupBox" style="display: none;"> 
        <div id="popupInfos" style="padding:20px 30px;"> 
            <div class="centent">温馨提示：是否重置密码？点击确认后新密码会发送到手机 <span class="moblie" style="color: #E95B5F;"></span></div>
      </div>
        <div style="text-align: center;">
            <a id="SetPwdIsOk" href="javascript:void(0);" url="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
            <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBoxSetPwd');" class="btn btn-default">取消</a>
        </div>
    </div> 
    <div id="auditBlockBox" class="popupBox" style="width:540px; height: 305px;">
        <div class=" header"><span class="title">封号原因</span><a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#auditBlockBox')"> </a></div>
        <div class="remindInfo" style="padding: 15px 10px 5px 10px; "> 
            <textarea id="textBlockContent"  style="width:100%;; height: 160px; resize: none;" placeholder="请在这里输入原因,最多输入100个字！" name="reason"></textarea>
            <div><span  class="inputRedinfo" style=" display: none; color: #E95B5F;">请填写原因,最多输入100个字</span>&nbsp;</div>
        </div>
        <div class="popupBtn" style="text-align: center;">
            <a id="cancelSendBnts" href="javascript:;" sid="" url="" class="btn btn-primary">确 定</a>&nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0);" rel="isNotOkCancel" class="btn btn-default">取 消</a>
        </div>
    </div>
     
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
    <script type="text/javascript">
        $(function(){
            //重置密码
            $('[rel=setPwdBlock]').click(function(){
                var url = $(this).data('href');
                var mobile = $(this).attr('mobile');
                $('#SetPwdIsOk').attr("href",url);
                $('#popupInfos').find('span').text(mobile);
                showPromptsIfonWeb('#popupBoxSetPwd');
            }); 
            //删除
            $('[rel=deleOfficial]').click(function(){
                var url = $(this).data('href');
                $("#deleIsOk").attr('href',url);
                showPromptsIfonWeb('#popupBox');
            });
            //封号、解封
            $('[rel=lockOfficial]').click(function(){
                var types =$(this).attr('types');
                var url =$(this).data('href'); 
                var offId = $(this).attr("sid");
                $('#cancelSendBnts').attr('url',url);
                $('#cancelSendBnts').attr('sid',offId);
                if(parseInt(types)==1){
                    $("#auditBlockBox").find('.header').find('.title').text('封号理由'); 
                }else{
                    $("#auditBlockBox").find('.header').find('.title').text('解封理由');  
                }
                showPromptsIfonWeb('#auditBlockBox');
            });
        });
        //确认操作
        $("#cancelSendBnts").click(function(){ 
            var urls =$(this).attr('url');
            var conten =$.trim($('#textBlockContent').val());
            if(conten.length>0 && conten.length<=100){
                var offId = $(this).attr("sid");
                ajaxPBolock(conten,urls,offId);
                hidePormptMaskWeb('#auditBlockBox');
            }else{
                $(".inputRedinfo").show();
            }
           
        });
        //
        $("#textBlockContent").keydown(function(){ 
            $(".inputRedinfo").hide();
        });
        //取消封号、解封操作
        $('[rel=isNotOkCancel]').click(function(){
            hidePormptMaskWeb('#auditBlockBox');
            $('#textBlockContent').val('');
            $(".inputRedinfo").hide();
        });
        
        //请求
        function ajaxPBolock(val,ajaxurl,offId){ 
            $.ajax({  
                url:ajaxurl,   
                type : 'POST',
                data:{reason:val},
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {   
                    var show_data =$.parseJSON(mydata);
                    if(show_data.state){ 
                        if(show_data.type=='解封'){
                             $('#official_'+offId).attr('types',1);
                             $('#official_'+offId).text('封号');
                             $("#goFront_"+offId).removeAttr('style');
                             var hrefStr = $("#goFront_"+offId).data('href');
                             $("#goFront_"+offId).attr('href',hrefStr);
                        }else{ 
                            $('#official_'+offId).text('解封');
                            $('#official_'+offId).attr('types',2);
                            $("#goFront_"+offId).css('text-decoration','line-through');
                            $("#goFront_"+offId).attr('href','javascript:;');
                        } 
                    }else{
                        
                    }
                    $('#textBlockContent').val('');
                    $(".inputRedinfo").hide();
                },  
                error : function() {  
                   // $("#popupInfo").html("加载出错");  
                }  
            });
        }
//        $( "#dateTime" ).datepicker({
//            defaultDate: "+1w", 
//            changeYear: true,
//            numberOfMonths: 1
//        });
        
        
        
    </script>
</div>


  
