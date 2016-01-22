<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit|ie-comp">
	<title><?php echo CHtml::encode(Yii::app()->name); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/themes/icon.css"> 
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/bootstrap/dist/css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/bootstrap/dist/css/bootstrap.min.css"> 
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/activityTheme.css"> 
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/jqueryui/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/Validform/validform.css"> 
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery.yiitab.js"></script>   
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/bootstrap/dist/js/bootstrap.min.js"></script> 
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/datepicker_zh-cn.js"></script> 
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/jquery.easyui.min.js"></script> 
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/src/jquery.datebox.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/locale/easyui-lang-zh_CN.js"></script> 
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/Validform/Validform_v5.3.2_min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/Validform/Validform_v5.3.2_ncr_min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	
</head>
<body class="easyui-layout">
    <?php include('ie.php'); ?>
    <?php include('_north.php'); ?>
    <?php include('_west.php'); ?>
    <?php include('_east.php'); ?>
    <?php include('_south.php'); ?>
    <div id="layouts" data-options="region:'center',title:'管理中心'">
            <?php echo $content; ?>
    </div>
    <script type="text/javascript"> 
    $(document).ready(function(){ 
        $('#layouts').scroll(function(event) {  
                $("#layouts").mousedown();
        });  
    });
</script>	 
</body>
</html>