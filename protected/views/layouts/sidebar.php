 <div id="subnavBox" class="subnavBox">
    <div class="logo" style="height:136px;text-align:center;border-bottom: 1px solid #DE2D2F;">
        <a href="#" title="蜻蜓校信">
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/logo_ico.png" alt="蜻蜓校信" >
        </a>
        <!-- <a class="btn btn-default" href="<?php echo Yii::app()->createUrl('xiaoxin/default/gotonewplatform');?>">使用新版本</a>-->
    </div>
    <div id="menuBox" class="menuBox borderBottom">
         <?php 
            $identity = Yii::app()->user->getIdentity();
            //$apps = NoticeQuery::getAllApplication($identity);
            if(empty($identity)){
               $url=Yii::app()->createUrl('xiaoxin/default/login');
               echo "<script>location.href='".$url."'</script>";exit();
            }
            if($identity==1){
                $apps = NoticeService::getAppByUid(Yii::app()->user->id);
               // $apps = NoticeQuery::getAllApplication($identity);
            }else{
                $apps = NoticeQuery::getAllApplication($identity);
            }
            $myapps = NoticeQuery::getMyApplicationPks(Yii::app()->user->id);
            $lightup =  XiaoxinMenu::appTipCodeArr($myapps);
            $submenu =  XiaoxinMenu::getSubMenu($this);
            // var_dump($submenu);exit;
        ?>
        <ul class="menuList borderBottom" style="border-top: 1px solid #f0767c;">
            <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/default/index');?>" class="<?php echo XiaoxinMenu::getTopCss($this,'home'); ?>"><em class="pngIco4"></em>首页</a></li>
            <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/notice/noticecenter');?>" class="<?php echo XiaoxinMenu::getTopCss($this,'notices'); ?>"><em class="pngIco1"></em>消息中心</a></li>
            <?php if($identity==1): ?>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/application/index');?>" <?php if(!in_array($submenu,$lightup)): ?>class="<?php echo XiaoxinMenu::getTopCss($this,'daily'); ?>"<?php endif; ?>><em class="pngIco2"></em>日常工作</a></li> 
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/index');?>" class="<?php echo XiaoxinMenu::getTopCss($this,'myclass'); ?>"><em class="pngIco3"></em>我的班级</a></li> 
            <?php else: ?>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/baby/index');?>" class="<?php echo XiaoxinMenu::getTopCss($this,'mybaby'); ?>"><em class="pngIco3"></em>我的孩子</a></li> 
            <?php endif; ?>
        </ul>
        <?php if($identity==1 && count($apps)): ?>
        <ul id="menuListBoxs" class="menuList borderTop">
            <?php foreach($apps as $app): ?>
            <li id="menuItme_<?php echo $app['appid'];?>" style="<?php if(!in_array($app['appid'],$myapps)){echo 'display:none;';} ?>">
                <a href="<?php echo $app['url']; ?>" class="<?php echo XiaoxinMenu::getSubCss($this,XiaoxinMenu::appTipCode($app['appid'])); ?>"><i class="<?php echo XiaoxinMenu::appTipIco($app['appid']); ?>"></i><?php echo $app['name']; ?></a>
            </li>
            <?php endforeach; ?> 
         </ul>
        <?php endif; ?>
    </div>
    <div class="userInfo borderTop"> 
            <div class="picBox"><img width="40px;" height="40px" src="<?php  echo Yii::app()->user->defaultPhoto();//echo STORAGE_QINNIU_XIAOXIN_TX.Yii::app()->user->getExtInstance()->photo; ?>" onerror="javascript:this.src='<?php echo Yii::app()->user->defaultPhoto(); ?>'" /></div>
            <div class="userName">
                <span>
                    <a class="fright" href="<?php echo Yii::app()->createUrl('xiaoxin/default/logout');?>">注销</a>
                    <?php $userName=Yii::app()->user->getRealName();?>
                    <a class="name" title="<?php echo $userName; ?>" href="<?php echo Yii::app()->createUrl('xiaoxin/default/account');?>"><?php echo $userName; ?></a>
                </span>
            </div> 
    </div>
    
</div>