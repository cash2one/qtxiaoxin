<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo CHtml::encode(Yii::app()->name); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/bootstrap/dist/css/bootstrap.min.css"> 
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery-1.9.1.js"></script> 
    <style type="text/css">
        body {
            padding-top: 80px;
            padding-bottom: 40px;
            background-color: #007fd7;
        } 
        .form-signin {
            max-width: 380px;
            padding: 19px 29px 29px 39px;
            margin: 0 auto 20px;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            -moz-box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 2px rgba(0, 0, 0, .05);
            overflow: hidden;
        }
        .form-signin div.row{ margin: 5px 0; }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 20px;
        }

        .form-signin label{ font-size: 18px; font-weight: 100;  margin: 10px 0; color: #343434; }
        .form-signin label.size1{ font-size: 14px;}
        .form-signin input[type="text"],
        .form-signin input[type="password"] {
            font-size: 16px !important;
            height: auto !important;
            margin-bottom: 5px;
            padding: 7px 9px !important;
            //background-color: #fff !important; 
        }
        .form-signin input:-webkit-autofill, .form-signin textarea:-webkit-autofill {
            //background-color:#fff !important;
            background-image: none;
            color: rgb(0, 0, 0);
        }
        .form-signin .error_info {
            color: red;
            margin-left: 65px;
        }
        .btn-large{ width: 200px; font-size: 18px;}
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px white inset;
            border: 1px solid #CCC!important;
            height: 27px!important;
            line-height: 27px!important;
            border-radius: 0 4px 4px 0;
        }
    </style>
</head>
<body>
    <!--[if lt IE 9]>
    <style type="text/css">
        #ie9-warning{ width:100%;position:absolute;display:none;top:0px;left:0;background:#ffffe1;padding:5px 0;font-size:16px}
        #ie9-warning p{width:960px;margin:0 auto;text-align:center;}
        #ie9-close{margin-top:-25px;}
    </style>
    <script>
    $(document).ready(function(){
        $("#ie9-warning").slideToggle("slow");
        $("#ie9-close").click(function(){$("#ie9-warning").hide("slow");
        });
    });
    </script>
    <div id="ie9-warning" style="z-index: 9999999999;">
        <p>您正在使用 Internet Explorer 浏览器，由于本页面不兼容Internet Explorer 9以下浏览器，在本页面的显示效果可能有差异。
        <br/> 建议您升级到 
        <a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank">Internet Explorer 9</a> 
        或以下浏览器：<a href="http://www.mozillaonline.com/">Firefox</a> / 
        <a href="http://www.google.com/chrome/?hl=zh-CN">Chrome</a> / 
        <a href="http://www.apple.com.cn/safari/">Safari</a> / 
        <a href="http://www.operachina.com/">Opera</a> 
        诚心为给您带来的不便致歉！
        <a id="ie9-close" class="close" data-dismiss="alert" href="#">×</a>
        </p>
    </div>
<![endif]--> 
    
     

    <div class="container">
    	<?php $form=$this->beginWidget('CActiveForm', array(
    		'htmlOptions'=> array('class'=>'form-signin'),
    		'id'=>'login-form',
    		'enableClientValidation'=>true,
    		'clientOptions'=>array(
    		'validateOnSubmit'=>true, 
    		),
    	)); ?>
     
        <h2 class="form-signin-heading">欢迎使用蜻蜓管理系统</h2>
        <fieldset style=" border: none;">
           	<div class="row">
    	       	<?php echo $form->labelEx($model,'账 号：'); ?>
    	       	<?php echo $form->textField($model,'username',array('placeholder' =>'账号','class'=>'input-block-level')); ?>
    			<?php echo $form->error($model,'username',array('class'=>'error_info')); ?> 
           	</div>
           	<div class="row">
           		<?php echo $form->labelEx($model,'密 码：'); ?>
    			<?php echo $form->passwordField($model,'password',array('placeholder' =>'密码','class'=>'input-block-level')); ?>
    			<?php echo $form->error($model,'password',array('class'=>'error_info')); ?>
           	</div> 
           	<div class="row"> 
                <?php echo $form->label($model,' ',array('style'=>'padding:0 30px;'))?>
    			<?php echo $form->checkBox($model,'rememberMe'); ?>
    			<?php echo $form->label($model,'记住我',array('for'=>'LoginForm_rememberMe','class'=>'size1')); ?>
    			<?php echo $form->error($model,'rememberMe'); ?>
    	    </div>
            <p> 
                <?php echo $form->label($model,' ',array('style'=>'padding:0 30px;'))?>
                <?php echo CHtml::submitButton('登 录',array('class'=>'btn btn-large btn-primary')); ?> 
            </p>
    	</fieldset>
        
    	<?php $this->endWidget(); ?>
    </div>
<script type="text/javascript">
    $(function(){
        $("#LoginForm_username").focus();
    })
</script>
</body> 

</html> 
