<?php

class FocusController extends Controller
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		//conlog(get_class($model));
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionUpdateview($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionPublicview($id)
	{
		$model = $this->loadModel($id);
		$this->render('publicview',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Focus;
		//$model->startdate = date('Y-m-d H:i:s',time());
		//$model->enddate = date('Y-m-d H:i:s',time());
		if(isset($_POST['Focus']))
		{
			$model->attributes=$_POST['Focus'];
			$filename = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($filename,$dir='focus');
			$model->image = $image;
			$model->uid = Yii::app()->user->id;
			if($model->save()){
				if($model->type=='1'){
					if(isset($_POST['FocusQuestion'])){
						$questions = $_POST['FocusQuestion']; 
						$point = isset($_POST['Focus']['point']) ? $_POST['Focus']['point'] : 0;
						$model->setFocPoint($point);
						foreach($questions as $key=>$val){
							$question_model = new FocusQuestion;
							$question_model->attributes=$val;
							$question_model->fid = $model->fid;
							if($question_model->save()){
								foreach($val['item'] as $ikey=>$item){
									$item_model = new FocusQuestionItem;
									$item_model->title=$item;
									$item_model->fqid=$question_model->fqid;
									$item_model->save();
								}
							}
						}
					}
				}
				Yii::app()->msg->postMsg('success', '创建成功');
				$this->redirect(array('create'));
			}
		}
		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionGetsubform()
	{	
		$type = Yii::app()->request->getParam('type');
		$qnum = Yii::app()->request->getParam('qnum');
		//投票题目
		if($type=="question"){
			$con = $this->renderPartial('sub_question',array(
				'qnum'=>$qnum
			),true);
			echo $con;
		}
		//投票题目选项
		if($type=="item"){
			$tnum = Yii::app()->request->getParam('tnum');
			$con = $this->renderPartial('sub_item',array(
				'qnum'=>$qnum,'tnum'=>$tnum
			),true);
			echo $con;
		}
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

		if(isset($_POST['Focus']))
		{	
			$oldimage = $model->image;
			$model->attributes=$_POST['Focus'];
			$filename = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($filename,$dir='focus');
			$model->image = $image;
			$model->image = $image ? $image : $oldimage;
			
			if($model->save()){
				if($model->type=='1'){
					if(isset($_POST['FocusQuestion'])){
						$questions = $_POST['FocusQuestion']; 
						$point = isset($_POST['Focus']['point']) ? $_POST['Focus']['point'] : 0;
						$model->setFocPoint($point);
						$model->deleteFocQuestions();
						foreach($questions as $key=>$val){
							$question_model = new FocusQuestion;
							$question_model->attributes=$val;
							$question_model->fid = $model->fid;
							if($question_model->save()){
								foreach($val['item'] as $ikey=>$item){
									$item_model = new FocusQuestionItem;
									$item_model->title=$item;
									$item_model->fqid=$question_model->fqid;
									$item_model->save();
								}
							}
						}
					}
				}
				Yii::app()->msg->postMsg('success', '创建成功');
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
		Yii::app()->msg->postMsg('success', '操作成功');
		$this->redirect(array('public'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$query = isset($_GET['Focus']) ? $_GET['Focus'] : array();
		$data = Focus::model()->pageData($query);
		$model = new Focus;
        $this->render('index',array('data'=>$data,'Focus'=>$query,'model'=>$model));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$query = isset($_GET['Focus']) ? $_GET['Focus'] : array();
		$data = Focus::model()->pageData($query);
		$model = new Focus;
        $this->render('admin',array('data'=>$data,'Focus'=>$query,'model'=>$model));
	}

	/**
	 * Lists all models.
	 */
	public function actionPublic()
	{
		$query = isset($_GET['Focus']) ? $_GET['Focus'] : array();
		$data = Focus::model()->pageDataPublic($query,$ty='public');
		$model = new Focus;
        $this->render('public',array('data'=>$data,'Focus'=>$query,'model'=>$model));
	}

	public function actionPublicadd()
	{
		$model=new Focus;
		$model->startdate = date('Y-m-d H:i:s',time());
		$model->enddate = date('Y-m-d H:i:s',time());
		if(isset($_POST['Focus']))
		{
			$model->attributes=$_POST['Focus'];
			$filename = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($filename,$dir='focus');
			$model->image = $image;
			$model->state = 2;
			$model->uid = Yii::app()->user->id;
			$startdate = $_POST['Focus']['startdate'];
			$enddate = $_POST['Focus']['enddate'];
			if($model->save()){
				$model->addPublicFocRelation($startdate,$enddate);
				if($model->type=='1'){
					if(isset($_POST['FocusQuestion'])){
						$questions = $_POST['FocusQuestion']; 
						$point = isset($_POST['Focus']['point']) ? $_POST['Focus']['point'] : 0;
						$model->setFocPoint($point);
						foreach($questions as $key=>$val){
							$question_model = new FocusQuestion;
							$question_model->attributes=$val;
							$question_model->fid = $model->fid;
							if($question_model->save()){
								foreach($val['item'] as $ikey=>$item){
									$item_model = new FocusQuestionItem;
									$item_model->title=$item;
									$item_model->fqid=$question_model->fqid;
									$item_model->save();
								}
							}
						}
					}
				}
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
		if(isset($_POST['Focus']))
		{	
			$oldimage = $model->image;
			$model->attributes=$_POST['Focus'];
			$filename = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImg($filename,$dir='focus');
			$model->image = $image;
			$model->image = $image ? $image : $oldimage;
			$startdate = $_POST['Focus']['startdate'];
			$enddate = $_POST['Focus']['enddate'];
			if($model->save()){
				$model->setPublicFocRelation($startdate,$enddate);
				if($model->type=='1'){
					if(isset($_POST['FocusQuestion'])){
						$questions = $_POST['FocusQuestion']; 
						$point = isset($_POST['Focus']['point']) ? $_POST['Focus']['point'] : 0;
						$model->setFocPoint($point);
						$model->deleteFocQuestions();
						foreach($questions as $key=>$val){
							$question_model = new FocusQuestion;
							$question_model->attributes=$val;
							$question_model->fid = $model->fid;
							if($question_model->save()){
								foreach($val['item'] as $ikey=>$item){
									$item_model = new FocusQuestionItem;
									$item_model->title=$item;
									$item_model->fqid=$question_model->fqid;
									$item_model->save();
								}
							}
						}
					}
				}
				Yii::app()->msg->postMsg('success', '修改成功');
				$this->redirect(array('public'));
			}
		}
		
		$this->render('publicedit',array(
			'model'=>$model,
		));
	}

	/**
	 * 启用或停用热点
	 * @param integer $id 热点主键
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
	 * 热点预览
	 * @param integer $id 热点主键
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
	 * @return Focus the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Focus::model()->loadByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Focus $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='focus-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
