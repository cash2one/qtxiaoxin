<style>
    #message,.message{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; right: 20px; bottom:0px; display: none; z-index: 10000; border-radius: 5px;}
    #message .messageType,.message .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message .success,.message .success{  border: 1px solid #fbeed5; background-color: #e95b5f; color: #fbe4e5; }
    #message .error,.message .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
    .table td select{ width: 81px; }
</style>
<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>
    <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
       <thead>
         <tr style="background-color: #e8e8e8;">
             <th width="80px"><input type="checkbox" id="checkAll">&nbsp;&nbsp;全选</th>
             <th width="20%">姓名</th>
             <th width="15%">监护人手机</th>
             <th width="20%">班级(学校)</th>
             <th width="15%">创建时间</th>
             <th>操作</th>
         </tr>  
       </thead>
       <tbody> 
       <?php if (count($students['list'])): ?>
       <?php foreach ($students['list'] as $student): ?>
             <tr> 
                <td class="checkSub"><input value="<?php echo $student['userid'];?>" type="checkbox"></td>
                <td><?php echo $student['name'];?></td>
                <td>
                    <?php $mobile=is_array($student['mobilephone'])?$student['mobilephone']:array();?>
                    <div class="partSelectP partSelectS" >
                        <span style=" padding-left: 25px;" class="<?php echo count($mobile)&&$mobile[0]['client']?'client':'';?>"><?php echo count($mobile)?$mobile[0]['mobilephone']:'';?></span>
                        <?php if(!empty($mobile)):?>
                		<span class='partSelectIcon' tid="0"></span>  
						<div class="partSelect">
							<div class="partSelectSub">
								<span class="navIcoTop"></span>
							</div> 
                            <ul class="mobileList">
                                <?php foreach($mobile as $v):?>
                                <li><a href="/xiaoxin/default/remote?identity=4&plant=backend&userid=<?php echo $v['userid'] ?>" target="_blank" style=" padding-left: 25px;" class="<?php echo  $v['client']?'client':''?>"><?php echo ($v['role']?$v['role']:'家长').'&nbsp;&nbsp;'. $v['mobilephone'];?></a><a rel="setPwd" href="javascript:void(0);" url="<?php echo Yii::app()->createUrl("student/initpwd/")?>?userid=<?php echo $v['userid']; ?>"> 重置密码</a></li>
                                <?php endforeach;?>
                            </ul>
						</div>
                        <?php endif;?>
					</div> 
                </td>
                <td>

                	<div class="partSelectP" >
                        <?php echo !empty($student['currentSchoolName'])?($student['currentClassName']."&nbsp;&nbsp;(".$student['currentSchoolName'].")"):'';?>
                        <?php if($student['classNum']>1):?>
                		<span class='partSelectIcon'></span> 
						<div class="partSelect">
							<div class="partSelectSub">
								<span class="navIcoTop"></span>
							</div>
							<div class="box">
                               <?php foreach($student['classArr'] as $kk=>$vv):?>
                                   <?php echo !empty($vv['schoolname'])? ($vv['classname']."&nbsp;&nbsp;(".$vv['schoolname'].")</br>"):'';?>
                                <?php endforeach;?>
                            </div>
						</div>
                        <?php endif;?>
					</div>
                </td>
                <td><?php echo substr($student['creationtime'],0,16);?></td>
                <td>
                    <a href="<?php echo Yii::app()->createUrl('student/update/'.$student['userid']);?>">编辑</a>
                    &nbsp;&nbsp;
                    <a rel="deleLink" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('student/delete').'?ids='.$student['userid'];?>" >删除</a>
                </td> 
            </tr>

           <?php endforeach; ?>
           <?php else: ?>
            <tr>
                <td colspan="6" align="center" style=" font-size: 21px; padding: 100px 0;">
                    暂无数据
                </td> 
            </tr>
            <?php endif;?>
       </tbody>
    </table>
        <div class="batchOperation clearfix" style="float:left;">
             <a href="javascript:;" class="btn btn-primary" style="margin-right:10px;" rel="checkDel">批量删除</a>
             <a href="javascript:;" class="btn btn-primary" rel="batchPass">批量重置密码</a>
             <span class="Validform_checktip " id="batchTip" style="display:none;"><span class="Validform_checktip Validform_wrong" >请勾选列表！</span> </span>
        </div>
        <div id="pager" style="  margin-top: 30px;">
            <?php
            $this->widget('CLinkPager',array(
                    'header'=>'',
                    'firstPageLabel' => '首页',
                    'lastPageLabel' => '末页',
                    'prevPageLabel' => '上一页',
                    'nextPageLabel' => '下一页',
                    'pages' => $students['pages'],
                    'maxButtonCount'=>9
                )
            );
            ?>
        </div>
    </div>
</div>
<div id="popupBox" class="popupBox"> 
    <div id="popupInfo" style="padding: 30px;"> 
        <div class="centent">温馨提示：是否删除当前学生？</div>
  </div>
    <div style="text-align: center;">
        <a id="isOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
    </div>
</div>

<div id="checkAllBox" class="popupBox">
    <div id="popupInfo" style="padding: 30px;">
        <div class="centent">温馨提示：是否批量删除学生？</div>
    </div>
    <div style="text-align: center;">
        <a id="delOk" href="javascript:;" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#checkAllBox');" class="btn btn-default">取消</a>
    </div>
</div>

<div id="popupBoxRset" class="popupBox">
    <div id="popupInfo" style="padding: 30px;">
        <div class="centent">温馨提示：是否重置密码？</div>
    </div>
    <div style="text-align: center;">
        <a id="isSetPwd" href="javascript:void(0);" url="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBoxRset');" class="btn btn-default">取消</a>
    </div>
</div>

<div id="batchBox" class="popupBox">
    <div id="popupInfo" style="padding: 30px;">
        <div class="centent">温馨提示：是否批量重置密码？</div>
    </div>
    <div style="text-align: center;">
        <a id="batchOk" href="javascript:;" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#batchBox');" class="btn btn-default">取消</a>
    </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/selectautocomplete.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
<script type="text/javascript"> 
$(function() { 
    var grade="";
    var sid="";
    if(grade){
        $("#grade").val(grade);
    }
    if(sid){
        $("#selectsid").val(sid);
    }
    //删除提醒
    $('[rel=deleLink] ').click(function(){
        var urls = $(this).data('href');
        $("#isOk").attr('href',urls);
        showPromptsIfonWeb('#popupBox');
    });
       //重置密码
        $('[rel=setPwd] ').click(function () {
            var urls = $(this).attr('url');
            $("#isSetPwd").attr('url', urls);
            showPromptsIfonWeb('#popupBoxRset');
        });
     //批量删除
        $('[rel=checkDel] ').click(function () {
            var str=[],
            inputCheckedNum=$('.checkSub').find('input:checked').length;
            if (inputCheckedNum != 0) {
                 $('.checkSub').find('input').each(function(index, el) {
                    var val=$(el).val();
                    if ($(el).is(':checked')) {
                        str.push(val);
                    };
                });
                str=str.join(',');
                var urls ="<?php echo Yii::app()->createUrl('student/delete')?>?ids="+str;
                $("#delOk").attr('href', urls);
                showPromptsIfonWeb('#checkAllBox');
            }else{
               $('#batchTip').show();
            };
           
        });

        //批量重置密码
        $('[rel=batchPass]').click(function(event) {
            var str=[],
            inputCheckedNum=$('.checkSub').find('input:checked').length;
            if (inputCheckedNum != 0) {
                 $('.checkSub').find('input').each(function(index, el) {
                    var val=$(el).val();
                    if ($(el).is(':checked')) {
                        str.push(val);
                    };
                });
                str=str.join(',');
                var urls ="<?php echo Yii::app()->createUrl('student/initpwd')?>?ids="+str;
                $("#batchOk").attr('data-href', urls);
                showPromptsIfonWeb('#batchBox');
            }else{
                 $('#batchTip').show();
            };
        });
        $("#batchOk").click(function(event) {
            $("#message,.message").remove();
            var urls=$(this).data('href');
             $.getJSON(urls,{},function(data){
                if(data&&data.msg=='success'){
                    var tishi = '<div class="message"><div class="messageType success" id="type-success"><span >✔</span>&nbsp;&nbsp;密码已重置成功</div></div>';
                    $('body').append(tishi);
                }else{
                    var tishi = '<div class="message"><div class="messageType success" id="type-success"><span >✔</span>&nbsp;&nbsp;密码重置失败</div></div>';
                    $('body').append(tishi);
                }
                $('.message').show();
                setTimeout( function() { $('.message').slideUp("slow");},3000); 
                hidePormptMaskWeb('#batchBox');
            })
        });
         //全选和不选
        $('#checkAll').click(function(event) {
            var _left=$(this);
            if (_left.is(':checked')) {
                $('.checkSub').find('input').attr('checked','checked');
                $('#batchTip').hide();
            }else{
                $('.checkSub').find('input').removeAttr('checked')
            };
        });

        $('.checkSub').on('click', 'input', function(event) {
             var inputNum=$('.checkSub').find('input').length,
                 inputCheckedNum=$('.checkSub').find('input:checked').length;
            if (inputCheckedNum == inputNum) {
                $('#checkAll').attr('checked','checked');
            }else{
                $('#checkAll').removeAttr('checked');
            };
            if(inputCheckedNum !=0){
                 $('#batchTip').hide();
            }

        });

    //年级联动
    $("#selectsid").change(function(){
        var datas = $(this).val();
        var url = $(this).attr('url');
        var selectid = $(this).attr('selectid');
        var option ='<option value="">全部</option>';
        if (datas) {  
            $.getJSON(url,{sid:datas,class:1},function(mydata) {
                if(mydata&&mydata.classs){
                    $.each(mydata.classs,function(i,v){
                        option=option+'<option value="'+i+'">'+v+'</option>';
                    });
                }
                $("#"+selectid).html(option);
            });
         }else{
             $("#"+selectid).html(option);
         }   
    }); 
    //提示框
    $('.partSelectIcon').click(function() {
        var tid = $(this).attr('tid');
        if(tid=="0"){
            $(this).parent('.partSelectS').addClass('partSelectPHigh');
             $('.partSelectIcon').next().hide();
             $('.partSelectIcon').attr('tid','0');
            $(this).next().show();
            $(this).attr('tid','1');
        }else{
            $(this).parent('.partSelectS').removeClass('partSelectPHigh');
            $(this).next().hide();
            $(this).attr('tid','0');
        } 
    });
    clickTarget('span.partSelectIcon',$('.partSelectIcon'));
   //用户体验优化 2
    function clickTarget(obj,str){
        $(document).click(function(e){ 
            if($(e.target).eq(0).is(obj)){  
            }else{
                if(str.is(":visible")){  
                  str.next().hide();
                  str.attr('tid','0');
                }else{  
                } 
            }
        }); 
    }
    $('.partSelectIcon').hover(function() {
        if(!$(this).parent().hasClass('partSelectS')){
            $(this).parent('.partSelectP').addClass('partSelectPHigh');
            $(this).next().show();
        }
    }, function() {
        if(!$(this).parent().hasClass('partSelectS')){
        	$(this).parent('.partSelectP').removeClass('partSelectPHigh');
        	$(this).next().hide();
        }
    });
    //重置密码
    $('#isSetPwd').click(function(){
            $("#message,.message").remove();
            var url = $(this).attr('url');
            $.ajax({
                url:url,
                type : 'Get',
                data : {cid:""},
                dataType : 'json',
                contentType : 'application/x-www-form-urlencoded',
                async : false,
                success : function(mydata) {
                    hidePormptMaskWeb('#popupBoxRset');
                    if(mydata&&mydata.msg==='success'){
                            var tishi = '<div id="message"><div class="messageType success" id="type-success"><span >✔</span>&nbsp;&nbsp;密码已重置为'+mydata.password+'</div></div>';
                            $('body').append(tishi); 
                    }else{ 
                        var tishi = '<div id="message"><div class="messageType success" id="type-success"><span >✘</span>&nbsp;&nbsp;密码重置失败</div></div>';
                        $('body').append(tishi);
                    }
                    $('#message').show();
                    setTimeout( function() { $('#message').slideUp("slow");},3000); 
                }
            });
        });
    // var projectss =schoolss;
    //var projects = projectss.split(',');
    //var projects = eval(schoolss);
    //selectAutocomplete("selectSchool",projects,'selectSchoolx');
    
  });
</script>


