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
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/mobile/js/prefixfree.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jquery-1.9.1.js"></script>  
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/mobile/js/jquery.validate.js"></script>
<script type="text/javascript"> 

$(document).ready(function() {//表单验证
    $("#form1").validate(); 
});
</script>
<style type="text/css">
    .layout_main{ width: auto; padding: 0 8px; }
    .header .title{ font-size: 20px; font-weight: bold; padding-top:10px;  color: #000000; word-wrap : break-word; white-space:normal;}
    .header .datetime{ font-size: 16px; color: #a2a2a2; padding: 8px 0;  } 
    .stat_list {padding: 0px; margin: 0 auto;}
    .stat_list .count{ font-size: 1.2em; padding: 0px; } 
    .stat_list .imgBox{  margin-bottom: 15px; }
    .stat_list .imgBox img{ width: 100%; }
    input.btn{ -webkit-appearance: none; cursor: pointer; background: #5bafec; font-size: 1px; border: 0;}
    input.btn{-webkit-border-radius: .3125em; border-radius: .3125em; background-color: #5bafec; box-shadow: 1px;padding: 6px 20px; font-size: 1.5em; color: #ffffff;  -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.15); -moz-box-shadow: 0 1px 3px rgba(0,0,0,.15); box-shadow: 0 1px 3px rgba(0,0,0,.15);}
    input.btn:hover { background-color: #2bafec; border-color: #ddd;}
    div.titleinfo{ font-size: 0.95em; line-height: 20px; }
    ul.box{width: 100%; margin: 0 auto; display: block; overflow: hidden; padding-top:8px; }
    ul.box li{font-size: 0.95em; margin: 6px auto; padding: 0px; min-height: 25px; line-height: 22px;}
    ul.box li label{padding-left: 3px;}
    ul.box li label.error{ color: red; }
    ul.box li:last-child{ height: 20px; padding: 0; margin-bottom:5px; line-height: 22px;}
    ul.box li span{ line-height: 22px;}
    ul.box li textarea { padding: 5px 10px; -webkit-border-radius:6px; border-radius: 6px; height: 120px; width: 100%;}
</style> 
</head>
<body> 
    <div class="layout_main"> 
        <div class="header"> 
            <h1 class="title">
                <?php echo $model->title; ?>  
            </h1>
            <div class="datetime">有效期：
                <span><?php echo date('Y-m-d',strtotime($relation->startdate));?>&nbsp;至&nbsp;<?php echo date('Y-m-d',strtotime($relation->enddate));?>&nbsp;&nbsp;</span>
                <span>可获青豆：<?php echo PointRelation::getRelationPoint('Focus',$model->fid); ?></span>
            </div> 
        </div>
        <div class="stat_list"> 
            <div class="imgBox" >
                <img src="<?php echo $model->image; ?>">
            </div> 
            <form method="post" action="" id="form1">  
                    <?php $qn=0;  $item_char = array('1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E','6'=>'F','7'=>'G','8'=>'H','9'=>'I','10'=>'J');
                        foreach($model->getFocQuestions() as $q):$qn++; ?>
                            <div class="titleinfo">
                                <?php echo $qn; ?>：<?php echo $q->title; ?>(<?php echo $q->getQuestionTypeName(); ?>) 
                            </div>
                            <ul class="box">
                               <?php $tn=0; if($q->type!=2):foreach($q->getQuestionItems() as $t):$tn++; ?>
                                    <li class=" ">
                                     <?php if($q->type==1): ?>
                                        <label for="check_<?php echo $qn; ?>_<?php echo $t->fqiid; ?>" >
                                            <input type="checkbox" relName="check-box" class="checkbox" id="check_<?php echo $qn; ?>_<?php echo $t->fqiid; ?>" name="Vote[item][<?php echo $qn; ?>][] ?>" value="<?php echo $t->fqiid; ?>" <?php if($tn == 1) { ?> required <?php } ?> minlength="1"  >
                                            <?php echo $item_char[$tn]; ?><?php echo $t->title; ?> 
                                        </label>  
                                     <?php endif; ?>
                                    <?php if($q->type==0): ?>
                                        <label for="radio_<?php echo $qn; ?>_<?php echo $t->fqiid; ?>"> 
                                            <input type="radio" relName="radio-btn" rel="single" qnum="<?php echo $qn; ?>" class="check_<?php echo $qn; ?>" id="radio_<?php echo $qn; ?>_<?php echo $t->fqiid; ?>" name="Vote[item][<?php echo $qn; ?>]" value="<?php echo $t->fqiid; ?>" <?php if($tn == 1): ?> required<?php endif; ?>>
                                            <?php echo $item_char[$tn]; ?><?php echo $t->title; ?>
                                        </label>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <li>
                                            <input type="hidden" name="Vote[answer][<?php echo $qn; ?>][qid]" value="<?php echo $q->fqid; ?>">
                                            <textarea name="Vote[answer][<?php echo $qn; ?>][text]"  required></textarea> 
                                        </li>
                                    <?php endif; ?>
                                    </li>  
                                <li class=" ">
                                    <label for="question_<?php echo $qn; ?>"  style="display: none;" class="error">请选一个选项1</label> 
                                </li> 
                            </ul>  
                        <?php endforeach; ?>
                    <div style="text-align: center; margin:30px 0; ">
                        <input class="btn" type="submit" value="提 交"> 
                        <input type="hidden" name="VoteId" value=" ">
                    </div>
            </form>
        </div> 
    </div> 
</body>
</html>

