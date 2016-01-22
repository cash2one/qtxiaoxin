<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-29
 * Time: 下午3:37
 */

class ExamController extends Controller
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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'scheck', 'update', 'create', 'delete', 'save', 'edit', 'send', 'leave', 'export', 'import', 'saveexcel', 'level', 'send'),
                'users' => array('@'),
            ),

            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $uid = Yii::app()->user->id;
        $schoollist = SchoolTeacherRelation::getTeacherSchools($uid); //获取登陆老师的学校列表
        foreach ($schoollist as $k => $v) { //我每个学校下面的班级
            if(!NoticeService::checkMonitorRight($k,$uid,Constant::APPID13)){
                unset($schoollist[$k]);
                continue;
            }
        }
        $sids = array_keys($schoollist);
        $query = isset($_GET['Exam']) ? $_GET['Exam'] : array('sid' => '', 'cid' => '', 'subject' => '', 'type' => '', 'name' => '');
        $data = Exam::model()->pageData($query, $sids,$uid);
        $model = new Exam;
        $typeArr = Exam::getExamType();
        $this->render("index", array('model' => $model, 'data' => $data, 'schools' => $schoollist, 'types' => $typeArr, 'query' => $query));
    }

    public function actionCreate()
    {
        $uid = Yii::app()->user->id;
        $schoollist = SchoolTeacherRelation::getTeacherSchools($uid); //获取登陆老师的学校列表
        foreach ($schoollist as $k => $v) { //我每个学校下面的班级
            if(!NoticeService::checkMonitorRight($k,$uid,Constant::APPID13)){
                unset($schoollist[$k]);
                continue;
            }
        }
        $typeArr = Exam::getExamType();
        $termArr = MainHelper::getTermArr();
        if (isset($_POST['Exam'])) {
            // conlog($_POST['Exam']);
            $model = new Exam;
            $data = $_POST['Exam'];
            $model->attributes = $data;
            if (empty($data['class']) || empty($data['subject'])) {
                Yii::app()->msg->postMsg('error', '创建失败，班级和科目是必选项 ');
                $this->redirect(Yii::app()->createUrl('xiaoxin/exam/create'));
            }
            $classpks = implode(",", $data['class']); //保存班级id,2,3,4，这样逗号分隔
            $subjectpks = implode(",", $data['subject']); //保存科目id,2,3,4，这样逗号分隔
            $model->userid = $uid;
            $model->cid = $classpks;
            $model->sid = $subjectpks;
            $tempArr = explode(",", $subjectpks);
            $config = array(); //定义默认等级
            if (is_array($tempArr)) {
                foreach ($tempArr as $key => $val) {
                    $config[$val]['A']['low'] = '90';
                    $config[$val]['A']['height'] = '100';
                    $config[$val]['B']['low'] = '80';
                    $config[$val]['B']['height'] = '90';
                    $config[$val]['C']['low'] = '60';
                    $config[$val]['C']['height'] = '80';
                    $config[$val]['D']['low'] = '0';
                    $config[$val]['D']['height'] = '60';
                }
                $config = json_encode($config, JSON_UNESCAPED_UNICODE);
            }
            $model->config = $config;
            if ($model->save()) {
                Yii::app()->msg->postMsg('success', '创建成功');
                $this->redirect(Yii::app()->createUrl('xiaoxin/exam/index'));
            }
        }
        $this->render("create", array('schools' => $schoollist, 'types' => $typeArr, 'terms' => $termArr));
    }

    public function actionUpdate($id)
    {

        if (isset($_POST['Exam'])) {
            $id = $_POST['Exam']['eid'];

            $model = Exam::model()->loadByPk($id);
            $model->name = $_POST['Exam']['name'];
            $model->type = $_POST['Exam']['type'];
            $model->term = $_POST['Exam']['term'];
            if ($model->save()) {
                Yii::app()->msg->postMsg('success', '保存成功');
                $this->redirect(Yii::app()->createUrl('xiaoxin/exam/update/' . $id));
            } else {
                Yii::app()->msg->postMsg('error', '保存失败');
                $this->redirect(Yii::app()->createUrl('xiaoxin/exam/update/' . $id));
            }

        }
        if ($id > 0) {
            $examInfo = Exam::model()->loadByPk($id);
            $typeArr = Exam::getExamType();
            $termArr = MainHelper::getTermArr();
            $uid = Yii::app()->user->id;
            $schoolid = $examInfo->schoolid;
            //获取该老师，该学校下的班级
           // $classes = ClassTeacherRelation::getTeacherClassRelation($uid, $schoolid);
            $tmp = array();
            $cids = explode(",", $examInfo->cid);
            //剔除不是本次考试的班级
            foreach ($cids as $v) {
                    $class=MClass::model()->findByPk($v);
                    $tmp[] = $class;
            }
            $gcinfo = MClass::getGradeClassArr($tmp); //获取年级信息，年级下面的班级数组
            $subjects = Subject::getSubjectsBySchoolids($examInfo->schoolid);
            $examSubject = explode(",", $examInfo->sid);
            $subs = array();
            foreach ($subjects as $sk => $sv) {
                if (in_array($sk, $examSubject)) {
                    $subs[] = $sv; //获取本次考试 科目
                }
            }
            $this->render("update", array('model' => $examInfo, 'types' => $typeArr, 'terms' => $termArr, 'gcinfo' => $gcinfo, 'subs' => $subs, 'classes' => $tmp));
        }
    }

    public function actionDelete($id)
    {
        $exam = Exam::model()->loadBypk($id);
        $result = $exam->deleteMark();
        if ($result->deleted == 1) {
            Yii::app()->msg->postMsg('success', '删除成功');
            $this->redirect(Yii::app()->createUrl('xiaoxin/exam/index'));
        }
    }


    /*
     * 进入成绩查看,录入页面
     */
    public function actionEdit($id)
    {
        $uid = Yii::app()->user->id;
        $cid = (int)Yii::app()->request->getParam("cid"); //班级id
        $gid = (int)Yii::app()->request->getParam("gid"); //年级未用到了,ajax的
        $eid = $id;
        $isEdit = Yii::app()->request->getParam("isEdit", 0); //为1 表示进入编辑,默认为0，查看
        $isExport = Yii::app()->request->getParam("isExport", 0); //为1 表示导出考试学生的模板
        $typeArr = Exam::getExamType();
        $examInfo = Exam::model()->findByPk($id);
        if (!$examInfo) {
            Yii::app()->msg->postMsg('error', '考试不存在');
            $this->redirect("index");
            exit();
        }
        if ($examInfo->deleted == 1) {
            Yii::app()->msg->postMsg('error', '考试已删除');
            $this->redirect("index");
            exit();
        }
        $examTypeName = $typeArr[$examInfo->type];
        $schoolid = $examInfo->schoolid;
        $classes = MClass::getClassByCids($examInfo->cid);
        $tmp = $classes;

        $gcinfo = MClass::getGradeClassArr($tmp);
        $subjectList = Subject::getSubjects($examInfo->sid);
        $sids = explode(",", $examInfo->sid);
        //如果没传cid,默认取第一个年级下面的第一个班级
        if (empty($cid)) {
            $tmp = $gcinfo;
            $tmp1 = array_shift($tmp);
            if (is_array($tmp1['classes'])) {
                $cids = array_keys($tmp1['classes']);
                $cid = array_shift($cids);
            } else {
                $cid = 0;
            }
        }

        $classMan = array();
        if ($cid) {
            $classMan = ExamService::getClsssStudent($cid, $sids);
            $score = array();
            $evaluation = array();
            foreach ($sids as $sid) {
                $examAlone = ExamAlone::getExamAndAloneInfo($cid, $sid, $eid); //获取该班级，该考试下的单科
                if ($examAlone) {
                    $score[$sid] = ExamScore::getExamScoreByEaid($examAlone['eaid']); //获取该乎下的成绩
                }
            }
            $evaluation = ExamEvaluation::getExamEvaluation($eid); //获取考试下的评价
            foreach ($classMan as $k => $val) { //$val : 每一个学生的考试信息(userid,username,所有科目id,考评)
                foreach ($sids as $sid) { //循环所有该考试下在科目
                    $sc = isset($score[$sid]) ? $score[$sid] : array(); //取出每一个科目下所有学生的成绩
                    $classMan[$k][$sid] = isset($sc[$val['userid']]) ? $sc[$val['userid']] : '';
                }
                if (isset($evaluation[$val['userid']])) {
                    $classMan[$k]['evaluation'] = isset($evaluation[$val['userid']]) ? $evaluation[$val['userid']] : '';
                }
            }
        }

        //拼装学生、成绩数组为md5加密所用
        $sides = explode(",", $examInfo->sid);
        $scores = array();
        foreach ($sides as $sid) {
            foreach ($classMan as $val) {
                $tmp = array();
                $tmp['userid'] = $val['userid'];
                $tmp[$sid] = $val[$sid];
                $scores[$sid][] = $tmp;
            }
        }

        $relationArr = array();
        $md5Arr = array();
        $eaidinfoList = ExamAlone::getExamAloneList($id); //获取该考试下所有单科
        $eaids = array(); //取出所有该次考试下在所有成绩单eaid
        foreach ($eaidinfoList as $eeid) {
            $eaids[] = $eeid['eaid'];
        }
        if (count($eaids)) {
            $md5Arr = ExamAlone::getExamAndAloneInfo1(implode(",", $eaids)); //所有该次考试所有成绩单有关联的单科成绩单
        } else {
            $md5Arr = array();
        }

        //获取关联的考试
        if (is_array($md5Arr)) foreach ($md5Arr as $examAlone) {
            if ($examAlone['eid'] != $id) {
                $alone['eid'] = $examAlone['eid'];
                $examtmp = Exam::model()->findByPk($examAlone['eid']); //该成绩单关联在考试信息
                if ($examtmp && $examtmp['deleted'] == 0) {
                    $mclass = MClass::model()->findByPk($examAlone['cid']);
                    $alone['cid'] = $mclass['cid'];
                    $alone['cid_name'] = $mclass['name'] ? $mclass['name'] : '';
                    $alone['grade_name'] = MClass::getGradeNameByCid($gcinfo, $mclass['cid']);
                    $alone['sid'] = $examAlone['sid'];
                    $alone['eaid'] = $examAlone['eaid'];
                    $alone['exam_name'] = $examtmp['name'];
                    $alone['exam_type'] = Exam::getExamType()[$examtmp['type']];
                    $alone['sid_name'] = isset($subjectList[$examAlone['sid']]) ? $subjectList[$examAlone['sid']] : '';
                    $relationArr[] = $alone;
                }
            }
        }
        //下载模板
        if ($isExport) {
            $cids = explode(",", $examInfo->cid);
            foreach ($cids as $rowcid) {
                $class = '';
                $classInfo = MClass::model()->loadByPk($rowcid);
                $gradeName = MClass::getGradeNameByCid($gcinfo, $rowcid);
                $class = $gradeName . $classInfo->name;
                $excel_file = $examInfo->name . '学生成绩';
                $header = array("学生id(请勿修改id)", "学生姓名"); //excel表头
                $mclass = MClass::model()->loadByPk($cid);
                foreach ($sids as $sid) {
                    $header[] = $subjectList[$sid];
                }
                $header[] = '评价';
                $ceils = array();
                $classMan = array();
                $clsssStudent = ClassStudentRelation::getClassStudentsOrderbystudent($rowcid,"studentid");

                foreach ($clsssStudent as $student) {
                    $data = array("userid" => $student['student'], 'name' => $student['name']);
                    foreach ($sids as $sid) {
                        $data[$sid] = '';
                    }
                    $data['evaluation'] = '';
                    $classMan[] = $data;

                }
                $score = array();
                $evaluation = array();
                foreach ($sids as $sid) {
                    $examAlone = ExamAlone::getExamAndAloneInfo($rowcid, $sid, $eid);
                    if ($examAlone) {
                        $score[$sid] = ExamScore::getExamScoreByEaid($examAlone['eaid']);

                    }
                }
                $evaluation = ExamEvaluation::getExamEvaluation($eid);
                foreach ($classMan as $k => $val) {
                    foreach ($sids as $sid) {
                        $sc = isset($score[$sid]) ? $score[$sid] : array();
                        foreach ($sc as $ssk => $ssv) {
                            if ($ssk == $val['userid']) {
                                $classMan[$k][$sid] = $ssv;
                            }
                        }
                    }
                    if (isset($evaluation[$val['userid']])) {
                        $classMan[$k]['evaluation'] = isset($evaluation[$val['userid']]) ? $evaluation[$val['userid']] : '';
                    }
                }
                foreach ($classMan as $kk => $val) {
                    $row = array();
                    $row[] = $val['userid'];
                    $row[] = $val['name'];
                    foreach ($sids as $sid) {
                        if ($val[$sid] == 0 || $val[$sid] == null || $val[$sid] == "") {
                            $val[$sid] = '';
                        }
                        $row[] = $val[$sid];
                    }
                    $row[] = $val['evaluation'];
                    $ceils[] = $row;

                }
                $mclass = MClass::model()->loadByPk($rowcid);
                $excel_content [] = array(
                    'sheet_name' => $mclass->name . "-" . $mclass->cid,
                    'sheet_title' => $header,
                    'ceils' => $ceils,
                );

            }
            PHPExcelHelper::exportExcel($excel_content, $excel_file);
            exit();
        }

        if ($isEdit) {
            $this->render("edit", array('gid' => $gid, 'examTypeName' => $examTypeName, 'examAloneList' => $relationArr, 'examInfo' => $examInfo, 'gcinfo' => $gcinfo, 'id' => $id, 'cid' => $cid, 'sids' => $sids, 'classMan' => $classMan));
        } else {
            $this->render("score", array('gid' => $gid, 'examTypeName' => $examTypeName, 'examAloneList' => $relationArr, 'examInfo' => $examInfo, 'gcinfo' => $gcinfo, 'id' => $id, 'cid' => $cid, 'sids' => $sids, 'classMan' => $classMan));
        }
    }

    /*
     * 保存成绩
     */
    public function actionSave()
    {
        if (isset($_POST['data'])) {
            $transaction = Yii::app()->db_xiaoxin->beginTransaction();
            $eid = $_POST['eid'];
            $cid = $_POST['cid'];
            $data = $_POST['data'];
            $tt = array();
            $scoredata = json_decode($_POST['data'], true);
            try {
                $examInfo = Exam::model()->loadByPk($eid);
                $sids = explode(",", $examInfo->sid);
                $scores = array();
                $dataArr = array();
                $empty = array();
                foreach ($sids as $sid) {
                    $empty[$sid] = 0;
                    foreach ($scoredata as $val) {
                        if (isset($val[$sid])) {
                            if ($val[$sid] == '') {
                                $empty[$sid]++; //保存该科未录入成绩的记录数
                            }
                            //保存两位小数
//                            if(preg_match('/\./',$val[$sid])){
//                                $tmpVal =  explode(".",$val[$sid]);
//                                $val[$sid]=$tmpVal[0].".".(substr($tmpVal[1],0,2));
//                            }
                            $tmp = array(); //成绩数据，需要md5
                            $tmp1 = array(); //评语数据，不需要放到md5中，所以独立出来
                            $tmp['userid'] = $val['userid'];
                            $tmp[$sid] = isset($val[$sid]) ? (string)$val[$sid] : ''; //分数
                            //下面是评论,评论要独立出来，不
                            $tmp1['userid'] = $val['userid'];
                            $tmp1['evaluation'] = $val['evaluation'];
                            $scores[$sid][] = $tmp;
                            $dataArr[$sid][] = $tmp1;
                        }

                    }

                }

                foreach ($scores as $key => $val) {
                    $isempty = $empty[$key];
                    if ($isempty == count($val)) { //如果未录入成绩，不作处理
                        continue;
                    }
                    $md5 = md5(json_encode($val)); //对单科成绩md5
                    $examAlone = ExamAlone::getExamAndAloneInfo($cid, $key, $eid); //查看是否已存在单科成绩记录
                    $hasMd5 = ExamAlone::getExamAloneByMd5($md5); //获取数据库中相同的md5成绩单
                    if (!$examAlone) { //不存在该科记录,
                        if ($hasMd5) { //存在相同md5值在成绩单，将该成绩单与此次单科成绩单进行关联
                            $examAlone = $hasMd5;
                            if (!ExamAloneRelation::getRelationByEidEaid($eid, $hasMd5->eaid)) { //本次考试与该成绩单没关联的话在建立新的关系
                                $aloneRelation = new ExamAloneRelation;
                                $aloneRelation->eaid = $hasMd5->eaid;
                                $aloneRelation->eid = $eid;
                                $aloneRelation->save();
                            }
                        } else {
                            //不存在相同md5值在成绩单，新插入一条独立在单科成绩单
                            $examAlone = new ExamAlone;
                            $examAlone->collate = $md5;
                            $examAlone->sid = $key;
                            $examAlone->cid = $cid;
                            if ($examAlone->save()) {
                                //新插入的单科成绩单与考试建立关系
                                $aloneRelation = new ExamAloneRelation;
                                $aloneRelation->eaid = $examAlone->eaid;
                                $aloneRelation->eid = $eid;
                                $aloneRelation->save();
                            }
                        }
                    } else {
                        //存在该科记录,修改数据
                        //注意，上面的查出来的是数组
                        $examAlone = ExamAlone::model()->loadByPk($examAlone['eaid']);
                        $examAlone->collate = $md5;
                        if ($md5 == $hasMd5['collate']) { //修改后的数据md5与数据库其他的相同
                            if ($hasMd5['eaid'] != $examAlone->eaid) { //剔除自己,不关联自己
                                //修改后的这个成绩单与数据库其他的相同md5值相同的成绩单的考试建立关系，删除自己原先的关系
                                $aloneRelation = new ExamAloneRelation;
                                $aloneRelation->eaid = $hasMd5['eaid'];
                                $aloneRelation->eid = $eid;
                                $aloneRelation->save();
                                $examAlone->deleted = 1;
                                $examAlone->save();
                            }

                        } else {
                            //修改后的数据md5与数据库其他的不同
                            if ($examAlone->save()) {
                                if (!ExamAloneRelation::getRelationByEidEaid($eid, $examAlone->eaid)) {
                                    //之前不存在关系，建立新关系 （针对新插入的成绩），如果存在就不管他原先的关系只保存数据
                                    $aloneRelation = new ExamAloneRelation;
                                    $aloneRelation->eaid = $examAlone->eaid;
                                    $aloneRelation->eid = $eid;
                                    $aloneRelation->save();
                                }
                            }
                        }
                    }

                    //保存成绩到Tb_exam_score ， $examAlone：单科成绩单

                    foreach ($val as $v) { //$val :所有单科成绩单成绩以及学生userid,不包括考评
                        $examScore = ExamScore::getExamScoreByEaidAndUserid($examAlone->eaid, $v['userid']);
                        if (!$examScore) {
                            //之前不存在该学生成绩就插入新的成绩
                            $examScore = new ExamScore;
                            $examScore->userid = $v['userid'];
                            $examScore->score = $v[$key]; //$key :外层循环的键值，每个科目id
                            $examScore->eaid = $examAlone->eaid;
                            $examScore->save();
                        } else {
                            //之前存在该学生成绩就修改成绩
                            if ($v[$key] == '') {
                                $examScore->deleted = 1;
                                $examScore->save();
                            } else {
                                $examScore->score = $v[$key]; //$key :外层循环的键值，每个科目id
                                $examScore->save();
                            }
                        }
                    }
                }

                //保存评价到Tb_exam_evaluation evaluation,$dataArr保存的userid,evaluation
                foreach ($dataArr as $key => $v) {
                    //先判断是否已存在
                    foreach ($v as $kk => $vv) {
                        $examEvaluation = ExamEvaluation::getUserExamEvaluation($eid, $vv['userid']);
                        if (!$examEvaluation) {
                            $examEvaluation = new ExamEvaluation();
                        }
                        $examEvaluation->userid = $vv['userid'];
                        $examEvaluation->evaluation = $vv['evaluation'];
                        $examEvaluation->eid = $eid; // eaid
                        $examEvaluation->save();
                    }

                }
                $transaction->commit();

                //查询关联的考试
                $relationArr = array();
                $uid = Yii::app()->user->id;
                $examInfo = Exam::model()->loadByPk($eid);
                $schoolid = $examInfo->schoolid;
                $classes = ClassTeacherRelation::getTeacherClassRelation($uid, $schoolid);
                $tmp = array();
                $cids = explode(",", $examInfo->cid);
                foreach ($classes as $v) {
                    if (in_array($v->cid, $cids)) {
                        $tmp[] = $v;
                    }
                }
                $gcinfo = MClass::getGradeClassArr($tmp); //所有年级以及班级
                $subjectList = Subject::getSubjects($examInfo->sid); //所有科目对象
                $eaidinfoList = ExamAlone::getExamAloneList($eid); //获取该次考试下所有单科成绩单
                $eaids = array();
                foreach ($eaidinfoList as $eeid) {
                    $eaids[] = $eeid['eaid'];
                }
                if (count($eaids)) {
                    $md5Arr = ExamAlone::getExamAndAloneInfo1(implode(",", $eaids));
                } else {
                    $md5Arr = array();
                }
                if (is_array($md5Arr)) foreach ($md5Arr as $examAlone) {
                    if ($examAlone['eid'] != $eid) { //剔除自身关联
                        $alone['eid'] = $examAlone['eid'];
                        $examtmp = Exam::model()->findByPk($examAlone['eid']);
                        if ($examtmp && $examtmp['deleted'] == 0) {
                            $mclass = MClass::model()->findByPk($examAlone['cid']);
                            $alone['cid'] = $mclass['cid'];
                            $alone['cid_name'] = $mclass['name'] ? $mclass['name'] : '';
                            $alone['grade_name'] = MClass::getGradeNameByCid($gcinfo, $mclass['cid']);
                            $alone['eaid'] = $examAlone['eaid'];
                            $alone['exam_name'] = $examtmp['name'];
                            $alone['exam_type'] = Exam::getExamType()[$examtmp['type']];
                            $alone['sid_name'] = isset($subjectList[$examAlone['sid']]) ? $subjectList[$examAlone['sid']] : '';
                            $relationArr[] = $alone;
                        }
                    }
                }
                die(json_encode(array('status' => '1', 'msg' => '保存成功', 'sids' => $sids, 'cid' => $cid, 'relation' => $relationArr)));
            } catch (Exception $e) {
                $transaction->rollback();
                die(json_encode(array('status' => '0', 'msg' => '保存失败')));
            }
        }
    }

    /*
     * 脱离关系
     */
    public function actionLeave()
    {
        $eaid = (int)Yii::app()->request->getParam('eaid'); //是要脱离的那个考试的成绩单eaid
        $eid = (int)Yii::app()->request->getParam('eid'); //要脱离的那个考试的eid
        $oldEid = (int)Yii::app()->request->getParam('oldEid'); //本次考试的成绩eid
        $transaction = Yii::app()->db_xiaoxin->beginTransaction();
        try {
            //复制新的单科成绩单 、成绩，给本次考试的单科成绩使用
            $examAlone = ExamAlone::model()->loadByPk($eaid);
            $examScoreList = ExamScore::getScoreByEaid($eaid);
            //复制成绩单
            $newExamAlone = new ExamAlone;
            $newExamAlone->cid = $examAlone->cid;
            $newExamAlone->sid = $examAlone->sid;
            $newExamAlone->collate = $examAlone->collate;
            if ($newExamAlone->save()) {
                //复制成绩
                foreach ($examScoreList as $val) {
                    $examScore = new ExamScore;
                    $examScore->userid = $val->userid;
                    $examScore->score = $val->score;
                    $examScore->eaid = $newExamAlone->eaid;
                    $examScore->save();
                }
                //新成绩单与本次考试$oldEid建立关系
                $newRelation = new ExamAloneRelation;
                $newRelation->eaid = $newExamAlone->eaid;
                $newRelation->eid = $oldEid;
                $newRelation->save();
            }
            //脱离旧关系
            $oldRelation = ExamAloneRelation::getRelationByEidEaid($oldEid, $eaid);
            if($oldRelation){
                $oldRelation->deleted = 1;
                $oldRelation->save();
            }
            $transaction->commit();
            die(json_encode(array('status' => '1', 'msg' => '脱离成功')));
        } catch (Exception $e) {
            $transaction->rollback();
            die(json_encode(array('status' => '0', 'msg' => '脱离失败')));
        }
    }

    //导出成绩,同保存成绩差不多
    public function actionImport($id)
    {
        $eid=$id;
        $examInfo = Exam::model()->loadByPk($id); //$id :本次考试成绩的eid
        $sids = explode(",", $examInfo->sid);
        $subjectList = Subject::getSubjects($examInfo->sid);
        $schoolid = $examInfo->schoolid;
        $uid = Yii::app()->user->id;
        $cids = explode(",", $examInfo->cid);
        $isExport = Yii::app()->request->getParam("isExport", 0);
        if ($isExport) {
            $cids = explode(",", $examInfo->cid);
            foreach ($cids as $rowcid) {
                $class = '';
                $classInfo = MClass::model()->loadByPk($rowcid);
                $gradeName = MClass::getGradeNameByCid($gcinfo, $rowcid);
                $class = $gradeName . $classInfo->name;
                $excel_file = $examInfo->name . '学生成绩';
                $header = array("学生姓名");
                foreach ($sids as $sid) {
                    $header[] = $subjectList[$sid];
                }
                $header[] = '评价';
                $ceils = array();
                $classMan = array();
                $clsssStudent = ClassStudentRelation::getClassStudents($rowcid);
                foreach ($clsssStudent as $student) {
                    $data = array("userid" => $student->student, 'name' => $student->student0->name);
                    foreach ($sids as $sid) {
                        $data[$sid] = '';
                    }
                    $data['evaluation'] = '';
                    $classMan[] = $data;

                }

                $score = array();
                $evaluation = array();
                foreach ($sids as $sid) {
                    $examAlone = ExamAlone::getExamAndAloneInfo($rowcid, $sid, $eid);
                    if ($examAlone) {
                        $score[$sid] = ExamScore::getExamScoreByEaid($examAlone['eaid']);

                    }
                }
                $evaluation = ExamEvaluation::getExamEvaluation($eid);
                foreach ($classMan as $k => $val) {
                    foreach ($sids as $sid) {
                        $sc = isset($score[$sid]) ? $score[$sid] : array();
                        foreach ($sc as $ssk => $ssv) {
                            if ($ssk == $val['userid']) {
                                $classMan[$k][$sid] = $ssv;
                            }
                        }
                    }
                    if (isset($evaluation[$val['userid']])) {
                        $classMan[$k]['evaluation'] = isset($evaluation[$val['userid']]) ? $evaluation[$val['userid']] : '';
                    }
                }
                foreach ($classMan as $kk => $val) {
                    $row = array();
                    $row[] = $val['name'];
                    foreach ($sids as $sid) {
                        $row[] = $val[$sid];
                    }
                    $row[] = $val['evaluation'];
                    $ceils[] = $row;

                }

                $excel_content [] = array(
                    'sheet_name' => $classInfo->name,
                    'sheet_title' => $header,
                    'ceils' => $ceils,
                );

            }
            PHPExcelHelper::exportExcel($excel_content, $excel_file);
            exit();
        }
        $this->render('import', array('id' => $id, 'examInfo' => $examInfo));
    }

    /*
     * 导入成绩页面
     */
    public function actionScheck()
    {
        $id = Yii::app()->request->getParam('id');
        $examInfo = Exam::getExamByEid($id);
        $this->render('import', array('id' => $id, 'examInfo' => $examInfo));
    }

    /*
     * 将导入的数据保存到excel,先放到cache中，再保存到数据库
     */
    public function actionSaveexcel()
    {
        //将数据从cache取出保存到数据库操作
        $uid = Yii::app()->user->id;
        $eid = Yii::app()->request->getParam("id", 0);
        $id = $eid;
        $cache = Yii::app()->cache;
        $allData = $cache->get("exam" . $eid . "examscoreupload" . $uid);

        //过滤上传空的成绩单
        $xss = array();
        foreach ($allData as $key => $val) {
            foreach ($val as $k => $v) {
                foreach ($v as $a => $b) {
                    if ($a == 'userid') {
                    } else if ($a == 'name') {
                    } else if ($b != null) {
                        $xss[] = $b;
                    }
                }
            }
        }
        if (empty($xss)) {
            Yii::app()->msg->postMsg('error', '上传成绩单为空,请检查');
            $url = $this->createUrl('exam/edit');
            $url = $url . "/" . $eid . "?isEdit=1";
            $this->redirect($url);
        }
        if (isset($allData)) {
            $transaction = Yii::app()->db_xiaoxin->beginTransaction();
            try {
                foreach ($allData as $kkey => $vval) {
                    $cid = $kkey;
                    $scoredata = $vval;
                    $tt = array();
                    $tmpsid = array();
                    $examInfo = Exam::model()->loadByPk($id);
                    $sids = explode(",", $examInfo->sid);
                    $scores = array();
                    $dataArr = array();
                    $empty = array();
                    foreach ($sids as $sid) {
                        $empty[$sid] = 0;
                        foreach ($scoredata as $val) {
                            //   if (isset($val[$sid])) {    //注释为了，导入空数据时候可以覆盖之前已有数据
                            if ($val[$sid] == "") {
                                $empty[$sid]++;
                            }
//                                if(preg_match('/\./',$val[$sid])){
//                                    $tmpVal =  explode(".",$val[$sid]);
//                                    $val[$sid]=$tmpVal[0].".".(substr($tmpVal[1],0,2));
//                                }
                            $tmp = array();
                            $tmp1 = array();
                            $tmp['userid'] = (string)$val['userid'];
                            $tmp[$sid] = isset($val[$sid]) ? $val[$sid] : null; //分数
                            $tmp[$sid] = (string)$tmp[$sid];
                            //下面是评论
                            $tmp1['userid'] = $val['userid'];
                            $tmp1['evaluation'] = $val['evaluation'];
                            $scores[$sid][] = $tmp;
                            $dataArr[$sid][] = $tmp1;
                            //  }
                        }
                    }
                    foreach ($scores as $key => $val) {
                        $isempty = $empty[$key];
                        if ($isempty == count($val)) {
                            continue;
                        }
                        $md5 = md5(json_encode($val));
                        $examAlone = ExamAlone::getExamAndAloneInfo($cid, $key, $eid);
                        $hasMd5 = ExamAlone::getExamAloneByMd5($md5);
                        if (!$examAlone) {
                            if ($hasMd5) {
                                $examAlone = $hasMd5;
                                if (!ExamAloneRelation::getRelationByEidEaid($eid, $hasMd5->eaid)) {
                                    $aloneRelation = new ExamAloneRelation;
                                    $aloneRelation->eaid = $hasMd5->eaid;
                                    $aloneRelation->eid = $eid;
                                    $aloneRelation->save();
                                }

                            } else {
                                $examAlone = new ExamAlone;
                                $examAlone->collate = $md5;
                                $examAlone->sid = $key;
                                $examAlone->cid = $cid;
                                if ($examAlone->save()) {
                                    $aloneRelation = new ExamAloneRelation;
                                    $aloneRelation->eaid = $examAlone->eaid;
                                    $aloneRelation->eid = $eid;
                                    $aloneRelation->save();
                                }
                            }
                        } else {
                            //注意，上面的查出来的是数组
                            $examAlone = ExamAlone::model()->loadByPk($examAlone['eaid']);
                            $examAlone->collate = $md5;
                            if ($md5 == $hasMd5['collate']) {
                                if ($hasMd5['eaid'] != $examAlone->eaid) {
                                    $aloneRelation = new ExamAloneRelation;
                                    $aloneRelation->eaid = $hasMd5['eaid'];
                                    $aloneRelation->eid = $eid;
                                    $aloneRelation->save();
                                    $examAlone->deleted = 1;
                                    $examAlone->save();
                                }
                            } else {
                                if ($examAlone->save()) {
                                    if (!ExamAloneRelation::getRelationByEidEaid($eid, $examAlone->eaid)) {
                                        $aloneRelation = new ExamAloneRelation;
                                        $aloneRelation->eaid = $examAlone->eaid;
                                        $aloneRelation->eid = $eid;
                                        $aloneRelation->save();
                                    }
                                }
                            }
                        }

                        foreach ($val as $v) {
                            //保存成绩到Tb_exam_score
                            $examScore = ExamScore::getExamScoreByEaidAndUserid($examAlone->eaid, $v['userid']);

                            if (!$examScore) {
                                $examScore = new ExamScore;
                                $examScore->userid = $v['userid'];
                                $examScore->score = $v[$key];
                                $examScore->eaid = $examAlone->eaid; // eaid
                                $examScore->save();
                            } else {
                                // error_log(json_encode($v));
                                if ($v[$key] == '') { //为空则删除原来的,score必须为float
                                    $examScore->deleted = 1;
                                    $examScore->save();
                                } else {
                                    $examScore->score = $v[$key];
                                    $examScore->save();
                                }
                            }
                        }
                    }
                    foreach ($dataArr as $key => $v) {
                        //保存评价到Tb_exam_evaluation evaluation
                        //先判断是否已存在
                        foreach ($v as $kk => $vv) {
                            $examEvaluation = ExamEvaluation::getUserExamEvaluation($eid, $vv['userid']);
                            if (!$examEvaluation) {
                                $examEvaluation = new ExamEvaluation();
                            }
                            $examEvaluation->userid = $vv['userid'];
                            $examEvaluation->evaluation = $vv['evaluation'];
                            $examEvaluation->eid = $eid; // eaid
                            $examEvaluation->save();
                        }
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
               // error_log("message:" . $e->getMessage());
                $transaction->rollback();
                //  die(json_encode(array('status' => '0', 'msg' => '保存失败')));
            }

            Yii::app()->msg->postMsg('success', '导入成功');
            $url = $this->createUrl('exam/edit');
            $url = $url . "/" . $eid . "?isEdit=1";
            $this->redirect($url);
        }
        Yii::app()->msg->postMsg('error', '导入失败');
        $url = $this->createUrl('exam/edit');
        $url = $url . "/" . $eid . "?isEdit=1";
        $this->redirect($url);
    }


    /*
     * 考试等级
     */
    public function actionLevel()
    {
        $eid = isset($_POST['eid']) ? $_POST['eid'] : '';
        $confighidden = isset($_POST['confighidden']) ? $_POST['confighidden'] : array();
        $config = isset($_POST['config']) ? $_POST['config'] : array(); //接收过来的json等级
        if (empty($config)) {
            $temp = array();
            foreach ($confighidden as $key => $val) {
                $temp[$val] = array();
            }
            $config = json_encode($temp, JSON_UNESCAPED_UNICODE);
        } else {
            $config = json_encode($config, JSON_UNESCAPED_UNICODE);
        }
        if (isset($config)) {
            $exam = Exam::model()->loadByPk($eid);
            $exam->config = $config;
            if ($exam->save()) {
                Yii::app()->msg->postMsg('success', '设置成功');
            } else {
                Yii::app()->msg->postMsg('error', '设置失败');
            }
            $this->redirect(Yii::app()->createUrl('xiaoxin/exam/send?eid=' . $eid));
        }
    }


    //发送考试成绩单
    public function actionSend()
    {
        $eid = (int)Yii::app()->request->getParam('eid');
        $cid = (int)Yii::app()->request->getParam("cid");
        $exam = Exam::model();
        /*
         * 发送操作
         */
        if (isset($_POST['cids']) && isset($_POST['eid'])) {
            $cids = $_POST['cids']; //所有班级id,数组
            $eid = $_POST['eid']; //考试id
            $id = $eid;
            $level = isset($_POST['level']) ? (int)$_POST['level'] : 1; //发送分数还是等级,1为发送分数，2为发送等级(A,B,CD)
            $ave = isset($_POST['ave']) ? (int)$_POST['ave'] : 0; //是否发送班级平均分
            $eval = isset($_POST['evaluation']) ? (int)$_POST['evaluation'] : 0; //是否发送考评
            $isok = isset($_POST['isok']) ? (int)$_POST['isok'] : 0; //是否给家长发送成绩单短信
            $isSendsms = isset($_POST['isSendsms']) ? (int)$_POST['isSendsms'] : 0; //是否给自己发送确认短信
            $examInfo = $exam->loadByPk($eid);
            $classArr = array(); //获取本次考试 所有班级名称数组
            $classList = MClass::getClassByCids(implode(",", $cids));
            foreach ($classList as $classInfo) {
                $classArr[$classInfo->cid] = $classInfo->name;
            }
            $config = json_decode($examInfo->config, true);
            $allData = array();
            if (is_array($cids)) {
                $sids = explode(",", $examInfo->sid);
                $score = array(); //保存每科的所有成绩
                $evaluation = array(); //保存评价
                $classMan = array(); // 保存所有学生信息
                $emptyScoresCidNum = 0;
                $evaluation = ExamEvaluation::getExamEvaluation($eid);
                foreach ($cids as $key => $cid) {
                    $clsssStudent = ClassStudentRelation::getClassStudents($cid); //获取该班级学生数据
                    foreach ($sids as $sid) {
                        $examAlone = ExamAlone::getExamAndAloneInfo($cid, $sid, $eid);
                        if ($examAlone) {
                            $score[$cid . '-' . $sid] = ExamScore::getExamScoreByEaid($examAlone['eaid']);
                            if (empty($score[$cid . '-' . $sid])) {
                                $emptyScoresCidNum++; //未录入成绩的班级科目数
                            }
                        }else{
                            $emptyScoresCidNum++; //未录入成绩的班级科目数
                        }
                    }

                    foreach ($clsssStudent as $student) {
                        $data = array("userid" => $student->student, 'name' => $student->student0->name, 'cid' => $cid);
                        foreach ($sids as $sid) {
                            $data[$sid] = '';
                        }
                        if ($eval == 1) { //如果选了考评
                            $data['evaluation'] = '';
                        }
                        $classMan[] = $data;
                    }
                }
                $totalEaid=(count($cids))*(count($sids));
                if($emptyScoresCidNum==$totalEaid){
                    Yii::app()->msg->postMsg('error', '发送失败,还未录入成绩');
                    $this->redirect(Yii::app()->createUrl('xiaoxin/exam/send') . '?eid=' . $eid);
                    exit();
                }

                //计算班级平均分
                $avgscore = array();
                foreach ($score as $cidsid => $aa) {
                    $avgscore[$cidsid] = ExamService::average($aa);
                }
                $exam_sid_num=array();//保存每科参考人数
                foreach ($classMan as $k => $val) {
                    $emptyscore=0;
                    foreach ($sids as $sid) {
                        $sc = isset($score[$val['cid'] . '-' . $sid]) ? $score[$val['cid'] . '-' . $sid] : array();
                        $classMan[$k][$sid] = isset($sc[$val['userid']]) ? $sc[$val['userid']] : '';
                        if(isset($sc[$val['userid']])){
                            $exam_sid_num[$sid]=isset($exam_sid_num[$sid])?($exam_sid_num[$sid]+1):1;
                        }
                    }
                   $classMan[$k]['evaluation'] = isset($evaluation[$val['userid']]) ? $evaluation[$val['userid']] : '';
                }


                $successNum = 0;
                //每个学生发一个成绩
                $userinfo = Yii::app()->user->getInstance();
                $exam = Exam::model()->loadByPk($eid);
                $examType = Exam::getExamType();
                $sidnum = count($sids);
                $text=array();
                $config1 = json_decode($exam->config, true);
                $configsend=ExamService::generateExamConfig($config1); //这个是用来给客户端的 显示100>=A>90,....
                foreach ($classMan as $k => $user) {
                    $success = false;
                    $data = array();
                    $uid = Yii::app()->user->id;
                    $data['uid'] = $uid; //发布者
                    $data['sendertitle'] = $userinfo->name; //发送者签名
                    $data['receiver'] = json_encode(array("5" => $user['userid'])); //接收人集合
                    $data['noticeType'] = 5; //通知类型
                    $data['isSendsms'] = 1;//$isSendsms; //是否转短信

                    $data['receiveTitle'] = "xxx"; //接收者称呼
                    $data['fixed_time'] = ''; //定时发送时间
                    $data['receivename'] = ""; //接收人名称集合();
                    $data['receivename'] = $user['name'];
                    $data['sid'] = (int)$exam->schoolid; //学校id
                    $data['uname'] = $userinfo->name; //发送人真实姓名
                    $schoolModel = School::model()->loadByPk($exam->schoolid);
                    $str = "学校： \t" . $schoolModel->name . "\r\n  班级： \t" . $classArr[$user['cid']] . "\r\n学期：\t" . $examInfo->term . "\r\n 考试类型：\t" . $examType[$examInfo->type] . "\r\n  考试名称：\t" . $examInfo->name . "\r\n";
                    $subjectList = Subject::getSubjects($examInfo->sid);
                    $sids = explode(",", $examInfo->sid);;
                    $str .= "\r\n（成绩通知单）\r\n  姓名：\t  " . $user['name'] . "\t ";
                    $nullsid = 0;
                    $scorestr = "";
                    $empty = 0;
                    $text['name']=$exam->name;

                    $menu_score=array();
                    $menu=array();
                    foreach ($sids as $mysid) {
                        $menu_score[$mysid]['subject']=$subjectList[$mysid];
                        $menu_score[$mysid]['score']=isset($user[$mysid])?$user[$mysid]:'缺考';
                        $sidconfig = isset($config[$mysid]) ? $config[$mysid] : array();
                        $levelName = ExamService::getLevelNameByScore($user[$mysid], $sidconfig);
                        $menu_score[$mysid]['level']=$levelName;
                        if ($level == 1) { //分数
                            if ($user[$mysid] == "" || $user[$mysid] == '缺考') {
                                $empty++;
                            }
                            $str .= $subjectList[$mysid] . " ：\t  " . ($user[$mysid] == '' ? '缺考' : $user[$mysid]) . " \t ";
                        } else { //等级
                            if (!$user[$mysid] || $user[$mysid] == '缺考') {
                                $empty++;
                            }
                            if ($user[$mysid]) {
                                $scorestr .= $subjectList[$mysid] . " ：\t  " . $levelName . " \t ";
                            }
                        }
                    }

                    $str .= $scorestr;
                    if ($eval == 1) {
                        $str .= " 考评：\t" . $user['evaluation'];

                    }
                    $text['evaluation']= $user['evaluation'];

                        if($ave) $str .= "\r\n班级平均分：\t";
                        foreach ($sids as $mysid) {
                            $menu_item=array();
                            if (isset($user[$mysid])) {
                                if ($user[$mysid] !== '' && $user[$mysid] != '缺考') {
                                    if (isset($avgscore[$user['cid'] . '-' . $mysid]) && $avgscore[$user['cid'] . '-' . $mysid]) {
                                        if($ave) { $str .= $subjectList[$mysid] . "：\t" . (isset($avgscore[$user['cid'] . '-' . $mysid]) ? $avgscore[$user['cid'] . '-' . $mysid] : '') . "\t  ";}
                                    }
                                }
                                //以下是给客户端用的，保存在content中的text中
                                $menu_item['average']=isset($avgscore[$user['cid'] . '-' . $mysid]) ? $avgscore[$user['cid'] . '-' . $mysid] : '';
                                $menu_item['config']=isset($configsend[$mysid])?$configsend[$mysid]:'';
                                $menu_item['subject']=isset($menu_score[$mysid]['subject'])?$menu_score[$mysid]['subject']:'';
                                if ($level == 1) { //分数
                                    $menu_item['score']=isset($menu_score[$mysid]['score'])?$menu_score[$mysid]['score']:'缺考';
                                    if($menu_item['score']===''){
                                        $menu_item['score']='缺考';
                                    }
                                    $menu_item['level']='';
                                }else{
                                    $menu_item['score']='';
                                    $menu_item['level']=isset($menu_score[$mysid]['level'])?$menu_score[$mysid]['level']:'';
                                }
                                $menu_item['examnum']=isset($exam_sid_num[$mysid])?$exam_sid_num[$mysid]:0;
                               // $menu_item['level']=isset($menu_score[$mysid]['level'])?$menu_score[$mysid]['level']:'';
                                $menu[]=$menu_item;
                            }
                        }
                    $text['examtype']=isset($examType[$examInfo->type])?$examType[$examInfo->type]:'';//考试类型
                    $text['term']=$examInfo->term;//学期
                    $text['showtype']=$level;//显示类型  1--分数，2--级别
                    $text['classname']=$classArr[$user['cid']];//班级
                    $text['eval']=(int)$eval; //是否显示考评
                    $text['showave']=(int)$ave; //是否显示班级平均分
                    $text['studentname']=$user['name'];
                    $text['exam']=$menu;
                    $data['data'] = json_encode(array('content' => $str,'text'=>$text), JSON_UNESCAPED_UNICODE);
                    $success = NoticeQuery::publishNotice($data, $uid, 0);
                    if ($success) {
                        $successNum++;
                    }
                }

            }
            if ($successNum > 0) {
                if ($isok) { //是否给自己发确认短信
                    $mobile = $userinfo->mobilephone;
                    if (!empty($mobile)) {
                        $recver = implode(",", $classArr);
                        $code = '你于:' . date("Y-m-d H:i:s") . '发布:' . $exam->term . "," . $examType[$examInfo->type] . "," . $exam->name . Constant::getNoticeTypeById(5) . ",接收对象为:" . $recver;
                        UCQuery::sendQtxxMsg($mobile,$code);
                    }
                }
                Yii::app()->msg->postMsg('success', '发送成功');
            } else {
                Yii::app()->msg->postMsg('error', '发送失败');
            }
            $this->redirect(Yii::app()->createUrl('xiaoxin/exam/send') . '?eid=' . $eid);
            //发送结束
        }

        /*
             跳转到成绩发送页面
         */
        //等级
        $config = array();
        if (isset($eid)) {
            $exam = $exam->loadByPk($eid);
            $config = json_decode($exam->config, true);
        }
        //成绩单
        $id = $eid;
        $typeArr = Exam::getExamType();
        $examInfo = Exam::model()->loadByPk($id);
        $examTypeName = $typeArr[$examInfo->type];
        $uid = Yii::app()->user->id;
        $schoolid = $examInfo->schoolid;
        $classes = MClass::getClassByCids($examInfo->cid);
        $tmp = $classes;
        $gcinfo = MClass::getGradeClassArr($tmp);
        $subjectList = Subject::getSubjects($examInfo->sid);
        $sids = explode(",", $examInfo->sid);
        $eid = $id;
        $avg = array();
        //未传入班级，默认第一个年级下面第一个班级
        if (empty($cid)) {
            $tmp = $gcinfo;
            $tmp1 = array_shift($tmp);
            if (is_array($tmp1['classes'])) {
                $cids = array_keys($tmp1['classes']);
                $cid = array_shift($cids);
            } else {
                $cid = 0;
            }
        }
        $classMan = array();
        if ($cid) {
            $classMan = ExamService::getClsssStudent($cid, $sids);
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
            //获取该考试下所有学生评价
            $evaluation = ExamEvaluation::getExamEvaluation($eid);
            $config = json_decode($examInfo->config, true);
            foreach ($classMan as $k => $val) {
                foreach ($sids as $sid) {
                    $sidconfig = isset($config[$sid]) ? $config[$sid] : array();
                    $sc = isset($score[$sid]) ? $score[$sid] : array();
                    $classMan[$k][$sid] = isset($sc[$val['userid']]) ? $sc[$val['userid']] : '';
                    $levelName = ExamService::getLevelNameByScoreShow($classMan[$k][$sid], $sidconfig);
                    $classMan[$k][$sid] .= ($levelName) ? ('（' . $levelName . '）') : '';
                }
                if (isset($evaluation[$val['userid']])) {
                    $classMan[$k]['evaluation'] = isset($evaluation[$val['userid']]) ? $evaluation[$val['userid']] : '';
                }
            }
        }



        $mysids=array($examInfo->schoolid);
        $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,Constant::NOTICE_TYPE_5);
        $this->render("send", array("score" => $avg, "config" => $config, 'isshowsendsms'=>$isshowsendsms,'model' => $exam, 'examTypeName' => $examTypeName,
            'examInfo' => $examInfo, 'gcinfo' => $gcinfo, 'id' => $id, 'cid' => $cid, 'sids' => $sids, 'classMan' => $classMan));
    }
}