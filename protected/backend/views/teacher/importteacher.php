<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/ajaxfileupload.js"></script>
<div class="box">
    <div class="form tableBox">
        <form id="business-form" method="post" action="<?php echo Yii::app()->createUrl("teacher/saveexcel");?>">
        <table class="tableForm">
            <thead></thead>
            <tbody> 
                
                <tr>
                    <td class="td_label">学 校* ：</td>
                    <td>
                        <div style="display: inline;"> 
                             <select id="schoolId" name=" " datatype="*" nullmsg="请选择学校！">
                                 <option value=''>全部</option>
                                 <?php if(is_array($schools)) foreach($schools as $k=>$val):?>
                                 <option value='<?php echo $k;?>'><?php echo $val;?></option>
                                 <?php endforeach;?> 
		                    </select>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 
                </tr>
                <tr>
                    <td class="td_label"></td>
                    <td>
                        <div  class="createBox" style="display:none; height: 420px; overflow-x:hidden; overflow-y:hidden;">
                            <table class="tableForm">
                               <thead></thead>
                               <tbody>
                                   <tr>
                                       <td>
                                            <div class="fileBox box_file" style="display: inline;" >
                                               <input id="fileXls" class="file" nullmsg="请上传文件！"  errormsg=""  name="batchfile" rel="fileName" type="file" onchange="addfile(this)" datatype="*" >
                                                 批量导入 
                                           </div>
                                           <span id="Validform_file"  class="Validform_checktip ">&nbsp;&nbsp;<a  href="<?php echo Yii::app()->request->baseUrl.'/template/老师导入模板.xls'; ?>">下载格式模版 </a></span>
                                           <input type="hidden" id="fileChecktip" value="0" /> 
                                       </td>
                                       <td> 
                                       </td>
                                   </tr>
                                   <tr>
                                       <td class="fileNamebox" style=" padding-top: 15px; display: none;">
                                           <span id="upfileloading" class="Validform_checktip Validform_loading" >正在验证数据...</span>
                                           <div id="result"></div>
                                       </td>
                                       <td> 
                                       </td>
                                   </tr>
                                   <tr class="msghmmTr" style="display: none;">
                                       <td ><div style="padding-left: 30px;">
                                               <input id="msghmm" type="checkbox" name="issendpwd"  value="1" style="margin-right:5px;">

                                               <label style="margin-top: 0px;" for="msghmm">发送账号密码通知短信</label></div></td>
                                       <td></td> 
                                   </tr>
                                   <tr class="msghmmCentenTr" style="display: none;">
                                       <td >
                                           短信内容：
                                           <textarea maxlength="280" style="color: #606060" name="smscontent">你好！感谢您使用<?php echo SITE_NAME;?>（<?php echo SITE_URL;?>）,平台有家校沟通丶成绩管理等功能。您的账号:[xxxxxxxxxxx]，密码:[xxxxxx]。客服电话:4001013838，工作时间:08:00-20:00
                                               </textarea>
                                           <p style="margin-left:70px;">(请不要删除xxxxxx占位符，否则用户收不到登录帐号和密码)</p>
                                       </td>
                                       <td></td>
                                   </tr>
                                </tbody>
                               <tfoot> 
                               </tfoot>
                           </table>
                        </div> 
                    </td>
                </tr>
            </tbody>
            <tfoot></tfoot>
        </table>  
        <table class="tableForm">
            <thead></thead>
            <tbody>
                <tr>
                    <td class="td_label"></td>
                    <td>
                        <p style="height: 30px;"></p> 
                        <a href="javascript:void(0);" class="btn btn-primary" rel="postFrom"><?php //if($model->isNewRecord){ echo '确  定'; }else {echo '保 存';}?>确 定</a>
                        <input type="hidden" name="schoolid" id="schoolid_hidden" value="">
                         
                    </td> 
                </tr>
            </tbody>
            <tfoot></tfoot>
        </table> 
    </form>
    </div><!-- form --> 
 </div>
<script type="text/javascript"> 
var Valid = $('#business-form').Validform({//表单验证
    tiptype:2,
    showAllError:true,
    ignoreHidden:true,
    postonce:true,
    datatype:{//传入自定义datatype类型 ; 
        "tel-3" : /^(\d{3,4}-)?\d{7,8}$/,
        "car"   : /^[0-9a-zA-Z]{1,15}$/,
        "nZ"    : /^(0|[1-9][0-9]*)$/
    },
    callback:function(data){ 
        //if($('#rightOrWrong').val()== '0'){
           // return false;
        //}else{ 
           // if($('#usefullInput').val()=="1"){ 
               //alert("请重新选择有效数据文件上传！");
              // return false; 
            //}else{ 
              //$('[rel=postFrom]').attr('disabled','disabled');
               // return true;
           // } 
        //}
    }
}); 

//提示
$('#schoolId').change(function(){
    var Val = $(this).find('option:selected').val(); 
    if(Val!=""){
          $('.createBox').show();
    }else{
        $('.createBox').hide();
    } 
});
 
//文件上传  
function ajaxFileUpload(){
    var schoolid=$("#schoolId").val();
    if(parseInt(schoolid)<1){
        //提示选学校
        return;
    }
    var uid="<?php echo Yii::app()->user->id;?>";
    var ajaxurlUpload = '<?php echo Yii::app()->createUrl('/teacher/importteacher');?>'+'?schoolid='+schoolid;
    $('#result').empty();
    $.ajaxFileUpload({
        url:ajaxurlUpload ,//需要链接到服务器地址
        secureuri:false,
        fileElementId:'fileXls',//文件选择框的id属性
        dataType: 'text', //服务器返回的格式，可以是json
        success: function (data, status) { //相当于java中try语句块的用法
            var arr=JSON.parse(data);
            if(arr.status=='1'){ //成功
                var errNum= $.trim(arr.errNum);
                var mobiles=arr.mobiles;
                var mobileserr=arr.mobileserr;
                var dutys=arr.dutys;
                var names=arr.names;
                var repeats=arr.repeats;
                var shmtl='<a id="fileName" class="fileIoc" href="javascript:void(0);">'+arr.filename+' </a>  一共：'+
                    (arr.total)+' 条数据，'+arr.validnum+' 条符合，<span class="remind" style="color: red;">'
                    +(arr.total-arr.validnum)+' 条无效。</span>';
                if(mobileserr.length>0){
                    shmtl+="<p style='padding-left: 30px;'>手机格式错误行："+mobileserr.join("，")+"</p>";
                }
                if(mobiles.length>0){
                    shmtl+="<p style='padding-left: 30px;'>手机号已存在行："+mobiles.join("，")+"</p>";
                }
                if(dutys.length>0){
                    shmtl+="<p style='padding-left: 30px;'>职务不存在行："+dutys.join("，")+"</p>";
                }
                if(names.length>0){
                    shmtl+="<p style='padding-left: 30px;'>姓名为空行："+names.join("，")+"</p>";
                }
                if(repeats.length>0){
                    shmtl+="<p style='padding-left: 30px;'>手机重复行："+repeats.join("，")+"</p>";
                }
                   // +'</span>';
                $('#result').html(shmtl);
                $("#fileChecktip").val(1);
                $('#upfileloading').hide();
                $('[rel=postFrom]').removeAttr('disabled');
                $("#schoolid_hidden").val($("#schoolId").val());
                if(arr.validnum>0){
                    $(".msghmmTr").show();
                } 
            }else{  //失败
                $('#result').html("上传失败了,请联系系统管理员");
            } 
        },
        error: function (data, status, e) {//相当于java中catch语句块的用法 
            $('#result').html("上传出错！");
            $('#upfileloading').hide();
            $('[rel=postFrom]').removeAttr('disabled');
        }
    }); 
}
//预览文件
function addfile(file){  
        var size = file.size / 1024;
        if(size>10){
            alert("附件不能大于10M");
        }else{ 
            var filepath = file.value;  
            var re = /(\\+)/g; 
            var filename = filepath.replace(re,"#"); 
            var one=filename.split("#"); 
            var two=one[one.length-1]; 
            var three=two.split("."); 
            var last=three[three.length-1]; 
            var tp ="xls,xlsx";
            var rs=tp.indexOf(last); 
            if(rs>=0){
                if (file.files && file.files[0]){
                    $("#Validform_filed").hide();
                    ajaxFileUpload();
                    $('.fileNamebox').show();
                    $('#upfileloading').show();
                    $('[rel=postFrom]').attr('disabled','disabled');
                }else {  
                    //prevDiv.innerHTML = perHtml; 
                }
            }else{
                file.value = '';
                //prevDiv.innerHTML = perHtml;
                alert("您选择的上传文件不是有效的excel文件！");
                return false;
            }
        } 
}
//ie判断 文件上传方式
if ((navigator.userAgent.indexOf('MSIE') >= 0)){  
     $(".box_file").empty();
     $(".box_file").removeClass('fileBox');
     $('.box_file').append('<input id="fileXls" rel="fileName" nullmsg="请上传文件！"  errormsg="" name="batchfile" style="width:auto;" type="file" onchange="addfile(this)" datatype="*">');
}
//发消息
$('#msghmm').change(function(){
    var msgCehek = $(this).attr("checked");
    if(msgCehek=="checked"){
       $(".msghmmCentenTr").show(); 
    }else{
      $(".msghmmCentenTr").hide();  
    }
});
 
//表单提交
$('[rel=postFrom]').click(function(){
    if($("#fileChecktip").val()=='1'){
         Valid.ignore("#fileXls");  
    }else{
         Valid.unignore("#fileXls"); 
         $("#Validform_filed").show(); 
    }
    Valid.resetStatus(); 
    $("#business-form").submit(); 
});
 
</script>