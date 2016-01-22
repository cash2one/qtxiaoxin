<a id="fileName" class="fileIoc" href="javascript:void(0);"><?php echo $name; ?></a><span class="remind">添加成功，</span><span class="remind" style="color: red;"><?php echo $empty; ?>条空白</span><span class="remind" style="color: red;"><?php echo $repeat; ?>条重复</span>
<?php if($usefull==0): ?>
	<span class="remind" style="color: red;"><?php echo $usefull; ?>条有效数据，请重新上传文件！</span>
    <input id="usefullInput" type="hidden" value="1">
<?php else: ?>
	<span class="remind" ><?php echo $usefull; ?>条有效数据，请点击确定完成导入！</span>
    <input id="usefullInput" type="hidden" value="0">
<?php endif; ?>