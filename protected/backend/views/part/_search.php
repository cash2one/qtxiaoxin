<form action="">
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr>
        <td width="45px"> 学校：</td>
        <td width="220px">
            <select name="Department[sid]" id="selectsid" class="max" >
                <option value="">全部</option>
                <?php foreach($schools as $k=>$v):?>
                    <option value="<?php echo $k;?>" <?php if($query['sid']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                <?php endforeach;?>
            </select>
        </td>
       
        <td width="75px">部门名称：</td>
        <td width="180px">
            <input name="Department[name]" value="<?php echo $query['name']; ?>" class="searchW260" style="width:160px;"  type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')" value="">
        </td>
        <td class="search">
            <a href="<?php echo Yii::app()->createUrl('part/create');?>" class="btn btn-primary fright">创建</a>
            <input type="submit" class="btn btn-primary" value="搜 索"> 
        </td>
    </tr> 
</table>
</form>