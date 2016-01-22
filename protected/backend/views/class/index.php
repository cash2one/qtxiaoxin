<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>
    <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
       <thead>
         <tr style="background-color: #e8e8e8;">
             <th width="15%">班级名称</th>
             <th width="10%">班级序号</th>
             <th width="5%">教师数量</th>
             <th width="5%">学生数量</th>
             <th width="15%">学校</th>
             <th width="10%">年级</th>
             <th width="10%">班主任</th>
             <th width="15%">创建时间</th>
             <th>操作</th>
         </tr>  
       </thead>
       <tbody>
       <?php if(count($classs['model'])):?>
       <?php foreach($classs['model'] as $class): ?>
           <tr> 
                <td><?php echo $class->name;?></td>
                <td><?php echo $class->seqno!=99999999?$class->seqno:'';?></td>
               <td><?php echo $class->teachers;?></td>
               <td><?php echo $class->total;?></td>
                <td><?php echo $class->schoolname;?></td>
                <td><?php echo $class->type==1?'兴趣班':$class->gradename;?></td>
                <td><?php echo $class->mastername;?></td>
                <td><?php echo substr($class->creationtime,0,16);?></td>
                <td>
                    <a href="<?php echo Yii::app()->createUrl('class/update/'.$class->cid);?>">编辑</a>
                    &nbsp;&nbsp;
                    <a rel="deleLink" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('class/delete/'.$class->cid);?>" >删除</a>
                     &nbsp;&nbsp; 
                     <a rel="resetpwd" href="javascript:void(0);" clasid="<?php echo $class->cid;?>" data-href="<?php echo Yii::app()->createUrl('class/initclasspwd');?>">批量重置密码</a>
                </td> 
            </tr>
       <?php endforeach;?>
       <?php else:?>
            <tr>
                <td colspan="7" align="center" style=" font-size: 21px; padding: 100px 0;">
                    暂无数据
                </td> 
            </tr>
       <?php endif;?>
      
       </tbody>
    </table>
        <div id="pager" style="  margin-top: 30px;">
            <?php
            $this->widget('CLinkPager',array(
                    'header'=>'',
                    'firstPageLabel' => '首页',
                    'lastPageLabel' => '末页',
                    'prevPageLabel' => '上一页',
                    'nextPageLabel' => '下一页',
                    'pages' => $classs['pages'],
                    'maxButtonCount'=>9
                )
            );
            ?>
        </div>
    </div>
</div>
<div id="popupBox" class="popupBox"> 
    <div id="popupInfo" style="padding: 30px;"> 
        <div class="centent">温馨提示：是否删除当前班级？</div>
  </div>
    <div style="text-align: center;">
        <a id="isOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
    </div>
</div>
<!--重置密码 -->
<div id="resetPwdBox" class="popupBox">
    <div class="header"><a href="javascript:hidePormptMaskWeb('#resetPwdBox');" class="close"></a> 班级重置密码</div>
    <div id="popupInfos" style="padding: 20px;"> 
        <span>
            发送对象：
        </span>
        <select class="resetType">
            <option value="0">全班家长</option>
            <option value="1">未发送账号密码的家长</option>
        </select>
        <div class="remindTip" style="padding-top:15px; color: #666666;">
            提示：给本班家长重置密码
        </div>
  </div>
    <div style="text-align: center; padding-bottom: 20px;" > 
        <a id="resetPwdIsOk" href="javascript:void(0);" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#resetPwdBox');" class="btn btn-default">取消</a>
    </div>
</div>
<!--/重置密码 -->

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/selectautocomplete.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
<script type="text/javascript">

$(function() {
    var grade="<?php echo $query['grade'];?>";
    var sid="<?php echo $query['sid'];?>";

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
  //年级联动
    $("#selectsid").change(function(){
        var datas = $(this).val();
        var url = $(this).attr('url');
        var selectid = $(this).attr('selectid'); 
        var option ='<option value="">全部</option>';

        if (datas) {
            $.getJSON(url,{sid:datas,grade:1},function(mydata) {
                if(mydata&&mydata.grades){
                    $.each(mydata.grades,function(i,v){
                        option=option+'<option value="'+i+'">'+v+'</option>';
                    });
                }
                $("#"+selectid).html(option);
            }); 
         }else{
             var grades='<?php  echo  json_encode($grades);?>';
             var t=JSON.parse(grades);
             $.each(t,function(i,v){
                option=option+'<option value="'+i+'">'+v+'</option>';
             });
             $("#"+selectid).html(option);
         }
    });
    //批量重置密码弹框
    $("a[rel=resetpwd]").click(function(){
        var url =$(this).data("href");
        var clasId =$(this).attr("clasid");
        $("#resetPwdIsOk").attr("url",url+"?cid="+clasId);
        $("#resetPwdIsOk").attr("href",url+"?cid="+clasId+"&isNotSendStudent=0");
        showPromptsIfonWeb('#resetPwdBox'); 
    });
    //
    $(".resetType").change(function(){
        
        var typeVal= $(this).val();
        if(typeVal=="0"){
          $(".remindTip").text("提示：给本班家长重置密码");  
        }else{
          $(".remindTip").text("提示：给本班未发送账号密码的家长重置密码");
        }
        var urls =$("#resetPwdIsOk").attr("url"); 
        $("#resetPwdIsOk").attr("href",urls+"&isNotSendStudent="+typeVal);
    }); 
   // var projectss =schoolss;
   //var projects = projectss.split(',');
  //var projects = eval(schoolss);
    //selectAutocomplete("selectSchool",projects,'selectSchoolx');

  });
</script>


