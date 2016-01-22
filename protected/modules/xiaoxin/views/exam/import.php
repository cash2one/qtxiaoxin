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
    <div class="titleText"><em class="inIco13"></em>日常工作 > <span> 成绩管理 > </span> <span><?php echo $examInfo['name'];?></span></div>
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
    <div id="contentBox" class="contentBox">
        <div class="box">
            <div class="headBox ">
                <div class="headNav noticeType_select">
                    <ul>
                        <li><a avalue="1" href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit'). '/' . $id."?isEdit=1"; ?>"  >成绩录入</a></li>
                        <li><a avalue="2" href="<?php echo Yii::app()->createUrl('xiaoxin/exam/scheck'). '?id=' . $id ;?>" class="focus">模版导入</a></li>
                    </ul>
                </div>
            </div>
            <div class="formBox" style="padding: 0 15px;">
                <div class="classTableBox invtesBox">
                    <form id="formBoxRegister" action="" method="post" enctype="multipart/form-data">
                        <table class="tableForm" id="tableFormAdd">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="classInfoTitle">
                                            〓 导入成绩单
                                        </div>
                                        <div class="danwonInfo">将成绩单按照模板（<a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit'.'/'.$id.'?isExport=1');?>">下载模板</a>）进行整理，保存后上传Excel文件（xls）即可。</div>
                                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/ecxelErpIcoExam.png">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="tableForm">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="classInfoTitle " style="padding-top:10px; line-height: 40px; height: 40px;  ">
                                        〓 选择Excel文件上传
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div id="filePopule" class="" style="display:inline;"><input id="fileExcle" style="display:inline;" class="file" name="upload_students" multiple="true"></div>
                                        <div id="fileNameK" class="PopFile">未选择文件</div>
                                        <p>&nbsp;</p>
                                        <span class="Validform_checktip Validform_wrong fileFormTip" style="display: none">上传的文件没有数据或数据格式不正确，请重新下载模板编辑后再上传</span>
                                        <span id="upFileLoading" class="Validform_checktip Validform_loading" style="display: none" > 正在上传文件...</span>
                                        <div id="upFileInt" class="Validform_checktip Validform_wrong" style=" clear: both; margin-top: 10px; " >该浏览器没有安装flash插件,导致文件上传功能不可用，请安装flash插件或换浏览器</div>
                                        <div id="upFileNext"class="Validform_checktip Validform_wrong"  style="display: none; background: none; padding-left: 0; clear: both;">点击下一步上传文件，进行下一步操作</div>
                                        <div id="upFileError"class="Validform_checktip Validform_wrong"  style="display: none; background: none; padding-left: 0; clear: both;">系统繁忙，请稍候上传...</div>
                                        <div id="upFileError1"class="Validform_checktip Validform_wrong"  style="display: none; background: none; padding-left: 0; clear: both;">系统繁忙，请稍候上传...</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>&nbsp;</p>
                                        <a rel="sendBtn" style="display: none;" href="<?php echo Yii::app()->createUrl('/xiaoxin/exam/saveexcel/').'?id='.$id;?>" class="btn btn-raed"> &nbsp;&nbsp;导入&nbsp;&nbsp; </a>
                                        &nbsp;&nbsp;
<!--                                        <a class="btn btn-default" href="<?php //echo Yii::app()->createUrl('/xiaoxin/exam/saveexcel/').'?id='.$id;?>" >返回</a> -->
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

<script type="text/javascript">
$(function() {
    $("#menuListBoxs li a[href*='exam']").addClass("focus");
   //表单验证控件
    //Validform.int("#formBoxRegister");
    var fileSiz=0,sname="";
    //file上传 控件
    var userid = "<?php echo Yii::app()->user->id; ?>";
    var url = "<?php echo Yii::app()->createUrl('/ajax/scheck/?id='.$examInfo['eid']).'&uid=';?>"+userid;

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
        'folder'        : '<?php echo Yii::app()->request->baseUrl; ?>/storage',
        'removeCompleted': true,
        'debug':false,
        'auto': true,
        'onInit'   : function(instance) {
            $('#upFileInt').hide();
            $("#filePopule").show();
        },
        'onUploadSuccess':function(file, data, response){
            //$("#file_upload_tmp").val(data);
            $("#upFileNext").text('').hide();
            $('#upFileLoading').hide();
            //console.log(data);
            var datas = $.parseJSON(data);
            if(datas.status=='1'){
                $("#upFileNext").text('点击导入上传文件，进行下一步操作').show();
                $('[rel=sendBtn]').show();
            }else if(datas.status=='3'){
                $('.fileFormTip').text(datas.msg).show();
            }else{ 
               $('#upFileError').text(datas.msg).show(); 
            }
        },
        'onUploadStart' : function(file){
            $('#upFileLoading').show();
        },
        'onSelect' : function(file) {
             $('#upFileError').text('').hide();
             $('#upFileError1').hide();
             $('[rel=sendBtn]').hide();
            if(sname==file.name){
            }else{
               if(fileSiz!=0){
                 //$('#fileExcle').uploadify('cancel','SWFUpload_0_'+fileSiz-1);
                }
                sname=file.name;
            }
            $("#fileNameK").text('').append('<span>'+file.name+'</span>');
            $('.fileFormTip').hide();
            //$("#upFileNext").text('点击导入上传文件，进行下一步操作').show();
             fileSiz++;
        },
        'onUploadError' : function(file, errorCode, errorMsg, errorString) { 
            $('#upFileLoading').hide(); 
            $('#upFileError1').show();
        }
    });
    //提交文件
    //$('[rel=sendBtn]').click(function(){
       // $("#upFileNext").hide();
        //if(fileSiz>0){
        //    $('#fileExcle').uploadify('upload','*');
       // }else{
         //   $("#upFileNext").text('请先选择上传文件').show();
        //}
    //});
});
</script>

