<?php

class RangeController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     *返回城市区域列表
     */
    public function actionCityarea()
    {
        $cid = Yii::app()->request->getParam('cid');
        $city = Area::model()->findByPk($cid);
        $arr = Area::getAreaArr(array('cid' => $cid));
        $con = $this->renderPartial('cityarea', array('arr' => $arr, 'city' => $city), true);
        echo $con;
    }

    /**
     *返回区域返回学校列表
     */
    public function actionAreaschools()
    {
        $area = Yii::app()->request->getParam('area');
        $arr =School::getSchoolArrByArea(array('area' => $area));
        die(json_encode(array('status'=>'1','data'=>$arr)));
    }

    /**
     *返回学校类型年级列表
     */
    public function actionSchooltypegrade()
    {
        $stid = Yii::app()->request->getParam('stid');
        $schooltype = SchoolType::model()->findByPk($stid);
        $arr = Grade::getGradeArr(array('stid' => $stid));
        $con = $this->renderPartial('schooltypegrade', array('arr' => $arr, 'schooltype' => $schooltype), true);
        echo $con;
    }

    // public function actionSchoolarea()
    // {
    //     $cid = Yii::app()->request->getParam('cid');
    //     $city = Area::model()->findByPk($cid);
    //     $arr = Area::getAreaArr(array('cid' => $cid));

    //     $con = $this->renderPartial('schoolarea', array('arr' => $arr), true);
    //     echo $con;
    // }

    public function actionSchoollist()
    {
        $aid = Yii::app()->request->getParam('aid');
        $stid = Yii::app()->request->getParam('stid');
        $school_arr = School::getSchoolTypeData(array('aid' => $aid, 'stid' => $stid));
        $arr = array();
        foreach ($school_arr as $r) {
            $arr[$r['sid']] = $r['sname'];
        }
        $con = $this->renderPartial('schoolarea', array('arr' => $arr), true);
        echo $con;
    }

    public function actionGoodlist()
    {
        $bid = Yii::app()->request->getParam('bid');
        $type = Yii::app()->request->getParam('ty','');//实物
        if ($bid) {
            $business = Business::model()->loadByPk($bid);
            $goods = $business->goods;
            $arr = array();
            foreach ($goods as $g) {
                if ($g->type == 1 || $type)
                    $arr[$g['mgid']] = $g['name'];
            }
        } else {
            $arr = MallGoods::getDataArr('card');
        }
        $con = $this->renderPartial('ajaxgoods', array('arr' => $arr), true);
        echo $con;
    }

    public function actionGoodbid()
    {
        $mgid = Yii::app()->request->getParam('mgid');
        $good = MallGoods::model()->loadByPk($mgid);
        echo $good->bid;
    }

    /*
    * 根据学校sid获取学校的年级,或学校的老师，学校的部门
     * 传grade>0，则表示获取年级
     * 传teacher,则同时获取老师
     * 传department,则同时获取部门
    */
    public function actionGetschoolgrade()
    {
        $sid = Yii::app()->request->getParam("sid", 0);
        $grade = Yii::app()->request->getParam("grade", 0);
        $teacher = Yii::app()->request->getParam("teacher", 0);
        $department = Yii::app()->request->getParam("department", 0);
        $class = Yii::app()->request->getParam("class", 0);
        $subject = Yii::app()->request->getParam("subject", 0);
        $gradeArr = array();
        $teacherArr = array();
        $departmentArr = array();
        $subjectArr=array();

        $classArr = array();
        if ((int)$sid) {
            if ($grade) {
                $gradeArr = School::getSchoolGradesArr($sid);
            }
            if ($teacher) {
                $teacherArr = School::getSchoolTeacherArr($sid,true);
            }
            if ($department) {
                $departmentArr = School::getSchoolDid($sid);
            }
            if ($class) {
                $classArr = School::getSchoolClassArr($sid);
            }
            if($subject){
                $subjectArr = School::getSchoolSubjectArr($sid);
            }
        }
        die(json_encode(array('grades' => $gradeArr, 'teachers' => $teacherArr, 'departments' => $departmentArr, 'classs' => $classArr,'subjects'=>$subjectArr)));
    }

    /*
    * 设置班主任;
    */
    public function actionClassmaster()
    {
        $cid = Yii::app()->request->getParam('cid');
        $uid = Yii::app()->request->getParam('uid');
        $msg = 'error';

        if ($cid) {
            $transaction = Yii::app()->db_member->beginTransaction();
            try {
                $class = MClass::model()->loadByPk($cid);

                if ($class) {
                    if ($uid) {
                        $class->master = $uid;
                    } else {
                        $class->master = null;
                    }
                    if ($class->save()) {
                        ClassTeacherRelation::updateOrCreateMaster($uid, $cid);
                        $msg = 'success';
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                echo $e->getMessage();
                $transaction->rollback();
            }

        }
        echo $msg;
    }

    /*
    * 设置班级科目;
    */
    public function actionSetsubject()
    {
        $cid = Yii::app()->request->getParam('cid');
        $uid = Yii::app()->request->getParam('uid');
        $sid = Yii::app()->request->getParam('sid');
        $sname = Yii::app()->request->getParam('subject', '');
        $msg = 'error';
        if ($cid && $sid) {
            $subject = Subject::getSubjectByattr($cid, $sid, $uid, $sname);
            if ($subject) {
                $user = Member::model()->findByPk($uid);
                if ($user && $user->state == 0) {
                    $user->state = 1;
                    $user->save();
                }
                $msg = 'success';
            }
        }
        echo $msg;
    }

    /*
     * 校验老师手机号是否已被绑定
     *
     */
    public function actionCheckteachermobile()
    {
        $mobilephone = Yii::app()->request->getParam("mobilephone", '');
        $uid = Yii::app()->request->getParam("uid", '0');
        $identity = Yii::app()->request->getParam("identity", '1');
        $isBind = false;
        if ($mobilephone && $identity) {
            if (empty($uid)) {
                $isBind = count(Member::checkteachermobilephone($mobilephone, $identity)) ? true : false;
            } else {
                $list = Member::checkteachermobilephone($mobilephone, false);
                if ($list) {
                    $info = $list;
                    if ($info->userid == $uid) { //是自己的手机
                        $isBind = false;
                    } else { //不是自己的手机号，并且已经在数据库中
                        $isBind = true;
                    }

                } else { //多于1个
                    $isBind = false;
                }

            }
        }
        die(json_encode(array('status' => '1', 'isBind' => $isBind ? '1' : '0')));
    }

    /*
    * ;
    */
    public function actionInitmemberpwd()
    {
        $ids = Yii::app()->request->getParam("ids", '');
        $total=0;
        if ($ids) {
            $msg = 'error';
            if ($ids) {
                $idArr = explode(",", $ids);
                $num = 0;
                $firstPassword="";
                $total=count($idArr);
                foreach ($idArr as $id) {
                    if ((int)$id) {
                        $member = Member::model()->findByPk($id);
                        if ($member) {
                            $password = MainHelper::generate_code(6);
                            $member->pwd = MainHelper::encryPassword($password);
                            if($total==1){
                                $firstPassword=$password;
                            }
                            $member->issendpwd=1;
                            if ($member->save()) {
                                $num++;
                                UCQuery::sendMobilePasswordMsg($member->mobilephone,$password);
                            }
                        }
                    }
                }
                if ($num > 0) {
                    $msg = 'success';
                }
            }
        }
        if($total>1){
            die(json_encode(array('msg' => $msg)));
        }else{
            die(json_encode(array('msg' => $msg, 'password' => isset($firstPassword) ? $firstPassword : "")));
        }
    }

    /**
     *返回城市区域列表
     */
    public function actionUser()
    {
        $type = Yii::app()->request->getParam('cid');
        $arr = User::getUserArr(array('type' => $type));
        $con = $this->renderPartial('users', array('arr' => $arr), true);
        echo $con;
    }

    public function actionAccessschool()
    {
        $uid = Yii::app()->request->getParam('uid');
        $type = Yii::app()->request->getParam('type');
        if($type==1){
            $schools = School::getDataArr(true);
        }else{
            $schools = Business::getDataArr();
        }
        
        $con = $this->renderPartial('accessschool', array('schools' => $schools,'uid'=>$uid,'type'=>$type), true);
        echo $con;
    }

    //获取城市、区域
     public function actionSchoolarea()
    {
        //510100
        $id=Yii::app()->request->getParam("cid",0);
        $cache=Yii::app()->cache;
        if($id){
            $info=$cache->get("city_child_$id");
            if(empty($info)){
                $info=Area::getCity(array('cid'=>$id));
                $cache->set("city_child_$id",$info);
            }
//             $con = $this->renderPartial('schoolarea', array('arr' => $info), true);
//             echo  $con;
            die(json_encode(array('status'=>'1','data'=>$info)));
        }

    }
}