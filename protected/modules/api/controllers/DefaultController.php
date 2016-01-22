<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		// $across = Yii::app()->request->getParam('across');
		// if($across){
		// 	echo header("Access-Control-Allow-Origin:".$across);
		// }
		
		$data = array(
			array("广告接口"=>Yii::app()->createAbsoluteUrl('api/adv/index')."?Adids=1,2,3&Uid=20140725"),
			array("热点接口"=>Yii::app()->createAbsoluteUrl('api/focus/index')."?Uid=20140725&Lastdate=&Activityid="),
			array("资讯接口"=>Yii::app()->createAbsoluteUrl('api/info/index')."?Uid=20140725&Lastdate=&Newsid=&Cid=1"),
			array("资讯分类接口"=>Yii::app()->createAbsoluteUrl('api/info/categories')),
			array("发表评论接口"=>Yii::app()->createAbsoluteUrl('api/info/sendcomment')."?Uid=20140725&Newsid=17&Content=xxxxxxx"),
			array("获取资讯评论接口"=>Yii::app()->createAbsoluteUrl('api/info/getcomments')."?Uid=20140725&Commentid=0"),
		);
		echo JsonHelper::JSON($data);
	}
}