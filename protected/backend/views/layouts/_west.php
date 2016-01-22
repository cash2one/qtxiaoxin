<style type="text/css">
.panel {
    margin-bottom: 0px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 0px;
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.05);
    box-shadow: 0 1px 1px rgba(0,0,0,0.05);
}
a.layout-button-left{ display: none !important;}
a.accordion-collapse{ display: none !important;}
.accordion { border: none !important; }
.nav{}
</style>
<?php
    $usertasks =  Uaccess::getTasks();

    $toptag = Menu::getTopTag($this);
    $subtag = Menu::getSubTag($this);
?>

<div id="siderBox"  style="width:180px;_width:186px; float: left; height: 900px; overflow: hidden; padding:0px; background-color: #335ea0;">
    <div id="firstpane" class="menu_list" style="position: relative;">
        <?php $business_tasks = array('商家列表','创建商家','编辑商家'); ?>
        <?php if(count(array_intersect($business_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='business'){echo ' active';} ?>">商家管理</p>
        <div class="menu_body" style="<?php if($toptag=='business'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:172px; padding: 0; margin: 0;  " >
                <?php if(in_array('商家列表',$usertasks)): ?>
                   <li class="<?php if($subtag=='business_list'){echo ' active';} ?>">
                       <a href="<?php echo Yii::app()->createUrl('business/index');?>">商家列表</a>
                   </li>
                <?php endif; ?>

                <?php if(in_array('创建商家',$usertasks)): ?>
                   <li class="<?php if($subtag=='business_create'){echo ' active';} ?>">
                       <a href="<?php echo Yii::app()->createUrl('business/create');?>">创建商家</a>
                   </li>
                <?php endif; ?>

                <?php if(in_array('编辑商家',$usertasks)): ?>
                   <li class="<?php if($subtag=='business_admin'){echo ' active';} ?>">
                       <a href="<?php echo Yii::app()->createUrl('business/admin');?>">编辑商家</a>
                   </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php $advertisement_tasks = array('广告列表','创建广告','编辑广告','开放广告'); ?>
        <?php if(count(array_intersect($advertisement_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='advertisement'){echo ' active';} ?>">广告管理</p>
        <div class="menu_body" style="<?php if($toptag=='advertisement'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  ">
                <?php if(in_array('广告列表',$usertasks)): ?>
                <li class="<?php if($subtag=='adv_list'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('adv/index');?>">广告列表</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('创建广告',$usertasks)): ?>
                <li class="<?php if($subtag=='adv_create'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('adv/create');?>">创建广告</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('编辑广告',$usertasks)): ?>
                <li class="<?php if($subtag=='adv_admin'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('adv/admin');?>">编辑广告</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('开放广告',$usertasks)): ?>
                <li class="<?php if($subtag=='adv_public'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('adv/public');?>">开放广告</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php $focus_tasks = array('热点列表','创建热点','编辑热点','开放热点'); ?>
        <?php if(count(array_intersect($focus_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='focus'){echo ' active';} ?>">热点管理</p>
        <div class="menu_body" style="<?php if($toptag=='focus'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  ">
                <?php if(in_array('热点列表',$usertasks)): ?>
                <li class="<?php if($subtag=='focus_list'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('focus/index');?>">热点列表</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('创建热点',$usertasks)): ?>
                <li class="<?php if($subtag=='focus_create'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('focus/create');?>">创建热点</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('编辑热点',$usertasks)): ?>
                <li class="<?php if($subtag=='focus_admin'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('focus/admin');?>">编辑热点</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('开放热点',$usertasks)): ?>
                <li class="<?php if($subtag=='focus_public'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('focus/public');?>">开放热点</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php $info_tasks = array('资讯列表','创建资讯','编辑资讯','开放资讯'); ?>
        <?php if(count(array_intersect($info_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='info'){echo ' active';} ?>" >资讯管理</p>
        <div class="menu_body" style="<?php if($toptag=='info'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  ">
                <?php if(in_array('资讯列表',$usertasks)): ?>
                <li class="<?php if($subtag=='info_list'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('information/index');?>">资讯列表</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('创建资讯',$usertasks)): ?>
                <li class="<?php if($subtag=='info_create'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('information/create');?>">创建资讯</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('编辑资讯',$usertasks)): ?>
                <li class="<?php if($subtag=='info_admin'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('information/admin');?>">编辑资讯</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('开放资讯',$usertasks)): ?>
                <li class="<?php if($subtag=='info_public'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('information/public');?>">开放资讯</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php $good_tasks = array('商品列表','创建商品','编辑商品','虚拟卡列表','创建虚拟卡','编辑虚拟卡','商家专区','订单管理'); ?>
        <?php if(count(array_intersect($good_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='goods'){echo ' active';} ?>" >商品管理</p>
        <div class="menu_body" style="<?php if($toptag=='goods'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  ">
                <?php if(in_array('商品列表',$usertasks)): ?>
                <li class="<?php if($subtag=='goods_list'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('goods/index');?>">商品列表</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('创建商品',$usertasks)): ?>
                <li class="<?php if($subtag=='goods_create'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('goods/create');?>">创建商品</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('编辑商品',$usertasks)): ?>
                <li class="<?php if($subtag=='goods_admin'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('goods/admin');?>">编辑商品</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('虚拟卡列表',$usertasks)): ?>
                <li class="<?php if($subtag=='gcard_index'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('gcard/index');?>">虚拟卡列表</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('创建虚拟卡',$usertasks)): ?>
                <li class="<?php if($subtag=='gcard_create'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('gcard/create');?>">创建虚拟卡</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('编辑虚拟卡',$usertasks)): ?>
                <li class="<?php if($subtag=='gcard_admin'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('gcard/admin');?>">编辑虚拟卡</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('商家专区',$usertasks)): ?>
                <li class="<?php if($subtag=='gcard_business'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('gcard/business');?>">商家专区</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('订单管理',$usertasks)): ?>
                <li class="<?php if($subtag=='mg_order'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('order/index');?>">订单管理</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php $contract_tasks = array('合同列表','创建合同','编辑合同','审核合同','广告位查询'); ?>
        <?php if(count(array_intersect($contract_tasks,$usertasks))): ?>
        <p id="test" class="menu_head<?php if($toptag=='contract'){echo ' active';} ?>">合同管理</p>
        <div class="menu_body" style="<?php if($toptag=='contract'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  " >
                <?php if(in_array('合同列表',$usertasks)): ?>
                <li class="<?php if($subtag=='contract_list'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('contract/index');?>">合同列表</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('创建合同',$usertasks)): ?>
                <li class="<?php if($subtag=='contract_create'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('contract/create');?>">创建合同</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('编辑合同',$usertasks)): ?>
                <li class="<?php if($subtag=='contract_admin'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('contract/admin');?>">编辑合同</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('审核合同',$usertasks)): ?>
                <li class="<?php if($subtag=='contract_document'){echo ' active';} ?>">
                    <?php $conCount=Contract::countConStateData(1);?>
                    <a href="<?php echo Yii::app()->createUrl('contract/document');?>">审核合同
                        &nbsp; &nbsp;<?php if($conCount): ?><span style=" width: 25px; height: 25px;   line-height: 25px; text-align: center; margin-top: 6px; background-color: red; color: white; display: inline-block; border-radius: 12px; "><?php echo $conCount; ?></span><?php endif; ?>
                    </a>
                </li>
                <?php endif; ?>
                <?php if(in_array('广告位查询',$usertasks)): ?>
                <li class="<?php if($subtag=='contract_adv'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('contract/adv');?>">广告位查询</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php $gird_tasks = array('商品统计','广告统计','资讯统计','热点统计','安装量统计'); ?>
        <?php if(count(array_intersect($gird_tasks,$usertasks))): ?>
        <p id="test" class="menu_head<?php if($toptag=='gird'){echo ' active';} ?>">数据分析</p>
        <div class="menu_body" style="<?php if($toptag=='gird'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  " >
                <?php if(in_array('商品统计',$usertasks)): ?>
                <li class="<?php if($subtag=='girdgoods'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('gird/goods/index');?>">商品统计</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('广告统计',$usertasks)): ?>
                <li class="<?php if($subtag=='girdadvs'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('gird/advs/index');?>">广告统计</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('资讯统计',$usertasks)): ?>
                <li class="<?php if($subtag=='girdinfos'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('gird/infos/index');?>">资讯统计</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('热点统计',$usertasks)): ?>
                <li class="<?php if($subtag=='girdfocs'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('gird/focs/index');?>">热点统计</a>
                </li>
                <?php endif; ?>
				<?php if(in_array('安装量统计',$usertasks)): ?>
                <li class="<?php if($subtag=='statistic'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('statistic/index');?>">安装量统计</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>


        <?php $campus_tasks = array('学校管理','班级管理','部门管理','科目管理','课程分配','职务管理','分组管理'); ?>
        <?php if(count(array_intersect($campus_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='schoolmanage'){echo ' active';} ?>">校园管理</p>
        <div class="menu_body"style="<?php if($toptag=='schoolmanage'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  ">
                <?php if(in_array('学校管理',$usertasks)): ?>
                <li class="<?php if($subtag=='school'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('school/index');?>">学校管理</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('班级管理',$usertasks)): ?>
                <li class="<?php if($subtag=='class'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('class/index');?>">班级管理</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('部门管理',$usertasks)): ?>
                <li class="<?php if($subtag=='department'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('part/index');?>">部门管理</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('科目管理',$usertasks)): ?>
                <li class="<?php if($subtag=='subject'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('subject/index');?>">科目管理</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('课程分配',$usertasks)): ?>
                <li class="<?php if($subtag=='courses'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('courses/index');?>">课程分配</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('职务管理',$usertasks)): ?>
                <li class="<?php if($subtag=='duty'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('duty/index');?>">职务管理</a>
                </li>
                <?php endif; ?>
				 <?php if(in_array('分组管理',$usertasks)): ?>
                <li class="<?php if($subtag=='group'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('group/index');?>">分组管理</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>


        <?php $member_tasks = array('教师管理','学生管理'); ?>
        <?php if(count(array_intersect($member_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='member'){echo ' active';} ?>">用户管理</p>
        <div class="menu_body"style="<?php if($toptag=='member'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  ">
                <?php if(in_array('教师管理',$usertasks)): ?>
                <li class="<?php if($subtag=='teacher'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('teacher/index');?>">教师管理</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('学生管理',$usertasks)): ?>
                <li class="<?php if($subtag=='student'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('student/index');?>">学生管理</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>


        <?php $user_tasks = array('账号列表','创建账号','编辑账号'); ?>
        <?php if(count(array_intersect($user_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='user'){echo ' active';} ?>" >账号管理</p>
        <div class="menu_body" style="<?php if($toptag=='user'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  ">
                <?php if(in_array('账号列表',$usertasks)): ?>
                <li class="<?php if($subtag=='user_list'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('user/index');?>">账号列表</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('创建账号',$usertasks)): ?>
                <li class="<?php if($subtag=='user_create'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('user/create');?>">创建账号</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('编辑账号',$usertasks)): ?>
                <li class="<?php if($subtag=='user_admin'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('user/admin');?>">编辑账号</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>


        <?php $official_tasks = array('公众号创建','公众号管理','公众号消息管理','公众号数据统计','公众号粉丝管理'); ?>
        <?php if(count(array_intersect($official_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='official'){echo ' active';} ?>">公&nbsp;&nbsp;众&nbsp;&nbsp;号</p>
        <div class="menu_body"style="<?php if($toptag=='official'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  ">
                <?php if(in_array('公众号创建',$usertasks)): ?>
                <li class="<?php if($subtag=='official_create'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('official/create');?>">创建公众号</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('公众号管理',$usertasks)): ?>
                <li class="<?php if($subtag=='official_list'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('official/index');?>">公众号管理</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('公众号消息管理',$usertasks)): ?>
                <li class="<?php if($subtag=='official_message'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('official/message');?>">消息管理</a>
                </li>
                <?php endif; ?>

                <?php if(in_array('公众号数据统计',$usertasks)): ?>
               <!--  <li class="<?php if($subtag=='official_datastat'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('official/datastat');?>">数据统计</a>
                </li> -->
                <?php endif; ?>
                <?php if(in_array('公众号粉丝管理',$usertasks)): ?>
                <!-- <li class="<?php if($subtag=='official_fans'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('official/fans');?>">粉丝管理</a>
                </li> -->
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php $kpi_tasks = array('绩效积分','排行榜','考核配置','历史评分','修改人数限定','考核白名单'); ?>
        <?php if(count(array_intersect($kpi_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='kpi'){echo ' active';} ?>">绩效管理</p>
        <div class="menu_body" style="<?php if($toptag=='kpi'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0; ">
                <?php if(in_array('绩效积分', $usertasks)): ?>
                <li class="<?php if($subtag=='kpi_index'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('kpi/index');?>">绩效积分</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('排行榜', $usertasks)): ?>
                <li class="<?php if($subtag=='kpi_ranking'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('kpi/ranking');?>">排行榜</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('修改人数限定', $usertasks)): ?>
                    <li class="<?php if($subtag=='kpi_configure'){echo ' active';} ?>">
                        <a href="<?php echo Yii::app()->createUrl('kpi/configure');?>">修改人数限定</a>
                    </li>
                <?php endif; ?>
                <?php if(in_array('考核白名单', $usertasks)): ?>
                    <li class="<?php if($subtag == 'kpi_scorelimit'){echo ' active';} ?>">
                        <a href="<?php echo Yii::app()->createUrl('kpi/scorelimit');?>">考核白名单</a>
                    </li>
                <?php endif; ?>
                <?php if(in_array('历史评分', $usertasks)): ?>
                    <li class="<?php if($subtag=='kpi_log'){echo ' active';} ?>">
                        <a href="<?php echo Yii::app()->createUrl('kpi/log');?>">历史评分</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php $srbac_tasks = array('功能权限','管理范围'); ?>
        <?php if(count(array_intersect($srbac_tasks,$usertasks))): ?>
        <p class="menu_head<?php if($toptag=='srbac'){echo ' active';} ?>">权限管理</p>
        <div class="menu_body" style="<?php if($toptag=='srbac'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0; ">
                <?php if(in_array('功能权限',$usertasks)): ?>
                <li class="<?php if($subtag=='srbac'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('srbac');?>">功能权限</a>
                </li>
                <?php endif; ?>
                <?php if(in_array('管理范围',$usertasks)): ?>
                <li class="<?php if($subtag=='user_access'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('user/access');?>">管理范围</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php endif; ?>

        <p class="menu_head<?php if($toptag=='account'){echo ' active';} ?>">个人设置</p>
        <div class="menu_body"style="<?php if($toptag=='account'){echo ' display:block;';} ?>">
            <ul class="navs bs-sidenav" style="clear: both; *width:174px; padding: 0; margin: 0;  ">
                <li class="<?php if($subtag=='account_set'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('user/account');?>">个人资料</a>
                </li>
                <li class="<?php if($subtag=='account_password'){echo ' active';} ?>">
                    <a href="<?php echo Yii::app()->createUrl('user/password');?>">修改密码</a>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        $("#firstpane p.menu_head").click(function(){
            //$(this).addClass('active').next("div.menu_body").slideToggle().siblings("div.menu_body").slideUp("slow");
            $(this).toggleClass('active').next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
            $(this).siblings().removeClass("active");
        });
    </script>
</div>
