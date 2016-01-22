<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;"> 
    <tbody valign="middle">
        <tr valign="middle">
            <td width="45px">商家：</td>
            <td width="170px">
                <?php $bid = isset($Information['bid'])?$Information['bid']:''; ?>
                <?php echo $form->dropDownList($model,'bid',Business::getDataArr(),array('class'=>'lag','empty' => '--全部--','options' => array($bid=>array('selected'=>true)))); ?>
            </td>
            <td width="75px">合同配置：</td>
	        <td width="100px">
	            <?php $type = isset($Information['contype'])?$Information['contype']:''; ?>
	            <?php echo $form->dropDownList($model,'contype',Information::getConTypeArr(),array('empty' => '--全部--','options' => array($type=>array('selected'=>true)),'style'=>'width: 80px;')); ?>
	        </td>
            <td width="45px">分类：</td>
            <td width="150px">
                <?php $ikid = isset($Information['ikid'])?$Information['ikid']:''; ?>
                <?php echo $form->dropDownList($model,'ikid',InformationKind::getDataArr(),array('empty' => '--全部--','options' => array($ikid=>array('selected'=>true)),'style'=>'width: 85px;')); ?>
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
        </tr>
    </tbody>

</table> 
<?php $this->endWidget(); ?>