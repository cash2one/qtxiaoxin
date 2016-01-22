<form action="">
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <td width="45px"> 学校：</td>
        <td width="220px">
            <select name="Student[sid]" id="selectsid" class="max" selectid="selecttid"  url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
                <option value="">全部</option>
                <?php foreach($schools as $k=>$v):?>
                    <option value="<?php echo $k;?>"  <?php if($query['sid']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td width="45px"> 班级：</td>
        <td width="130px">
            <select name="Student[cid]" id="selecttid" >
                <option value="">全部</option>
                <?php foreach($classs as $k=>$v):?>
                    <option value="<?php echo $k;?>" <?php if($query['cid']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td width="45px">姓名：</td>
        <td width="140px">
            <input name="Student[name]" value="<?php echo $query['name'];?>" class="searchW260" style="width:120px;"  type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')" >
        </td> 
         <td width="85px">监护人手机：</td>
        <td width="140px">
            <input name="Student[mobilephone]"  maxlength="11" value="<?php echo $query['mobilephone'];?>" class="searchW260" style="width:120px;"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')">
        </td>                     
        <td class="search"> 
             <a href="<?php echo Yii::app()->createUrl('student/create');?>" class="btn btn-primary fright">创建</a>
             <span class="fright">&nbsp;&nbsp;&nbsp;&nbsp;</span>
             <a href="<?php echo Yii::app()->createUrl('student/importstudent');?>" class="btn btn-primary fright">学生批量导入</a>
            <input type="submit" class="btn btn-primary" value="搜 索">  
        </td>

    </tr>
</table>
</form> 