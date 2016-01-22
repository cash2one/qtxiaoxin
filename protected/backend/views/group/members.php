<?php foreach($members as $member): ?>
    <?php $name=explode(":",$member['name']);?>
    <li><a rel="chekedItime" class="" uit="0" data-name="<?php echo $member['name']; ?>" data-usid="<?php echo $member['userid'] ?>"
           href="javascript:void(0);"><em class="userIco"></em><span><?php echo count($name)>1?$name[1]:$member['name']; ?></span></a></li>
<?php endforeach; ?>

    


