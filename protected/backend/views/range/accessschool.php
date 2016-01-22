<select multiple="multiple" size="20" name="duallistbox_demo1[]" >
<?php foreach($schools as $ks=>$vs): ?>
    <option value="<?php echo $ks; ?>" <?php if(UserAccess::checkUserSchool($uid,$ks,$type)):?>selected="selected"<?php endif;?>><?php echo $vs; ?></option>
<?php endforeach; ?>
</select>