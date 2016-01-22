<?php

class SchoolController extends Controller
{
    public function actionIndex()
    {

        $typeArr = Yii::app()->cache->get("school_type_list");
        if (empty($typeArr)) {
            $typeArr = SchoolType::getSchoolTypeArr();
            Yii::app()->cache->set("school_type_list", $typeArr);
        }
        $allProvinces = Area::getAllprovince(); //所有省份
        $cityArr = Area::getCityArr();
        // $schoolArr = School::getDataArr(true);
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $query = isset($_GET['School']) ? $_GET['School'] : array('name' => '', 'type' => '', 'city' => '', 'area' => '','province'=>'');
        $schools = School::model()->pageData($query);
        foreach ($schools['model'] as $k => $val) {
            $types = explode(",", $val->stid);
            $typedesc = "";
            foreach ($types as $v) {
                if ($v&&isset($typeArr[$v])) {
                    $typedesc .= $typeArr[$v] . ",";
                }
            }
            $schools['model'][$k]->stype = rtrim($typedesc, ",");
            $schools['model'][$k]->area = $val->a->name;
        }
        //给所有学校名称给前端，用于自动完成
        $schoolnames = '';
        foreach ($schoolArr as $k => $v) {
            $label=explode(":",$v);
            $schoolnames[] = array('value' => isset($label[1])?$label[1]:$v, 'label' =>$v );
        }

       if ($query['city']) {
            $areas = Area::getCityAreaArr($query['city']);
        } else {
            $areas = array();
        }
        if ($query['province']) {
            $cityData=Area::getCity(array('cid'=>$query['province']));
        } else {
            $cityData = array();
        }
        if ($query['city']) {
            $areaData=Area::getCity(array('cid'=>$query['city']));
        } else {
            $areaData = array();
        }
        $schoolnames = json_encode($schoolnames);
        $this->render('index', array('areaData'=>$areaData,'cityData'=>$cityData,'types' => $typeArr, 'citys' => $cityArr, 'areas' => $areas, 'schoollist' => $schoolArr, 'schools' => $schools, 'query' => $query, 'schoolnames' => $schoolnames,'allProvinces'=>$allProvinces));
    }

    public function actionCreate()
    {
        $typeArr = Yii::app()->cache->get("school_type_list");
        if (empty($typeArr)) {
            $typeArr = SchoolType::getSchoolTypeArr();
            Yii::app()->cache->set("school_type_list", $typeArr);
        }
        $allProvinces = Area::getAllprovince(); //所有省份
        $cityArr = Area::getCityArr();
        $citys=array();
        $towns=array();
        $mycity='';
        $myprovince='';
        if (isset($_POST['School'])) {
            $model = new School;
            $model->attributes = $_POST['School'];
            $model->stid = implode(",", $_POST['selecttype']);
            $model->sid = UCQuery::makeMaxId(2, true);
            $taocan = isset($_POST['School']['taocan'])?$_POST['School']['taocan']:"";
            if ($model->save()) {
                if($taocan=="C"){
                    $sms = new SmsConfig;
                    $sms->sid = $model->sid;
                    $sms->noticetype='0,1,2,3,5,6,7,8';
                    $time = date("Y-m-d")." 00:00:00";
                    $sms->starttime=$time;
                    $sms->save();
                }
                Yii::app()->msg->postMsg('success', '创建学校成功');
                MainHelper::setCookie(Yii::app()->params['xxschoolid'], $model->sid);
                $this->redirect(array('index'));
            }

        }
        $stid = array();
        $taocan = "AB";
         $this->render('create', array('myprovince'=>$myprovince,'mycity'=>$mycity,'allProvinces'=>$allProvinces,'types' => $typeArr,'taocan'=>$taocan,'citys' => $citys, 'update' => 0, 'model' => '', 'stid' => $stid));
    }

    public function actionUpdate($id)
    {
        $typeArr = Yii::app()->cache->get("school_type_list");
        if (empty($typeArr)) {
            $typeArr = SchoolType::getSchoolTypeArr();
            Yii::app()->cache->set("school_type_list", $typeArr);
        }
        $smsconfig = SmsConfig::model()->find('sid=:sid',array(':sid'=>$id));
        if($smsconfig){
           $taocan = "C";
        }else{
            $taocan = "AB";
        }
        $allProvinces = Area::getAllprovince(); //所有省份
        $cityArr = Area::getCityArr();
        $model = School::model()->loadByPk($id);
        if (isset($_POST['School'])) {
            $model->name = $_POST['School']['name'];
            $model->stid = implode(",", $_POST['selecttype']);
            $model->aid = $_POST['School']['aid'];
            $model->enableddirectsend = $_POST['School']['enableddirectsend'];
            $taocan = isset($_POST['School']['taocan'])?$_POST['School']['taocan']:"";
            if ($model->save()) {
                if($taocan=="AB"){
                    if($smsconfig){
                        $smsconfig->delete();
                    }
                }else if($taocan=="C"){
                    if(!$smsconfig){
                        $sms = new SmsConfig;
                        $sms->sid = $model->sid;
                        $sms->noticetype='0,1,2,3,5,6,7,8';
                        $time = date("Y-m-d")." 00:00:00";
                        $sms->starttime=$time;
                        $sms->save();
                    }
                }
                Yii::app()->msg->postMsg('success', '修改学校成功');
                $this->redirect(Yii::app()->createUrl('school/index'));
            }

        }
        $aid = $model->aid;
        $citys=array();
        $towns=array();
        $mycity='';
        $myprovince='';
        if(strlen($aid)==6){
            $mycity=substr($aid,0,4)."00";
            $myprovince=substr($aid,0,2)."0000";
            $citys=Area::getCity(array('cid'=>$myprovince));
            $towns=Area::getCity(array('cid'=>$mycity));
        }


        $stid = explode(",", $model->stid);
        $this->render('create', array(
            'model' => $model, 'citys'=>$citys,'areas'=>$towns,'myprovince'=>$myprovince,'allProvinces'=>$allProvinces, 'taocan'=>$taocan,'types' => $typeArr,  'update' => 1, 'cityId' => $mycity, 'stid' => $stid
        ));
    }

    /*
     * 删除学校
     */
    public function actionDelete()
    {
        $id = Yii::app()->request->getParam("id", 0);
        $list = Yii::app()->request->getParam("list", 0);
        if ($id) {
            $result = School::deleteSchool($id);
            if ($result) {
                Yii::app()->msg->postMsg('success', '删除成功');
            } else {
                Yii::app()->msg->postMsg('error', '删除失败');
            }

            if ($list) {
                $this->redirect(Yii::app()->createUrl("school/index"));
            } else {
                $this->redirect($this->previousurl);
            }

        } else {
            Yii::app()->msg->postMsg('success', '参数传入有错误,请重试');
            $this->redirect($this->previousurl);
        }

    }

}