<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
        <table class="tableForm searchForm" style="margin-bottom: 10px;"> 
            <tbody valign="middle">
                <tr valign="middle"> 
                    <td width="45px;">状态：</td>
                    <td width="130px">
                        <select class="" name="User[deleted]" id="User_deleted">
                            <option value="" <?php if(isset($User['deleted']) && $User['deleted']=='0'){ ?>selected="selected"<?php } ?>>--全部--</option>
                            <option value="0" <?php if(isset($User['deleted']) && $User['deleted']=='0'){ ?>selected="selected"<?php } ?>>启用</option>
                            <option value="1" <?php if(isset($User['deleted']) && $User['deleted']==1){ ?>selected="selected"<?php } ?>>停用</option>
                        </select>
                    </td>
                    <td width="75px"> 创建时间：</td>
                    <td width="200px"><input type="text" style="width:180px;" id="dateTime" readonly="readonly" name="User[creationtime]" value="<?php if(isset($User['creationtime'])){echo $User['creationtime'];} ?>"></td>
                    <td width="60px" valign="middle" >账号名：</td>
                    <td width="260px"><input type="text" style="width:240px;" name="User[name]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($User['name'])){echo $User['name'];} ?>"></td>
                    <td class="search"><input type="submit" class="btn btn-primary" value=" 搜 索 "></td>
                </tr>
            </tbody>
 
        </table> 
<?php $this->endWidget(); ?>