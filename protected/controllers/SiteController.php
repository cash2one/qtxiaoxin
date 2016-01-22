<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		phpinfo();
	}

	public function actionTest()
	{
		var_dump('ssssssssss');
		exit;
	}

	public function actionExport()
	{
		$ceils = array(
			array(1,'aaa'),
			array(2,'bbb'),
		);
	    $excel_file='批量邀请学生模版';
	    $excel_content = array(
			array(
				'sheet_name' => 'batch',
				'sheet_title' => array(
					'ID','姓名'
				),
				'hide_column' => array('A'),
				'ceils' => $ceils,
			),
		);
		PHPExcelHelper::exportExcel($excel_content, $excel_file);
		// spl_autoload_unregister(array('YiiBase','autoload'));//取消YII自动加载
		// $excel = PHPExcelHelper::generalExcel($excel_content, $excel_file);
		// conlog($excel);
		// PHPExcelHelper::downloadExcel($excel);
		// //恢复Yii自动加载功能
  //       spl_autoload_register(array('YiiBase','autoload'));
		// conlog($excel);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->renderPartial('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionFlushcache()
	{
		Yii::app()->cache->flush();
	}

	public function actionNoticetest()
	{
		$uid = Yii::app()->request->getParam('uid');
		$sender = Yii::app()->request->getParam('sender');
		$sid = Yii::app()->request->getParam('sid');
		for($i=0;$i<100;$i++){
			$receiver = '{"5":"'.$uid.'"}';
			$content = '{"content":"notice'.$i.'"}';
			$sql = "INSERT INTO tb_notice(sender,receiver,noticetype,content,sendertitle,receivertitle,issendsms,sid,schoolname,receivename,sendtime) VALUES (".$sender.",'".$receiver."',2,'".$content."','','','0',".$sid.",'葫芦娃大战白骨精','葫芦娃速成班','2014-10-15 20:50:28')";
			NoticeQuery::execute($sql);
		}
	}

	public function actionNoticefixed()
	{
		$uid = Yii::app()->request->getParam('uid');
		$sender = Yii::app()->request->getParam('sender');
		$sid = Yii::app()->request->getParam('sid');
		for($i=0;$i<1000;$i++){
			$receiver = '{"3":"'.$uid.'"}';
			$content = '{"content":"\\\\potice_\\\\r\\\\nfixed\\\\"time'.$i.'"}';
			$sql = "INSERT INTO tb_notice_fixedtime(sender,receiver,noticetype,content,sendertitle,receivertitle,issendsms,sid,schoolname,receivename,sendtime,status) VALUES (".$sender.",'".$receiver."',2,'".$content."','','','0',".$sid.",'葫芦娃大战白骨精','葫芦娃速成班','2014-10-15 20:50:28','1')";
			NoticeQuery::execute($sql);
		}
	}
}