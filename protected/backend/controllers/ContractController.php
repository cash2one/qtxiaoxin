<?php

class ContractController extends Controller
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$advrels = $model->getAdvRelationData();
		$focrels = $model->getFocRelationData();
		$inforels = $model->getInfoRelationData();
		$total = count($advrels) + count($focrels) + count($inforels);
		$this->render('view',array(
			'model'=>$model,'advrels'=>$advrels,'focrels'=>$focrels,'total'=>$total,'inforels'=>$inforels,
		));
	}

	public function actionUpdateview($id)
	{
		$model = $this->loadModel($id);
		$advrels = $model->getAdvRelationData();
		$focrels = $model->getFocRelationData();
		$inforels = $model->getInfoRelationData();
		$total = count($advrels) + count($focrels) + count($inforels);
		$this->render('view',array(
			'model'=>$model,'advrels'=>$advrels,'focrels'=>$focrels,'total'=>$total,'inforels'=>$inforels,
		));
	}

	public function actionDocview($id)
	{
		$model = $this->loadModel($id);
		$advrels = $model->getAdvRelationData();
		$focrels = $model->getFocRelationData();
		$inforels = $model->getInfoRelationData();
		$total = count($advrels) + count($focrels) + count($inforels);
		$this->render('documentview',array(
			'model'=>$model,'advrels'=>$advrels,'focrels'=>$focrels,'total'=>$total,'inforels'=>$inforels,
		));
	}

	public function actionApproval($id)
	{
		$model = $this->loadModel($id);
		$advrels = $model->getAdvRelationData();
		$focrels = $model->getFocRelationData();
		$inforels = $model->getInfoRelationData();
		$total = count($advrels) + count($focrels) + count($inforels);
		$this->render('approval',array(
			'model'=>$model,'advrels'=>$advrels,'focrels'=>$focrels,'total'=>$total,'inforels'=>$inforels,
		));
	}

	public function actionSetstate($id)
	{
		$model = $this->loadModel($id);
		$owner = $model->u;
		$state = Yii::app()->request->getParam('state');
		$model->state = $state?$state:0;
		$model->save();
		if($owner->uid!=Yii::app()->user->id){
			$subject = "蜻蜓校信后台中心";
			if($model->state==2){
				$message = "您创建的编号为".$model->contractid."的合同(".$model->name.")已被".Yii::app()->user->name."审核通过";
				MainHelper::mailSend($owner->mail,"qingtinghd@163.com",$subject,$message);
			}
			if($model->state==3){
				$message = "您创建的编号为".$model->contractid."的合同(".$model->name.")已被".Yii::app()->user->name."打回";
				MainHelper::mailSend($owner->mail,"qingtinghd@163.com",$subject,$message);
			}
		}
		Yii::app()->msg->postMsg('success', '审批成功');
		$this->redirect(array('document'));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Contract;
		if(isset($_POST['Contract'])){
			echo '<pre>';
			$model->attributes=$_POST['Contract'];
			if(isset($_POST['submitcon']) && $_POST['submitcon']=='1'){
				$model->state = 1;
			}
			$model->uid = Yii::app()->user->id;
			if($model->save()){
				$cid = $model->cid;
				if(isset($_POST['ConType'])){
					// echo "<pre>";
					// print_r($_POST['ConType']);exit;
					foreach($_POST['ConType'] as $ct){
						$contype = $ct['contype'];
						$aid = isset($ct['objid'])?$ct['objid']:0;
						if($contype=='info'){
							$sdate = isset($ct['sdate'])?$ct['sdate']:'';
							if($sdate)
								$this->setConInfoRelation($cid,$aid,$sdate);
						}else{
							$location = isset($ct['location'])?$ct['location']:'';
							if(!isset($ct['sdate']) || !isset($ct['edate']))
								continue;
							$sdate = $ct['sdate'];
							$edate = $ct['edate'];
							$result = isset($ct['result'])?$ct['result']:'';
							
							$school_ids = isset($ct['school_ids'])?$ct['school_ids']:'';
							$grade_ids = isset($ct['grade_ids'])?$ct['grade_ids']:'';
							if($contype=='adv'){
								if($result)
									$this->setConAdvRelation($cid,$aid,$location,$sdate,$edate,$result,$school_ids);
							}else{
								$this->setConFocRelation($cid,$aid,$sdate,$edate,$school_ids,$grade_ids);
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

	public function setConAdvrelation($cid,$aid,$loc,$sdate,$edate,$results,$ns=0)
	{
		$results = explode(",",$results);
		if($ns){
			$ns = count(explode(",",$ns));
		}
		$relation = new ContractAdvertisementRelation;
		$relation->cid = $cid;
		$relation->aid = $aid;
		$relation->alid = $loc;
		$relation->startdate = $sdate;
		$relation->enddate = $edate;
		$relation->school = $ns;
		$relation->person = 0;
		$relation->save();

		$person = 0;
		// conlog($results);
		foreach($results as $result){
			$r = explode("-",$result);
			$sid = $r[0];
			$gid = $r[1];
			if(!$sid || !$gid){
				continue;
			}
			$person += UserSchoolGradeCount::getSchoolGradePerson($sid,$gid);
			$date_arr = School::model()->getAvailableDate($sid,$gid,$loc,$sdate,$edate);
			
			foreach($date_arr['dates'] as $d){
				$s = $d['sdate'];
				$e = $d['edate'];
				if(strtotime($e)>=strtotime($s)){
					$range = new ContractAdvertisementRange;
					$range->sid = $sid;
					$range->gid = $gid;
					$range->carid = $relation->carid;
					$range->startdate = $s;
					$range->enddate = $e;
					$range->save();
				}
			}
		}
		$relation->person = $person;
		$relation->save();
	}

	public function setConFocRelation($cid,$fid,$sdate,$edate,$school_ids,$grade_ids)
	{
		$schools = explode(",",$school_ids);
		$grades = explode(",",$grade_ids);
		$relation = new ContractFocusRelation;
		$relation->cid = $cid;
		$relation->fid = $fid;
		$relation->startdate = $sdate;
		$relation->enddate = $edate;
		$relation->school = count($schools);
		$relation->person = 0;
		$relation->save();
		
		$person = 0;
		foreach($schools as $school){
			foreach($grades as $grade){
				$range = new ContractFocusRange;
				$range->sid = $school;
				$range->gid = $grade;
				$range->cfrid = $relation->cfrid;
				$range->save();
				$person += UserSchoolGradeCount::getSchoolGradePerson($school,$grade);
			}
		}
		$relation->person = $person;
		$relation->save();
	}

	public function setConInfoRelation($cid,$iid,$sdate)
	{
		$relation = new ContractInfomationRelation;
		$relation->cid = $cid;
		$relation->iid = $iid;
		$relation->startdate = $sdate;
		$relation->save();
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$advs = $model->getAdvRelationData();
		$focs = $model->getFocRelationData();
		$infos = $model->getInfoRelationData();

		if(isset($_POST['Contract'])){
			$model->attributes=$_POST['Contract'];
			if($model->save()){
				$cid = $model->cid;
				if(isset($_POST['ConType'])){
					foreach($_POST['ConType'] as $ct){
						$aid = isset($ct['objid'])?$ct['objid']:'';
						$location = isset($ct['location'])?$ct['location']:'';
						$sdate = isset($ct['sdate'])?$ct['sdate']:'';
						$edate = isset($ct['edate'])?$ct['edate']:'';
						$result = isset($ct['result'])?$ct['result']:'';
						$contype = isset($ct['contype'])?$ct['contype']:'';
						$school_ids = isset($ct['school_ids'])?$ct['school_ids']:'';
						$grade_ids = isset($ct['grade_ids'])?$ct['grade_ids']:'';
						if($contype=='adv'){
							if($result)
								$this->setConAdvRelation($cid,$aid,$location,$sdate,$edate,$result,$school_ids);
						}elseif($contype=='foc'){
							$this->setConFocRelation($cid,$aid,$sdate,$edate,$school_ids,$grade_ids);
						}else{
							$this->setConInfoRelation($cid,$aid,$sdate);
						}
					}
				}

				if(isset($_POST['advrealtion_delete'])){
					$arids = explode(",",$_POST['advrealtion_delete']);
					Contract::deleteConAdvRelations($arids);
				}
				if(isset($_POST['focrealtion_delete'])){
					$frids = explode(",",$_POST['focrealtion_delete']);
					Contract::deleteConFocRelations($frids);
				}
				if(isset($_POST['inforealtion_delete'])){
					$irids = explode(",",$_POST['inforealtion_delete']);
					Contract::deleteConInfoRelations($irids);
				}

				Yii::app()->msg->postMsg('success', '创建成功');
				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,'advs'=>$advs,'focs'=>$focs,'infos'=>$infos
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$owner = $model->u;
		if($owner->uid!=Yii::app()->user->id){
			$subject = "蜻蜓校信后台中心";
			$message = "您创建的编号为".$model->contractid."的合同(".$model->name.")已被".Yii::app()->user->name."删除";
			MainHelper::mailSend($owner->mail,"qingtinghd@163.com",$subject,$message);
		}

		$model->deleteMark();
		Yii::app()->msg->postMsg('success', '操作成功');
		$this->redirect(isset($_GET['returntype']) ?  array('document') : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$query = isset($_GET['Contract']) ? $_GET['Contract'] : array();
		$query['uid'] = Yii::app()->user->id;
		$data = Contract::model()->pageData($query);
		$model = new Contract;
        $this->render('index',array('data'=>$data,'Contract'=>$query,'model'=>$model));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$query = isset($_GET['Contract']) ? $_GET['Contract'] : array();
		$query['uid'] = Yii::app()->user->id;
		$data = Contract::model()->pageData($query);
		$model = new Contract;
        $this->render('admin',array('data'=>$data,'Contract'=>$query,'model'=>$model));
	}

	public function actionDocument()
	{
		$query = isset($_GET['Contract']) ? $_GET['Contract'] : array();
		$data = Contract::model()->pageData($query,'doc');
		$model = new Contract;
        $this->render('document',array('data'=>$data,'Contract'=>$query,'model'=>$model));
	}

	public function actionGetoptions()
	{	
		$bid = Yii::app()->request->getParam('bid');
		$type = Yii::app()->request->getParam('type');
		//广告类型
		if($type=="adv"){
			$arr = Business::getAdvDataArr($bid);
			$options = '';
			foreach($arr as $k=>$v){
				$o = "<option value=" . $k . ">" . $v . "</option>";
				$options.=$o;
			}
			echo $options;
		}
		//热点类型
		if($type=="foc"){
			$arr = Business::getFocDataArr($bid);
			$options = '';
			foreach($arr as $k=>$v){
				$o = "<option value=" . $k . ">" . $v . "</option>";
				$options.=$o;
			}
			echo $options;
		}

		if($type=="info"){
			$arr = Business::getInfoDataArr($bid);
			$options = '';
			foreach($arr as $k=>$v){
				$o = "<option value=" . $k . ">" . $v . "</option>";
				$options.=$o;
			}
			echo $options;
		}
	}

	public function actionGetcontent()
	{	
		$order = Yii::app()->request->getParam('order');
		$con = $this->renderPartial('content',array(
			'order'=>$order
		),true);
		echo $con;
	}

	public function actionQuery()
	{
		$order = Yii::app()->request->getParam('order');
		$sdate = Yii::app()->request->getParam('sdate');
		$edate = Yii::app()->request->getParam('edate');
		$location = Yii::app()->request->getParam('location');
		$areas = Yii::app()->request->getParam('areas');
		$grades = Yii::app()->request->getParam('grades');
		$business = Yii::app()->request->getParam('business');
		$contype = Yii::app()->request->getParam('contype');
		// $objid = Yii::app()->request->getParam('objid');
		// echo $edate;exit;
		$gids = explode(",",$grades);
		$areas = explode(",",$areas);
		$grade_arr = array();
		foreach($gids as $g){
			// var_dump($g);
			$grade = Grade::model()->findByPk($g);
			$grade_arr[$g] = $grade->name;
		}
		$school_arr = School::getSchoolData(array('aids'=>$areas,'gids'=>$gids));
		// conlog($school_arr);
		if($contype=='adv'){
			$data = array();
			foreach($school_arr as $school){
				$school_data = array();
				$school_data['sid'] = $school->sid;
				$school_data['name'] = $school->name;
				if($contype=='adv'){
					foreach($gids as $g){
						$school_data[$g]['info'] = $school->getSchoolGradeInfo($g,$location,$sdate,$edate);
						// $school_data[$g]['info']['person'] = UserSchoolGradeCount::getSchoolGradePerson($school->sid,$g);
					}
				}
				array_push($data,$school_data);
			}
			$con = $this->renderPartial('queryadv',array('data'=>$data,'grade_arr'=>$grade_arr,'order'=>$order),true);
			echo $con;
		}else{
			$person = array();
			foreach($school_arr as $school){
				$pn = 0;
				foreach($gids as $g){
					$pn += UserSchoolGradeCount::getSchoolGradePerson($school->sid,$g);
				}
				$person[$school->sid] = $pn;
			}
			$con = $this->renderPartial('queryfoc',array('schools'=>$school_arr,'grades'=>$grades,'order'=>$order,'person'=>$person),true);
			echo $con;
		}
		
	}

	public function actionAdv()
	{
		return $this->render('adv',array());
	}

	public function actionLocationquery()
	{

		$model=new Contract;
		$aids = Yii::app()->request->getParam('areas');
		$gids = Yii::app()->request->getParam('grades');
		$sdate = Yii::app()->request->getParam('sdate');
		$edate = Yii::app()->request->getParam('edate');
		$alid = Yii::app()->request->getParam('location');
		$gids = explode(",",$gids);
		$aids = explode(",",$aids);
		$school_arr = School::getSchoolData(array('aids'=>$aids,'gids'=>$gids));
	
		$advid = '';
		$data = array();
		foreach($school_arr as $school){
			$school_data = array();
			$school_data['sid'] = $school->sid;
			$school_data['name'] = $school->name;
			foreach($gids as $g){
				$school_data[$g]['info'] = $school->getSchoolGradeInfo($g,$alid,$sdate,$edate);
			}
			array_push($data,$school_data);
			
		}
		// echo "<pre>";
		// print_r($data);exit;
		$grade_arr = array();
		foreach($gids as $g){
			$grade = Grade::model()->findByPk($g);
			$grade_arr[$g] = $grade->name;
		}
		$con = $this->renderPartial('location',array('data'=>$data,'grade_arr'=>$grade_arr),true);
		echo $con;
	}

	public function actionSchoolquery()
	{
		$sid = Yii::app()->request->getParam('sid');
		$sdate = Yii::app()->request->getParam('sdate');
		$edate = Yii::app()->request->getParam('edate');
		$st = Yii::app()->request->getParam('st');
		$school = School::model()->findByPk($sid);
		$grdes = $school->getSchoolGradeArr($st);
		$locations = AdvertisementLocation::getLoactionArr();
		$data = array();
		foreach($locations as $kl=>$kv){
			$location_data = array();
			$location_data['sid'] = $kl;
			$location_data['name'] = $kv;
			foreach($grdes as $g=>$gn){
				$location_data[$g]['info'] = $school->getSchoolGradeInfo($g,$kl,$sdate,$edate);
			}
			array_push($data,$location_data);
		}
		$con = $this->renderPartial('school',array('data'=>$data,'grade_arr'=>$grdes),true);
		echo $con;
	}

	public function actionRangeconfig()
	{
		$order = Yii::app()->request->getParam('order');
		$con = $this->renderPartial('rangeconfig',array('order'=>$order),true);
		echo $con;
	}

	public function actionRangedetail()
	{
		$type = Yii::app()->request->getParam('ty');
		$rid = Yii::app()->request->getParam('rid');
		$data = array();
		if($type=='adv'){
			$relation = ContractAdvertisementRelation::model()->loadByPk($rid);
			$advid = $relation->aid;
			$alid = $relation->alid;
			$ranges = $relation->getAdvRangeData();
			$school_arr = array();
			$grade_arr = array();
			$school_data = array();
			foreach($ranges as $range){
				$sid = $range->sid;
				$gid = $range->gid;
				$days = $range->state;
				$days += 1;
				$school_data[$sid][$gid] = array('days'=>$days,
					'type'=>$this->getAdvRangeStatus($relation->startdate,$relation->enddate,$days)
					);
				if(!in_array($sid,$school_arr)){
					array_push($school_arr,$sid);
				}
				if(!in_array($gid,$grade_arr)){
					array_push($grade_arr,$gid);
				}
			}
			// echo "<pre>";
			// print_r($school_data);exit;
			$con = $this->renderPartial('rangedetailadv',array('data'=>$school_data,'grade_arr'=>$grade_arr,'school_arr'=>$school_arr,'relation'=>$relation),true);
			echo $con;
		}else{
			$relation = ContractFocusRelation::model()->loadByPk($rid);
			$school_arr = $relation->getRelationRangeSchools();
			$con = $this->renderPartial('rangedetailfoc',array('school_arr'=>$school_arr,'relation'=>$relation),true);
			echo $con;
		}
	}

	public function actionContypepreview()
	{
		$type = Yii::app()->request->getParam('ty');
		$rid = Yii::app()->request->getParam('tid');
		if($type=='adv'){
			$adv = Advertisement::model()->loadByPk($rid);
			$con = $this->renderPartial('contypepreview',array('model'=>$adv),true);
			echo $con;
		}elseif($type=='foc'){
			$foc = Focus::model()->loadByPk($rid);
			$con = $this->renderPartial('contypepreview',array('model'=>$foc),true);
			echo $con;
		}else{
			$info = Information::model()->loadByPk($rid);
			$con = $this->renderPartial('contypepreview',array('model'=>$info),true);
			echo $con;
		}
	}

	public function getAdvRangeStatus($s,$e,$d)
	{
		if(!$d)
			return 'empty';
		$s = strtotime($s);
		$e = strtotime($e);
		$day = ceil(($e-$s)/86400);
		if($d>=$day)
			return 'all';
		if($d<$day)
			return 'part';
		return 'empty';
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Contract the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Contract::model()->loadByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Contract $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contract-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
