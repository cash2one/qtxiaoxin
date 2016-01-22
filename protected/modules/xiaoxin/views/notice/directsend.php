<!--创建消息,通知 -->
<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/sendlist?noticeType='.$noticeType);?>" >发送记录</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/unsendlist?noticeType='.$noticeType);?>" >待发列表</a></li>

                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticeteacher');?>" class="focus">通知老师</a></li>

            </ul>
        </div>
    </div>
    <div class="titleText"><em class="inIco25"></em>日常工作 > 定向发送</div>
</div>
<div class="mianBox">
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show" >
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox" style="background: #FFFFFF;">
            <div class="pheader"><em class="Pico"></em>选择老师</div>
            <div class="groupBox" style="position: relative;">
                <div class="titleName selectTite">
                    <a rel="showSchoolClass" tid="0" href="javascript:void(0);">选择学校</a>
                </div>
                <ul id="listSc" class="listSc" style="position: absolute; display: none; overflow-x: hidden;overflow-y:auto; max-height: 650px; *height: 580px;"> 
                    <?php if(is_array($schoolList)){?>
                        <?php foreach($schoolList as $k=>$v):?>
                            <li><a href="javascript:void(0);"  sid="<?php echo $v['sid'];?>" class="selectClass" sname="<?php echo $v['name'];?>"><?php echo $v['name'];?> </a></li>
                        <?php endforeach;?>
                    <?php } ?>


                </ul>

                <div class="studentListbox">
                    <ul id="studentListS" style="display: none;">
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box" style="padding-top: 10px;"> 
            <div class="formBox">
                <form id="formBoxRegister" action="<?php echo Yii::app()->createUrl('xiaoxin/notice/publish');?>" method="post">
                    <table class="tableForm">
                        <tr>
                            <td>
                                <div class="infoTitle" >〓 接收对象</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="memberBox">
                                    <ul id="memberList">
                                        <!--<li class="memberBtn"><a rel="addUserBtn" href="javascript:void(0);" ><em class="addBtnIco"></em> 添加成员</a></li>-->
                                    </ul>
                                </div>
                                <div id="cuntUserCheck" class="cuntMember" >已选择了<span class="red">0</span>个老师<span id="cuntTip" style="display: none;" class="Validform_checktip Validform_wrong">至少添加一个老师</span></div>
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
                                <div style="margin-bottom: 10px;">老师称谓：
                                    <select name="receivertitle" id="receiverTit">
                                        <option value="xxx老师">xxx老师</option>
                                        <option value="xxx">xxx</option> 
                                    </select>
                                </div>
                                <div>
                                    <!--<div id="" class="" style="width:auto; height: 120px; border:1px solid #E1E1E1; padding: 3px 8px 5px; outline: none;" contenteditable="true" contentEditable="true" placeholder="请在这里填写发送内容"></div>-->
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
                                        <input type="hidden" maxLength="4" id="totals" size="3" value="500" class="inputtext" /> 
                                        <input type="hidden" maxLength="4" id="useds" size="3" value="0" class="inputtext" /> 
                                        您还可以输入<span id="remains_text" class="red">500</span>字
                                        <input readonly type="hidden" maxLength="4" id="remains" value="500" />
                                        <span id="textareaTip" class="Validform_checktip Validform_wrong  main2" style="display:none;">内容不能为空！</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="infoTitle" >〓 更多设置</div>
                                <div style="padding: 10px 0;"><label class="checkbox"><input name="isSendsms" value="1" type="checkbox">发送确认短信</label></div>
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
        <div class="popupBtn" style="text-align: right;padding:0 20px;color:#666;">
            <a id="sensitiveWordsBtn" href="javascript:void(0);"  class="btn btn-raed" data-val="">继续发送</a>&nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#sensitiveWordsBox')" class="btn btn-default">修改文字</a>
        </div>
    </div>
</div>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/characterFilter.js" type="text/javascript"></script>
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
        //显示校班级
        $('[rel=showSchoolClass]').click(function(){
            var tid = $(this).attr('tid');
            if(parseInt(tid)==0){
                $('#listSc').show();
                $(this).attr('tid',1);
            }else{
                $('#listSc').hide();
                $(this).attr('tid',0);
            }
            safariOptimize($('#studentListS li a span'));
            AutoHeight();
        });
        //请求学生数据
        $(".selectClass").live('click',function(){ 
            var cid = parseInt($(this).attr("cid"));
            var sid = parseInt($(this).attr("sid"));
            var type = $.trim($(this).attr("type"));
            //var cname = $(this).attr('cname');
            var sname = $(this).attr('sname');
            var shoolId =$("#shoolId").val();
            var url="<?php echo Yii::app()->createUrl('xiaoxin/notice/getdirector');?>";
            //console.log(url);
            $.getJSON(url,{id:cid,type:type,sid:sid},function(data){
                if(data&&data.status==='1'){
                    $("#studentListS").html('');
                    var str=[];
                    if(data&&data.data){ 
                        $.each(data.data,function(i,v){
                            if(type=='dept'){
                                str.push('<li><a href="javascript:void(0);" id="addStudent_'+(type=='group'? v.member:v.userid)+'" sname='+ v.name+' rel="addStudent" tid="0" pid="'+ (v.userid? v.userid: v.member)+'" data-sid="'+sid+'" data-userid="'+ (v.userid? v.userid: v.member)+'" data-cid="'+cid+'" data-tpyid="0"><span class="fright ">✔</span>'+ ( v.name)+'</a></li>');
                            }else{
                                str.push('<li><a href="javascript:void(0);" id="addStudent_'+(type=='group'? v.member:v.userid)+'" sname='+ v.name+' rel="addStudent" tid="0" pid="'+ (v.userid? v.userid: v.member)+'" data-sid="'+sid+'" data-userid="'+ (v.userid?v.userid:v.member)+'" data-cid="'+cid+'" data-tpyid="0"><span class="fright ">✔</span>'+ ( v.name)+'</a></li>');
                            } 
                        });
                    }
                    if(parseInt(shoolId)==sid){
                    }else{ 
                        $('#memberList').empty();
                        $("#shoolId").val(sid);
                    } 
                    var all ='<li><a rel="addAllStudent" class="schoolT_'+sid+'" tid="0" data-sid="'+sid+'" data-cid="'+cid+'" href="javascript:void(0);"><span class="fright ">✔</span>全部</a></li>';
                    if(str.join('').length){
                        $("#studentListS").html(all+str.join(''));
                    }else{ 
                        $("#studentListS").html('<li><a href="javascript:void(0);" style="color:#999;">当前老师选中的学校还没有配置定向发送对象</a></li>');
                    }
                    $('#studentListS').show(); 
                    $('[rel=showSchoolClass]').text(sname); 
                    AutoHeight();
                }
            });
        });

        //添加
        $('[rel=addStudent]').live('click',function(){
            var type =$(this).attr('tid');
            var userid =$(this).data('userid');
            var sid =$(this).data('sid');
            var tpyid =$(this).data('tpyid');
            var cid =$(this).data('cid');
            var sname =$(this).attr('sname');
            if(parseInt(type)==0){
                $("#checkbox_"+userid).parent('li').remove();
                var str ='<li class="userCheck userCheck_'+sid+'"><em class="userIco"></em><span>'+sname+'</span><a rel="deleItime" data-userid="'+userid+'" class="deleIco" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+userid+'" class="userCheck_'+userid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyid+'-'+userid+'"></li>';
                $(this).attr('tid',1);
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

                        var cnames = e.getAttribute('sname');
                        var sname=cnames.split(":");
                        cnames=sname[1]?sname[1]:e.getAttribute('sname');
                        if(parseInt(types)==0){
                            $("#checkbox_"+userid).parent('li').remove();
                            var str ='<li class="userCheck userCheck_'+sid+'"><em class="userIco"></em><span>'+cnames+'</span><a rel="deleItime" class="deleIco" data-userid="'+userid+'"  data-cid="'+cids+'" href="javascript:void(0);"></a><input checked="checked" id="checkbox_'+userid+'" class="userCheck_'+userid+'" type="checkbox" style="display: none;" name="Group[uid][]" value="'+sid+'-'+tpyids+'-'+userid+'"></li>';
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
        $('[rel=deleItime]').live('click',function(){
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
            var cunt =box.find('li').length;
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
            var cunt =box.find('li').length;
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
    });

</script>