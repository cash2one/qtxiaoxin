<!--消息通知中心 -->
<style>
    #message, .message{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; left: 40%; bottom:0px; display: none; z-index: 10000; border-radius: 5px;}
    #message .messageType, .message .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message .success, .message .success{  border: 1px solid #fbeed5; background-color: #e95b5f; color: #fbe4e5; }
    #message .error,.message .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
</style>
<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <?php if($identity!=4): //家长登录?>
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type=0');?>" class="focus">已收消息</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type=1');?>" >已发消息</a></li>
            </ul>
            <?php endif;?>
        </div>  
    </div>
    <div class="titleText"><em class="inIco15"></em>消息中心</div>  
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
         <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox backtrackColor">
            <div class="pheader"><em class="Pico"></em>查找</div>
            <div class="tableForm">
                <form id="formBoxRegister" action="" method="post">
                    <div class="stitle">查询内容：</div>
                    <div class=" inputBox" style="overflow: hidden;"><input style="width: 100%; *width: 270px;" onkeyup="this.value=this.value.replace(/(^\s+)|\s+$/g,'');" value="<?php echo $keyword;?> "   type="text" name="keyword" class="lg" placeholder="" /></div>
                    <div class="stitle">选择日期范围：</div>
                    <div class="selectListBox">
                        <ul>
                            <li><a rel="checkSearch" avalue="0" href="javascript:void(0);"><span class="fright check">✔</span>全部</a><input class="hide" name="time" value="0" type="radio"></li>
                            <li><a rel="checkSearch" avalue="1" href="javascript:void(0);"><span class="fright">✔</span>本周</a><input class="hide" name="time" value="1" type="radio"></li>
                            <li><a rel="checkSearch" avalue="2" href="javascript:void(0);"><span class="fright">✔</span>上周</a><input class="hide" name="time" value="2" type="radio"></li>
                            <li><a rel="checkSearch" avalue="3" href="javascript:void(0);"><span class="fright">✔</span>本月</a><input class="hide" name="time" value="3" type="radio"></li>
                            <li><a rel="checkSearch" avalue="4"  href="javascript:void(0);"><span class="fright">✔</span>上月</a><input class="hide" name="time" value="4" type="radio"></li>
                            <li><a rel="checkSearch" avalue="5" href="javascript:void(0);"><span class="fright">✔</span>本学期</a><input class="hide" name="time" value="5" type="radio"></li>
                        </ul>
                    </div>
                    <div class="searchBtnBox">
                        <input type="button" rel="searchBtns" class="btn btn-raed" value="开始查找" >
                        <!--<a class="btn btn-raed">开始查找</a>-->
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box" style="padding-top: 10px;">
            <div class="headBox">
                <div class="headNav">
                    <ul class="noticeType_select">
                        <?php if($identity==4): //家长登录?>
                            <li><a avalue="" href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=');?>" class="focus" >全部</a></li>
                            <li><a avalue="2,4" href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=2,4');?>" >通知</a></li>
                            <li><a avalue="1" href="<?php echo  Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=1');?>" >作业</a></li>
                            <li><a  avalue="3" href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=3');?> " >表现</a></li>
                            <li><a  avalue="5" href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=5');?> " >成绩</a></li>
                            <li><a  avalue="8" href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=8');?> " >餐单</a></li>
                            <li><a avalue="0" href="<?php echo  Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=0');?>" >系统</a></li>
                        <?php else:?>
                            <li><a avalue="" href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=');?>" class="focus" >全部</a></li>
                            <li><a avalue="4,7" href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=4,7');?>" >通知</a></li>
                            <li><a avalue="0" href="<?php echo  Yii::app()->createUrl('xiaoxin/notice/noticecenter?type='.$type.'&noticeType=0');?>" >系统</a></li>
                        <?php endif;?>
                    </ul>
                    <?php if($notReadNum>0):?>
                     <span rel="allReadBtn" class="btn fright btn-default" style="margin-top: 8px; color: #999;">全部设为已读</span>
                    <?php endif;?>
                </div>  
            </div>
            <div class="box noticeListBox">
            <?php if(empty($data)){?>
               <div class="noContent">
                    <span><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                    <p>空空如也，没有任何消息</p>
                </div>
                <?php }else{?>
                <ul>
                    <?php foreach($data as $val):?>
                    <li msgid="<?php echo $val['msgid'];?>">
                        <em class="<?php echo $val['showclass'];?>"></em> 
                        <div class="txtBox" style="margin-left: 65px;">
                            <div class="noticeTitle"><?php echo $val['typedesc'];?><span class="redType"><?php echo $val['readMsg'];?></span></div>
                            <div class="infoDetail">来自：<?php echo $val['schoolname']."&nbsp;".$val['uname'];?>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $val['receivername']?$val['receivername'].'&nbsp;&nbsp;&nbsp;':'';?><span class="timeIco">&nbsp;&nbsp;</span><?php echo $val['showtime'];?> &nbsp;&nbsp;<span class="commentIco">
                                <a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/detail?id='.$val['msgid']);?>">评论(<b rel="replyNum_<?php echo $val['msgid'];?>"><?php echo (int)$val['replyNum'];?></b>)</a></span>
                            </div> 
                            <p class="noticeInfo"><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/detail?id='.$val['msgid']);?>"><?php echo $val['content'];?></a></p>
                           
                            <?php if(is_array($val['images'])&&!empty($val['images'])):?>
                                <div class="commentImgBox">
                                    <?php foreach($val['images'] as $img):?>
                                        <a href="javascript:;" rel="imgPreview" data-img="<?php echo $img;?>" style="width:160px;height:110px;overflow:hidden;display: inline-block;text-align:center;border:1px solid #d9d9d9;margin-right:10px;">
                                            <img style="max-width:160px;" src="<?php echo $img.'?imageView2/3/w/160/h/110';?>"/>
                                             <i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                                        </a>
                                    <?php endforeach;?>
                                </div>
                            <?php else:?>
                                
                        <?php endif;?>
                        <div class="commentAudioBox">
                            <?php if(isset($val['medias']['url'])&&!empty($val['medias']['url'])):?>
                                <a href="<?php echo $val['medias']['url'];?>" title="<?php echo $val['medias']['name'];?>">语音下载</a>
                            <?php endif;?>
                        </div> 
                        <div class="commentsBox">
                            <div style=" overflow: hidden; width: 100%;">
                                <div class="commentbtn"><a href="javascript:;" msgid="<?php echo $val['msgid'];?>"  rel="commentRel" data-did="<?php echo $val['noticeid'];?>" data-num="<?php echo $val['replyNum'];?>"  > 点评 </a></div>
                                 <div class="textinput" style=" *overflow: hidden;"> 
                                    <input id="textarea_<?php echo $val['noticeid'];?>"  value="" rel="textarea" type="text" maxlength="110"  onkeyup="kbcount(this,'textarea_<?php echo $val['noticeid'];?>');" onafterpaste="kbcount(this,'textarea_<?php echo $val['noticeid'];?>');" style=" vertical-align: bottom;width:100%; height: 32px; *line-height: 30px; *height: 30px; *margin-top:-1px;border: 1px solid #e1e1e1; *padding: 3px;"   placeholder="说点什么" >
                                </div>
                            </div>
                            <div class="inputRedinfo kbcountRedinfo" >请填写评论</div> 
                        </div>
                    </li>
                    <?php endforeach;?> 
                </ul>
                <?php } ?> 
                <div id="pager" style="  margin-top: 30px;">
                    <?php
                    $this->widget('CLinkPager',array(
                            'header'=>'',
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '末页',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'pages' => $pages,
                            'maxButtonCount'=>5
                        )
                    );
                    ?>
                </div>
            </div>
        </div> 
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
        var noticeType="<?php echo $noticeType;?>",
         keyword="<?php echo $keyword;?>",
         timeType="<?php echo (int)$timeType;?>";
        $(".noticeType_select a").removeClass("focus");
        $(".noticeType_select a[avalue='"+noticeType+"']").addClass("focus");
        /*
        if(noticeType=="2,7"){
            $(".noticeType_select a:eq(1)").addClass("focus");
        }else if(noticeType=="0"){
            $(".noticeType_select a:eq(2)").addClass("focus");
        } else{
            $(".noticeType_select a:eq(0)").addClass("focus");
        }
        */
        $(".selectListBox li a span").removeClass("check");
        $(".selectListBox li a[avalue="+timeType+"] span").addClass("check");
        $("input[name=time][value="+timeType+"]").attr("checked",true);
        $("[rel=searchBtns]").on("click",function(){
             var url="<?php echo Yii::app()->createUrl("xiaoxin/notice/noticecenter");?>";
             url=url+"?noticeType="+noticeType+"&keyword="+ $.trim($("input[name=keyword]").val())+"&timeType="+$("input[name=time]:checked").val();
             location.href=url;
        });
        //快捷搜索
        
        $('[rel=imgPreview]').click(function(){
            var imgUrl = $(this).data('img'); 
            var img ='<img style="max-height:600px;"  src="'+imgUrl+'">'; 
            $("#imgPBox").empty();
            $("#imgPBox").append(img);
            showPromptsImg('#imgPreview');
        });
        //发表评论
        $('[rel=commentRel]').click(function(){
            var self=this;
            var did = $(this).data('did'); 
            var num = $(this).data('num');
            var msgid = $(this).attr('msgid');
            var next=$(this).parent().next();
            //有相同did的情况
            var contentS = $.trim($("input",next).val());

            if(contentS==""){ 
                $(this).parents('.commentsBox').find('.inputRedinfo').text('评论不能为空').show();
            }else{ 
                 if(contentS.length>100){
                    $(this).parents('.commentsBox').find('.inputRedinfo').text('评论不能大于100个字').show();
                }else{
                    $.post("/index.php/xiaoxin/notice/reply",{msgid:msgid,content:contentS,noticeId:did},function(data)  //回复评论
                    {
                        if(data&&data.status==='1'){ 
                            var tishi = '<div id="message"><div class="messageType success" id="type-success"><span >✔</span>&nbsp;&nbsp;评论成功</div></div>';
                              num=num+1; 
                              //$("#textarea_"+did).val('');
                              $("input",next).val('');
                              $("[rel=replyNum_"+msgid+"]").text(num);
                              $(self).data("num",num);
                              $('body').append(tishi);
                        }else{ 
                             var tishi = '<div id="message"><div class="messageType success" id="type-success"><span >✘</span>&nbsp;&nbsp;评论失败</div></div>';
                             $('body').append(tishi);
                        }
                        $('#message').show(); 
                        setTimeout( function() { $('#message').slideUp("slow");},3000); 
                    },'json'); 
                } 
            }  
        });  
        //搜索选择日期范围
        $('[rel=checkSearch]').click(function(){
            $(this).parent('li').find('input[type=radio]').click();
            $(this).parent('li').siblings().find('span').removeClass('check');
            $(this).parent('li').find('span').addClass('check');
        });
        
       //未读消息设为已读
       $('[rel=allReadBtn]').click(function(){
           var that=this;
           var urls='<?php echo Yii::app()->createUrl("xiaoxin/notice/setreadstate");?>';  
           $.getJSON(urls,{noticeType:noticeType},function(data){  
                if(data&&data.status=="1"){ 
                    var tishi = '<div id="message1" class="message"><div class="messageType success" id="type-success"><span >✔</span>&nbsp;&nbsp;设置成功</div></div>';
                    $(this).hide();
                }else{ 
                    var tishi = '<div id="message1" class="message"><div class="messageType success" id="type-success"><span >✘</span>&nbsp;&nbsp;设置失败</div></div>';
                }
                $('body').append(tishi);
                $('#message1').show();
                $(that).hide();
                setTimeout( function() { $('#message1').slideUp("slow");},3000);
                setTimeout( function() {$('#message1').remove();$(".redType").hide(); },4000);
            });
       });
    });
     
</script>
