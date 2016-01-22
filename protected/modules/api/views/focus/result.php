<?php
/* @var $this SiteController */
// echo "<pre>";
// var_dump($model);
?>
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
	.header .title{ font-size: 20px; font-weight: bold; padding-top:10px;  color: #000000; word-wrap : break-word; white-space:normal;}
    .header .datetime{ font-size: 16px; color: #a2a2a2; padding: 8px 0;  } 
	.stat_list { padding: 10px 0; width: 100%; }
	.itme { clear: both; margin-bottom: 30px; overflow: hidden;}
	.itme .itme_title{ font-size: 17px;  margin-bottom: 10px; color: #000000; }
    .itme .itme_title a{text-decoration: none; color: #3883F9; }
	.barbox{font-size: 17px; line-height: 1.5em; color:#777777;  overflow: hidden; padding-left: 10px; }
	.barbox dt{width:100%; clear: both; margin:5px 0; color: #000000; padding: 0;}
	.barbox dd{ margin: 5px 65px 5px 0; border: 1px solid #3883f9; line-height: 35px;}
    .barbox dd.barline{ height:1.0em; overflow:hidden; display: inline-block;}
    .barbox dd.last{width: 60px; margin-right: 0; float: right; text-align: left; color: #777777; border:none;} 
    .barbox .bgColor{ display:block; height: 40px; padding: 0px; margin: 0; width: 0%; background: #3883F9;}
    .countS{ color:#A2A2A2; margin-left: 10px; }
</style>
</head>
   <div class="layout_main">
   	<div class="header"> 
            <h1 class="title">
                <?php echo $model->title; ?> 
            </h1>
            <div class="datetime">
                <span><?php echo date('Y-m-d H:i',strtotime($relation->enddate));?> &nbsp;&nbsp;</span>
                <span>投票人数：<?php echo $model->total; ?></span>
            </div> 
        </div> 
    	<div class="stat_list">
            <?php $qn=0;  $item_char = array('1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E','6'=>'F','7'=>'G','8'=>'H','9'=>'I','10'=>'J');
            foreach($model->getFocQuestions() as $q):$qn++; ?>
            <?php $questionjoin = FocusAnswer::getQuestionJoinResult($q->fqid); ?> 
            <div class="itme">
 
                <div class="itme_title">
                    <span><?php echo $qn; ?>：<?php echo $q->title; ?>(<?php echo $q->getQuestionTypeName(); ?>) </span>
                    <span class="countS"><?php if($q->type==2){echo FocusAnswer::getQuestionJoinNumber($q->fqid,'answer');}else{echo $questionjoin['question'];} ?>人参与</span>
                    <?php if($q->type==2): ?>
                        <a href="<?php echo Yii::app()->createUrl('api/focus/replay/'.$q->fqid);?>">点击查看（50条最新评论）</a>
                    <?php endif; ?>
                </div> 
                <?php $tn=0; if($q->type!=2): ?>
                <dl class="barbox">
                    <?php foreach($q->getQuestionItems() as $t):$tn++; ?>
                        <dt><?php echo $item_char[$tn]; ?>.<?php echo $t->title; ?></dt>
                        <?php $percentage = FocusAnswer::getItemJoinPercentage($questionjoin,$t->fqiid); ?>
                        <dd class="last"><?php echo $percentage; ?>%</dd>
                        <dd> 
                            <div class="bgColor" style="width: <?php echo $percentage; ?>%;"></div>
                        </dd>
                    <?php endforeach; ?>
                </dl> 
                <?php endif; ?>
            </div>
            <?php endforeach; ?> 
    	</div>
    </div> 
</body>
</html>