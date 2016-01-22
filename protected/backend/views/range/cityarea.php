<a href="javascript:void(0);" class="cityAll" data-value="<?php echo $city->aid; ?>" data-city="<?php echo $city->name; ?>">全部</a>&nbsp;&nbsp;
<?php foreach($arr as $ka=>$va){ ?> 
<a href="javascript:void(0);" class="itmeRegion"  data-city="<?php echo $city->name; ?>" data-parent="<?php echo $city->aid; ?>" data-value="<?php echo $ka; ?>" rel="<?php echo $city->aid; ?>"><?php echo $va; ?></a>
    &nbsp;&nbsp;
<?php } ?>