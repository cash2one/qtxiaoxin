<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>
    <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
       <thead>
         <tr style="background-color: #e8e8e8;">
             <th width="20%">组名称</th>
             <th width="15%">创建者</th>
             <th width="25%">学校</th>
             <th width="10%">组类型</th>
             <th width="15%">创建时间</th>
             <th >操作</th>
         </tr>  
       </thead>
       <tbody>
       <?php if(count($groups['model'])):?>
           <?php foreach($groups['model'] as $group): ?>
               <tr>
                   <td><?php echo $group->name;?></td>
                   <td><?php echo $group->creater0?$group->creater0->name:'';?></td>
                   <td><?php echo $group->s?$group->s->name:'';?></td>
                   <td><?php echo $typeArr[$group->type];?></td>
                   <td><?php echo substr($group->creationtime,0,16);?></td>
                   <td>
                       <a href="<?php echo Yii::app()->createUrl('group/update/'.$group->gid);?>">编辑</a>
                       &nbsp;&nbsp;
                       <a rel="deleLink" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('group/delete/'.$group->gid);?>" >删除</a>
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
                    'pages' => $groups['pages'],
                    'maxButtonCount'=>9
                )
            );
            ?>
        </div>
    </div>
</div>
<div id="popupBox" class="popupBox"> 
    <div id="popupInfo" style="padding: 30px;"> 
        <div class="centent">温馨提示：是否删除当前组？</div>
  </div>
    <div style="text-align: center;">
        <a id="isOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
    </div>
</div>
<a href="javascript:;" onclick="showPromptsIfon('#popupBox')"></a>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js" ></script>
<script type="text/javascript">

$(function() {

    //年级联动
    $("#selectsid").change(function(){
        var datas = $(this).val();
        var url = $(this).attr('url');
        var selectid = $('#teacherselect');
        var option ='<option value="">全部</option>';
        if (datas) {
            $.getJSON(url,{sid:datas,teacher:1},function(mydata) {
                if(mydata&&mydata.teachers){
                    $.each(mydata.teachers,function(i,v){
                        option=option+'<option value="'+i+'">'+v+'</option>';
                    });
                }
                selectid.html(option);
            });
        }else{
            selectid.html(option);
        }
    });
    //删除提醒
    $('[rel=deleLink] ').click(function(){
        var urls = $(this).data('href');
        $("#isOk").attr('href',urls);
        showPromptsIfonWeb('#popupBox');
    });
  });
</script> 


