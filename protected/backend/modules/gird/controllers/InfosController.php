<?php

class InfosController extends Controller
{
	public function actionTest()
	{
		$query = isset($_GET['Information']) ? $_GET['Information'] : array();
		$data = Information::model()->pageDataGird($query);
		$model = new Information;
        $this->render('test',array('data'=>$data,'Information'=>$query,'model'=>$model));
	}

	public function actionIndex()
	{
		$query = isset($_GET['Information']) ? $_GET['Information'] : array();
		$data = ViewGirdInformation::model()->pageData($query);
		$model = new Information;
        $this->render('index',array('data'=>$data,'Information'=>$query,'model'=>$model));
	}

	public function actionBrowse($id)
	{
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$query['tid'] = $id;
		$query['action'] = 'Browse';
		$query['target'] = 'Information';
		$data = ClientLogSchoolRelation::model()->pageData($query);
		$model = new ClientLogSchoolRelation;
        $this->render('browse',array('data'=>$data,'ClientLogSchoolRelation'=>$query,'model'=>$model));
	}

	public function actionDaily($id)
	{	
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$model = Information::model()->findByPk($id);
		$logs = $model->getDailyLog($query);
		$this->render('daily',array('model'=>$model,'ClientLogSchoolRelation'=>$query,'logs'=>$logs));
	}
}