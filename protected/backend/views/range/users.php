<option value="">--选择账号--</option>
<?php foreach($arr as $u){ ?>
	<option value="<?php echo $u->uid; ?>"><?php echo $u->username; ?></option>
<?php } ?>