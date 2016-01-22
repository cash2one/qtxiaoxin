<!--创建消息,通知 -->
<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/sendlist?noticeType='.$noticeType);?>" >发送记录</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/unsendlist?noticeType='.$noticeType);?>" >待发列表</a></li>
                <?php if($noticeType==1):?>
                    <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/homework');?>" class="focus">发布作业</a></li>
                <?php else:?>
                    <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticefamily');?>" class="focus">通知家长</a></li>
                <?php endif;?>
            </ul>
        </div>  
    </div>
    <div class="titleText"><em class="<?php echo $noticeType==1? 'inIco1':'inIco2';?>"></em>日常工作 > <?php echo $noticeType==1?'布置作业':'通知家长';?></div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show" >
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox" style="background: #FFFFFF;">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
                可以针对班级、分组、学生（个人）发布<?php echo $noticeType==1?"作业信息":"学校通知";?>。
            </div>
            <!--<div class="pheader"><em class="Pico"></em>选择分组</div>-->
            <div class="groupBox" style=" display: none;">
                <?php if(is_array($schoolList)) {foreach($schoolList as $val):?>
                <div class="titleName" sid="<?php echo $val['sid'];?>"><em class="group"></em><?php echo $val['name'];?></div>
                <ul id="school_<?php echo $val['sid'];?>">
                    <li><a rel="addAllClass" class="schoolT_<?php echo $val['sid'];?>" tid="0" data-sid="<?php echo $val['sid'];?>" data-cid="" href="javascript:void(0);"><span class="fright ">✔</span>全部 </a></li> 
                    <?php if(is_array($val['class'])):?>
                       <?php foreach($val['class'] as $v):?>
                                <li><a rel="addClass" class="schoolT_<?php echo $val['sid'];?>" id="addClass_<?php echo $v['gid'];?>" tid="0" data-tpyid="2" data-cname="<?php echo $v['name'];?>" data-sid="<?php echo $val['sid'];?>" data-cid="<?php echo $v['gid'];?>" href="javascript:void(0);"><span class="fright ">✔</span><?php echo $v['name'];?></a></li>
                        <?php endforeach;?>
                    <?php endif;?> 
                </ul>
                <?php endforeach;}?>
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box">
            <div class="headBox ">
                <div class="headNav noticeType_select">
                    <ul>
                        <?php if($noticeType==1):?>
                            <li><a avalue="1" href="<?php echo Yii::app()->createUrl("xiaoxin/notice/homework?noticeType=$noticeType");?> " >班级</a></li>
                            <li><a avalue="2" href="<?php echo Yii::app()->createUrl("xiaoxin/notice/homework?receiveType=1&noticeType=$noticeType");?> " class="focus" >分组</a></li>
                            <li><a avalue="0" href="<?php echo Yii::app()->createUrl("xiaoxin/notice/homework?receiveType=2&noticeType=$noticeType");?>" >学生</a></li>
                        <?php else:?>
                            <li><a avalue="1" href="<?php echo Yii::app()->createUrl("xiaoxin/notice/noticefamily?noticeType=$noticeType");?>" >班级</a></li>
                            <li><a avalue="2" href="<?php echo Yii::app()->createUrl("xiaoxin/notice/noticefamily?receiveType=1&noticeType=$noticeType");?> " class="focus" >分组</a></li>
                            <li><a avalue="0" href="<?php echo Yii::app()->createUrl("xiaoxin/notice/noticefamily?receiveType=2&noticeType=$noticeType");?>" >学生</a></li>
                        <?php endif;?>
                    </ul>
                </div>  
            </div>
            <div class="formBox">
               <form id="formBoxRegister" action="<?php echo Yii::app()->createUrl('xiaoxin/notice/publish');?>" method="post">
                   <table class="tableForm">
                        <tr>
                             <td>
                                 <div class="infoTitle" >〓 接收对象<a class="clear" href="javascript:;" rel="clearCheck">清空</a></div>
                             </td>
                        </tr>
                       <tr>
                            <td>
                                <div class="memberBox">
                                    <ul id="memberList">
                                       <li class="memberBtn"><a rel="addUserBtn" href="javascript:void(0);" ><em class="addBtnIco"></em> 添加分组</a></li>
                                    </ul>
                                </div>
                                <div id="cuntUserCheck" class="cuntMember" >已选择了<span class="red">0</span>个分组<span id="cuntTip" style="display: none;" class="Validform_checktip Validform_wrong">至少添加一个分组</span></div>
                                <span class="Validform_checktip" ></span>
                                <div id="cacheBox" style="display: none;"> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="infoTitle" >〓 输入内容</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-bottom: 10px;">家长称谓：
                                    <select name="receivertitle" id="receiverTit">
                                        <option  value="xxx家长">xxx家长</option>
                                        <option  value="xxx">xxx</option> 
                                    </select>
                                </div>
                                <div>
                                    <!--<div id="" class="textFixed" style="width:100%; height: 120px; border:1px solid #E1E1E1; padding: 3px 8px 5px; *padding: 0; outline: none;" contenteditable="true" contentEditable="true" placeholder="请在这里填写发送内容"></div>-->
                                    <textarea id="textareaCont"  name="body" class="textFixed" onKeyDown="gbcount(this.form.textareaCont,this.form.totals,this.form.useds,this.form.remains);" onKeyUp="gbcount(this.form.textareaCont,this.form.totals,this.form.useds,this.form.remains);" style="width:100%; padding: 3px 8px 5px; *padding: 0; height: 120px; border:1px solid #E1E1E1; outline: none;" placeholder="请在这里填写发送内容"></textarea>
                                    <input id="textareaContVal" type="hidden" name="content"  value=""/>
                                </div>
                                <div style="margin-top: 10px;" id="container"> 
                                    <div class="fright">
                                        老师签名：
                                        <select name="sendertitle" id="senderTit">
                                            <?php foreach($signArr as $val):?>
                                                <option value="<?php echo $val;?>"><?php echo $val;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="set-msg" style=" display: inline-block; margin-right: 40px; line-height: 20px;">
<!-- 
                                                  <input type="hidden" id="domain" value="<?php echo STORAGE_QINNIU_XIAOXIN_XX; ?>">
                                       <input type="hidden" id="uptoken_url"  value="<?php echo Yii::app()->createUrl('ajax/gettoken').'?type=xx';?>">
                                        <?php if($noticeType==2):?>
                                        <a href="javascript:void(0);" class="btn btn-default"  style="margin-right:10px;" id="pickfiles">添加图片</a>
                                        <span style="color:#999;margin-right:20px;">(仅支持4张PNG或JPG格式的图片)</span>
                                      <?php endif;?>
 -->

                                         <?php if($noticeType==1):?>
                                         <a href="javascript:void(0);" class="btn btn-default msgSend" style="margin-right:10px;">存为模板</a>
                                         <a href="javascript:void(0);" class="btn btn-default msgTmpBtn"  style="margin-right:10px;">模板库</a>

                                         <?php endif;?>
                                       <input type="hidden" maxLength="4" id="totals" size="3" value="500" class="inputtext" /> 
                                       <input type="hidden" maxLength="4" id="useds" size="3" value="0" class="inputtext" /> 
                                       您还可以输入<span id="remains_text" class="red">500</span>字
                                       <input readonly type="hidden" maxLength="4" id="remains" value="500" />
                                       <span id="textareaTip" class="Validform_checktip Validform_wrong main2" style="display:none;">内容不能为空！</span>
                                         <span id="msgTip" style="display:none;"> <span class="Validform_checktip Validform_right main2">保存成功</span> </span>
                                    </div> 
                                </div>
                               <!--  <div class="plupload" id="plupload">
                                        <ul class="clearfix">
                                         
                                        </ul>
                                        <div class="Validform_checktip Validform_wrong" style="margin:10px 0 0;clear:both;display:none;" id="plupload-tip"></div>
                                </div> -->
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="infoTitle" >〓 更多设置</div>
                                <div style="padding: 10px 0;">
                                     <label class="checkbox"><input name="isSendToMe" value="1" type="checkbox">给自己发送一条确认短信</label>
                                    <?php if($isshowsendsms):?>
                                    <p>
                                        <!--<label class="checkbox"><input name="isSendsms" value="1" type="checkbox"> 同步发送短信给未安装手机客户端的用户</label>-->
                                    </p>
                                    <?php endif;?>
                                </div>
                            </td>
                        </tr>
                         
                        <tr>
                            <td>
                                <input id="shoolId" type="hidden" value="1"/>
                                <input type="hidden" value="<?php echo $noticeType;?>" name="noticeType"/>
                                <input id="receiveName" type="hidden" value="" name="receivename"/> 
                                <input id="delayedTxVal" type="hidden" name="fixed_time" value="">  
                                <a id="submitForms" href="javascript:void(0);" class="btn btn-raed">发 送</a> 
                                &nbsp;&nbsp;
                                <a href="javascript:void(0);" rel="delayedTxBtn" id="delayBtn" class="btn btn-default" data-url="<?php echo Yii::app()->createUrl('xiaoxin/notice/gettime');?>">定时发送</a> 
                                <a href="javascript:void(0);" rel="previewMsg" class="btn btn-default" style="margin-left:10px;">预览短信</a>
                            </td>
                        </tr>
                   </table> 
               </form>
            </div>
        </div>
        
    </div>
</div>
<div id="delayedTx" class="">
    <div id="delayedTxBox" class="popupBox" style="width: 550px; height: 210px;">
        <div class="header">定时发送 <a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#delayedTxBox')" > </a></div>
        <div id="setTime" class="remindInfo setTime" style=" padding: 15px 20px 0 20px;"> 
        </div> 
        <div class="popupBtn">
            <a id="saveMemberBtn" href="javascript:void(0);"  class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#delayedTxBox')" class="btn btn-default">取 消</a>
        </div>
    </div>
</div>
<div id="previewMsg">
    <div id="previewMsgBox" class="popupBox" style="width: 318; height: 636px;background-color:none;background:url(<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/preview-msg.png) no-repeat center center;">
        <div class="header" style="background:none;border:none;"><a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#previewMsgBox')" > </a></div>
        <div  class="remindInfo setTime" style=" padding: 15px 20px;"> 
            <div class="previewContent">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/preview-top.jpg" alt="" class="preview-top">
                <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/preview-bottom.jpg" alt="" class="preview-bottom">
                <div class="previewContentMsg">
                    
                </div>
            </div>
        </div> 
   
    </div>
</div>

<div id="sensitiveWords">
    <div id="sensitiveWordsBox" class="popupBox" style="width: 550px;">
        <div class="header">提示<a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#sensitiveWordsBox')" > </a></div>
        <div class="remindInfo  setTime" > 
           发布文字涉及短信运营商敏感字库，可能导致短信发送失败，网络消息发送不受影响。
           <p class="red" id="sensitiveTip"></p>
        </div> 
        <div class="popupBtn" style="text-align: right;padding:0 20px;">
            <a id="sensitiveWordsBtn" href="javascript:void(0);"  class="btn btn-raed" data-val="">继续发送</a>&nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#sensitiveWordsBox')" class="btn btn-default">修改文字</a>
        </div>
    </div>
</div>

<div id="msgTmp" >
    
</div>
<div id="selectClassBox">
    <div id="selectClass" class="popupBox" style="width: 640px; height: 495px; *height: 515px;" >
        <div class="header" style="">添加分组<a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#selectClass')" ></a></div>
        <div id="selectContent" class="popupContent" style="padding: 20px;">
            <div class="selectBox">
                <select id="selectSchoolList" url="<?php echo Yii::app()->createUrl('xiaoxin/notice/selectclass');?>">
                    <option tip="0" value="">选择学校</option>
                    <?php if(is_array($schoolList)) {foreach($schoolList as $val):?>
                        <option tip="0" value="<?php echo $val['sid'];?>"><?php echo $val['name'];?></option>
                    <?php endforeach;};?> 
                </select>
                <?php if(is_array($schoolList)) { foreach($schoolList as $val):?>
                    <a rel="allCheck" id="clear_<?php echo $val['sid'];?>" class="clear" tip="0" href="javascript:;" style="display: none;">全部选中</a>
                <?php endforeach;};?>
            </div>
             <div id="memberBoxId" class="memberBox" style="height: 305px; margin-bottom: 15px;">
                  <?php if(is_array($schoolList)) { foreach($schoolList as $val):?>
                    <ul rel="removeListClass" id="popMember_<?php echo $val['sid'];?>" class="ulListBox"> 
                    </ul>
                 <?php endforeach;};?> 
            </div>
            <div class="popupBtn">
                <a id="saveMemberBtn" href="javascript:void(0);"  class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#selectClass')" class="btn btn-default">取 消</a>
            </div>
        </div>
    </div>
    <ul id="selectCacheClass">
    </ul>
</div>

<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/characterFilter.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/tmpLibrary.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/plupload/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/qiniu.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/qiniu/js/sendMsgUpload.js"></script>
<script type="text/javascript">
    $(function(){ 
         Validform.int('#formBoxRegister');

         //上传图片
        // updataLoadImg();
         //弹框
        $('[rel=addUserBtn]').click(function(){
            var box =$("#memberBoxId").find("li");
            box.each(function(k,v){
                var type = v.getAttribute('severtype');
                //var id  =
                 if(type=='1'){
                    $(this).removeClass('checked');
                    $(this).find('a').attr('tip','0'); 
                 }
                 if(type=='2'){ 
                     $(this).addClass('checked');
                     $(this).find('a').attr('tip','1'); 
                 }
                 v.setAttribute('severtype','0');
                 $("#memberBoxId").find("li.checked").find('a').attr('tip','1');
            });
            var sid = $('#selectSchoolList').find('option:selected').val();
            var boxsrs = $('#popMember_'+sid);
            if(boxsrs.find('li').length==boxsrs.find('li.checked').length&&boxsrs.find('li.checked').length!=0){
                $('#clear_'+sid).attr('tip','1').text('全部取消');
            }else{
                $('#clear_'+sid).attr('tip','0').text('全部选中'); 
            }
            showPromptPush('#selectClass');
        });
        //选择学校
        $('#selectSchoolList').change(function(){ 
            var _this = $(this).find('option:selected'),
            sid = _this.val(),
            urls = $(this).attr('url'),
            tip =_this.attr('tip');
            $(".ulListBox").hide();
            $('#popMember_'+sid).show();
            if(tip=='0'){
                if(sid){ 
                    ajaxClass(urls,sid); 
                } 
            }
            $('[rel=allCheck]').hide();
            $('#clear_'+sid).show();
            _this.attr('tip','1');
            var box =$("#memberBoxId").find("li");
            box.each(function(k,v){
                var type = v.getAttribute('severtype');
                //var id  =
                 if(type=='1'){
                    $(this).removeClass('checked');
                    $(this).find('a').attr('tip','0'); 
                 }
                 if(type=='2'){ 
                     $(this).addClass('checked');
                     $(this).find('a').attr('tip','1'); 
                 }
                 v.setAttribute('severtype','0');
                 $("#memberBoxId").find("li.checked").find('a').attr('tip','1');
            });
            var boxsrs = $('#popMember_'+sid);
            if(boxsrs.find('li').length==boxsrs.find('li.checked').length&&boxsrs.find('li.checked').length!=0){
                $('#clear_'+sid).attr('tip','1').text('全部取消');
            }else{
                $('#clear_'+sid).attr('tip','0').text('全部选中'); 
            }
        });
        //请求班级
        function ajaxClass(url,schoolId){
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'text',
                data: {sid:schoolId,type:2}
            }).done(function(data) { 
                if (data){ 
                    //alert(data);
                    $('#popMember_'+schoolId).append(data);
                }; 
            });
        }
        //添加成员 
        $('[rel=chekedItime]').live('click',function(){ 
            var sh = $("#shoolId").val();
            var type = $(this).attr('tip');
            var sid = $(this).data('sid');
            var cid = $(this).data('cid'); 
            if(parseInt(type)==0){ 
                if($("#checkboxs_"+sid+"_"+cid).length>0){ 
                    $(this).parent('li').attr('severtype','0');
                }else{
                    $(this).parent('li').attr('severtype','1'); 
                } 
                $(this).attr('tip',1);
                $(this).parent('li').addClass('checked');
                var box = $('#popMember_'+sid);
                if(box.find('li').length==box.find('li.checked').length&&box.find('li.checked').length!=0){
                    $('[rel=allCheck]').attr('tip','1').text('全部取消');
                }
            }else{
                if($("#checkboxs_"+sid+"_"+cid).length>0){ 
                    $(this).parent('li').attr('severtype','2'); 
                }else{
                    $(this).parent('li').attr('severtype','0'); 
                } 
                $(this).attr('tip',0);
                $(this).parent('li').removeClass('checked');
                $('[rel=allCheck]').attr('tip','0').text('全部选中');
                //$(this).parents('ul').find('[rel=addAllClass]').attr('tip',0); 
            } 
    });
    //全选
    $('[rel=allCheck]').live('click',function(){ 
        var sids = $('#selectSchoolList').find('option:selected').val(); 
        var _this = $(this);
        var tip = _this.attr('tip');
        if(tip=='0'){
            $('#popMember_'+sids).find('li[class!=checked] a').attr('tip','1');
            $('#popMember_'+sids).find('li[class!=checked]').attr('severtype','1').addClass('checked');
            _this.attr('tip','1');
            _this.text('全部取消');
        }else{
            var boxss =$('#popMember_'+sids);
            boxss.find('li a').attr('tip','0');
            boxss.find('li a').each(function(k,v){
                var cid = v.getAttribute('data-cid');
                 if($("#checkboxs_"+sids+"_"+cid).length>0){ 
                    $(this).parent('li').attr('severtype','2'); 
                }else{
                    $(this).parent('li').attr('severtype','0'); 
                } 
            }); 
            boxss.find('li').removeClass('checked');
            _this.attr('tip','0');
            _this.text('全部选中');
        } 
    });
    //清空选中
    $('[rel=clearCheck]').click(function(){
        $('[rel=allCheck]').attr('tip','0').text('全部选中');
        $("#memberList").find('[rel=deleItime]').click();
    });
    //清空选中
    $('[rel=clearCheck]').click(function(){
        $("#memberList").find('[rel=deleItime]').click();
    });
   //删除成员
    $('[rel=deleItime]').live('click',function(){ 
        $(this).parent('li').remove();
        var cid = $(this).data('cid'); 
        var sid = $(this).data('sid');
        $("#addCheckClass_"+sid+"_"+cid).attr('tip','0').parent().removeClass('checked'); 
        $("#addCheckClass_"+sid+"_"+cid).parent('li').attr('severType','0');
        //$("#addCheckClass_"+cid).parents('ul').find('[rel=chekedItime]').attr('tip','0').find('span').hide();
        $("#cuntUserCheck").find('span.red').text($('#memberList').find('li').length-1);
    });
    //保存选中
    $('#saveMemberBtn').live('click',function(){
        var sids = $('#selectSchoolList').find('option:selected').val();
        $('.ulListBox').attr('rel','removeListClass');
        $('#popMember_'+sids).attr('rel','');
        $("#memberBoxId").find("li").attr('severType','0');
        $("#memberBoxId").find("li").find('a').attr('tip','0');
        $('[rel=removeListClass]').find('li').removeClass('checked');
        $("#memberBoxId").find("li.checked").find('a').attr('tip','1');
        var str = ''; 
        $('#memberList').find('li.userCheck').remove();
        //var box = $("#selectCacheClass").html();
        var box = $('#popMember_'+sids).find('li.checked'); 
        box.find('a').each(function(k,v){
            //type = v.getAttribute('tip');
            sid = v.getAttribute('data-sid');
            cid = v.getAttribute('data-cid');
            tpyid = v.getAttribute('data-tpyid'); 
            cname = $(this).text();
            str +='<li class="userCheck userCheck_'+sid+'"><em></em><span>'+cname+'</span><a rel="deleItime" data-sid="'+sid+'" data-cid="'+cid+'" class="deleIco" href="javascript:void(0);"></a><input checked="checked" id="checkboxs_'+sid+'_'+cid+'" class="userCheck_'+cid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyid+'-'+cid+'"></li>'
        }); 
        $("#memberList .memberBtn").before(str);
        var cunt = box.length;
        hidePormptMaskWeb('#selectClass');
        $("#cuntUserCheck").find('span.red').text(cunt);
        if(parseInt(cunt)>0){
            $('#cuntTip').hide();
        }
        //$("#selectCacheClass").empty(); 
    });
     
        //添加成员
        $('[rel=addClass]').live('click',function(){
            var sh = $("#shoolId").val();
            var type =$(this).attr('tid');
            var sid =$(this).data('sid');
            var cid =$(this).data('cid');
            var tpyid =$(this).data('tpyid');
            var cname =$(this).data('cname');
            if(parseInt(sh)==parseInt(sid)){ 
                if(parseInt(type)==0){
                    var str ='<li class="userCheck userCheck_'+sid+'"><em></em><span>'+cname+'</span><a rel="deleItime" data-cid="'+cid+'" class="deleIco" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+cid+'" class="userCheck_'+cid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyid+'-'+cid+'"></li>';
                    $(this).attr('tid',1);
                    $(this).find('span').show();
                    $('#memberList').append(str); 
                }else{
                    $("#checkbox_"+cid).parent('li').remove();
                    $(this).find('span').show();
                    $(this).attr('tid',0);
                    $(this).find('span').hide();
                    $(this).parents('ul').find('[rel=addAllClass]').attr('tid',0); 
                } 
            }else{
                $("#memberList").empty();
                $(".schoolT_"+sh).find('span').hide();
                $(".schoolT_"+sh).attr('tid',0);
                if(parseInt(type)==0){
                    var str ='<li class="userCheck userCheck_'+sid+'"><em></em><span>'+cname+'</span><a rel="deleItime" data-cid="'+cid+'" class="deleIco" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+cid+'" class="userCheck_'+cid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyid+'-'+cid+'"></li>';
                    $(this).attr('tid',1);
                    $(this).find('span').show();
                    $('#memberList').append(str); 
                }else{
                    $("#checkbox_"+cid).parent('li').remove();
                    $(this).find('span').show();
                    $(this).attr('tid',0);
                    $(this).find('span').hide();
                    $(this).parents('ul').find('[rel=addAllClass]').attr('tid',0); 
                } 
                $("#shoolId").val(sid);
            }
            var lens = $("#school_"+sid).find('li').length -1; 
            var len =$('#memberList').find('li').length;
            if(parseInt(lens)==parseInt(len)){
                $(this).parents('ul').find('[rel=addAllClass]').find('span').show();
                $(this).parents('ul').find('[rel=addAllClass]').attr('tid',1);
            }else{
                $(this).parents('ul').find('[rel=addAllClass]').find('span').hide();
                $(this).parents('ul').find('[rel=addAllClass]').attr('tid',0);
            }
            if(parseInt(len)>0){
                $('#cuntTip').hide();
            } 
            $("#cuntUserCheck").find('span.red').text(len);
        });
        //全选
        $('[rel=addAllClass]').live('click',function(){
            var sh = $("#shoolId").val();
            var sid = $(this).data('sid');
            var type = $(this).attr('tid');
            var box = $("#school_"+sid); 
            if(parseInt(sh)==parseInt(sid)){  
                if(parseInt(type)==0){ 
                    box.find('a[rel=addClass]').each(function(v,e){  
                        var types = e.getAttribute('tid');
                        var cids = e.getAttribute('data-cid');
                        var tpyids = e.getAttribute('data-tpyid');
                        var cnames = e.getAttribute('data-cname'); 
                        if(parseInt(types)==0){ 
                           var str ='<li class="userCheck userCheck_'+sid+'"><em></em><span>'+cnames+'</span><a rel="deleItime" class="deleIco" data-cid="'+cids+'" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+cids+'" class="userCheck_'+cids+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyids+'-'+cids+'"></li>';
                            $('#memberList').append(str);
                            $('#addClass_'+cids).attr('tid',1);
                            $('#addClass_'+cids).find("span").show();
                        }
                    });
                    $(this).attr('tid',1);
                    $(this).find('span').show();
                }else{ 
                    $('#memberList').find('.userCheck_'+sid).remove();
                    $("#school_"+sid).find('a[rel=addClass]').find('span').hide();
                    $("#school_"+sid).find('a').attr('tid',0); 
                    $(this).find('span').hide();
                }
            }else{
                $("#memberList").empty();
                $(".schoolT_"+sh).find('span').hide();
                $(".schoolT_"+sh).attr('tid',0);
                if(parseInt(type)==0){ 
                    box.find('a[rel=addClass]').each(function(v,e){  
                        var types = e.getAttribute('tid');
                        var cids = e.getAttribute('data-cid');
                        var tpyids = e.getAttribute('data-tpyid');
                        var cnames = e.getAttribute('data-cname'); 
                        if(parseInt(types)==0){ 
                           var str ='<li class="userCheck userCheck_'+sid+'"><em></em><span>'+cnames+'</span><a rel="deleItime" class="deleIco" data-cid="'+cids+'" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+cids+'" class="userCheck_'+cids+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyids+'-'+cids+'"></li>';
                            $('#memberList').append(str);
                            $('#addClass_'+cids).attr('tid',1);
                            $('#addClass_'+cids).find("span").show();
                        }
                    });
                    $(this).attr('tid',1);
                    $(this).find('span').show();
                }else{ 
                    $('#memberList').find('.userCheck_'+sid).remove();
                    $("#school_"+sid).find('a[rel=addClass]').find('span').hide();
                    $("#school_"+sid).find('a').attr('tid',0);
                    $(this).find('span').hide();
                }
                $("#shoolId").val(sid);
            } 
            
            var len =$('#memberList').find('li').length;
            if(parseInt(len)>0){
                $('#cuntTip').hide();
            }
            $("#cuntUserCheck").find('span.red').text(len);
        });
        //删除成员
        $('[rel=deleItime1]').live('click',function(){ 
            $(this).parent('li').remove();
            var cid = $(this).data('cid')
            $("#addClass_"+cid).attr('tid','0').find('span').hide(); 
            $("#addClass_"+cid).parents('ul').find('[rel=addAllClass]').attr('tid','0').find('span').hide();
            $("#addClass_"+cid).find('span').hide();
            $("#cuntUserCheck").find('span.red').text($('#memberList').find('li').length);
        });
         //定时发送弹框

        var urlFilter="<?php echo Yii::app()->createUrl('xiaoxin/notice/checkbadword');?>";
        $('[rel=delayedTxBtn]').click(function(){
            $('#sensitiveWordsBtn').attr('data-val','time');
            var textF =$.trim($("#textareaCont").val());
            // var url = "<?php echo Yii::app()->createUrl('xiaoxin/notice/gettime');?>";
            var box = $("#memberList");
            var cunt =box.find('li').length-1;
            if (cunt > 0) {
                 if (textF!="") {
                     characterFilter(urlFilter,textF,timeCallbcak);
                 }else{
                    $("#textareaTip").text('内容不能为空！').show(); 
                 }
             }else{
                if (textF=="") {
                    $("#textareaTip").text('内容不能为空！').show(); 
                }
                $('#cuntTip').show();
             }
     
        });
 
        
        //定时发送
        $("#saveMemberBtn").click(function(){
            var box = $("#memberList");
            var cunt =box.find('li').length-1;
            var content =$.trim($("#textareaCont").val());
            var nameS = '';

            var hs=$("#selectH").val()=="0"?"00":$("#selectH").val();
            var is=$("#selectI").val()=="0"?"00":$("#selectI").val();
            var fixed_time= $("#selectY").val()+"-"+$("#selectM").val()+"-"+$("#selectD").val()+" "+hs+":"+is+":00"; 
            var timeHiddenDefine = $('#timeHiddenDefine').val();
            var sDate = new Date(fixed_time.replace(/\-/g, "\/"));
            var eDate = new Date(timeHiddenDefine.replace(/\-/g, "\/")); 

            if(sDate.getTime()>eDate.getTime()){

                // characterFilter(urlFilter,textF,timeCallbcak);
                 $("input[name=fixed_time]").val(fixed_time);
                if(parseInt(cunt)>0){
                    if(parseInt(content.length)>0&&parseInt(content.length)<=500){
                        box.find('span').each(function(i,e){
                            if(i==parseInt(cunt)-1){
                                nameS +=e.innerHTML;
                            }else{
                                nameS +=e.innerHTML+',';
                            }
                        });
                        $("#textareaContVal").val(content);
                        $('#receiveName').val(nameS);
                        //alert( $("input[name=fixed_time]").val());
                        $("#formBoxRegister").submit();
                       
                    }else{
                       $("#textareaTip").text('内容不能为空！').show(); 
                    }
                }else{
                    if(parseInt(content.length)>0&&parseInt(content.length)<=500){
                    }else{
                        $("#textareaTip").text('内容不能为空！').show(); 
                    }
                    $('#cuntTip').show();
                }
                 hidePormptMaskWeb('#delayedTxBox');
                
            }else{
              $('.setTimeTip').show();
              $('.setTimeTip').animate({opacity: 0}, 5000,function(){
                    $('.setTimeTip').hide().css({
                        'opacity': '1'
                    });
                }) 
            }  
        });

        //提交表单
        $('#submitForms').click(function(){
           $('#sensitiveWordsBtn').attr('data-val','send');
           var textF=$.trim($("#textareaCont").val()); 
            characterFilter(urlFilter,textF,callbcak);
            //$("#formBoxRegister").submit();
        });
        //预览信息
        $('[rel=previewMsg]').click(function(){
            var parentName=$('#receiverTit').val(),
                viewContent=$('#textareaCont').val(),
                teaName=$('#senderTit').val(),
                _html='';
            _html=parentName+','+viewContent+' '+teaName+'';
            $('#previewMsgBox').find('.previewContentMsg').html(_html);
            showPromptPush('#previewMsgBox');
        });

       
        //模板库
        $('.msgTmpBtn').click(function(){
            var url='<?php echo Yii::app()->createUrl("xiaoxin/notice/getTemplate")."?type=0";?>';
            tmpLibrary.initTmp(url);
        });

        $('.msgSend').click(function(event) {
            var val=$('#textareaCont').val();
            var url='<?php echo Yii::app()->createUrl("xiaoxin/notice/addTemplate");?>';
            if (val != '') {
                $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: {templatecontent:val,type:0}
                }).done(function(data) {
                    if (data) {
                        if (data.status==1) {
                            $('#msgTip').show();
                            $('#msgTip').animate({opacity: 0}, 4000,function(){
                                 $('#msgTip').hide().css({
                                     'opacity': '1'
                                 });;
                            })   
                            
                        };
                    };
                  
                
                })
            }else{
                $('#textareaTip').show().text('内容不能为空！');
            };
        });
    });
</script>