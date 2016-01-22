<!DOCTYPE html>
<html >
<head> 
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit|ie-comp"> 
    <title><?php echo CHtml::encode(Yii::app()->name); ?></title>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/official/base.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/official/ui.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/official/main.css">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/jquery.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/global.js"></script>
    <!-- html5.js for IE less than 9 -->
    <!--[if lt IE 9]>
        <script src="js/html5.js"></script>
        
    <![endif]-->

    <!-- css3-mediaqueries.js for IE less than 9 -->
    <!--[if lt IE 9]>
        <script src="js/css3-mediaqueries.js"></script>
    <![endif]-->
    
    <!-- IE8一下的浏览器提示更新 -->
    <!--[if lt IE 8]>
    <div id="ie6-warning">您正在使用 Internet Explorer 8以下的浏览器，在本页面的显示效果可能有差异。建议您升级到 <a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank">Internet Explorer 8、9、10、11</a> 或以下浏览器： <a href="http://www.mozillaonline.com/" target="_blank">Firefox</a> / <a href="http://www.google.com/chrome/?hl=zh-CN">Chrome</a> / <a href="http://www.apple.com.cn/safari/" target="_blank">Safari</a> / <a href="http://www.operachina.com/" target="_blank">Opera</a>
    </div>
    <![endif]-->
</head>

<body >
        <?php include('header.php'); ?>
       
        <?php include('sidebar.php'); ?>
        <?php echo $content;?>
       
        <script>

           //导航样式显示问题 主要为了兼容IE
           $(function(){
                $('#nav').find('.border-icon i').each(function(index, el) {
                    var h=$(el).height();
                    var w=$(el).width();
                    $(el).css({
                        'position':'absolute',
                        'top':'50%',
                        'left':'50%',
                        'margin-top': -(h/2)+'px',
                        'margin-left': -(w/2)+'px'
                    });
                });
                $('#nav').find('li').each(function(index, el) {
                    if (!$(this).hasClass('active')) {
                        $(this).find('.border-icon i').hide();
                    };
                });
                $('#nav').find('li').hover(function() {
                    var _left=$(this);
                   if (!_left.hasClass('active')) {
                        setTimeout(function(){
                            _left.find('.border-icon i').show();
                        },50);
                   }
                }, function() {
                    var _left=$(this);
                    if (!_left.hasClass('active')) {
                        setTimeout(function(){
                            _left.find('.border-icon i').hide();
                        },200);
                    }
                });
               
           })
        </script>
        <?php Yii::app()->msg->printMsg();?>
</body>
</html>
