<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
               <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/');?>" >考试列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/create');?>" class="focus">创建考试</a></li>
            </ul>
        </div>
    </div>
    <div class="titleText"><em class="inIco13"></em>日常工作 > <span> 成绩管理</span></div>
</div>
<div class="mianBox">
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
        </div>
    </div>
    <div id="contentBox" class="contentBox ">
        <div class="box">
            <div class="listTopTite bBottom">创建考试</div>
            <div class="formBox exam">
                <form id="formBoxRegister" action="" method="post">
                    <table class="tableForm">
                        <tbody>

                            <tr>
                                <td class="examTd"><span class="inputTitle">所在学校：</span></td>
                                <td>

                                    <div class="inputBox">
                                        <select name="Exam[schoolid]" id="class_school"  datatype="*" nullmsg="请选择学校！" errormsg="" rel=" ">
                                                <option value=''>--选择学校--</option>
                                                <?php foreach($schools as $sk=>$sv): ?>
                                                    <option value="<?php echo $sk; ?>" ><?php echo $sv; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                     <!--<div class="inputBox"><input name="Account[name]" value=" " class="lg" type="text" datatype="*" nullmsg="请输入所在学校！" errormsg="所在学校不能为空！"></div>-->
                                    <span class="Validform_checktip" >  </span>
                                    </td>
                            </tr>
                             <tr>
                                <td  class="examTd"><span class="inputTitle">考试类型：</span></td>
                                <td>

                                    <div class="inputBox">
                                        <select name="Exam[type]" id="class_school"  datatype="*" nullmsg="请选择考试类型！" errormsg="" rel=" ">
                                                <option value=''>--考试类型--</option>
                                                <?php foreach($types as $tk=>$tv): ?>
                                                    <option value="<?php echo $tk; ?>"><?php echo $tv; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                     <!--<div class="inputBox"><input name="Account[name]" value=" " class="lg" type="text" datatype="*" nullmsg="请输入所在学校！" errormsg="所在学校不能为空！"></div>-->
                                    <span class="Validform_checktip" ></span>
                                    </td>
                            </tr>
                            <tr>
                                <td  class="examTd"><span class="inputTitle">学&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期：</span></td>
                                <td>

                                    <div class="inputBox">
                                        <select name="Exam[term]" id="class_school"  datatype="*" nullmsg="请选择学期！" errormsg="" rel=" ">
                                                <option value=''>--选择学期--</option>
                                                <?php foreach($terms as $tk=>$tv): ?>
                                                    <option value="<?php echo $tk; ?>"><?php echo $tv; ?></option>
                                                <?php endforeach; ?>
                                        </select>
                                    </div>
                                     <!--<div class="inputBox"><input name="Account[name]" value=" " class="lg" type="text" datatype="*" nullmsg="请输入所在学校！" errormsg="所在学校不能为空！"></div>-->
                                    <span class="Validform_checktip" ></span>
                                </td>
                            </tr>
                            <tr>
                                <td  class="examTd" ><span class="inputTitle">考试名称：</span></td>
                                <td>

                                    <div class="inputBox"><input name="Exam[name]" class="lg" placeholder="请输入考试名称" type="text" datatype="*1-20" nullmsg="请输入考试名称！" errormsg="考试名称不能大于20个字!"></div>
                                    <span class="Validform_checktip" ></span>
                                    <div class="info" style="display: none;">考试名称不能大于20个字!<span class="dec"><s class="dec1">◆</s><s class="dec2">◆</s></span></div>
                                </td>
                            </tr>
                            <tr>
                                <td  class="examTd"> <span class="inputTitle">班&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;级：</span></td>
                                <td>
                                        <div id="examGrade"></div>
                                </td>
                            </tr>
                             <tr>
                                <td  class="examTd"> <span class="inputTitle">科&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目：</span></td>
                                <td>
                                        <div class="examGrade examSubject" >
                                            <div class="examSelectBox" id="examSubject"></div>
                                        </div>
                                </td>
                            </tr>
                            <tr>
                                 <td  class="examTd"></td>
                                 <td>

                                     <input type="button" class="btn btn-raed"  value="创 建" id="examSumit"><span class="Validform_checktip " ><span class="Validform_checktip" id="schoolValidform"></span> </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
    //表单验证控件
    Validform.int("#formBoxRegister");
    var ajaxurl = "<?php echo Yii::app()->createUrl('ajax/teacherschinfo'); ?>",
        examSubjectId=$('#examSubject'),
        examGradeId=$('#examGrade'),
        subjecturl,
        classurl; 
    //全选
    examGradeId.on('change', 'input[type=checkbox]', function(event) {
         var _left=$(this),
             thisGradeSub=_left.parent('.examSelectClass').find('input'),
             num=_left.parent('.examSelectClass').find('input:checked').length;
        num < thisGradeSub.length ? _left.parent().prev().find('.examGradeTit').removeAttr('checked')
        : _left.parent().prev().find('.examGradeTit').attr('checked','checked')

    });

    //学校控制
    var schoolStatus=true;
    $('#class_school').change(function(event) {
        var _left=$(this),
            sid=_left.val(),
            subjecturl = ajaxurl+'?sid='+sid+'&ty=subject',
            classurl = ajaxurl+'?sid='+sid+'&ty=class';
            if (sid) {
                ajaxDate(subjecturl,'subject');
                ajaxDate(classurl,'class');
            }else{
                 examSubjectId.html('');
                 examGradeId.html('');
            };
            setTimeout( function() {
                AutoHeight();
            },500);
        $('#schoolValidform').removeClass('Validform_wrong').text('');
        schoolStatus=false;
    });

    //判断班级和科目是否为空
    $('#examSumit').click(function(){
         //var examC=$('.examSelectClass').find('input');
         var nums=$('.examSelectClass').find('input:checked').length;
         var numj =$('.examSelectClass').find('input').length;
         var numq=$('#examSubject').find('input').length;
         var nump=$('#examSubject').find('input').length;
         if (schoolStatus) {
             if ($('#class_school').val() == '') {
                $('#formBoxRegister').submit();
             } 
         };
         if(numj==0){
             $('#checkboxClass').addClass('Validform_wrong').removeClass('Validform_right').text('没有班级不能创建考试！');
         }else{
            if (nums == 0) {
                 $('#checkboxClass').addClass('Validform_wrong').removeClass('Validform_right').text('请选择班级！');
            }else{
                $('#checkboxClass').addClass('Validform_right').removeClass('Validform_wrong').text('通过信息验证！');
                if(numq==0){
                    $('#examKmun').addClass('Validform_wrong').removeClass('Validform_right').text('没有科目不能创建考试！');   
                }else{
                   $('#examKmun').addClass('Validform_right').removeClass('Validform_wrong').text('通过信息验证！');
                   $('#formBoxRegister').submit(); 
                } 
            }
         } 
    }); 

    //获取年级和科目数据
    function ajaxDate(url,type){
         $.ajax({
              url: url,
              type: 'Post',
              dataType: 'JSON',
              data: {} 
          }).done(function(data) {
              var data=eval(data), num=1;
            //科目
            if(type == 'subject'){
                var html='';
                if(data !=''){
                    $.each(data, function(index, val) {
                         if (num == 1) {
                            html+= '<input id="Information_kindtop_sub_'+index+'" value="'+index+'" type="checkbox" name="Exam[subject][]" '
                                   +'datatype="need2" nullmsg="请选择科目！"><label for="Information_kindtop_sub_'+index+'" >'+val+'</label>';
                         }else{
                            html+= '<input id="Information_kindtop_sub_'+index+'" value="'+index+'" type="checkbox" name="Exam[subject][]" '
                                   +'datatype="need2" nullmsg="请选择科目！"><label for="Information_kindtop_sub_'+index+'" >'+val+'</label>';
                         };
                         num++;
                         examSubjectId.html('<div>'+html+'</div><span class="Validform_checktip "><span class="Validform_checktip ">&nbsp;</span></span>');
                        // console.log(val);
                    });
                }else{
                    // examSubjectId.next().children().text('');
                    examSubjectId.html('<span class="Validform_checktip "><span id="examKmun" class="Validform_checktip ">&nbsp;</span></span>');
                }
            }
            //年级班级
            if( type == 'class'){
                  var html='';
                if(data !=''){
                   var numb=1;
                    var p ,len=0;
                    for(p in data) {len++;}
                    $.each(data, function(index, val) {
                        var classes=val.classes;
                        if (numb==len) {
                             html+='<div class="examGrade"><label class="checkbox">'
                           +'<input  type="checkbox" class="examGradeTit" >'+val.gname+'</label></div><div class="examSelectBox examSelectClass" style="margin-bottom:0">';
                         }else{
                             html+='<div class="examGrade"><label class="checkbox">'
                           +'<input  type="checkbox" class="examGradeTit" >'+val.gname+'</label></div><div class="examSelectBox examSelectClass" >';
                         }
                         $.each(classes, function(classindex, classVal) {
                             if(numb==len){
                                html+='<input id="Information_kindtop_'+classindex+'" value="'+classindex+'" type="checkbox" name="Exam[class][]" >'
                                +'<label for="Information_kindtop_'+classindex+'" >'+classVal+'</label>';
                             }else{
                                html+='<input id="Information_kindtop_'+classindex+'" value="'+classindex+'" type="checkbox" name="Exam[class][]" >'
                                    +'<label for="Information_kindtop_'+classindex+'" >'+classVal+'</label>';
                            }
                         });
                         numb++;
                         html+='</div>';
                         examGradeId.html(html+'<span class="Validform_checktip"><span class="Validform_checktip" id="checkboxClass">&nbsp;</span></span>');
                    });

                    //年级复选框
                    $('.examGrade').on('change', '.examGradeTit', function(event) {
                        var _left=$(this),
                            thisGradeSub=_left.parent().parent().next().find('input'),
                            thisGradeL=_left.parents('#examGrade').find('.examSelectClass input');
                        var num=0;

                        if (_left.is(":checked")) {
                          $('#checkboxClass').addClass('Validform_right').removeClass('Validform_wrong').text('通过信息验证！');
                            thisGradeSub.attr('checked','checked')
                        }else{
                           thisGradeSub.removeAttr('checked');
                           thisGradeL.each(function(index, el) {
                                if (!$(el).is(":checked")) {
                                   num++;
                                }
                           });
                        }
                        if (num == thisGradeL.length) {
                             $('#checkboxClass').addClass('Validform_wrong').removeClass('Validform_right').text('请选择班级！');
                         };
                    });
                    //班级复选框
                    $('.examSelectClass').on('change', 'input', function(event) {
                        var _left=$(this),
                            num=_left.parent().parent().find('.examSelectClass input:checked').length;
                         if (num ==0) {
                              $('#checkboxClass').addClass('Validform_wrong').removeClass('Validform_right').text('请选择班级！');
                         }else{
                               $('#checkboxClass').addClass('Validform_right').removeClass('Validform_wrong').text('通过信息验证！');
                         };
                    });
                }else{
                    examGradeId.html('<span class="Validform_checktip "><span id="checkboxClass" class="Validform_checktip ">&nbsp;</span></span>');
                }
            }
            //Validform.int("#formBoxRegister");
          });
    }

});
</script>