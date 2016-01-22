<?php

class PhonebookController extends Controller
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
            $this->redirect(Yii::app()->createUrl("xiaoxin/default/index"));
            exit();
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
                'actions' => array('scheck'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'studentlist', 'getgrade', 'getclassbygrade', 'getdepartment','test','upload'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    //花名册老师列表
    public function  actionIndex()
    {
        $uid = Yii::app()->user->id;
        $schoollist = SchoolTeacherRelation::getTeacherSchools($uid); //获取登陆老师的学校列表
        foreach ($schoollist as $k => $v) { //我每个学校下面的班级
            if(!NoticeService::checkMonitorRight($k,$uid,Constant::APPID17)){
                unset($schoollist[$k]);
                continue;
            }
        }
        $uniqueSchoollist = array_unique($schoollist); //去重
        $temp = $uniqueSchoollist; //改变引用
        $firtstSchool = array_shift($uniqueSchoollist);
        $firtstSchoolid = array_search($firtstSchool, $temp);
        $query = isset($_GET['Phonebook']) ? $_GET['Phonebook'] : array('schoolid' => $firtstSchoolid, 'name' => '', 'did' => '');
        $result = SchoolTeacherRelation::model()->pageData($query);
        $allData = array(); //返回页面的数据
        $userids=array();
        foreach ($result['model'] as $key => $val) {
            $userids[]=$val['teacher0']['userid'];
            $allData[$key]['userid'] = $val['teacher0']['userid'];
            $allData[$key]['name'] = $val['teacher0']['name'];
            $allData[$key]['mobilephone'] = $val['teacher0']['mobilephone'];
            $allData[$key]['client'] = 0;
            $allData[$key]['department'] = SchoolTeacherRelation::getDepartmentByTeachers($val['sid'], $val['teacher0']['userid']);
        }
        $onlineusers=UserOnline::getOnLineUser($userids);
        foreach($allData as $key => $val){
            $allData[$key]['client']=isset($onlineusers[$val['userid']])?1:0;
        }

        $allDepartment = Department::getSchoolDepartment(array("sid" => $query['schoolid']));
       // $schoollist = SchoolTeacherRelation::getTeacherSchools($uid); //获取登陆老师的学校列表
        $this->render('index', array('schoollist' => $schoollist, 'data' => $result, 'name' => $query['name'], 'schoolid' => $query['schoolid'], 'allDepartment' => $allDepartment, 'did' => $query['did'], 'allData' => $allData));
    }

    //花名册学生列表
    public function  actionStudentlist()
    {


        $uid = Yii::app()->user->id;
        $schoollist = SchoolTeacherRelation::getTeacherSchools($uid); //获取登陆老师的学校列表
        foreach ($schoollist as $k => $v) { //我每个学校下面的班级
            if(!NoticeService::checkMonitorRight($k,$uid,Constant::APPID17)){
                unset($schoollist[$k]);
                continue;
            }
        }
        $uniqueSchoollist = array_unique($schoollist); //去重
        $temp = $uniqueSchoollist; //改变引用
        $firtstSchool = array_shift($uniqueSchoollist);
        $firtstSchoolid = array_search($firtstSchool, $temp);
        $query = isset($_GET['Phonebook']) ? $_GET['Phonebook'] : array('schoolid' => $firtstSchoolid, 'grade' => '', 'class' => '', 'name' => '');
        $cids = array();
        $allGrade = School::getSchoolGradesData($uid,$query['schoolid']); //获取所有年级
        $tempgrade = $allGrade;
        if ($query['grade']) {
            $cache = Yii::app()->cache;
            $grade_class = $cache->get("grade_class");
                $result = !empty($grade_class[$query['grade']])?$grade_class[$query['grade']]:"";
                if(is_array($result)){
                    foreach($result['classes'] as $key=>$val){
                        $cids[]= $val['cid'];
                    }
                }else{
                    $cids = array();
                }
        }else{
            $Fcids = NoticeService::getClassBySidUid($query['schoolid'],$uid);

            foreach($Fcids as $key=>$val){
                $cids[] = $val['cid'];
            }
        }
        if($query['grade']=="interest"){
            $teachers = SchoolTeacherRelation::getSchoolTeachersRelation(array('teacher' => $uid, 'sid' => $query['schoolid']));
            if ($teachers && isset($teachers->duty)) {
                $val=Duty::model()->findByPk($teachers->duty);
                if(!$val||$val->deleted==1){
                    return null;
                }
                if ($val->isseeallclass == 0) {
                    $myInterestClass = MClass::getAllInterestClass($query['schoolid'],$uid);
                }else if($val->isseeallclass == 1){
                    $cache = Yii::app()->cache;
                    $grade_class = $cache->get("grade_class");
                    if(!empty($grade_class['interest'])){
                        foreach($grade_class['interest']['classes'] as $key=>$val){
                            $myInterestClass[] =array('cid'=>$val['cid'],'name'=>$val['name']);
                        }
                    }else{
                        $myInterestClass =null;
                    }
                }else if($val->isseeallclass == 2){
                    $myInterestClass = MClass::getAllInterestClass2($query['schoolid']);
                }

            }
            if($myInterestClass){
                foreach($myInterestClass as $key=>$val){
                    $cids[] = $val['cid'];
                }
            }

        }
        $result = ClassStudentRelation::pageData($query,$cids);

        $allData = array(); //返回页面的数据
        $sort = array();
        $userids=array();
        if($result){
        foreach ($result['model'] as $key => $val) {
            $studentid = $val['student'];
            $student = Member::model()->findByPk($studentid);
            if ($student && $student->deleted == 0) {
                $allData[$key]['name'] = $student->name;
                $allguardian = Guardian::getChildGuardianRelation($studentid);
                $mobilephone = array();
                foreach ($allguardian as $k => $v) {
                    $user = Member::model()->findByPk($v['guardian']);
                    if ($user && $user->deleted == 0) {
                        $mobilephone[$k]['mobilephone'] = $user->mobilephone;
                        $mobilephone[$k]['role'] =$v->role;
                        $mobilephone[$k]['client'] = UserOnline::getOnLineByUserId($user->userid)?1:0;
                    }
                }
                $allData[$key]['mobilephone'] = $mobilephone;
            }
            $allData[$key]['time'] = $val['creationtime'];
            $allData[$key]['class'] = $val->c->name;
        }


        foreach($allGrade as $key=>$val){
            if($val!="兴趣班"){
                $sort[$key] = $val;
            }
        }
        foreach($allGrade as $key=>$val){
            if($val=="兴趣班"){
                $sort[$key] = $val;
            }
        }

        }
        $allclass = array();
        $resultgrade = !empty($grade_class[$query['grade']])?$grade_class[$query['grade']]:"";
        if(is_array($resultgrade)){
            foreach($resultgrade['classes'] as $key=>$val){
                $allclass[] =array('cid'=>$val['cid'],'name'=>$val['name']) ;
            }
        }else{
            $allclass = array();
        }
        $this->render('studentlist', array('allClass' => $allclass, 'schoollist' => $schoollist, 'data' => $result, 'name' => $query['name'], 'schoolid' => $query['schoolid'], 'grade' => $query['grade'], 'class' => $query['class'], 'allData' => $allData, 'allGrade' => $sort));
    }

    //获得年级
    public function actionGetgrade()
    {
        $uid = Yii::app()->user->id;
        $schoolid = Yii::app()->request->getParam("schoolid");
        if ($schoolid) {
            $allGrade = School::getSchoolGradesData($uid,$schoolid);
            $sort = array();
            foreach($allGrade as $key=>$val){
                if($val!="兴趣班"){
                    $sort[$key] = $val;
                }
            }
            foreach($allGrade as $key=>$val){
                if($val=="兴趣班"){
                    $sort[$key] = $val;
                }
            }
            if (!empty($sort)) {
                die(json_encode(array("state" => 1, "allGrade" => json_encode($sort))));
            } else {
                die(json_encode(array("state" => 2, "error" => "获取的年级数据为空")));
            }
        } else {
            die(json_encode(array("state" => 0, "error" => "传入参数出错")));
        }
    }

    //根据年级获取班级
    public function  actionGetClassByGrade()
    {
        $grade_id = Yii::app()->request->getParam("grade_id");
        $uid = Yii::app()->user->id;
        if (isset($grade_id)) {
                $cache = Yii::app()->cache;
                $grade_class = $cache->get("grade_class");
                $allclass = array();
                $result = !empty($grade_class[$grade_id])?$grade_class[$grade_id]:"";

                if(is_array($result)){
                    foreach($result['classes'] as $key=>$val){
                        $allclass[] =array('cid'=>$val['cid'],'name'=>$val['name']) ;
                    }
                }else{
                    $allclass = array();
                }
            if (!empty($allclass)) {
                die(json_encode(array("state" => 1, "allGrade" => json_encode($allclass))));
            } else {
                die(json_encode(array("state" => 2, "error" => "获取的班级数据为空")));
            }
        } else {
            die(json_encode(array("state" => 0, "error" => "传入参数出错")));
        }
    }

    //获取所有部门
    public function  actionGetdepartment()
    {
        $schoolid = Yii::app()->request->getParam("schoolid");
        if (isset($schoolid)) {
            $allDepartment = Department::getSchoolDepartment(array("sid" => $schoolid));
            if (!empty($allDepartment)) {
                die(json_encode(array("state" => 1, "allGrade" => json_encode($allDepartment))));
            } else {
                die(json_encode(array("state" => 2, "error" => "获取的老师数据为空")));
            }
        } else {
            die(json_encode(array("state" => 0, "error" => "传入参数出错")));
        }
    }

     public function actionUpload(){
       
         $this->render('qiniu');

    }
}