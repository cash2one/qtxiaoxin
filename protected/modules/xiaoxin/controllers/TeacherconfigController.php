<?php

class TeacherconfigController extends Controller
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
                'actions' => array('index', 'create', 'update', 'delete','getteachers'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function  actionIndex()
    {
        $uid = Yii::app()->user->id;
        $tempSchool = SchoolTeacherRelation::getTeachersSchoolRaletion($uid); //获取登陆老师的学校列表
        $schoollist = array();
        foreach ($tempSchool as $k => $v) {
            if (NoticeService::checkMonitorRight($v->sid, $uid, Constant::APPID21)) {
                $schoollist[] = $v;
            }
        }

        if(empty($schoollist)){
            Yii::app()->msg->postMsg('error', '没有权限,请先设置权限');
            $this->redirect(Yii::app()->createUrl("xiaoxin/")) ;
        }
        if (isset($_GET['sid'])) {
            $sid = (int)Yii::app()->request->getParam("sid", 0);
        } else {
            $sid = isset($schoollist[0])?$schoollist[0]->sid:-1;
        }
        $allTeachers = SchoolTeacherRelation::getSchoolTeachers(array('sid' => $sid));
        //选中的老师的
        if (isset($_GET['selectuid'])) {
            $selectuid = (int)Yii::app()->request->getParam("selectuid", 0);
        } else {
            if (!empty($allTeachers)) {
                $selectuid = isset($allTeachers[0])?$allTeachers[0]->teacher:0;
            } else {
                $selectuid = 0;
            }
        }
        $teachers = TeachersRelation::getTeachersRelation($selectuid, $sid);
        $members = array();
        $tmp = array();
        if ($teachers) {
            if (!empty($teachers->teachers)) {
                $userlist = Member::getUsersByUids(explode(",", $teachers->teachers));
                if (is_array($userlist)) {
                    foreach ($userlist as $val) {
                        $members[] = array('userid' => $val->userid, 'name' => $val->name);
                        $tmp[] = $val->userid;
                    }
                }
            }
        }

        //添加
        if (isset($_POST['sid'])) {
            $sid = $_POST['sid'];
            $selectteachers = isset($_POST['duallistbox_demo1'])?$_POST['duallistbox_demo1']:array(); //老师数组
            $uid = $_POST['selectuid']; //选中的老师

            $teachers = TeachersRelation::getTeachersRelation($uid, $sid);
            if ($teachers) {
                $teachers->teachers = $selectteachers ? implode(",", $selectteachers) : '';
                $teachers->updatetime = date("Y-m-d H:i:s");
                $teachers->save();
            } else {
                $teachers = new TeachersRelation();
                $teachers->sid = $sid;
                $teachers->uid = $uid;
                $teachers->creationtime = date("Y-m-d H:i:s");
                $teachers->updatetime = date("Y-m-d H:i:s");
                $teachers->teachers = $selectteachers ? implode(",", $selectteachers) : '';
                $teachers->save();
            }
            Yii::app()->msg->postMsg('success', '保存成功');
            $this->redirect(Yii::app()->createUrl("xiaoxin/teacherconfig/index") . "?sid=" . $sid . "&selectuid=" . $uid);

        }
        $this->render("index", array('rightlist' => $tmp, 'sid' => $sid, 'selectuid' => $selectuid, 'allteachers' => $allTeachers, 'teachers' => $members, 'schools' => $schoollist));
    }

    public function actionGetteachers(){
        $sid = Yii::app()->request->getParam("sid", '0');
        $teacherArr = School::getSchoolTeacherReturnArr($sid,true);
        $teacher = isset($_GET['teacher'])?Yii::app()->request->getParam("teacher", '0'):$teacherArr[0]['userid'];
        $teachers = TeachersRelation::getTeachersRelation($teacher, $sid);
        $members = array();
        $tmp = array();
        if ($teachers) {
            if (!empty($teachers->teachers)) {
                $userlist = Member::getUsersByUids(explode(",", $teachers->teachers));
                if (is_array($userlist)) {
                    foreach ($userlist as $val) {
                        $members[] = array('userid' => $val->userid, 'name' => $val->name);
                        $tmp[] = $val->userid;
                    }
                }
            }
        }
        die(json_encode(array('allteacher'=>$teacherArr,'selects'=>$members,'teacher'=>$teacher,'tmp'=>$tmp)));
    }


}