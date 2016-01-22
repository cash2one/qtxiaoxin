<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html style=" position: relative; overflow: hidden;">
<head> 
	<meta charset="UTF-8">
	<meta name="renderer" content="webkit|ie-comp">
	<title><?php echo CHtml::encode(Yii::app()->name); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/themes/icon.css"> 
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/bootstrap/dist/css/bootstrap.min.css"> 
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/business/Validform/validform.css"> 
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/jquery.easyui.min.js"></script> 
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/src/jquery.datebox.js"></script> 
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/easyui/locale/easyui-lang-zh_CN.js"></script> 
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/css/business/bootstrap/dist/js/bootstrap.min.js"></script>  
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/datepicker_zh-cn.js"></script> 
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/Validform/Validform_v5.3.2_min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/Validform/Validform_v5.3.2_ncr_min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/activityTheme.css">
</head>
<style>
    .layout-panel-center{
        left: 179px; top: 70px;
        position: relative;
    }
</style>
<body class="easyui-layout" > 
    <?php include('ie.php'); ?>
    <?php include('_north.php'); ?> 
    <?php include('_east.php'); ?>
    <?php include('_west.php'); ?> 
    <div id="mianContent" style=" width: auto; overflow: hidden;  *display: inline-block;">
        <div class="navCrumb" id="navCrumb">
            <?php if(Menu::getReturnState($this)){ ?>
            <div  class="backtrack">
                <?php $returnurl = Menu::getReturnDefine($this); ?>
                <a href="<?php echo $returnurl?$returnurl:$this->previousurl; ?>" class="btn btn-primary">返 回</a>
            </div>
            <?php } ?>
            当前位置：<?php echo Menu::getSubName($this); ?>
        </div>
        <div id="mianOver" style="position: relative; height: 80%; padding: 0; overflow: auto;">
            <?php echo $content; ?> 
        </div>
    </div>
    <?php include('_south.php'); ?>
    <script type="text/javascript"> 
        $(document).ready(function(){ 
            $('#mianOver').scroll(function(event) {  
                $("#mianOver").mousedown();
            });  
        });
        function AutoHeight() {//根据浏览器大小控制网页大小
            var Height_Page = window.document.body.clientHeight;
            var Width_Page = window.document.body.clientWidth;
            var Height_Page_Using = document.documentElement.clientHeight;
            var Width_Page_Using = document.documentElement.clientWidth;
            var Head = document.getElementById("headerbox");
            var Footer = document.getElementById("footerBox");
            var Mian = document.getElementById('mianContent');
            var Sider = document.getElementById('siderBox');
            var Omian = document.getElementById('mianOver');  
            var Crumb = document.getElementById('navCrumb'); 
            if (getBrowser() == "msie7.0" || getBrowser() == "msie6.0" || getBrowser() == "msie5.0") {
                
                var Height_Top = Head.offsetHeight;
                var Width_Sider = Sider.offsetWidth;
                var Height_Crumb = Crumb.offsetHeight; 
                var Height_Bottom = Footer.offsetHeight; 
                //若以上无效，则采用(主要是IE6.0，5.0需要)
                if (Height_Page > Height_Page_Using) {
                    Height_Page = Height_Page_Using;
                }
               if (Width_Page > Width_Page_Using) {
                    Width_Page = Width_Page_Using;
                }
                if(Width_Page<1220){
                    Head.style.width ='1220px';
                    Omian.style.width =(1220 - Width_Sider)+'px'; 
                    Crumb.style.width =(1220 - Width_Sider)+'px';  
                }else{
                    Head.style.width='auto';
                    Omian.style.width =(Width_Page - Width_Sider)+'px'; 
                    Crumb.style.width =(Width_Page - Width_Sider)+'px';
                } 
                Mian.style.height = (Height_Page - Height_Top - Height_Bottom) + "px";
                Sider.style.height = (Height_Page - Height_Top - Height_Bottom) + "px";
                Omian.style.height = (Height_Page - Height_Top - Height_Bottom - Height_Crumb)+"px"; 
            } else {
                var Width_Siders = Sider.offsetWidth;
                if(Width_Page<1220){
                    Head.style.width ='1220px';
                    Omian.style.width =(1220 - Width_Siders)+'px'; 
                    Crumb.style.width =(1220 - Width_Siders)+'px';  
                }else{
                    Omian.style.width =(Width_Page - Width_Siders)+'px'; 
                    Crumb.style.width =(Width_Page - Width_Siders)+'px';
                    Head.style.width='auto';
                }
                
                Mian.style.height = Height_Page-118+"px";
                Sider.style.height = Height_Page-118+"px";
                Omian.style.height = Height_Page-162+"px"; 
            }
        } 
        function getBrowser() {//浏览器判断
            var Sys = {};
            var ua = navigator.userAgent.toLowerCase();
            var re = /(msie|firefox|chrome|opera|version).*?([\d.]+)/;
            var m = ua.match(re);
            Sys.browser = m[1].replace(/version/, "'safari");
            Sys.ver = m[2];
            return Sys.browser + Sys.ver;
        }
        window.onresize = function() {//改变浏览器大小的时候触发
            AutoHeight();
        }
        window.onload = function() {//页面加载触发
            AutoHeight();
        }

    </script>
    <?php Yii::app()->msg->printMsg(); ?>  
</body>
</html> 