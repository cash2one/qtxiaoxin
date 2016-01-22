<?php

class InformationController extends Controller
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionDetail($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Information;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Information']))
		{
			$model->attributes=$_POST['Information'];
			$imagefile = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($imagefile,$dir='information');

			$bigimagefile = CUploadedFile::getInstance($model,"bigimage");
			$bigimage = MainHelper::uploadImg($bigimagefile,$dir='information');
			$model->image = $image;
			$model->bigimage = $bigimage;
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
		if(isset($_POST['Information']))
		{
			$oldimage = $model->image;
			$oldbigimage = $model->bigimage;
			$model->attributes=$_POST['Information'];
			$imagefile = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($imagefile,$dir='information');
			$model->image = $image?$image:$oldimage;

			$bigimagefile = CUploadedFile::getInstance($model,"bigimage");
			$bigimage = MainHelper::uploadImg($bigimagefile,$dir='information');
			$model->bigimage = $bigimage?$bigimage:$oldbigimage;
			$model->headtop = $model->head?$model->headtop:0;
			if($model->save()){
				Yii::app()->msg->postMsg('success', '操作成功');
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
		Yii::app()->msg->postMsg('success', '操作成功');
		$this->redirect(array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$query = isset($_GET['Information']) ? $_GET['Information'] : array();
		$data = Information::model()->pageData($query);
		$model = new Information;
        $this->render('index',array('data'=>$data,'Information'=>$query,'model'=>$model));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$query = isset($_GET['Information']) ? $_GET['Information'] : array();
		$data = Information::model()->pageData($query);
		$model = new Information;
        $this->render('admin',array('data'=>$data,'Information'=>$query,'model'=>$model));
	}

	public function actionPublic()
	{
		$query = isset($_GET['Information']) ? $_GET['Information'] : array();
		$data = Information::model()->pageDataPublic($query);
		$model = new Information;
        $this->render('public',array('data'=>$data,'Information'=>$query,'model'=>$model));
	}

	public function actionPublicadd()
	{
		$model=new Information;
		$model->startdate = date('Y-m-d H:i:s',time());
		if(isset($_POST['Information']))
		{
			$model->attributes=$_POST['Information'];
			$imagefile = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($imagefile,$dir='information');
			$bigimagefile = CUploadedFile::getInstance($model, 'bigimage');
			$bigimage = MainHelper::uploadImg($bigimagefile,$dir='information');
			$model->image = $image;
			$model->bigimage = $bigimage;
			$model->state = 2;
			$model->uid = Yii::app()->user->id;
			$startdate = $_POST['Information']['startdate'];
			if($model->save()){
				$model->addPublicInfoRelation($startdate);
				Yii::app()->msg->postMsg('success', '创建成功');
				$this->redirect(array('public'));
			}
		}
		$this->render('publicadd',array(
			'model'=>$model,
		));
	}

	public function actionPublicview($id)
	{
		$this->render('publicview',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionPublicedit($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Information']))
		{
			$oldimage = $model->image;
			$oldbigimage = $model->bigimage;
			$model->attributes=$_POST['Information'];
			$imagefile = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($imagefile,$dir='information');

			$bigimagefile = CUploadedFile::getInstance($model,"bigimage");
			$bigimage = MainHelper::uploadImg($bigimagefile,$dir='information');
			$model->image = $image?$image:$oldimage;
			$model->bigimage = $bigimage?$bigimage:$oldbigimage;
			$startdate = $_POST['Information']['startdate'];
			$model->headtop = $model->head?$model->headtop:0;
			if($model->save()){
				$model->setPublicInfoRelation($startdate);
				Yii::app()->msg->postMsg('success', '操作成功');
				$this->redirect(array('public'));
			}	
		}

		$this->render('publicedit',array(
			'model'=>$model,
		));
	}

	public function actionPublicdel($id)
	{
		$this->loadModel($id)->deleteMark();
		Yii::app()->msg->postMsg('success', '操作成功');
		$this->redirect(array('public'));
	}

	/**
	 * 启用或停用资讯
	 * @param integer $id 资讯主键
	 */
	public function actionSetdisable($id)
	{
		$model = $this->loadModel($id);
		if($model->state==1){
			$model->headtop = 0;
			$model->kindtop = 0;
			$model->state=2;
		}else{
			$model->state=1;
		}	
		$model->save();
		echo $model->getDisableState(true);
	}
	
	/**
	 * 种类置顶判断
	 */
	public function actionKindtop()
	{
		$ikid = Yii::app()->request->getParam('ikid');
		$iid = Yii::app()->request->getParam('iid');
		$num = Information::countKindTop($ikid,$iid);
		echo $num;
	}

	/**
	 * 资讯预览
	 * @param integer $id 资讯主键
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
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Information the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Information::model()->loadByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Information $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='information-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
