<?php if(is_array($classs)&&count($classs)):?>
<?php foreach($classs as $class):?>
    <?php if($type=="1"):?>
        <li severtype="0"><a rel="chekedItime" class="schoolT_<?php echo $class['sid'];?>" id="addCheckClass_<?php echo $class['sid'];?>_<?php echo $class['cid'];?>" tip="0" data-tpyid="1" data-cname="<?php echo $class['name'];?>" data-sid="<?php echo $class['sid'];?>" data-cid="<?php echo $class['cid'];?>" href="javascript:void(0);"><?php echo $class['name'];?></a></li>
    <?php else:?>
        <li severtype="0"><a rel="chekedItime" class="schoolT_<?php echo $class['sid'];?>" id="addCheckClass_<?php echo $class['sid'];?>_<?php echo $class['gid'];?>" tip="0" data-tpyid="2" data-cname="<?php echo $class['name'];?>" data-sid="<?php echo $class['sid'];?>" data-cid="<?php echo $class['gid'];?>" href="javascript:void(0);"><?php echo $class['name'];?></a></li>
    <?php endif;?> 
<?php endforeach;?>
<?php else:?>
<!--    <li>
    <a style="color:#999;" href="javascript:void(0);">此学校还没有添加<?php echo $type=="1"?'班级':'分组';?></a>
    </li>-->
<?php endif;?> 