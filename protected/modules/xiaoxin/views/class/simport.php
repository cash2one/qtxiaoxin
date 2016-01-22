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
               批量添加学生操作.
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box"> 
            <div class="listTopTite bBottom">添加学生</div> 
            <div class="formBox">
                <div class="classTableBox invtesBox"> 
                    <form id="formBoxRegister" action="<?php echo Yii::app()->createUrl('/xiaoxin/class/simport/'.$class->cid);?>?ty=import" method="post">
                        <table class="tableForm" id="tableFormAdd">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="classInfoTitle" >
                                        〓 检查导入信息
                                        </div>
                                        <div class="danwonInfo">根据您提供的文件，本次操作可以成功添加 <span><?php echo $total; ?></span> 名学生</div>
                                        <div class="stList">
                                            <table class="table table-bordered" >
                                                <thead>
                                                    <tr>
                                                        <th>序号</th>
                                                        <th>姓名</th>
                                                        <th>家长手机号</th>
                                                        <th>状态</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($data as $d): ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $d['seque'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $d['name']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $d['mobile']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $d['error'] ? '<span class="icoBox errorIco">'.$d['msg'].'</span>' : '<span class="icoBox succesIco"> </span>'; ?>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td> 
                                </tr> 
                                <tr style="display: none;">
                                    <td>
                                        <div class="classInfoTitle" >
                                        〓 说点什么
                                        </div>
                                    </td>
                                </tr>
                                <tr style="display: none;">
                                    <td>
                                        <div class="inputBox">
                                            <textarea style="width: 486px; height: 98px;" name="desc" maxlength="110" value="欢迎加入<?php echo $class->name; ?>" placeholder="对学生说点什么吧"  datatype="*1-100" nullmsg="信息不能为空！" errormsg="信息不能大于100个字！">欢迎加入<?php echo $class->name; ?></textarea> 
                                        </div>
                                         <span class="Validform_checktip" ></span> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>&nbsp;</p>
                                        <!-- <input class="btn btn-raed" type="submit" value="保  存"> -->
                                        <a href="<?php echo Yii::app()->createUrl('xiaoxin/class/supload?cid='.$class->cid);?>" class="btn btn-default">返回</a>    &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:;" url="<?php echo Yii::app()->createUrl('/xiaoxin/class/simport/'.$class->cid);?>?ty=import" tip="0" id="postBnt" class="btn btn-raed">下一步</a>
                                        <span class="loadingTip" style="display:none; color: #999; margin-left: 15px; " id="addSuccess"><img style="display: inline;" src="<?php echo Yii::app()->request->baseUrl; ?>/image/onLoad.gif">&nbsp;正在导入数据，请稍后...</span>                                        
                                        <!--<a  class="btn btn-raed" href="<?php echo Yii::app()->createUrl('/xiaoxin/class/simport/'.$class->cid);?>?ty=import" >保  存</a>--> 
                                        <!--&nbsp;&nbsp;<a class="btn btn-default" href="<?php echo Yii::app()->createUrl('/xiaoxin/class/supload/'.$class->cid);?>" >返回</a>--> 
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
<div id="inviteBox" class="popupBox" style=" width: 600px;">
    <div class="header">发送邀请 <a href="<?php echo Yii::app()->createUrl('xiaoxin/class/students/'.$class->cid);?>" class="close"  > </a></div>
    <div class="remindInfo">
        <p style=" color: #999; margin-bottom: 5px;">立即为新成员发送短信邀请</p>
        <div id="remindText" class="centent" style="text-indent: 0em;padding: 5px; border: 1px solid #f1f1f1; height: 200px;">
                ****家长你好：我是<?php echo $class->s?$class->s->name:'xxx';?>的<?php echo $userinfo->name;?>老师，我刚在<?php echo SITE_NAME;?>创建了班级，今后日常作业和学校通知都通过该平台发放。请您免费下载使用<?php echo SITE_NAME;?>接收信息、跟其他家长交流。系统为您配置的账号是：*********，初始密码：******。下载地址：<?php echo SITE_APP_DOWNLOAD_SHORT_URL;?>
        </div>
    </div>
    <div class="popupBtn">
        <a id="delayPostBtn" href="<?php echo Yii::app()->createUrl('xiaoxin/class/students/'.$class->cid);?>" class="btn btn-raed">稍后发送</a>
        <a id="isPostBnts" href="javascript:void(0);" url="<?php echo Yii::app()->createUrl('xiaoxin/class/sendpwd/');?>" cid ="<?php echo $class->cid;?>"  class="btn btn-raed">发送邀请</a>&nbsp;&nbsp;&nbsp;
    </div>
</div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {

    //邀请操作
    $('#isPostBnts').click(function(){
        var url = $(this).attr('url');
        var cid = $(this).attr('cid');
        $.ajax({  
            url:url,   
            type : 'POST', 
            data:{cid:cid,importType:'1'},
            dataType : 'json',              
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {
                var data =mydata;  
                 if(data.status=="1"){
                    var urlstr = '<?php echo Yii::app()->createUrl('xiaoxin/class/students/'.$class->cid);?>';
                    window.location.href = urlstr;
                }
            },  
            error : function() { 
                //str = "系统繁忙,请稍后再试";
            }  
        }); 
    });
    
    //完成添加操作
    $('#postBnt').click(function(){
        var url =$(this).attr('url');
        var tip =$(this).attr('tip');
        $(".loadingTip").show();
        if(tip=='0'){ 
            $(this).attr('tip','1');
            $.ajax({  
                url:url,   
                type : 'POST', 
                dataType : 'json',              
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {
                    var data =mydata; 
                    var urlstr = data.url; 
                    if(data.status=="1"){           
                        $("#addSuccess").text('已成功导入!');
                        showPromptPush('#inviteBox');
                        //$(".loadingTip").hide(); 
                    }else{
                        window.location.href = mydata.url;                        
                    }
                },  
                error : function() { 
                    //str = "系统繁忙,请稍后再试";
                }  
            });
        }
    });

        //表单验证控件
    Validform.int("#formBoxRegister");


});
</script>
