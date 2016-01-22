<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta content="yes" name="apple-mobile-web-app-capable" /> 
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<title><?php echo $model->title; ?></title>
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/style.css"> 
<style type="text/css">
.layout_main{ width: auto; padding: 0 8px; height: auto;}
.header .title{  font-size: 20px; font-weight: 700; padding:10px 0 15px 0;  color: #000000; word-wrap : break-word; white-space:normal;}
.countS{ color:#A2A2A2; margin-left: 10px; font-weight: 100;  font-size: 16px;}
.conmentList{ padding: 0; margin: 0; }
.conmentList li{padding: 5px 0 15px 0; list-style: none; border-bottom: 1px solid #E5E5E5; margin-bottom: 15px;}
.conmentList li p.title{ color:#5C5C5C; }
</style>
</head>
    <body>
        <div class="layout_main">
            <div class="header">
                 <div class="title">
                    问题：<?php echo $model->title; ?>(<?php echo $model->getQuestionTypeName(); ?>)
                    <span class="countS"><?php echo FocusAnswer::getQuestionJoinNumber($model->fqid,'answer'); ?>人参与</span>
                 </div>
            </div>
            <div class="picBox"> 
                <ul class="conmentList">
                    <?php if(count($data['model'])): ?>
                        <?php foreach($data['model'] as $r): ?>
                        <li>
                            <p><?php echo $r->text; ?></p>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li style="border-bottom:none;">
                            <p class="title">暂时没人回答，快抢先第一个回答吧！</p>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div> 
    </body>
</html>