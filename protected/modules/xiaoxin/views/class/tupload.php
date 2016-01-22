<div class="header">
<!--    <div class="headBox fright">
        <div class="headNav">
            <ul>
               <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/view/'.$class->cid);?>">首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/teachers/'.$class->cid);?>" class="focus">成员</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/update/'.$class->cid);?>">设置</a></li>
            </ul>
        </div>  
    </div>-->
    <div class="titleText"><em class="inIco17"></em>我的班级 > <?php echo $class->name; ?></div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
               批量添加老师操作.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box"> 
            <div class="listTopTite bBottom">添加老师</div> 
            <div class="formBox">
                <div class="classTableBox invtesBox"> 
                    <form id="formBoxRegister" action="<?php echo Yii::app()->createUrl('/xiaoxin/class/tcheck/'.$class->cid);?>" method="post">
                        
                        <table class="tableForm" id="tableFormAdd">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="classInfoTitle">
                                            〓 编写Excel电子表格 
                                        </div>
                                        <div class="danwonInfo">将通讯录按照模板（<a href="<?php echo  Yii::app()->request->baseUrl.'/template'.'/批量邀请老师模版.xls';?>">下载模板</a>）进行整理，保存后上传Excel文件（xls）即可。</div>
                                        <!--<img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/ecxelErpIco.png">-->
                                    </td> 
                                </tr> 
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="tableForm">
                            <tbody> 
                                <tr>
                                    <td>
                                        <div class="classInfoTitle bTop" style="padding-top:10px; line-height: 40px; height: 40px;  ">
                                        〓 选择Excel文件上传
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td> 
                                        <div id="filePopule" class="" style="display:inline;"><input id="fileExcle" style="display:inline;" class="file" name="upload_students" multiple="true"></div>
                                        <div id="fileNameK" class="PopFile">未选择文件</div> 
                                        <p>&nbsp;</p>
                                        <span class="Validform_checktip Validform_wrong fileFormTip" style="display: none">上传的文件没有数据或数据格式不正确，请在模板中重新编辑后再上传</span>
                                        <span id="upFileLoading" class="Validform_checktip Validform_loading" style="display: none" > 正在上传文件...</span> 
                                        <div id="upFileInt" class="Validform_checktip Validform_wrong" style="display: none; clear: both; margin-top: 10px; " >该浏览器没有安装flash插件,导致文件上传功能不可用，请安装flash插件或换浏览器</div> 
                                        <div id="upFileNext"class="Validform_checktip Validform_wrong"  style="display: none; background: none; padding-left: 0; clear: both;">点击下一步上传文件，进行下一步操作</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>&nbsp;</p>
                                        <a rel="sendBtn" href="javascript:void(0);" class="btn btn-raed">预览名单</a>
                                        &nbsp;&nbsp;
<!--                                        <a class="btn btn-default" href="<?php echo Yii::app()->createUrl('/xiaoxin/class/students/'.$class->cid);?>" >返回</a> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div> 
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/uploadify/uploadify.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/uploadify/jquery.uploadify.min.js?ver=<?php echo rand(0,9999);?>" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
   //表单验证控件
    Validform.int("#formBoxRegister");
    var fileSiz=0,sname="";
    //file上传 控件
    var userid = "<?php echo Yii::app()->user->id; ?>";
    var url = "<?php echo Yii::app()->createUrl('/xiaoxin/class/tcheck?cid='.$class->cid);?>&uid="+userid;
    $("#fileExcle").uploadify({ 
        'height'        :'32',
        'width'         :'100',
        'removeTimeout' : 0,
        'overrideEvents':['onUploadProgress'],
        'buttonImage' : '<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/feilBtnBg1.jpg',
        'buttonText'    : '选择Excel文件 ', 
        'fileSizeLimit'     : '10MB', 
        'fileTypeExts'      : '*.xls', 
        'swf'           : '<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/uploadify/uploadify.swf',
        'uploader'      : url,
        'folder'        : '<?php echo Yii::app()->request->baseUrl; ?>/storage/uploads',
        'removeCompleted': true,
        'debug':false,
        'auto': false,
        'onInit'   : function(instance) {
            $('#upFileInt').hide();
            $("#filePopule").show();
        },
        'onUploadSuccess':function(file, data, response){ 
            $("#file_upload_tmp").val(data);
            $("#upFileNext").text('').hide();
            $('#upFileLoading').hide();
            if(data=='0'){
                $('.fileFormTip').show();
            }else{
                window.location="<?php echo Yii::app()->createUrl('xiaoxin/class/timport/'.$class->cid);?>";
            }
        }, 
        'onUploadStart' : function(file){ 
            $('#upFileLoading').show();
        }, 
        'onSelect' : function(file) { 
            if(sname==file.name){ 
            }else{
               if(fileSiz!=0){
                 $('#fileExcle').uploadify('cancel','SWFUpload_0_'+fileSiz-1); 
                }
                sname=file.name;
            } 
            $("#fileNameK").text('').append('<span>'+file.name+'</span>');
            $('.fileFormTip').hide(); 
            $("#upFileNext").text('点击预览名单上传文件，进行下一步操作').show();
             fileSiz++;
        },
        'onUploadError' : function(file, errorCode, errorMsg, errorString) {
            //alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
            $('#upFileLoading').hide();
            
        } 
    });
    //提交文件
    $('[rel=sendBtn]').click(function(){ 
        $("#upFileNext").hide(); 
        if(fileSiz>0){
            $('#fileExcle').uploadify('upload','*');  
        }else{
            $("#upFileNext").text('请先选择上传文件').show();
        } 
    });
});
</script>

