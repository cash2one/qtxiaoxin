<?php

class SubjectController extends Controller
{
	public function actionIndex()
	{
        $query = isset($_GET['Subject']) ? $_GET['Subject'] : array( 'schoolid' => '','name'=>'');
        if(isset($_GET['Subject'])&&isset($query['schoolid'])){
            MainHelper::setCookie(Yii::app()->params['xxschoolid'],$query['schoolid']);
        }
        $query['schoolid'] = isset($_GET['Subject'])?$query['schoolid']:MainHelper::getCookie(Yii::app()->params['xxschoolid']);
        $subjectlist =Subject::model()->pageData($query);
        // $schoolArr = School::getDataArr(true);//所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $this->render('index',array('subjects'=>$subjectlist,'schools'=>$schoolArr,'query'=>$query));

	}

	public function actionCreate()
	{
        // $schoolArr = School::getDataArr(true);//所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        if (isset($_POST['Subject'])) {
            $model = new Subject();
            $model->attributes = $_POST['Subject'];
            $model->sid = UCQuery::makeMaxId(4,true);
            if ($model->save()) {
                Yii::app()->msg->postMsg('success', '创建科目成功');
                $this->redirect(array('index'));
            }
        }
        $sid = MainHelper::getCookie(Yii::app()->params['xxschoolid']);
        $this->render('create',array('schools'=>$schoolArr,'sid'=>$sid));
	}

	public function actionUpdate($id)
	{
        $model = Subject::model()->loadByPk($id);
        // $schoolArr = School::getDataArr(true);//所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        if (isset($_POST['Subject'])) {
            $model->attributes = $_POST['Subject'];
            $success=$model->save();
            if ($model->save()) {
                Yii::app()->msg->postMsg('success', '编辑科目成功');
                $this->redirect(array('index'));
            }
        }
        $this->render('update',array('schools'=>$schoolArr,'model'=>$model));
	}
    
    public function actionDelete($id)
    {
        $list = Yii::app()->request->getParam("list", 0);
        if ($id) {
            $model = Subject::model()->loadByPk($id);
            $model->deleteMark();
            Yii::app()->msg->postMsg('success', '删除成功');
            if($list){
                $this->redirect(Yii::app()->createUrl("subject/index"));
            }else{
                $this->redirect($this->previousurl);
            }

        } else {
            Yii::app()->msg->postMsg('success', '参数传入有错误,请重试');
            $this->redirect($this->previousurl);
        }
    }
}