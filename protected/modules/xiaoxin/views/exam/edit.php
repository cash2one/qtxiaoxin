<style>
    #message1{ font-size: 18px; min-width: 265px; *width: 265px; margin: 0px auto; position:absolute ; right: 50%; bottom:5px; display: none; z-index: 10000; border-radius: 5px;}
    #message1 .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message1 .success{  border: 1px solid #fbeed5; background-color: #e95b5f; color: #fbe4e5; }
    #message1 .error{border: 1px solid #eed3d7; background-color: #e95b5f; color: #fbe4e5; }
    // #message .messageType span{  float: left;}
</style>
<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/update'). '/' . $id;?>" >首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit') . '/' . $id; ?>" >成绩</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit'). '/' . $id."?isEdit=1"; ?>" class="focus">录入</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/send'). '?eid=' . $id; ?>">发送</a></li>
            </ul>
        </div>
    </div>
    <div class="titleText"><em class="inIco13"></em>日常工作 > <span> 成绩管理 > </span> <span><?php echo $examInfo->name;?> </span></div>
</div>
<div class="mianBox">
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>关联考试</div>
            <div class="groupBox" id="groupBoxRelationArr">
                <?php if(count($examAloneList)): ?>
                    <?php foreach($examAloneList as $g=>$val):?>
                        <div class="titleName examConnect clearfix">
                            <em></em>
                            <div class="examContent">
                                <span class="gradeSpan"><?php echo $val['cid_name'];?></span>
                                <span class="subjectSpan"><?php echo $val['sid_name'];?></span>
                                <p><?php echo $val['exam_name'];?></p>
                            </div>
                            <a href="javascript:;" id="remove_exam_<?php echo $g;?>" tid="remove_exam_<?php echo $g;?>" eid="<?php echo $val['eid'];?>" eaid="<?php echo $val['eaid'];?>"  oldEid="<?php echo $id;?>"  class="btn btn-default divorced" rel="remove_exam">脱离</a>
                        </div>
                    <?php endforeach;?>
                <?php else:?>
                    <div style="margin:20px; text-align: center; font-size:18px; color:#666;">没有关联的考试</div>
                <?php endif;?>

            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox ">
        <div class="box">
            <div class="headBox ">
                <div class="headNav noticeType_select">
                    <ul>
                        <li><a avalue="1" href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit'). '/' . $id."?isEdit=1"; ?>" class="focus" >成绩录入</a></li>
                        <li><a avalue="2" href="<?php echo Yii::app()->createUrl('xiaoxin/exam/scheck'). '?id=' . $id ;?>" >模版导入</a></li>
                    </ul>
                </div>
            </div>
            <div class="formBox exam"> 
                <div class="box" style="padding-top:0;">
                <form id="formBoxRegister" action="" method="post"> 
                    <div class="exam" style=" padding: 0px;">
                    <table class="tableForm">
                        <tbody>
                        <tr id="examGradeList">
                            <td  class="examTd"  style="padding: 11px 5px;"><span class="inputTitle">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级：</span></td>
                            <td class="td_grade" style="padding: 11px 5px;">
                                <?php $j=0;foreach($gcinfo as $k=>$v):?>
                                    <a href="javascript:void(0);" gid="<?php echo $v['gid'];?>" class="btn <?php echo $j>0?'btn-default':'btn-raed';?> exam-btn" ><?php echo $v['gname'];?></a>
                                    <?php $j++;?>
                                <?php  endforeach;?>
                                <!--<a href="" class="btn btn-default exam-btn" >二年级</a>-->
                            </td>
                        </tr>
                        <tr id="examClassList" class="pd5">
                            <td  class="examTd" ><span class="inputTitle">班&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级：</span></td>
                            <td >
                                <?php $i=0;foreach($gcinfo as $k=>$v):?>
                                    <div id="classGid<?php echo $v['gid'];?>" style="margin-bottom:10px;<?php echo $i>0?'display:none':'';?>;">
                                        <?php $k=0; foreach($v['classes'] as $cc=>$dd):?>
                                            <a href="javascript:;" rel="classItme" eid="<?php echo $id;?>" cid="<?php echo $cc;?>"  href1="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit').'?id='.$id.'&cid='.$cc;?>" cid="<?php echo $cc;?>" class="btn <?php echo $k>0?'btn-default':'btn-raed';?> exam-btn" >
                                                <?php echo $dd;?>&nbsp;
                                            </a>
                                            <?php $k++;?>
                                        <?php endforeach;?>
                                    </div>
                                    <?php $i++;?>
                                <?php endforeach;?>
                            </td>
                        </tr>
                        </tbody>
                    </table> 
                    </div>
                    <div class="classMemberBox" style="overflow-y: hidden; overflow-x: auto; margin-bottom: 20px; padding: 15px 0;">
                        <table class="table tables">
                            <thead>
                            <tr class="tableHead">
                                <th width="80px"><div style="width:80px;">姓名</div></th>
                                <?php foreach($sids as $sid):?>
                                <th width="80px"><div style="width:80px;"><?php $subjectinfo=Subject::model()->findByPk($sid);echo $subjectinfo->name;?></div></th>
                                <?php endforeach;?>
                                <th><div style="text-align: left; width: 140px; margin: 0;"> 评语 <a href="javascript:;" class="publicMsg" rel="publicMsg">统一评语</a></div> </th>
                            </tr>
                            </thead>
                            <tbody class="examBody">
                            <?php if(count($classMan)): ?>
                                <?php foreach($classMan as $v):?>
                                    <tr id="userid_<?php echo $v['userid'];?>" userid="<?php echo $v['userid'];?>">
                                        <td><div style=" text-align: left; margin-left: 10px;"><?php echo $v['name'];?></div></td>
                                        <?php foreach($sids as $sid):?>
                                            <td ><input class="ssx" rel="sids" type="text" sid="<?php echo $sid;?>"  value="<?php echo isset($v[$sid])?$v[$sid]:'';?>" onkeyup="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"/></td>
                                        <?php endforeach;?>
                                            <td><div style=" text-align: left;"><input type="text" maxlength="100" rel="evaluation" value="<?php echo $v['evaluation'];?>" name="evaluation[]" /></div></td>
                                    </tr>
                                <?php endforeach;?>
                            <?php else:?>
                                <tr>
                                    <td colspan="<?php echo count($sids)+2;?>">
                                        <div class="noContent" style="background: #FFF; padding-bottom: 20px;">
                                            <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                            <p>空空如也，没有任何数据</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif;?>
                            </tbody>
                        </table>
                    </div> 
                    <input id="cidData" type="hidden" value="<?php echo $cid;?>" >
                    <input id="serverBtn" type="button" class="btn btn-raed  "  value="保 存">
                    &nbsp;&nbsp;
                    <!--<input type="button" class="btn btn-default"   value="取 消">-->
                    <span class="Validform_checktip" ><span class="Validform_checktip Validform_wrong" id="schoolValidform" style=" display: none;">请填写学生成绩！</span> </span>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="publicMsgBox" class="popupBox" style="width:500px;">
    <div class="header">统一评语<a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#publicMsgBox')" > </a></div>
    <div class="remindInfo">
        <div class="centent" style="text-indent:0; ">
            <textarea  id="publicMsgInput" ></textarea>
            <span class="Validform_checktip"><span class="Validform_checktip" id="publicMsgTip">&nbsp;</span></span>
        </div>
    </div>
    <div class="popupBtn">
        <a  href="javascript:;"  id="publicMsgBtn" class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskWeb('#publicMsgBox')" class="btn btn-default">取 消</a>
    </div>
</div>
<div id="remindBox" class="popupBox">
    <div class="remindInfo">
        <div id="remindText" class="centent">是否删脱离当前考试？ </div>
    </div>
    <div class="popupBtn">
        <a id="deleLink" href="javascript:;"  class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskWeb('#remindBox')" class="btn btn-default">取 消</a>
    </div>
</div>
<div id="message1">
    <div class="messageType success" id="icon1"><span id="icon">✔&nbsp;&nbsp;</span> <span class="text"></span></div>
    <div class="messageType success" id="icon2" style="display: none;"><span id="icons" >✘&nbsp;&nbsp;</span ><span class="text"></span> </div>
</div>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    //表单验证控件
    // Validform.int("#formBoxRegister");
    $("#menuListBoxs li a[href*='exam']").addClass("focus");
    //解除考试关联操作
    $('#groupBoxRelationArr').on('click','[rel=remove_exam]',function(){
        var eid = $(this).attr('eid');
        var eaid = $(this).attr('eaid');
        var oldeid = $(this).attr('oldEid');
        var tid = $(this).attr('tid');
        $('#deleLink').attr({eid:eid,eaid:eaid,oldEid:oldeid,tid:tid});
        showPromptsRemind('#remindBox');
    });
    //解除确定操作
    $(document).on('click','#deleLink',function(){
        var eid = $(this).attr('eid');
        var eaid = $(this).attr('eaid');
        var oldeid = $(this).attr('oldEid');
        var tid = $(this).attr('tid');
        hidePormptMaskWeb('#remindBox');
        $.ajax({
            url:"<?php echo Yii::app()->createUrl('xiaoxin/exam/leave')?>",
            type : 'POST',
            data : {eid:eid,eaid:eaid,oldEid:oldeid},
            dataType : 'text',
            contentType : 'application/x-www-form-urlencoded',
            async : false,
            success : function(data) {
                //location.reload();
                var mydata =$.parseJSON(data)
                //console.log(mydata.status);
                //var mydata=eval(data);
                $('#message1').find('.text').empty();
                if(mydata&&mydata.status=='1'){
                    $('#icon1').show().find('.text').append(mydata.msg);
                    $('#icon2').hide();
                    $('#'+tid).parent().remove();
                }else{
                    $('#icon2').show().find('.text').append(mydata.msg);
                    $('#icon1').hide();
                }
                $('#message1').show();
                setTimeout( function() {
                    $('#message1').slideUp("slow");
                    //location.reload();
                },3000);
                if($("#groupBoxRelationArr").find('.titleName').length==0){
                    var hd = '<div style="margin:20px; text-align: center; font-size:18px; color:#666;">没有关联的考试</div>';
                    $("#groupBoxRelationArr").append(hd);
                }
            },
            error : function() {
                // alert("calc failed");
            }
        });
    });

    //统一评语
    $('[rel=publicMsg]').click(function(){
        showPromptsRemind('#publicMsgBox');
    });
    $('#publicMsgBtn').click(function(event) {
        var publicMsgInput=$.trim($('#publicMsgInput').val());
        if (publicMsgInput.length > 100 ) {
             return false;
        };
        if (publicMsgInput) {
            $('[rel=evaluation]').each(function(index, el) {
                $(el).val(publicMsgInput);
            });
            hidePormptMaskWeb('#publicMsgBox');
        }else{
            $('#publicMsgTip').addClass('Validform_wrong').removeClass('Validform_right').text('评语不能为空！')
            return false;
        };
       

    });
    $('#publicMsgInput').keyup(function(event) {
        var thisVal=$.trim($(this).val());
        if ( thisVal.length > 100) {
            $('#publicMsgTip').addClass('Validform_wrong').removeClass('Validform_right').text('评语字数不能超过100个字！')
        }else{
            $('#publicMsgTip').addClass('Validform_right').removeClass('Validform_wrong').text('通过信息验证！')
        };
        if (thisVal == '') {
            $('#publicMsgTip').addClass('Validform_wrong').removeClass('Validform_right').text('评语不能为空！')
        };
    });

    //切换年级
    var eid ="<?php echo $id;?>";
    $('#examGradeList').on('click', 'a', function(event) {
        var gid=$(this).attr('gid');
        $(this).addClass('btn-raed').siblings().removeClass('btn-raed').addClass('btn-default');
        $('#classGid'+gid+'').show().siblings().hide();
        var cid =$('#classGid'+gid+'').find('a').first().attr('cid');
        $('#cidData').val(cid);
        var urls="<?php echo Yii::app()->createUrl('ajax/index')?>"+"?eid="+eid+"&cid="+cid;
        ajxapost(eid,cid,urls);
        setTimeout( function() {
            AutoHeight();
        },500);
    });

    //选择班级
    $('#examClassList').on('click','a[rel=classItme]',function(){
        var cid = $(this).attr('cid');
        $(this).addClass('btn-raed').siblings().removeClass('btn-raed').addClass('btn-default');
        var urls="<?php echo Yii::app()->createUrl('ajax/index')?>"+"?eid="+eid+"&cid="+cid;
        ajxapost(eid,cid,urls);
        $('#cidData').val(cid);
        setTimeout( function() {
            AutoHeight();
        },500);
    });
    //提醒优化
    $(document).on('focus','[rel=sids]',function(){
        $('#schoolValidform').hide();
    });
    //保存操作
    $(document).on('click','#serverBtn',function(){
        var cid = $('#cidData').val();
        var inputBox =$('.examBody');
        var datas =[]; 
        var flags = false;
        inputBox.find('tr').each(function(i,v){
            var data = "";
            var trBox = $(this);
            var str = ''; 
            //alert(trBox.attr('userid'));
            //data.userid= trBox.attr('userid');
            trBox.find('input[rel=sids]').each(function(i,v){
                var ss = $(this).attr('sid');
                var sv = $(this).val();
                if(sv!=''){
                   flags=true;  
                }
                if(i==trBox.find('input[rel=sids]').length-1){
                    str += '"'+ ss +'":"' + sv +'"';
                }else{
                    str += '"'+ ss + '":"' + sv + '",';
                }
            });
            data ='{"userid":"'+trBox.attr('userid')+'","evaluation":"'+trBox.find('input[rel=evaluation]').val()+'",'+str+'}';
            //console.log(data);
            datas.push(data);
        });
        var strDate = datas.join(',');
        if(flags){
            saveAjax(cid,eid,strDate); 
        }else{
            $('#schoolValidform').show();
        }
        
    });
});
//保存请求
function saveAjax(cid,eid,strDate){ 
    $.ajax({
            url:"<?php echo Yii::app()->createUrl('xiaoxin/exam/save')?>",
            type : 'POST',
            data : {cid:cid,eid:eid,data:"["+strDate+"]"},
            dataType : 'text',
            contentType : 'application/x-www-form-urlencoded',
            async : false,
            success : function(data) {
                var hd = '';
                //location.reload();relation
                var mydata =$.parseJSON(data);
                //console.log(mydata);
                //var mydata=eval(data);
                $('#message1').find('.text').empty();
                if(mydata&&mydata.status=='1'){
                    $('#icon1').show().find('.text').append(mydata.msg);
                    $('#icon2').hide();
                    if(mydata.relation !=''){
                        $.each(mydata.relation, function(index, val) {
                            hd+='<div class="titleName examConnect clearfix"><em></em>'
                                +'<div class="examContent"><span class="gradeSpan">'+val.cid_name + '</span>'
                                +'<span class="subjectSpan">'+val.sid_name+'</span>'
                                +'<p>'+val.exam_name+'</p>'
                                +'</div><a href="javascript:;" id="remove_exam_'+index+'" oldeid="'+eid+'"  eid="'+val.eid+'" eaid="'+val.eaid+'" tid="remove_exam_'+index+'" class="btn btn-default divorced" rel="remove_exam">脱离</a></div>';
                        });
                        $("#groupBoxRelationArr").empty().append(hd);
                    }else{
                        hd = '<div style="margin:20px; text-align: center; font-size:18px; color:#666;">没有关联的考试</div>';
                        $("#groupBoxRelationArr").empty().append(hd);
                    }
                }else{
                    $('#icon2').show().find('.text').append(mydata.msg);
                    $('#icon1').hide();
                }
                $('#message1').show();
                setTimeout( function() {
                    $('#message1').slideUp("slow");
                },3000);
            },
            error : function() {
                // alert("calc failed");
            }
        });
}

//请求学生成绩信息
function ajxapost(eid,cid,url){
    $.ajax({
        url: url,
        type: 'Post',
        dataType: 'JSON',
        data: {},
    }).done(function(data) {
            var datas=eval(data);
            //console.log(datas.sids.length);
            if(data !=''){
                var keyUpVal="'undo'";

                $(".examBody").empty();
                var html = '',hs = '',ht = '',hd = '';
                if(datas.data !=''){
                    $.each(datas.data, function(index, val) {
                        html = '<tr id="userid_'+val.userid+'" userid="'+val.userid+'"><td userid="'+val.userid+'"><div style=" text-align: left; margin-left: 10px;">'+ val.name+'</div></td>';
                        $.each(datas.sids, function(i, v) {
                            hs+='<td><input class="ssx" rel="sids" type="text"  value="'+val[v]+'" name="name" sid="'+v+'" onkeyup="if(isNaN(value))execCommand('+keyUpVal+')" onafterpaste="if(isNaN(value))execCommand('+keyUpVal+')"></td>';
                        });
                        ht = '<td><div style=" text-align: left;"><input rel="evaluation" maxlength="100" type="text" value="'+val.evaluation+'" name="name" ></div></td></tr>';
                        $(".examBody").append(html+hs+ht);
                        hs="";
                    });
                }else{
                    var hw = '<tr><td colspan="'+datas.sids.length+2+'"><div class="noContent" style="background: #FFF; padding-bottom: 20px;">'
                        +'<span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>'
                        +'<p>空空如也，没有任何数据</p></div></td></tr>';
                    $(".examBody").append(hw);
                }
                // console.log(datas.relationArr);
                if(datas.relationArr !=''){
                    $.each(datas.relationArr, function(index, val) {
                        hd+='<div class="titleName examConnect clearfix"><em></em>'
                            +'<div class="examContent"><span class="gradeSpan">'+val.cid_name + '</span>'
                            +'<span class="subjectSpan">'+val.sid_name+'</span>'
                            +'<p>'+val.exam_name+'</p>'
                            +'</div><a href="javascript:;" id="remove_exam_'+index+'" tid="remove_exam_'+index+'" class="btn btn-default divorced" rel="remove_exam">脱离</a></div>';
                    });
                    $("#groupBoxRelationArr").empty().append(hd);
                }else{
                    hd = '<div style="margin:20px; text-align: center; font-size:18px; color:#666;">没有关联的考试</div>';
                    $("#groupBoxRelationArr").empty().append(hd);
                }
            }else{
            }
        });
}
</script>
