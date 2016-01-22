<div class="header"> 
    <div class="titleText"><em class="inIco"></em>首页</div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox backtrackColor">
            <div class="pheader"><em></em>系统通知</div>
            <div class="systemInfo">
                <?php if(is_array($systemNotice)):?>
                <?php foreach($systemNotice as $val):?>
                <p>〓 <?php echo $val['content'];?></p>
                <?php endforeach;?>
                <?php endif;?>
                <!--<p>〓 向您通报一则重要讯息,昨天下午,二实小门口出现人贩,他先故意撞倒学生,然后称要将.</p>
                <p>〓 已有最新版本的App下载，请大家更新升级。</p>
                <p>〓 其带往医院,幸好老师及时发现！我们已在班级进行安全教育,也请您再次跟孩子说明,千万不要和陌生人走.</p>
                -->
            </div>
        </div>
        <div class="paneBox backtrackColor">
            <div class="pheader">资源下载</div>
            <div class="systemInfo">
                <p>蜻蜓告诉你：如果在本地电脑听不到语音信息，建议点击下载音频播放器。</p>
                <div class="fleft"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/mkpayle.png"></div>
                <div class="kmplayeInfo" style=" margin-left: 85px;">
                    <p class="title">kmplaye音频播放器</p>
                    <p class="info">版本：3.9.1.130</p>
                    <p class="info">大小：34.2M</p>
                    <p class="info">环境：WinXp/Win2003/Vista/Win7</p>
                </div>
                <div style=" text-align: center; margin-top: 10px;">
                    <a class="btn btn-raed" href="<?php echo Yii::app()->request->baseUrl; ?>/template/KMPlayer2013.exe">下载安装</a>
                </div>
            </div>
        </div> 
<!--        <div class="paneBox">
            <div class="pheader">今日日志</div>
        </div>-->
    </div>
    <div id="contentBox" class="contentBox" style="border: none; background: none;">
        <div class="box indexBox">
            <div class="indexHeader">今日<span class="detime">（<?php echo date("Y").'年'. date('m');?>月<?php echo date('d');?>日）</span>
                <?php if($isApproveRight&&$data['unApproveNum']):?>
                <a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/approvelist?status=0');?>">待审核：(<i><?php echo $data['unApproveNum'];?></i>)</a>
                <?php endif;?>
                <?php if($data['unReadNum']):?>
                <a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter?noticeType=');?>">未读消息：(<i><?php echo $data['unReadNum'];?></i>)</a>
                <?php endif;?>

            </div>
        </div>
        <div class="box indexBox" style="padding: 0 15px;">
            <div class="listTopTite bBottom">最新消息</div>
            <div class="box" style="padding: 0 15px 15px 15px;">
                <ul class="indexNoticeList"> 
                    <?php if(empty($newsNotice)):?>
                        <li>
                            <div class="noContent">
                                <span><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                <p>空空如也，没有任何消息</p>
                            </div>
                        </li>
                    <?php else:?> 
                    <?php foreach($newsNotice as $val):?>
                    <li>
                        <em class="<?php echo $val['showclass'];?>"></em>
                        <div  class="infoBox txtBox">
                            <div class="noticeType" ><?php echo $val['typedesc'];?> &nbsp;&nbsp;<span>来自：<?php echo $val['schoolname'];?>&nbsp; 
                                <?php echo $val['uname'];?></span>&nbsp; <span><?php echo $val['receivername'];?></span>&nbsp; <span class="timeIco"><?php echo $val['showtime'];?></span></div>
                            <p>
                                <a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/detail?id='.$val['msgid']);?>">
                                   <?php  echo $val['content'];?>
                                </a>
                            </p>
                            <div class="commentImgBox">
                                <?php foreach($val['images'] as $img):?> 
                                    <a href="javascript:;" rel="imgPreview" data-img="<?php echo $img;?>" style="width:160px;height:110px;overflow:hidden;display: inline-block;text-align:center;border:1px solid #d9d9d9;margin-right:10px;">
                                        <img style="max-width:160px;"  src="<?php echo $img.'?imageView2/3/w/160/h/110';?>"/>
                                         <i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                                    </a> 
                                <?php endforeach;?>
                            </div>
                            <div class="commentAudioBox">
                                <?php if(isset($val['medias']['url'])&&!empty($val['medias']['url'])):?>
                                    <a href="<?php echo $val['medias']['url'];?>" title="<?php echo $val['medias']['name'];?>">语音下载</a>
                                <?php endif;?>
                            </div>
                        </div>
                    </li>
                    <?php endforeach;?> 
                    <?php endif;?> 
                </ul>
            </div>
        </div>
        <div class="box indexBox" style="padding: 0 20px;">
            <div class="listTopTite bBottom">&nbsp;&nbsp;最新评论</div> 
            <div class="commentsList" style="margin-top: 0;">
                <ul class="indexList" style="margin-bottom: 40px;">
                    <?php if(empty($newsReply)):?> 
                        <li>
                            <div class="noContent">
                                <span><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                <p>空空如也，没有任何消息</p>
                            </div>
                        </li>
                    <?php else:?> 
                        <?php foreach($newsReply as $val):?>
                            <li>
                                <div class=" fleft">
                                    <img width="40px;" height="40px" src="<?php echo $val['photo']; ?>" />
                                </div>
                                <div class="commentTBox">
                                    <div class="commentTxt"><span class="<?php echo ($val['username']?'name':'');?>"><?php echo $val['username']?$val['username']:'匿名人';?></span>在&nbsp;&nbsp;<span><?php echo $val['showtime'];?></span> &nbsp;&nbsp;回复了 &nbsp;&nbsp;<span class="name"><?php echo $val['typedesc'];?></span> </div>
                                    <p class="commentTime commentTxt"><a href="
                                    <?php echo Yii::app()->createUrl('xiaoxin/notice/senddetail?id='.$val['noticeid']);?> ">
                                            <?php echo $val['content'];?></a></p>
                                </div>
                            </li>
                        <?php endforeach;?> 
                    <?php endif;?> 
                </ul>
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
        $('[rel=imgPreview]').click(function(){
            var imgUrl = $(this).data('img');
            var img ='<img style="max-height:600px;"  src="'+imgUrl+'">';
            $("#imgPBox").empty();
            $("#imgPBox").append(img);
            showPromptsImg('#imgPreview');
        });
    });
     
</script>