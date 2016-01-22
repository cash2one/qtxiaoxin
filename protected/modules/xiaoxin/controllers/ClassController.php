<?php

class ClassController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            // 'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function init(){
        $identity = Yii::app()->user->getIdentity(); //获取是老师还是家长登录
        if($identity==Constant::FAMILY_IDENTITY){
           // $this->redirect(Yii::app()->createUrl("xiaoxin/default/index"));
          //  exit();
        }
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('scheck', 'tcheck'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'view', 'teachers', 'pinvite', 'downloadxls', 'item', 'students', 'sinvite', 'apply', 'deleted', 'supload', 'update', 'invites', 'create', 'subjects', 'removeteacher', 'schoolgrade', 'depart',
                    'master', 'simport','Isexist', 'giveupinvite', 'accept', 'refuse', 'removestudent', 'texport', 'sexport', 'sendpwd', 'generatecode', 'updatestudent', 'tupload', 'timport', 'anewpinvite', 'scfinish', 'scimport', 'scupload'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * 我的班级-班级列表
     * panrj 2014-08-09
     */
    public function actionIndex()
    {
        $teacher = Yii::app()->user->getInstance();
        $uid = Yii::app()->user->id;
        $class_std = array();
        $class_intr = array();
        $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
        $allcids=array();
        foreach ($schoolList as $k => $val) {
            $classSysList = ClassTeacherRelation::getTeacherClassRelation($uid, $val['sid']); //系统班
            $myclassIds = array();
            if (is_array($classSysList)) {
                foreach ($classSysList as $v) {
                    if ($v->c) {
                        $class = $v->c;
                        if ($class->type == 0) {
                            if (!in_array($class->cid, $myclassIds)) {
                                $myclassIds[] = $class->cid;
                                $allcids[]=$class->cid;
                                $studentNum=ClassStudentRelation::countClassStudentNum($class->cid);
                                $schoolList[$k]['sys'][] = array('cid' => $class->cid, 'name' => $class->name, 'master' => $class->master, 'total' => $studentNum, 'type' => $class->type,
                                    'sid' => $class->sid, 'sname' => $class->s ? $class->s->name : '', 'seqno' => $class->seqno, 'pingyin' => $class->pingyin, 'teachers_num' => $class->teachers);
                            }
                        } else {
                            if (!in_array($class->cid, $myclassIds)) {
                                $myclassIds[] = $class->cid;
                                $allcids[]=$class->cid;
                                $studentNum=ClassStudentRelation::countClassStudentNum($class->cid);
                                $schoolList[$k]['ins'][] = array('cid' => $class->cid, 'name' => $class->name, 'master' => $class->master, 'total' => $studentNum, 'type' => $class->type,
                                    'sid' => $class->sid, 'sname' => $class->s ? $class->s->name : '', 'seqno' => $class->seqno, 'pingyin' => $class->pingyin, 'teachers_num' => $class->teachers);
                            }
                        }
                    }
                }
            }

        }
        //统计这些的老师数量　
        $teacherNumArr=ClassTeacherRelation::countClassTeacherNum(implode(",",$allcids));
        foreach ($schoolList as $k => $val) {
            if (!isset($schoolList[$k]['sys']) || !is_array($schoolList[$k]['sys'])) {
                $schoolList[$k]['sys'] = array();
            }
            if (isset($schoolList[$k]['ins']) && is_array($schoolList[$k]['ins'])) {
                foreach ($schoolList[$k]['ins'] as $ins) {
                    $schoolList[$k]['sys'][] = $ins;
                }
            }
        }

        $this->render('index', array(
                'teacher' => $teacher,
                'class_std' => $class_std,
                'class_intr' => $class_intr,
                'schools' => $schoolList,
                'teacherNumArr'=>$teacherNumArr
            )
        );
    }

    /**
     * 我的班级-班级首页（详情）
     * panrj 2014-08-09
     */
    public function actionView($id)
    {
        $class = UCQuery::loadClass($id);
        $school = UCQuery::loadSchool((int)$class->sid);
        $age = MainHelper::getGradeAge((int)$class->year);
        $grade = Grade::getGradeInfo(array('stid' => $class->stid, 'age' => $age));

        // $grade = UCQuery::getClassGrade($class);
        $uid=Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($uid);
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $master = UCQuery::loadUser($class->master);
        $this->render('view', array(
                'class' => $class,
                'school' => $school,
                'grade' => $grade,
                'master' => $master
            )
        );
    }

    /**
     * 我的班级-成员-老师
     * panrj 2014-08-09
     */
    public function actionTeachers($id)
    {
        $page = (int)Yii::app()->request->getParam("page", 1);
        $class = MClass::model()->findByPk($id);
        if(!$class){
            Yii::app()->msg->postMsg('error', '班级不存在');
            $this->redirect(array("class/index"));
            exit();
        }
        $userid=Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid); //过滤那种在浏览器输入id情况，修改别的老师的数据
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $userinfo=Member::model()->findByPk($userid);
        $teachers_old = ClassTeacherRelation::getClassTeacher($id);
        $teachers = array();
        $needSendpwdNum=0;
        foreach ($teachers_old as $val) {
            $client = UserOnline::getOnLineByUserId($val->teacher);
            $web = $val->teacher0->lastlogintime ? 1 : 0;
            if(!$client&&!$web){
                $needSendpwdNum++;
            }
            $teachers[] = array('userid' => $val->teacher0->userid, 'name' => $val->teacher0->name, 'mobilephone' => $val->teacher0->mobilephone,
                'teacher' => $val->teacher, 'sid' => $val->sid, 'subject' => $val->subject, 'id' => $val->id, 'creationtime' => $val->creationtime, 'cid' => $val->cid,
                'state' => $val->state, 'client' => $client, 'web' => $web);
        }
        $subjects = Subject::getSubjectsBySchoolids($class->sid);
        $subjectList = array();
        foreach ($subjects as $k => $val) {
            $subjectList[] = array('sid' => $k, 'name' => $val);
        }
        $temp = array(); //array('teacherid1'=>array1,'teacherid2'=>array2,...);将数组转换成该格式
        foreach ($teachers as $k => $val) {
            if (!array_key_exists($val['userid'], $temp)) {
                $temp[$val['userid']] = $val;
            } else {
                //将重复的老师但教不同科目的合并为一个数组，将科目整合到一起用','分隔开
                if (!empty($val['sid'])) { //科目不为空
                    $temp[$val['userid']]['sid'] = !empty($val['sid']) ? ($temp[$val['userid']]['sid'] ? ($temp[$val['userid']]['sid'] . ",") : '' . $val['sid']) : ($temp[$val['userid']]['sid']);
                    $temp[$val['userid']]['subject'] = !empty($val['subject']) ? ($temp[$val['userid']]['subject'] ? ($temp[$val['userid']]['subject'] . "," . $val['subject']) : $val['subject']) : ($temp[$val['userid']]['subject'] . "");
                } else {
                    $temp[$val['userid']]['subject'] = $temp[$val['userid']]['subject'] . "";
                }
            }
        }
        $data = UCQuery::PageData($temp, $page);
        $this->render('teachers', array('data' => $data, 'class' => $class,'userinfo'=>$userinfo, 'subjects' => $subjectList,'needSendpwdNum'=>$needSendpwdNum));
    }

    /**
     * 我的班级-成员-老师-设置科目
     * panrj 2014-08-09
     */
    public function actionSubjects()
    {
        $cid = Yii::app()->request->getParam('cid');
        $sid = Yii::app()->request->getParam('sid');
        $tid = Yii::app()->request->getParam('tid');
        $sname = Yii::app()->request->getParam('sname');
        $uid = $tid = Yii::app()->request->getParam('uid');
        if ($cid && $sid && $tid) {
            $data = ClassTeacherRelation::getTeacherSubject($cid, $uid);
            $tmp = array();
            $tmp1 = array();
            $del = array();
            foreach ($data as $k => $v) {
                $tmp[] = $v->sid;
                $tmp1[$v->sid] = $v;

            }
            if (in_array($sid, $tmp)) {
                if (count($data) == 1) {
                    $data[0]->sid = null;
                    $data[0]->subject = '';
                    $success = $data[0]->save();
                } else {
                    $data = $tmp1[$sid];
                    $data->deleted = 1;
                    $success = $data->save();
                }
            } else {

                $data = new ClassTeacherRelation;
                $data->sid = $sid;
                $data->cid = $cid;
                $data->state = 1;
                $data->teacher = $uid;
                $data->subject = $sname;
                $success = $data->save();
            }

        } else {

        }

        if ($success) {
            Yii::app()->msg->postMsg('success', '操作成功');
        } else {
            Yii::app()->msg->postMsg('error', '操作失败');
        }
        $this->redirect(Yii::app()->createUrl('xiaoxin/class/teachers/' . $cid));
    }

    /**
     * 我的班级-成员-老师邀请（添加）
     * panrj 2014-08-09
     */
    public function actionPinvite($id)
    {
        $userid = Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid); //过滤那种在浏览器输入id情况，修改别的老师的数据
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $class = MClass::model()->findByPk($id);
        if (isset($_POST['Teacher'])) {
            $data = $_POST['Teacher'];
            $total = count($data['mobile']);
            $sid = $class->sid;
            $school = School::model()->findByPk($class->sid);
            $isregister = $school && $school->createtype == 1 ? 1 : 0;
            $version = (int)USER_BRANCH;
            $password = MainHelper::generate_code(6);
            $pwd = MainHelper::encryPassword($password);
            $new_teachers = array();
            $totalPeople =  ClassTeacherRelation::getClassTeacherNumByCid($class->cid) + ClassStudentRelation::countClassStudentNum($class->cid);
            $tmpTotal = $total + $totalPeople;
            if ($tmpTotal > Constant::CLASS_TOTAL) { //默认100
                $sub = (Constant::CLASS_TOTAL-$totalPeople) < 0 ? 0 : (Constant::CLASS_TOTAL-$totalPeople);
                Yii::app()->msg->postMsg('error', '班级成员上限100，目前还能导入'. $sub .'人');
                $this->redirect(Yii::app()->createUrl('xiaoxin/class/teachers/' . $id));
            }
            $uids = array();
            $num = 0;
            $userinfo = Yii::app()->user->getInstance();
            foreach ($data['mobile'] as $k => $v) {
                $name = $data['name'][$k];
                $result = MemberService::addTeacherByMobileAndName($v, trim($name), $id,'', $class);
                if (!isset($result['isexists'])) {
                    $num++;
                    $teacherinfo = Member::getUniqueMember($v);
                    if ($teacherinfo) {
//                        $data['receiver'] = '{"5":"' . $teacherinfo->userid . '"}';
//                        $data['noticeType'] = 6;
//                        $data['isSendsms'] = false;
//                        $data['data'] = '{"content":"' . $data['desc'] . '"}';
//                        $data['receiveTitle'] = 'xxx';
//                        $data['sendertitle'] = ($userinfo ? $userinfo->name : '') . '老师';
//                        $data['sid'] = $class->sid;
//                        $data['receivename'] = $name;
//                        NoticeQuery::publishNotice($data, Yii::app()->user->id, false);
                        ////2015-1-22，入班邀请去掉
                        if (isset($result['mobile']) && isset($result['password'])) {
                            $str = $teacherinfo->name . '老师' . "您好：我是" . ($class->s ? $class->s->name : '') . "的" . $userinfo->name . "老师，我刚在".SITE_NAME."创建了班级，并为你开通了登录账号：" . $v . "，初始密码：" . $result['password'] . "，大家都在上面交流了。下载地址：".SITE_APP_DOWNLOAD_SHORT_URL;
                            UCQuery::sendMobileMsg($v, $str);
                        }
                    }
                }

            }
            Yii::app()->msg->postMsg('success', '成功发送老师邀请' . $num . '名');
            $this->redirect(Yii::app()->createUrl('xiaoxin/class/teachers/' . $id));
        }
        $this->render('pinvite', array('class' => $class));
    }

    /**
     * 我的班级-成员-批量添加老师-上传
     * panrj 2014-08-09
     */
    public function actionTupload()
    {
        $id = Yii::app()->request->getParam('cid');
        $class = UCQuery::loadClass($id);
        $userid=Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid); //过滤那种在浏览器输入id情况，修改别的老师的数据
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $this->render('tupload', array('class' => $class));
    }

    public function actionTcheck()
    {
        $id = Yii::app()->request->getParam('cid');
        $userid = Yii::app()->request->getParam('uid');
        $userid = $userid ? $userid : Yii::app()->user->id;
        if (isset($_FILES['Filedata'])) {
            $uploadfile = $_FILES['Filedata']['tmp_name'];
            Yii::$enableIncludePath = false;
            Yii::import('application.extensions.PHPExcel', 1);
            require_once(PHPEXCEL_ROOT . 'PHPExcel/IOFactory.php');
            require_once(PHPEXCEL_ROOT . 'PHPExcel/Reader/Excel5.php');
            $objPHPExcel = new PHPExcel();
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($uploadfile);
            $objPHPExcel->setActiveSheetIndex(0);
            $ActiveSheet = $objPHPExcel->getActiveSheet();
            $max = $objPHPExcel->getActiveSheet()->getHighestRow();
            $dataArr = array();
            $uniqueArr=array();
            for ($row = 2; $row <= $max; $row++) {
                $name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
                $mobile = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
                $seque = $row - 1;
                if ($name && $mobile && CheckHelper::IsMobile($mobile)) {
                    if(!in_array($name.$mobile,$uniqueArr)){
                        $uniqueArr[]=$name.$mobile;
                        array_push($dataArr, array('name' => $name, 'mobile' => $mobile, 'error' => 0, 'seque' => $seque,'msg'=>''));
                    }else{
                        array_push($dataArr, array('name' => $name, 'mobile' => $mobile, 'error' => 1, 'seque' => $seque,'msg'=>'手机名字重复'));
                    }
                    
                } else {
                    array_push($dataArr, array('name' => $name, 'mobile' => $mobile, 'error' => 1, 'seque' => $seque,'msg'=>'手机或名字不正确'));
                }
            }
            $cache = Yii::app()->cache;
            $cache->set("class" . $id . "teacherupload" . $userid, MainHelper::multi_unique($dataArr));

            echo count($dataArr);
        } else {
            echo 0;
        }
    }

    /**
     * 我的班级-成员-批量添加老师-导入
     * zengp 2014-12-25
     */
    public function actionTimport($id)
    {
        $class = MClass::model()->findByPk($id);
        $ty = Yii::app()->request->getParam('ty');
        $desc = Yii::app()->request->getParam('desc');
        $userid = Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid); //过滤那种在浏览器输入id情况，修改别的老师的数据
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $cache = Yii::app()->cache;
        $userinfo=Member::model()->findByPk($userid);
        $Arr = $cache->get("class" . $id . "teacherupload" . $userid);
        if(!$Arr) $Arr=array();
        //$total = $Arr ? count($Arr) : 0;              
        $total = 0;
        foreach ($Arr as $sitem) {
            if ($sitem['error'] == 0)
                $total++;
        }
        $resultArr = array('status' => 0, 'msg' => '', 'cid' => $id, 'url' => '', 'nums' => 0);
        if (!count($Arr)) {
            Yii::app()->msg->postMsg('error', '未检测到有效数据，请先下载模版填写无误后上传！');
            // $this->redirect(Yii::app()->createUrl('xiaoxin/class/tupload/' . $id));
            $url = Yii::app()->createUrl('xiaoxin/class/tupload/' . $id);
            //$resultArr['msg'] = '未检测到有效数据，请先下载模版填写无误后上传！';
            $resultArr['url'] = $url;
            die(json_encode($resultArr));
        } else {
            if ($ty == 'import') {
                $totalPeople =  ClassTeacherRelation::getClassTeacherNumByCid($class->cid) + ClassStudentRelation::countClassStudentNum($class->cid);
                $tmpTotal = $total + $totalPeople;
                if ($tmpTotal > Constant::CLASS_TOTAL) { //默认100
                    $sub = (Constant::CLASS_TOTAL-$totalPeople) < 0 ? 0 : (Constant::CLASS_TOTAL-$totalPeople);
                    Yii::app()->msg->postMsg('error', '班级成员上限100，目前还能导入'. $sub .'人');
                    $url = Yii::app()->createUrl('xiaoxin/class/tupload/' . $id);
                    $resultArr['url'] = $url;
                    die(json_encode($resultArr));
                }

                $nameArr = array();
                $mobileArr = array();
                $num = 0;
                //$userinfo = Yii::app()->user->getInstance();
                $sendpwd = array();
                foreach ($Arr as $teacher) {
                    if ($teacher['error'] == 0) {
                        $result = MemberService::addTeacherByMobileAndName($teacher['mobile'], trim($teacher['name']), $id, $class);
                        if ($result) {
                            if (isset($result['mobile']) && isset($result['password'])) {
                                $sendpwd[] = array('mobile' => $result['mobile'], 'password' => $result['password'], 'name' => trim($teacher['name']));
                            }
                        }
                        $num += 1;
                    }
                }
                $cache->delete("class" . $id . "teacherupload" . $userid);
                $cache->set("class" . $id . "teacheruploadsendpwd" . $userid, $sendpwd);
                Yii::app()->msg->postMsg('success', '成功添加老师' . $num . '名');
                // $this->redirect(Yii::app()->createUrl('xiaoxin/class/teachers/' . $id));
                $resultArr['status'] = 1;
                $resultArr['tmp'] = $result;
                $resultArr['url'] = Yii::app()->createUrl('xiaoxin/class/teachers/' . $id);
                die(json_encode($resultArr));
            }
        }


        $this->render('timport', array('total' => $total, 'data' => $Arr, 'class' => $class,'userinfo'=>$userinfo));
    }

    /**
     * 我的班级-成员-老师-科目设置
     * panrj 2014-08-09
     */
    public function actionItem()
    {
        $this->renderPartial('item');
    }

    /**
     * 我的班级-成员-学生
     * panrj 2014-08-09
     */
    public function actionStudents($id)
    {
        $page = (int)Yii::app()->request->getParam("page", 1);
        $class = MClass::model()->findByPk($id);
        if(!$class){
            Yii::app()->msg->postMsg('error', '班级不存在');
            $this->redirect(array("class/index"));
            exit();
        }
        $userid=Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid);
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $userinfo=Member::model()->findByPk($userid);
        //  $sql = "CALL php_xiaoxin_getClassStudent('" . $class->cid . "')";
        $students = ClassStudentRelation::getClassStudents($id, 0);
        $arr = array();
        $needSendpwdNum=0;
        foreach ($students as $val) {
            $studentExt = StudentExt::model()->findByPk($val->student);
            //不要一开始处理完，等分完页再处理，加快显示
//            $guradian = Guardian::getChildGuardianRelation($val->student);
//            $data = array();
//            foreach ($guradian as $k => $v) {
//                $user = Member::model()->findByPk($v['guardian']);
//                $data[$k]['role'] = $v['role'];
//                $data[$k]['mobile'] = $user->mobilephone;
//                $data[$k]['client'] = UserOnline::getOnLineByUserId($v['guardian']) ? 1 : 0;
//                $data[$k]['web'] = $user->lastlogintime ? 1 : 0;
//                if(!$data[$k]['client']&&!$data[$k]['web']){
//                    $needSendpwdNum++;
//                }
//            }
            $arr[] = array( 'studentid' => $studentExt ? $studentExt->studentid : '', 'state' => $val->state, 'mobilephone' => $val->student0->mobilephone, 'cid' => $val->cid, 'id' => $val->id, 'userid' => $val->student, 'student' => $val->student, 'name' => $val->student0->name, 'creationtime' => $val->creationtime);
        }
        $tmp = MainHelper::array_subkey_sort($arr, 'studentid', 'asc');
        $data = UCQuery::PageData($tmp, $page);
        //只对当页处理图标等显示
        if(is_array($data['datas'])){
            foreach($data['datas'] as $kk=>$val){
                $guradian = Guardian::getChildGuardianRelation($val['userid']);
                $guardiandata = array();
                foreach ($guradian as $k => $v) {
                    $user = Member::model()->findByPk($v['guardian']);
                    $guardiandata[$k]['role'] = $v['role'];
                    $guardiandata[$k]['mobile'] = $user->mobilephone;
                    $guardiandata[$k]['client'] = UserOnline::getOnLineByUserId($v['guardian']) ? 1 : 0;
                    $guardiandata[$k]['web'] = $user->lastlogintime ? 1 : 0;
                    if(!$guardiandata[$k]['client']&&!$guardiandata[$k]['web']){
                        $needSendpwdNum++;
                    }
                }
                $data['datas'][$kk]['guradians']=$guardiandata;
            }
        }
        //D($data['datas']);
        $this->render('students', array('data' => $data, 'class' => $class,'userinfo'=>$userinfo,'needSendpwdNum'=>$needSendpwdNum));
    }

    /**
     * 我的班级-成员-学生邀请（添加学生）
     * panrj 2014-08-09
     */
    public function actionSinvite($id)
    {
        $userid = Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid);
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $class = MClass::model()->findByPk($id);
        if (isset($_POST['Student'])) {
            $data = $_POST['Student'];
            $total = count($data['mobile']);
            $mobiles = $data['mobile'];
            $names = $data['name'];
            $num = 0;
            $school = School::model()->findByPk($class->sid);
            $isregister = $school && $school->createtype == 1 ? 1 : 0;
            $userinfo = Yii::app()->user->getInstance();

            $totalPeople =ClassTeacherRelation::getClassTeacherNumByCid($class->cid) + ClassStudentRelation::countClassStudentNum($class->cid);
            $tmpTotal = $total + $totalPeople;
            if ($tmpTotal > Constant::CLASS_TOTAL) { //默认100
                $sub = (Constant::CLASS_TOTAL-$totalPeople) < 0 ? 0 : (Constant::CLASS_TOTAL-$totalPeople);
                Yii::app()->msg->postMsg('error', '班级成员上限100，目前还能导入'. $sub .'人');
                $this->redirect(Yii::app()->createUrl('xiaoxin/class/teachers/' . $id));
            }

            foreach ($mobiles as $km => $kv) {
                $result = MemberService::addStudentByMobileAndName($kv, trim($names[$km]), $id, "", $class);
                if ($result) {
                    $num++;
                    if (isset($result['mobile']) && isset($result['password'])) {
                        $str = trim($names[$km]) . '家长' . "您好：我是" . ($class->s ? $class->s->name : '') . "的" . $userinfo->name . "老师，我刚在".SITE_NAME."创建了班级，今后日常作业和学校通知都通过该平台发放。请您免费下载使用".SITE_NAME."接收信息、跟其他家长交流。系统为您配置的账号是：" . $kv . "，初始密码：" . $result['password'] . "。下载地址：".SITE_APP_DOWNLOAD_SHORT_URL;
                        UCQuery::sendMobileMsg($kv, $str);
                    }
                }
            }
            Yii::app()->msg->postMsg('success', '成功添加学生' . $num . '名');
            $this->redirect(Yii::app()->createUrl('xiaoxin/class/students/' . $id));
        }
        $this->render('sinvite', array('class' => $class));
    }

    /**
     * 我的班级-成员-待确认邀请
     * panrj 2014-08-09
     */
    public function actionApply()
    {
        $page = (int)Yii::app()->request->getParam("page", 1);
        $userid = Yii::app()->user->id;
        $sql = "CALL php_xiaoxin_GetClassTeacherRealtionByAttributes('0','0','" . $userid . "')";
        $teachers = UCQuery::queryAll($sql);
        $teachers = MainHelper::array_subkey_sort($teachers, 'creationtime');
        $data = UCQuery::PageData($teachers, $page);
        $this->render('apply', array('data' => $data));
    }

    /**
     * 我的班级-成员-已删除
     * panrj 2014-08-09
     */
    public function actionDeleted($id)
    {
        $page = (int)Yii::app()->request->getParam("page", 1);
        $class = UCQuery::loadClass($id);
        $sql = "CALL php_xiaoxin_GetClassTeacherRealtionDeleted('" . $id . "')";
        $teachers = UCQuery::queryAll($sql);
        $sql = "CALL php_xiaoxin_GetClassStudentRealtionDeleted('" . $id . "')";
        $students = UCQuery::queryAll($sql);
        // $data = UCQuery::PageData(array_merge($teachers,$students),$page);

        $dataArr = MainHelper::array_subkey_sort(array_merge($teachers, $students), 'pingyin');

        $data = UCQuery::PageData($dataArr, $page);


        $this->render('deleted', array('data' => $data, 'class' => $class));
    }

    public function actionSexport()
    {
        $ceils = array();
        $excel_file = '批量邀请学生模版';
        $excel_content = array(
            array(
                'sheet_name' => 'batch',
                'sheet_title' => array(
                    '姓名', '手机号'
                ),
                'ceils' => $ceils,
            ),
        );
        PHPExcelHelper::exportExcel($excel_content, $excel_file);
    }

    public function actionTexport()
    {
        $ceils = array();
        $excel_file = '批量邀请老师模版';
        $excel_content = array(
            array(
                'sheet_name' => 'batch',
                'sheet_title' => array(
                    '姓名', '手机号'
                ),
                'ceils' => $ceils,
            ),
        );
        PHPExcelHelper::exportExcel($excel_content, $excel_file);
    }

    /**
     * 我的班级-成员-批量添加学生-上传
     * panrj 2014-08-09
     */
    public function actionSupload()
    {
        $id = Yii::app()->request->getParam('cid');        
        $userid=Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid); //过滤那种在浏览器输入id情况，修改别的老师的数据
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $class = MClass::model()->findByPk($id);
        $this->render('supload', array('class' => $class));
    }

    public function actionScheck()
    {
        $id = Yii::app()->request->getParam('cid');
        $userid = Yii::app()->request->getParam('uid');
        $member = Member::model()->findByPk($userid);
        $userid = $userid ? $userid : Yii::app()->user->id;
        if (isset($_FILES['Filedata'])) {
            $uploadfile = $_FILES['Filedata']['tmp_name'];
            Yii::$enableIncludePath = false;
            Yii::import('application.extensions.PHPExcel', 1);
            require_once(PHPEXCEL_ROOT . 'PHPExcel/IOFactory.php');
            require_once(PHPEXCEL_ROOT . 'PHPExcel/Reader/Excel5.php');
            $objPHPExcel = new PHPExcel();
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($uploadfile);
            $objPHPExcel->setActiveSheetIndex(0);
            $ActiveSheet = $objPHPExcel->getActiveSheet();
            $max = $objPHPExcel->getActiveSheet()->getHighestRow();
            if ($member->createtype == 1) {
                $max = $max > 100 ? 101 : $max; //自注册班级成员不能超过100
            }
            $dataArr = array();
            $uniqueArr=array();
            for ($row = 2; $row <= $max; $row++) {
                $name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
                $mobile = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
                $seque = $row - 1;
                $name = mb_substr($name, 0, 10, 'utf-8');
                if ($name && $mobile && CheckHelper::IsMobile($mobile)) {
                    if(!in_array($name.$mobile,$uniqueArr)){
                        $uniqueArr[]=$name.$mobile;
                        array_push($dataArr, array('name' => $name, 'mobile' => $mobile, 'error' => 0, 'seque' => $seque,'msg'=>''));
                    }else{
                        array_push($dataArr, array('name' => $name, 'mobile' => $mobile, 'error' => 2, 'seque' => $seque,'msg'=>'姓名手机号重复'));
                    }
                } else {
                    array_push($dataArr, array('name' => $name, 'mobile' => $mobile, 'error' => 1, 'seque' => $seque,'msg'=>'电话或名字不正确'));
                }
            }
            $cache = Yii::app()->cache;
            $cache->set("class" . $id . "studentupload" . $userid, $dataArr);
            echo count($dataArr);
        } else {
            echo 0;
        }
    }

    /**
     * 我的班级-成员-批量添加学生-导入
     * panrj 2014-08-09
     */
    public function actionSimport($id)
    {
        $class = MClass::model()->findByPk($id);
        $ty = Yii::app()->request->getParam('ty');
        $desc = Yii::app()->request->getParam('desc');
        $userid = Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid); //过滤那种在浏览器输入id情况，修改别的老师的数据
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $userinfo=Member::model()->findByPk($userid);
        $cache = Yii::app()->cache;
        $Arr = $cache->get("class" . $id . "studentupload" . $userid);
        if(!$Arr) $Arr=array();
        //$total = $Arr ? count($Arr) : 0;    
        $total = 0;
        foreach ($Arr as $sitem) {
            if ($sitem['error'] == 0)
                $total++;
        }
        $resultArr = array('status' => 0, 'msg' => '', 'cid' => $id, 'url' => '', 'nums' => 0);
        if (!count($Arr)) {
            // Yii::app()->msg->postMsg('error', '未检测到有效数据，请先下载模版填写无误后上传！');
            // $this->redirect(Yii::app()->createUrl('xiaoxin/class/supload/' . $id));
            $url = Yii::app()->createUrl('xiaoxin/class/students/' . $id);
            $resultArr['msg'] = '未检测到有效数据，请先下载模版填写无误后上传！';
            $resultArr['url'] = $url;
            echo json_encode($resultArr);
            exit;
        } else {
            if ($ty == 'import') {
                $totalPeople =ClassTeacherRelation::getClassTeacherNumByCid($class->cid) + ClassStudentRelation::countClassStudentNum($class->cid);
                $tmpTotal = $total + $totalPeople;
                if ($tmpTotal > Constant::CLASS_TOTAL) { //默认100
                    $sub = (Constant::CLASS_TOTAL-$totalPeople) < 0 ? 0 : (Constant::CLASS_TOTAL-$totalPeople);
                    Yii::app()->msg->postMsg('error', '班级成员上限100，目前还能导入'. $sub .'人');
                    $url = Yii::app()->createUrl('xiaoxin/class/supload?cid=' . $id);
                    $resultArr['url'] = $url;
                    die(json_encode($resultArr));
                }

                $nameArr = array();
                $mobileArr = array();
                $num = 0;
                $userinfo = Yii::app()->user->getInstance();
                $sendpwd = array();
                //$transaction = Yii::app()->db_member->beginTransaction();
               // try{
                    foreach ($Arr as $student) {
                        if ($student['error'] == 0) {
                            if(!empty($student['mobile'])&&!empty($student['name'])){
                                $result = MemberService::addStudentByMobileAndName($student['mobile'], trim($student['name']), $id, "",$class);
                                if (isset($result['mobile']) && isset($result['password'])) {
                                    $sendpwd[] = array('mobile' => $result['mobile'], 'password' => $result['password'], 'name' => trim($student['name']));
                                }
                                $num += 1;
                            }

                        }
                    }
                  //  $transaction->commit();
               // }catch(Exception $e){
                //    $transaction->rollback();
               // }
                $cache->delete("class" . $id . "studentupload" . $userid);
                $cache->set("class" . $id . "studentuploadsendpwd" . $userid, $sendpwd);
                Yii::app()->msg->postMsg('success', '成功添加学生' . $num . '名');
                // $this->redirect(Yii::app()->createUrl('xiaoxin/class/students/' . $id));
                $resultArr['status'] = 1;
                $resultArr['url'] = Yii::app()->createUrl('xiaoxin/class/students/' . $id);
                echo json_encode($resultArr);
                exit;
            }
        }

        $this->render('simport', array('total' => $total, 'data' => $Arr, 'class' => $class,'userinfo'=>$userinfo));
    }

    /**
     * 我的班级-设置（修改）
     * panrj 2014-08-09
     */
    public function actionUpdate($id)
    {
        $class = MClass::model()->findByPk($id);
        if(!$class){
            Yii::app()->msg->postMsg('error', '班级不存在');
            $this->redirect(array("class/index"));
            exit();
        }
        $uid=Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($uid);
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        if (isset($_POST['Class'])) {
            $data = $_POST['Class'];
            $name = $data['name'];
            $info = $data['info'];
            $schoolid = $data['schoolid'];
            $className = isset($name)?$name:"";
            $schoolid = isset($schoolid)?$schoolid:"";
           // $isClass =  MClass:: getClassByName($className,$schoolid);
        //    if(!$isClass){
                $sql = "CALL php_xiaoxin_UpdateClassInfo('" . $class->cid . "','" . $name . "','" . $info . "')";
                $m = UCQuery::updateTrans($sql);
                Yii::app()->msg->postMsg('success', '操作成功');
                $this->redirect(Yii::app()->createUrl('xiaoxin/class/update/' . $class->cid));
         //   }else{
           //     Yii::app()->msg->postMsg('error', '修改班级失败,该班级名称已存在');
            //    $this->redirect($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : array('index'));
         //   }

        }
        $sql = "CALL php_xiaoxin_getClassTeacher('" . $id . "')";
        $teachers=array();
        $nameArr=array();
        $teachers_temp = UCQuery::queryAll($sql);
        foreach($teachers_temp as $val){
            if(!in_array($val['name'],$nameArr)){
                $nameArr[]=$val['name'];
                $teachers[]=$val;
            }
        }
        $this->render('update', array('class' => $class, 'teachers' => $teachers));
    }

    /**
     * 我的班级-创建班级
     * panrj 2014-08-09
     */
    public function actionCreate()
    {
        $userid = Yii::app()->user->id;
        $sid = Yii::app()->request->getParam('sid');

        if (isset($_POST['Class'])) {
            $name = MainHelper::csubstr(trim($_POST['Class']['name']),0,20);
            $info = isset($_POST['Class']['info']) ? $_POST['Class']['info'] : '';
            $sid = $_POST['sid'];
            //自注册默认为兴趣班f
            $cid = MClass::createClassByOpenReg($name, $info, $sid, $userid);
            if($cid=="exist"){
                Yii::app()->msg->postMsg('error', '该班级已存在');
                $this->redirect($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : array('index'));
                die();
            }
            Yii::app()->cache->set("userid_".$userid."cid_".$cid.date("Y-m-d"),$cid,3600);
            // else {
            //     if ($gid) { //创建系统班
            //         $sql = "CALL php_xiaoxin_getGradeByPk('" . $gid . "')";
            //         $grade = UCQuery::queryRow($sql);
            //         $age = $grade->age;
            //         $stid = $grade->stid;
            //         $year = MainHelper::getClassYearByGradeAge($age);
            //         $type = 0;
            //         $sql = "CALL php_xiaoxin_AddTeacherClass('" . $name . "','" . $year . "','" . $sid . "','" . $stid . "','" . $type . "','" . $master . "','" . $info . "'," . (int)USER_BRANCH . ")";
            //         $m = UCQuery::insertTrans($sql);
            //     }
            // }
            Yii::app()->msg->postMsg('success', '操作成功');
            $this->redirect(Yii::app()->createUrl('xiaoxin/class/scupload?cid=' . $cid));
        }
        //$schools = UCQuery::getTeacherSchool($userid);
        //$sid = 46101;
        $this->render('create', array('sid' => $sid));
    }

    /**
     * 我的班级-入班邀请
     * panrj 2014-08-09
     */
    public function actionInvites($id)
    {
        $page = (int)Yii::app()->request->getParam("page", 1);
        $class = UCQuery::loadClass($id);
        $userid = Yii::app()->user->id;
        $sql = "CALL php_xiaoxin_GetClassTeacherRealtionByAttributes('" . $id . "','0','0')";
        $teachers = UCQuery::queryAll($sql);
        $sql = "CALL php_xiaoxin_GetClassStudentRealtionByAttributes('" . $id . "','0','0')";
        $students = UCQuery::queryAll($sql);
        $dataArr = MainHelper::array_subkey_sort(array_merge($teachers, $students), 'creationtime');
        $data = UCQuery::PageData($dataArr, $page);
        $this->render('invites', array('data' => $data, 'class' => $class));
    }

    /**
     * 我的班级-入班邀请-确认
     * panrj 2014-08-09
     */
    public function actionAccept($id)
    {
        $sql = "CALL php_xiaoxin_ChangeClassRelationState('" . $id . "','1','teacher')";
        $errors = UCQuery::updateTrans($sql);
        if (!$errors)
            Yii::app()->msg->postMsg('success', '操作成功');
        $this->redirect(Yii::app()->createUrl('xiaoxin/class/apply'));
    }

    /**
     * 我的班级-入班邀请-拒绝
     * panrj 2014-08-09
     */
    public function actionRefuse($id)
    {
        $sql = "CALL php_xiaoxin_ChangeClassRelationState('" . $id . "','2','teacher')";
        $errors = UCQuery::updateTrans($sql);
        if (!$errors)
            Yii::app()->msg->postMsg('success', '操作成功');
        $this->redirect(Yii::app()->createUrl('xiaoxin/class/apply'));
    }

    /**
     * 我的班级-放弃邀请
     * panrj 2014-08-09
     */
    public function actionGiveupinvite($id)
    {
        $tid = Yii::app()->request->getParam('tid');
        $ty = Yii::app()->request->getParam('ty');

        if ($tid && $ty) {
            $sql = "CALL php_xiaoxin_ChangeClassRelationState('" . $tid . "','3','" . $ty . "')";
            $errors = UCQuery::updateTrans($sql);
            if (!$errors)
                Yii::app()->msg->postMsg('success', '操作成功');
        }
        $this->redirect(Yii::app()->createUrl('xiaoxin/class/invites/' . $id));
    }

    /**
     * 我的班级-移除老师
     * $id-- userid
     * panrj 2014-08-09
     */
    public function actionRemoveteacher($id)
    {
        $cid = Yii::app()->request->getParam('cid');
        $errors = false;
        if ($cid && $id) {
            $errors = ClassTeacherRelation::deleteClassTeacher($id, $cid);
        }

        if ($errors) {
            Yii::app()->msg->postMsg('success', '操作成功');
        } else {
            Yii::app()->msg->postMsg('error', '操作失败');
        }
        $this->redirect(Yii::app()->createUrl('xiaoxin/class/teachers/' . $cid));

        // $this->render('invites');
    }

    /**
     * 我的班级-移除学生
     * panrj 2014-08-09
     * $id为关系id,不同班班,班班id是学生id
     */
    public function actionRemovestudent($id)
    {
        $cid = Yii::app()->request->getParam('cid');
        $errors=false;
        $classStudentRelation=ClassStudentRelation::model()->findByPk($id);
        if($cid&&$classStudentRelation){
            $studentRelation=ClassStudentRelation::getStudentClass($classStudentRelation->student);
            //获取该学生的所有班级
            $studentClassNum=0;

            if($studentRelation){
                foreach($studentRelation as $val){
                    if($val->c&&$val->c->deleted==0){
                        $studentClassNum++;
                    }
                }

            }

            $classStudentRelation->deleted = 1;
            $save = $classStudentRelation->save();
            if(!$save) $errors=true;

            if($save&&$studentClassNum==1){ //如果该学生只存在一个班级中，删除该学生
                $member=Member::model()->findByPk($classStudentRelation->student);
                $member->deleted=1;
                $member->save();

                //删除该学生的监护人关系
                $guardians=Guardian::getChildGuardianRelation($classStudentRelation->student);
                foreach($guardians as $guardian){
                    $guardian->deleted=1;
                    $guardian->save();
                }
            }
        }


        if (!$errors)
            Yii::app()->msg->postMsg('success', '操作成功');
        $this->redirect(Yii::app()->createUrl('xiaoxin/class/students/' . $cid));
        // $this->render('invites');
    }

    /**
     * 我的班级-获取学校年级
     * panrj 2014-08-09
     */
    public function actionSchoolgrade()
    {
        $sid = Yii::app()->request->getParam('sid');
        $con = '';
        if ($sid) {
            $sql = "CALL php_xiaoxin_getSchoolGrade('" . $sid . "')";
            $grades = UCQuery::queryAll($sql);
            $con = $this->renderPartial('schoolgrade', array('grades' => $grades), true);
        }
        echo $con;
    }

    /**
     * 我的班级-解散班级
     * panrj 2014-08-09
     */
    public function actionDepart($id)
    {
        $sql = "CALL php_xiaoxin_DeleteClassAndRelation('" . $id . "')";
        $errors = UCQuery::updateTrans($sql);
        if (!$errors)
            Yii::app()->msg->postMsg('success', '操作成功');
        $this->redirect(Yii::app()->createUrl('xiaoxin/class/index'));
    }

    /**
     * 我的班级-更换班主任
     * panrj 2014-08-09
     */
    public function actionMaster($id)
    {
        $uid = Yii::app()->request->getParam('uid');
        $sql = "CALL php_xiaoxin_ChangeClassMaster('" . $id . "','" . $uid . "')";
        $errors = UCQuery::updateTrans($sql);
        if (!$errors){
           // ClassTeacherRelation::updateOrCreateMaster($uid,$id);
            Yii::app()->msg->postMsg('success', '操作成功');
        }
        $this->redirect(Yii::app()->createUrl('xiaoxin/class/update/' . $id));
    }

    /*
     * 生成邀请码
     * 规则:类型type+随机码(3)+微妙，
     * 密码6位
     */
    public function actionGeneratecode($id)
    {
        $page = (int)Yii::app()->request->getParam("page", 1);
        $listSql = "call php_xiaoxin_getClasscdkey($id)";
        $ty = Yii::app()->request->getParam('ty');
        $classInfo = UCQuery::loadClass($id);
        $data = UCQuery::queryAll($listSql);

        if (isset($_POST['Generatecode'])) {
            $num = $_POST['Generatecode']['number'] ? (int)($_POST['Generatecode']['number']) : 0;
            $type = $_POST['Generatecode']['type'] ? (int)$_POST['Generatecode']['type'] : 0; //1是学生,0是老师
            $data = array();
            $success = UCQuery::generateInviteCode($id, $num, $type);
            Yii::app()->msg->postMsg('success', '操作成功');
            $this->redirect(Yii::app()->createUrl('xiaoxin/class/generatecode/' . $id));
        }
        $data = $this->assembleCode($data);
        $data = UCQuery::PageData($data, $page);
        $this->render('generatecode', array('data' => $data, 'class' => $classInfo, 'type' => $ty));
    }

    /*
     * 导出xls
     */
    public function actionDownloadxls($id)
    {
        $listSql = "call php_xiaoxin_getClasscdkey($id)";
        $classInfo = UCQuery::loadClass($id);
        $data = UCQuery::queryAll($listSql);
        if (empty($data)) {
            Yii::app()->msg->postMsg('error', '没有数据可导出');
            exit();
        }
        $data = $this->assembleCode($data);
        $ceils = array();
        foreach ($data as $val) {
            $ceils[] = array($val['cdkey'], $val['password'], $val['useType'], $val['useState'], $val['updatetime'], $val['name'], $val['mobilephone']
            );
        }
        $excel_file = '导出邀请码';
        $excel_content = array(
            array(
                'sheet_name' => 'batch',
                'sheet_title' => array('邀请码', '密码', '类型', '状态', '使用时间', '使用者', '使用者手机'),
                'ceils' => $ceils,
            ),
        );
        PHPExcelHelper::exportExcel($excel_content, $excel_file);
    }

    private function assembleCode($data)
    {
        foreach ($data as $k => $val) {
            if (empty($val['userid'])) {
                $data[$k]['useState'] = '';
            } else {
                $data[$k]['useState'] = '已使用';
            }
            $data[$k]['useType'] = intval($val['type']) == 0 ? '老师' : '学生';
            if (!empty($val['userid'])) {
                $userInfo = UCQuery::loadUser($val['userid']);
                if ($val['type'] == 1) {
                    $guardians = UCQuery::queryAll("call php_xiaoxin_GetStudentGuardian({$val['userid']},0)");
                    if (is_array($guardians) && count($guardians) > 0) {
                        $data[$k]['mobilephone'] = $guardians[0]['mobilephone'];
                    } else {
                        $data[$k]['mobilephone'] = '';
                    }
                    $data[$k]['name'] = $userInfo->name;
                } else {
                    $data[$k]['name'] = $userInfo->name;
                    $data[$k]['mobilephone'] = $userInfo->mobilephone;
                }
            } else {
                $data[$k]['name'] = '';
                $data[$k]['mobilephone'] = '';
                $data[$k]['updatetime'] = '';
            }
        }
        return $data;
    }

    /*
     * $id为班级id
     */
    public function actionUpdatestudent($id)
    {
        if (isset($_POST['name']) && isset($_POST['mobilephone'])) {
            $names = $_POST['name'];
            $mobilephones = is_array($_POST['mobilephone']) ? array_unique($_POST['mobilephone']) : array();
            $ids = isset($_POST['id']) ? $_POST['id'] : array();

            $student = (int)$_POST['student'];
            $studentid = $_POST['studentid'];//学号id
            $class=MClass::model()->findByPk($id);
            $currUser=Yii::app()->user->getInstance();
            $num = count($mobilephones);
            $msgArr = array();
            $transaction = Yii::app()->db_member->beginTransaction();
            try {
                $user_ext = StudentExt::model()->findByPk($student);

                if ($user_ext) {
                    $user_ext->studentid = $studentid; //保存学号
                    $user_ext->save();
                } else {
                    $user_ext = new StudentExt;
                    $user_ext->userid = $student;
                    $user_ext->studentid = $studentid;
                    $user_ext->save();

                }
                $parentids = array();
                if (empty($mobilephones)) { //如果为空，则删除这个学生的全部关系
                    Guardian::deleteStudentGrardianRelation($student); //删除原来的学生家长关系
                }

                for ($i = 0; $i < $num; $i++) {
                    $ids[$i] = trim($ids[$i]);
                    if (isset($ids[$i]) && !empty($ids[$i])) { //编辑
                        $oldGuardian = Guardian::model()->findByPk($ids[$i]);
                        if (!$oldGuardian) continue;
                        if ($oldGuardian->guardian0->mobilephone == $mobilephones[$i]) {
                            $parentids[] = $oldGuardian->guardian;
                            if ($oldGuardian->role == $names[$i]) { //原手机号，角色没变，则不需要修改
                                continue;
                            } else {
                                $oldGuardian->role = $names[$i]; //只修改了角色
                                $oldGuardian->save();
                            }
                        } else {
                            $user = Member::getUniqueMember($mobilephones[$i]);
                            if ($user) {
                                $parentids[] = $user->userid;
                                $oldGuardian->guardian = $user->userid;
                                $oldGuardian->role = $names[$i];
                                $oldGuardian->save();
                                $newId = Constant::FAMILY_IDENTITY;
                                $tranId = Member::transIdentity($newId, $user->identity);
                                $user->identity = $tranId;
                                $user->save();
                            } else {
                                $oldUser = Member::model()->findByPk($oldGuardian->guardian);
                                if ($oldUser) {
                                    $parentids[] = $oldUser->userid;
                                    $oldUser->mobilephone = $mobilephones[$i];
                                    $oldUser->save();
                                }
                            }
                        }


                    } else {
                        $user = Member::getUniqueMember($mobilephones[$i]);
                        if ($user) {
                            $parentids[] = $user->userid;
                            $guardian = new Guardian;
                            $guardian->child = $student;
                            $guardian->guardian = $user->userid;
                            if ($i == 0) {
                                $guardian->main = 1;
                            }
                            if (!empty($names[$i])) {
                                $guardian->role = $names[$i];
                            }
                            $guardian->save();
                            $newId = Constant::FAMILY_IDENTITY;
                            $tranId = Member::transIdentity($newId, $user->identity);
                            $user->identity = $tranId;
                            $user->save();
                        } else {
                            $userid = UCQuery::makeMaxId(0, true);
                            $parentids[] = $userid;
                            $member = new Member;
                            $member->userid = $userid;
                            $member->name = '用户' . substr($mobilephones[$i], -4); //$_POST['Student']['name'] . '的' . $roles[$i];
                            $member->identity = Constant::FAMILY_IDENTITY; //家长标志;
                            $member->mobilephone = $mobilephones[$i];
                            $member->account = "p" . $userid; //;
                            $member->issendpwd = 1;
                            $password = MainHelper::generate_code(6);
                            $member->pwd = MainHelper::encryPassword($password);
                            if ($member->save()) {
                                $msgArr[] = array('mobile' => $mobilephones[$i], 'password' => $password);
                                $msg = $names[$i] . '家长:我是' . $class->s->name . '的' . $currUser->name . '老师，我刚在'.SITE_NAME.'创建了班级，并为你开通了登录账号，账号：' . $mobilephones[$i] . ',初始密码:' . $password . ',大家可以在上面交流了。下载地址：'.SITE_APP_DOWNLOAD_SHORT_URL;
                                UCQuery::sendMobileMsg($mobilephones[$i],$msg);
                                $guardian = new Guardian;
                                $guardian->child = $student;
                                $guardian->guardian = $userid;
                                $guardian->main = 1;
                                if (!empty($names[$i])) {
                                    $guardian->role = $names[$i];
                                }
                                $guardian->save();
                            }

                        }
                    }
                }
                Guardian::deleteStudentGrardianByGuardians($student, $parentids);
                $transaction->commit();
                Yii::app()->msg->postMsg('success', '修改学生成功');
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->msg->postMsg('error', '修改学生失败');
            }
            $this->redirect(Yii::app()->createUrl("xiaoxin/class/students/$id"));
            exit();
        }
        $class = MClass::model()->findByPk($id);
        $student = Yii::app()->request->getParam("student", 0);
        $studentInfo = Member::model()->findByPk($student);
        $student_ext = StudentExt::model()->findByPk($student);
        $studentid = $student_ext ? $student_ext->studentid : '';
        $guardianList = array();
        if ($student) {
            $guardianList = Guardian::getChildGuardianRelation($student);
        }

        $this->render('updatestudent', array("id" => $id, 'studentid' => $studentid, 'class' => $class, 'guardians' => $guardianList, 'student' => $studentInfo));
    }

    /**
     * 重新邀请学生或老师
     * $cid classid
     * zengp 2014-12-27
     */
    public function actionAnewpinvite()
    {
        $cache = Yii::app()->cache;
        $anew_pinvite_day_count = Constant::ANEW_PINVITE_DAY_COUNT;
        $anew_pinvite_day_nums = Constant::ANEW_PINVITE_DAY_NUMS;

        $userid = Yii::app()->user->id;
        $cid = Yii::app()->request->getParam('cid');
        $type = Yii::app()->request->getParam('ty'); //1老师 2学生 （班级重新邀请）    
        $identity = $type == 1 ? 'teacher' : 'student';
        $myclass=ClassTeacherRelation::getTeacherClass($userid);
        if(!array_key_exists($cid,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $key_count = "anewpinvitedaycount_" . $userid . $cid . $identity . date("Y-m-d");
        $key_nums = "anewpinvitedaynums_" . $userid . $cid . date("Y-m-d");
        $currCount = $cache->get($key_count) ? $cache->get($key_count) : 0;
        $currNums = $cache->get($key_nums) ? $cache->get($key_nums) : 0;

        if (!empty($cid)) {
            $class = MClass::model()->findByPk($cid);
            $currUser = Member::model()->findByPk($userid);
        }

        $isregister = $class && $class->s && $class->s->createtype == 1;
        if ($cid && $type) {
            if ($type == 1) {
                $nums = 0;
                $teachers = ClassTeacherRelation::getClassTeacher($cid);
                foreach ($teachers as $teacher) {
                    $teacherInfo = $teacher->teacher0;
                    $web = $teacherInfo->lastlogintime ? 1 : 0;
                    $client = UserOnline::getOnLineByUserId($teacher->teacher);
                    if (!$web && !$client) {
                        $password = MainHelper::generate_code(6);
                        $pwd = MainHelper::encryPassword($password);
                        $member = Member::model()->findByPk($teacher->teacher);
                        if ($member) {
                            $member->pwd = $pwd;
                            $member->save();
                            $msg = $member->name . '老师:我是' . $class->s->name . '的' . $currUser->name . '老师，我刚在'.SITE_NAME.'创建了班级，并为你开通了登录账号，账号：' . $member->mobilephone . ',初始密码:' . $password . ',大家可以在上面交流了。下载地址：'.SITE_APP_DOWNLOAD_SHORT_URL;
                            UCQuery::sendMobileMsg($teacherInfo->mobilephone, $msg);
                        }
                        $nums++;
                        $currNums++;
                    }
                }

            } else if ($type == 2) {
                $nums = 0;
                $students = ClassStudentRelation::getClassStudents($cid, 0);

                foreach ($students as $student) {
                    $guardians = Guardian::getChildGuardianRelation($student->student);
                    $studentInfo=Member::model()->findByPk($student->student);
                    foreach ($guardians as $guardian) {
                        $guardianInfo = $guardian->guardian0;
                        $web = $guardianInfo->lastlogintime ? 1 : 0;
                        $client = UserOnline::getOnLineByUserId($guardianInfo->userid) ? 1 : 0;
                        if (!$web && !$client) {
                            $password = MainHelper::generate_code(6);
                            $guardianInfo->pwd = MainHelper::encryPassword($password);
                            $guardianInfo->save();
                            $msg =$studentInfo->name . "家长您好：我是" . $class->s->name . "的" . $currUser->name . "老师，我刚在".SITE_NAME."创建了班级，今后日常作业和学校通知都通过该平台发放。请您免费下载使用".SITE_NAME."接收信息、跟其他家长交流。系统为您配置的账号是：" .$guardianInfo->mobilephone . "，初始密码：" . $password . "。下载地址：".SITE_APP_DOWNLOAD_SHORT_URL;
                           // $msg = $guardianInfo->name . '家长:我是' . $class->s->name . '的' . $currUser->name . '老师，我刚在'.SITE_NAME.'创建了班级，并为你开通了登录账号，账号：' . $guardianInfo->mobilephone . ',初始密码:' . $password . ',大家可以在上面交流了。下载地址：'.SITE_APP_DOWNLOAD_SHORT_URL;
                            UCQuery::sendMobileMsg($guardianInfo->mobilephone, $msg);
                            $nums++;
                            $currNums++;
                        }
                    }

                }
            }
            $currCount += 1;
            $cache->set($key_count, $currCount, 3600 * 24);
            $cache->set($key_nums, $currNums, 3600 * 24);
            $sendpwd=Sendpwd::getTeacherSendpwd($userid);

            if(!$sendpwd){
                Sendpwd::addTeacherSendpwd($userid,$nums);
            }else{
                $sendpwd->sendpwdnum=$sendpwd->sendpwdnum+$nums;
                $sendpwd->save();
            }

            if ($nums > 0) {
                $tmp = $type == 1 ? '老师' : '家长';
                Yii::app()->msg->postMsg('success', '成功发送' . $tmp . '邀请' . $nums . '名');
                die(json_encode(array('status' => 1)));
            } else {
                Yii::app()->msg->postMsg('success', '不存在未使用用户，未发送邀请');
                die(json_encode(array('status' => 0)));
            }
        }
    }

    /*
     * 老师或学生发送密码邀请处理
     */
    public function actionSendpwd()
    {

        $userid = Yii::app()->user->id;
        $userinfo = Member::model()->findByPk($userid);
        $cid = (int)Yii::app()->request->getParam("cid", '0');
        $myclass=ClassTeacherRelation::getTeacherClass($userid);
        if(!array_key_exists($cid,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $importType = (int)Yii::app()->request->getParam("importType", '0'); //不同的地方导入创建url的标识
        $type = Yii::app()->request->getParam("type", '1'); //老师还是学生,默认是学生
        $stuOrTea = $type == 1 ? 'studentuploadsendpwd' : 'teacheruploadsendpwd'; //cache名
        $list = array();
        $class = null;
        $resultArr = array('status' => 0, 'nums' => 0, 'cid' => $cid);
        // $cid = '714701';
        if (!empty($cid)) {
            $class = MClass::model()->findByPk($cid);
        } else {
            die(json_encode($resultArr));
        }
        $cache = Yii::app()->cache;
        $list = $cache->get("class" . $cid . $stuOrTea . $userid);
        $numAdd = 0;
        if ($type == 1)
            $numAdd = $cache->get("class" . $cid . $stuOrTea . 'Nums' . $userid);
        // conlog($list);
        $nums = 0;
        $role = $type == 1 ? '家长' : '老师';
        $mobiles = array();
        if ($class) {
            $school = School::model()->findByPk($class->sid);
        } else {
            $school = null;
        }
        $isregister = $school && $school->createtype == 1;
        if (is_array($list) && count($list)) {
            foreach ($list as $val) {
                if ($type == 1) {
                    $str = $val['name'] . $role . "您好：我是" . $class->s->name . "的" . $userinfo->name . "老师，我刚在".SITE_NAME."创建了班级，今后日常作业和学校通知都通过该平台发放。请您免费下载使用".SITE_NAME."接收信息、跟其他家长交流。系统为您配置的账号是：" . $val['mobile'] . "，初始密码：" . $val['password'] . "。下载地址：".SITE_APP_DOWNLOAD_SHORT_URL;
                } else {
                    $str = $val['name'] . $role . "您好：我是" . $class->s->name . "的" . $userinfo->name . "老师，我刚在".SITE_NAME."创建了班级，并为你开通了登录账号：" . $val['mobile'] . "，初始密码：" . $val['password'] . "，大家都在上面交流了。下载地址：".SITE_APP_DOWNLOAD_SHORT_URL;
                }
                UCQuery::sendMobileMsg($val['mobile'], $str);
                $mobiles[] = $val['mobile'];
                $nums += 1;
            }
        }
        if (count($mobiles)) {
            Member::updateissendpwdStateByMobiles($mobiles);
        }
        // if($nums > 0){
        $resultArr['status'] = 1;
        if ($importType == 1) {
            $tmp = $type == 1 ? '家长' : '老师';
            Yii::app()->msg->postMsg('success', '成功发送' . $tmp . '邀请' . $nums . '名'); //班级管理里面的导入学生或教师的成功邀请信息（右正解弹窗)
        } else {
            $resultArr['url'] = Yii::app()->createUrl('xiaoxin/class/scfinish/' . $class->cid . '?ty=1&nums=' . $numAdd . '&sendnums=' . $nums); //创建班级导入学生时的跳转链接
        }
        die(json_encode($resultArr));
        // }else{
        //     die(json_encode($resultArr));           
        // }
        //$this->render('sendpwd',array('class'=>$class));
    }

    /**
     * 开放注册-创建班级-批量添加学生处理
     * $id-- classid
     * zengp 2014-12-27
     */
    public function actionScimport($id)
    {
        $class = MClass::model()->findByPk($id);
        $ty = Yii::app()->request->getParam('ty');
        $desc = Yii::app()->request->getParam('desc');
        $userid = Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid);
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $userinfo=Member::model()->findByPk($userid);
        $cache = Yii::app()->cache;
        $Arr = $cache->get("class" . $id . "studentupload" . $userid);
        if(!$Arr) $Arr=array();
        //$total = $Arr ? count($Arr) : 0;
        $total = 0;
        foreach ($Arr as $sitem) {
            if ($sitem['error'] == 0)
                $total++;
        }
        $resultArr = array('status' => 0, 'msg' => '', 'cid' => $id, 'url' => '', 'nums' => 0);
        if (!count($Arr)) {
            // Yii::app()->msg->postMsg('error', '未检测到有效数据，请先下载模版填写无误后上传！');
            // $this->redirect(Yii::app()->createUrl('xiaoxin/class/scupload/' . $id));
            $url = Yii::app()->createUrl('xiaoxin/class/scupload?cid=' . $id);
            $resultArr['msg'] = '未检测到有效数据，请先下载模版填写无误后上传！';
            $resultArr['url'] = $url;
            echo json_encode($resultArr);
            exit;
        } else {
            if ($ty == 'import') {
                $totalPeople =ClassTeacherRelation::getClassTeacherNumByCid($class->cid) + ClassStudentRelation::countClassStudentNum($class->cid);
                $tmpTotal = $total + $totalPeople;
                if ($tmpTotal > Constant::CLASS_TOTAL) { //默认100
                    $sub = (Constant::CLASS_TOTAL-$totalPeople) < 0 ? 0 : (Constant::CLASS_TOTAL-$totalPeople);
                    Yii::app()->msg->postMsg('error', '班级成员上限100，目前还能导入'. $sub .'人');
                    $url = Yii::app()->createUrl('xiaoxin/class/scupload?cid=' . $id);
                    $resultArr['url'] = $url;
                    die(json_encode($resultArr));
                }

                $nameArr = array();
                $mobileArr = array();
                $num = 0;
                $userinfo = Yii::app()->user->getInstance();
                $sendpwd = array();
                foreach ($Arr as $student) {
                    if ($student['error'] == 0) {
                        $result = MemberService::addStudentByMobileAndName($student['mobile'], trim($student['name']), $id, "",$class);
                        if (!empty($result)) {
                            if (isset($result['mobile']) && isset($result['password'])) {
                                $sendpwd[] = array('mobile' => $result['mobile'], 'password' => $result['password'], 'name' => trim($student['name']));
                            }
                        }
                        $num += 1;
                    }
                }
                $cache->delete("class" . $id . "studentupload" . $userid);
                $cache->set("class" . $id . "studentuploadsendpwd" . $userid, $sendpwd);
                $cache->set("class" . $id . "studentuploadsendpwdNums" . $userid, $num);
                //Yii::app()->msg->postMsg('success', '成功添加学生' . $num . '名');
                //$this->redirect(Yii::app()->createUrl('xiaoxin/class/students/' . $id));
                if($cache->get("userid_".$userid."cid_".$id.date("Y-m-d"))){
                    $resultArr['first']=1;
                    $cache->delete("userid_".$userid."cid_".$id.date("Y-m-d"));
                }else{
                    $resultArr['first']=0;
                }
                $resultArr['status'] = 1;
                $resultArr['url'] = Yii::app()->createUrl('xiaoxin/class/scfinish/' . $class->cid . '?ty=2&nums=' . $num . '&sendnums=0');
                echo json_encode($resultArr);
                exit;
            }
        }
        $this->render('scimport', array('total' => $total, 'data' => $Arr, 'class' => $class,'userinfo'=>$userinfo));
    }

    /**
     * 开放注册-创建班级成功
     * $id-- classid
     * zengp 2014-12-27
     */
    public function actionScfinish($id)
    {
        $ty = Yii::app()->request->getParam('ty');
        $nums = Yii::app()->request->getParam('nums');
        $sendnums = Yii::app()->request->getParam('sendnums');
        $class = MClass::model()->findByPk($id);
        $this->render('scfinish', array('ty' => $ty, 'nums' => $nums, 'sendnums' => $sendnums, 'class' => $class)); //ty=2=添加 =1=邀请
    }

    /**
     * 开放注册-创建班级批量导入学生
     * $id-- classid
     * zengp 2014-12-27
     */
    public function actionScupload()
    {
        $id = Yii::app()->request->getParam('cid');
        $class = MClass::model()->findByPk($id);
        $userid = Yii::app()->user->id;
        $myclass=ClassTeacherRelation::getTeacherClass($userid);
        if(!array_key_exists($id,$myclass)){
            Yii::app()->msg->postMsg('error', '你无权操作此班级');
            $this->redirect(array("class/index"));
            exit();
        }
        $this->render('scupload', array('class' => $class));
    }
    /**
     * 开放注册-创建班级去重
     * $id-- classid
     * zengp 2014-12-27
     */
    public function actionIsexist()
    {
        $name = trim(Yii::app()->request->getParam('cname'));
        $sid = Yii::app()->request->getParam('sid');
        $cid = Yii::app()->request->getParam('cid');
        $isbool = MClass::Isexist($name,$sid);
        if(!$isbool||($isbool&&$isbool->cid==$cid)){
            die(json_encode(array('status' => '1', 'msg' => true), JSON_UNESCAPED_UNICODE));
        }else{
            die(json_encode(array('status' => '2', 'msg' => '该班级已存在'), JSON_UNESCAPED_UNICODE));
        }
    }


}