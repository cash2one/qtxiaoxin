<?php
class AjaxController extends Controller
{
    /*
     * 根据选择的班级返回成绩单数据以及关联数据
     */
    public function actionIndex()
    {
        $cid = (int)Yii::app()->request->getParam("cid");
        $eid = (int)Yii::app()->request->getParam("eid");
        $isShowLevel = (int)Yii::app()->request->getParam("showlevel", 0); //是否需要显示成绩等级ABCD...
        $examInfo = Exam::model()->loadByPk($eid);
        $uid = Yii::app()->user->id;
        $schoolid = $examInfo->schoolid;
        $classes = ClassTeacherRelation::getTeacherClassRelation($uid, $schoolid);
        $tmp = array();
        $cids = explode(",", $examInfo->cid);
        foreach ($classes as $v) {
            if (in_array($v->cid, $cids)) {
                $tmp[] = $v;
            }
        }
        $gcinfo = MClass::getGradeClassArr($tmp);
        $sids = explode(",", $examInfo->sid);
        $subjectList = Subject::getSubjects($examInfo->sid);
        if ($cid) {
            $classMan = ExamService::getClsssStudent($cid, $sids); //获取班级下的学生
            $score = array();
            $evaluation = array();
            foreach ($sids as $sid) {
                $examAlone = ExamAlone::getExamAndAloneInfo($cid, $sid, $eid);
                if ($examAlone) {
                    $score[$sid] = ExamScore::getExamScoreByEaid($examAlone['eaid']);
                    $avgtmp[$sid] = ExamScore::getExamScoreByEaid($examAlone['eaid']);
                } else {
                    $avgtmp[$sid] = array();
                }
            }
            foreach ($avgtmp as $key => $val) {
                $avg[$key]['avg'] = (ExamService::average($val)) ? ExamService::average($val) : '';
            }
            $evaluation = ExamEvaluation::getExamEvaluation($eid);
            $config = json_decode($examInfo->config, true);
            if (is_array($classMan)) {
                foreach ($classMan as $k => $val) {
                    foreach ($sids as $sid) {
                        $sidconfig = isset($config[$sid]) ? $config[$sid] : array();
                        $sc = isset($score[$sid]) ? $score[$sid] : array();
                        $classMan[$k][$sid] = isset($sc[$val['userid']]) ? $sc[$val['userid']] : '';
                        if ($isShowLevel) {
                            $levelName = ExamService::getLevelNameByScoreShow($classMan[$k][$sid], $sidconfig);
                            $classMan[$k][$sid] .= ($levelName) ? ('（' . $levelName . '）') : '';
                        }
                    }
                    if (isset($val['userid'])) {
                        if (isset($evaluation[$val['userid']])) {
                            $classMan[$k]['evaluation'] = isset($evaluation[$val['userid']]) ? $evaluation[$val['userid']] : '';
                        }
                    }
                }

            }
        }


        $relationArr = ExamService::getRelationExam($eid, $gcinfo, $subjectList);
        die(json_encode(array('data' => $classMan, 'score' => $avg, 'sids' => $sids, 'relationArr' => $relationArr)));
    }

    /**
     * 返回学校老师数据
     */
    public function actionTeacherschinfo()
    {
        $sid = Yii::app()->request->getParam("sid", '');
        $ty = Yii::app()->request->getParam("ty");
        $uid = Yii::app()->user->id;
        if ($sid && $ty) {
            if ($ty == 'class') {
                $classes = NoticeService::getExamClassBySidUid($sid,$uid);
                $gcinfo = MClass::getGradeClassArr($classes);
                echo json_encode($gcinfo);
                exit;
            }
            if ($ty == 'subject') {
                $subjects = Subject::getSubjectsBySchoolids($sid);

                echo json_encode($subjects);
                exit;
            }
        } else {
            echo '';
            exit;
        }
    }

    public function actionGetteachersbysid(){
        $sid = Yii::app()->request->getParam("sid", 0);
        $teacherArr = School::getSchoolTeacherReturnArr($sid,true);
        die(json_encode($teacherArr));
    }

    public function actionTeacherclass()
    {
        $sid = Yii::app()->request->getParam("sid", '');
        $uid = Yii::app()->user->id;
        $classes = NoticeService::getExamClassBySidUid($sid,$uid);
        $arr = array();
        foreach ($classes as $class) {
            if($class instanceof MClass){
                $arr[] = array('cid'=>$class->cid,'name'=>$class->name);
            }else{
                $arr[] = array('cid'=>$class->c->cid,'name'=>$class->c->name);//$class->c->name;
            }
        }

        die(json_encode($arr));
        exit;
    }

    /*
     * 上传成绩改放到这，主要是flash登录机制，这里不需要登录
     */
    public function actionScheck()
    {

        $id = Yii::app()->request->getParam('id');
        $uid = Yii::app()->request->getParam('uid') ? Yii::app()->request->getParam('uid') : Yii::app()->user->id;
        if (empty($uid) || empty($id)) {
            die(json_encode(array('status' => '2', 'msg' => '上传失败,参数有误'), JSON_UNESCAPED_UNICODE));
        }
        $examInfo = Exam::getExamByEid($id);
        $sids = explode(",", $examInfo['sid']);
        $sid_score = array();
        $subcount = count($sids);

        if (isset($_FILES['Filedata'])) {
            $root = yii::app()->basePath;
            spl_autoload_unregister(array('YiiBase', 'autoload'));
            $uploadfile = $_FILES['Filedata']['tmp_name'];
            Yii::$enableIncludePath = false;
            Yii::import('application.extensions.PHPExcel', 1);
            require_once($root . '/extensions/PHPExcel/IOFactory.php');
            require_once($root . '/extensions/PHPExcel/Reader/Excel5.php');
            $objPHPExcel = new PHPExcel();
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($uploadfile);
            $sheets = $objPHPExcel->getAllSheets();
            $objPHPExcel->setActiveSheetIndex(0);
            $allData = array();
            $ActiveSheet = null;
            $names = $objPHPExcel->getSheetNames();
            $sheetNum = $objPHPExcel->getSheetCount();
            for ($pp = 0; $pp < $sheetNum; $pp++) {
                $ActiveSheet = $objPHPExcel->getSheet($pp);
                $max = $ActiveSheet->getHighestRow();
                $maxColumn = $ActiveSheet->getHighestColumn();
                $counColumn = $this->getalphnum($maxColumn);
                $upalonesids = $counColumn - 3; //上传的成绩单有多少科目
                if ($upalonesids != $subcount) {
                    die(json_encode(array('status' => '3', 'msg' => '上传的成绩单与本次考试成绩不匹配'), JSON_UNESCAPED_UNICODE));
                }
                $cidname = $names[$pp];
                $cidid = explode("-", $cidname);
                $dataArr = array();
                for ($row = 2; $row <= $max; $row++) {
                    $userid = $ActiveSheet->getCellByColumnAndRow(0, $row)->getValue();
                    $name = $ActiveSheet->getCellByColumnAndRow(1, $row)->getValue();
                    for ($i = 0; $i < $subcount; $i++) {
                        $sid_score[$sids[$i]] = $ActiveSheet->getCellByColumnAndRow($i + 2, $row)->getValue();
                    }
                    $evaluation = $ActiveSheet->getCellByColumnAndRow($i + 2, $row)->getValue();
                    $data = array('userid' => $userid, 'name' => $name, 'evaluation' => $evaluation);
                    foreach ($sid_score as $key => $vv) {
                        $data[$key] = $vv;
                    }
                    $dataArr[] = $data;
                }
                $allData[$cidid[1]] = $dataArr;
            }
            $cache = Yii::app()->cache;
            $cache->set("exam" . $id . "examscoreupload" . $uid, $allData);
            spl_autoload_register(array('YiiBase', 'autoload'));
            die(json_encode(array('status' => '1', 'msg' => '上传成功'), JSON_UNESCAPED_UNICODE));
        } else {
            die(json_encode(array('status' => '2', 'msg' => '上传失败'), JSON_UNESCAPED_UNICODE));
        }
        //  $this->render('import', array('id' => $id, 'examInfo' => $examInfo));
    }

    private function getalphnum($char)
    {
        $sum = '';
        $array = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $len = strlen($char);
        for ($i = 0; $i < $len; $i++) {
            $index = array_search($char[$i], $array);
            $sum += ($index + 1) * pow(26, $len - $i - 1);
        }
        return $sum;
    }

    public function actionTest()
    {
        $partten = '/^[a-zA-Z0-9_]+@[a-zA-Z0-9]+\.(com)|(cn)$/';

        $s = "zhoujunshe@.com";
        if (preg_match($partten, $s)) {
            echo "match";
        } else {
            echo 'no match';
        }

    }
    /*
     * 导入老师
     */
    public function actionImportteacher()
    {

        $sid = Yii::app()->request->getParam('sid');
        $uid = Yii::app()->request->getParam('uid') ? Yii::app()->request->getParam('uid') : Yii::app()->user->id;
        if (empty($uid) || empty($id)) {
            die(json_encode(array('status' => '2', 'msg' => '上传失败,参数有误'), JSON_UNESCAPED_UNICODE));
        }

        if (isset($_FILES['Filedata'])) {
            $root = yii::app()->basePath;
            spl_autoload_unregister(array('YiiBase', 'autoload'));
            $uploadfile = $_FILES['Filedata']['tmp_name'];
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
            for ($row = 2; $row <= $max; $row++) {
                $name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
                $mobile = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
                if (!in_array($mobile, $mobileArr) && $name && $mobile && CheckHelper::IsMobile($mobile)) {
                    array_push($mobileArr, $mobile);
                    array_push($dataArr, array('name' => $name, 'mobile' => $mobile));
                }
            }
            $cache = Yii::app()->cache;
            $cache->set("schoolid" . $sid . "teacherupload" . $uid, $dataArr);
            spl_autoload_register(array('YiiBase', 'autoload'));
            die(json_encode(array('status' => '1', 'msg' => '上传成功'), JSON_UNESCAPED_UNICODE));
        } else {
            die(json_encode(array('status' => '2', 'msg' => '上传失败'), JSON_UNESCAPED_UNICODE));
        }
        //  $this->render('import', array('id' => $id, 'examInfo' => $examInfo));
    }
    /*
     * 导入学生
     */
    public function actionImportStudent()
    {

        $sid = Yii::app()->request->getParam('sid');
        $uid = Yii::app()->request->getParam('uid') ? Yii::app()->request->getParam('uid') : Yii::app()->user->id;
        if (empty($uid) || empty($id)) {
            die(json_encode(array('status' => '2', 'msg' => '上传失败,参数有误'), JSON_UNESCAPED_UNICODE));
        }

        if (isset($_FILES['Filedata'])) {
            $root = yii::app()->basePath;
            spl_autoload_unregister(array('YiiBase', 'autoload'));
            $uploadfile = $_FILES['Filedata']['tmp_name'];
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
            for ($row = 2; $row <= $max; $row++) {
                $name = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue();
                $mobile = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue();
                $classname = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue();
                if (!in_array($mobile, $mobileArr) && $name && $classname &&$mobile && CheckHelper::IsMobile($mobile)) {
                    array_push($mobileArr, $mobile);
                    array_push($dataArr, array('name' => $name, 'mobile' => $mobile,'classname'=>$classname));
                }
            }
            $cache = Yii::app()->cache;
            $cache->set("schoolid" . $sid . "studentupload" . $uid, $dataArr);
            spl_autoload_register(array('YiiBase', 'autoload'));
            die(json_encode(array('status' => '1', 'msg' => '上传成功'), JSON_UNESCAPED_UNICODE));
        } else {
            die(json_encode(array('status' => '2', 'msg' => '上传失败'), JSON_UNESCAPED_UNICODE));
        }
        //  $this->render('import', array('id' => $id, 'examInfo' => $examInfo));
    }
    public function actionPwd(){
        $uid=(int)Yii::app()->request->getParam("uid");
        if($uid){
            $userList=UCQuery::queryAll("select * from tb_user where length(pwd)<10 and deleted=0 and pwd!='' and userid=$uid limit 1000");
        }else{
            $userList=UCQuery::queryAll("select * from tb_user where length(pwd)<10 and deleted=0 and pwd!=''  limit 1000");
        }
        foreach($userList as $val){
            $member=Member::model()->findByPk($val['userid']);
            if($member){
                $member->pwd=MainHelper::encryPassword($member->pwd);
                $member->save();
            }
        }

    }

    public function actionQiniutoken()
    {
        $arr = array('uptoken'=>MainHelper::generate_password(22));
        // "uptoken": "0MLvWPnyya1WtPnXFy9KLyGHyFPNdZceomL"
        echo JsonHelper::JSON($arr);
    }
    
    /**
     * 公众号的七牛云上传地址，对返回格式作了区别
     */
    public function actionOfficialtoken($type)
    {
        require_once( Yii::app()->basePath.'/extensions/qiniu/qiniuphp/rs.php');
        
        if($type == 'tx'){ //头像图片
            $bucket = STORAGE_QINNIU_BUCKET_TX;
        }else if(($type == 'xx')){ //消息图片
            $bucket = STORAGE_QINNIU_BUCKET_XX;
        }
        
        //$bucket = STORAGE_QINNIU_BUCKET;
        $accessKey = STORAGE_QINNIU_ACCESSKEY;
        $secretKey = STORAGE_QINNIU_SECRETKEY;
        
        Qiniu_SetKeys($accessKey, $secretKey);
        $putPolicy = new Qiniu_RS_PutPolicy($bucket);
        
        $putPolicy->ReturnBody = '{"key": $(key),"width": $(imageInfo.width),"height": $(imageInfo.height)}';
        $upToken = $putPolicy->Token(null);
        echo '{"uptoken": "'.$upToken.'"}'; 
    }

    public function actionGettoken($type)
    {
        require_once( Yii::app()->basePath.'/extensions/qiniu/qiniuphp/rs.php');

        if($type == 'tx'){ //头像图片
            $bucket = STORAGE_QINNIU_BUCKET_TX;
        }else if(($type == 'xx')){ //消息图片
            $bucket = STORAGE_QINNIU_BUCKET_XX;
        }

        //$bucket = STORAGE_QINNIU_BUCKET;
        $accessKey = STORAGE_QINNIU_ACCESSKEY;
        $secretKey = STORAGE_QINNIU_SECRETKEY;

        Qiniu_SetKeys($accessKey, $secretKey);
        $putPolicy = new Qiniu_RS_PutPolicy($bucket);
        // $putPolicy -> Scope = $bucket . ":" . Yii::app()->user->id.'.jpg';
        // $putPolicy -> InsertOnly = 0;
        // $putPolicy->SaveKey = Yii::app()->user->id.'.jpg';
        $upToken = $putPolicy->Token(null);
        echo '{"uptoken": "'.$upToken.'"}';
    }
    /*
     *点提交验证码
     */
    public function actionCheckphonenum(){
        $cache = Yii::app()->cache;
        $phone = trim(Yii::app()->request->getParam('phone'));
        $code = trim(Yii::app()->request->getParam('code'));
        $phoneday = "openregister_" . $phone.date("Y-m-d");
        $key = "openregister_" . $phone;
        $todaynum=$cache->get($phoneday);
        $codevalue=$cache->get($key);
        if(!$codevalue&&$todaynum){
            die(json_encode(array('status' => '0','msg'=>'验证码错误或已失效')));//
        }
        if($code&&$codevalue==$code){
            die(json_encode(array('status' => '1','msg'=>'')));//
        }else if($code&&$codevalue!==$code){
            $todaynum=$cache->get($phoneday);
            if(!$todaynum){
                die(json_encode(array('status' => '0','msg'=>'请点击获取验证码按扭，获取验证码')));//
            }
            die(json_encode(array('status' => '0','msg'=>'验证码错误或已失效')));//
        }

        $todaynum=$cache->get($phoneday);
        if(!$todaynum){
            die(json_encode(array('status' => '0','msg'=>'请点击获取验证码按扭，获取验证码')));//
        }
        if(!preg_match('/^1\d{10}$/',$phone)){
            die(json_encode(array('status' => '0','msg'=>'手机号格式不正确')));//
        }
        if($todaynum&&(int)$todaynum>=3){
            die(json_encode(array('status' => '0','msg'=>'已超过发送次数限制，请明天再试')));//一天发送验证不能超过3次
        }else{
            die(json_encode(array('status' => '1','msg'=>'')));//
        }
    }

    // //开放注册验证手机
    // public function actionCheckphone()
    // {
    //     $cache = Yii::app()->cache;
    //     $phone = Yii::app()->request->getParam('phone');
    //     $phoneday = "openregister_" . $phone.date("Y-m-d");
    //     $todaynum=$cache->get($phoneday);
    //     if($todaynum&&(int)$todaynum>=3){
    //         die(json_encode(array('status' => '0','msg'=>'已超过发送次数限制，请明天再试')));//一天发送验证不能超过3次
    //     }
    //     $match = Member::getUniqueByOpenReg($phone);
    //     if($match){
    //         $key = "openregister_" . $phone;
    //         $code = MainHelper::generate_code(6);
    //         $msg = "尊敬的用户，您本次获得的验证码是：" . $code."，请勿告诉他人。";
    //         UCQuery::sendMobileMsg($phone, $msg,11);
    //         $cache->set($key, $code, 1800);
    //         if($todaynum){
    //             $todaynum=$todaynum+1;
    //         }else{
    //             $todaynum=1;
    //         }
    //         $cache->set($phoneday, $todaynum, 3600*24);
    //         if($match == 1){
    //             //,'code' => $code
    //             echo json_encode(array('status' => '1'));
    //         }else{
    //             //, 'code' => $code
    //             echo json_encode(array('status' => '2','uid' => $match));
    //         }
    //         exit();
    //     }
    //     echo json_encode(array('status' => '0'));
    // }

    //开放注册发送验证码
    public function actionSendcode()
    {
        $phone = Yii::app()->request->getParam('phone');

        if ($phone) {
            $cache = Yii::app()->cache;
            $key = "openregister_" . $phone;

            $code = MainHelper::generate_code(6);
            $msg = "尊敬的用户，您本次获得的验证码是：" . $code."，请勿告诉他人。";
            UCQuery::sendMobileMsg($phone, $msg,11);

            $cache->set($key, $code, 1800);

            echo json_encode(array('status' => '1'));
        } else {
            echo json_encode(array('status' => '0'));
        }
    }

    //开放注册-检查验证码
    public function actionCheckcode()
    {
        $phone = Yii::app()->request->getParam('phone');
        $code = Yii::app()->request->getParam('code');
        $userid = Yii::app()->user->id;

        $key = "openregister_" . $phone;
        $cache = Yii::app()->cache;
        $cachecode = $cache->get($key);
        $msg = $cachecode ? '验证码有误，请输入正确验证码' : '验证码已过期，请重新获取验证码';
        $rs = array('status' => 0, 'msg' => $msg);
        if ($phone && $code) {
            if ($cachecode == $code) {
                $rs['status'] = 1;
                $rs['msg'] = '验证通过';
            }
        }
        echo json_encode($rs);
    }

    //开放注册-学校名是否存在
    public function actionCheckschool()
    {
        $schoolName = Yii::app()->request->getParam('sname');
        $sid = School::getSchoolByName($schoolName);

        if($sid){            
            if($sid == 1){
                echo json_encode(array('status' => '0'));//系统存在
            }else{
                echo json_encode(array('status' => '2','sid' => $sid));
            }
        }else{
            echo json_encode(array('status' => '1'));
        }
    }

    /**
    * 重新邀请限制
    * zengp 2014-12-28    
    * @return json 
    */
    public function actionCheckAnewSendCount()
    {
        $cache=Yii::app()->cache;
        $anew_pinvite_day_count = Constant::ANEW_PINVITE_DAY_COUNT;
        $anew_pinvite_day_nums = Constant::ANEW_PINVITE_DAY_NUMS;

        $cid = Yii::app()->request->getParam('cid');
        $type = Yii::app()->request->getParam('ty');
        $userid = Yii::app()->user->id;
        $needSendpwdNum=0;
        $identity = $type == 1 ? 'teacher' : 'student';
        $sendpwd=Sendpwd::getTeacherSendpwd($userid);
         $key_count = "anewpinvitedaycount_" . $userid . $cid . $identity .date("Y-m-d");
        // $key_nums = "anewpinvitedaynums_" . $userid . $cid . date("Y-m-d");
        // conlog($cache->get($key_count));exit;
        //  $currCount = $cache->get($key_count);
        //$currNums = $cache->get($key_nums);
        $currCount = $cache->get($key_count);
        if($currCount >= $anew_pinvite_day_count){
            Yii::app()->msg->postMsg('success', '每天只能发送一次邀请');
            die(json_encode(array('status'=>0)));
        }
        if($sendpwd&&$sendpwd->sendpwdnum>=$sendpwd->maxsendnum){
            Yii::app()->msg->postMsg('success', '您已超过邀请短信发送量，如有问题请联系客服');
            die(json_encode(array('status'=>0)));
        }
//        if($type==1){
//            $teachers_old = ClassTeacherRelation::getClassTeacher($cid);
//            $needSendpwdNum=0;
//            foreach ($teachers_old as $val) {
//                $client = UserOnline::getOnLineByUserId($val->teacher);
//                $web = $val->teacher0->lastlogintime ? 1 : 0;
//                if(!$client&&!$web){
//                    $needSendpwdNum++;
//                }
//            }
//        }else{
//            $students = ClassStudentRelation::getClassStudents($cid, 0);
//            $needSendpwdNum=0;
//            foreach ($students as $val) {
//                $guradian = Guardian::getChildGuardianRelation($val->student);
//                foreach ($guradian as $k => $v) {
//                    $user = Member::model()->findByPk($v['guardian']);
//                    $client = UserOnline::getOnLineByUserId($v['guardian']) ? 1 : 0;
//                    $web = $user->lastlogintime ? 1 : 0;
//                    if(!$client&&!$web){
//                        $needSendpwdNum++;
//                    }
//                }
//            }
//        }
        die(json_encode(array('status'=>1,'needSendpwdNum'=>$needSendpwdNum)));
    }

}