<!--我的应用 -->
<div class="header">
<!--    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/group/index');?>" class="focus">分组列表</a></li> 
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/group/create');?>">创建列表</a></li>
            </ul>
        </div>  
    </div>-->
<div class="titleText"><em class="inIco16"></em>日常工作</div>  
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
                <div class="coord">点亮徽标，可以将功能添加到左侧快捷功能列表中，方便您的使用。</div>
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox"> 
        <div class="box" style="padding-top: 10px;"> 
            <div class="listTopTite bBottom">功能列表</div>
            <div class="applicationList">
                <ul>
                    <?php if(!empty($data)):?>
                    <?php foreach($data as $val):?>
                    <li class=" "> 
                        <div class="applicationItme">
                            <div class="stampBtn "> 
                                <em rel="stampBtn" appid="<?php echo $val['appid'];?>" tip="<?php echo (int)$val['have'];?>" class="fright <?php echo (intval($val['have'])==0?'stamp':'');?>" title="<?php echo (intval($val['have'])==0?'设为快捷':'取消快捷');?>"></em>
                            </div>
                            <div style=" margin-right: 20px;">
                                <a href="<?php echo Yii::app()->createUrl($val['url']);?>">
                                    <span class="fleft" style=" margin-right: 15px;"><img width="40px" width="50px" src="<?php echo Yii::app()->request->hostinfo.$val['icon']; ?>"/></span>
                                    <span class="info applicationTitle"> <?php echo $val['name'];?> </span> 
                                    <span class="info applicationInfo"><?php echo $val['desc'];?></span>  
                                </a> 
                            </div>
                        </div>
                    </li>
                    <?php endforeach;?>
                    <?php ;else:?>
                        <li style="float: none; width: auto; height: auto;">
                            <div class="noContent" style="background: #FFF; padding-bottom: 20px;"> 
                                <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                <p>空空如也，没有任何数据</p>
                            </div>
                        </li>
                    <?php endif;?>
                </ul>
            </div> 
        </div> 
    </div>
</div>
<div id="remindBox" class="popupBox"> 
    <div class="remindInfo"> 
        <div id="remindText" class="centent">温馨提示：左侧栏最多只能设置10个功能为快捷！</div>
    </div>
    <div class="popupBtn">
        <a id="deleLink"  href="javascript:void(0);" onclick="hidePormptMaskWeb('#remindBox')"  class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskWeb('#remindBox')" class="btn btn-default">取 消</a>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        //标记快捷
        var url="<?php echo Yii::app()->createUrl('xiaoxin/application/add');?>";
        $('[rel=stampBtn ]').on("click",function(){
            var len =$("#menuListBoxs").find('li:visible').length;
            var type = $(this).attr('tip'); 
            if(parseInt(len)<10||parseInt(type)==1){  
                var appid = parseInt($(this).attr('appid'));
                var state=0;
                if(parseInt(type)==0){
                    $(this).removeClass('stamp');
                    $(this).attr('title','取消快捷');
                    $(this).attr('tip',1);
                    state=1; //设为快捷
                }else{
                    $(this).attr('tip',0);
                    $(this).addClass('stamp');
                    $(this).attr('title','设为快捷');
                    state=0;//取消快捷
                }
                $.getJSON(url,{appid:appid,state:state},function(data){
                    if(data&&data.status==='1'){
                        //成功 
                        if(state==1){
                           $("#menuItme_"+appid).show(); 
                        }else{
                           $("#menuItme_"+appid).hide(); 
                        } 
                    }else{
                        //失败
                    }

                });
             }else{
                 showPromptsRemind('#remindBox');
             }
        });
        //加背景
        $('.applicationList li').hover(function(){
            $(this).addClass('application');
        },function(){
           $(this).removeClass('application');
        });
    });
</script>
