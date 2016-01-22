
<div class="content">
    <div class="title"><span class="icon icon4"></span>查看消息</div>
    <div class="content-center">
        <div class="form-horizontal publish tit-view">
            <h2>封面</h2>
            <div class="control-group">
                <label class="control-label" for="">标&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;题：</label>
                <div class="controls">
                    <div class="inline" id="title">
                        <?php echo $message->title; ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="">副&nbsp;标&nbsp;题：</label>
                <div class="controls">
                    <div class="inline" id="tit-sub">
                        <?php echo $message->subhead; ?>
                       <!--  <input type="text" id="" name="subhead" value="<?php echo $message->subhead; ?>" class="input-xlarge" maxlength="20" datatype="*" nullmsg="副标题不能为空" > -->
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="">封&nbsp;面&nbsp;图：</label>
                <div class="controls ">
                    <div class="author-wrapper upload-tx">
                        <div class="author clearfix"  id="container">
                            <div class="author-img">
                                <img  id="uploadImg" src="<?php if(isset($message->cover) && $message->cover != '') echo $message->cover."?imageView2/3/w/558|imageMogr2/crop/x310"; ?>" alt="" ><i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                            </div>
                          <!--   <input type="hidden" id="domain" value="<?php echo STORAGE_QINNIU_XIAOXIN_XX; ?>">
                            <input type="hidden" id="uptoken_url"  value="<?php echo Yii::app()->createUrl('ajax/officialtoken').'?type=tx';?>">

                            <input type="hidden" name="cover" id="file_upload_tmp" value="<?php
                                if(isset($message->cover) && $message->cover != '')
                                    echo $message->cover;
                                ?>" data-val='1'>
                            <input type="hidden" name="msgid" value="<?php echo $message->msgid;?>"> -->
                        </div>
                    </div>
                </div>
            </div>
            <h2>内容</h2>
              <div class="control-group">
                <label class="control-label" for="">来&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;源：</label>
                <div class="controls">
                    <div class="inline">
                        <?php echo $message->msgfrom; ?>
                   </div>
                   <span class="help-inline"></span>
                </div>
              </div>
            <div class="control-group" >
                <label class="control-label" for="">正&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;文：</label>
                <div id="msg-content" class="controls" style="overflow:hidden;">
                    <?php if(isset($message->con->content)) echo $message->con->content; ?>
                </div>
            </div>

            <div class="control-group">
                <div class="double-btn" id="double-btn">
                    <a href="javascript:;" class="btn btn-radius " data-action="banner">封面预览</a>
                    <a href="javascript:;" class="btn btn-radius " data-action="content">正文预览</a>
                    <span class="Validform_checktip Validform_wrong" id="mce-tip" style="display:none;"></span>
                    <input type="hidden" id="send-publish-flag" name="publish" value="<?php echo true == $message->getPushlishStatus()?>"/>
                </div>
            </div>
          </div>
    </div>
</div>
<!--ViewBox begin-->
<div id="imgViewBox" class="modal hide fade imgViewBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <a href="javascript:;" class="closeBox" data-dismiss="modal" aria-hidden="true"><img  src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/close.png" alt="" ></a>
  <div class="modal-body">
          <div class="imgView">
              <img  src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/phone-banner.png" alt="" >
              <div class="imgView-c">
                <div class="tit copy-tit">标题标题标题标题标题标题标题标题标题</div>
                <div class="time-name"><span class="time"><?php echo date("Y-m-d H:i", time()); ?></span></div>
                <div class="banner">
                     <img  src="" alt="" id="viewBanner">
                     <i style="display:inline-block;height:100%; vertical-align:middle"></i>
                </div>
                <div id="imgView-c" class="imgView-div"></div>
              </div>
          </div>
  </div>
</div>
<div id="contentViewBox" class="modal hide fade imgViewBox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
  <a href="javascript:;" class="closeBox" data-dismiss="modal" aria-hidden="true"><img  src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/close.png" alt="" ></a>
  <div class="modal-body">
          <div class="contentView">
              <img  src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/content-view.png" alt="" >
             <div class="top-tit copy-tit">
                     这里是标题
            </div>
            <div class="contentView-c">
                <div class="tit copy-tit">这里是标题</div>
                <div class="time-name"><span class="time"><?php echo date("Y-m-d"); ?></span> <span class="name"><?php if(isset($message->msgfrom) && $message->msgfrom !=''): echo $message->msgfrom; else: echo Yii::app()->getModule('official')->user->getInfo('openname'); endif;?></span></div>
                <div class="contentView-text" id="content-view"></div>
            </div>

          </div>
  </div>
</div>
<!--ViewBox end-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/intValidform.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/bootstrap-transition.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/modal.js" type="text/javascript"></script>
<script type="text/javascript">

    //预览
   var view=function(){
       var btnP=$('#double-btn');
       btnP.on('click', 'a', function(event) {
           var _left=$(this),
               action=_left.data('action');
           var getContent=$("#msg-content").html();
           var url='<?php echo Yii::app()->request->baseUrl; ?>/index.php/official/publish/Imgjson';
           if (action == 'banner') {
                var src=$('#uploadImg').attr('src');
               $('#viewBanner').attr({src: src});
               $('.copy-tit').text($('#title').text());
               var titSub=$('#tit-sub').text();
               $('#imgView-c').html(titSub);
               $('#imgViewBox').modal('show');
           }else if (action == 'content') {
               $('.copy-tit').text($('#title').text());
               $.ajax({
                   url: url,
                   type: 'POST',
                   dataType: 'JSON',
                   data: {content:getContent}
               }).done(function(data) {
                   if (data) {
                       var _html='';
                       $.each(data.item, function(index, val) {
                            if (val.type=='text') {
                                       _html+='<p>'+val.content+'</p>';
                                   }else if (val.type=='image') {
                                      var h=(231*val.height)/val.width;
                                      if (h < 50) {
                                          _html+='<div class="div-center"><img  src="'+val.content+'" alt="" ><i style="display:inline-block;height:100%; vertical-align:middle;"></i></div>';
                                      }else if ( h / 231 >= 6) {
                                          _html+='<p class="center"><img  src="'+val.content+'?imageMogr2/crop/'+val.width+'x'+(val.width*1.6)+'" alt="" ></p>';
                                      }else if ( h / 231 <= 6) {
                                          _html+='<p class="center"><img  src="'+val.content+'?imageView2/2/w/290" alt="" ></p>';
                                      }
                                   }
                       });
                       $('#content-view').html(_html);
                       $('#contentViewBox').modal('show');
                   }else{
                       $('#content-view').html('');
                       $('#contentViewBox').modal('show');
                   }
               })
           }
       });
   }

    
    $(function() {
        view();
    });

</script>
