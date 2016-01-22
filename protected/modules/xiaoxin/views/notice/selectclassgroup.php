<ul>
    <?php if(is_array($classs)) foreach($classs as $class):?>
        <li group="0" cid="<?php echo $class['cid'];?>"><?php echo $class['name'];?></li>
    <?php endforeach;?>
    <?php if(is_array($groups)) foreach($groups as $class):?>
        <li group="1"  gid="<?php echo $class['gid'];?>"><?php echo $class['name'];?></li>
    <?php endforeach;?>
</ul>

