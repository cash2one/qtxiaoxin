<!--消息发送列表-->
<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/sendlist?noticeType='.$noticeType);?>"class="focus" >发送记录</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/unsendlist?noticeType='.$noticeType);?>" >待发列表</a></li>
                <?php if($noticeType==1):?>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/homework');?>">发布作业</a></li>
                <?php ;elseif($noticeType==2):?>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticefamily');?>">通知家长</a></li>
                <?php ;elseif($noticeType==4):?>
                    <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticerush');?>">紧急通知</a></li>
                <?php ;elseif($noticeType==7):?>
                    <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticeteacher');?>">通知老师</a></li>
                    <?php ;elseif($noticeType==3):?>
                    <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/conduct');?>">在校表现</a></li>
                <?php endif;?>
            </ul>
        </div>  
    </div> 
    <div class="titleText"><em class="<?php echo (isset($navClass[$noticeType]))?$navClass[$noticeType]:'';?>"></em>日常工作 >
        <?php
        $type= Constant::noticeTypeArray();
        echo $type[$noticeType];
        ?></div>
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
                    <div class=" inputBox"><input style=" width: 100%; *width: 270px;" name="keyword" onkeyup="this.value=this.value.replace(/(^\s+)|\s+$/g,'');" value="<?php echo $keyword;?>" type="text" class="lg" placeholder="" /></div>
                    <div class="stitle">选择日期范围：</div>
                    <div class="selectListBox">
                        <ul>
                            <li><a rel="checkSearch" avalue="0" href="javascript:void(0);"><span class="fright check">✔</span>全部</a><input class="hide" name="time" value="0" type="radio"></li>
                            <li><a rel="checkSearch" avalue="1" href="javascript:void(0);"><span class="fright">✔</span>本周</a><input class="hide" name="time" value="1" type="radio"></li>
                            <li><a rel="checkSearch" avalue="2" href="javascript:void(0);"><span class="fright">✔</span>上周</a><input class="hide" name="time" value="2"  type="radio"></li>
                            <li><a rel="checkSearch" avalue="3" href="javascript:void(0);"><span class="fright">✔</span>本月</a><input class="hide" name="time" value="3" type="radio"></li>
                            <li><a rel="checkSearch" avalue="4" href="javascript:void(0);"><span class="fright">✔</span>上月</a><input class="hide" name="time" value="4" type="radio"></li>
                            <li><a rel="checkSearch" avalue="5" href="javascript:void(0);"><span class="fright">✔</span>本学期</a><input class="hide" name="time" value="5" type="radio"></li>
                        </ul>
                    </div>
                    <div class="searchBtnBox">
                        <input type="button" class="btn btn-raed" value="开始查找" >
                        <!--<a class="btn btn-raed">开始查找</a>-->
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box" style="padding-top:10px; "> 
            <div class="box noticeListBox">
                <?php if(empty($data)){?>
                    <div class="noContent">
                        <span><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                        <p>空空如也，没有任何消息</p>
                    </div>
                <?php }else{?>
                <ul>
                    <?php foreach($data as $val):?>
                    <li class="bBottom">
                        <em class="<?php echo $val['showclass'];?>"></em>
                        <div class="txtBox" style="margin-left: 60px;">
                            <div class="noticeTitle"><?php echo $val['typedesc'];?></div>
                            <div class="infoDetail">发给： 
                                <a class="hoverName" rel="hoverName"href="javascript:void(0);" title=""><?php echo $val['schoolname'];?>&nbsp;
                                    <?php echo $val['receivename'];?>&nbsp; </a> 
                                <div class="nameBox" style=" ">
                                    <?php echo $val['schoolname'];?>&nbsp; <?php echo $val['receivename'];?>
                                </div> 
                                <span class="timeIco">&nbsp;</span><?php echo $val['showtime'];?>
                                <span class="commentIco"><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/showdetail?id='.$val['noticeid']);?>">评论(<?php echo $val['replyNum'];?>)</a></span>
                            </div>
                            <p class="noticeInfo"><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/showdetail?id='.$val['noticeid']);?>"><?php echo $val['content'];?></a></p> 
                            <?php if(is_array($val['images'])&&!empty($val['images'])):?>
                                <div class="commentImgBox">
                                    <?php foreach($val['images'] as $img):?> 
                                        <a  href="javascript:;" rel="imgPreview" data-img="<?php echo $img;?>"> 
                                            <div style=" display: inline-block; overflow: hidden; width: 160px; height: 110px; text-align: center; vertical-align: middle;">
                                                <img style="max-width:160px"  src="<?php echo $img.'?imageView2/3/w/160/h/110';?>"/>
                                                <i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                                            </div>
                                        </a>  
                                    <?php endforeach;?>
                                </div>
                            <?php endif;?>
                            <div class="commentAudioBox">
                                <?php if(isset($val['medias']['url'])&&!empty($val['medias']['url'])):?>
                                    <a href="<?php echo $val['medias']['url'];?>" title="<?php echo $val['medias']['name'];?>">语音下载</a>
                                <?php endif;?>
                            </div>
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
        if(noticeType=="2"){
            $(".noticeType_select a:eq(1)").addClass("focus");
        }else if(noticeType=="0"){
            $(".noticeType_select a:eq(2)").addClass("focus");
        } else{
            $(".noticeType_select a:eq(0)").addClass("focus");
        }
        $(".selectListBox li a span").removeClass("check");
        $(".selectListBox li a[avalue="+timeType+"] span").addClass("check");
        $("input[name=time][value="+timeType+"]").attr("checked",true);

        $(".btn-raed").on("click",function(){
            var url="<?php echo Yii::app()->createUrl("xiaoxin/notice/sendlist?noticeType=$noticeType");?>";
            url=url+"&noticeType="+noticeType+"&keyword="+ $.trim($("input[name=keyword]").val())+"&timeType="+$("input[name=time]:checked").val();
            location.href=url;
        })
        //查看图片
        $('[rel=imgPreview]').click(function(){
            var imgUrl = $(this).data('img');
            var img ='<img style="max-height:600px;"  src="'+imgUrl+'">';
            $("#imgPBox").empty();
            $("#imgPBox").append(img);
            showPromptsImg('#imgPreview');
        });
        //查看发送人
        $('[rel=hoverName]').hover(function(){
            $(this).parent().find('.nameBox').show();
            $(this).parent('.infoDetail').css('position','relative');
        },function(){
            $(this).parent().find('.nameBox').hide();
            $(this).parent('.infoDetail').css('position','static');
        });
        $('[rel=checkSearch]').click(function(){
            $(this).parent('li').find('input[type=radio]').click();
            $(this).parent('li').siblings().find('span').removeClass('check');
            $(this).parent('li').find('span').addClass('check');
        });
        var isLink="<?php echo $link;?>";

        if(isLink=='1'||isLink==0){
            $(".menuList li a").removeClass("focus");
            if(noticeType==2){
                $("#menuListBoxs li a[href*='noticefamily']").addClass("focus");
            }else if(noticeType==7){
                $("#menuListBoxs li a[href*='noticeteacher']").addClass("focus");
            }else if(noticeType==1){
                $("#menuListBoxs li a[href*='homework']").addClass("focus");
            }else if(noticeType==3){
                $("#menuListBoxs li a[href*='conduct']").addClass("focus");
            }else if(noticeType==8){
                $("#menuListBoxs li a[href*='foodmenu']").addClass("focus");
            }else{
                $("#menuListBoxs li a[href*='noticerush']").addClass("focus");
            }
        }else{
            $(".menuList li a").removeClass("focus");
            $("a[href*='application']").addClass("focus");
        }
    });

</script>