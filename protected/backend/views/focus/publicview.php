<div class="box">
    <div class="viweInfo" style="">
        <p><span class="leftTitle">标题：</span><?php echo $model->title; ?></p>
        <p><span class="leftTitle">摘要：</span><?php echo $model->summery; ?></p> 
        <div class="pic" style="padding-left: 85px;"> 
            <img  src="<?php echo $model->image; ?>"> 
        </div>
        <p><span class="leftTitle">投放时间：</span><?php echo $model->getPublicFocRelation()->startdate; ?>&nbsp;至&nbsp;<?php echo $model->getPublicFocRelation()->enddate; ?></p>
    <?php if($model->type==0){?> 
    <p><span class="leftTitle">热点类型：</span>文章</p>
        <div>
            <span style="width: 85px; float: left; color: #999999; display: inline-block;">热点内容：</span> 
            <div style="margin-left: 85px;">
                <?php echo $model->text; ?>
           </div>
        </div>
        <?php }else if($model->type==1){ ?>
        <p><span class="leftTitle" >热点类型：</span>问卷</p>
            <div>
                <span style="width: 85px; color: #999999; float: left;">热点内容：</span> 
                <div class="issueListBox" style=" margin-left: 85px;">  
                    <?php $qn=0; 
                        $item_char = array('1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E','6'=>'F','7'=>'G','8'=>'H','9'=>'I','10'=>'J');
                    foreach($model->getFocQuestions() as $q){$qn++; ?>
                    <div class="itme">
                        <p>问题<?php echo $qn; ?>：<?php echo $q->title; ?>(<?php echo $q->getQuestionTypeName(); ?>)</p>
                        <table class="table table-bordered">
                            <?php $tn=0; if($q->type!=2){foreach($q->getQuestionItems() as $t){$tn++; ?>
                            <tr>
                                <?php if($q->type==1){ ?>
                                    <td  class="leftTd"><input type="checkbox" name="question_<?php echo $qn; ?>"></td>
                                    <td><?php echo $item_char[$tn]; ?>：<?php echo $t->title; ?></td>
                                <?php } ?>

                                <?php if($q->type==0){ ?>
                                    <td class="leftTd"><input type="radio" name="question_<?php echo $qn; ?>"></td>
                                    <td><?php echo $item_char[$tn]; ?>：<?php echo $t->title; ?></td>
                                <?php } ?>
                            </tr>
                            
                            <?php }}else{ ?>
                            <tr>
                                <td class="leftTd">答案</td>
                                <td><textarea style=" width: 100%; height: 50px;"></textarea></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php }else{?>
         <p><span class="leftTitle">热点类型：</span>链接</p> 
        <?php if($model->url){ ?>
            <p class="leftTitle"><span>链接：</span><?php echo $model->url; ?></p>
        <?php }?> 
        <?php } ?>
    </div>
</div>

