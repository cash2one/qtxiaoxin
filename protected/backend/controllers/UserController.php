<?php

class UserController extends Controller
{
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				// 'actions'=>array('*'),
				'users'=>array('@'),
			),
			// array('allow', // allow admin user to perform 'admin' and 'delete' actions
			// 	'actions'=>array('error','login','logout','uploadfile','test'),
			// 	'users'=>array('*'),
			// ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * 用户详情页
	 * @param integer $id 用户主键
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * 添加用户
	 */
	public function actionCreate()
	{
		$model=new User;
		$model->type = '';
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
            if(User::countUserExsit(trim($model->username))){
               Yii::app()->msg->postMsg('error', '修改失败，用户已存在');
               $this->redirect(array('admin'));
                exit();
            }
			$pwd = MainHelper::generate_password();
			$model->password = md5($pwd);			
			$filename = CUploadedFile::getInstance($model, 'logo');
			$logo = MainHelper::uploadImg($filename,$dir='user');
			$model->logo = $logo;
			if($model->save()){
                if ($model->type == 0) {
                    $creationtime = date('Y-m-d H:i:s');
                    $workParam = new WorkParam();
                    $workParam->userid = $model->uid;
                    $workParam->creationtime = $creationtime;
                    $workParam->minlimit = 2;
                    $workParam->maxlimit = 3;
                    $workParam->save();
                }
				//发送邮件
				$message = $this->renderPartial('mail',array(
					'username'=>$model->username,'password'=>$pwd,'type'=>'登录'
				),true);
				$subject = "蜻蜓校信后台中心";
				MainHelper::mailSend($model->mail,"qingtinghd@163.com",$subject,$message);
				Yii::app()->msg->postMsg('success', '创建成功');
				$this->redirect(array('admin'));
			}
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * 更新用户
	 * @param integer $id 用户主键
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['User']))
		{
			$oldlogo = $model->logo;
			$model->attributes=$_POST['User'];
			$filename = CUploadedFile::getInstance($model, 'logo');
			$logo = MainHelper::uploadImg($filename,$dir='user');
			$model->logo = $logo;
			$model->logo = $logo ? $logo : $oldlogo;
			if($model->save()){

				Yii::app()->msg->postMsg('success', '修改成功');
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * 删除用户并添加删除记录
	 * @param integer $id 用户主键
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$uid = $model->uid;
		$model->deleteMark();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			Yii::app()->msg->postMsg('success', '操作成功');
			if(Yii::app()->user->id==$uid){
				Yii::app()->user->logout();
				$this->redirect(Yii::app()->homeUrl);
			}
			$this->redirect(array('admin'));
	}

	/**
	 * 启用或停用用户
	 * @param integer $id 用户主键
	 */
	public function actionSetdisable($id)
	{
		$model = $this->loadModel($id);
		if($model->state==0){
			$model->state=1;
			$model->save();
		}else{
			$model->state=0;
			$model->save();
		}		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		echo $model->getDisableState();
	}

	/**
	 * 用户列表页
	 * panrj 2014-05-19
	 */
	public function actionIndex()
	{
		$query = isset($_GET['User']) ? $_GET['User'] : array();
		$data = User::model()->pageData($query);
		$model = new User;
		
        $this->render('index',array('data'=>$data,'User'=>$query,'model'=>$model));  
	}

	/**
	 * 用户管理页面
	 */
	public function actionAdmin()
	{
		$query = isset($_GET['User']) ? $_GET['User'] : array();
		$data = User::model()->pageData($query);
		$model = new User;
        $this->render('admin',array('data'=>$data,'User'=>$query,'model'=>$model));  
	}

	/**
	 * 个人资料
	 */
	public function actionAccount()
	{	
		if(Yii::app()->user->isGuest){
			Yii::app()->user->logout();
			$this->redirect(Yii::app()->homeUrl);
		}
		$model = $this->loadModel(Yii::app()->user->id);
		if($model->deleted){
			Yii::app()->user->logout();
			$this->redirect(Yii::app()->homeUrl);
		}
		if(isset($_POST['User']))
		{
			$oldlogo = $model->logo;
			$model->attributes=$_POST['User'];
			$logofile = CUploadedFile::getInstance($model, 'logo');
			$logo = MainHelper::uploadImg($logofile,$dir='user');
			$model->logo = $logo ? $logo : $oldlogo;
			if($model->save())
				Yii::app()->msg->postMsg('success', '保存成功');
				$this->redirect(array('account'));
		}
		$this->render('account',array('model'=>$model));  
	}

	/**
	 * 修改密码
	 */
	public function actionPassword()
	{
		if(Yii::app()->user->isGuest){
			Yii::app()->user->logout();
			$this->redirect(Yii::app()->homeUrl);
		}
		$user = $this->loadModel(Yii::app()->user->id);
		if($user->deleted){
			Yii::app()->user->logout();
			$this->redirect(Yii::app()->homeUrl);
		}

		$model = new ChangePasswordForm;
		// collect user input data
		if(isset($_POST['ChangePasswordForm']))
		{
			$model->attributes=$_POST['ChangePasswordForm'];
			if($model->validate() && $model->changePassword())
			{
				Yii::app()->msg->postMsg('success', '保存成功');
				$this->redirect( $this->action->id );
			}
		}

		$this->render('password',array('model'=>$model)); 
  	}

  	public function actionAccess()
  	{
  		$uid = Yii::app()->request->getParam('uid');
  		$type = Yii::app()->request->getParam('type');
  		if(isset($_POST['Access'])){
  			$uid = $_POST['Access']['user'];
  			$schools = $_POST['Access']['schools'];
  			$schools = explode(",",$schools);
  			if(count($schools)){
  				$type = $_POST['Access']['type'];
  				UserAccess::saveUserSchool($uid,$schools,$type);
  				Yii::app()->msg->postMsg('success', '保存成功');
  			}
  			$redirecturl = Yii::app()->createUrl('user/access').'?uid='.$uid.'&type='.$type;
  			$this->redirect($redirecturl);
  		}
  		$this->render('access',array('uid'=>$uid,'type'=>$type)); 
  	}

	public function actionUserexsit()
	{
		$uid = Yii::app()->request->getParam('uid');
		$uname = Yii::app()->request->getParam('username');
		$count = User::countUserExsit($uname,$uid);
		echo $count;
	}

	//重置密码
	public function actionInitmemberpwd()
    {
        $uid = Yii::app()->request->getParam("uid", '');

        $msg = 'error';
        if ($uid) {
            $firstPassword="";

            $user = User::model()->findByPk($uid);
            if ($user) {
                $password = MainHelper::generate_code(6);
                //$user->password = MainHelper::encryPassword($password);
                $user->password = md5($password);
                $firstPassword=$password;

                if ($user->save()) {
                	//发送邮件
					$message = $this->renderPartial('mail',array(
						'username'=>$user->username,'password'=>$password,'type'=>'重置'
					),true);
					$subject = "蜻蜓校信后台中心";
					MainHelper::mailSend($user->mail,"qingtinghd@163.com",$subject,$message);

                    $msg = 'success';
                }
            }     
        }

        die(json_encode(array('msg' => $msg, 'password' => isset($firstPassword) ? $firstPassword : "")));
        
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
