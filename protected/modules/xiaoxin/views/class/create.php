<div class="header">
<!--    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/index');?>" >班级列表</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/apply');?>">入班邀请</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/create');?>" class="focus">创建班级</a></li>
            </ul>
        </div>  
    </div>-->
    <div class="titleText"><em class="inIco17"></em>我的班级 > 新建班级</div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
               创建所在学校的新班级或兴趣班.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox ">
        <div class="box"> 
            <div class="listTopTite bBottom">
                 <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/class_step_1.png">
            </div> 
            <div class="formBox">
                <form id="formBoxRegister" action="" method="post">
                    <table class="tableForm">
                        <tbody> 
                            <tr>
                                <td>
                                    <span class="inputTitle">班级名称：</span>
                                    <div class="inputBox"><input id="className" url="<?php echo Yii::app()->createUrl('xiaoxin/class/Isexist');?>" name="Class[name]"  placeholder="请输入班级名称" value="" maxlength="20" class="lg" type="text" datatype="*1-20" nullmsg="请输入班级名称！" errormsg="班级名称不能大于20个字!"></div>
                                    <span id="tipCheck" class="Validform_checktip"></span>  
                                    <div class="info" style="display: none;">班级名称不能大于20个字!<span class="dec"><s class="dec1">◆</s><s class="dec2">◆</s></span></div>
                                    <input id="isOkType" type="hidden" value="1">
                                </td>
                            </tr>
                            <input id="schoolId" type="hidden" name="sid" value="<?php echo $sid;?>">
                            <!--tr>
                                <td>
                                    <span class="inputTitle">所在学校：</span>
                                    <div class="inputBox">
                                        <select id="class_school" name="Class[school]" datatype="*" nullmsg="请选择学校！" errormsg="" rel="<?php //echo Yii::app()->createUrl('xiaoxin/class/schoolgrade');?>">
                                            <option value=''>--选择学校--</option>
                                            <?php //foreach($schools as $school): ?>
                                                <option value="<?php //echo $school['sid']; ?>"><?php //echo $school['name']; ?></option>
                                            <?php //endforeach; ?> 
                                        </select>
                                    </div>
                                     <!--<div class="inputBox"><input name="Account[name]" value=" " class="lg" type="text" datatype="*" nullmsg="请输入所在学校！" errormsg="所在学校不能为空！"></div>-->
                                    <!--span class="Validform_checktip" ></span>  
                                    </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="inputTitle">所属年级：</span>
                                    <div class="inputBox">
                                        <select id="school_grade" name="Class[grade]" datatype="*" nullmsg="请选择班级！" errormsg="">
                                            <option value=''>--选择年级--</option>
                                        </select>
                                    </div>
                                    <span class="Validform_checktip" ></span> 
                                </td>
                            </tr-->
<!--                            <tr style=" vertical-align: top;">
                                <td style=" vertical-align: top; " >
                                    <span class="inputTitle">班级介绍：</span>
                                    <div class="inputBox">
                                        <textarea name="Class[info]"  placeholder="介绍一下您的班级吧" style="width: 400px; height: 100px" class=" " type="text" ignore="ignore" datatype="*1-100" nullmsg="" errormsg="班级介绍不能大于100个字！"></textarea>
                                    </div>
                                    <span class="Validform_checktip" ></span> 
                                </td>
                            </tr>-->
                            <tr>
                             <td> 
                                <span class="inputTitle" style="margin-left: 69px;"></span>
                                <a id="submitBtn" href="javascript:;" class="btn btn-raed">下一步</a>
                                <!--<input type="submit" class="btn btn-raed"  value="下一步">--> 
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
    //Validform.int("#formBoxRegister");
    $('#className').keydown(function(){
        $('#tipCheck').removeClass('Validform_wrong').text(''); 
    });
    //判断班级名称是否可用
    $('#className').keyup(function(){
        var cname = $.trim($(this).val());
        var url = $(this).attr("url");
        var sid = $('#schoolId').val();
        if(cname){
            $.ajax({
                url:url,   
                type : 'POST',
                data : {sid:sid,cname:cname},
                dataType : 'json',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {   
                    var show_data =mydata;
                    if(show_data.status=='1'){
                        $('#isOkType').val('0');
                        $('#tipCheck').removeClass('Validform_wrong').addClass('Validform_right').text('通过验证'); 
                    }else{
                       $('#isOkType').val('1');
                        $('#tipCheck').removeClass('Validform_right').addClass('Validform_wrong').text('输入班级名称已存在，请从新输入'); 
                    } 
                },  
                error : function() {  
                    // alert("calc failed");  
                }  
            });
        }
    });
    //提交
    $('#submitBtn').click(function(){
        var cname = $.trim($('#className').val());
        var types = $('#isOkType').val();
        if(cname){
            if(types=='0'){
                $("#formBoxRegister").submit();
            }else{
                $('#tipCheck').removeClass('Validform_right').addClass('Validform_wrong').text('输入班级名称已存在，请从新输入'); 
            }
        }else{
           $('#tipCheck').removeClass('Validform_right').addClass('Validform_wrong').text('请输入班级名称'); 
        }
    });
    
    $("#class_school").change(function(){
        $("#school_grade").html("<option value=''>--选择年级--</option>");
        var sid = $(this).val();
        var url = $(this).attr("rel");
        if(sid){
            $.ajax({  
                url:url,   
                type : 'POST',
                data : {sid:sid},
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {   
                    var show_data =mydata;
                    $("#school_grade").html(show_data); 
                },  
                error : function() {  
                    // alert("calc failed");  
                }  
            });
        }
    });
 
});
</script>
