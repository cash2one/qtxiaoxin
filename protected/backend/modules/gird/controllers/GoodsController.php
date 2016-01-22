<?php

class GoodsController extends Controller
{
	public function actionTest()
	{
		$query = isset($_GET['MallGoods']) ? $_GET['MallGoods'] : array();
		$data = MallGoods::model()->pageData($query);
		$model = new MallGoods;
        $this->render('test',array('data'=>$data,'MallGoods'=>$query,'model'=>$model));
	}

	public function actionIndex()
	{
		$query = isset($_GET['MallGoods']) ? $_GET['MallGoods'] : array();
		$data = ViewGirdMallGoods::model()->pageData($query);
		$model = new MallGoods;
        $this->render('index',array('data'=>$data,'MallGoods'=>$query,'model'=>$model));
	}

	public function actionBrowse($id)
	{
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$query['tid'] = $id;
		$query['action'] = 'Browse';
		$query['target'] = 'Mall';
		$data = ClientLogSchoolRelation::model()->pageData($query);
		$model = new ClientLogSchoolRelation;
        $this->render('browse',array('data'=>$data,'ClientLogSchoolRelation'=>$query,'model'=>$model));
	}

	public function actionSold($id)
	{
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$query['tid'] = $id;
		$query['action'] = 'Buy';
		$query['target'] = 'Mall';
		$data = ClientLogSchoolRelation::model()->pageData($query);
		$model = new ClientLogSchoolRelation;
        $this->render('sold',array('data'=>$data,'ClientLogSchoolRelation'=>$query,'model'=>$model));
	}

	public function actionComment($id)
	{
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$query['tid'] = $id;
		$query['action'] = 'Comment';
		$query['target'] = 'Mall';
		$data = ClientLogSchoolRelation::model()->pageData($query);
		$model = new ClientLogSchoolRelation;
        $this->render('comment',array('data'=>$data,'ClientLogSchoolRelation'=>$query,'model'=>$model));
	}

	public function actionDaily($id)
	{	
		$query = isset($_GET['ClientLogSchoolRelation']) ? $_GET['ClientLogSchoolRelation'] : array();
		$model = MallGoods::model()->findByPk($id);
		$logs = $model->getDailyLog($query);
		$this->render('daily',array('model'=>$model,'ClientLogSchoolRelation'=>$query,'logs'=>$logs));
	}
}