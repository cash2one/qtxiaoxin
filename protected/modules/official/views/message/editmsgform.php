<style>
    #elm1_toolbar1,#elm1_toolbar3,#elm1_toolbar3,#elm1_bullist,#elm1_numlist,#elm1_outdent,#elm1_indent,
    .defaultSkin .mceSeparator,#elm1_anchor,#elm1_cleanup,#elm1_help,#elm1_code,#elm1_link,#elm1_unlink,#tit-sub_parent{
        display:none!important;
    }
    #elm1_tbl{
        height:279px!important;
    }
</style>
<div class="content">
    <div class="title"><span class="icon icon3"></span>编辑消息</div>
    <div class="content-center">

        <form class="form-horizontal publish" action="<?php echo Yii::app()->createUrl('/official/publish/savemsg'); ?>" method="post" id="form-sub">
            <h2>封面</h2>
            <div class="control-group">
                <label class="control-label" for="">标&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;题：</label>
                <div class="controls">
                    <div class="inline">
                        <input type="text" id="title" name="title" value="<?php echo $message->title; ?>" class="input-xxlarge" maxlength="50"  datatype="*" nullmsg="标题不能为空" >
                    </div>
                    <span class="help-inline">限制50个字符以内</span>
                    <span class="ValidformTip Validform_checktip" ></span>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="">副&nbsp;标&nbsp;题：</label>
                <div class="controls">
                    <div class="inline">
                          <textarea rows="4" id="tit-sub" name="subhead" class="input-xxlarge"  style="display:inline-block!important" placeholder="" maxlength="150" datatype="*" nullmsg="副标题不能为空"><?php echo $message->subhead; ?></textarea>
                       <!--  <input type="text" id="" name="subhead" value="<?php echo $message->subhead; ?>" class="input-xlarge" maxlength="20" datatype="*" nullmsg="副标题不能为空" > -->
                    </div>
                    <span class="help-inline">限制150个字符以内</span>
                    <span class="ValidformTip Validform_checktip"></span>
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
                            <!--qiniu控件配置，此处和编辑器上传共享配置-->
                            <input type="hidden" id="domain" value="<?php echo STORAGE_QINNIU_XIAOXIN_XX; ?>">
                            <input type="hidden" id="uptoken_url"  value="<?php echo Yii::app()->createUrl('ajax/officialtoken').'?type=xx';?>">
                            <ul class="author-msg">
                                <li class="name">你可以选择一张png/jpg图片（900*500）作为封面图（图片大小限制2M以内）</li>
                                <li class="edit-img"  ><span id="pickfiles">更换图片</span></li>
                            </ul>
                            <input type="hidden" name="cover" id="file_upload_tmp" value="<?php
                                if(isset($message->cover) && $message->cover != '')
                                    echo $message->cover;
                                ?>" data-val='1'>
                            <input type="hidden" name="msgid" value="<?php echo $message->msgid;?>">
                        </div>
                    </div>
                </div>
            </div>
            <h2>内容</h2>
              <div class="control-group">
                <label class="control-label" for="">来&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;源：</label>
                <div class="controls">
                    <div class="inline">
                         <input type="text" class="input-xlarge" maxlength="20" id="msgfrom" name="msgfrom" value="<?php echo $message->msgfrom; ?>">
                   </div>
                   <span class="help-inline"></span>
                </div>
              </div>
            <div class="control-group">
                <textarea id="elm1" name="content" value="" rows="15"  style="width:80%;height:320px;" placeholder="这里是复文框"></textarea>
                <div style="margin-top:10px;">注：你可以选择一张png/jpg图片（900*500）作为详情图（图片大小限制2M以内）</div>
            </div>
            <?php if($message->send != 2 && $message->sendtime == '2001-01-01 00:00:00'): ?>
            <div class="control-group">
                <input type="checkbox" name="timer" <?php if(isset($message->sendtime) && $message->sendtime !='2001-01-01 00:00:00'): ?> checked <?php endif; ?> style="vertical-align:middle;margin-right:10px;">
                <div class="input-append date form_datetime" id="datepicker_send">
                    <input size="16" type="text" name="sendtime" value="<?php if(isset($message->sendtime) && $message->sendtime !='2001-01-01 00:00:00') echo substr($message->sendtime, 0, 16); ?>" class="input-small" placeholder="请选择发送时间" readonly="readonly" >
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
                <span class="">定时发布时间设置仅在点击发布时生效</span>
                <?php if($message->send == 1): ?><div class="red datepicker-tip">今日还能发布<?php echo $sendFreq->getTodayMsgCount();?>次</div><?php endif; ?>
            </div>
            <?php endif; ?>
            <div class="control-group">
                <div class="double-btn" id="double-btn">
                    <a href="javascript:;" class="btn btn-radius " id="sub-btn">保&nbsp;&nbsp;存</a>
                    <?php if($message->send == 1 && $message->sendtime == '2001-01-01 00:00:00'): ?><a href="javascript:;" class="btn btn-radius btn-pale-green " <?php if( false == $sendFreq->getTodayMsgCount() ):?><?php endif;?> id="send-btn">发&nbsp;&nbsp;布</a><?php endif; ?>
                    <a href="javascript:;" class="btn btn-radius " data-action="banner">封面预览</a>
                    <a href="javascript:;" class="btn btn-radius " data-action="content">正文预览</a>
                    <span class="Validform_checktip Validform_wrong" id="mce-tip" style="display:none;"></span>
                    <input type="hidden" id="send-publish-flag" name="publish" value="<?php echo true == $message->getPushlishStatus()?>"/>
                </div>
            </div>
        </form>
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
                     <img  src="" alt="" id="viewBanner"><i style="display:inline-block;height:100%; vertical-align:middle"></i>
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
                <div class="time-name"><span class="time"><?php echo date("Y-m-d"); ?></span><span class="name" id="msgfrom-txt"><?php if(isset($message->msgfrom) && $message->msgfrom !=''): echo $message->msgfrom; else: echo Yii::app()->getModule('official')->user->getInfo('openname'); endif;?></span></div>
                <div class="contentView-text" id="content-view"></div>
            </div>

          </div>
  </div>
</div>
<div>
</div>
<!--ViewBox end-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/official/Validform/validform.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/official/bootstrap-datepicker/css/bootstrap-datetimepicker.min.css">
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/bootstrap-datepicker/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/bootstrap-datepicker/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/plupload/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/qiniu.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/main.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/intValidform.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/bootstrap-transition.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/modal.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/editBox.js"></script>
<script type="text/javascript">

    //预览
   var view=function(){
       var btnP=$('#double-btn');
       btnP.on('click', 'a', function(event) {
           var _left=$(this),
               action=_left.data('action');
           var getContent=tinyMCE.get('elm1').getContent({format: 'raw'});
           var url='<?php echo Yii::app()->request->baseUrl; ?>/index.php/official/publish/Imgjson';
           if (action == 'banner') {
                var src=$('#uploadImg').attr('src');
               $('#viewBanner').attr({src: src});
               if ($('#title').val() == '') {
                   $('.copy-tit').text('标题');
               }else{
                   $('.copy-tit').text($('#title').val());
               }
               var titSub=$('#tit-sub').val();
               $('#imgView-c').html(titSub);
               $('#imgViewBox').modal('show');
                          
           }else if (action == 'content') {
               if ($('#title').val() == '') {
                   $('.copy-tit').text('标题');
               }else{
                   $('.copy-tit').text($('#title').val());
               }
               $('.top-tit').text('<?php echo $openname = Yii::app()->getModule('official')->user->getInfo('openname'); ?>');
               if ($('#msgfrom').val() != '') {
                   $('#msgfrom-txt').text($('#msgfrom').val());
               } else {
                   $('#msgfrom-txt').text("<?php echo $openname; ?>");
               }
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
                                      }else if ( h / 231 > 6) {
                                          _html+='<p class="center"><img  src="'+val.content+'?imageMogr2/crop/'+val.width+'x'+(val.width*1.6)+'" alt="" ></p>';
                                      }else if ( h / 231 <= 6) {
                                          _html+='<p class="center"><img  src="'+val.content+'?imageView2/2/w/290" alt="" ></p>';
                                      }
                                      else{
                                          _html+='<p class="center"><img  src="'+val.content+'" width="290px" alt="" ></p>';
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
    //时间控制器
    var timeSend=function(){
        var config = {
            language:'zh',
            format: 'yyyy-mm-dd hh:ii',
            autoclose:true,
            language:'zh-CN',
            minView:0,
            todayBtn: true,
            pickerPosition: "top-left",
            viewSelect: 'month',
            startDate:'<?php echo date("Y-m-d H:i", time()); ?>'
        }
        <?php if($message->send != 2 && $message->sendtime == '2001-01-01 00:00:00'): ?>
        var startPicker = $('#datepicker_send').datetimepicker(config);
        <?php endif; ?>
        // startPicker.on('changeDate',function(ev){
        // 	endPicker.datetimepicker('setStartDate',$(ev.target).find('input').val());
        // });
    }

    var submitConfirm=function(){
       var getContent = tinyMCE.get('elm1').getContent({format: 'raw'});
        var val=$('#file_upload_tmp').attr('data-val');
        if (val != '0') {
          if ($.trim(getContent)!='') {
              if ($.trim(getContent)!='<p><br data-mce-bogus="1"></p>') {
                  $('#form-sub').submit();
              }else{
                $('#mce-tip').text('内容不能为空').show();
              }
          }else{

              $('#mce-tip').text('内容不能为空').show();
          }
        }else{

          $('#mce-tip').text('请选择封面图').show();
        }
    }
    
    $(function() {
        var editMceT='<?php if(isset($message->con->content)) echo $message->con->content; ?>';
        view();
        timeSend();
        tinyMceFun('edit',editMceT);//复文本框
        updataLoadImg();//上传图片
        Validform.int("#form-sub");//表单验证控件
        $('#sub-btn').click(function(){
            submitConfirm();
        });

        var sendNum='<?php echo $sendFreq->getTodayMsgCount(); ?>';
        if (sendNum == '0') {
            $('#send-btn').css({
                'text-decoration': 'line-through'
            });

        };
        $('#send-btn').click(function(){

            var val=$('#file_upload_tmp').attr('data-val');
            if (sendNum != '0') {
                if (val != '0') {
                    $('#send-publish-flag').val('1');
                    submitConfirm();
                }else{
                    $('#mce-tip').text('请选择封面图').show();
                }

            }else{
                $('#mce-tip').text('您今日发布的次数已发完').show();
            }
        })
    });

</script>
