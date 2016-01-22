<?php 
	define ("XIAOXIN_LOGIN_IDENTITY", "xiaoxin_login_identity");
	define ("CLIENT_FILE_DOWNLOAD_URL", "http://file27.qtxiaoxin.com/FileHandler.ashx");
	
	if(!file_exists(dirname(__FILE__).'/ConstantsTest.php')){
	    define('OLD_PLATFORM_DOMAIN','http://xxdemo.qtxiaoxin.com');
	    define("NEW_PLATFORM_DOMAIN", "http://newxxdemo.qtxiaoxin.com");
	}else{
	    require_once(dirname(__FILE__).'/ConstantsTest.php');
	}
	


/* 测试环境存储 */	
	define ("STORAGE_QINNIU_BUCKET_TX", "zhoufeng"); //头像图片
	define ("STORAGE_QINNIU_BUCKET_XX", "zhoufeng"); //消息图片
//	define ("STORAGE_QINNIU_XIAOXIN_TX", "http://".STORAGE_QINNIU_BUCKET_TX.".qiniudn.com/"); //头像的图片地址
//	define ("STORAGE_QINNIU_XIAOXIN_XX", "http://".STORAGE_QINNIU_BUCKET_XX.".qiniudn.com/"); //消息的图片地址
	define ("STORAGE_QINNIU_XIAOXIN_TX", "http://7qnbf9.com1.z0.glb.clouddn.com/"); //头像的图片地址
	define ("STORAGE_QINNIU_XIAOXIN_XX", "http://7qnbf9.com1.z0.glb.clouddn.com/"); //消息的图片地址

	define ("STORAGE_QINNIU_ACCESSKEY", "0vga-ps7yxZhnuza6l155sQ6tVGr6SEtYDWK4h7Q");
	define ("STORAGE_QINNIU_SECRETKEY", "4SM6dvjJQvNwdRnApnINdfGwT_KFi0TqsfWDDiyy");


    //校信用户版本
    define('USER_BRANCH','01');
    //站点名称
    define('SITE_NAME','蜻蜓校信');


    //站点域名
    define('SITE_URL','http://www.banban.com');
    //APP下载短域名
    define('SITE_APP_DOWNLOAD_SHORT_URL','http://t.cn/RwU3di3');
    //APP 下载地址
    define('SITE_APP_DOWNLOAD_URL','http://app.banban.im/install');
    //公共号地址
    define('OFFICIAL_URL','http://gzh.qtxiaoxin.com');

    //短信签名
    define("SMS_SIGN","【蜻蜓校信】");



/* 生产环境存储 */
/*
	define ("STORAGE_QINNIU_BUCKET_TX", "qt-person"); //头像图片
	define ("STORAGE_QINNIU_BUCKET_XX", "qtxiaoxin-notice"); //消息图片
//	define ("STORAGE_QINNIU_XIAOXIN_TX", "http://".STORAGE_QINNIU_BUCKET_TX.".qiniudn.com/"); //头像的图片地址
//	define ("STORAGE_QINNIU_XIAOXIN_XX", "http://".STORAGE_QINNIU_BUCKET_XX.".qiniudn.com/"); //消息的图片地址
	define ("STORAGE_QINNIU_XIAOXIN_TX", "http://7sbkpq.com2.z0.glb.clouddn.com/"); //头像的图片地址
	define ("STORAGE_QINNIU_XIAOXIN_XX", "http://7sbkpr.com2.z0.glb.clouddn.com/"); //消息的图片地址

	define ("STORAGE_QINNIU_ACCESSKEY", "HzcT9A03kD3CjOGCInhWIKD800-kFsbnHJZZi07i");
	define ("STORAGE_QINNIU_SECRETKEY", "fkKh0EbdXbkFjJwnJUa-8-OSTB071IL6OJ1cJkct");
*/

