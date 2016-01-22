<?php

class CoursesController extends Controller
{
    public function actionIndex()
    {
        // $schoolArr = School::getDataArr(true); //所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $query = isset($_GET['Class']) ? $_GET['Class'] : array('grade' => '', 'sid' => '', 'name' => '');
        if (isset($_GET['Class']) && isset($query['sid'])) {
            $gradeArr = School::getSchoolGradesArr($query['sid'], true);
            MainHelper::setCookie(Yii::app()->params['xxschoolid'], $query['sid']);
        } else {
            $query['sid'] = MainHelper::getCookie(Yii::app()->params['xxschoolid']);
            $gradeArr = $query['sid'] ? School::getSchoolGradesArr($query['sid'], true) : Grade::getGradeArr();
        }
        $query['size'] = 100;
        $tmp = array();
        if (empty($query['sid'])) {
            $subjects = array();
            $teachers = array();
            $classlist = array('model' => array(), 'pages' => array());
        } else {
            $subjects = School::getSchoolSubjectArr($query['sid']);
            $teachers = School::getSchoolTeacherArr($query['sid']);

            $members = array();
            foreach ($teachers as $kk => $kv) {
                $members[] = array("userid" => $kk, 'name' => $kv);
            }

            $classlist = MClass::model()->pageData($query);
        }
        $this->render('index', array('courses' => $classlist, 'schools' => $schoolArr, 'query' => $query, 'grades' => $gradeArr, 'subjects' => $subjects, 'teachers' => $teachers));
    }


    public function actionImport()
    {
        // $schoolArr = School::getDataArr(true); //所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        if (isset($_FILES['batchfile'])) {
            $uid = Yii::app()->user->id;
            $schoolid = Yii::app()->request->getParam("schoolid", 0);
            $SchoolSidArr = School::getSchoolSubjectArr($schoolid);
            $schoolClassArr = School::getSchoolClassArr($schoolid);
            $schoolTeacherArr = School::getSchoolTeacherArr($schoolid);
            //交换value与key值,id跟名字交换，根据名字查ID
            $teacherids = array_flip($schoolTeacherArr);
            $clascids = array_flip($schoolClassArr);
            $sids = array_flip($SchoolSidArr);
            if (empty($uid) || empty($schoolid)) {
                die(json_encode(array('status' => '2', 'msg' => '上传失败,参数有误'), JSON_UNESCAPED_UNICODE));
            }
            $validnum = 0; //符合条件数目;
            $novalidnum = 0; //不符合条件数目
            $notteachernum = 0; //年级不存在数目
            $notclassnum = 0; //年级不存在数目
            $notsubjectnum=0;//科目不存在数目
            $errNum=array(); //excel不符合条件的行数,
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
                $classname = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue());
                $sidname = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue());
                $teachername = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue());
                if (!in_array($classname, $schoolClassArr)) {
                    $notclassnum++;
                    $errNum[]=$row;
                }
                if ($sidname!=='班主任'&&!in_array($sidname, $SchoolSidArr)) {
                    $notsubjectnum++;
                    $errNum[]=$row;
                }
                if (!in_array($teachername, $schoolTeacherArr)) {
                    $notteachernum++;
                    $errNum[]=$row;
                }
                if ($classname && $sidname && $teachername && in_array($classname, $schoolClassArr) && in_array($teachername, $schoolTeacherArr)) {
                    $validnum++;
                    if ($sidname == "班主任") {
                        $sid = 0;
                    } else {
                        $sid = isset($sids[$sidname]) ? $sids[$sidname] : "";
                    }
                    $dataArr[] = array('classname' => $classname, 'cid' => $clascids[$classname], 'sid' => $sid, 'sidname' => $sidname, 'teacherid' => $teacherids[$teachername], 'teachername' => $teachername);
                } else {
                    $novalidnum++;
                    $errNum[]=$row;
                }

            }
            $cache = Yii::app()->cache;
            $cache->set("schoolid" . $schoolid . "coursesupload" . $uid, $dataArr);
            spl_autoload_register(array('YiiBase', 'autoload'));
            $errNums=!empty($errNum)?implode(",",array_unique($errNum)):'';//哪些行错误
            die(json_encode(array('status' => '1', 'msg' => '上传成功', 'errNum'=>$errNums,'notsubjectnum'=>$notsubjectnum,'notteachernum' => $notteachernum, 'notclassnum' => $notclassnum, 'filename' => $_FILES['batchfile']['name'], 'validnum' => $validnum, 'novalidnum' => $novalidnum), JSON_UNESCAPED_UNICODE));
        }
        $this->render("import", array('schools' => $schoolArr));
    }

    public function actionSaveexcel()
    {
        $cache = Yii::app()->cache;
        $schoolid = isset($_POST['schoolid']) ? intval($_POST['schoolid']) : 0;
        $uid = Yii::app()->user->id;
        if ($schoolid > 0) {
            $allData = $cache->get("schoolid" . $schoolid . "coursesupload" . $uid);
            $successNum = 0;
            if (is_array($allData)) {
                $transaction = Yii::app()->db_member->beginTransaction();
                $gradeArr = School::getSchoolGradesArr($schoolid); //获取学校所有年级
                $gradenamegidArr = array_flip($gradeArr);

                try {

                    foreach ($allData as $val) {
                        if ($val['sid'] === '') {
                            continue;
                        }

                        if ($val['sid'] === 0) { //班主任

                            $relation = ClassTeacherRelation::model()->findByAttributes(array("cid" => $val['cid'], "type" => 1));
                            if (!$relation) {
                                $relation = new ClassTeacherRelation;
                                $relation->sid = null;
                                $relation->type = 1;
                                $relation->state = 1;
                                $relation->teacher = $val['teacherid'];
                                $relation->cid = $val['cid'];
                                $relation->subject = '';
                                $relation->save();

                                $mclass = MClass::model()->findByPk($val['cid']);
                                if ($mclass) {
                                    $mclass->master = $val['teacherid'];
                                    $mclass->save();
                                }
                                $successNum++;
                            } else {
                                if ($relation->teacher != $val['teacherid']) {

                                    $relation->teacher = $val['teacherid'];
                                    $relation->deleted=0;
                                    $relation->save();
                                    $mclass = MClass::model()->findByPk($val['cid']);
                                    if ($mclass) {
                                        $mclass->master = $val['teacherid'];
                                        $mclass->save();
                                    }
                                    $successNum++;
                                }
                            }
                        } else
                            $relation = ClassTeacherRelation::getTeacherSubjectByCidSid($val['cid'], $val['sid']);
                            if (!$relation) {
                                $relation = new ClassTeacherRelation;
                                $relation->sid = $val['sid'];
                                $relation->type = 0;
                                $relation->state = 1;
                                $relation->teacher = $val['teacherid'];
                                $relation->cid = $val['cid'];
                                $relation->subject = $val['sidname'];
                                $relation->save();
                                $successNum++;
                            }else{
                                $relation->teacher=$val['teacherid'];
                                $relation->deleted=0;
                                $relation->state=1;
                                $relation->save();
                                $successNum++;
                            }
                    }
                    $transaction->commit();
                    Yii::app()->msg->postMsg('success', '成功导入' . $successNum . '条班级数据');
                } catch (Exception $e) {
                    error_log($e->getMessage());
                    $transaction->rollback();
                    Yii::app()->msg->postMsg('error', '成功导入' . $successNum . '条班级数据');
                }
                $url = Yii::app()->createUrl('courses/index') . "?Class[sid]=" . $schoolid . "&Class[grade]=&Class[name]=";
                $this->redirect($url);
            }
        }

    }
}