<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta content="yes" name="apple-mobile-web-app-capable" /> 
<meta content="black" name="apple-mobile-web-app-status-bar-style" /> 
<meta content="telephone=no" name="format-detection" /> 
<title><?php echo '积分规则'; ?></title>
<meta name="description" content="">
<meta name="keywords" content="">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/api/style.css">
<style type="text/css">
    body { background-color: #EFEFF4; }
	/* 内容 */
	#content{ padding:0; background:#EFEFF4;  }
	.path{ padding:0 0 5px 5px;   } 
/*	 效果导航 
	.effectNav{ margin-top:10px;  border-top:1px solid #666; background:#999; padding-bottom:10px; }
	.effectNav h3{ padding:0 10px; background:#ddd; background:#333; color:#fff;  }
	.effectNav ul{ font-size:0;}
	.effectNav li{ display:inline-block; font-size:12px; padding:0 10px; margin:10px 0 0 10px;  background:#cdcdcd;  }
	.effectNav li.new{ background:#fce8cd;  } */
	/* 本例子css -------------------------------------- */
	.tabBox .hd{ height:40px; line-height:40px; padding:0px; font-size:18px; position:relative;  background:#fff; }
	.tabBox .hd ul{ width:100%; position:absolute; height:41px; top:0; overflow:hidden;  }
	.tabBox .hd ul li{ text-align: center; width:50%; float:left; padding:0px; color:#666; border:1px solid #f1f1f1; border-top:none;  }
	.tabBox .hd ul .on{ width:49.3%; border-bottom: 5px solid #26C1B1; border-right: none; border-left: none;   background:#fff; color:#CF7F21;   }
	.tabBox .hd ul .on a{ color: #26C1B1; display:block; /* 修复Android 4.0.x 默认浏览器当前样色无效果bug */  }
	.tabBox .hd ul li a{color:#646464; }
    .tabBox .bd ul{ padding: 10px 0; }
	.tabBox .bd li{ line-height:33px; }
    .tabBox .bd ul li.whiteBg{ padding: 10px 8px; background-color: white; font-size:14px; color: #4c4c4c; border-top:1px solid #DBDBDB; border-bottom: 1px solid #DBDBDB;  }
    .whiteBg p.span{ text-indent: 2em;}
    .tabBox .bd ul li .box{ padding: 5px 15px;}
    .tabBox .bd ul li .fontInfo{ text-indent: 2.0em; }
    .tabBox .bd ul li .title{ color: #89898A; font-size: 13px; padding: 0 15px; }
	.tabBox .bd li a{ color:#666;  }
	.tabBox .bd li a{ -webkit-tap-highlight-color:rgba(0,0,0,0); }  /* 去掉链接触摸高亮 */
</style>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/api/TouchSlide.1.1.js"></script>
</head>
<body>
    <div class="layoutMain">
    	<div id="content"> 
			<div id="leftTabBox" class="tabBox">
				<div class="hd">
					<ul>
						<li><a href="javascript:;">积分规则</a></li>
						<li><a href="javascript:;">常见问题</a></li> 
					</ul>
				</div>
				<div class="bd">
						<ul>
                            <li class="whiteBg"> 
                                <p>1. 老师在网页或手机应用端进行以下操作可获得相应积分:</p>
                                <p class="span">&nbsp;&nbsp;&nbsp;&nbsp;任务&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;奖励</p>
                                <p class="span">发布成绩&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最高20/天</p>
                                <p class="span">发布表现&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最高20/天</p>
                                <p class="span">发布作业&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最高30/天</p>
                                <p class="span">发布通知&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最高30/天</p>
                                <p>2. 班主任特权</p>
                                <p>激活一个新家长用户，赠送20青豆。 </p><br>


                                <p> 积分使用：</p>
                                <p> 1. 可以在应用内商城里兑换虚拟或实物礼品。</p>
                                <p>2. 请留意兑换礼物的有效期限，确保在有效期内使用，否则过期作废。</p>
                            </li> 
						</ul>
                    <ul>
                        <li class="whiteBg">
                            <p> 问：我能实时查看青豆数量吗？</p>
                            <p>答：青豆数量每天统计一次，所以你只能查看今天之前每天的青豆详情。</p><br>
                        
                            <p>问：我能在网页版中兑换礼品吗？</p>
                            <p>答：目前只能通过手机应用端的商城进行兑换。</p><br>
                       
                            <p>问：青豆能转让吗？</p>
                            <p>答：青豆不能转让，只能个人使用。</p><br>
                        
                            <p>问：为什么我发布了消息，却没有获得青豆？</p>
                            <p>答：手机应用端接收成功后，才会计算青豆奖励。</p>
                        </li>
                    </ul> 
				</div>
			</div>
			<script type="text/javascript">TouchSlide({ slideCell:"#leftTabBox",effect:"leftLoop" }); </script>
        </div>
    </div>
</body>
</html>  