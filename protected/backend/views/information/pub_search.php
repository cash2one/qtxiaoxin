<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;"> 
    <tbody valign="middle">
        <tr valign="middle">
            <td width="45px"> 状态：</td>
            <td width="100px">
                <?php $state = isset($Information['state'])?$Information['state']:''; ?>
                <?php echo $form->dropDownList($model,'state',Information::getDisableArr(),array('empty' => '--全部--','options' => array($state=>array('selected'=>true)),'style'=>'width: 80px;')); ?>
            </td>
            <td width="45px"> 分类：</td>
            <td width="150px">
                <?php $ikid = isset($Information['ikid'])?$Information['ikid']:''; ?>
                <?php echo $form->dropDownList($model,'ikid',InformationKind::getDataArr(),array('empty' => '--全部--','options' => array($ikid=>array('selected'=>true)),'style'=>'width: 80px;')); ?>
                <?php $kindtop = isset($Information['kindtop'])?$Information['kindtop']:''; ?>
                <label class="checkbox checkbox-inline"><input type="checkbox" name="Information[kindtop]" id="Information_kindtop" <?php if($kindtop){?>checked="checked"<?php } ?>>置顶</label>
            </td> 
            <td width="75px">是否头条：</td>
            <td width="150px">
	            <?php $head = isset($Information['head'])?$Information['head']:''; ?>
	            <select name="Information[head]" id="Information_head" style="width: 80px;">
	                <option value="">--全部--</option>
	                <option value="0" <?php if($head=='0'){?>selected="selected"<?php } ?> >否</option>
	                <option value="1" <?php if($head=='1'){?>selected="selected"<?php } ?> >是</option>
	            </select>
                <?php $headtop = isset($Information['headtop'])?$Information['headtop']:''; ?>
                <label class="checkbox checkbox-inline"><input type="checkbox" name="Information[headtop]" id="Information_headtop" <?php if($headtop){?>checked="checked"<?php } ?>>置顶</label>
        	</td> 
            <td width="75px;" valign="middle">资讯标题：</td>
            <td width="180px"><input type="text" style="width: 160px;" name="Information[title]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($Information['title'])){echo $Information['title'];} ?>"></td>
            <td class="search"><input type="submit" class="btn btn-primary" value=" 搜 索 "></td>
            <td></td>
            <td width="90px" class="search"><a class="btn btn-primary" href="<?php echo Yii::app()->createUrl('information/publicadd');?>">创建开放资讯</a></td>
        </tr>
    </tbody>

</table> 
<?php $this->endWidget(); ?>