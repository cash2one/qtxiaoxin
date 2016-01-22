<?php

class ClassController extends Controller
{
    public function actionIndex()
    {
        // $schoolArr = School::getDataArr(true); //所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $query = isset($_GET['Class']) ? $_GET['Class'] : array('schoolname' => '', 'grade' => '', 'sid' => '', 'name' => '');
        if (isset($_GET['Class']) && isset($query['sid'])) {
            $gradeArr = $query['sid'] ? School::getSchoolGradesArr($query['sid']) : Grade::getGradeArr();
            MainHelper::setCookie(Yii::app()->params['xxschoolid'], $query['sid']);
        } else {
            $query['sid'] = isset($_GET['Class']) ? $query['sid'] : MainHelper::getCookie(Yii::app()->params['xxschoolid']);
            $gradeArr = $query['sid'] ? School::getSchoolGradesArr($query['sid']) : Grade::getGradeArr();
        }
        $classlist = MClass::model()->pageData($query);

        foreach ($classlist['model'] as $k => $v) {
            $classlist['model'][$k]->mastername = $v->master0 ? $v->master0->name : '';
            $schoolDeleted = $v->s->deleted ? '(已删除)' : '';
            $classlist['model'][$k]->schoolname = $v->s ? $v->s->name . $schoolDeleted : '';
            $stid = $v->stid;
            $year = $v->year;
            $age = MainHelper::getGradeAge($year);
            $gradeInfo = Grade::getGradeInfo(array('stid' => $stid, 'age' => $age));
            $classlist['model'][$k]['gradename'] = $gradeInfo ? $gradeInfo->name : '';
        }

        $this->render('index', array('grades' => $gradeArr, 'schools' => $schoolArr, 'classs' => $classlist, 'query' => $query));
    }
    public function actionCreate()
    {
        if (isset($_POST['Class'])) {
            $transaction = Yii::app()->db_member->beginTransaction();
            try {
                $model = new MClass;
                $model->attributes = $_POST['Class'];
                $model->creationtime = date("Y-m-d H:i:s");
                $model->master = $model->master ? $model->master : null;
                $grade = $_POST['grade'];
                $model->seqno=!empty($model->seqno)? $model->seqno:99999999;
                $model->teachers = $model->teachers ? $model->teachers : 1;
                $model->cid = UCQuery::makeMaxId(1, true);
                if ($grade) {
                    if ($grade == 'interest') { //创建兴趣班
                        $model->stid = 0;
                        $model->year = 0;
                        $model->type = 1;
                    } else {
                        $gradeInfo = Grade::model()->findByPk($grade);
                        $stid = $gradeInfo->stid;
                        $year = MainHelper::getClassYearByGradeAge($gradeInfo->age);
                        $model->stid = $stid;
                        $model->year = $year;
                    }
                } else {
                    Yii::app()->msg->postMsg('error', '参数有错误，失败');
                    $this->redirect(array('create'));
                }
               $classname =  MClass:: getClassByName($model->name,$model->sid);
               if(!$classname){
                   $model->save();
                   if ($model->master) {
                       ClassTeacherRelation::updateOrCreateMaster($model->master, $model->cid);
                   }
                   $transaction->commit();
                   Yii::app()->msg->postMsg('success', '创建班级成功');
                   $this->redirect(array('index'));
               }else{
                   Yii::app()->msg->postMsg('error', '创建班级失败,该班级名称已存在');
                   $this->redirect($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : array('index'));
               }

            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->msg->postMsg('error', '创建班级失败');
                $this->redirect(array('create'));
            }

        }
        // $schoolArr = School::getDataArr(true); //所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $sid = MainHelper::getCookie(Yii::app()->params['xxschoolid']);
        $this->render('create', array('schools' => $schoolArr, 'sid' => $sid));
    }

    public function actionUpdate($id)
    {
        $model = MClass::model()->loadByPk($id);
        if (isset($_POST['Class'])) {
            $cid = isset($_POST['Class']['cid'])?$_POST['Class']['cid']:"";
            $className = isset($_POST['Class']['name'])?$_POST['Class']['name']:"";
            $schoolid = isset($_POST['Class']['sid'])?$_POST['Class']['sid']:"";
            $isClass =  MClass:: getClassByName($className,$schoolid);
            if(!$isClass||($isClass&&$isClass->cid==$cid)){
                    $transaction = Yii::app()->db_member->beginTransaction();
                    try {
                        $model->attributes = $_POST['Class'];
                        $model->seqno=!empty($model->seqno)? $model->seqno:99999999;
                        //$model->seqno =  $_POST['Class']['seqno'];
                        $grade = isset($_POST['grade']) ? $_POST['grade'] : '';
                        //$model->teachers = $model->teachers?$model->teachers:1;
                        if ($grade) {
                            if ($grade == 'interest') { //兴趣班
                                $model->stid = 0;
                                $model->year = 0;
                                $model->type = 1;
                            } else {
                                $gradeInfo = Grade::model()->findByPk($grade);
                                $stid = $gradeInfo->stid;
                                $year = MainHelper::getClassYearByGradeAge($gradeInfo->age);
                                $model->stid = $stid;
                                $model->year = $year;
                                 $model->type = 0;
                            }
                        }
                        //  else {
                        //     Yii::app()->msg->postMsg('error', '参数有错误，失败');
                        //     $this->redirect(array('create'));
                        // }
                        $model->master = $model->master ? $model->master : null;

                        $model->save();
                        if ($model->master) {
                            ClassTeacherRelation::updateOrCreateMaster($model->master, $model->cid);
                        } else {
                            $master = ClassTeacherRelation::updateOrCreateMaster($model->master, $model->cid);
                            //$master->deletedMark();
                        }
                        $transaction->commit();
                        Yii::app()->msg->postMsg('success', '修改班级成功');
                        $this->redirect(array('index'));
                    } catch (Exception $e) {

                        $transaction->rollback();
                        Yii::app()->msg->postMsg('error', '改班级失败');
                        $this->redirect(array('index'));
                    }
            }else{
                Yii::app()->msg->postMsg('error', '修改班级失败,该班级名称已存在');
                $this->redirect($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : array('index'));
            }
        }
        if ($model->sid) { //考虑学校删除的情况
            $schoolInfo = School::model()->findByPk($model->sid);
            $isDeleteSchool = $schoolInfo->deleted;
        }
        $grade = $model->getClassGrade();
        if ($isDeleteSchool) {
            $gradeArr = array();
            $teacherArr = array();
        } else {
            $gradeArr = School::getSchoolGradesArr($model->sid, true);
            $teacherArr = School::getSchoolTeacherArr($model->sid);
        }
        // $schoolArr = School::getDataArr(true); //所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $this->render('update', array('model' => $model, 'schools' => $schoolArr, 'grade' => $grade, 'grades' => $gradeArr, 'teachers' => $teacherArr));
    }

    public function actionDelete($id)
    {
        $list = Yii::app()->request->getParam("list", 0);
        if ($id) {
            $model = MClass::model()->loadByPk($id);
            $model->deleteMark();
            Yii::app()->msg->postMsg('success', '删除成功');
            if ($list) {
                $this->redirect(Yii::app()->createUrl("class/index"));
            } else {
                $this->redirect($this->previousurl);
            }

        } else {
            Yii::app()->msg->postMsg('success', '参数传入有错误,请重试');
            $this->redirect($this->previousurl);
        }
    }

    //班级导入
    public function actionImport()
    {
        // $schoolArr = School::getDataArr(true); //所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        if (isset($_FILES['batchfile'])) {
            $uid = Yii::app()->user->id;
            $schoolid = Yii::app()->request->getParam("schoolid", 0);
            $gradeArr = School::getSchoolGradesArr($schoolid);//获取学校所有年级
            $classArr = MClass::getSchoolClassAfter($schoolid);//获取学校所有的班级
            $gradenamegidArr=array_flip($gradeArr);
            if (empty($uid) || empty($schoolid)) {
                die(json_encode(array('status' => '2', 'msg' => '上传失败,参数有误'), JSON_UNESCAPED_UNICODE));
            }
            $errNum=array(); //excel不符合条件的行数,
            $validnum = 0; //符合条件数目;
            $novalidnum = 0; //不符合条件数目
            $notgradenum=0;//年级不存在数目
            $notclassnum=0;//班级已经存在
            $root = yii::app()->basePath;
            spl_autoload_unregister(array('YiiBase', 'autoload'));
            $uploadfile = $_FILES['batchfile']['tmp_name'];
            Yii::$enableIncludePath = false;
            Yii::import('application.extensions.PHPExcel', 1);
            require_once($root . '/extensions/PHPExcel/IOFactory.php');
            require_once($root . '/extensions/PHPExcel/Reader/Excel5.php');
            $objPHPExcel = new PHPExcel();
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($uploadfile);
            $objPHPExcel->setActiveSheetIndex(0);
            $mobileArr = array();
            $ActiveSheet = $objPHPExcel->getActiveSheet();
            $max = $objPHPExcel->getActiveSheet()->getHighestRow();
            $dataArr = array();
            for ($row = 2; $row <= $max; $row++) {
                $classname = MainHelper::csubstr(trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue()),0,20);
                $gradename = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue());
                if((!in_array($gradename,$gradeArr)&&$gradename!="兴趣班")){
                    $notgradenum++;
                    $errNum[]=$row;
                }
                 if(in_array($classname,$classArr)){
                     $notclassnum++;
                     $errNum[]=$row;
                 }
                if (!in_array($classname,$classArr)&&$classname&&$gradename&&(in_array($gradename,$gradeArr)||$gradename=="兴趣班")){
                    $validnum++;
                    $dataArr[]=array('classname' => $classname,'gradename'=>$gradename);
                } else {
                    $novalidnum++;
                    $errNum[]=$row;
                }
            }
            $cache = Yii::app()->cache;
            $cache->set("schoolid" . $schoolid . "classupload" . $uid, $dataArr);
            spl_autoload_register(array('YiiBase', 'autoload'));
            $errNums=!empty($errNum)?implode(",",array_unique($errNum)):'';//哪些行错误
            die(json_encode(array('status' => '1', 'msg' => '上传成功','notclassnum'=>$notclassnum,'errNum'=>$errNums,'notgradenum'=>$notgradenum,'filename' => $_FILES['batchfile']['name'],  'validnum' => $validnum, 'novalidnum' => $novalidnum), JSON_UNESCAPED_UNICODE));
        }
        $this->render("import", array('schools' => $schoolArr));
    }
    /*
     * 保存老师上传的数据
     */
    public function actionSaveexcel(){
        $cache = Yii::app()->cache;
        $schoolid=isset($_POST['schoolid'])?intval($_POST['schoolid']):0;
        $uid = Yii::app()->user->id;
        if ($schoolid>0) {
            $allData = $cache->get("schoolid" . $schoolid . "classupload" . $uid);
            $successNum = 0;
            if (is_array($allData)) {
                $transaction = Yii::app()->db_member->beginTransaction();
                $gradeArr = School::getSchoolGradesArr($schoolid);//获取学校所有年级
                $gradenamegidArr=array_flip($gradeArr);

                try {
                    foreach ($allData as $val) {
                        $classname = $val['classname'];//班级名称
                        $gradename = $val['gradename'];//年级名称
                        if($gradename=='兴趣班'){
                                $classinfo=MClass::model()->findByAttributes(array('deleted'=>0,'sid'=>$schoolid,'name'=>$classname,'type'=>1));
                                if($classinfo){
                                    continue;
                                }
                                $mclass=new MClass;
                                $mclass->cid = UCQuery::makeMaxId(1, true);
                                $mclass->name=$classname;
                                $mclass->sid=$schoolid;
                                $mclass->stid = 0;
                                $mclass->year = 0;
                                $mclass->type = 1;
                                $mclass->save();
                                $successNum++;

                        }else{

                               if(!in_array($gradename,$gradeArr)){
                                   continue;
                               }else{
                                   $gid=$gradenamegidArr[$gradename];
                                   $gradeInfo=Grade::model()->findByPk($gid);

                                   $year=MainHelper::getClassYearByGradeAge($gradeInfo->age);
                                   $classinfo=MClass::model()->findByAttributes(array('deleted'=>0,'sid'=>$schoolid,'name'=>$classname,'stid'=>$gradeInfo->stid,'year'=>$year));
                                   if($classinfo){
                                       continue;
                                   }
                                   $mclass=new MClass;
                                   $mclass->cid = UCQuery::makeMaxId(1, true);
                                   $mclass->name=$classname;
                                   $mclass->sid=$schoolid;
                                   $mclass->stid = $gradeInfo->stid;
                                   $mclass->year = $year;
                                   $mclass->type = 0;
                                   $mclass->save();
                                   $successNum++;
                               }
                        }
                    }
                    $transaction->commit();
                    Yii::app()->msg->postMsg('success', '成功导入' . $successNum . '条班级数据');
                }catch(Exception $e){
                    $transaction->rollback();
                    error_log($e->getMessage());
                    Yii::app()->msg->postMsg('error', '成功导入' . $successNum . '条班级数据');
                }
                $url = Yii::app()->createUrl('class/index') . '?Class[sid]=' . $schoolid . "&Class[grade]=&Class[name]=";
                $this->redirect($url);
            }
        }
    }
    /*
     * 班级重置密码
     * 传cid和isNotSendStudent"
     * isNotSendStudent  1－是只给未发送密码学生发,
     *                   0不是表示全班同学
     */
    public function actionInitclasspwd()
    {
        $cid = (int)Yii::app()->request->getParam("cid", 0);
        $isNotSendStudent = (int)Yii::app()->request->getParam("isNotSendStudent", 0);
        if ($cid) {
            $classStudent = ClassStudentRelation::getClassStudents($cid, $isNotSendStudent);
            $num=0;
            foreach ($classStudent as $val) {
                $guardians = Guardian::getChildGuardian($val->student);
                foreach ($guardians as $member) {
                    if ($member && $member->deleted == 0) {
                        if($isNotSendStudent){
                            if($member->issendpwd==1){
                                continue;
                            }
                        }
                        $password = MainHelper::generate_code(6);
                        $member->pwd = MainHelper::encryPassword($password);
                        $member->issendpwd=1;
                        if ($member->save()) {                            
							UCQuery::sendMobilePasswordMsg($member->mobilephone,$password);
                        }
                    }
                }
                $num++;
                if($val->student0){
                    $val->student0->issendpwd=1;
                    $val->student0->save();
                }
            }
            Yii::app()->msg->postMsg('success', '重置成功'.$num."条");
        } else {
            Yii::app()->msg->postMsg('error', '参数有误');
        }
        $this->redirect($this->previousurl?$this->previousurl:array('index'));
    }
}