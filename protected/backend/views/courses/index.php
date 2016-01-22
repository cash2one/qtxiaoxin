<style>
    #message{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; right: 20px; bottom:50px; display: none; z-index: 10000; border-radius: 5px;}
    #message .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message .success{  border: 1px solid #fbeed5; background-color: #335ea0; color: #ffffff; }
    #message .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
    .table td select{ width: 81px; }
</style>
<div class="box">
	<form action="">
		<table class="tableForm searchForm" style="margin-bottom: 10px;">
		    <tr> 
		        <td width="45px"> 学校：</td>
		        <td width="220px">
                    <select name="Class[sid]" id="selectsid" class="max" selectid="grade"  url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
                        <?php foreach($schools as $k=>$v):?>
                            <option value="<?php echo $k;?>" <?php if($query['sid']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                        <?php endforeach;?>
                    </select>
                </td>
		        <td width="45px"> 年级：</td>
		        <td width="130px">
                        <select name="Class[grade]" id="grade" >
                            <option value="interest">兴趣班</option>
                            <?php foreach($grades as $k=>$v):?>
                                <option value="<?php echo trim($k);?>" <?php if($query['grade']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                            <?php endforeach;?>
                        </select>
                        
		        </td>
		        <td width="75px">班级名称：</td>
		        <td width="140px">
		            <input name="Class[name]" value="<?php echo $query['name'];?>" class="searchW260" style="width:120px;"  type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')" >
		        </td>                   
		        <td class="search">
                    <a href="<?php echo Yii::app()->createUrl('courses/import');?>" class="btn btn-primary fright">课程批量导入</a>
		            <input type="submit" class="btn btn-primary" value="搜 索"> 
		        </td>
		    </tr>
		</table>
	</form>  
    <div class="tableBox"> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
           <thead>
             <tr style="background-color: #e8e8e8;">
                 <th width="15%"><div style="width: 200px;">班级名称</div></th>
                 <th width="5%">班主任</th>
                 <?php foreach($subjects as $k=>$val):?>
                 <th width="5%" subjectid="<?php echo $k;?>"><?php echo $val;?> </th> 
                 <?php endforeach;?>
             </tr>  
           </thead>
           <tbody>
            <?php $i=1;$j=1;?> 
           <?php if($query['sid'] &&$query['grade']): ?>
           <?php if(count($courses['model'])):?>
           <?php foreach($courses['model'] as $k=>$class):?> 
               <?php $i++;?>
               <tr>
                    <td><?php echo $class->name;?></td>
                    <td>
                        <select rel="teacherName" name="teachername" id="teacher_<?php echo $i; ?>" cid="<?php echo $class->cid; ?>">
                            <option value=''>选老师</option>
                            <?php foreach($teachers as $tk=>$tv):?>
                                <option value="<?php echo $tk; ?>" <?php if($tk==$class->master) echo 'selected="selected"';?>><?php echo $tv; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>

                   <?php foreach($subjects as $k=>$val):?>
                    <?php $j++;?>
                   <td>
                       <select rel="CoursesMaster"  name="Courses[<?php echo $k; ?>][master]" id="courses_<?php echo $j;?>" cid="<?php echo $class->cid; ?>" sid="<?php echo $k; ?>" subject="<?php echo $val; ?>">
                            <?php $csuid = $class->getClassSubject($k); ?>
                            <option value=''>选老师</option>
                            <?php foreach($teachers as $tk=>$tv):?>
                               <option value="<?php echo $tk; ?>" <?php if($tk==$csuid) echo 'selected="selected"';?>><?php echo $tv; ?></option>
                            <?php endforeach; ?>
                       </select>
                   </td>
                    
                   <?php endforeach; ?>

                </tr>
               <?php endforeach;?>
              <?php else:?>
                <tr>
                    <td colspan="<?php echo count($subjects)+2;?>" align="center" style=" font-size: 21px; padding: 100px 0;">
                        暂无数据
                    </td> 
                </tr>
             <?php endif;?>
             <?php else: ?>
               <tr>
                   <td colspan="<?php echo count($subjects)+2;?>" align="center" style=" font-size: 21px; padding: 100px 0;">
                       请先选择学校跟年级
                   </td>
               </tr>
            <?php endif; ?>
           </tbody>
        </table> 
    </div>
</div>  
<script type="text/javascript">

$(function() {
    $("#selectsid").change(function(){
        var datas = $(this).val();
        var url = $(this).attr('url');
        var selectid = $(this).attr('selectid');
        var option =''; 
        if (datas) {
            $.getJSON(url,{sid:datas,grade:1},function(mydata) {
                if(mydata&&mydata.grades){
                    $.each(mydata.grades,function(i,v){
                        option = option+'<option value="'+i+'">'+v+'</option>';
                    });
                }
                option = '<option value="interest">兴趣班</option>'+option;
                $("#"+selectid).html(option); 
            });
        }else{
            
            $("#"+selectid).html('<option value="">全部</option>');
        }
    });
    //改班主任
    $('[rel=teacherName]').change(function(){
      var uid = $(this).find('option:selected').val();
       var cid = $(this).attr('cid');
       var sid ='' ,subject ='' ,url="<?php echo Yii::app()->createUrl('range/classmaster');?>"; 
        ajaxPost(url,cid,sid,uid,subject);
    });
    //设置班级科目任课老师
    $('[rel=CoursesMaster]').change(function(){
       var uid = $(this).find('option:selected').val();
       var cid = $(this).attr('cid');
       var subject = $(this).attr('subject');
       var sid = $(this).attr('sid'),urls="<?php echo Yii::app()->createUrl('range/setsubject');?>";
        ajaxPost(urls,cid,sid,uid,subject);
    });
    //请求代码
    function ajaxPost(url,cid,sid,uid,subject){ 
         $.ajax({
            url:url,
            type : 'Get',
            data : {cid:cid,sid:sid,uid:uid,subject:subject},
            dataType : 'text',
            contentType : 'application/x-www-form-urlencoded',
            async : false,
            success : function(mydata) { 
               if(mydata==='success'){ 
                        var tishi = '<div id="message"><div class="messageType success" id="type-success"><span >✔</span>&nbsp;&nbsp;修改成功</div></div>';
                        $('body').append(tishi);
                        $('#message').show();
                        setTimeout( function() { $('#message').slideUp("slow");},3000);
                    }else{ 
                        var tishi = '<div id="message"><div class="messageType success" id="type-success"><span >✘</span>&nbsp;&nbsp;修改失败</div></div>';
                        $('body').append(tishi);
                        $('#message').show();
                        setTimeout( function() { $('#message').slideUp("slow");},3000);
                      //  location.reload();
                    }
            }
        });
    }
  });
</script>


