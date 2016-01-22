<div class="box">
    <div class="tableBox">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
    <table class="tableForm searchForm" style="margin-bottom: 10px;">
        <tr>
            <td width="45px"> 类型：</td>
            <td width="130px">
                <?php $state = isset($Focus['state'])?$Focus['state']:''; ?>
                <?php $type = isset($Focus['type'])?$Focus['type']:''; ?>
            <?php echo $form->dropDownList($model,'type',Focus::getTypeArr(),array('empty' => '--全部类型--','options' => array($type=>array('selected'=>true)))); ?>
            </td>
            <td width="45px"> 状态：</td>
            <td width="130px">
                <?php $state = isset($Focus['state'])?$Focus['state']:''; ?>
                <select name="Focus[state]" id="Focus_state">
                    <option value="">--全部--</option>
                    <option value="1" <?php if($state==1){?>selected="selected"<?php } ?> >启用</option>
                    <option value="2" <?php if($state==2){?>selected="selected"<?php } ?>>停用</option>
                </select>
            </td>
            <td width="75px" class=" ">热点标题：</td>
            <td width="260px"><input class="searchW260" style="width:240px;" type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')" name="Focus[title]" value="<?php if(isset($Focus['title'])){echo $Focus['title'];} ?>"></td>
            <td class="search"><input type="submit" class="btn btn-primary" value="搜 索"></td>
            <td></td>
            <td width="90px" class="search"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('focus/publicadd');?>">创建开放热点</a></td>
        </tr> 
    </table>
    <?php $this->endWidget(); ?>
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">
                  <th width="30%">热点标题</th>
                  <th width="8%">类型</th>
                  <th width="8%">状态</th>
                  <th width="20%">创建时间</th>
                  <th>操作</th>
              </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?>
                    <?php foreach($data['model'] as $foc){?>
                        <tr>
                            <td><?php echo $foc->title; ?></td>
                            <td><?php echo $foc->getTypeName(); ?></td>
                            <td rel="state_<?php echo $foc->fid; ?>"><?php echo $foc->getDisableState();?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($foc->creationtime));?></td>
                            <td>
                                <a href="<?php echo Yii::app()->createUrl('focus/publicview/'.$foc->fid);?>">查看</a>&nbsp;&nbsp;
                                <a rel="set_state" aid="<?php echo $foc->fid; ?>" url="<?php echo Yii::app()->createUrl('focus/setdisable/'.$foc->fid);?>" href="javascript:void(0);"><?php echo $foc->getDisableState(true); ?></a>&nbsp;&nbsp;
                                <!-- <a href="<?php echo Yii::app()->createUrl('focus/publicdelete/'.$foc->fid);?>">删 除</a>&nbsp;&nbsp;</td> -->
                                <a href="javascript:void(0);" rel="preview" aid="<?php echo $foc->fid; ?>" url="<?php echo Yii::app()->createUrl('focus/preview/'.$foc->fid);?>">预览</a>
                                <span style="display: inline-block; margin-left: 10px;">
                                    <a <?php if($foc->state==1){ echo 'style="display:none"';} ?> rel="editBnt" href="<?php echo Yii::app()->createUrl('focus/publicedit/'.$foc->fid);?>">编辑 </a>
                                </span> 
                            </td>
                        </tr>
                    <?php } ?>
                <?php }else {?>
                    <tr>
                        <td colspan="5" align="center" style=" font-size: 21px; padding: 100px 0;">
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
   <div class="header">热点预览 <a href="javascript:void(0);" class="close" onclick="hidePormptMask('popupBox')" > </a></div>
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
})

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
})

</script>
 
