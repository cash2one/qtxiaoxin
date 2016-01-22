<?php

class FocsController extends Controller
{
	public function actionTest()
	{
		$query = isset($_GET['Focus']) ? $_GET['Focus'] : array();
		$data = Focus::model()->pageDataGird($query);
		$model = new Focus;
        $this->render('test',array('data'=>$data,'Focus'=>$query,'model'=>$model));
	}

	public function actionIndex()
	{
		$query = isset($_GET['Focus']) ? $_GET['Focus'] : array();
		$data = ViewGirdFocus::model()->pageData($query);
		$model = new Focus;
        $this->render('index',array('data'=>$data,'Focus'=>$query,'model'=>$model));
	}

	public function actionBrowse($id)
	{
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$query['tid'] = $id;
		$query['action'] = 'Browse';
		$query['target'] = 'Focus';
		$data = ClientLogSchoolRelation::model()->pageData($query);
		$model = new ClientLogSchoolRelation;
        $this->render('browse',array('data'=>$data,'ClientLogSchoolRelation'=>$query,'model'=>$model));
	}

	public function actionJoin($id)
	{
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$query['tid'] = $id;
		$query['action'] = 'Join';
		$query['target'] = 'Focus';
		$data = ClientLogSchoolRelation::model()->pageData($query);
		$model = new ClientLogSchoolRelation;
        $this->render('join',array('data'=>$data,'ClientLogSchoolRelation'=>$query,'model'=>$model));
	}

	public function actionDaily($id)
	{	
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$model = Focus::model()->findByPk($id);
		$logs = $model->getDailyLog($query);
		$this->render('daily',array('model'=>$model,'ClientLogSchoolRelation'=>$query,'logs'=>$logs));
	}

	public function actionAnswer($id)
	{	
		$model = Focus::model()->findByPk($id);
		$this->render('answer',array('model'=>$model));
	}

	public function actionReplay($id)
	{	
		$model = FocusQuestion::model()->findByPk($id);
		$data = FocusAnswer::getQuestionAnswerReplaies(array('fqid'=>$model->fqid));
		$this->render('replay',array('model'=>$model,'data'=>$data));
	}
}