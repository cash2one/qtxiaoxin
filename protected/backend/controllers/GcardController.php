<?php

class GcardController extends Controller
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

	public function actionBusdetail($id)
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
		$model=new MallGoodsCard;
		$model->starttime = date('Y-m-d H:i:s',time());
		$model->endtime = date('Y-m-d H:i:s',time());
		if(isset($_POST['MallGoodsCard']))
		{
			$type = $_POST['create_type'];
			if($type==1){
				$model->attributes=$_POST['MallGoodsCard'];
				if($model->save()){
					Yii::app()->msg->postMsg('success', '创建成功');
					$this->redirect(array('create'));
				}
			}

			if($type==2){
				$user_id = Yii::app()->user->id;

				//panrj 2014-07-23 CouchBase改为文件缓存
				$cache=Yii::app()->cache;
				$datas = $cache->get("gcarduploadfile".$user_id);
				// $datas = CouchBaseHelper::get("gcarduploadfile".$user_id);
				if(!$datas){
					Yii::app()->msg->postMsg('error', '请先上传文件！');
					$this->redirect(array('create'));
				}else{
					foreach($datas as $code){
						$model=new MallGoodsCard;
						$model->attributes=$_POST['MallGoodsCard'];
						$model->number = $code;
						$model->save();
					}

					//panrj 2014-07-23 CouchBase改为文件缓存
					$cache->delete("gcarduploadfile".$user_id);
					// CouchBaseHelper::delete("gcarduploadfile".$user_id);
					Yii::app()->msg->postMsg('success', '创建成功');
					$this->redirect(array('create'));
				}
			}

			if($type==3){
				  
				$num = $_POST['create_num'];
				for($i=0;$i<$num;$i++){
					$model=new MallGoodsCard;
					$model->attributes=$_POST['MallGoodsCard'];
					$r1 = rand(0,999);
					$mgid = $model->mgid;
					$time = explode (" ", microtime()); 
					$t = $time[0]*1000*1000;
					$r2 = (int)$t;
					
					$hash = $r1.$r2.$mgid;
					$code = MainHelper::enid($hash);
					$model->number = $code;
					$model->save();
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->bid = $model->mg->bid;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MallGoodsCard']))
		{
			$model->attributes=$_POST['MallGoodsCard'];
			if($model->save())
				Yii::app()->msg->postMsg('success', '创建成功');
				$this->redirect(array('admin'));
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
		$query = isset($_GET['MallGoodsCard']) ? $_GET['MallGoodsCard'] : array();
		$data = MallGoodsCard::model()->pageData($query);
		$model = new MallGoodsCard;
        $this->render('index',array('data'=>$data,'MallGoodsCard'=>$query,'model'=>$model));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$query = isset($_GET['MallGoodsCard']) ? $_GET['MallGoodsCard'] : array();
		$data = MallGoodsCard::model()->pageData($query);
		$model = new MallGoodsCard;
        $this->render('admin',array('data'=>$data,'MallGoodsCard'=>$query,'model'=>$model));
	}

	public function actionBusiness()
	{
		$query = isset($_GET['MallGoodsCard']) ? $_GET['MallGoodsCard'] : array();
		$data = MallGoodsCard::model()->pageData($query,'business');
		$model = new MallGoodsCard;
        $this->render('business',array('data'=>$data,'MallGoodsCard'=>$query,'model'=>$model));
	}

	public function actionSetstate($id)
	{
		$model = $this->loadModel($id);
		if($model->state==0){
			$model->state = 1;
			$r = "设为未使用";
		}else{
			$model->state = 0;
			$r = "设为已使用";
		}
		$model->save();
		echo $r;
	}

	public function actionChecknum()
	{
		$bid = Yii::app()->request->getParam('bid');
		$code = Yii::app()->request->getParam('code');
		$mgcid = Yii::app()->request->getParam('mgcid');
		$count = MallGoodsCard::countCardNumber($bid,$code,$mgcid);
		echo $count;
	}

	public function actionExport()
	{
		$ceils = array();
	    $excel_file='批量导入模版';
	    $excel_content = array(
			array(
				'sheet_name' => 'batch',
				'sheet_title' => array(
					'卡号',
				),
				'ceils' => $ceils,
			),
		);
		PHPExcelHelper::exportExcel($excel_content, $excel_file);
	}
	
	public function actionUpload()
	{	
		$bid = Yii::app()->request->getParam('bid');
		Yii::$enableIncludePath = false;    
		Yii::import('application.extensions.PHPExcel', 1);  
		$uploadfile = $_FILES['batchfile']['tmp_name'];
		require_once(PHPEXCEL_ROOT.'PHPExcel/IOFactory.php');
		require_once(PHPEXCEL_ROOT.'PHPExcel/Reader/Excel5.php');
		$objPHPExcel = new PHPExcel();
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objReader -> setReadDataOnly(true);
		$objPHPExcel = $objReader -> load($uploadfile);
		$objPHPExcel -> setActiveSheetIndex(0);
		$ActiveSheet = $objPHPExcel->getActiveSheet();
		$max = $objPHPExcel -> getActiveSheet() -> getHighestRow();
		$repeat = 0;
		$empty = 0;
		$usefull = 0;
		$data = array();
		for($row = 2; $row <= $max; $row++){
			$code = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
			if($code){
				$count = MallGoodsCard::countCardNumber($bid,$code,'');
				if($count){
					$repeat += 1;
				}else{
					array_push($data,$code);
					$usefull += 1;
				}
			}else{
				$empty += 1;
			}
		}
		$user_id = Yii::app()->user->id;

		//panrj 2014-07-23 CouchBase改为文件缓存
		$cache=Yii::app()->cache;
		$cache->set("gcarduploadfile".$user_id,$data);
		// CouchBaseHelper::set("gcarduploadfile".$user_id,$data);
		
		$con = $this->renderPartial('upload',array('repeat'=>$repeat,'empty'=>$empty,'name'=>$_FILES['batchfile']['name'],'usefull'=>$usefull),true);
		echo $con;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MallGoodsCard the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MallGoodsCard::model()->LoadByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MallGoodsCard $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mall-goods-card-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
