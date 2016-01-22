<!--消息,通知详情（发送者的） -->
<div class="header">
    <div class="headBox fright">
        <!--
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter');?>" >已收消息</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type=1');?>" class="focus">已发消息</a></li>
            </ul>
        </div>
        -->
    </div>
    <div class="titleText"><em class="inIco19"></em>日常工作 > 消息审核</div>
</div>
<div class="mianBox">
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em class="Pico"></em>功能说明</div>
        </div>
    </div>
    <div id="contentBox" class="contentBox"  >
        <div class="box bBottom" style="padding: 10px 15px;">
            <div class="box noticeListBox">
                <ul>
                    <li>
                        <em class="<?php echo $val['showclass'];?>"></em>
                        <div class="txtBox" style="margin-left: 60px;">
                            <div class="noticeTitle"><?php echo $val['typedesc'];?></div>
                            <div class="infoDetail">
                                <a class="hoverName" rel="hoverName" href="" title=" ">发给：<?php echo $val['schoolname'];?>&nbsp;<?php echo $val['receivename'];?></a>
                                <div class="nameBox" style=" ">
                                    发给：<?php echo $val['schoolname'];?>&nbsp;<?php echo $val['receivename'];?>
                                </div>
                                <span class="timeIco">&nbsp;</span><?php echo $val['showtime'];?>
                            </div>
                            <p class="noticeInfo"><?php echo $val['content'];?></p>
                            <div class="commentImgBox">
                                <?php if(is_array($val['images'])&&!empty($val['images'])):?>
                                    <?php foreach($val['images'] as $img):?>
                                        <a href="javascript:;" rel="imgPreview" data-img="<?php echo $img;?>" style="width:160px;height:110px;overflow:hidden;display: inline-block;text-align:center;border:1px solid #d9d9d9;margin-right:10px;">
                                            <img style="max-width:160px;" src="<?php echo $img.'?imageView2/3/w/160/h/110';?>"/>
                                             <i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                                        </a>
                                        <!--
                                        <a href="javascript:;"  rel="imgPreview" data-img="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/commentpic.jpg"><img width="160px" height="110px" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/commentpic.jpg"/></a>
                                        <a href="javascript:;" rel="imgPreview" data-img="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/commentpic.jpg"><img width="160px" height="110px" src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/commentpic.jpg"/></a>
                                        -->
                                    <?php endforeach;?>
                                <?php endif;?>
                                <div class="commentAudioBox">
                                    <?php if(isset($val['medias']['url'])&&!empty($val['medias']['url'])):?>
                                        <a href="<?php echo $val['medias']['url'];?>" title="<?php echo $val['medias']['name'];?>">语音下载</a>
                                    <?php endif;?>
                                </div>
                            </div>
                        </div>
                        
                    </li>
                </ul>
            </div>
        </div>
            <div style=" text-align: center; padding: 20px 0;">
                <a class="btn btn-raed approve_status" style=" margin-right: 20px;" href="#">通过</a>  <a class="btn btn-default" href="#" onclick="showPromptsRemind('#auditBox')">未通过</a>
            </div>
    </div>
</div>
<div id="auditBox" class="popupBox" style="width:640px; height: 330px;">
    <div class=" header"> 审核不通过</div>
    <div class="remindInfo"> 
        <textarea style="width:100%;; height: 160px;" placeholder="请在这里输入审核不通过原因！" name="reason"></textarea>
        <div class="inputRedinfo" style=" display: none; color: #E95B5F;">请填写原因,最多输入100个字</div>
    </div>
    <div class="popupBtn">
        <a id="cancelSendBnt " href="#" class="btn btn-raed unapprove_status">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" rel="isNotOk" class="btn btn-default">取 消</a>
    </div>
</div> 
<div id="PreviewBox">
    <div id="imgPreview" class="popupBox" style=" ">
        <div class="header" style="">&nbsp;<a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#imgPreview')" > </a></div>
        <div id="imgPBox" class="imgbox" style="padding: 10px 40px;">
            <p>正在加载...</p>
        </div>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        $("#menuListBoxs li a[href*='approvelist']").addClass("focus");
        //查看图片
        $('[rel=imgPreview]').click(function(){
            var imgUrl = $(this).data('img');
            var img ='<img style="max-height:600px;" src="'+imgUrl+'">';
            $("#imgPBox").empty();
            $("#imgPBox").append(img);
            showPromptsImg('#imgPreview');
        });

        //发表评论
        $('[rel=commentRel]').click(function(){
            var did = $(this).data('did');
            var num = $(this).data('num');
            var type = '0';
            if($('#anonymity').attr('checked')=="checked"){
                type = '1'
            }
            var contentS = $("#textareaText").val();
            if(contentS!=""&&contentS.length<100){
                 $.post("/index.php/xiaoxin/notice/reply",{content:contentS,noticeId:did,nameless:type},function(data)  //回复评论
                {
                    if(data&&data.status==='1'){
                        //num=num+1;
                        //showmessage('评论成功');
                        window.location="";
                        $("#textareaText").text('');

                    }
                },'json'); 
            }else{
               $(this).parents('.commentsBox').find('.inputRedinfo').show();
            }
        });

        //输入框优化
        $('[rel=textarea]').keydown(function(){
            $(this).parents('.commentsBox').find('.inputRedinfo').hide();
        });

        //查看发送人
        $('[rel=hoverName]').hover(function(){
            $(this).parent().find('.nameBox').show();
        },function(){
            $(this).parent().find('.nameBox').hide();
        });

        /*
          审核
          var url="<?php echo Yii::app()->createUrl('xiaoxin/notice/approve');?>
          参数:id <?php echo $val['id'];?>
          status: 1 --审核通过  2--审核不通过
          reason --如果审核不通过(填写原因
          $.post(url,{id:id,status:status,reason:reason},function(data){
          },'json);
         */
          //审核不通过
        $(".unapprove_status").on("click",function(e){
           // e.preventDefault();
            var url="<?php echo Yii::app()->createUrl('xiaoxin/notice/approve');?>";
            var id="<?php echo $val['id'];?>";
            var status=2;
            var reason=$.trim($("textarea[name=reason]").val());
            if(reason.length<=100&&reason.length>0){
                 $.post(url,{id:id,status:status,reason:reason},function(data){
                    if(data&&data.status==='1'){
                       // alert('审核成功');
                        location.href="<?php echo Yii::app()->createUrl('xiaoxin/notice/approvelist?status=0');?>";
                    }
                },'json');
            }else{
                if(reason.length>100){
                    $(".inputRedinfo").text('最多输入100个字').show();
                }else{
                    $(".inputRedinfo").text('请填写原因').show();
                } 
            } 
        });
        //取消
        $("[rel=isNotOk]").click(function(){
            $(".inputRedinfo").hide();
            $("textarea[name=reason]").val('');
            hidePormptMaskWeb('#auditBox');
        });
        
        //审核通过
        $(".approve_status").on("click",function(){
            var url="<?php echo Yii::app()->createUrl('xiaoxin/notice/approve');?>";
            var id="<?php echo $val['id'];?>";
            var status=1;
            var reason='';
            $.post(url,{id:id,status:status,reason:reason},function(data){
                if(data&&data.status==='1'){
                   // alert('审核成功');
                    location.href="<?php echo Yii::app()->createUrl('xiaoxin/notice/approvelist?status=0');?>";
                }
            },'json');
        })


    });

</script>
