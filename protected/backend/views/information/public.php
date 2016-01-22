<div class="box">
    <div class="tableBox">
    <?php include('pub_search.php'); ?> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              	<tr style="background-color: #e8e8e8;">
					<th width="25%">资讯标题</th>
					<th width="8%">是否头条</th>
					<th width="15%">所属分类</th>
					<th width="8%">状态</th>
					<th width="15%">创建时间</th>
					<th width="">操作</th> 
              	</tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])): ?> 
                    <?php foreach($data['model'] as $info): ?>
                        <tr>
                            <td><?php echo $info->title;?></td>
                            <td><?php echo $info->getHeadStatus();?></td>
                            <td><?php echo $info->getKindStatus();?></td>
                            <td rel="state_<?php echo $info->iid; ?>"><?php echo $info->getDisableState();?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($info->creationtime)); ?></td>
                            <td> 
                                <a href="<?php echo Yii::app()->createUrl('information/publicview/'.$info->iid);?>">查看</a>&nbsp;&nbsp; 
                                <a rel="set_state" iid="<?php echo $info->iid; ?>" url="<?php echo Yii::app()->createUrl('information/setdisable/'.$info->iid);?>" href="javascript:void(0);"><?php echo $info->getDisableState(true); ?></a>&nbsp;&nbsp;
                                <a href="javascript:void(0);" rel="preview" iid="<?php echo $info->iid; ?>" url="<?php echo Yii::app()->createUrl('information/preview/'.$info->iid);?>">预览 </a> 
                                <span style="display: inline-block; margin-left: 10px;">
                                    <a  <?php if($info->state==1){?> style="display:none" <?php } ?> rel="editBnt" href="<?php echo Yii::app()->createUrl('information/publicedit/'.$info->iid);?>">编辑 </a>
                                </span> 
                            </td>
                        	
                        </tr>
                    <?php endforeach; ?>  
                <?php else: ?>
                        <tr>
                            <td colspan="6" align="center" style=" font-size: 21px; padding: 100px 0;">
                                暂无数据
                            </td>
                        </tr> 
                <?php endif; ?>  
            </tbody>
        <!--    <tfoot>
                <tr>
                    <td colspan="7">

                    </td>
                </tr>  
            </tfoot>-->
        </table>
        <div id="pager">    
            <?php    
                $this->widget('CLinkPager',array(    
                    'header'=>'',    
                    'firstPageLabel' => '首页',    
                    'lastPageLabel' => '末页',    
                    'prevPageLabel' => '上一页',    
                    'nextPageLabel' => '下一页',    
                    'pages' => $data['pages'],    
                    'maxButtonCount'=>9    
                    )    
                );    
            ?>    
        </div>  
    </div> 
    <div class="popupBox">
        <div class="header">资讯预览 <a href="javascript:void(0);" class="close" onclick="hidePormptMask('popupBox')" > </a></div>
        <div id="popupInfo"> 
        </div> 
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script> 
<script type="text/javascript">
    //日期控件
    $( "#dateTime" ).datepicker({
        defaultDate: "+1w", 
        changeYear: true,
        numberOfMonths: 1
    });
    //停用启用操作
    $("[rel=set_state]").click(function(){
    url = $(this).attr("url");
    iid = $(this).attr("iid");
    obj = $(this);
    $.ajax({  
        url:url,   
        type : 'POST',
        dataType : 'text',  
        contentType : 'application/x-www-form-urlencoded',  
        async : false,  
        success : function(mydata) {   
            var show_data =mydata; 
            obj.text(show_data);
            var state ='';
            if(show_data == '停用'){
                state = '启用';
                 obj.parent('td').find('[rel=editBnt]').hide();
            }else{
                state = '停用';
                obj.parent('td').find('[rel=editBnt]').show();
            }
            $("[rel=state_"+ iid + "]").text(state);
        },  
        error : function() {  
                // alert("calc failed");  
        }  
    });
});
    //查看资讯内容
    $("[rel=preview]").click(function(){ 
        url = $(this).attr("url");
        iid = $(this).attr("iid");
        $.ajax({  
            url:url,   
            type : 'POST',
            data : {iid:iid}, 
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {   
                var show_data =mydata;  
                $("#popupInfo").html(show_data); 
                showPromptsIfon('popupBox');
            },  
            error : function() {  
                $("#popupInfo").html("请求出错!");
                showPromptsIfon('popupBox');
            }  
        });
    })
</script>


  
