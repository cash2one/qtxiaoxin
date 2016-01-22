<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;"> 
    <tbody valign="middle">
        <tr valign="middle">
            <td width="75px" valign="middle">公众号ID：</td>
            <td width="160px"><input type="text" style="width:140px;" name="OfficialInfo[name]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($OfficialInfo['name'])){echo $OfficialInfo['name'];} ?>"></td>
            <td width="90px" valign="middle">公众号名称：</td>
            <td width="160px"><input type="text" style="width:140px;" name="OfficialInfo[openname]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($OfficialInfo['openname'])){echo $OfficialInfo['openname'];} ?>"></td>
            <td width="45px" valign="middle">类型：</td>
            <td width="150px">              
                <select name="OfficialInfo[opentype]" style="width:110px;" datatype="*" nullmsg="全部类型" id=" ">
                    <option value="">-- 全部类型 --</option>
                    <option value="1" <?php if(isset($OfficialInfo['opentype']) && $OfficialInfo['opentype'] ==1){echo "selected";}?>>系统公众号</option>
                    <option value="2" <?php if(isset($OfficialInfo['opentype']) && $OfficialInfo['opentype'] ==2){echo "selected";}?>>普通公众号</option>
                </select>
            </td>
            <td class="search"><input type="submit" class="btn btn-primary" value=" 搜 索 "></td>
        </tr>
    </tbody>

</table> 
<?php $this->endWidget(); ?>