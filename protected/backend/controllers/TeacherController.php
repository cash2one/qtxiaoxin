<?php

class TeacherController extends Controller
{
    public function actionIndex()
    {
        // $schoolArr = School::getDataArr(true); //所有学校,带首字母用于下拉
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        // $schoolArr1 = School::getDataArr(); //所有学校不带首字母;
        $userid = Yii::app()->user->id;
        $schoolArr1 = UserAccess::getUserSchools($userid,false);

        $query = isset($_GET['Teacher']) ? $_GET['Teacher'] : array('mobilephone' => '', 'did' => '', 'sid' => '', 'name' => '','duty'=>'');
        //如果传入学校，就要设置学校cookie
        if (isset($_GET['Teacher']) && isset($query['sid'])) {
            MainHelper::setCookie(Yii::app()->params['xxschoolid'], $query['sid']);
        } else {
            $query['sid'] = isset($_GET['Teacher']) ? $query['sid'] : MainHelper::getCookie(Yii::app()->params['xxschoolid']);

        }
        $page = (int)Yii::app()->request->getParam("page", 1);
        $query['page'] = $page;
        $teacherlist = array();
        $teacherlist = ClassTeacherRelation::model()->pageDataBySql($query);
        $count = $teacherlist['total'];
        $criteria = new CDbCriteria();
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        foreach ($teacherlist['model'] as $k => $v) {
            $firstsid = explode(",", $v['sid']);
            if (!$query['sid']) {
                $firstinfo = $this->getSchoolSidName($firstsid);
            }
            $teacherlist['model'][$k]['schoolname'] = $query['sid'] ? $schoolArr1[$query['sid']] : (isset($firstinfo['name']) ? $firstinfo['name'] : ''); //学校名，
            //如果选择了学校，则以选择的查询学校为主显示，否则显示第一个

            //根据学校，查询这个老师在这个学校的部门,以显示部门名称,view中的did是个1,2,3这样的集合，不知道属于哪个学校

            $ration = SchoolTeacherRelation::getSchoolTeachersRelation(array('sid' => $query['sid'] ? $query['sid'] : (isset($firstinfo['sid']) ? $firstinfo['sid'] : ''), 'teacher' => $v['userid']));
            $did = $ration && $ration->did ? $ration->did : '0';

            if ($did) {
                $deptInfo = Department::model()->findByPk($did);
                $teacherlist['model'][$k]['deptname'] = $deptInfo && $deptInfo->deleted == 0 ?
                    $deptInfo->name : '';
            } else {
                $teacherlist['model'][$k]['deptname'] = '';
            }
            $allduty = SchoolTeacherRelation::getTeachersJob($v['userid']);
            if ($query['sid']) {
                $teacherlist['model'][$k]['duty'] = isset($allduty[$query['sid']]) ? $allduty[$query['sid']] : "";
            } else {
                $tempduty = isset($ration->duty) ? $ration->duty : "";
                $duty = Duty::model()->findByPk($tempduty);
                $teacherlist['model'][$k]['duty'] = $duty && $duty->deleted == 0 ? $duty->name : '无职务';
            }
            //下面用于循环输出这个老师的所有学校名，部门名
            $sids = explode(",", $v['sid']);
            $teacherlist['model'][$k]['schoolarr'] = SchoolTeacherRelation::getSchoolNameByTeachers($v['userid']);
            $teacherlist['model'][$k]['schoolnum'] = count($teacherlist['model'][$k]['schoolarr']); //学校数量
            $teacherlist['model'][$k]['client'] = UserOnline::getOnLineByUserId($v['userid'])?1:0; //客户端
        }
        $teacherlist['pages'] = $pages;
        $didArr = array();
        $didArr = School::getSchoolDid($query['sid'] ? $query['sid'] : "0");
        $dutylist=Duty::model()->findAll("deleted=:deleted",array(":deleted"=>0));
        $this->render('index', array('schools1' => $schoolArr1, 'dutylist'=>$dutylist,'schools' => $schoolArr, 'dids' => $didArr, 'teachers' => $teacherlist, 'query' => $query));
    }

    /*
     * 创建老师
     */
    public function actionCreate()
    {
        if (isset($_POST['Teacher'])) {

            $grade_id = isset($_POST['grade']) ? $_POST['grade'] : "";
            $cids=isset($_POST['cid']) ? $_POST['cid'] :array();
            $subjects=isset($_POST['subject']) ? $_POST['subject'] :array();
            $msgArr = array();
            $transaction = Yii::app()->db_member->beginTransaction();
            try {
                $member = Member::getUniqueMember($_POST['Teacher']['mobilephone']); //根据手机号获取用户是否存在
                if ($member) { //已经存在
                    if($member->identity==Constant::FAMILY_IDENTITY){
                        $member->name = $_POST['Teacher']['name'];
                    }
                    $oldIdentity = $member->identity;
                    $newIdentity = 1;
                    //换算身份
                    /*
                     *1--老师
                      2--学生
                      4--家长
                      5--(老师+家长)
                     */
                    $transIdentity = Member::transIdentity($newIdentity, $oldIdentity);
                    $member->identity = $transIdentity;
                    $member->state = 1;
                    $member->save();
                } else {
                    $userid = UCQuery::makeMaxId(0, true);
                    $member = new Member;
                    $member->state = 1;
                    $member->userid = $userid;
                    $member->attributes = $_POST['Teacher'];
                    $member->identity = Constant::TEACHER_IDENTITY; //默认老师身份;
                    $member->account = "t" . $userid; //默认老师身份;
                    $member->issendpwd = 1;
                    $password = MainHelper::generate_code(6);
                    $member->pwd = MainHelper::encryPassword($password);
                    if ($member->save()) {
                        UCQuery::sendMobilePasswordMsg($_POST['Teacher']['mobilephone'],$password);
                    }
                }
                $userid = $member->userid;
                $sids = isset($_POST['sid']) ? $_POST['sid'] : array();
                $dids = isset($_POST['did']) ? $_POST['did'] : array();
                //去重判断
                $siddids = array();
                $sign = 0;
                for ($i = 0; $i < count($sids); $i++) {
                    if (!$sids[$i]) continue;
                    if (!in_array('' . $sids[$i] . $dids[$i], $siddids)) {
                        $tempduty = isset($_POST['duty'][$i]) ? $_POST['duty'][$i] : "";
                        $oldrelation = SchoolTeacherRelation::getSchoolTeachersRelation(array('sid' => $sids[$i], 'teacher' => $userid));
                        if (!$oldrelation) {
                            $schoolteacher = new SchoolTeacherRelation;
                            $schoolteacher->sid = $sids[$i];
                            $schoolteacher->did = $dids[$i];
                            $duty = Duty::model()->findByPk($tempduty);
                            if ($duty && $duty->deleted == 0 && $duty->isseeallclass == 1) { //年级主任
                                $tempgrade = isset($grade_id[$sign]) ? $grade_id[$sign] : "";
                                $grade = Grade::model()->findByPk($tempgrade);
                                $sign++;
                                if ($grade) {
                                    $schoolteacher->stid = $grade->stid;
                                    $schoolteacher->year = MainHelper::getClassYearByGradeAge($grade->age);
                                }
                                $schoolteacher->duty = $_POST['duty'][$i];
                            } else {
                                $schoolteacher->duty = $_POST['duty'][$i];
                            }
                            $schoolteacher->teacher = $userid;
                            $schoolteacher->state = 1;
                            $schoolteacher->save();
                        }
                        $siddids[] = '' . $sids[$i] . $dids[$i];
                    }
                }

                //老师班级处理
                $cidlen=count($cids);
                for($i=0;$i<$cidlen;$i++){
                    $cid=$cids[$i];
                    if(empty($cid)) continue;
                    $sid=$subjects[$i];
                    $classTeacherRelation=new ClassTeacherRelation();
                    $classTeacherRelation->cid=$cid;
                    $classTeacherRelation->teacher=$userid;
                    $classTeacherRelation->state=1;
                    if($sid==='0'){  //班主任
                        $classTeacherRelation->type=1;
                        $mclass=MClass::model()->findByPk($cid);
                        if($mclass){
                            $mclass->master=$userid;
                            $mclass->save();
                        }
                        ClassTeacherRelation::updateOrCreateMaster($userid, $cid);

                    }else if($sid===''){ //没有任教科目
                        $classTeacherRelation->save();
                    }else{
                        if($sid){
                            $data=ClassTeacherRelation::getTeacherSubjectByCidSid($cid,$sid);
                            if($data){
                                $data->teacher=$userid;
                                $data->save();
                            }else{
                                $subjectinfo=Subject::model()->findByPk($sid);
                                $classTeacherRelation->type=0;
                                $classTeacherRelation->sid=$sid;
                                $classTeacherRelation->subject=$subjectinfo?$subjectinfo->name:'';
                                $classTeacherRelation->save();

                            }
                        }


                    }

                }
                $transaction->commit();
                Yii::app()->msg->postMsg('success', '创建老师成功');
                $this->redirect(array('index'));
            } catch (Exception $e) {
               // error_log($e->getMessage());
                $transaction->rollback();
                Yii::app()->msg->postMsg('error', '创建老师失败');
                $this->redirect(array('index'));
            }
        }
        // $schoolArr = School::getDataArr(true); //所有学校,带首字母用于下拉
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $sid = MainHelper::getCookie(Yii::app()->params['xxschoolid']);
        $didArr = array();
        if ($sid) {
            $didArr = School::getSchoolDid($sid);
        }
        $subjectArr=array();
        $classArr=array();
        if($sid){
            $subjectArr=School::getSchoolSubjectArr($sid);
            $classArr = School::getSchoolClassArr($sid);
        }

        //查出所有权限
        $allDuty = Duty::model()->findAll('deleted=:deleted', array(':deleted' => 0));
        $this->render('create', array('schools' => $schoolArr, 'sid' => $sid, 'allDuty' => $allDuty, 'dids' => $didArr,'subjects'=>$subjectArr,'classs'=>$classArr));
    }

    public function actionUpdate($id)
    {
        $teacherrelation = SchoolTeacherRelation::getTeachersSchoolRaletion($id);
        if (isset($_POST['Teacher'])) {
            $grade_id = isset($_POST['grade']) ? $_POST['grade'] : "";
            $cids=isset($_POST['cid']) ? $_POST['cid'] :array();
            $subjects=isset($_POST['subject']) ? $_POST['subject'] :array();
            $transaction = Yii::app()->db_member->beginTransaction();
            try {
                $member = Member::model()->loadByPk($id);
                $member->name = $_POST['Teacher']['name'];
                $member->mobilephone = $_POST['Teacher']['mobilephone']; //考虑下换成别的手机号码情况
                $member->state = 1;
                $member->save();
                //批量删除，再新增
                SchoolTeacherRelation::model()->deleteTeachersRelation($id);
                $sids = isset($_POST['sid']) ? $_POST['sid'] : array();
                $dids = isset($_POST['did']) ? $_POST['did'] : array();
                //去重判断
                $siddids = array();
                $sign = 0;
                for ($i = 0; $i < count($sids); $i++) {
                    if (!$sids[$i]) continue;
                    //新增的
                    if (!in_array('' . $sids[$i] . $dids[$i], $siddids)) {
                        $tempduty = isset($_POST['duty'][$i]) ? $_POST['duty'][$i] : "";
                        $oldrelation = SchoolTeacherRelation::getSchoolTeachersRelation(array('sid' => $sids[$i], 'teacher' => $id));
                        if (!$oldrelation) {
                            $model = new SchoolTeacherRelation;
                            $model->sid = $sids[$i];
                            $model->did = $dids[$i];
                            $duty = Duty::model()->findByPk($tempduty);
                            if ($duty && $duty->deleted == 0 && $duty->isseeallclass == 1) { //年级主任
                                $tempgrade = isset($grade_id[$sign]) ? $grade_id[$sign] : "";
                                $grade = Grade::model()->findByPk($tempgrade);
                                $sign++;
                                if ($grade && $grade->deleted == 0) {
                                    $model->stid = $grade->stid;
                                    $model->year = MainHelper::getClassYearByGradeAge($grade->age);
                                }
                                $model->duty = $tempduty;
                            } else {
                                $model->duty = $tempduty;
                            }
                            $model->state = 1;
                            $model->teacher = $id;
                            $model->save();
                        }
                        $siddids[] = '' . $sids[$i] . $dids[$i];
                    }
                }

                //老师班级处理
                $cidlen = count($cids);
                $new=array();
                $old=array();
                for($i=0;$i<$cidlen;$i++){
                    if($cids[$i]){
                        if($subjects[$i]==="0"){
                            $new[]=$cids[$i]."-".$subjects[$i]."-1";
                        }else{
                            $new[]=$cids[$i]."-".(int)$subjects[$i]."-0";
                        }
                    }

                }
                $myclassrelation=ClassTeacherRelation::getTeacherClassRelationByTeacher($id);
                foreach($myclassrelation as $val){
                    $old[]=$val->cid."-".(int)$val->sid."-".$val->type;
                }
                $adds=array_diff($new,$old); //要增加的
                $dels=array_diff($old,$new);//要删除的

                foreach($adds as $val){
                    $cidstr=explode("-",$val);//cid-sid-type
                    if($cidstr[2]==1){ //班主任
                        $mclass=MClass::model()->findByPk($cidstr[0]);
                        if($mclass){
                            $mclass->master=$id;
                            $mclass->save();
                        }
                        ClassTeacherRelation::updateOrCreateMaster($id, $cidstr[0]);
                    }else{
                        $classTeacherRelation = new ClassTeacherRelation;
                        $classTeacherRelation->cid=$cidstr[0];
                        $classTeacherRelation->teacher=$id;
                        $classTeacherRelation->state=1;
                        if($cidstr[1]==0){//科目为空情况
                            $list=ClassTeacherRelation::getTeacherSubject($cidstr[0],$id);//判斷老師和這個班級是否已有關係
                            if($list&&count($list)){

                            }else{
                                $classTeacherRelation->sid=null;
                                $classTeacherRelation->subject="";
                                $classTeacherRelation->save();
                            }
                        }else{
                            $data=ClassTeacherRelation::getTeacherSubjectByCidSid($cidstr[0],$cidstr[1]);
                            if($data){
                                $data->teacher=$id;
                                $data->save();
                            }else{
                                $classTeacherRelation->sid=$cidstr[1];
                                $subjectinfo=Subject::model()->findByPk($classTeacherRelation->sid);
                                $classTeacherRelation->subject=$subjectinfo?$subjectinfo->name:'';
                                $classTeacherRelation->save();
                            }
                        }

                    }
                }
                foreach($dels as $val){
                    $cidstr=explode("-",$val);//cid-sid-type

                    $classRelation=ClassTeacherRelation::deleteTeacherSubject($cidstr[0],$id,$cidstr[1]);
                    if($cidstr[2]==1){ //把班主任删除的情况
                        ClassTeacherRelation::deleteMaster($cidstr[0],$id);
                    }
                }
                $transaction->commit();
                Yii::app()->msg->postMsg('success', '修改老师成功');
                $this->redirect(array('index'));
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->msg->postMsg('error', '修改老师失败');
                $this->redirect(array('index'));
            }
        }
        // $schoolArr = School::getDataArr(true); //所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        $model = Member::model()->loadByPk($id);

        foreach ($teacherrelation as $k => $v) {
            if ($v['duty']) {
                $duty = Duty::model()->findByPk($v['duty']);
                if ($duty->isseeallclass == 1) {
                    $age = MainHelper::getGradeAge($v->year);
                    $stid = $v->stid;
                    $grade = Grade::getGradeInfo(array('stid' => $stid, 'age' => $age));
                    if ($grade) {
                        $teacherrelation[$k]['grade'] = $grade->name;
                        $teacherrelation[$k]['grade_id'] = $grade->gid;
                        $gradeArr = School::getSchoolGradesArr($v->sid);
                    } else {
                        $gradeArr = null;
                    }

                    $teacherrelation[$k]['gradeArr'] = $gradeArr;
                }
            }
            $teacherrelation[$k]->chooldeptarr = School::getSchoolDid($v->sid);
        }
        $classTeacherArr = ClassTeacherRelation::getTeacherClassRelationByTeacher($id);
       // $userid = Yii::app()->user->id;
        ///$schoolArr = UserAccess::getUserSchools($userid);
        $result = array();
        foreach($classTeacherArr as $key=>$val){
            $result[$key]['data'] =$val;
            $result[$key]['classs'] = School::getSchoolClassArr($val->c->sid);
            $result[$key]['subjects'] = School::getSchoolSubjectArr($val->c->sid);
        }
        $classs=array();
        $subjects=array();
        //查出所有权限
        $allDuty = Duty::model()->findAll('deleted=:deleted', array(':deleted' => 0));
        //查出所有年级
        $this->render('update', array('subjects'=>$subjects,'classs'=>$classs,'model' => $model,'schools'=>$schoolArr,'result'=>$result,'allDuty' => $allDuty, 'schools' => $schoolArr, 'relations' => $teacherrelation,'classTeacherArr'=>$classTeacherArr));
    }

    public function actionDelete()
    {
        $list = Yii::app()->request->getParam("list", 0);
        $ids = Yii::app()->request->getParam("ids", '');
        if ($ids) {
            $transaction = Yii::app()->db_member->beginTransaction();
            try {
                $idArr = explode(",", $ids);
                $num = 0;
                foreach ($idArr as $v) {
                    if ((int)$v) {
                        $success = Member::deleteMember($v);
                        if ($success) {
                            $num++;
                        }
                    }
                }

                $transaction->commit();
                if ($num > 0) {
                    Yii::app()->msg->postMsg('success', '删除老师成功');
                } else {
                    Yii::app()->msg->postMsg('error', '删除老师失败');
                }

                if ($list) {
                    $this->redirect(Yii::app()->createUrl("teacher/index"));
                } else {
                    $this->redirect($this->previousurl);
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->msg->postMsg('error', '删除老师失败');
                if ($list) {
                    $this->redirect(Yii::app()->createUrl("teacher/index"));
                } else {
                    $this->redirect($this->previousurl);
                }
            }
        } else {
            Yii::app()->msg->postMsg('error', '参数传入有错误,请重试');
            $this->redirect($this->previousurl);
        }
    }

    /*
     * 获取一个学校id,名称
     */
    private function getSchoolSidName($sids)
    {
        $result = array();
        if (is_array($sids)) {
            foreach ($sids as $sid) {
                $info = School::model()->findByPk($sid);
                if ($info && $info->deleted == 0) {
                    $result['sid'] = $info->sid;
                    $result['name'] = $info->name;
                    break;
                } else {
                    continue;
                }
            }
        }
        return $result;

    }

    //教师批量导入
    public function actionImportTeacher()
    {
        // $schoolArr = School::getDataArr(true); //所有学校
        $userid = Yii::app()->user->id;
        $schoolArr = UserAccess::getUserSchools($userid);
        
        if (isset($_FILES['batchfile'])) {
            $uid = Yii::app()->user->id;
            $schoolid = Yii::app()->request->getParam("schoolid", 0);
            if (empty($uid) || empty($schoolid)) {
                die(json_encode(array('status' => '2', 'msg' => '上传失败,参数有误'), JSON_UNESCAPED_UNICODE));
            }
            $t1 = array(); //手机格式错误
            $t2 = array(); //已存在手机行
            $t3 = array(); //职务不存在行
            $t4 = array(); //姓名为空错误行
            $t5 = array(); //手机号重复行
            $errNum = array(); //excel不符合条件的行数,
            $validnum = 0; //符合条件数目;
            $novalidnum = 0; //不符合条件数目
            $root = yii::app()->basePath;
            $dutyList = Duty::model()->findAll('deleted=:deleted', array(':deleted' => 0));
            $dutyArr=array();
            foreach($dutyList as $vv){
                $dutyArr[$vv->name]=$vv;
            }
            $gradeList=School::getSchoolClassArr($schoolid);
            $shoolmobileList = SchoolTeacherRelation::getSchoolTeacherMobilesArr($schoolid);
            $existsMobile = array();
            $notdutys = array();

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
            $notvalidmoble = 0;
            $dataArr = array();
            $mobileArr = array();
            $RegExp = '/^1\d{10}$/';
            for ($row = 2; $row <= $max; $row++) {
                $name = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $row)->getValue());
                $mobile = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $row)->getValue());
                $duty = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $row)->getValue());
                $grade = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $row)->getValue());
                if(empty($name)){
                    $t4[]=$row;
                }
                if (!preg_match($RegExp, $mobile)) {
                    if(!in_array($row,$t1)){
                    $notvalidmoble++;
                    $t1[] = $row; //手机格式
                    }
                }
                $isduty = false;
                if ($duty) {
                    if (!$this->inDuty($duty, $dutyList)) {
                        if(!in_array($row,$t3)){
                            $t3[] = $row; //职务不存在
                            $isduty = true;
                        }
                    }
                   $dutydata = isset($dutyArr[$duty])?$dutyArr[$duty]:'';

                   if($dutydata&&$dutydata->isseeallclass==1){
                        $isduty=true;
                        if(in_array($grade,$gradeList)){
                            $isduty=false;
                        }else{
                            $t3[] = $row; //职务不存在
                        }

                   }

                }
                if(in_array($mobile,$mobileArr)){
                    $t5[]=$row;
                }
                if (in_array($mobile, $shoolmobileList)) {
                    if(!in_array($row,$t3)){
                        $t2[] = $row;
                    }
                } else {
                    if (!in_array($mobile, $mobileArr) && $name && $mobile && preg_match($RegExp, $mobile) && !$isduty) {
                        $validnum++;
                        array_push($mobileArr, $mobile);
                        array_push($dataArr, array('name' => $name, 'mobile' => $mobile, 'grade' => $grade, 'duty' => $duty));
                    } else {
                        $novalidnum++;
                    }
                }
            }
            $cache = Yii::app()->cache;
            $cache->set("schoolid" . $schoolid . "teacherupload" . $uid, $dataArr);
            spl_autoload_register(array('YiiBase', 'autoload'));
            $errNums = !empty($errNum) ? implode(",", array_unique($errNum)) : ''; //哪些行错误
            die(json_encode(array('status' => '1', 'dutys' => $t3, 'mobiles' => $t2,'repeats'=>$t5,'names'=>$t4, 'mobileserr' => $t1, 'msg' => '上传成功', 'errNum' => $errNums, 'total'=>$row-2, 'filename' => $_FILES['batchfile']['name'], 'validnum' => $validnum, 'novalidnum' => $novalidnum)));
        }
        $this->render("importteacher", array('schools' => $schoolArr));
    }

    /*
     * 保存老师上传的数据
     */
    public function actionSaveexcel()
    {
        set_time_limit(0);
        $cache = Yii::app()->cache;
        $schoolid = isset($_POST['schoolid']) ? intval($_POST['schoolid']) : 0;
      //  $t1=microtime(true);
       // var_dump($t1);
        $uid = Yii::app()->user->id;
        $issendpwd = isset($_POST['issendpwd']) ? (int)$_POST['issendpwd'] : 0;
        $gradeList=Grade::getGradeData();
        $gradeArr=array();
        foreach($gradeList as $val){
            $gradeArr[$val->name]=$val;
        }
        $dutyList=Duty::getDutyList();
        $dutyArr=array();
        foreach($dutyList as $val){
            $dutyArr[$val->name]=$val;
        }
        if ($schoolid > 0) {
            $allData = $cache->get("schoolid" . $schoolid . "teacherupload" . $uid);
            $successNum = 0;
            if (empty($allData)) {
                // Yii::app()->msg->postMsg('error', '导入数据失败，上传内容为空，请检查导入是否导入数据或联系管理员');
                //   $this->render("importteacher", array());
                // exit();
            }
            if (is_array($allData)) {
                $msgArr = array();
                $transaction = Yii::app()->db_member->beginTransaction();
                try {
                    foreach ($allData as $val) {
                        $mobile = $val['mobile'];
                        if ($mobile) {
                            //根据手机判断该老师是否存在user表
                            $member = Member::getUniqueMember($mobile);
                            if ($member) {
                                //判断该老师跟当前的学校是否存在关系
                                $isInSchool = SchoolTeacherRelation::getSchoolTeachersRelation(array('sid' => $schoolid, 'teacher' => $member->userid));
                                if (!$isInSchool) {
                                    $schoolTeacher = new SchoolTeacherRelation;
                                    $schoolTeacher->sid = $schoolid;
                                    $schoolTeacher->teacher = $member->userid;
                                    $schoolTeacher->state = 1;
                                    $schoolTeacher->deleted = 0;
                                    $isduty = isset($val['duty']) ? $val['duty'] : "";
                                    if ($isduty) {
                                        //保存职务
                                        $duty =isset($dutyArr[$isduty])?$dutyArr[$isduty]:null;// Duty::model()->getDutyByName($isduty);
                                        if ($duty) {
                                            //判断是不是年级主任
                                            if ($duty['isseeallclass'] == 1) {
                                                //查询根据年级名字去查年级
                                                if ($val['grade']) {
                                                    $grade =isset($gradeArr[$val['grade']])?$gradeArr[$val['grade']]:null;
                                                    if ($grade) {
                                                        $schoolTeacher->year = MainHelper::getClassYearByGradeAge($grade->age);
                                                        $schoolTeacher->stid = $grade->stid;
                                                        $schoolTeacher->duty = $duty->dutyid;
                                                    } else {
                                                        //上传时候职务是年级主任但是所上传对应的年级在数据库中不存在
                                                        continue;
                                                    }
                                                } else {
                                                    //上传时候职务是年级主任却没有上传年级
                                                    continue;
                                                }
                                            } else {
                                                //不是年级主任
                                                $schoolTeacher->duty = $duty->dutyid;
                                            }
                                        } else {
                                            //改职务不存在
                                            continue;
                                        }
                                    } else {
                                      //  $schoolTeacher->duty = 0;
                                    }
                                    if ($schoolTeacher->save()) {
                                        //保存关系成功判断身份是否是老师，不是老师转换身份位老师
                                        if($member->identity==Constant::FAMILY_IDENTITY){
                                            $member->name=$val['name'];
                                        }
                                        $newIdentity = Member::transIdentity(Constant::TEACHER_IDENTITY, $member->identity);
                                        $member->identity = $newIdentity;
                                        $member->deleted = 0;
                                        $member->state = 1;
                                        $member->save();
                                        $successNum++;
                                    }
                                }
                            } else {
                                $user = new Member();
                                $user->name = $val['name'];
                                $user->mobilephone = $mobile;
                                $userid = UCQuery::makeMaxId(0, true);
                                $user->state = 1;
                                $user->userid = $userid;
                                $user->identity = Constant::TEACHER_IDENTITY; //默认老师身份;
                                $password = MainHelper::generate_code(6);
                                $user->account = "t" . $userid; //默认老师身份;
                                $user->pwd = MainHelper::encryPassword($password);
                                $user->issendpwd = (int)$issendpwd;
                                if ($user->save()) {
                                    $msgArr[] = array('mobile' => $mobile, 'password' => $password);
                                    $schoolTeacher = new SchoolTeacherRelation;
                                    $schoolTeacher->sid = $schoolid;
                                    $schoolTeacher->teacher = $userid;
                                    $schoolTeacher->state = 1;
                                    $schoolTeacher->deleted = 0;
                                    $isduty = isset($val['duty']) ? $val['duty'] : "";
                                    if ($isduty) {
                                        //保存职务
                                        //$duty = Duty::model()->getDutyByName($isduty);
                                        $duty =isset($dutyArr[$isduty])?$dutyArr[$isduty]:null;
                                        if ($duty) {
                                            //判断是不是年级主任
                                            if ($duty['isseeallclass'] == 1) {
                                                //查询根据年级名字去查年级
                                                if ($val['grade']) {
                                                    $grade =isset($gradeArr[$val['grade']])?$gradeArr[$val['grade']]:'';
                                                    if ($grade) {
                                                        $schoolTeacher->year = MainHelper::getClassYearByGradeAge($grade->age);
                                                        $schoolTeacher->stid = $grade->stid;
                                                        $schoolTeacher->duty = $duty->dutyid;
                                                    } else {
                                                        //上传时候职务是年级主任但是所上传对应的年级在数据库中不存在
                                                        continue;
                                                    }
                                                } else {
                                                    //上传时候职务是年级主任却没有上传年级
                                                    continue;
                                                }
                                            } else {
                                                //不是年级主任
                                                $schoolTeacher->duty = $duty->dutyid;
                                            }
                                        } else {
                                            //改职务不存在
                                            continue;
                                        }
                                    } else {
                                       // $schoolTeacher->duty = 0;
                                    }
                                    if ($schoolTeacher->save()) {
                                        $successNum++;
                                    }
                                }

                            }
                        }
                    }
                    $transaction->commit();
                  ///  $t2=microtime(true);
                    //var_dump($t2);
                   /// var_dump("speed:".($t2-$t1));die('aa');

                    $smscontent = isset($_POST['smscontent']) ?trim($_POST['smscontent']) : '';
                    if ($issendpwd) {
                        $isEditContent=true; //是否修改过短信内容
                        if($smscontent=="你好！感谢您使用".SITE_NAME."（".SITE_URL."）,平台有家校沟通丶成绩管理等功能，我们的手机客户端同时推出。您的账号:[xxxxxxxxxxx]，密码:[xxxxxx]。客服电话:4001013838，工作时间:08:00-20:00"){
                            $isEditContent=false;
                        }
                        if(!$isEditContent){
                            foreach ($msgArr as $val) {
                                UCQuery::sendMobilePasswordMsg($val['mobile'], $val['password']);
                            }
                        }else{
                            $isxxxx=preg_match('/\[x{11}\]/', $smscontent) && preg_match('/\[x{6}\]/', $smscontent);
                            foreach ($msgArr as $val) {
                                if ($isxxxx) {
                                    $str=$smscontent;
                                    $str = str_replace("[xxxxxxxxxxx]", $val['mobile'], $str);
                                    $code = str_replace("[xxxxxx]", $val['password'], $str);
                                    UCQuery::sendMobileMsg($val['mobile'], $code);
                                } else {
                                    UCQuery::sendMobilePasswordMsg($val['mobile'], $val['password']);
                                }
                            }
                        }
                    }
                    Yii::app()->msg->postMsg('success', '成功导入数据老师数据:' . $successNum . "条");
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::app()->msg->postMsg('error', '导入数据失败，请检查导入数据格式或联系管理员');
                }

                $url = Yii::app()->createUrl('teacher/index') . '?Teacher[sid]=' . $schoolid . "&Teacher[did]=&Teacher[name]=&Teacher[mobilephone]=&Teacher[duty]=";
                $this->redirect($url);
            }
        }
    }

    public function  actionGetgrade()
    {
        $schoolid = Yii::app()->request->getParam("schoolid", 0);
        $dutyid = Yii::app()->request->getParam("duty", 0);
        if (isset($schoolid)) {
            $duty = Duty::model()->findByPk($dutyid);
            if ($duty->deleted == 0 && $duty->isseeallclass == 1) { //职务是年级主任
                $gradeArr = School::getSchoolGradesArr($schoolid);

                if (is_array($gradeArr)) {
                    die(json_encode(array('state' => 1, 'gradeArr' => json_encode($gradeArr))));
                } else {
                    die(json_encode(array('state' => 0, 'msg' => '数据为空')));
                }
            } else {
                die(json_encode(array('state' => 0, 'msg' => '传入的职务不是年级主任')));
            }
        } else {
            die(json_encode(array('state' => 0, 'msg' => '传入的学校id不存在')));
        }
    }

    private function inDuty($duty, $dutyList)
    {
        $isExists = false;
        if (!empty($duty)) {
            foreach ($dutyList as $val) {
                if ($duty == trim($val->name)) {
                    $isExists = true;
                    break;
                }
            }
            return $isExists;
        }
    }


}