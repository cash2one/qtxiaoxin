<?php

class GoodsController extends Controller
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{		
		$sub_pks = MallGoodsAddress::getGoodBusinessAddressPks($id);
		$records = array();
		if(count($sub_pks))
			$records = MallBusinessAddress::getByMbaids($sub_pks);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'subs'=>$records,
		));
	}

	public function actionDetail($id)
	{
		$sub_pks = MallGoodsAddress::getGoodBusinessAddressPks($id);
		$records = array();
		if(count($sub_pks))
			$records = MallBusinessAddress::getByMbaids($sub_pks);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'subs'=>$records,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MallGoods;
		$model->type = 0;
		$model->number = 0;
		if(isset($_POST['MallGoods']))
		{
			$model->attributes=$_POST['MallGoods'];
			if(isset($_POST['MallGoods']['aids'])){
				$aids = $_POST['MallGoods']['aids'];
				$model->range = implode(",", $aids);
			}
			$imagefile = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImgAbsolute($imagefile,$dir='goods');

			$bigimagefile = CUploadedFile::getInstancesByName("bigimage");
			$json = '';
			if(count($bigimagefile)){
				$json .= '[';
				$arrs = '';
				foreach($bigimagefile as $bimg){
					$fn = MainHelper::uploadImgAbsolute($bimg,$dir='goods');
					$arrs = $arrs?$arrs.',':$arrs;
					$arrs .= '{"url":"'.$fn.'"}';
				}
				$json .= $arrs.']';
			}
			

			$model->image = $image;
			$model->bigimage = $json;
			$model->uid = Yii::app()->user->id;
			$model->discount = $model->discount?$model->discount:1;
			$model->salediscount = $model->salediscount?$model->salediscount:1;
			$model->mallstarttime = $model->mallstarttime?$model->mallstarttime:NULL;
			$model->mallendtime = $model->mallendtime?$model->mallendtime:NULL;
			$model->sort = $model->sort?$model->sort:1000;
			if($model->save()){

				if(isset($_POST['MallGoods']['subaddress'])){
					//conlog($_POST['MallGoods']['subaddress']);
					//MallGoodsAddress::deleteMallGoodAddress($id);
					foreach($_POST['MallGoods']['subaddress'] as $mbaid){
						$addr_model = new MallGoodsAddress;
						$addr_model->mgid = $model->mgid;
						$addr_model->mbaid = $mbaid;
						$addr_model->save();
					}
				}

				Yii::app()->msg->postMsg('success', '创建成功');
				$this->redirect(array('create'));
			}
		}
		
		$cache = Yii::app()->cache;
		$province_list = $cache->get("all_province_list");
		if (empty($province_list)) {
		    $province_list = Area::model()->findAllByAttributes(array('deleted' => 0, 'parentid' => 0, 'type' => 3));;
		    $cache->set("all_province_list", $province_list);
		}
		$this->render('create',array(
			'model'=>$model,
		    'province_list'=>$province_list,
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
		$subs = array();
		if($model->type==1){ //虚拟物品
			$sub_pks = MallGoodsAddress::getGoodBusinessAddressPks($id);
			if(count($sub_pks)){
				$fd_bus = MallBusinessAddress::getBuAddrIdByMgAddrId($sub_pks[0]);
				$fd_bus_bid = $fd_bus->bid ? $fd_bus->bid : $model->bid;
			}else{
				$fd_bus_bid = $model->bid;
			}
			$records = MallBusinessAddress::getByBusinessPk($fd_bus_bid); //传入已分配的商家分店信息的商家id
			foreach($records as $s){
				$selected = in_array($s->mbaid, $sub_pks); 
				$subs[] = array('id'=>$s->mbaid,'bid'=>$s->bid,'name'=>$s->name,'phone'=>$s->phone,'address'=>$s->address,'selected'=>$selected);
			}
		}
		
		if(isset($_POST['MallGoods']))
		{
			if(isset($_POST['MallGoods']['aids'])){
				$aids = $_POST['MallGoods']['aids'];
				$model->range = implode(",", $aids);
			}
			$oldimg = $model->image;
			$model->attributes=$_POST['MallGoods'];
			$imagefile = CUploadedFile::getInstance($model, 'image');
			$image = MainHelper::uploadImgAbsolute($imagefile,$dir='goods');
			$model->image = $image?$image:$oldimg;
			$oldimages = isset($_POST['oldbigimages'])?$_POST['oldbigimages']:array();
			$json = '';
			if(count($oldimages)){
				$arrs = '';
				foreach($oldimages as $obg){
					$arrs = $arrs?$arrs.',':$arrs;
					$arrs .= '{"url":"'.$obg.'"}';
				}
				$json .= $arrs;
			}

			$bigimagefile = CUploadedFile::getInstancesByName("bigimage");
			if(count($bigimagefile)){
				$narrs = $json?$json:'';
				foreach($bigimagefile as $bimg){
					$fn = MainHelper::uploadImgAbsolute($bimg,$dir='goods');
					$narrs = $narrs?$narrs.',':$narrs;
					$narrs .= '{"url":"'.$fn.'"}';
				}
				$json = $narrs;
			}
			$json = $json?'['.$json.']':'';
			$model->bigimage = $json;
			$model->discount = $model->discount?$model->discount:1;
			$model->salediscount = $model->salediscount?$model->salediscount:1;
			$model->starttime = $model->starttime?$model->starttime:NULL;
			$model->endtime = $model->endtime?$model->endtime:NULL;
			$model->mallstarttime = $model->mallstarttime?$model->mallstarttime:NULL;
			$model->mallendtime = $model->mallendtime?$model->mallendtime:NULL;
			$model->sort = $model->sort?$model->sort:1000;
			if(isset($_POST['MallGoods']['subaddress'])){
				//conlog($_POST['MallGoods']['subaddress']);
				MallGoodsAddress::deleteMallGoodAddress($id);
				foreach($_POST['MallGoods']['subaddress'] as $mbaid){
					$addr_model = new MallGoodsAddress;
					$addr_model->mgid = $id;
					$addr_model->mbaid = $mbaid;
					$addr_model->save();
				}
			}

			if($model->save()){
				Yii::app()->msg->postMsg('success', '修改成功');
				$this->redirect(array('admin'));
			}
		}
		
		$cache = Yii::app()->cache;
		$province_list = $cache->get("all_province_list");
		if (empty($province_list)) {
		    $province_list = Area::model()->findAllByAttributes(array('deleted' => 0, 'parentid' => 0, 'type' => 3));;
		    $cache->set("all_province_list", $province_list);
		}

		$this->render('update',array(
			'model'=>$model,
			'subs' => $subs,
		    'province_list'=>$province_list,
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
		$query = isset($_GET['MallGoods']) ? $_GET['MallGoods'] : array();
		$data = MallGoods::model()->pageData($query);
		$model = new MallGoods;
        $this->render('index',array('data'=>$data,'MallGoods'=>$query,'model'=>$model));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$query = isset($_GET['MallGoods']) ? $_GET['MallGoods'] : array();
		$data = MallGoods::model()->pageData($query);
		$model = new MallGoods;
        $this->render('admin',array('data'=>$data,'MallGoods'=>$query,'model'=>$model));
	}

	public function actionSetdisable($id)
	{
		$model = $this->loadModel($id);
		if($model->state==1){
			$model->state=0;
		}else{
			$model->state=1;
		}	
		$model->save();
		echo $model->getDisableState(true);
	}
	
	public function actionCheckname()
	{
		$bid = Yii::app()->request->getParam('bid');
		$code = Yii::app()->request->getParam('name');
		$mgid = Yii::app()->request->getParam('mgid');
		$count = MallGoods::countGoodsName($bid,$code,$mgid);
		echo $count;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MallGoods the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MallGoods::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MallGoods $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='mall-goods-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
