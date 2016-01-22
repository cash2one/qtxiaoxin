<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>
    <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
       <thead>
         <tr style="background-color: #e8e8e8;">
             <th width="30%">部门名称</th>
             <th width="30%">学校</th>
             <th width="20%">创建时间</th>
             <th>操作</th>
         </tr>  
       </thead>
       <tbody>
       <?php if(count($parts['model'])):?>
           <?php foreach($parts['model'] as $part): ?>
               <tr>
                   <td><?php echo $part->name;?></td>
                   <td><?php echo $part->s?$part->s->name:"";?></td>
                   <td><?php echo substr($part->creationtime,0,16);?></td>
                   <td>
                       <a href="<?php echo Yii::app()->createUrl('part/update/'.$part->did);?>">编辑</a>
                       &nbsp;&nbsp;
                       <a rel="deleLink" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('part/delete/'.$part->did);?>" >删除</a>
                   </td>
               </tr>
           <?php endforeach;?>
       <?php else:?>
           <tr>
               <td colspan="6" align="center" style=" font-size: 21px; padding: 100px 0;">
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
                    'pages' => $parts['pages'],
                    'maxButtonCount'=>9
                )
            );
            ?>
        </div>
    </div>
</div>
<div id="popupBox" class="popupBox"> 
    <div id="popupInfo" style="padding: 30px;"> 
        <div class="centent">温馨提示：是否删除当前部门？</div>
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
    // 自动补全
    
   	var projectss =["深圳南山小学part","深圳大学part"];
    //console.log (projectss);
    // var projects = projectss.split(',');
    searchAutocomplete("selectSchool",projectss);              
  });
</script> 


