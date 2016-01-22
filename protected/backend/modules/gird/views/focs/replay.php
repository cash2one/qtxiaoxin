<style>
.viweInfo p span.leftTitle ,.picBox span.titleL{ text-align: right; width: 70px; }
.picBox .contentS{ margin-left: 70px; }
.countS{ color:#A2A2A2; margin-left: 10px; }
.conmentList{ padding: 0; margin: 0; }
.conmentList li{padding: 0px 0 15px 0; list-style: none; border-bottom: 1px solid #E5E5E5; margin-bottom: 15px;}
.conmentList li p.title{ color:#A2A2A2; }
</style>
<div class="box">
    <div class="viweInfo">
        <p>
            <span class="leftTitle">问题：</span>
            <?php echo $model->title; ?>(<?php echo $model->getQuestionTypeName(); ?>)
            <span class="countS"><?php echo FocusAnswer::getQuestionJoinNumber($model->fqid,'answer'); ?>人参与</span></p>
    </div>
    <div class="picBox">
        <span class="titleL">内容：</span>
        <div class="contentS">
            <ul class="conmentList">
            <?php if(count($data['model'])): ?>
                <?php foreach($data['model'] as $r): ?>
                <li>
                    <p class="title"><?php echo $r->userid; ?></p>
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
    <div id="pager">    
        <?php    
            $this->widget('CLinkPager',array(    
                'header'=>'',    
                'firstPageLabel' => '首页',    
                'lastPageLabel' => '末页',    
                'prevPageLabel' => '上一页',    
                'nextPageLabel' => '下一页',    
                'pages' => $data['pages'],    
                'maxButtonCount'=>9    
                )    
            );    
        ?>    
    </div> 
</div>