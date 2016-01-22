<?php

class AdvsController extends Controller
{
	public function actionTest()
	{
		$query = isset($_GET['Advertisement']) ? $_GET['Advertisement'] : array();
		$data = Advertisement::model()->pageDataGird($query);
		$model = new Advertisement;
        $this->render('test',array('data'=>$data,'Advertisement'=>$query,'model'=>$model));
	}

	public function actionIndex()
	{
		$query = isset($_GET['Advertisement']) ? $_GET['Advertisement'] : array();
		$data = ViewGirdAdvertisement::model()->pageData($query);
		$model = new Advertisement;
        $this->render('index',array('data'=>$data,'Advertisement'=>$query,'model'=>$model));
	}

	public function actionBrowse($id)
	{
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$query['tid'] = $id;
		$query['action'] = 'Browse';
		$query['target'] = 'Advertisement';
		$data = ClientLogSchoolRelation::model()->pageData($query);
		$model = new ClientLogSchoolRelation;
        $this->render('browse',array('data'=>$data,'ClientLogSchoolRelation'=>$query,'model'=>$model));
	}

	public function actionDaily($id)
	{	
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$model = Advertisement::model()->findByPk($id);
		$logs = $model->getDailyLog($query);
		$this->render('daily',array('model'=>$model,'ClientLogSchoolRelation'=>$query,'logs'=>$logs));
	}
}