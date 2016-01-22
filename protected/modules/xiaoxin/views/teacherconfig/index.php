<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/listbox/prettify.css">  
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/listbox/bootstrap-duallistbox.css">  
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/listbox/jquery.bootstrap-duallistbox.js"></script>
<div class="header"> 
    <div class="titleText"><em class="inIco24"></em>定向发送设置</div>  
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
                管理老师发送权限，规避消息风险。
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox"> 
        <div class="box" style="padding: 20px;"> 
                <form id="demoform" action="" method="post">
                <table class="tableForm searchForm" style="margin-bottom: 10px;">
                    <tr> 
                        <td width="75px">选择学校：</td>
                        <td width="150px">
                            <select datatype="*" nullmsg="请选择类型！" errormsg="" name="sid" id="selectuid" class="Validform_error" style="width:150px;">
                                <?php foreach($schools as $val):?>
                                    <option value="<?php echo $val->sid;?>" <?php if($sid==$val->sid)  echo 'selected="selected"';?>> <?php echo  $val->s?$val->s->name:'';?></option>
                                <?php endforeach;?>
                            </select>
                        </td> 
                        <td width="81px">选择老师：</td>
                        <td width="130px">
                            <select datatype="*" nullmsg="请选择类型！" errormsg="" name="selectuid" id="selectteacher" class="Validform_error">
                                <?php foreach($allteachers as $val):?>
                                <option value="<?php echo $val->teacher;?>" <?php if($selectuid==$val->teacher)  echo 'selected="selected"';?>> <?php echo $val->teacher0?$val->teacher0->name:'';?></option>
                                <?php endforeach;?>
                            </select>
                        </td>
                        <td></td>
                    </tr> 
                </table>
                  <div id="target">
                  <select multiple="multiple" size="25" name="duallistbox_demo1[]">
                      <?php foreach($allteachers as $val):?>
                       <option value="<?php echo $val->teacher;?>" <?php if(in_array($val->teacher,$rightlist)) echo 'selected="selected"';?>><?php echo $val->teacher0?$val->teacher0->name:'';?></option>
                      <?php endforeach;?>
                  </select>
                  </div>
                  <br>
                  <button type="submit" class="btn btn-default btn-block">保 存</button>
                </form> 
        </div> 
    </div>
</div>
<script>


    $("#demoform").submit(function() {
   //  $("#demoform").submit() = true;
     // return false;
    });
    $(function(){
        var settings = {
            infoTextEmpty:'无数据',
            infoText:'总计 {0}',
            filterPlaceHolder:'过滤',
            infoTextFiltered:'<span >匹配到</span> {1} 项中的 {0} 项',
            filterTextClear:'显示全部'

        };
        var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox(settings);
        $("#selectuid").change(function(){
           //var url="<?php echo Yii::app()->createUrl('xiaoxin/teacherconfig');?>";
            var url="<?php echo Yii::app()->createUrl('xiaoxin/teacherconfig/getteachers');?>";
            var sid=$(this).val();
            $.getJSON(url,{sid:sid},function(data){
                if(data&&data.allteacher){
                    var str=[];
                    $.each(data.allteacher,function(i,v){
                            str.push('<option value="'+ v.userid+'">'+ v.name+"</option>");
                    });
                    $("#selectteacher").html('<option value="0">选择老师</option>'+str.join(""));
                    $('#target').html('<select multiple="multiple" size="30" name="duallistbox_demo1[]">'+str.join("")+'</select>');
                    var demo2 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox(settings);
                }
            });
        });
        $("#selectteacher").on("change",function(){
            var url="<?php echo Yii::app()->createUrl('xiaoxin/teacherconfig');?>";
            var sid=$("#selectuid").val();
            var selectuid=parseInt($(this).val());
            if(selectuid){
                var url="<?php echo Yii::app()->createUrl('xiaoxin/teacherconfig/getteachers');?>";
                $.getJSON(url,{sid:sid,teacher:selectuid},function(data){
                    if(data&&data.allteacher){
                        var str=[],str1=[];
                        var tmp=data.tmp;
                        $.each(data.allteacher,function(i,v){
                            if($.inArray(""+v.userid,tmp)!==-1){
                                str.push('<option selected="selected" value="'+ v.userid+'">'+ v.name+"</option>");
                            }else{
                                str.push('<option value="'+ v.userid+'">'+ v.name+"</option>");
                            }

                        });
                        $('#target').html('<select multiple="multiple" size="30" name="duallistbox_demo1[]">'+str.join("")+'</select>');
                        var demo2 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox(settings);
                    }
                });
            }

        });
    })
</script>
  

