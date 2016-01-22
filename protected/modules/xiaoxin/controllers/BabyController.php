<?php

class BabyController extends Controller
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
        if($identity!=Constant::FAMILY_IDENTITY){
            //$this->redirect(Yii::app()->createUrl("xiaoxin/default/index"));
           // exit();
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
                'actions' => array('index', 'account', 'group', 'deny', 'accept', 'remove', 'parent', 'removeparent'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $userid = Yii::app()->user->id;
        // var_dump(UCQuery::checkUserClient($userid));exit;
        $sql = "CALL php_xiaoxin_getParentStudent('" . $userid . "')";
        $students = UCQuery::queryAll($sql);
        // conlog($students);
        $this->render('index', array('students' => $students));
    }

    public function actionAccount($id)
    {
        $student = UCQuery::loadTableRecord('tb_user', $id);
        if ($student->sex == 0)
            $defaultphoto = Yii::app()->request->baseUrl . '/image/xiaoxin/default_pic.jpg';
        if ($student->sex == 1)
            $defaultphoto = Yii::app()->request->baseUrl . '/image/xiaoxin/man_pic.jpg';
        if ($student->sex == 2)
            $defaultphoto = Yii::app()->request->baseUrl . '/image/xiaoxin/woman_pic.jpg';

        $ext = UCQuery::loadTableRecord('tb_user_ext', $id);
        $sql = "CALL php_xiaoxin_GetGuardian('" . $id . "','" . Yii::app()->user->id . "')";
        $guardian = UCQuery::queryRow($sql);
        if (isset($_POST['Account'])) {
            $info = $_POST['Account'];
            $filename = isset($_POST['Account']['photo']) ? $_POST['Account']['photo'] : '';
            $photo = MainHelper::copyImg($filename, $dir = 'xiaoxin/student');
            $extphoto = property_exists($ext, 'photo') ? $ext->photo : '';
            $photo = $photo ? $photo : $extphoto;
            $name = $info['name'] ? $info['name'] : $student->name;
            $sex = $info['sex'] ? $info['sex'] : $student->sex;
            $birthday = $info['birthday'] ? $info['birthday'] : '0000-00-00';
            $role = $info['role'] ? $info['role'] : '家长';
            $sql = "CALL php_xiaoxin_UpdateStudentInfo('" . $id . "','" . $name . "','" . $sex . "','" . $photo . "','" . $birthday . "','" . $guardian->id . "','" . $role . "')";
            $m = UCQuery::updateUser($sql);
            Yii::app()->msg->postMsg('success', '操作成功');
            $this->redirect(Yii::app()->createUrl('xiaoxin/baby/account/' . $id));
        }
        $student_ext = StudentExt::model()->findByPk($id);
        $studentid = $student_ext ? $student_ext->studentid : '';
        $this->render('account', array('student' => $student, 'studentid' => $studentid, 'ext' => $ext, 'guardian' => $guardian, 'default' => $defaultphoto));
    }

    public function actionGroup($id)
    {
        $child = UCQuery::loadTableRecord('tb_user', $id);
        $sql = "CALL php_xiaoxin_getStudentClass('" . $id . "','1')";
        $groups = UCQuery::queryAll($sql);
        $sql = "CALL php_xiaoxin_getStudentClass('" . $id . "','0')";
        $applies = UCQuery::queryAll($sql);
        $this->render('group', array('groups' => $groups, 'child' => $child, 'applies' => $applies));
    }

    /**
     * 我的孩子-入班邀请-拒绝
     * panrj 2014-08-22
     */
    public function actionDeny($id)
    {
        $child = Yii::app()->request->getParam('child');
        $sql = "CALL php_xiaoxin_ChangeClassRelationState('" . $id . "','2','student')";
        $errors = UCQuery::updateTrans($sql);
        if (!$errors)
            Yii::app()->msg->postMsg('success', '操作成功');
        $this->redirect(Yii::app()->createUrl('xiaoxin/baby/group/' . $child));
    }

    /**
     * 我的孩子-入班邀请-确认
     * panrj 2014-08-22
     */
    public function actionAccept($id)
    {
        $child = Yii::app()->request->getParam('child');
        $sql = "CALL php_xiaoxin_ChangeClassRelationState('" . $id . "','1','student')";
        $errors = UCQuery::updateTrans($sql);
        if (!$errors)
            Yii::app()->msg->postMsg('success', '操作成功');
        $this->redirect(Yii::app()->createUrl('xiaoxin/baby/group/' . $child));
    }

    /**
     * 我的孩子-班级-移除学生
     * panrj 2014-08-22
     */
    public function actionRemove($id)
    {
        $child = Yii::app()->request->getParam('child');
        $sql = "CALL php_xiaoxin_DeleteClassStudentRelation('" . $id . "')";
        $errors = UCQuery::updateTrans($sql);
        if (!$errors)
            Yii::app()->msg->postMsg('success', '操作成功');
        $this->redirect(Yii::app()->createUrl('xiaoxin/baby/group/' . $child));
    }

    /**
     * 我的孩子-家长-移除学生
     * panrj 2014-08-22
     */
    public function actionParent($id)
    {
        if (isset($_POST['name'])) {
            $names = $_POST['name'];
            $mobilephones = $_POST['mobilephone'];
            $roles = $_POST['role'];
            $len = count($mobilephones);
            $transaction = Yii::app()->db_member->beginTransaction();
            try {
                for ($i = 0; $i < $len; $i++) {
                    $mobile = $mobilephones[$i];
                    $member = Member::getUniqueMember($mobile);

                    if ($member) {
                        $newIdentity = Member::transIdentity(Constant::FAMILY_IDENTITY, $member->identity);
                        $member->identity = $newIdentity;
                        $member->save();
                        $isGuardian = Guardian::getRelationByChildGuardian($member->userid, $id);
                        if (!$isGuardian) {
                            $parent = new Guardian;
                            $parent->guardian = $member->userid;
                            $parent->child = $id;
                            if (!empty($roles[$i])) {
                                $parent->role = $roles[$i];
                            }
                            $parent->save();
                        } else {
                            //if (!empty($roles[$i])) {
                                $isGuardian->role = $roles[$i];;
                                $isGuardian->save();
                           // }
                        }
                    } else { //不存在这个用户
                        $userid = UCQuery::makeMaxId(0, true);
                        $member = new Member;
                        $member->userid = $userid;
                        $member->name = $names[$i] ? $names[$i] : ('用户' . substr($mobilephones[$i], -4)); //$_POST['Student']['name'] . '的' . $roles[$i];
                        $member->identity = Constant::FAMILY_IDENTITY; //家长标志;
                        $member->mobilephone = $mobilephones[$i];
                        $member->account = "p" . $member->userid; //;
                        $password=MainHelper::generate_code(6);
                        $member->pwd = MainHelper::encryPassword($password);
                        if ($member->save()) {                           
							UCQuery::sendMobilePasswordMsg($mobilephones[$i],$password);
                           
                            //建立关系
                            $guardian = new Guardian;
                            $guardian->child = $id;
                            $guardian->guardian = $userid;
                            $guardian->main = 1;
                            if(!empty($roles[$i])){ //如果不填家长孩子关系，数据库默认为"家长"
                                $guardian->role = $roles[$i];
                            }

                            $guardian->save();


                        }
                    }
                }
                $transaction->commit();
                Yii::app()->msg->postMsg('success', '操作成功');
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->msg->postMsg('error', '操作失败');
            }
            $this->redirect(Yii::app()->createUrl('xiaoxin/baby/parent/' . $id));


        }
        $child = UCQuery::loadTableRecord('tb_user', $id);
        $guradians = UCQuery::getStudentGuradian($id, 0);
        $deleted = UCQuery::getStudentGuradian($id, 1);
        // conlog($guradians);
        $this->render('parent', array('guradians' => $guradians, 'child' => $child, 'deleted' => $deleted));
    }

    /**
     * 我的孩子-家长-移除家长
     * panrj 2014-08-22
     */
    public function actionRemoveparent($id)
    {
        $child = Yii::app()->request->getParam('child');
        $sql = "CALL php_xiaoxin_DeleteStudentGuardian('" . $id . "')";
        $errors = UCQuery::updateTrans($sql);
        if (!$errors)
            Yii::app()->msg->postMsg('success', '操作成功');
        $this->redirect(Yii::app()->createUrl('xiaoxin/baby/parent/' . $child));
    }
}