<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0,width=device-width,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta name="renderer" content="webkit|ie-comp">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/api/style.css">
    <title></title>
</head>
<body>
<div class="container">
    <div class="header">
        <div class="title" title=""><a class="help" href="<?php echo Yii::app()->createUrl('/api/user/qdrule'); ?>"> </a> 当前积分</div>
        <div class="qindouCount">
            <?php 
                if($score):
                    $tmp = '';
                    foreach ($score as $s):
                       if(empty($tmp)) $tmp =  $s ? 'class="cunt"' :'';
             ?>
                        <span <?php echo $tmp; ?> ><?php echo $s;?></span>
            <?php 
                    endforeach;
                endif;
            ?>
            青豆
        </div>
    </div>
    
    <div class="qindouListBox">
        <ul id="scrollTopBox">
            <?php 
                if($beans):
                foreach($beans as $bean):               
            ?>
            <li>
                <div class="link" tid="0">
                    <a href="javascript:;" class=""><?php echo $bean['date']?></a>
                </div>
                <div class="itemBox gainBox">
                    <span><?php echo $bean['getTotal'];?></span>获得（青豆）
                </div>
                <div class="detailsList">
                    <?php 
                        if(!empty($bean['getBeans'])):
                            foreach($bean['getBeans'] as $getAc): 
                    ?>
                                <p><span><?php echo isset($getAc->rule->name)?$getAc->rule->name:'';?></span> <span class="last"><?php echo $getAc['bean'];?></span></p>
                    <?php 
                            endforeach; 
                        endif;
                    ?>                    
                </div>
                <div class="itemBox expenseBox">
                    <span><?php echo $bean['expendTotal'];?></span>消耗（青豆）
                </div>
                <div class="detailsList">
                     <?php 
                        if(!empty($bean['expendBeans'])):
                          foreach($bean['expendBeans'] as $getAc): 
                    ?>
                            <p><span><?php echo isset($getAc->rule->name)?$getAc->rule->name:'';?></span> <span class="last"><?php echo $getAc['bean'];?></span></p>
                    <?php 
                            endforeach; 
                        endif;
                    ?>  
                </div>
            </li>
        <?php
            endforeach; 
            else:
        ?>
            <li>
                <div class="link" tid="0">
                    <a href="javascript:;" class="up"><?php echo $lastdate;?> 前无更多青豆</a>
                </div> 
            </li>
        <?php    
            endif;
        ?>
        </ul>
        <div class="more" style="">
            <a href="<?php echo $preUrl ? $preUrl : ''; ?>">查看更早 </a>
        </div>
    </div> 
</div> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/zepto.min.js"></script>
<script>
    $(function(){
        $(document).on('touchstart', '.link', function(e){ 
            var _this = $(this);
            if(_this.attr('tid')=="0"){
                _this.find('a').addClass('up');
                _this.parent().find('.detailsList').show();
                _this.attr('tid',1);
            }else{
                _this.find('a').removeClass('up');
                _this.parent().find('.detailsList').hide();
                _this.attr('tid',0);
            }
        });  
    });
</script>
</body>
</html>