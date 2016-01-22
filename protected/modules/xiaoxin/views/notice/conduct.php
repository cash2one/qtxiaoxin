<!--创建消息,通知 -->
<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/sendlist?noticeType='.$noticeType);?>" >发送记录</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/unsendlist?noticeType='.$noticeType);?>" >待发列表</a></li>

                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/conduct?');?>" class="focus">在校表现</a></li>

            </ul>
        </div>  
    </div>
    <div class="titleText"><em class="inIco4"></em>日常工作 > 在校表现</div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show" >
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox" style="background: #FFFFFF;">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">可以向学生家长发布学生在校表现，让家长了解学生在校情况。 </div>
            <!--<div class="pheader"><em class="Pico"></em>选择学生</div>-->
            <div class="groupBox" style="position: relative; display: none;">
                <div class="titleName selectTite">
                    <a rel="showSchoolClass" tid="0" href="javascript:void(0);">选择学校班级</a>
                </div>
                <ul id="listSc" class="listSc" style="position: absolute; display: none; overflow-x: hidden;overflow-y:auto; max-height: 720px; *height: 620px;">
                     <?php if(is_array($schoolList)){?>
                     <?php foreach($schoolList as $k=>$v):?>
                     <li><a href="javascript:void(0);"  sid="<?php echo $v['sid'];?>" class="school"><?php echo $v['name'];?> </a></li>
                     <?php if(is_array($v['class'])){ foreach($v['class'] as $t):?>
                                 <?php if(isset($t['group'])&&$t['group']==1):?> <!--分组-->
                                   <li><a rel="selectClass" group="1" sid="<?php echo $v['sid'];?>" sname="<?php echo $v['name'];?>" cname="<?php echo $t['name'];?>" cid="<?php echo $t['gid'];?>" href="javascript:void(0);" class="class selectClass"><?php echo $t['name'];?> </a></li>
                                 <?php else:?>
                                     <li><a rel="selectClass" group="0" sid="<?php echo $v['sid'];?>" sname="<?php echo $v['name'];?>" cname="<?php echo $t['name'];?>" cid="<?php echo $t['cid'];?>" href="javascript:void(0);" class="class selectClass"><?php echo $t['name'];?> </a></li>
                                  <?php endif;?>

                     <?php endforeach;?>
                    <?php };?>
                    <?php endforeach;}?> 
                 </ul>

                <div class="studentListbox">
                    <ul id="studentListS" style="display: none;"> 
                    </ul> 
                </div>
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box">
            <div class="headBox ">
                <div class="headNav noticeType_select">
                    <ul>
                        <li><a typev="1" rel="couductTypeBtn" href="javascript:;" class="focus">表扬</a></li>
                        <li><a typev="2" rel="couductTypeBtn" href="javascript:;" >批评</a></li>
                    </ul>
                </div>  
            </div>
            <div class="formBox">
               <form id="formBoxRegister" action="<?php echo Yii::app()->createUrl('xiaoxin/notice/publish');?>" method="post">
                   <input id="couductTypeVal" name="type" type="hidden" value="1">
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
                                        <li class="memberBtn"><a rel="addUserBtn" href="javascript:void(0);" ><em class="addBtnIco"></em> 添加学生</a></li>
                                    </ul>
                                </div>
                                <div id="cuntUserCheck" class="cuntMember" >已选择了<span class="red">0</span>个学生<span id="cuntTip" style="display: none;" class="Validform_checktip Validform_wrong">至少添加一个学生</span></div>
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
                                        <option value="xxx家长">xxx家长</option>
                                        <option value="xxx">xxx</option> 
                                    </select>
                                </div>
                                <div>
                                    <!--<div  style="width:auto; height: 120px; border:1px solid #E1E1E1; padding: 3px 8px 5px; outline: none;" contenteditable="true" contentEditable="true" placeholder="请在这里填写发送内容"></div>-->
                                    <textarea id="textareaCont"  name="body" class="textFixed" onKeyDown="gbcount(this.form.textareaCont,this.form.totals,this.form.useds,this.form.remains);" onKeyUp="gbcount(this.form.textareaCont,this.form.totals,this.form.useds,this.form.remains);" style="width:100%; padding: 3px 8px 5px; *padding: 0; height: 120px; border:1px solid #E1E1E1; outline: none;" placeholder="请在这里填写发送内容"></textarea>
                                    <input id="textareaContVal" type="hidden" name="content"  value=""/>
                                </div>
                                <div style="margin-top: 10px;">
                                    <div class="fright">
                                        老师签名：
                                        <select name="sendertitle" id="senderTit">
                                            <?php foreach($signArr as $val):?>
                                                <option value="<?php echo $val;?>"><?php echo $val;?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="set-msg" style=" display: inline-block; margin-right: 40px; line-height: 20px;">

                                        <a href="javascript:void(0);" class="btn btn-default msgSend" style="margin-right:10px;">存为模板</a>
                                        <a href="javascript:void(0);" class="btn btn-default msgTmpBtn"  style="margin-right:10px;">模板库</a>

                                       <input type="hidden" maxLength="4" id="totals" size="3" value="500" class="inputtext" /> 
                                       <input type="hidden" maxLength="4" id="useds" size="3" value="0" class="inputtext" /> 
                                       您还可以输入<span id="remains_text" class="red">500</span>字
                                       <input readonly type="hidden" maxLength="4" id="remains" value="500" />
                                       <span id="textareaTip" class="Validform_checktip Validform_wrong main2" style="display:none;">内容不能为空！</span>
                                       <span id="msgTip" style="display:none;"> <span class="Validform_checktip Validform_right main2">保存成功</span> </span>
                                    </div> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="infoTitle" >〓 更多设置</div>
                                <div style="padding: 10px 0;">
                                    <label class="checkbox"><input name="isSendToMe" value="1" type="checkbox">给自己发送一条确认短信</label>
                                    <?php if($isshowsendsms):?>
                                        <p>
                                            <!--<label class="checkbox"><input name="isSendsms" value="1" type="checkbox">同步发送短信给未安装手机客户端的用户 </label>-->
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
                                <input  type="hidden" value="" name="fixed_time"/> 
                                <a id="submitForms" href="javascript:void(0);" class="btn btn-raed">发 送</a>  
                                &nbsp;&nbsp;
                                 <a href="javascript:void(0);" rel="delayedTxBtn"  id="delayBtn" class="btn btn-default" data-url="<?php echo Yii::app()->createUrl('xiaoxin/notice/gettime');?>">定时发送</a>
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
        <div id="setTime" class="remindInfo setTime" style="padding: 15px 20px 0 20px;"> 
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
        <div class="header" style="">添加学生<a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#selectClass')" ></a></div>
        <div id="selectContent" class="popupContent" style="padding: 20px;">
            <div class="selectBox">
                <select style=" width: 200px;" id="selectSchoolList" url="<?php echo Yii::app()->createUrl('xiaoxin/notice/selectclass');?>">
                    <option value="">选择学校</option>
                    <?php if(is_array($schoolList)){?>
                    <?php foreach($schoolList as $k=>$v):?>
                        <option  value="<?php echo $v['sid'];?>"><?php echo $v['name'];?></option>
                    <?php endforeach;};?>
                </select> 
                <?php if(is_array($schoolList)){?>
                <?php foreach($schoolList as $k=>$v):?>
                <select id="selectClassListBox_<?php echo $v['sid'];?>" class="selectClassListBox" style=" display: none; width: 200px;">
                    <option value="">选择班级/分组</option>
                    <?php if(is_array($v['class'])){ foreach($v['class'] as $t):?>
                            <?php if(isset($t['group'])&&$t['group']==1):?> <!--分组-->
                            <option tip="0" group="1" sid="<?php echo $v['sid'];?>" sname="<?php echo $v['name'];?>" cname="<?php echo $t['name'];?>" cid="<?php echo $t['gid'];?>" value="<?php echo $t['gid'];?>"><?php echo $t['name'];?></option>
                            <?php else:?>
                            <option tip="0" group="0" sid="<?php echo $v['sid'];?>" sname="<?php echo $v['name'];?>" cname="<?php echo $t['name'];?>" cid="<?php echo $t['cid'];?>" value="<?php echo $t['cid'];?>" ><?php echo $t['name'];?></option>
                            <?php endif;?> 
                    <?php endforeach;};?> 
                </select>
                    <?php if(is_array($v['class'])){ foreach($v['class'] as $t):?>
                        <?php if(isset($t['group'])&&$t['group']==1):?> <!--分组-->
                        <a rel="allCheck" sid="<?php echo $v['sid'];?>" id="clear_<?php echo $v['sid'];?>_1_<?php echo $t['gid'];?>" cid="<?php echo $t['sid'];?>_1_<?php echo $t['gid'];?>"  class="clear" tip="0" href="javascript:;" style=" display: none;">全部选中</a>
                        <?php else:?>
                        <a rel="allCheck" sid="<?php echo $v['sid'];?>" id="clear_<?php echo $v['sid'];?>_0_<?php echo $t['cid'];?>" cid="<?php echo $t['sid'];?>_0_<?php echo $t['cid'];?>"  class="clear" tip="0" href="javascript:;" style=" display: none;">全部选中</a>
                        <?php endif;?> 
                    <?php endforeach;};?>
                <?php endforeach;};?>
            </div>
            <div id="memberBoxId" class="memberBox" style="height: 305px; margin-bottom: 15px;">
                <?php if(is_array($schoolList)){?>
                    <?php foreach($schoolList as $k=>$v):?>
                    <div rel="removeListClass" id="schoolCalssListBox_<?php echo $v['sid'];?>" class="divUlListBox">
                        <?php if(is_array($v['class'])){ foreach($v['class'] as $t):?>
                         <?php if(isset($t['group'])&&$t['group']==1):?> <!--分组--> 
                            <ul  id="popMember_<?php echo $v['sid'];?>_1_<?php echo $t['gid'];?>" class="ulListBox"> 
                            </ul>
                            <?php else:?> <!--班级-->
                            <ul id="popMember_<?php echo $v['sid'];?>_0_<?php echo $t['cid'];?>" class="ulListBox"> 
                            </ul>
                        <?php endif;?> 
                        <?php endforeach;};?> 
                    </div>
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
<script type="text/javascript"> 
    $(function(){
         Validform.int('#formBoxRegister'); 
        //体验优化
        $(document).click(function(e){ 
           if($(e.target).eq(0).is('[rel=showSchoolClass]')){  
           }else{
               if($('#listSc').is(":visible")){ 
                   $('#listSc').hide();
                   $('[rel=showSchoolClass]').attr('tid',0);
               }else{  
               } 
           }
       });
        //弹框
        $('[rel=addUserBtn]').click(function(){
            var box =$("#memberBoxId").find("li");
            box.each(function(k,v){
                var type = v.getAttribute('severtype');
                //var id  =
                 if(type=='1'){
                    $(this).removeClass('checked');
                    $(this).find('a').attr('tid','0'); 
                 }
                 if(type=='2'){ 
                     $(this).addClass('checked');
                     $(this).find('a').attr('tid','1'); 
                 }
                 v.setAttribute('severtype','0');
                 $("#memberBoxId").find("li.checked").find('a').attr('tid','1');
            });
            var sid =$('#selectSchoolList').find('option:selected').val();
            var _this = $('#selectClassListBox_'+sid).find('option:selected'), 
            tip =_this.attr('tip');
            var cid = parseInt(_this.attr("cid")); 
            var group=parseInt(_this.attr("group"));
            var boxsrs = $('#popMember_'+sid+'_'+group+'_'+cid); 
            if(boxsrs.find('li').length==boxsrs.find('li.checked').length&&boxsrs.find('li.checked').length!=0){
                $('#clear_'+sid+'_'+group+'_'+cid).attr('tip','1').text('全部取消');
            }else{
                $('#clear_'+sid+'_'+group+'_'+cid).attr('tip','0').text('全部选中'); 
            }
            showPromptPush('#selectClass');
        });
        //切换学校
        $('#selectSchoolList').change(function(){ 
            var _this = $(this).find('option:selected'),
            sid = _this.val();
            $('.selectClassListBox').hide();
            $('.ulListBox').hide();
            $('#selectClassListBox_'+sid).show();
            //$("#mySelect option:first").prop("selected", 'selected');
            $('#selectClassListBox_'+sid).find('option:first').attr('selected','selected');
             $('[rel=allCheck]').hide();
            var box =$('#schoolCalssListBox_'+sid).find("li");
            box.each(function(k,v){
                var type = v.getAttribute('severtype');
                //var id  =
                 if(type=='1'){
                    $(this).removeClass('checked');
                    $(this).find('a').attr('tid','0'); 
                 }
                 if(type=='2'){ 
                     $(this).addClass('checked');
                     $(this).find('a').attr('tid','1'); 
                 }
                 v.setAttribute('severtype','0');
                 $("#memberBoxId").find("li.checked").find('a').attr('tid','1');
            });
        });
        //选择班级分组
        $('.selectClassListBox').change(function(){ 
            var _this = $(this).find('option:selected'),
            //sid = _this.val(),
            //urls = $(this).attr('url'),
            tip =_this.attr('tip');
            var cid = parseInt(_this.attr("cid"));
            var sid = parseInt(_this.attr("sid"));
            var cname = _this.attr('cname');
            var sname = _this.attr('sname');
            var shoolId =$("#shoolId").val();
            var group=parseInt(_this.attr("group")); //1表示请求的是分组 0为班级
            $(".ulListBox").hide();
            $('#popMember_'+sid+'_'+group+'_'+cid).show();
            if(tip=='0'){
                if(cid){ 
                    ajaxUserPost(cid,sid,cname,sname,group); 
                } 
            }
            $('[rel=allCheck]').hide();
            $('#clear_'+sid+'_'+group+'_'+cid).show();
            _this.attr('tip','1');
            var boxsrs = $('#popMember_'+sid+'_'+group+'_'+cid); 
            if(boxsrs.find('li').length==boxsrs.find('li.checked').length&&boxsrs.find('li.checked').length!=0){
                $('#clear_'+sid+'_'+group+'_'+cid).attr('tip','1').text('全部取消');
            }else{
                $('#clear_'+sid+'_'+group+'_'+cid).attr('tip','0').text('全部选中'); 
            }
        });
        function ajaxUserPost(cid,sid,cname,sname,group){ 
            var url="<?php echo Yii::app()->createUrl('xiaoxin/notice/getmember');?>";
            $.getJSON(url,{classId:cid,group:group},function(data){
                if(data&&data.status==='1'){
                    $('#popMember_'+sid+'_'+group+'_'+cid).html('');
                    var str=[]; 
                    if(data&&data.data){
                        $.each(data.data,function(i,v){
                            str.push('<li><a href="javascript:void(0);" class="addStudent_'+v.userid+'" id="addStudent_'+v.userid+'" data-sname='+ v.name+' rel="chekedItime" tid="0" pid="'+ v.userid+'" data-sid="'+sid+'" data-userid="'+ v.userid+'" data-cid="'+cid+'" data-tpyid="0">'+ v.name+'</a></li>');
                        }); 
                    }
                    if(str.join('').length){ 
                        $('#popMember_'+sid+'_'+group+'_'+cid).html(str.join(''));
                    }else{ 
//                        $('#popMember_'+sid+'_'+group+'_'+cid).html('<li><a href="javascript:void(0);" style="color:#999;">该班级还没有添加学生</a></li>');
                    } 
                } 
            });
        } 
        //添加成员
        $('[rel=chekedItime]').live('click',function(){ 
            var sh = $("#shoolId").val();
            var type = $(this).attr('tid'); 
            var userid =$(this).data("userid");
            var sids = $('#selectSchoolList').find('option:selected').val();
            var selectClassListBoxs = $('#selectClassListBox_'+sids).find('option:selected'),
            group = selectClassListBoxs.attr('group'),
            cid = selectClassListBoxs.val(); 
            if(parseInt(type)==0){
                if($("#checkbox_"+userid).length>0){ 
                    $(this).parent('li').attr('severtype','0');
                }else{
                    $(this).parent('li').attr('severtype','1'); 
                } 
                $(this).attr('tid',1);
                $(this).parent('li').addClass('checked');
                var box = $('#popMember_'+sids+'_'+group+'_'+cid);
                if(box.find('li').length==box.find('li.checked').length){
                    $('[rel=allCheck]').attr('tip','1').text('全部取消');
                }
            }else{
                 if($("#checkbox_"+userid).length>0){ 
                    $(this).parent('li').attr('severtype','2');
                }else{
                    $(this).parent('li').attr('severtype','0'); 
                } 
                $(this).attr('tid',0);
                $(this).parent('li').removeClass('checked');
                $('[rel=allCheck]').attr('tip','0').text('全部选中');
            } 
        });
        //全选
    $('[rel=allCheck]').live('click',function(){ 
        var _this = $(this);
        var sids = _this.attr('sid');
        var cids = _this.attr('cid');
        var tip = _this.attr('tip');
        if(tip=='0'){
            $('#popMember_'+cids).find('li[class!=checked] a').attr('tid','1');
            $('#popMember_'+cids).find('li[class!=checked]').attr('severtype','1').addClass('checked');
            _this.attr('tip','1');
            _this.text('全部取消');
        }else{
            var boxss =$('#popMember_'+cids);
            boxss.find('li a').attr('tid','0');
            boxss.find('li a').each(function(k,v){
                var userid = v.getAttribute('data-userid');
                if($("#checkbox_"+userid).length>0){ 
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
        //删除成员
        $('[rel=deleItime]').live('click',function(){ 
            $(this).parent('li').remove();
            var userid = $(this).data('userid'); 
            $("#addStudent_"+userid).attr('tid','0').parent().removeClass('checked'); 
            $("#addStudent_"+userid).parent('li').attr('severType','0'); 
            $('.addStudent_'+userid).attr('tid','0').parent().removeClass('checked');
            $('.addStudent_'+userid).parent().attr('severtype','0');
            //$("#addStudent_"+userid).attr('tid','0').find('span').hide(); 
            //$("#addStudent_"+userid).parents('ul').find('[rel=addAllStudent]').attr('tid','0').find('span').hide();
            //$("#addStudent_"+userid).find('span').hide();
            $("#cuntUserCheck").find('span.red').text($('#memberList').find('li').length-1);
        }); 
        //保存选中
        $('#saveMemberBtn').live('click',function(){
            var sh = $("#shoolId").val();
            var sids = $('#selectSchoolList').find('option:selected').val();
            var selectClassListBoxs = $('#selectClassListBox_'+sids).find('option:selected'),
            group = selectClassListBoxs.attr('group'),
            cid = selectClassListBoxs.attr('cid');
            $('.divUlListBox').attr('rel','removeListClass');
            $('#schoolCalssListBox_'+sids).attr('rel','');
            $('[rel=removeListClass]').find('li').removeClass('checked');
            if(parseInt(sh)!=parseInt(sids)){
                $('#memberList').find('li.userCheck').remove();
            }else{ 
                var box =$("#memberBoxId").find("li");
                box.each(function(k,v){
                   var type = v.getAttribute('severtype');
                    var usid = $(this).find('a').attr('data-userid');
                    if(type=='2'){ 
                        $("#checkbox_"+usid).parent().remove();
                    }
                    if(type=='0'){ 
                        $("#checkbox_"+usid).parent().remove();
                    }
                });
            }
            $("#memberBoxId").find("li").find('a').attr('tip','0');
            $("#memberBoxId").find("li").attr('severType','0');
            $("#memberBoxId").find("li.checked").find('a').attr('tip','1');
            var str = '',userids=[]; 
            //var box = $("#selectCacheClass").html();
            var box = $('#schoolCalssListBox_'+sids).find('li.checked'); 
            box.find('a').each(function(k,v){
                var types = v.getAttribute('tid');
                var userid = v.getAttribute('data-userid');
                //$("#checkbox_"+userid).parent().remove();
                var cids = v.getAttribute('data-cid');
                var tpyids = v.getAttribute('data-tpyid');
                var cnames = v.getAttribute('data-sname');
                if(!notinArray(userid,userids)){
                    userids.push(userid);
                    str = '<li severtype="0" class="userCheck userCheck_'+sids+'"><em class="userIco"></em><span>'+cnames+'</span><a rel="deleItime" class="deleIco" data-userid="'+userid+'" data-cid="'+cids+'" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+userid+'" class="userCheck_'+userid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sids+'-'+tpyids+'-'+userid+'"></li>';
                    $("#memberList .memberBtn").before(str);
                }
            }); 
            //$("#memberList .memberBtn").before(str); 
            hidePormptMaskWeb('#selectClass');
            var cunt = $("#memberList").find("li").length-1;
            $("#cuntUserCheck").find('span.red').text(cunt); 
            
            if(cunt>0){
                $('#cuntTip').hide();
            }
            //$("#selectCacheClass").empty(); 
            $("#shoolId").val(sids);
        });  
       function notinArray(k,ids){
            for(var i=0,len=ids.length;i<len;i++){
                if(k==ids[i]){
                    return true;
                }
            }
            return false;
        }
       //选择表现类别
       $('a[rel=couductTypeBtn]').click(function(){
           var typeVal =$(this).attr('typev');
           $("#couductTypeVal").val(typeVal);
           $(this).addClass('focus').parent('li').siblings('li').find('a').removeClass('focus');
       });
       //显示校班级
        $('[rel=showSchoolClass]').click(function(){
            var tid = $(this).attr('tid');
            if(parseInt(tid)==0){
                $('#listSc').show();
                 $(this).attr('tid',1);
            }
            safariOptimize($('#studentListS li a span'));
            AutoHeight();
        });
        //请求学生数据
        $(".selectClass").live('click',function(){
            var cid = parseInt($(this).attr("cid"));
            var sid = parseInt($(this).attr("sid"));
            var cname = $(this).attr('cname');
            var sname = $(this).attr('sname');
            var shoolId =$("#shoolId").val();
            var group=parseInt($(this).attr("group")); //1表示请求的是分组 0为班级
            var url="<?php echo Yii::app()->createUrl('xiaoxin/notice/getmember');?>";
            $.getJSON(url,{classId:cid,group:group},function(data){
                if(data&&data.status==='1'){
                    $("#studentListS").html('');
                    var str=[];
                    if(data&&data.data){
                        $.each(data.data,function(i,v){
                            str.push('<li><a href="javascript:void(0);" id="addStudent_'+v.userid+'" data-sname='+ v.name+' rel="addStudent" tid="0" pid="'+ v.userid+'" data-sid="'+sid+'" data-userid="'+ v.userid+'" data-cid="'+cid+'" data-tpyid="0"><span class="fright ">✔</span>'+ v.name+'</a></li>');
                        }); 
                    } 
                    if(parseInt(shoolId)==sid){ 
                    }else{ 
                        $('#memberList').empty();
                        $("#shoolId").val(sid);
                    }
                     
                    var all ='<li><a rel="addAllStudent" class="schoolT_'+sid+'" tid="0" data-sid="'+sid+'" data-cid="'+cid+'" href="javascript:void(0);"><span class="fright ">✔</span>全部 </a></li>';
                    if(str.join('').length){ 
                        $("#studentListS").html(all+str.join(''));
                    }else{ 
//                        $("#studentListS").html('<li><a href="javascript:void(0);" style="color:#999;">该班级还没有添加学生</a></li>');
                    }
                    $('#studentListS').show();
                    $('[rel=showSchoolClass]').text(cname+'---'+sname); 
                    
                }
                safariOptimize($('#studentListS li a span'));
                AutoHeight();
            });
        });
         
        //添加
        $('[rel=addStudent]').live('click',function(){
            var type =$(this).attr('tid');
            var userid =$(this).data('userid');
            var sid =$(this).data('sid');
            var tpyid =$(this).data('tpyid');
            //var cid =$(this).data('cid');
            var sname =$(this).attr('data-sname');
            if(parseInt(type)==0){
                var str ='<li class="userCheck userCheck_'+sid+'"><em class="userIco"></em><span>'+sname+'</span><a rel="deleItime" data-userid="'+userid+'" class="deleIco" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+userid+'" class="userCheck_'+userid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyid+'-'+userid+'"></li>';
                $(this).attr('tid',1);
                $("#checkbox_"+userid).parent('li').remove();
                $(this).find('span').show();
                $('#memberList').append(str); 
            }else{
                $("#checkbox_"+userid).parent('li').remove(); 
                $(this).attr('tid',0);
                $(this).find('span').hide(); 
            } 
            var len =$('#memberList').find('li').length;
            var lens = $("#studentListS").find('li').length -1;  
            if(parseInt(lens)==parseInt(len)){
                $(this).parents('ul').find('[rel=addStudent]').find('span').show();
                $(this).parents('ul').find('[rel=addStudent]').attr('tid',1);
                $(this).parents('ul').find('[rel=addAllStudent]').find('span').show();
                $(this).parents('ul').find('[rel=addAllStudent]').attr('tid',1);
            }else{
                $(this).parents('ul').find('[rel=addAllStudent]').find('span').hide();
                $(this).parents('ul').find('[rel=addAllStudent]').attr('tid',0);
            }
            if(parseInt(len)>0){
                $('#cuntTip').hide();
            }
            $("#cuntUserCheck").find('span.red').text(len);
        });
        
        //全选
        $('[rel=addAllStudent]').live('click',function(){
            var sh = $("#shoolId").val();
            var sid = $(this).data('sid');
            var type = $(this).attr('tid');
            var box = $("#studentListS"); 
            if(parseInt(sh)==parseInt(sid)){  
                if(parseInt(type)==0){ 
                    box.find('a[rel=addStudent]').each(function(v,e){  
                        var types = e.getAttribute('tid');
                        var userid = e.getAttribute('data-userid');
                        var cids = e.getAttribute('data-cid');
                        var tpyids = e.getAttribute('data-tpyid');
                        var cnames = e.getAttribute('data-sname'); 
                        if(parseInt(types)==0){
                           $("#checkbox_"+userid).parent('li').remove();
                           var str ='<li class="userCheck userCheck_'+sid+'"><em class="userIco"></em><span>'+cnames+'</span><a rel="deleItime" class="deleIco" data-userid="'+userid+'" data-cid="'+cids+'" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+userid+'" class="userCheck_'+userid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyids+'-'+userid+'"></li>';
                            $('#memberList').append(str);
                            $('#addStudent_'+userid).attr('tid',1);
                            $('#addStudent_'+userid).find("span").show();
                        }
                    });
                    $(this).attr('tid',1);
                    $(this).find('span').show();
                }else{ 
                    $('#memberList').find('.userCheck_'+sid).remove();
                    box.find('a[rel=addStudent]').find('span').hide();
                    box.find('a').attr('tid',0); 
                    $(this).find('span').hide();
                }
            }else{ 
                $(".schoolT_"+sh).find('span').hide();
                $(".schoolT_"+sh).attr('tid',0);
                if(parseInt(type)==0){ 
                    box.find('a[rel=addStudent]').each(function(v,e){  
                        var types = e.getAttribute('tid');
                        var userid = e.getAttribute('data-userid');
                        var cids = e.getAttribute('data-cid');
                        var tpyids = e.getAttribute('data-tpyid');
                        var cnames = e.getAttribute('data-cname'); 
                        if(parseInt(types)==0){
                           $("#checkbox_"+userid).parent('li').remove();
                           var str ='<li class="userCheck userCheck_'+sid+'"><em></em><span>'+cnames+'</span><a rel="deleItime" class="deleIco" data-userid="'+userid+'" data-cid="'+cids+'" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+userid+'" class="userCheck_'+userid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyids+'-'+userid+'"></li>';
                            $('#memberList').append(str);
                            $('#addStudent'+userid).attr('tid',1);
                            $('#addStudent'+userid).find("span").show();
                        }
                    });
                    $(this).attr('tid',1); 
                    $(this).find('span').show();
                }else{ 
                    $('#memberList').find('.userCheck_'+sid).remove();
                    box.find('a[rel=addClass]').find('span').hide();
                    box.find('a').attr('tid',0);
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
            var userid = $(this).data('userid'); 
            $("#addStudent_"+userid).attr('tid','0').find('span').hide(); 
            $("#addStudent_"+userid).parents('ul').find('[rel=addAllStudent]').attr('tid','0').find('span').hide();
            $("#addStudent_"+userid).find('span').hide();
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
            var typeVal=$('#couductTypeVal').val();
            var url='<?php echo Yii::app()->createUrl("xiaoxin/notice/getTemplate")."?type=";?>'+typeVal;
            tmpLibrary.initTmp(url);
        });

        $('.msgSend').click(function(event) {
            var val=$('#textareaCont').val();
            var typeVal=$('#couductTypeVal').val();
            var url='<?php echo Yii::app()->createUrl("xiaoxin/notice/addTemplate");?>';
            if (val != '') {
                $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: {templatecontent:val,type:typeVal}
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
            }
        });
    });
    
</script>