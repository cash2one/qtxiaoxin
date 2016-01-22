
<option value=''>--选择年级--</option>
<option value="interest">兴趣班</option>
<?php foreach($grades as $grade): ?>
    <option value="<?php echo $grade['gid']; ?>"><?php echo $grade['name']; ?></option>
<?php endforeach; ?>