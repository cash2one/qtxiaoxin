 <?php if(get_class($model)=='Focus') : ?>
    <h3><?php echo $model->title; ?></h3> 
    <div class="prompt">
         <img src="<?php echo $model->image; ?>" width="365px">
     </div>
    <div class="centent">
     <?php if($model->type==0){?>  
         <div style=" table-layout:fixed; word-break: break-all;"> 
             <?php echo $model->text; ?> 
         </div>
         <?php }else if($model->type==1){ ?> 
             <div style="display:inline-block; table-layout:fixed; word-break: break-all;"> 
                 <div class="issueListBox"> 
                     <?php $qn=0; 
                         $item_char = array('1'=>'A','2'=>'B','3'=>'C','4'=>'D','5'=>'E','6'=>'F','7'=>'G','8'=>'H','9'=>'I','10'=>'J');
                     foreach($model->getFocQuestions() as $q){$qn++; ?>
                     <div class="itme">
                         <p style="table-layout:fixed; word-break: break-all; overflow:hidden;">问题<?php echo $qn; ?>：<?php echo $q->title; ?>(<?php echo $q->getQuestionTypeName(); ?>)</p>
                         <table class="tableForm">
                             <?php $tn=0; if($q->type!=2){foreach($q->getQuestionItems() as $t){$tn++; ?>
                             <tr>
                                 <?php if($q->type==1){ ?>
                                 <td class="inputBox" width="20px;"><input type="checkbox" name="question_<?php echo $qn; ?>"></td>
                                     <td><?php echo $item_char[$tn]; ?>：<?php echo $t->title; ?></td>
                                 <?php } ?>

                                 <?php if($q->type==0){ ?>
                                     <td class="inputBox" width="20px;"><input type="radio" name="question_<?php echo $qn; ?>"></td>
                                     <td><?php echo $item_char[$tn]; ?>：<?php echo $t->title; ?></td>
                                 <?php } ?>
                             </tr>

                             <?php }}else{ ?>
                             <tr> 
                                 <td><textarea style=" width: 100%; height: 50px;"></textarea></td>
                             </tr>
                             <?php } ?>
                         </table>
                     </div>
                     <?php } ?>
                 </div>
             </div>
         <?php }else if($model->type==2){?>
         <p>链接</p>
         <p><?php echo $model->url; ?></p>
         <?php }?> 
     </div> 
<?php else: ?>
    <h3><?php echo $model->title; ?></h3> 
    <div class="prompt">
         <img src="<?php echo $model->image; ?>" width="365px">
     </div>
    <div style="display:inline-block;table-layout:fixed; word-break: break-all;"></div>
    <div class="centent" style="padding: 0 5px;"  ><?php echo $model->text; ?></div>
<?php endif; ?> 