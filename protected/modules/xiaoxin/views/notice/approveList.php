<!--待发送列表-->
<div class="header"> 
    <div class="titleText"><em class="inIco19"></em>日常工作 > 消息审核 </div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox backtrackColor">
            <div class="pheader"><em class="Pico"></em>功能说明</div>
            <div class="tableForm">
                <form id="formBoxRegister" action="" method="post">
                    <div class="stitle">查询内容</div>
                    <div class=" inputBox"><input style=" width: 100%;" name="keyword" value="<?php echo $keyword;?>" type="text" class="lg" placeholder="" /></div>
                    <div class="stitle">选择日期范围</div>
                    <div class="selectListBox">
                        <ul>
                            <li><a rel="checkSearch" avalue="0" href="javascript:void(0);">全部<span class="fright check">✔</span></a><input class="hide" name="time" value="0" type="radio"></li>
                            <li><a rel="checkSearch" avalue="1" href="javascript:void(0);">本周<span class="fright">✔</span></a><input class="hide" name="time" value="1" type="radio"></li>
                            <li><a rel="checkSearch" avalue="2" href="javascript:void(0);">上周<span class="fright">✔</span></a><input class="hide" name="time" value="2"  type="radio"></li>
                            <li><a rel="checkSearch" avalue="3" href="javascript:void(0);">本月<span class="fright">✔</span></a><input class="hide" name="time" value="3" type="radio"></li>
                            <li><a rel="checkSearch" avalue="4" href="javascript:void(0);">上月<span class="fright">✔</span></a><input class="hide" name="time" value="4" type="radio"></li>
                            <li><a rel="checkSearch" avalue="5" href="javascript:void(0);">本学期<span class="fright">✔</span></a><input class="hide" name="time" value="5" type="radio"></li>
                        </ul>
                    </div>
                    <div class="searchBtnBox">
                        <input type="button" class="btn btn-raed search_btn" value="开始查找" >
                        <!--<a class="btn btn-raed">开始查找</a>-->
                    </div>
                </form> 
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box">
            <div class="headBox">
                <div class="headNav">
                    <ul> 
                        <li><a class="<?php echo $status==0?'focus':'';?>"href="<?php echo Yii::app()->createUrl('xiaoxin/notice/approvelist?status=0');?>" >待审核</a></li>
                        <li><a class="<?php echo $status==1?'focus':'';?>" href="<?php echo Yii::app()->createUrl('xiaoxin/notice/approvelist?status=1,2');?>" >已审核</a></li>
                    </ul>
                </div>  
            </div>
            <!--<div class="listTopTite bBottom"><?php echo $status==0?'待':'已';?>审核列表</div>-->
            <div class="box noticeListBox">
                <?php if(empty($data)){?>
                    <div class="noContent">
                        <span><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                        <p>空空如也，没有任何消息</p>
                    </div>
                <?php }else{?>
                <ul>
                    <?php foreach($data as $val):?>
                    <li>
                        <em class="<?php echo $val['showclass'];?>"></em>
                        <div class="txtBox" style="margin-left: 60px;">
                            <div class="noticeTitle"><?php echo $val['typedesc'];?>
                                <?php if(intval($status)==0):?>
                                <a rel="approve" data-aid="<?php echo $val['id'];?>" href="<?php echo Yii::app()->createUrl('xiaoxin/notice/approvedetail?id='.$val['id']);?>" style="padding: 4px 10px;" class="fright btn btn-default">审核</a>
                                <?php endif;?>
                            </div> 
                            <div class="infoDetail" style=" position: relative;">发给： 
                                <a class="hoverName" rel="hoverName" href="javascript:void(0);" title=""><?php echo $val['schoolname'];?>&nbsp;
                                    <?php echo $val['receivename'];?>&nbsp; </a> 
                                <div class="nameBox" style=" ">
                                    <?php echo $val['schoolname'];?>&nbsp; <?php echo $val['receivename'];?>
                                </div>  
                                <span class="timeIco">&nbsp;</span><?php echo $val['creationtime'];?>
                            </div>
                            <p class="noticeInfo"> <?php echo $val['content'];?> </p>
                            <div class="commentImgBox">
                                <?php if(is_array($val['images'])&&!empty($val['images'])):?>
                                    <?php foreach($val['images'] as $img):?>
                                        <a href="javascript:;" rel="imgPreview" data-img="<?php echo $img;?>" style="width:160px;height:110px;overflow:hidden;display: inline-block;text-align:center;border:1px solid #d9d9d9;margin-right:10px;">
                                            <img style="max-width:160px;"  src="<?php echo $img.'?imageView2/3/w/160/h/110';?>"/>
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
                        <div class="hintBox <?php echo $val['status']==2?'errorInfo':'';?>" style="<?php echo $status==0?'display: block;':'';?> ">
                                <?php
                                      if($status==0){
                                           echo $val['sendtime']>$val['creationtime']? ('本消息审核通过后，将于:'.$val['sendtime'].'发送'):'本消息审核通过后，将立即发送';
                                      }else{
                                          if($val['status']==1){
                                              echo '本消息于:'.$val['approvetime'].' 审核通过'.($val['sendtime']>$val['approvetime']?('; 于:'.$val['sendtime']." 发送"):'');
                                          }else if($val['status']==2){
                                              echo '本消息于:'.$val['approvetime'].' 审核不通过，<span class="textInfo">不通过原因：'.$val['reason'].'</span>';
                                         }
                                      }
                                ?>  
                            </div>
                    </li>
                    <?php endforeach;?> 
                </ul>
                <?php } ?>
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
<div id="remindBox" class="popupBox"> 
    <div class="remindInfo"> 
        <div class="centent">是否取消发送当前作业？</div>
    </div>
    <div class="popupBtn">
        <a id="cancelSendBnt" href="javascript:void(0);" class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskWeb('#remindBox')" class="btn btn-default">取 消</a>
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


        $(".selectListBox li a span").removeClass("check");
        $(".selectListBox li a[avalue="+timeType+"] span").addClass("check");
        $("input[name=time][value="+timeType+"]").attr("checked",true);

        $(".search_btn").on("click",function(){
            var url="<?php echo Yii::app()->createUrl("xiaoxin/notice/approvelist?status=$status");?>";
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
        },function(){
            $(this).parent().find('.nameBox').hide(); 
        });
        $('[rel=checkSearch]').click(function(){
            $(this).parent('li').find('input[type=radio]').click();
            $(this).parent('li').siblings().find('span').removeClass('check');
            $(this).parent('li').find('span').addClass('check');
        });
    });
   function ajaxPsotCancel(aid){
        var url="<?php echo Yii::app()->createUrl('xiaoxin/notice/cancelsend');?>"; 
        $.getJSON(url,{id:aid},function(data){  
            location.reload();
        }) 
   }
    //取消
    /*
    $('[rel=approve]').on('click',function(e){
        e.preventDefault(); 
        var aid=parseInt($(this).attr("data-aid")); 
        if(aid>0){
            var onk = 'ajaxPsotCancel('+aid+')';
            $('#cancelSendBnt').attr("onclick",onk); 
        }
        showPromptsRemind('#remindBox');
    });
     */
</script>