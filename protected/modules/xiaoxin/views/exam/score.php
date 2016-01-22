<style>
    #message1{ font-size: 18px; min-width: 265px; *width: 265px; margin: 0px auto; position:absolute ; right: 50%; bottom:50px; display: none; z-index: 10000; border-radius: 5px;}
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
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit') . '/' . $id; ?>" class="focus">成绩</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit'). '/' . $id."?isEdit=1"; ?>">录入</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/send'). '?eid=' . $id; ?>">发送</a></li>
            </ul>
        </div>
    </div>
    <div class="titleText"><em class="inIco13"></em>日常工作 > <span> 成绩管理 > </span> <span><?php echo $examInfo->name;?></span></div>
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
                    <?php $k=0; foreach($examAloneList as $g=>$val):?>
                        <div class="titleName examConnect clearfix">
                            <em></em>
                            <div class="examContent">
                                <span class="gradeSpan"><?php echo $val['cid_name'];?></span>
                                <span class="subjectSpan"><?php echo $val['sid_name'];?></span>
                                <p><?php echo $val['exam_name'];?></p>
                            </div>
                            <a href="javascript:;" id="remove_exam_<?php echo $k;?>" tid="remove_exam_<?php echo $k;?>" eid="<?php echo $val['eid'];?>" eaid="<?php echo $val['eaid'];?>" oldEid="<?php echo $id;?>"  class="btn btn-default divorced" rel="remove_exam">脱离</a>
                        </div>
                    <?php $k++; ?>
                    <?php endforeach;?>
                <?php else:?>
                    <div style="margin:20px; text-align: center; font-size:18px; color:#666;">没有关联的考试</div>
                <?php endif;?> 
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox ">
        <div class="box">
            <div class="listTopTite bBottom">成绩列表</div>
            <div class="formBox exam">
                <div class="box" style="padding-top:0;">
                <form id="formBoxRegister" action="" method="post">
                    <table class="tableForm">
                        <tbody>
                            <tr id="examGradeList" class="pd5">
                                <td  class="examTd" style="padding:3px 5px;"><span class="inputTitle">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级：</span></td>
                                <td >
                                    <?php $j=0;foreach($gcinfo as $k=>$v):?>
                                    <a href="javascript:void(0);" gid="<?php echo $v['gid'];?>" class="btn <?php echo $j>0?'btn-default':'btn-raed';?> exam-btn" ><?php echo $v['gname'];?></a>
                                    <?php $j++;?>
                                    <?php  endforeach;?>
                                    <!--<a href="" class="btn btn-default exam-btn" >二年级</a>-->
                                </td>
                            </tr>
                            <tr id="examClassList">
                                <td  class="examTd" style="padding:3px 5px;"><span class="inputTitle">班&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级：</span></td>
                                <td >
                                    <?php $i=0;foreach($gcinfo as $k=>$v):?>
                                       <div id="classGid<?php echo $v['gid'];?>" style="margin-bottom:10px;<?php echo $i>0?'display:none':'';?>;">
                                                <?php $k=0; foreach($v['classes'] as $cc=>$dd):?>  
                                                    <a  href="javascript:;" rel="classItme" eid="<?php echo $id;?>" cid="<?php echo $cc;?>" class="btn btn-default exam-btn <?php if($k==0):?>btn-raed<?php endif;?>" >
                                                    <?php $k++;?>
                                                <?php echo $dd;?>&nbsp;
                                                </a>
                                                <?php endforeach;?>
                                        </div>
                                        <?php $i++;?>
                                     <?php endforeach;?> 
                                </td> 
                            </tr> 
                        </tbody>
                    </table>
                    <div class="classMemberBox" style="overflow-y: hidden; overflow-x: auto; margin-bottom: 20px; padding: 0;">
                        <table class="table tables"> 
                            <thead>
                                <tr class="tableHead">
                                    <th width="80px"><div style="width:80px;">姓名 </div></th>
                                    <?php foreach($sids as $sid):?>
                                        <th width="80px"><div style="width:80px;"><?php $subjectinfo=Subject::model()->findByPk($sid);echo $subjectinfo->name;?></div></th>
                                    <?php endforeach;?>
                                    <th ><div style="width:140px; text-align: left; margin: 0;">评语</div> </th>
                                </tr>
                            </thead>
                            <tbody class="examBody">
                                <?php if(count($classMan)): ?>
                                    <?php foreach($classMan as $v):?>
                                    <tr>
                                        <td userid="<?php echo $v['userid'];?>"><div style=" text-align: left; margin-left: 10px;"><?php echo $v['name'];?></div></td>
                                        <?php foreach($sids as $sid):?>
                                            <td > <?php echo $v[$sid];?></td>
                                        <?php endforeach;?>
                                            <td><div style=" text-align: left; margin-left: 15px;"><?php echo $v['evaluation'];?></div> </td>
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
                    <input type="button" class="btn btn-raed " id="btn_edit" value="录 入">
                    &nbsp;&nbsp;
                    <input type="button" class="btn btn-default" id="btn_export" value="导 出">
                    &nbsp;&nbsp;
                    <input type="button" class="btn btn-default" id="btn_send" value="发 送">
                    <input type="hidden" name="current_cid" value="<?php echo $cid;?>"> 
                </form>
                </div>
            </div>
        </div>
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
        $("#menuListBoxs li a[href*='exam']").addClass("focus");
        var eid ="<?php echo $id;?>";
        //表单验证控件
        // Validform.int("#formBoxRegister");
        //选择年纪
        $('#examGradeList').on('click', 'a', function(event) {
             var gid=$(this).attr('gid');
             $(this).addClass('btn-raed').siblings().removeClass('btn-raed').addClass('btn-default');
            $('#classGid'+gid+'').show().siblings().hide();
            var cid =$('#classGid'+gid+'').find('a').first().attr('cid');
            $("input[name=current_cid]").val(cid);
            var urls="<?php echo Yii::app()->createUrl('ajax/index')?>"+"?eid="+eid+"&cid="+cid;
            ajxapost(eid,cid,urls);
            setTimeout( function() {  
                AutoHeight();  
            },500); 
        });
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
        //选着班级
        $('#examClassList').on('click','a[rel=classItme]',function(){
            var cid = $(this).attr('cid');
            $(this).addClass('btn-raed').siblings().removeClass('btn-raed').addClass('btn-default');
            var urls="<?php echo Yii::app()->createUrl('ajax/index')?>"+"?eid="+eid+"&cid="+cid; 
            ajxapost(eid,cid,urls);
            setTimeout( function() {  
                AutoHeight();  
            },500);
            
        });
        
        $("#btn_send").click(function(){
            var url="<?php echo Yii::app()->createUrl('xiaoxin/exam/send').'?eid='.$id;?>";
            location.href=url;
        });
        $("#btn_export").click(function(){
            var cid=$("input[name=current_cid]").val();
            var url="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit').'/'.$id.'?&isExport=1';?>";
            url=url+"&cid="+cid;
            location.href=url;
        })
        $("#btn_edit").click(function(){
            var url="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit').'/'.$id."?isEdit=1";?>";
            location.href=url;
        });
        
    });
    //请求学生成绩信息
    function ajxapost(eid,cid,url){
        $.ajax({
            url: url,
            type: 'Post',
            dataType: 'JSON',
            data: {},
        }).done(function(data) {
            var datas=eval(data); 
            if(data !=''){
                $(".examBody").empty();
                var html = '',hs = '',ht = '' ,hd = '';
                if(datas.data !=''){
                    $.each(datas.data, function(index, val) { 
                        html = '<tr><td><div style=" text-align: left; margin-left: 10px;">'+val.name+'</div></td>';
                        $.each(datas.sids, function(i, v) {
                            hs+='<td>'+val[v]+'</td>';
                        });
                        ht = '<td><div style=" text-align: left;">'+val.evaluation+'</div></td></tr>'; 
                        $(".examBody").append(html+hs+ht);
                        hs="";
                    });
                }else{
                    var hw = '<tr><td colspan="'+datas.sids.length+2+'"><div class="noContent" style="background: #FFF; padding-bottom: 20px;">'
                        +'<span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>'
                        +'<p>空空如也，没有任何数据</p></div></td></tr>';
                    $(".examBody").append(hw);
                } 
                
               //console.log(datas.relationArr);
                if(datas.relationArr !=''){ 
                   $.each(datas.relationArr, function(index, val) {
                    hd+='<div class="titleName examConnect clearfix"><em></em>' 
                        +'<div class="examContent"><span class="gradeSpan">'+val.cid_name + '</span>' 
                        +'<span class="subjectSpan">'+val.sid_name+'</span>'
                        +'<p>'+val.exam_name+'</p>'
                        +'</div><a href="javascript:;" id="remove_exam_'+index+'" tid="remove_exam_'+index+'" eid="'+val.eid+'" eiad="'+val.eaid+'" oldEid="'+val.oldEid+'" class="btn btn-default divorced" rel="remove_exam">脱离</a></div>'; 
                    });
                    $("#groupBoxRelationArr").empty().append(hd); 
                }else{
                    hd = '<div style="margin:20px; text-align: center; font-size:18px; color:#666;">没有关联的考试</div>';
                    $("#groupBoxRelationArr").empty().append(hd);
                }
            }       
        }); 
    }
</script>