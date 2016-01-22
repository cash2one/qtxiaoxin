<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/foodmenu/')."?week=".$week."&year=".$year;?>"class="focus">餐单</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/foodmenu/publish')."?week=".$week."&year=".$year;?>">发布</a></li>
            </ul>
        </div>
    </div>
    <div class="titleText"><em class="inIco7"></em>日常工作 > 餐单管理</div>
</div>
<div class="mianBox">
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
             <div class="box" style="padding: 15px 0;">
                编辑每周食谱，并且可发布给学生家长。
            </div> 
        </div>
    </div>
    <div id="contentBox" class="contentBox ">
        <div class="box footManage" style="padding-top:0;">
            <div class="listTopTite bBottom" >
                <div align="center" >
                    <a href="<?php echo Yii::app()->createUrl('xiaoxin/foodmenu/index').'?sid='.$sid.'&year='.$year.'&week='.($week-1);?>" class="btn btn-default prevWeek">
                      <span></span>
                    </a>
                    <span class="thisWeek">第<?php echo $week;?>周&nbsp;&nbsp;<em>（<?php echo $dates[0].'&nbsp;~&nbsp;'.$dates[6];?>）</em></span>
                    <a href="<?php echo Yii::app()->createUrl('xiaoxin/foodmenu/index').'?sid='.$sid.'&year='.$year.'&week='.($week+1);?>" class="btn btn-default nextWeek">
                        <span></span>
                    </a>
                </div>
            </div>
            <div class="formBox">
                <form id="formBoxRegister" action="<?php echo Yii::app()->createUrl('xiaoxin/foodmenu/save');?>" method="post">
                    <table class="tableForm">
                        <tbody>
                            <tr>
                                <td class="date">
                                    学校：
                                </td>
                                <td>
                                    <div class="inputBox">
                                        <select id="class_school" name="sid" datatype="*" nullmsg="请选择学校！" errormsg="" rel="<?php echo Yii::app()->createUrl('xiaoxin/class/schoolgrade');?>">
                                            <?php foreach($schools as $val):?>
                                                <option value="<?php echo $val->sid;?>" <?php if($sid==$val->sid)  echo 'selected="selected"';?>> <?php echo  $val->s?($val->s->createtype==0?$val->s->name:$val->s->name.'(自建)'):'';?></option>
                                            <?php endforeach;?> 
                                        </select>
                                    </div>
                                    <!--<div class="inputBox"><input name="Account[name]" value=" " class="lg" type="text" datatype="*" nullmsg="请输入所在学校！" errormsg="所在学校不能为空！"></div>-->
                                    <span class="Validform_checktip" ></span>
                                </td>
                            </tr>
                            <?php for($i=0;$i<7;$i++):?>
                            <tr class="allTime">
                                <td class="date textTd">
                                    <?php echo $weekName[$i];?>
                                    <span class="day"><?php echo $dates[$i];?></span>
                                </td>
                                <td class="textTd">
                                    <div class="inputBox">  
                                        <?php if(!$weekFoodContent):?> 
                                        <textarea <?php if(!$isEdit) echo 'disabled="disabled" ';?> ignore="ignore" datatype="*1-100" nullmsg="" errormsg="餐单不能大于100个字！" name="content[]" ></textarea>
                                        <?php else:?>
                                         <textarea <?php if(!$isEdit) echo 'disabled="disabled" ';?> ignore="ignore" datatype="*1-100" nullmsg="" errormsg="餐单不能大于100个字！" name="content[]"><?php echo isset($content[$i+1])?$content[$i+1]:'';?></textarea>
                                        <?php endif;?>
                                    </div>
                                     <span class="Validform_checktip" >&nbsp;</span> 
                                </td>
                            </tr>
                            <?php endfor;?>
                            <tr>
                                <td></td>
                                <td>
                                    <?php if($isEdit):?>
                                         <!--<input type="submit" class="btn btn-raed"   value="保 存">-->
                                        <a rel="subService" href="javascript:void(0);" class="btn btn-raed">保 存</a>
                                    <?php endif;?>
                                    <input type="hidden" name="id" value="<?php echo $weekFoodContent?$weekFoodContent->id:0;?>" >
                                    <input type="hidden" name="week" value="<?php echo $week;?>"/>
                                    <input type="hidden" name="year" value="<?php echo $year;?>"/>
                                    <span id="subTip" class="Validform_checktip Validform_wrong" style="display: none;"> 请至少输入一天的餐单!</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() { 
    //表单验证控件
    Validform.int("#formBoxRegister");
    $("#class_school").change(function(){
        var sid=$(this).val();
        var week=$("input[name=week]").val();
        var year=$("input[name=year]").val();
        var url="<?php echo Yii::app()->createUrl('xiaoxin/foodmenu/index').'?sid=';?>";
        location.href=url+sid+"&year="+year+"&week="+week;
    });
  $('[rel=subService]').click(function(){
      var sbj =$('#formBoxRegister').find('textarea');
      var i =0;
    $.each(sbj, function(key, val) {  
        //console.log($(this).val()); 
        var str=$(this).val();
        $(this).val($.trim(str));
        if($.trim(str)!=""){
            i++;
        }
      });  
      if(i>0){
          $("#subTip").hide(); 
         $('#formBoxRegister').submit(); 
      }else{
         $("#subTip").show(); 
      }
  });
  $('#formBoxRegister textarea').keyup(function(){
      $("#subTip").hide();
  });
});
</script>