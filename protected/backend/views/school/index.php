<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>
    <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
       <thead>
         <tr style="background-color: #e8e8e8;">
             <th width="8%">学校id</th>
             <th width="20%">学校名称</th>
             <th width="7%">自建</th>
             <th width="10%">类型</th>
             <th width="8%">城市</th>
             <th width="10%">地区</th>
             <th width="10%">是否开启定向发送</th>
             <th width="16%">创建时间</th>
             <th>操作</th>
         </tr>  
       </thead>
       <tbody>
       <?php if(count($schools['model'])):?>
       <?php foreach($schools['model'] as $school): ?>
           <tr> 
                <td><?php echo $school->sid; ?></td>
                <td><?php echo $school->name; ?></td>
                <td><?php echo $school->createtype==1?"是":""; ?></td>
                <td><?php echo $school->stype;?></td>
                <td><?php echo School::getCityNameByAid($school->aid);?></td>
                <td><?php echo $school->area;?></td>
                <td><?php echo $school->enableddirectsend==0?'不开启':'开启';?></td>
                <td><?php echo substr($school->creationtime,0,16);?></td>
                <td>
                    <a href="<?php echo Yii::app()->createUrl('school/update/'.$school->sid);?>">编辑</a>
                    &nbsp;&nbsp;
                    <a rel="deleLink" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('school/delete/'.$school->sid);?>" >删除</a>
                </td> 
            </tr>
       <?php endforeach; ?>
       <?php else: ?>
            <tr>
                <td colspan="9" align="center" style=" font-size: 21px; padding: 100px 0;">
                    暂无数据
                </td> 
            </tr> 
       <?php endif; ?>
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
                    'pages' => $schools['pages'],
                    'maxButtonCount'=>9
                )
            );
            ?>
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
    var type="<?php echo $query['type'];?>";
    var city="<?php echo $query['city'];?>";
    var area="<?php echo $query['area'];?>";
    if(type){
        $("#querytype").val(type);
    }
   if(city){
      $("#querycity").val(city);
   }
   if(area){
       $("#queryarea").val(area);
   }
   
   //城市地区联动
   $(document).on('change','#queryprovince',function() {
       ajaxareaurl = "<?php echo Yii::app()->createUrl('range/schoolarea');?>";
        var cityid = $(this).find("option:selected").val(); 
        if (cityid) {
            $.ajax({  
                url:ajaxareaurl,
                type : 'Get',
                data : {cid:cityid},  
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) { 
                    mydata=$.parseJSON(mydata);
                    if(mydata.status=='1'){ 
                        var str=[];
                        $("#querycity").html(''); 
                        $.each(mydata.data,function(i,v){
                             str.push('<option value="'+v.aid+'">'+v.name+'</option>');
                        });
                        $("#querycity").html(option +str.join('')); 
                    }
                }   
            });
        }else{
            var option ='<option value="">全部</option>';
            $("#querycity").html(option);
            $("#querycity").val('');

        }
   });
    //城市地区联动
   $(document).on('change','#querycity',function() {
        var ajaxareaurl = "<?php echo Yii::app()->createUrl('range/schoolarea');?>"; 
        var cityid = $(this).find("option:selected").val(); 
        if (cityid) {
            $.ajax({  
                url:ajaxareaurl,
                type : 'Get',
                data : {cid:cityid},  
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {
                   var option ='<option value="">全部</option>';
                   mydata=$.parseJSON(mydata);
                   if(mydata.status=='1'){ 
                        var str=[];
                        $("#queryarea").html('');
                        $.each(mydata.data,function(i,v){
                             str.push('<option value="'+v.aid+'">'+v.name+'</option>');
                        }); 
                        $("#queryarea").html(option +str.join('')); 
                    }
                }   
            });
        }else{
            var option ='<option value="">全部</option>';
            $("#queryarea").html(option);
            $("#queryarea").val('');

        }
   });
   //删除提醒
    $('[rel=deleLink] ').click(function(){
        var urls = $(this).data('href');
        $("#isOk").attr('href',urls);
        showPromptsIfonWeb('#popupBox');
    });
    // 自动补全 
    var projectss = '<?php echo $schoolnames;?>'; 
    var projects = eval(projectss);
    searchAutocomplete("project",projects);              
  });
</script> 


