<div class="box">
    <div class="tableBox">
  
    <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
       <thead>
         <tr style="background-color: #e8e8e8;">
             <th width="20%">名称</th>
             <th width="20%">权限范围</th>
             <th width="20%">权限级别</th>
             <th width="20%">创建时间</th>
             <th>操作</th>
         </tr>  
       </thead>
       <tbody>
           <tr> 
                <td>校长</td>
                <td>紧急通知</td>
                <td>全校</td>
                <td>2014-11-3</td>
                <td>
                    <a href="">编辑</a>
                    &nbsp;&nbsp;
                    <a rel="deleLink" href="javascript:;" data-href="" >删除</a>
                </td> 
            </tr>
            <tr>
                <td colspan="6" align="center" style=" font-size: 21px; padding: 100px 0;">
                    暂无数据
                </td> 
            </tr> 
      
       </tbody>
    </table>
        <div id="pager" style="  margin-top: 30px;">
         
        </div>
    </div>
</div>
<div id="popupBox" class="popupBox"> 
    <div id="popupInfo" style="padding:20px 30px;"> 
        <div class="centent">温馨提示：是否删除当前学校？删除学校后将会把该学校所关联的班级、部门、科目一并删除!</div>
  </div>
    <div style="text-align: center;">
        <a id="isOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
    </div>
</div>
<a href="javascript:;" onclick="showPromptsIfon('#popupBox')"></a>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery.autocomplete.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/selectautocomplete.js"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
<script type="text/javascript"> 
$(function() {
   
   //删除提醒
    $('[rel=deleLink] ').click(function(){
        var urls = $(this).data('href');
        $("#isOk").attr('href',urls);
        showPromptsIfonWeb('#popupBox');
    });
          
  });
</script> 


