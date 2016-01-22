<?php

class PartController extends Controller
{
	public function actionIndex()
	{
		$query = isset($_GET['Department']) ? $_GET['Department'] : array( 'sid' => '','name'=>'');
        if(isset($_GET['Department'])&&isset($query['sid'])){
            MainHelper::setCookie(Yii::app()->params['xxschoolid'],$query['sid']);
        }
        $query['sid']=isset($_GET['Department'])?$query['sid']:MainHelper::getCookie(Yii::app()->params['xxschoolid']);
        $partlist =Department::model()->pageData($query);
        // $schoolArr = School::getDataArr(true);//所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
		$this->render('index',array('parts'=>$partlist,'schools'=>$schoolArr,'query'=>$query));
	}

	public function actionCreate()
	{
        // $schoolArr = School::getDataArr(true);//所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        if (isset($_POST['Department'])) {
            $model = new Department;
            $model->attributes = $_POST['Department'];
            $model->did = UCQuery::makeMaxId(3,true);
            if ($model->save()) {
                Yii::app()->msg->postMsg('success', '创建部门成功');
                $this->redirect(array('index'));
            }
        }
        $sid=MainHelper::getCookie(Yii::app()->params['xxschoolid']);
        $this->render('create',array('schools'=>$schoolArr,'sid'=>$sid));
	}

	public function actionUpdate($id)
	{
        $model = Department::model()->loadByPk($id);
        // $schoolArr = School::getDataArr(true);//所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        if (isset($_POST['Department'])) {
            $model->attributes = $_POST['Department'];
            if ($model->save()) {
                Yii::app()->msg->postMsg('success', '编辑部门成功');
                $this->redirect(array('index'));
            }
        }
		$this->render('update',array('schools'=>$schoolArr,'model'=>$model));
	}

    public function actionDelete($id)
    {
        $list = Yii::app()->request->getParam("list", 0);
        if ($id) {
            $model = Department::model()->loadByPk($id);
            $model->deleteMark();
            Yii::app()->msg->postMsg('success', '删除成功');
            if($list){
                $this->redirect(Yii::app()->createUrl("part/index"));
            }else{
                $this->redirect($this->previousurl);
            }

        } else {
            Yii::app()->msg->postMsg('success', '参数传入有错误,请重试');
            $this->redirect($this->previousurl);
        }
    }
}