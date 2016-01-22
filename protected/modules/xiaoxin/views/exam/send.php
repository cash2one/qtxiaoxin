<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
               <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/update'). '/' . $id;?>" >首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit') . '/' . $model->eid; ?>">成绩</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit'). '/' . $model->eid.'?isEdit=1'; ?>">录入</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/send'). '?eid='. $model->eid; ?>" class="focus">发送</a></li>
            </ul>
        </div>
    </div>
    <div class="titleText"><em class="inIco13"></em>日常工作 > <span> 成绩管理 > </span> <span><?php echo $examInfo->name;?></span></div>
</div>
<div class="mianBox">
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="jawvascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
        </div>
    </div>
    <div id="contentBox" class="contentBox ">
        <div class="box">
            <div class="listTopTite bBottom">发送成绩</div>
            <div class="formBox exam ">
            	<div class="box" style="padding-top:0;">
	                <form id="formBoxRegister" action="" method="post">
	                    <table class="tableForm">
	                        <tbody>
                                <tr >
                                    <td  style="width:38%"><div class="sendTopName clearfix">考试名称：</div><span class="sendTopSpan"><?php echo $examInfo->name;?></span></td>
                                    <td  style="width:35%"><div class="sendTopName clearfix">学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期：</div><span class="sendTopSpan"><?php echo $examInfo->term;?></span></td>
                                    <td  style="width:27%"><div class="sendTopName clearfix">考试类型：</div><span class="sendTopSpan"><?php echo $examTypeName;?></span></td>
                                </tr>
                            </tbody>
	                    </table> 	
                        <table class="tableForm">
	                        <tbody>
                                <tr>
                                    <td  class="examTd">
                                        <span class="inputTitle">发&nbsp;送&nbsp;项 ：</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                                <button rel="btnSendType" type="button" id="level1" class="btn btn-raed" aid="1">分数</button>
                                                <button rel="btnSendType" type="button"  id="level2" class="btn btn-default" aid="2">等级</button>
                                                <input type="hidden" value="1" name="level" id="level">
                                        </div>
                                    </td> 
                                </tr>
	                        </tbody>
	                    </table> 	 
                        <div class="gradeTable" style=" overflow-x:auto; overflow-y: hidden; margin-left: 90px;">
                            <div id="gradeTable">
                                <table>
                                   <thead>
                                       <tr>
                                           <th >
                                               <div style="width:80px;">科目\等级</div></th>

                                               <?php foreach($config as $k=>$v):?>
                                                   <?php if(is_array($v)):?>
                                                       <?php  foreach($v as $key=>$val):?>
                                                           <th><div style="width:125px;"><?php echo $key; ?></div></th>
                                                       <?php endforeach;?>
                                                   <?php  endif;?>
                                                   <?php break;?>
                                               <?php endforeach;?>

                                       </tr>
                                   </thead>
                                   <tbody>


                                       <?php foreach($config as $k=>$v):?>
                                           <tr>
                                               <td ><?php  $sub = Subject::getSubjects($k); if($sub){ echo $sub[$k];} ?></td>
                                               <?php if(is_array($v)): $ii=0;?>
                                               <?php   foreach($v as $key=>$val):?>
                                                   <td><?php echo  $val['height']; ?> <?php echo $ii==0?'>=':'>';?>  <?php echo $key; ?>  >= <?php echo  $val['low']; ?></td>
                                               <?php $ii++;endforeach;?>
                                               <?php endif;?>

                                           </tr>
                                       <?php endforeach;?>

                                   </tbody>
                               </table>
                            </div>
                            <div class="gradeTable-edit">
                                <a href="javascript:;" rel="publicGradeBox">修改等级配置</a>
                            </div>
                        </div> 
                        <table class="tableForm">
	                        <tbody>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="examGrade"><label class="checkbox"><input type="checkbox" name="ave" value="1" class="examGradeTit">班级平均分</label></div>
				                    <div class="examGrade"><label class="checkbox"><input type="checkbox" name="evaluation" value="1" class="examGradeTit">评语</label></div>
                                    </td>
                                </tr>
	                        <tr>
	                        	 <td  class="examTd"><span class="inputTitle">年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级：</span></td>
	                        	 <td>
	                        	 	<div class="examSelectBox sendSelectClass" id="examGradeList">
	                                    <?php $j=0;foreach($gcinfo as $k=>$v):?>
	                                        <input class="grade_<?php echo $v['gid'];?>" type="checkbox" name="gid_" gid="<?php echo $v['gid'];?>"/>
	                                        <a href="javascript:void(0);" gid="<?php echo $v['gid'];?>" class="btn <?php echo $j>0?'btn-default':'btn-raed';?> exam-btn" ><?php echo $v['gname'];?></a>
	                                        <?php $j++;?>
	                                    <?php  endforeach;?>
	                        	 	</div>
	                        	 </td>
	                        </tr>
	                        <tr id="examClassList">
	                        	 <td  class="examTd"><span class="inputTitle">班&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级：</span></td>
                                 <td class="sendSelectClass">
	                                 <?php $i=0;foreach($gcinfo as $k=>$v):?>
	                                     <div id="classGid<?php echo $v['gid'];?>" gid="<?php echo $v['gid'];?>"  style="margin-bottom:10px;<?php echo $i>0?'display:none':'';?>;">
	                                         <?php $k=0; foreach($v['classes'] as $cc=>$dd):?>
	                                         	
	                                             <input  type="checkbox"  name="cids[]" value="<?php echo $cc;?>">
	                                             <a href="javascript:;" rel="classItme" eid="<?php echo $id;?>" cid="<?php echo $cc;?>"  href1="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit').'?id='.$id.'&cid='.$cc;?>" cid="<?php echo $cc;?>" class="btn <?php echo $k>0?'btn-default':'btn-raed';?> exam-btn">
	                                                 <?php echo $dd;?>&nbsp;
	                                             </a>
	                                             <?php $k++;?>
	                                         <?php endforeach;?>
	                                     </div>
	                                     <?php $i++;?>
	                                 <?php endforeach;?>
	                                <!--
	                        	 	<div class="examSelectBox sendSelectClass" id="examClassList">
		                        	 	<input  type="checkbox" >
		                        	 	<a href="javascript:;" class="btn btn-raed exam-btn" rel="classItme">(1)班</a>
		                        	 	<input  type="checkbox">
		                        	 	<a href="javascript:;" class="btn btn-default exam-btn" rel="classItme">(2)班</a>
	                        	 	</div>
	                        	 	-->
	                        	 </td>
	                        </tr>
	                        </tbody>
	                    </table>
	                    <div class="classMemberBox" style="overflow-y: hidden; overflow-x: auto; margin-bottom: 20px; padding: 0;">
		                    <table class="table tables">
		                        <thead>
			                        <tr class="tableHead">
			                            <th width="80px"><div style="width:80px;  ;">姓名</div></th>
		                                <?php foreach($sids as $sid):?>
		                                    <th width="80px"><div style="width:120px; "><?php $subjectinfo=Subject::model()->findByPk($sid);echo $subjectinfo->name;?>（等级）</div></th>
		                                <?php endforeach;?>
			                            <th><div style="width:140px; text-align: left; margin: 0; ">评语</div></th>
			                        </tr>
		                        </thead>
		                        <tbody class="examBody">
		                        <?php if(count($classMan)): ?>
		                            <?php foreach($classMan as $v):?>
		                                <tr>
		                                    <td ><div style=" text-align: left;margin-left:10px;"><?php echo $v['name'];?></div></td>
		                                    <?php foreach($sids as $sid):?>
		                                    	   <td ><?php echo $v[$sid];?> </td>
		                                    <?php endforeach;?>
		                                    <td><div style=" text-align: left; "><?php echo $v['evaluation'];?></div> </td>
		                                </tr>
		                            <?php endforeach;?>

                                    <tr style="color:#FD7F35;">
                                        <td ><div style=" text-align: left;margin-left:10px;">班级平均分</div></td>
                                    <?php foreach($score as $k=>$v):?>
                                        <td ><?php echo $v['avg']?></td>
                                    <?php endforeach;?>
                                    <td></td> 
                                    </tr> 
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
	                    <div class="examGrade sendMsg">
                            <label class="checkbox"><input  type="checkbox" name="isok" value="1">给自己发送一条确认短信 <span>（选中后，在发送成功时会给自己的号码发送一条确定短信）</span></label>
                            <?php if($isshowsendsms):?>
                            <p style="margin-top: 5px;">
                            <!--<label class="checkbox"><input  type="checkbox" name="isSendsms" value="1">同步发送短信给未安装手机客户端的用户 <span>（选中后，会给学生家长的号码发送一条成绩单短信）</span></label>-->
                            </p>
                            <?php endif;?>
	                    </div>
	                    <input  type="submit" class="btn btn-raed "   value="发送" id="sendSubmit"><span class="Validform_checktip "><span class="Validform_checktip " id="classValidform"></span> </span>
	                    <input  type="hidden" name="eid"  value="<?php echo $id;?>">
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="publicGradeBox" class="popupBox" style="width:900px;">
    <div class="header">等级设置<a href="javascript:void(0);" class="close" onclick="hidePormptMaskGred('#publicGradeBox')" > </a></div>
    <div class="remindInfo" style="overflow-y: auto;max-height:450px;">
			<div class="gradeTable addGradeTable" style="overflow-x: auto; overflow-y:hidden; width:850px; ">
                <form id="formBoxGrade" action="<?php echo  Yii::app()->createUrl('xiaoxin/exam/level')?>" method="post">
                    <table class="formBoxGradeTable">
                        <thead>
                            <tr  id="gradeList">
                                <th style="width:70px;"><div style="width:70px;">科目\等级</div></th>
                                    <?php foreach($config as $k=>$v):?>
                                        <?php if(is_array($v)):?>
                                            <?php  foreach($v as $key=>$val):?>
                                                <th class="gradeNum"><div style="width:180px;"><?php echo $key; ?><a href="javascript:;" class="delete-btn" title="删除">-</a></div></th>
                                            <?php endforeach;?>
                                        <?php  endif;?>
                                        <?php break;?>
                                    <?php endforeach;?>
                            </tr>
                        </thead>
                        <tbody  >
                            <?php if(is_array($config)):?>
                            <?php $i=0;  $sub = Subject::getSubjects($k);foreach($config as $k=>$v):?>
                                <tr class="gradeListTr gradeListTr_<?php echo $i;?>" tir="<?php echo $k;?>">
                                    <td ><?php $sub=""; echo isset($sub[$k])?$sub[$k]:''; ?><input type="hidden" name="confighidden[]" value="<?php echo $k;?>"></td>
                                    <?php  if(is_array($v)): ?>
                                    <?php  $ii=0; foreach($v as $key=>$val):?>
                                            <td>
                                                <input type="text"  name="config[<?php echo $k;?>][<?php echo $key;?>][height]" value="<?php echo $val['height'];?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">  <?php echo $ii==0?'>=':'>';?> <?php echo $key; ?>&nbsp;>=
                                                <input type="text"  name="config[<?php echo $k;?>][<?php echo $key;?>][low]" value="<?php echo $val['low'];?>" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" >
                                            </td>
                                            
                                    <?php $ii++;endforeach;?>
                                    <?php endif;?>
                                </tr>
                                <?php $i++; endforeach;?>
                            <?php endif;?>
                        </tbody>
                    </table>
                    <input type="hidden" name="eid" value="<?php echo $id;?>"> 
                </form>
                <div class="gradeTable-edit">
                	<a href="javascript:;" id="addGrade">添加等级</a>
                </div>
            </div>
    </div>
    <div class="popupBtn"> 
        <a  href="javascript:;"  id="publicGradeBtn" class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskGred('#publicGradeBox')" class="btn btn-default">取 消</a>
    </div>
</div> 
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    $("#menuListBoxs li a[href*='exam']").addClass("focus");
    $("#level1").click(function(){
            $("#level").val($(this).attr("aid"));
    })
    $("#level2").click(function(){
        $("#level").val($(this).attr("aid"));
    });
    //表单验证控件
    // Validform.int("#formBoxRegister");
    
    //发送项类型选择
    $('[rel=btnSendType]').click(function(){
        $(this).removeClass('btn-default').addClass('btn-raed').siblings().removeClass('btn-raed').addClass('btn-default');
    });

    //等级弹出框
    var htmlPublic="";
    $(document).on('click','[rel=publicGradeBox]',function(){ 
        if(htmlPublic==""){
            htmlPublic =$('#formBoxGrade').html();
        }else{
           $('#formBoxGrade').empty();
           $('#formBoxGrade').html(htmlPublic);
        }
        showPromptsRemind('#publicGradeBox');
    });

    //添加等级
    var tip=0;
    $(document).on('click','#addGrade',function(event) {
    	var keyUpVal="''";
        var gradeNum=$('.gradeNum');

     	$('#gradeList').find('th:last-child .delete-btn').removeClass('delete-btn-S');
         if(gradeNum.length == 0){
            var _html='<th tip="'+tip+'" class="gradeNum"><div style="width:180px;"><input type="text" maxlength="10" class="input-first" ><a href="#" class="delete-btn" title="删除">-</a></div></th>';
            $('.gradeListTr').append('<td class="itme_'+tip+'"><input rel="height" type="text" class="input-sub"  onkeyup="this.value=this.value.replace('+/\D/g+','+keyUpVal+')" onafterpaste="this.value=this.value.replace('+/\D/g+','+keyUpVal+')"> >= <span>等级</span> >= <input rel="low" type="text"  onkeyup="this.value=this.value.replace('+/\D/g+','+keyUpVal+')" onafterpaste="this.value=this.value.replace('+/\D/g+','+keyUpVal+')"></td>');
        }else{
            var _html='<th tip="'+tip+'" class="gradeNum"><div style="width:180px;"><input type="text" maxlength="10" class="input-first" ><a href="#" class="delete-btn" title="删除">-</a></div></th>';
             $('.gradeListTr').append('<td class="itme_'+tip+'"><input rel="height" type="text" class="input-sub"  onkeyup="this.value=this.value.replace('+/\D/g+','+keyUpVal+')" onafterpaste="this.value=this.value.replace('+/\D/g+','+keyUpVal+')"> > <span>等级</span> >= <input rel="low" type="text"  onkeyup="this.value=this.value.replace('+/\D/g+','+keyUpVal+')" onafterpaste="this.value=this.value.replace('+/\D/g+','+keyUpVal+')"></td>');
        }
     	
        $('#gradeList').append(_html);
        $('#gradeList').find('th:last-child .delete-btn').addClass('delete-btn-S');
        tip++;
    });
    $('#gradeList').find('th:last-child').find('.delete-btn').addClass('delete-btn-S');
    $(document).on('keyup', '.input-first', function(event) {
    		var num=$(this).parents('th').attr('tip');
    		var _val=$.trim($(this).val());
            var gid =$('tr.gradeListTr');
    		if(_val ==''){
    			$('.gradeListTr td.itme_'+num).find('span').text('等级'); 
    		}else{
                $('.gradeListTr td.itme_'+num).find('span').text(_val);
                gid.each(function(i,v){
                    var tir = $(this).attr('tir');
                    $(this).find('td.itme_'+num).find('input[rel=height]').attr('name','config['+tir+']['+_val+'][height]');
                    $(this).find('td.itme_'+num).find('input[rel=low]').attr('name','config['+tir+']['+_val+'][low]');
                }); 
    		}
	});
    $(document).on('click', 'a.delete-btn', function(event) { 
    	$(this).parent().parent().remove();
    	$('.gradeListTr td:last-child').remove();
    	$('#gradeList').find('th:last-child .delete-btn').addClass('delete-btn-S');
    });
    $(document).on('click','#publicGradeBtn',function(event) {
    	$('#formBoxGrade').submit();
    });
    //添加等级 end

    //切换年级
    var eid ="<?php echo $id;?>";
    $('#examGradeList').on('click', 'a', function(event) {
        var gid=$(this).attr('gid');
        $(this).addClass('btn-raed').siblings().removeClass('btn-raed').addClass('btn-default');
        $('#classGid'+gid+'').show().siblings().hide();
        var cid =$('#classGid'+gid+'').find('a').first().attr('cid');
        $('#cidData').val(cid);
        var urls="<?php echo Yii::app()->createUrl('ajax/index')?>"+"?eid="+eid+"&cid="+cid+"&showlevel=1";
        ajxapost(eid,cid,urls);
        setTimeout( function() {
            AutoHeight();
        },500);
    });

    //班级全选和不选
    $('#examGradeList').on('change', 'input[type=checkbox]', function(event) {
    	var gid=$(this).attr('gid');
    	if ($(this).is(':checked')) {
    		$('#classGid'+gid).find('input').attr('checked','checked')
    	}else{
    		$('#classGid'+gid).find('input').removeAttr('checked');
    	};
    	var counts=$('#examClassList').find('input:checked').length;
    	if (counts == 0) {
    		$('#classValidform').addClass('Validform_wrong').removeClass('Validform_right').text('请选择班级！');
    	}else{
    		$('#classValidform').addClass('Validform_right').removeClass('Validform_wrong').text('通过信息验证！');
    	};
    });

    $('#examClassList').on('change', 'input[type=checkbox]', function(event) {
    	var gid=$(this).parent().attr('gid'),
    		_thisP=$(this).parent().find('input'),
    		num=0;
    	num = $(this).parent().find('input:checked').length;
    	var counts=$('#examClassList').find('input:checked').length;
    	if (num < _thisP.length) {
			$('.grade_'+gid).removeAttr('checked');
    	}else{
    		$('.grade_'+gid).attr('checked','checked');
    	}
    	if (counts == 0) {
    		$('#classValidform').addClass('Validform_wrong').removeClass('Validform_right').text('请选择班级！');
    	}else{
    		$('#classValidform').addClass('Validform_right').removeClass('Validform_wrong').text('通过信息验证！');
    	};
    });
    $('#sendSubmit').on('click', function(event) {
    	var counts=$('#examClassList').find('input:checked').length;
    	if (counts == 0) {
    		$('#classValidform').addClass('Validform_wrong').removeClass('Validform_right').text('请选择班级！');
    		return false;
    	}else{
    		$('#classValidform').addClass('Validform_right').removeClass('Validform_wrong').text('通过信息验证！');
    	};
    });

    //选择班级
    $('#examClassList').on('click','a[rel=classItme]',function(){
        var cid = $(this).attr('cid');
        $(this).addClass('btn-raed').siblings().removeClass('btn-raed').addClass('btn-default');
        var urls="<?php echo Yii::app()->createUrl('ajax/index')?>"+"?eid="+eid+"&cid="+cid+"&showlevel=1";
        ajxapost(eid,cid,urls);
        $('#cidData').val(cid);
        setTimeout( function() {
            AutoHeight();
        },500);
    });


});
//请求学生成绩信息
function ajxapost(eid,cid,url){
    $.ajax({
        url: url,
        type: 'Post',
        dataType: 'JSON',
        data: {}
    }).done(function(data) {
            var datas=eval(data);
            //console.log(datas.sids.length);
            if(data !=''){
                $(".examBody").empty();
                var html = '',hs = '',ht = '',hd = '';
                if(datas.data !=''){
                    $.each(datas.data, function(index, val) {
                        html = '<tr id="userid_'+val.userid+'" userid="'+val.userid+'"><td userid="'+val.userid+'"><div style=" text-align: left;margin-left:10px;">'+ val.name+'</div></td>';
                        $.each(datas.sids, function(i, v) {
                            hs+='<td>'+val[v]+'</td>';
                        });
                        ht = '<td><div style=" text-align: left; ">'+val.evaluation+'</div></td></tr>';

                        $(".examBody").append(html+hs+ht);
                        hs="";
                    });
                    var avgHtml='<tr style="color:#FD7F35;"><td>班级平均分</td>',tdHtml =''; 
                     $.each(datas.score, function(index, val) {
                          tdHtml+='<td>'+val.avg+'</td>'
                     })
                     $(".examBody").append(avgHtml+tdHtml+'<td></td></tr>');
                     
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
                            +'<div class="examContent"><span class="gradeSpan">'+val.grade_name+'&nbsp;'+val.cid_name + '</span>'
                            +'<span class="subjectSpan">'+val.sid_name+'</span>'
                            +'<p>'+val.grade_name+'&nbsp;&nbsp;'+val.cid_name +'&nbsp;&nbsp;'+val.exam_type +'&nbsp;&nbsp;'+val.exam_name+'</p>'
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
