<style type="text/css">
	.stat_list {width:600px; padding: 0;  }
	.itme { clear: both; margin-bottom: 20px; overflow: hidden; border-bottom: 1px solid #E5E5E5;}
	.itme .itme_title{ font-size: 14px;  margin-bottom: 10px; color: #000000; }
	.barbox{ width:600px; font-size: 14px; line-height: 1.5em; color:#777777;  overflow: hidden; padding-left: 10px; margin-bottom: 0; }
	.barbox dt{width:100%; clear: both; margin:5px 0; color: #000000; padding: 0; font-weight: 100;}
	.barbox dd{ margin: 5px 300px 15px 0; border: 1px solid #335EA0; line-height: 20px;}
    .barbox dd.barline{ height:1.0em; overflow:hidden; display: inline-block;} 
    .barbox dd.last{width: 290px; margin-right: 0; float: right; text-align: left; color: #777777; border:none;} 
    .barbox .bgColor{ display:block; height: 30px; padding: 0px; margin: 0; width: 0%; background: #335EA0;} 
    .viweInfo p span.leftTitle ,.picBox span.titleL{ text-align: right; width: 70px; }
    .picBox .contentS{ margin-left: 70px; }
    .countS{ color:#A2A2A2; margin-left: 10px; }
</style> 
<div class="box">
    <div class="viweInfo">
        <p>
            <span class="leftTitle">问卷标题：</span>
            <?php echo $model->title; ?> <span class="countS"><?php echo $model->countJoin();?> 人参与</span>
        </p>
    </div>
    <div class="picBox">
        <span class="titleL">内容：</span>
        <div class="contentS">
            <div class="stat_list">
                <?php $qn=0;  $item_char = array('1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E','6'=>'F','7'=>'G','8'=>'H','9'=>'I','10'=>'J');
                foreach($model->getFocQuestions() as $q):$qn++; ?>
                <?php $questionjoin = FocusAnswer::getQuestionJoinResult($q->fqid); ?> 
                <div class="itme" <?php if($qn==count($model->getFocQuestions())): echo'style=" border-bottom: none;"'; endif;?>>
                     <div class="itme_title">
                        <span><?php echo $qn; ?>：<?php echo $q->title; ?>(<?php echo $q->getQuestionTypeName(); ?>)</span>
                        <span class="countS"><?php if($q->type==2){echo FocusAnswer::getQuestionJoinNumber($q->fqid,'answer');}else{echo $questionjoin['question'];} ?>人参与</span>
                        <?php if($q->type==2): ?>
                            <a href="<?php echo Yii::app()->createUrl('gird/focs/replay/'.$q->fqid);?>">查看详情</a>
                        <?php endif; ?>
                    </div>
                        
                    <?php $tn=0; if($q->type!=2): ?>
                    <dl class="barbox">
                        <?php foreach($q->getQuestionItems() as $t):$tn++; ?>
                            <dt><?php echo $item_char[$tn]; ?>.<?php echo $t->title; ?></dt>
                            <?php $percentage = FocusAnswer::getItemJoinPercentage($questionjoin,$t->fqiid); ?>
                            <dd class="last"><?php echo $percentage; ?>%&nbsp;，共<?php echo isset($questionjoin['items'][$t->fqiid])?$questionjoin['items'][$t->fqiid]:0; ?>人选择此项</dd>
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
    </div> 
</div>
