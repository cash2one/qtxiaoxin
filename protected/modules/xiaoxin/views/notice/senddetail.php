<!--消息,通知详情（发送者的） --> 
<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <?php if($identity!=3): //家长不要显示以发列表?>
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter');?>" >已收消息</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?type=1');?>" class="focus">已发消息</a></li>
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
        <div class="paneBox">
            <div class="pheader"><em class="Pico"></em>功能说明</div>
        </div>
    </div>
    <div id="contentBox" class="contentBox" style="background: none;">
        <div class="box bBottom" style="padding: 10px 15px; background: #ffffff;"> 
            <div class="box noticeListBox"> 
                <ul>
                    <li>
                        <em class="<?php echo $val['showclass'];?>"></em>
                        <div class="txtBox" style="margin-left: 60px;">
                            <div class="noticeTitle"><?php echo $val['typedesc'];?></div>
                            <div class="infoDetail">发给：
                                <a class="hoverName" rel="hoverName" href="" title=" "><?php echo $val['schoolname'];?>&nbsp;<?php echo $val['receivename'];?></a>
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
        <div class="box">
            <div class="">
                <div class="commentsBox">
                    <div class="userPic fleft">
                        <img width="50px;" height="50px" onerror="javascript:this.src='/image/xiaoxin/man_pic.jpg'" src="<?php echo Yii::app()->user->getLogo(); ?>" />
                    </div>
                    <div class="textareaBox" style="">
                        <span class="navIco"> </span>
                        <textarea rel="textarea" id="textareaText" maxlength="120" onkeydown="kbcountInfo(this,'textarea_inputRedinfo');" onkeyup="kbcountInfo(this,'textarea_inputRedinfo');" style="*width: 99%; *padding: 3px 5px; height: 80px;" placeholder="说点什么"></textarea>
                        <div id='textarea_inputRedinfo' class="inputRedinfo">请填写评论,且评论不能大于100个字</div>
                        <div class="commentbtn" style="margin-top: 20px;">&nbsp;
                            <a href="javascript:;" rel="commentRel" data-did="<?php echo $val['noticeid'];?>" style="*margin-top:-30px;" class="fright btn btn-default"> 点评 </a>
                            <!--<label class="checkbox checkbox-inline" style="color: #999999;"><input id="anonymity" type="checkbox"  > 匿名</label>--> 
                        </div>
                    </div> 
                </div>
                <div class="commentsList">
                    <ul class="">
                        <?php if(!empty($replylist)):?>
                        <?php foreach($replylist as $v):?>
                        <li>
                            <div class=" fleft">
                                <img width="40px;" height="40px" onerror="javascript:this.src='/image/xiaoxin/man_pic.jpg'" src="<?php echo $v['photo']; ?>" />
                            </div>
                            <div class="commentTBox">
                                <div class="commentTxt"><span class="name"><?php echo $v['username']?$v['username']:'匿名人';?></span>说：<?php echo $v['content'];?></div>
                                <p class="commentTime"><?php echo $v['showtime'];?></p>
                            </div>
                        </li>
                        <?php endforeach;?>
                        
                        <?php endif;?>
                    </ul>
                </div>
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
            var contentS = $.trim($("#textareaText").val()); 
            if(contentS!=""&&contentS.length<=100){
                $.post("/index.php/xiaoxin/notice/reply",{content:contentS,noticeId:did,nameless:type},function(data)  //回复评论
                {
                    if(data&&data.status==='1'){
                          //num=num+1;
                          //showmessage('评论成功');
                          // window.location="";
                          $("#textareaText").text('');
                          location.reload();
                          
                    }
                },'json');   
            }else{ 
               $(this).parents('.commentsBox').find('.inputRedinfo').show(); 
            }  
        });
         
        
        //查看发送人
        $('[rel=hoverName]').hover(function(){
            $(this).parent().find('.nameBox').show(); 
            $(this).parent('.infoDetail').css('position','relative');
        },function(){
            $(this).parent().find('.nameBox').hide(); 
            $(this).parent('.infoDetail').css('position','static');
        });
    }); 
    
</script>
