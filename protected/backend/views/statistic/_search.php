<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
    <td width="45px"> 类型：</td>
        <td width="130px">
            <select name="School[type]" id="querytype" >
                <option  value="">全部</option>
                <?php foreach($types as $k=>$v):?>
                <option value="<?php echo $k;?>"><?php echo $v;?></option>
                <?php endforeach;?>
            </select>   
        </td>

        <td width="45px"> 城市：</td>
        <td width="130px">
            <select name="School[city]" id="querycity">
                <option value="">全部</option>
                <?php foreach($citys as $k=>$v):?>
                    <option value="<?php echo $k;?>"><?php echo $v;?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td width="45px"> 地区：</td>
        <td width="130px">
            <select name="School[area]" id="queryarea">
                <option  value="">全部</option>
                <?php if(count($areas)):?>
                <?php foreach($areas as $k=>$v):?>
                        <option value="<?php echo $k;?>"><?php echo $v;?></option>
                <?php endforeach;?>
                <?php endif;?>
            </select>
        </td>
        <td width="75px">学校名称：</td>
        <td width="260px">
            <input class="searchW260" name="School[name]"  id="project" style="width:240px;"  type="text" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"
                   name="Advertisement[title]" value="<?php echo $query['name'];?>">
        </td>
        <td class="search">
            <a href="<?php echo Yii::app()->createUrl('school/create');?>" class="btn btn-primary fright">创建</a>
            <input type="submit" class="btn btn-primary" value="搜 索"> 
        </td>
    </tr> 
</table>
<?php $this->endWidget(); ?>