<?php

class StudentController extends Controller
{
    public function actionIndex()
    {


        // $schoolArr = School::getDataArr(true); //所有学校,带首字母用于下拉
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        //$schoolArr1 = School::getDataArr(); //所有学校不带首字母;
        $query = isset($_GET['Student']) ? $_GET['Student'] : array('mobilephone' => '', 'cid' => '', 'sid' => '', 'name' => '');
        //如果传入学校，就要设置学校cookie
        if (isset($_GET['Student']) && isset($query['sid'])) {
            MainHelper::setCookie(Yii::app()->params['xxschoolid'], $query['sid']);
        } else {
            $query['sid'] = isset($_GET['Student']) ? $query['sid'] : MainHelper::getCookie(Yii::app()->params['xxschoolid']);
        }
        if (isset($query['cid'])) {
            MainHelper::setCookie("selectcurrentcid", $query['cid']);
        }
        $page = (int)Yii::app()->request->getParam("page", 1);

        $query['page'] = $page;
        $studentList = ClassStudentRelation::model()->pageDataBySql($query);
        $count = $studentList['total'];
        $criteria = new CDbCriteria();
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        foreach ($studentList['list'] as $k => $val) {
            $m = ClassStudentRelation::getStudentClassSchoolName($val['userid']);
            //  print("select t.userid,t.mobilephone as mobilephone,p.role from tb_user t inner join (select guardian,role from tb_guardian where child=" . $val['userid'] . " and deleted=0) p on p.guardian=t.userid where t.deleted=0  ");
            $mobilephone = UCQuery::queryAll("select t.userid,t.mobilephone as mobilephone,p.role from tb_user t inner join (select guardian,role from tb_guardian where child=" . $val['userid'] . " and deleted=0) p on p.guardian=t.userid where t.deleted=0  ");
            $studentList['list'][$k]['classArr'] = $m; //班级名和学校名的数组
            //var_dump($mobilephone);
            foreach ($mobilephone as $kk => $vv) {
                $mobilephone[$kk]['client'] = UserOnline::getOnLineByUserId($vv['userid']) ? 1 : 0;
            }
            $studentList['list'][$k]['mobilephone'] = $mobilephone;
            $studentList['list'][$k]['classNum'] = count($m);
            if ($studentList['list'][$k]['classNum'] > 1) {
                if ($query['sid'] && $query['cid']) { //选择了学校和班级
                    foreach ($m as $tt => $ttv) {
                        if ($ttv['cid'] == $query['cid']) { //查询时选了班级，选择查询的班级为显示班级
                            $studentList['list'][$k]['currentClassName'] = isset($m[$tt]) ? $m[$tt]['classname'] : '';
                            $studentList['list'][$k]['currentSchoolName'] = isset($m[$tt]) ? $m[$tt]['schoolname'] : '';
                        }
                    }
                } else if ($query['sid'] && empty($query['cid'])) {
                    foreach ($m as $tt => $ttv) {
                        if ($ttv['sid'] == $query['sid']) {
                            $studentList['list'][$k]['currentClassName'] = isset($m[$tt]) ? $m[$tt]['classname'] : '';
                            $studentList['list'][$k]['currentSchoolName'] = isset($m[$tt]) ? $m[$tt]['schoolname'] : '';
                        }
                    }
                } else { //没有选学校班级查询，取第一个
                    $studentList['list'][$k]['currentClassName'] = isset($m[0]) ? $m[0]['classname'] : '';
                    $studentList['list'][$k]['currentSchoolName'] = isset($m[0]) ? $m[0]['schoolname'] : '';
                }

            } else {
                $studentList['list'][$k]['currentClassName'] = isset($m[0]) ? $m[0]['classname'] : '';
                $studentList['list'][$k]['currentSchoolName'] = isset($m[0]) ? $m[0]['schoolname'] : '';
            }


        }
        $studentList['pages'] = $pages;
        $classArr = array();
        if ($query['sid']) {
            $classArr = School::getSchoolClassArr($query['sid']);
        }


        $this->render('index', array('schools' => $schoolArr, 'classs' => $classArr, 'students' => $studentList, 'query' => $query));
    }

    public function actionCreate()
    {
        // $schoolArr = School::getDataArr(true); //所有学校,带首字母用于下拉
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $sid = MainHelper::getCookie(Yii::app()->params['xxschoolid']);
        $cid = Yii::app()->request->getParam("cid", '');
        $classArr = array();
        if (isset($_POST['Student'])) {
            $msgArr = array();
            $transaction = Yii::app()->db_member->beginTransaction();
            try {
                $mobilephones = isset($_POST['mobilephone']) ? array_unique($_POST['mobilephone']) : array();
                $p_mobile = array();
                foreach ($mobilephones as $val) {
                    $p_mobile[$val] = Member::getUniqueMember($val);
                }
                $studentname = trim($_POST['Student']['name']);
                $isExistsChild = false;

                foreach ($p_mobile as $k => $val) {
                    if ($val) {

                        //判断学生名字是否一致
                        $child = $child = Guardian::checkGuardianChildByName($val->userid,$studentname);
                        if ($child && $child->deleted == 0) {
                            $isExistsChild = $child;
                            break;
                        }
                    }
                }
                if ($isExistsChild) {
                    Yii::app()->msg->postMsg('error', '监护人手机号已有这个孩子名，勿需再重新创建');
                    $this->redirect(array('index'));
                    exit();
                }


                if (!$isExistsChild) {
                    $suid = UCQuery::makeMaxId(0, true);
                    $member = new Member;
                    $member->userid = $suid;
                    $member->name = $_POST['Student']['name'];
                    $member->identity = 2; //学生标志;
                    $member->account = "s" . $suid; //默认老师身份;
                    $member->pwd = MainHelper::encryPassword("123456");
                    $member->state = 1;
                    $member->issendpwd = 1;
                    $member->save();
                } else {
                    $member = Member::model()->findByPk($isExistsChild->child);
                    if ($member) {
                        $suid = $member->userid;
                        Guardian::deleteStudentGrardianRelation($member->userid); //删除原来的学生家长关系
                        //删除学生班级关系
                        ClassStudentRelation::deleteStudentClassRelation($member->userid);
                    }
                }
                $parents = array();
                $roles = isset($_POST['role']) ? $_POST['role'] : array();
                //去重判断
                for ($i = 0; $i < count($mobilephones); $i++) {
                    $mobile = $mobilephones[$i];
                    $isExists = Member::getUniqueMember($mobile);
                    //家长已存在，建立对应关系
                    if ($isExists) {
                        //换算身份
                        $transIdentity = Member::transIdentity(4, $isExists->identity);
                        $isExists->identity = $transIdentity;
                        $isExists->state = 1;
                        $isExists->save();
                        $parents[] = array('userid' => $isExists->userid, 'role' => $roles[$i]);
                    } else {
                        $userid = UCQuery::makeMaxId(0, true);
                        $member = new Member;
                        $member->userid = $userid;
                        $member->state = 1;
                        $member->name = '用户' . substr($mobile, -4); //$_POST['Student']['name'] . '的' . $roles[$i];
                        $member->identity = Constant::FAMILY_IDENTITY; //家长标志;
                        $member->mobilephone = $mobile;
                        $member->account = "p" . $userid; //;
                        $member->issendpwd = 1;
                        $password = MainHelper::generate_code(6);
                        $member->pwd = MainHelper::encryPassword($password);
                        if ($member->save()) {
                            $parents[] = array('userid' => $userid, 'role' => $roles[$i]);
                            $msgArr[] = array('mobile' => $mobile, 'password' => $password);
                        }
                    }
                }
                foreach ($parents as $vv => $val) {
                    if (!Guardian::getRelationByChildGuardian($val['userid'], $suid)) {
                        $guardian = new Guardian;
                        $guardian->child = $suid;
                        $guardian->guardian = $val['userid'];
                        $guardian->role = $val['role'] ? $val['role'] : '家长';
                        if ($vv == 0) {
                            $guardian->main = 1;
                        }
                        $guardian->save();
                    }
                }

                $classIds = isset($_POST['classId']) ? array_unique($_POST['classId']) : array();
                foreach ($classIds as $class) {
                    $classRelation = new ClassStudentRelation;
                    $classRelation->cid = $class;
                    $classRelation->state = 1;
                    $classRelation->student = $suid;
                    $classRelation->save();
                }

                $transaction->commit();

                foreach ($msgArr as $val) {
                    UCQuery::sendMobilePasswordMsg($val['mobile'], $val['password']);
                }
                Yii::app()->msg->postMsg('success', '创建学生成功');
                $this->redirect(array('index'));
            } catch (Exception $e) {
                error_log($e->getMessage());
                $transaction->rollback();
                Yii::app()->msg->postMsg('success', '创建学生失败');
                $this->redirect(array('index'));
            }
        }
        if ($sid) {
            $classArr = School::getSchoolClassArr($sid);
        }
        $this->render('create', array('schools' => $schoolArr, 'sid' => $sid, 'classs' => $classArr, 'cid' => $cid));
    }

    public function actionUpdate($id)
    {
        if (isset($_POST['Student'])) {
            $msgArr = array();
            $transaction = Yii::app()->db_member->beginTransaction();
            try {
                $member = Member::model()->loadByPk($id);
                $suid = $member->userid;
                $member->name = $_POST['Student']['name'];
                $member->state = 1;
                $member->save();
                //创建家长
                $mobilephones = isset($_POST['mobilephone']) ? array_unique($_POST['mobilephone']) : array();
                $roles = isset($_POST['role']) ? $_POST['role'] : array();
                $oldGuardian = Guardian::getDeleteStudentGrardianRelation($suid); //删除原来的学生家长关系
                $oldGuardianArr = array();
                $oldMember = array();
                $oldMobile = array(); //保存旧的监护人
                foreach ($oldGuardian as $val) {
                    $oldmemberinfo = Member::model()->findByPk($val->guardian);
                    if ($oldmemberinfo) {
                        $oldMobile[$oldmemberinfo->mobilephone] = $val;
                    }
                }
                $deleteGuardianIds = array();
                foreach ($oldMobile as $k => $val) {
                    if (!in_array($k, $mobilephones)) { //如果旧的监护人手机不存在，现在的监护人手机列表，则要删除
                        $val->deleteMark();
                    }
                }


                for ($i = 0; $i < count($mobilephones); $i++) {
                    $mobile = $mobilephones[$i];
                    $isExists = Member::getUniqueMember($mobile);
                    //家长已存在，加对应关系
                    if ($isExists) {
                        $transIdentity = Member::transIdentity(4, $isExists->identity);
                        $isExists->identity = $transIdentity;
                        $isExists->state = 1;
                        $isExists->save();
                        $guardian = new Guardian;
                        $guardian->child = $suid;
                        $guardian->guardian = $isExists->userid;
                        $guardian->role = $roles[$i] ? $roles[$i] : '家长';
                        if ($i == 0) {
                            $guardian->main = 1;
                        }
                        $isGuardian = Guardian::getRelationByChildGuardian($isExists->userid, $suid);
                        if (!$isGuardian) {
                            $guardian->save();
                        } else {
                            $isGuardian->role = $roles[$i] ? $roles[$i] : '家长';
                            $isGuardian->save();
                        }

                    } else {
                        //不存在,建立家长
                        $userid = UCQuery::makeMaxId(0, true);
                        $parent = new Member;
                        $parent->state = 1;
                        $parent->userid = $userid;
                        $parent->name = '用户' . substr($mobile, -4); //$_POST['Student']['name'] . '的' . $roles[$i];
                        $parent->identity = Constant::FAMILY_IDENTITY; //学生;
                        $parent->mobilephone = $mobile;
                        $parent->account = "p" . $userid; //默认家长;
                        $parent->issendpwd = 1;
                        $password = MainHelper::generate_code(6);
                        $parent->pwd = MainHelper::encryPassword($password);
                        if ($parent->save()) {
                            //创建学生家长对应关系
                            $msgArr[] = array('mobile' => $mobile, 'password' => $password);
                            $guardian = new Guardian;
                            $guardian->child = $suid;
                            $guardian->guardian = $userid;
                            $guardian->role = $roles[$i] ? $roles[$i] : '家长';
                            if ($i == 0) {
                                $guardian->main = 1;
                            }
                            $guardian->save();
                        }
                    }
                }
                //  Guardian::deleteStudentGrardianRelations($oldGuardianArr);
                //删除学生班级关系
                // ClassStudentRelation::deleteStudentClassRelation($member->userid);
                $oldClassRelations = ClassStudentRelation::getStudentClass($member->userid);
                $oldCids = array();
                foreach ($oldClassRelations as $oldClassRelation) { //找出原先的班级cid
                    $oldCids[] = $oldClassRelation->cid;
                }
                $cids = isset($_POST['cid']) ? array_unique($_POST['cid']) : array();
                //要添加的班级id
                $addClasss = array_diff($cids, $oldCids);

                //要删除的班级
                $deleteCids = array_diff($oldCids, $cids);


                foreach ($addClasss as $k => $v) {
                    $studentClass = new ClassStudentRelation;
                    $studentClass->cid = $v;
                    $studentClass->student = $suid;
                    $studentClass->state = 1;
                    $studentClass->save();
                }
                foreach ($deleteCids as $deleteCid) {
                    $deleteRelation = ClassStudentRelation::getRelationByCidStudent($deleteCid, $member->userid);
                    if ($deleteRelation) {
                        $deleteRelation->deleteMark();
                    }
                }
                $transaction->commit();

                foreach ($msgArr as $val) {
                    UCQuery::sendMobilePasswordMsg($val['mobile'], $val['password']);
                }
                Yii::app()->msg->postMsg('success', '修改学生成功');
                $this->redirect(array('index'));
            } catch (Exception $e) {
                $transaction->rollback();
                // error_log($e->getMessage());
                Yii::app()->msg->postMsg('success', '修改学生失败');
                $this->redirect(array('index'));
            }
        }
        // $schoolArr = School::getDataArr(true); //所有学校,带首字母用于下拉
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);

        $member_model = Member::model()->loadByPk($id);
        $guardians = $member_model->guardians;
        foreach ($guardians as $k => $val) {
            if ($val->deleted == 1) {
                unset($guardians[$k]);
            }
        }
        $classlist = ClassStudentRelation::getStudentClass($member_model->userid);
        $cids = array();
        //保存每个学校的班级数组，用于select
        foreach ($classlist as $kk => $c) {
            $cids[$c->c->sid] = School::getSchoolClassArr($c->c->sid);
        }
        $this->render('update', array('model' => $member_model, 'schools' => $schoolArr, 'guardians' => $guardians, 'classs' => $classlist, 'cids' => $cids));
    }

    /*
     * 重置家长密码
     * 传的是家长id
     */
    public function actionInitpwd()
    {
        $ids = Yii::app()->request->getParam('ids', '');
        $userid = (int)Yii::app()->request->getParam('userid');
        $msg = 'error';
        if ($ids) { //传多个学生id重置，家长密码，需要循环学生，找出学生家长一一重置
            $idArr = explode(",", $ids);
            $num = 0;
            foreach ($idArr as $id) {
                if ((int)$id) {
                    $guardians = Guardian::getChildGuardian($id);
                    foreach ($guardians as $member) {
                        if ($member && $member->deleted == 0) {
                            $password = MainHelper::generate_code(6);
                            $member->pwd = MainHelper::encryPassword($password);
                            $member->issendpwd = 1;
                            if ($member->save()) {
                                $num++;
                                UCQuery::sendMobilePasswordMsg($member->mobilephone, $password);
                            }
                        }
                    }
                }
                $student = Member::model()->findByPk($id);
                if ($student->deleted == 0) {
                    $student->issendpwd = 1;
                    $student->save();
                }
            }
            if ($num > 0) $msg = "success";
            die(json_encode(array('msg' => $msg)));
        }
        //传单个家长id重置密码;
        if ($userid) {
            $member = Member::model()->findByPk($userid);
            if ($member) {
                $password = MainHelper::generate_code(6);
                $member->pwd = MainHelper::encryPassword($password);
                $member->issendpwd = 1;
                if ($member->save()) {
                    UCQuery::sendMobilePasswordMsg($member->mobilephone, $password);
                    $msg = 'success';
                }
            }
            die(json_encode(array('msg' => $msg, 'password' => isset($password) ? $password : "")));
        }

    }


    public function actionDelete()
    {
        $ids = Yii::app()->request->getParam("ids", '');
        $list = Yii::app()->request->getParam("list", 0);

        if ($ids) {
            $transaction = Yii::app()->db_member->beginTransaction();
            try {

                $idArr = explode(",", $ids);
                $num = 0;
                foreach ($idArr as $v) {
                    if ((int)$v) {
                        $success = Member::deleteStudent($v);
                        if ($success) {
                            $num++;
                        }
                    }
                }

                $transaction->commit();
                if ($num > 0) {
                    Yii::app()->msg->postMsg('success', '删除学生成功');
                } else {
                    Yii::app()->msg->postMsg('error', '删除学生失败');
                }

                if ($list) {
                    $this->redirect(Yii::app()->createUrl("student/index"));
                } else {
                    $this->redirect($this->previousurl);
                }

            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->msg->postMsg('error', '删除学生失败');
                if ($list) {
                    $this->redirect(Yii::app()->createUrl("student/index"));
                } else {
                    $this->redirect($this->previousurl);
                }
            }
        } else {
            Yii::app()->msg->postMsg('success', '参数传入有错误,请重试');
            $this->redirect($this->previousurl);
        }
    }

    public function actionImportStudent()
    {
        if (isset($_FILES['batchfile'])) {
            $schoolid = Yii::app()->request->getParam("schoolid", 0);
            $uid = Yii::app()->user->id;
            if (empty($uid) || empty($schoolid)) {
                die(json_encode(array('status' => '2', 'msg' => '上传失败,参数有误'), JSON_UNESCAPED_UNICODE));
            }
            $errNum = array(); //excel不符合条件的行数,
            $t1 = array();
            $t2 = array();
            $t3 = array();
            $schoolClass = School::getSchoolClass($schoolid);
            $schoolClassArr = array();
            $allclass = array();
            foreach ($schoolClass as $val) {
                $schoolClassArr[] = $val->name;
                $allclass[$val->name] = $val;
            }
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
            $mobileArr = array();
            $RegExp = '/^1\d{10}$/';
            $studentnotmobile = 0;
            $notclass = 0;
            $validnum = 0; //符合条件数目;
            $novalidnum = 0; //不符合条件数目
            for ($row = 2; $row <= $max; $row++) {
                $name = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue());
                $mobile = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue());
                $classname = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue());
                if (empty($name)) {
                    $t3[] = $row;
                }
                if (!preg_match($RegExp, $mobile)) {
                    $studentnotmobile++; //手机不符合
                    $t2[] = $row;
                }
                if (!$classname || !in_array($classname, $schoolClassArr)) {
                    $notclass++; //班级不存在
                    $t1[] = $row;
                }
                if ($name && $classname && $mobile && preg_match($RegExp, $mobile) && in_array($classname, $schoolClassArr)) {
                    array_push($dataArr, array('name' => $name, 'mobile' => $mobile, 'classname' => $classname,
                        'cid' => isset($allclass[$classname]) ? $allclass[$classname]->cid : 0));
                    $validnum++;
                } else {
                    $novalidnum++;
                    $errNum[] = $row;
                }
            }
            $cache = Yii::app()->cache;
            $cache->set("schoolid" . $schoolid . "studentupload" . $uid, $dataArr);
            $cache->set("studentnotmobile", $studentnotmobile);
            spl_autoload_register(array('YiiBase', 'autoload'));
            $errNums = !empty($errNum) ? implode(",", array_unique($errNum)) : ''; //哪些行错误
            die(json_encode(array('status' => '1', 'msg' => '上传成功', 't1' => $t1, 't2' => $t2, 't3' => $t3, 'filename' => $_FILES['batchfile']['name'], 'studentnotmobile' => $studentnotmobile, 'notclass' => $notclass, 'validnum' => $validnum, 'novalidnum' => $novalidnum), JSON_UNESCAPED_UNICODE));

        }

        // $schoolArr = School::getDataArr(true); //所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $this->render("importstudent", array('schools' => $schoolArr));
    }


    /*
    * 保存学生上传的数据
    */
    public function actionSaveexcel()
    {
        set_time_limit(0);
        $schoolid = isset($_POST['schoolid']) ? intval($_POST['schoolid']) : 0;
        $uid = Yii::app()->user->id;
        $cache = Yii::app()->cache;
        $allData = $cache->get("schoolid" . $schoolid . "studentupload" . $uid);
        $t1 = microtime(true);
        //error_log("b:" . $t1);
        Yii::log("b:" . $t1,CLogger::LEVEL_ERROR);
        $studentnotvalidmobile = $cache->get("studentnotmobile");
        $issendpwd = isset($_POST['issendpwd']) ? (int)$_POST['issendpwd'] : 0;
        $smscontent = isset($_POST['smscontent']) ? $_POST['smscontent'] : '';
        $isEditContent = true; //是否修改过短信内容
        if ($smscontent == "你好！感谢您使用".SITE_NAME."（".SITE_URL."）,平台有家校沟通丶成绩管理等功能。您的账号:[xxxxxxxxxxx]，密码:[xxxxxx]。客服电话:4001013838，工作时间:08:00-20:00") {
            $isEditContent = false;
        }
        $successNum = 0;
        $msgArr = array();
        $notclass = 0;
        $allData = empty($allData) ? array() : $allData;
        $class_relation = array();
        $class_relation_student = array();
        $class_unique = array();
        $phoneArr=array();
        foreach ($allData as $val) {
            if (!in_array($val['classname'], $class_unique)) {
                $class_unique[] = $val['classname'];
                $class_object = MClass::model()->findByPk(intval($val['cid']));
                if ($class_object && $class_object->deleted == 0) {
                    $class_relation[$val['classname']] = $class_object;
                    //获取这个班级的学生名--id键值数组
                    $classstudent_temp=ClassStudentRelation::getClassStudentsReturnArr($val['cid']);
                    $class_relation_student[$val['cid']]=$classstudent_temp?$classstudent_temp:array();

                }
            }
            $phoneArr[]=$val['mobile'];
        }


        //找出这批手机号在数据库存在的记录
        $allUser=Member::getUseridByMobileArr($phoneArr);

        if (is_array($allData)) {
            $transaction = Yii::app()->db_member->beginTransaction();
           // UCQuery::execute("start TRANSACTION;");
            try {

                foreach ($allData as $val) {
                    $name = $val['name']; //学生姓名
                    $mobile = $val['mobile']; //监护人手机;
                    $classname = $val['classname'];
                    $cid = $val['cid'];
                    //判断班级是否存在
                    $class = isset($class_relation[$classname]) ? $class_relation[$classname] : null;
                    if (!$class) {
                        $notclass++;
                        continue;
                    }

                    //检验手机号
                    if ($mobile) {
                        $member = isset($allUser[$mobile])?$allUser[$mobile]:null;
                        if ($member) { //家长存在
                           // $childs = Guardian::getChilds($member->userid);
                            //判断学生名字是否一致,是否在这个监护人的孩子中
                            $child = Guardian::checkGuardianChildByName($member->userid,$name);
                            if ($child) { //小孩存在监护人关系中
                                $isInclass = ClassStudentRelation::model()->findByAttributes(array("cid" => $class->cid, 'student' => $child->child, 'deleted' => 0));
                                if ($isInclass) {
                                } else {
                                    $isInclass = new ClassStudentRelation();
                                    $isInclass->cid = $class->cid;
                                    $isInclass->student = $child->child;
                                    $isInclass->deleted = 0;
                                    $isInclass->state = 1;
                                   // $isInclass->save();
                                    ClassStudentRelation::insertClassStudentRelation($isInclass,$class,$name);
                                    $class_relation_student[$cid][$name]= $isInclass->student;
                                }
                                $successNum++;
                            } else { //不在这个监护人关系中,看在不在这个班级中
                                $nameuser = array_key_exists($name,$class_relation_student[$cid])?$class_relation_student[$cid][$name]:'';
                                if ($nameuser) { //已在班级中
                                    //家长跟学生关系
                                    $isExists = Guardian::getRelationByChildGuardian($member->userid, $nameuser);
                                    if (!$isExists) {
                                        $guardian = new Guardian;
                                        $guardian->child = $nameuser;
                                        $guardian->guardian = $member->userid;
                                        $guardian->role = '家长';
                                        $guardian->main = 1;
                                        $guardian->save();
                                        $successNum++;
                                    }
                                } else {
                                    //新建学生
                                    $suid = UCQuery::makeMaxId(0, true);
                                    $user = new Member;
                                    $user->userid = $suid;
                                    $user->name = $name;
                                    $user->identity = Constant::STUDENT_IDENTITY; //学生标志;
                                    $user->account = "s" . $suid;
                                    $password = MainHelper::generate_code(6);
                                    $user->pwd = MainHelper::encryPassword("123456");
                                    $user->state = 1;
                                    $user->issendpwd = (int)$issendpwd;
                                    $user->save();

                                    $isInclass = new ClassStudentRelation();
                                    $isInclass->cid = $class->cid;
                                    $isInclass->student = $suid;
                                    $isInclass->deleted = 0;
                                    $isInclass->state = 1;
                                    ClassStudentRelation::insertClassStudentRelation($isInclass,$class,$name);
                                   // $isInclass->save();

                                    $class_relation_student[$cid][$name]= $isInclass->student;

                                    $guardian = new Guardian;
                                    $guardian->child = $suid;
                                    $guardian->guardian = $member->userid;
                                    $guardian->role = '家长';
                                    $guardian->main =  1;
                                    $guardian->save();
                                    $successNum++;
                                }
                            }
                        } else {
                            $nameuser = array_key_exists($name,$class_relation_student[$cid])?$class_relation_student[$cid][$name]:'';

                            if ($nameuser) {
                                //如果导入在学生之前就存在
                                //新建 学生
                                $parentid = UCQuery::makeMaxId(0, true);
                                $parent = new Member;
                                $parent->state = 1;
                                $parent->userid = $parentid;
                                $parent->name = '用户' . substr($mobile, -4); //$_POST['Student']['name'] . '的' . $roles[$i];
                                $parent->identity = Constant::FAMILY_IDENTITY; //学生;
                                $parent->mobilephone = $mobile;
                                $parent->account = "p" . $parentid; //默认家长;
                                $parent->issendpwd = (int)$issendpwd;
                                $password = MainHelper::generate_code(6);
                                $parent->pwd = MainHelper::encryPassword($password);
                                if ($parent->save()) {
                                    $allUser[$mobile]=$parent;
                                   // $msgArr[] = array('mobile' => $mobile, 'password' => $password);
                                   if($issendpwd){
                                       $this->sendPwd($smscontent,$mobile,$password,$isEditContent);
                                   }

                                }

                                //家长跟学生关系
                                $guardian = new Guardian;
                                $guardian->child = $nameuser;
                                $guardian->guardian = $parentid;
                                $guardian->role = '家长';
                                $guardian->main = count(Guardian::countChildGuardian($nameuser)) ? 0 : 1;
                                $guardian->save();
                                $successNum++;

                            } else {
                                //导入学生之前不存在
                                //新建学生
                                $studentid = UCQuery::makeMaxId(0, true);
                                $member = new Member;
                                $member->userid = $studentid;
                                $member->name = $name;
                                $member->identity = Constant::STUDENT_IDENTITY; //学生标志;
                                $member->account = "s" . $studentid;
                                $member->pwd = MainHelper::encryPassword("123456");
                                $member->state = 1;
                                $member->issendpwd = (int)$issendpwd;
                                $member->save();

                                //新建 家长
                                $parentid = UCQuery::makeMaxId(0, true);
                                $parent = new Member;
                                $parent->state = 1;
                                $parent->userid = $parentid;
                                $parent->name = '用户' . substr($mobile, -4); //$_POST['Student']['name'] . '的' . $roles[$i];
                                $parent->identity = Constant::FAMILY_IDENTITY; //学生;
                                $parent->mobilephone = $mobile;
                                $parent->account = "p" . $parentid; //默认家长;
                                $password = MainHelper::generate_code(6);
                                $parent->pwd = MainHelper::encryPassword($password);
                                $parent->issendpwd = (int)$issendpwd;

                                if ($parent->save()) {
                                    $allUser[$mobile]=$parent;
                                   // $msgArr[] = array('mobile' => $mobile, 'password' => $password);
                                    if($issendpwd){
                                        $this->sendPwd($smscontent,$mobile,$password,$isEditContent);
                                    }
                                }

                                //班级学生关系
                                $isInclass = new ClassStudentRelation();
                                $isInclass->cid = $class->cid;
                                $isInclass->student = $studentid;
                                $isInclass->deleted = 0;
                                $isInclass->state = 1;
                                //$isInclass->save();
                                ClassStudentRelation::insertClassStudentRelation($isInclass,$class,$name);
                                $class_relation_student[$cid][$name]= $isInclass->student;

                                $guardian = new Guardian;
                                $guardian->child = $studentid;
                                $guardian->guardian = $parentid;
                                $guardian->role = '家长';
                                $guardian->main = 1;
                                $guardian->save();
                                $successNum++;
                            }
                        }
                    }


                }//for结束

               // UCQuery::execute("commit;");
                //一次统计完班级人数，避免每次增加一个后，统计更新一次
                foreach($class_relation_student as $classid=>$v){
                    $num=ClassStudentRelation::countClassStudentNum($classid);
                    $tempclass=MClass::model()->findByPk($classid);
                    if($tempclass){
                        $tempclass->total=$num;
                        $tempclass->save();
                    }

                }
                $transaction->commit();
            } catch (Exception $e) {
                  error_log("导入学生出错了:" . $e->getMessage());
                //UCQuery::execute("rollback;");
                $transaction->rollback();

            }

        }

        $t2 = microtime(true);
       // Yii::log("end import:" . $t2,CLogger::LEVEL_ERROR);
        Yii::log("import student:".+$successNum."- num,spend time:" . ($t2-$t1),CLogger::LEVEL_ERROR);
        /*
        if ($issendpwd) {
            $smscontent = isset($_POST['smscontent']) ? $_POST['smscontent'] : '';
            $isEditContent = true; //是否修改过短信内容
            if ($smscontent == "你好！感谢您使用".SITE_NAME.."（".SITE_URL."）,平台有家校沟通丶成绩管理等功能，我们的手机客户端同时推出，点击（".SITE_APP_DOWNLOAD_SHORT_URL."） 即可下载安装。您的账号:[xxxxxxxxxxx]，密码:[xxxxxx]。客服电话:4001013838，工作时间:08:00-20:00") {
                $isEditContent = false;
            }
            if (!$isEditContent) {
                foreach ($msgArr as $val) {
                    UCQuery::sendMobilePasswordMsg($val['mobile'], $val['password']);
                }
            } else {
                $isxxxx = preg_match('/\[x{11}\]/', $smscontent) && preg_match('/\[x{6}\]/', $smscontent);
                foreach ($msgArr as $val) {
                    if ($isxxxx) {
                        $str = $smscontent;
                        $str = str_replace("[xxxxxxxxxxx]", $val['mobile'], $str);
                        $code = str_replace("[xxxxxx]", $val['password'], $str);
                        UCQuery::sendMobileMsg($val['mobile'], $code);
                    } else {
                        UCQuery::sendMobilePasswordMsg($val['mobile'], $val['password']);
                    }
                }
            }
        }
        */
        $t3 = microtime(true);
        // var_dump("end:" . $t3);
        // var_dump("host." . ($t3 - $t1));D('aa');
        Yii::app()->msg->postMsg('success', '成功导入' . $successNum . '条学生数据');

        $url = Yii::app()->createUrl('student/index') . '?Student[sid]=' . $schoolid . "&Student[cid]=&Student[name]=&Student[mobilephone]=";
        $this->redirect($url);
    }

    private function sendPwd($content,$mobile,$password,$isEditContent=true){
        if (!$isEditContent) {
                UCQuery::sendMobilePasswordMsg($mobile, $$password);
        }else{
            $isxxxx = preg_match('/\[x{11}\]/', $content) && preg_match('/\[x{6}\]/', $content);
            if ($isxxxx) {
                $str = $content;
                $str = str_replace("[xxxxxxxxxxx]", $mobile, $str);
                $code = str_replace("[xxxxxx]", $password, $str);
                UCQuery::sendMobileMsg($mobile, $code);
            } else {
                UCQuery::sendMobilePasswordMsg($mobile, $password);
            }
        }
    }

}