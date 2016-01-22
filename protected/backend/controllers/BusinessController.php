<?php

class BusinessController extends Controller
{
	/**
	 * 商户详情页
	 * @param integer $id 商户主键
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'addrs'=>MallBusinessAddress::getByBusinessPk($id),
		));
	}

	/**
	 * 创建商户
	 */
	public function actionCreate()
	{
		$model=new Business;
		if(isset($_POST['Business']))
		{
			$model->attributes=$_POST['Business'];
			$logofile = CUploadedFile::getInstance($model, 'logo');
			$logo = MainHelper::uploadImgAbsolute($logofile,$dir='business');
			$imagefile = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImgAbsolute($imagefile,$dir='business');
			$model->logo = $logo;
			$model->image = $image;
			$model->uid = Yii::app()->user->id;
			if($model->save()){
				if(isset($_POST['Business']['Sub']['subaddress'])){
					$subs = $_POST['Business']['Sub'];
					foreach($subs['subaddress'] as $ks=>$sa){
						$adds_model = new MallBusinessAddress;
						$adds_model->bid = $model->bid;
						$adds_model->address = $sa;
						$adds_model->phone = $subs['subphone'][$ks];
						$adds_model->name = $subs['subname'][$ks];
						$adds_model->save();
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
			
	/**
	 * 修改商户
	 * @param integer $id 商户主键
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$subs = MallBusinessAddress::getByBusinessPk($id);
		if(isset($_POST['Business']))
		{	
			$oldlogo = $model->logo;
			$oldimage = $model->image;
			$model->attributes=$_POST['Business'];
			$logofile = CUploadedFile::getInstance($model, 'logo');
			$logo = MainHelper::uploadImgAbsolute($logofile,$dir='business');
			$imagefile = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImgAbsolute($imagefile,$dir='business');
			$model->logo = $logo ? $logo : $oldlogo;
			$model->image = $image ? $image : $oldimage;
			
			if(isset($_POST['Business']['Sub']['subaddress'])){
				$subs = $_POST['Business']['Sub'];
				MallBusinessAddress::deleteBusinessAddress($id);
				foreach($subs['subaddress'] as $ks=>$sa){
					$adds_model = new MallBusinessAddress;
					$adds_model->bid = $model->bid;
					$adds_model->address = $sa;
					$adds_model->phone = $subs['subphone'][$ks];
					$adds_model->name = $subs['subname'][$ks];
					$adds_model->save();
				}
			}

			if($model->save())
				Yii::app()->msg->postMsg('success', '修改成功');
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
			'subs'=>$subs,
		));
	}

	/**
	 * 删除商户
	 * @param integer $id 商户主键
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->deleteMark();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			Yii::app()->msg->postMsg('success', '操作成功');
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * 商户列表页
	 */
	public function actionIndex()
	{
		$query = isset($_GET['Business']) ? $_GET['Business'] : array();
		$data = Business::model()->pageData($query);
		$model = new Business;
        $this->render('index',array('data'=>$data,'Business'=>$query,'model'=>$model));  
	}

	/**
	 * 商户管理页面
	 */
	public function actionAdmin()
	{
		$query = isset($_GET['Business']) ? $_GET['Business'] : array();
		$data = User::model()->pageData($query);
		$data = Business::model()->pageData($query);
		$model = new Business;
        $this->render('admin',array('data'=>$data,'Business'=>$query,'model'=>$model));  
	}

	public function actionSetdisable($id)
	{
		$model = $this->loadModel($id);
		if($model->state==1){
			if($model->countGoodsEnable()){
				echo 'warning';
				exit;
			}
			$model->state=0;
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
	 * @return Business the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Business::model()->loadByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Business $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='business-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
