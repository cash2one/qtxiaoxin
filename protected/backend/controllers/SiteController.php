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
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			// 'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			// array('allow',  // allow all users to perform 'index' and 'view' actions
			// 	'actions'=>array('index','view'),
			// 	'users'=>array('*'),
			// ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('error','login','logout','uploadfile','test'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// echo "<pre>";
		// print_r(Uaccess::getTasks());
		// exit;
		// $json = '{"a":{"a":1,"b":2,"c":3},"b":{"a":12,"b":22,"c":32},"c":{"a":13,"b":23,"c":33}}';
		// echo "<pre>";
		// $r = json_decode($json,true);
		// var_dump($r['a']['c']);
		// exit;
		// var_dump(Yii::app()->user->logo);exit;
		if(isset($_GET['ty']) && $_GET['ty']=='notify'){
			Yii::app()->msg->postMsg('success', 'Testing...notify');
			$this->redirect(Yii::app()->createUrl('site/test'));
		}
		$this->render('index');
	}

	public function actionTest()
	{
		conlog(php_sapi_name());
		$member = Member::model()->loadByPk(1);
		var_dump($member->updatetime);
		$member->save();
		conlog($member->updatetime);
		$hash = Yii::app()->request->getParam("hash", 101346000121315850459);
		var_dump($hash);
		$code = MainHelper::enid($hash);
		var_dump($code);
		$num = MainHelper::deid($code);
		conlog($num);
		
		$hash = 101346000121315850459;
		var_dump($hash);
		$code = MainHelper::get_char($hash);
		var_dump($code);
		$num = MainHelper::get_num($code);
		conlog($num);
		
		
		$school = new School;
		$model = $school->loadByPk(1379);
		$model->name = '中南学校中南学校中南学校中南学校中南学校';
		$model->save();
		$code = 'L3RDW0TLXRKO7';
		// 100001000113569373471
		echo $code; echo "<br>";
		$num = MainHelper::deid($code);
		echo $num; echo "<br>";
		$n = UCQuery::deidInviteCode($code);
		conlog($n);
		$code1 = MainHelper::enid($num);
		conlog($code1);
		$py = new PinYin();
		echo $py->getAllPY("蜻蜓互动"); //shuchuhanzisuoyoupinyin
		echo "<br>";
		echo $py->getFirstPY("输出汉字首拼音"); //schzspy
		exit;
		$this->render('test');
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
				$this->render('error', $error);
		}
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
		$this->renderpartial('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionUploadfile(){
		$root=YiiBase::getPathOfAlias('webroot');
		$filename = CUploadedFile::getInstanceByName("upload_file");
		if (is_object($filename)) {
			$exts = is_object($filename)?$filename->extensionName:"jpg";
			$newName=date('YmdHis').rand(1000,9999).'.'.$exts;
			$folder='storage/images/upload/'.date('Ym').'/';
			MainHelper::createFolder($folder);
            $filename->saveAs($root.'/'.$folder.$newName);
            echo Yii::app()->request->hostInfo.'/'.$folder.$newName;
        }else{
        	echo '';
        }
	}

}
