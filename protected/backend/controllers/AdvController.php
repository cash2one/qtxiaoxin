<?php

class AdvController extends Controller
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		// $count = $this->loadModel($id)->countConAdvRelation();
		// if(!$count)
		// 	var_dump($count);
		$model = $this->loadModel($id);
		// var_dump($model);exit;
		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionDetail($id)
	{
		// $count = $this->loadModel($id)->countConAdvRelation();
		// if(!$count)
		// 	var_dump($count);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionPublicview($id)
	{
		// $count = $this->loadModel($id)->countConAdvRelation();
		// if(!$count)
		// 	var_dump($count);
		$this->render('publicview',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Advertisement;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Advertisement']))
		{
			$model->attributes=$_POST['Advertisement'];
			$filename = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($filename,$dir='advertisement');
			$model->image = $image;
			$model->uid = Yii::app()->user->id;
			if($model->save()){
				Yii::app()->msg->postMsg('success', '创建成功');
				$this->redirect(array('create'));
			}
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Advertisement']))
		{	
			$oldimage = $model->image;
			$model->attributes=$_POST['Advertisement'];
			$filename = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($filename,$dir='advertisement');
			$model->image = $image;
			$model->image = $image ? $image : $oldimage;
			
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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->deleteMark();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			Yii::app()->msg->postMsg('success', '操作成功');
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionPublicdelete($id)
	{
		$this->loadModel($id)->deleteMark();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			Yii::app()->msg->postMsg('success', '操作成功');
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('public'));
	}

	/**
	 * 广告预览
	 * @param integer $id 广告主键
	 */
	public function actionPreview($id)
	{
		$model = $this->loadModel($id);
		$con = $this->renderPartial('preview',array(
			'model'=>$model
		),true);
		echo $con;
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$query = isset($_GET['Advertisement']) ? $_GET['Advertisement'] : array();
		$data = Advertisement::model()->pageData($query);
		$model = new Advertisement;
        $this->render('index',array('data'=>$data,'Advertisement'=>$query,'model'=>$model));
	}

	/**
	 * Lists all models.
	 */
	public function actionPublic()
	{
		$query = isset($_GET['Advertisement']) ? $_GET['Advertisement'] : array();
		$data = Advertisement::model()->pageDataPublic($query,$ty='public');
		$model = new Advertisement;
        $this->render('public',array('data'=>$data,'Advertisement'=>$query,'model'=>$model));
	}

	public function actionPublicadd()
	{
		$model=new Advertisement;

		if(isset($_POST['Advertisement']))
		{
			$model->attributes=$_POST['Advertisement'];
			$filename = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($filename,$dir='advertisement');
			$model->image = $image;
			$model->state = 2;
			$model->uid = Yii::app()->user->id;
			if($model->save()){
				Yii::app()->msg->postMsg('success', '创建成功');
				$this->redirect(array('public'));
			}
		}
		$this->render('publicadd',array(
			'model'=>$model,
		));
	}

	public function actionPublicedit($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Advertisement']))
		{	
			$oldimage = $model->image;
			$model->attributes=$_POST['Advertisement'];
			$filename = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($filename,$dir='advertisement');
			$model->image = $image;
			$model->image = $image ? $image : $oldimage;
			if($model->save())
				Yii::app()->msg->postMsg('success', '修改成功');
				$this->redirect(array('public'));
		}
		
		$this->render('publicedit',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{

		$query = isset($_GET['Advertisement']) ? $_GET['Advertisement'] : array();
		$data = Advertisement::model()->pageData($query);
		$model = new Advertisement;
        $this->render('admin',array('data'=>$data,'Advertisement'=>$query,'model'=>$model));
	}

	/**
	 * 启用或停用广告
	 * @param integer $id 广告主键
	 */
	public function actionSetdisable($id)
	{
		$model = $this->loadModel($id);
		if($model->state==1){
			$model->state=2;
		}else{
			$model->state=1;
		}	
		$model->save();
		echo $model->getDisableState(true);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Advertisement the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Advertisement::model()->loadByPk($id);
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Advertisement $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='advertisement-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
