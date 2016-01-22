<form action="">
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr>
        <td width="45px"> 学校：</td>
        <td width="220px">
            <select name="Teacher[sid]" id="selectsid" class="max" selectid="grade"  url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
                <option value="">全部</option>
                <?php foreach($schools as $k=>$v):?>
                    <option value="<?php echo $k;?>"  <?php if($query['sid']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td width="45px"> 部门：</td>
        <td width="130px">
            <select name="Teacher[did]" id="selecttid" >
                <option value="">全部</option>
                <?php foreach($dids as $k=>$v):?>
                    <option value="<?php echo $k;?>" <?php if($query['did']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                <?php endforeach;?>
            </select>
        </td>
         <td width="45px">职务：</td>
        <td width="130px">
             <select name="Teacher[duty]">
                <option value="">全部</option>
                <?php foreach($dutylist as $k=>$v):?>
                    <option value="<?php echo $v->dutyid;?>" <?php if($query['duty']== $v->dutyid) echo 'selected="selected"'; ?>><?php echo $v->name;?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td width="45px">姓名：</td>
        <td width="140px">
            <input name="Teacher[name]" value="<?php echo $query['name'];?>" class="searchW260" style="width:120px;"  type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')" >
        </td>
         <td width="75px">绑定手机：</td>
        <td width="140px">
            <input name="Teacher[mobilephone]"  maxlength="11" value="<?php echo $query['mobilephone'];?>" class="searchW260" style="width:120px;"  type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')">
        </td>
        <td class="search">
            <input type="submit" class="btn btn-primary" value="搜 索">
            <span>&nbsp;&nbsp;</span>
            <div class="" style="width: 193px;display: inline-block; margin-top: 1px;">
                <a href="<?php echo Yii::app()->createUrl('teacher/create');?>" class="btn btn-primary  ">创 建</a>
                <span>&nbsp;&nbsp;</span>
                <a href="<?php echo Yii::app()->createUrl('teacher/importteacher');?>" class="btn btn-primary ">老师批量导入</a>
            </div>
        </td>
    </tr>
</table>
</form>