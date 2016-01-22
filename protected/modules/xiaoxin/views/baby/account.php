<div class="header"> 
    <div class="headBox fright">
        <div class="headNav">
            <ul> 
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/baby/account/'.$student->userid);?>" class="focus">首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/group/'.$student->userid);?>" >班级</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/parent/'.$student->userid);?>">家长</a></li>
            </ul>
        </div>  
</div>
<div class="titleText"><em></em>我的孩子 > <?php echo $student->name; ?></div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
                点亮徽标,可以将功能添加到快捷功能列表中，方便您的使用.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox account">
        <div class="box" style="padding-top:10px;"> 
            <div class="formBox">
                <form id="formBoxRegister" action="" method="post">
                    <table class="tableForm">
                        <tbody> 
                        <tr>
                            <td>
                                <div class="userPic fleft ">
                                    <img width="60px;" height="60px;" src="<?php echo property_exists($ext,'photo')&&$ext->photo? $ext->photo:Yii::app()->request->baseUrl.$default ; ?>" />
                                </div>
                                <div class="userBtnBox">
                                 <!--    <p>你可以选择一张png/jpg图片（180*180）作为头像</p>
                                    <div id="filePopule">
                                        <input type="file" name="Account[phototmp]" id="fileUserPic" class="btn" value="相册选择">
                                    </div> -->
                                    <input type="hidden" name="Account[photo]" id="file_upload_tmp" value=''>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><div class="title">基本信息</div></td>
                        </tr>
                        <tr>
                            <td>
                                <span class="inputTitle">姓 名：</span>
                                <div class="inputBox"><input name="Account[name]" value="<?php echo $student->name; ?>" class="medium" type="text" datatype="*1-8" nullmsg="请输入您的姓名！" errormsg="姓名不能大于8个字！"></div>
                                <span class="Validform_checktip" ></span>  
                                <div class="info" style="display: none;">姓名不能大于8个字<span class="dec"><s class="dec1">◆</s><s class="dec2">◆</s></span></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="inputTitle">学 号：</span>
                                <div class="inputBox"> <?php echo $studentid;?></div>
                            </td>
                        </tr>
                        <tr> 
                            <td><span class="inputTitle" style=" *float: left; *margin-top: 8px;">性 别：</span> 
                                <div class="btn-group" style=" ">
                                    <button rel="btnRadioSex" type="button" class="btn <?php echo $student->sex==1?'btn-raed':'btn-default'; ?>" uid="1">男</button> 
                                    <button rel="btnRadioSex" type="button" class="btn <?php echo $student->sex==2?'btn-raed':'btn-default'; ?>" uid="2">女</button>
                                </div>
                                <input rel="radioSex" type="hidden" name="Account[sex]" value="<?php echo $student->sex; ?>"> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="inputTitle">出生日期：</span>
                                <div class="inputBox"><input class="detaTmie hidden"  name="Account[birthday]" value="<?php echo property_exists($ext,'birthday')?$ext->birthday:''; ?>" class="medium" type="text" nullmsg="请输入您的出生日期！"></div>
                                 <span class="Validform_checktip" ></span>  
                            </td>
                        </tr> 
                        <tr>
                            <td>
                                <span class="inputTitle">称 谓：</span>
                                <div class="inputBox"><input  name="Account[role]" placeholder="请输入与孩子的关系" maxlength="10" class="medium" type="text" ignore="ignore" value="<?php echo $guardian?$guardian->role:'家长';?>" datatype="*1-10" errormsg="称谓不能大于10个字！"></div>
                                <span class="Validform_checktip" ></span> 
                            </td>
                        </tr> 
                        <tr>
                            <td>
                                <div class="btnBorder">
                                    <input type="submit" class="btn btn-raed"  value=" 保 存 ">
                                </div>
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
<!--<link href="<?php //echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/uploadify/uploadify.css" rel="stylesheet" type="text/css"/>
<script src="<?php //echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/uploadify/jquery.uploadify.min.js?ver=<?php //echo rand(0,9999);?>" type="text/javascript"></script>-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/dateTmie.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
   //表单验证控件
    Validform.int("#formBoxRegister");
    //日期控件
    $(".detaTmie").sjSelect(); 
    
    //上传图片 控件
    // $("#fileUserPic").uploadify({
    //     'height'        :'31',
    //     'width'         :'100', 
    //     'buttonText'    : '相册上传 ', 
    //     'fileSizeLimit'     : '10240KB',
    //     'fileTypeExts'       : '*.jpg;*.png', 
    //     'swf'           : '<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/uploadify/uploadify.swf',
    //     'uploader'      : '<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/uploadify/uploadify.php',
    //     'folder'        : '<?php echo Yii::app()->request->baseUrl; ?>/uploads',
    //     'formData' : { '<?php echo session_name();?>' : '<?php echo session_id();?>' },
    //     'auto'          : true,
    //     'onUploadSuccess':function(file, data, response){
    //         $("#file_upload_tmp").val(data);
    //          var img ='<img width="60px;" height="60px;" src="'+data+ '" />';
    //          $(".userPic").empty().append(img); 
    //     }

    //     // 'onAllComplete' : function(event,data) {
    //     //     alert(data.filesUploaded + ' files uploaded successfully!');
    //     // }

    // });
    $('[rel=btnRadioSex]').click(function(){
        var uid =$(this).attr('uid');
        $('[rel=btnRadioSex]').removeClass('btn-raed').addClass('btn-default');
        $(this).addClass('btn-raed');
        $('input[rel=radioSex]').val(uid);
         
    });
});
</script>

    