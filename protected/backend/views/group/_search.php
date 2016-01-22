<form action="">
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <td width="45px"> 学校：</td>
        <td width="220px">
            <select name="Group[sid]" id="selectsid" class="max" url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>" >
                <option value="">全部</option>
                <?php foreach($schools as $k=>$v):?>
                    <option value="<?php echo $k;?>" <?php if($query['sid']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td width="65px"> 创建者：</td>
        <td width="130px">
            <select name="Group[teacher]" id="teacherselect" >
                <option value="">全部</option>
                <?php if(is_array($teachers)): foreach($teachers as $k=>$val):?>
                    <option value="<?php echo $k;?>" <?php if($query['teacher']==$k) echo 'selected="selected"'; ?>><?php echo $val;?></option>
                <?php endforeach;?>
                <?php endif;?>
            </select>
        </td>
        <td width="65px">组类型：</td>
        <td width="130px">
            <select name="Group[type]"  >
                <option value="-1">全部</option>
                <option value="0" <?php echo $query['type']==0?"selected='selected'":"";?> >学生组</option>
                <option value="1" <?php echo $query['type']==1?"selected='selected'":"";?>>老师组</option>
            </select>
        </td>
        <td width="65px">组名称：</td>
        <td width="140px">
            <input class="searchW260" style="width:120px;"  name="Group[name]" type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"
                   value="<?php echo $query['name'];?>">
        </td>
        <td class="search">
            <a href="<?php echo Yii::app()->createUrl('group/create');?>" class="btn btn-primary fright">创建</a>
            <input type="submit" class="btn btn-primary" value="搜 索"> 
        </td>
    </tr> 
</table>
</form>