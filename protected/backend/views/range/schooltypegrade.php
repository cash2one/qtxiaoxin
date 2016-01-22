<a href="javascript:void(0);" class="schoolAll" data-value="<?php echo $schooltype->stid; ?>" data-school="<?php echo $schooltype->name; ?>">全部</a>&nbsp;&nbsp;
<?php foreach($arr as $ka=>$va){ ?> 
	<a href="javascript:void(0);" class="itmeSchool" data-school="<?php echo $schooltype->name; ?>"  data-value="<?php echo $ka; ?>" rel="<?php echo $schooltype->stid; ?>"><?php echo $va; ?></a>&nbsp;&nbsp;
<?php } ?>