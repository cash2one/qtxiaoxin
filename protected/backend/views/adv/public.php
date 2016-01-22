 <div class="box">
    <div class="tableBox">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
    <table class="tableForm searchForm" style="margin-bottom: 10px;">
        <tr>
            <td width="45px"> 状态：</td>
            <td width="130px">
                <?php $state = isset($Advertisement['state'])?$Advertisement['state']:''; ?>
                <select name="Advertisement[state]" id="Advertisement_state">
                    <option value="">--全部--</option>
                    <option value="1" <?php if($state==1){?>selected="selected"<?php } ?> >启用</option>
                    <option value="2" <?php if($state==2){?>selected="selected"<?php } ?> >停用</option>
                </select>
            </td>
            <td width="75px" class=" ">广告标题：</td>
            <td width="260px;"><input class="searchW260" style="width:240px;" type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  name="Advertisement[title]" value="<?php if(isset($Advertisement['title'])){echo $Advertisement['title'];} ?>"></td>
            <td class="search"><input type="submit" class="btn btn-primary" value="搜 索"></td>
            <td></td>
            <td width="90px" class="search"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('adv/publicadd');?>">创建开放广告</a></td>
        </tr> 
    </table>
    <?php $this->endWidget(); ?>
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">
                  <th width="30%">广告标题</th>
                  <th width="8%">状态</th>
                  <th width="20%">创建时间</th>
                  <th>操作</th>
              </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?>
                    <?php foreach($data['model'] as $adv){?>
                        <tr>
                            <td><?php echo $adv->title;?></td>
                            <td rel="state_<?php echo $adv->aid; ?>"><?php echo $adv->getDisableState();?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($adv->creationtime));?></td>
                            <td>
                                <a href="<?php echo Yii::app()->createUrl('adv/publicview/'.$adv->aid);?>">查看</a>&nbsp;&nbsp;
                                <a rel="set_state" aid="<?php echo $adv->aid; ?>" url="<?php echo Yii::app()->createUrl('adv/setdisable/'.$adv->aid);?>" href="javascript:void(0);"><?php echo $adv->getDisableState(true); ?></a>&nbsp;&nbsp;
                                <!-- <a href="<?php echo Yii::app()->createUrl('adv/publicdelete/'.$adv->aid);?>">删除</a>&nbsp;&nbsp;</td> -->
                                <a href="javascript:void(0);" rel="preview" aid="<?php echo $adv->aid; ?>" url="<?php echo Yii::app()->createUrl('adv/preview/'.$adv->aid);?>" >预览</a>
                                <span style="display: inline-block; margin-left: 10px;">
                                    <a <?php if($adv->state==1){ echo 'style="display:none"';} ?> rel="editBnt" href="<?php echo Yii::app()->createUrl('adv/publicedit/'.$adv->aid);?>">编辑 </a>
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                <?php }else {?>
                    <tr>
                        <td colspan="4" align="center" style=" font-size: 21px; padding: 100px 0;">
                            暂无数据
                        </td> 
                    </tr> 
                <?php } ?>
            </tbody>
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
</div>
<div class="popupBox">
    <div class="header">广告预览 <a href="javascript:void(0);" class="close" onclick="hidePormptMask('popupBox')" > </a></div>
    <div id="popupInfo"> 
    </div> 
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script>
<script type="text/javascript">
$("[rel=set_state]").click(function(){
    url = $(this).attr("url");
    aid = $(this).attr("aid");
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
            if(show_data == '停用'){
                state = '启用';
                obj.parent('td').find('[rel=editBnt]').hide();
            }else{
                state = '停用';
                obj.parent('td').find('[rel=editBnt]').show();
            }
            $("[rel=state_"+ aid + "]").text(state); 
        },  
        error : function() {  
                // alert("calc failed");  
        }  
    });
  });
    $("[rel=preview]").click(function(){ 
        url = $(this).attr("url");
        $.ajax({  
            url:url,   
            type : 'POST',
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
    }); 
</script>
 
