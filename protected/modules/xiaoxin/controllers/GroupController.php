<?php

class GroupController extends Controller
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
				'actions'=>array('index','create','delete','update','member','getmember'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * 自定义分组-列表
	 * panrj 2014-08-09
	 */
	public function actionIndex()
	{
		$userid = Yii::app()->user->id;
		$sql = "CALL php_xiaoxin_GetTeacherGroupList('".$userid."','0')";
		$students = UCQuery::queryAll($sql);

        $shareStudengGroups=GroupPermission::getShareGids($userid,0,0);
        foreach($shareStudengGroups as $k=>$val){
            $num=GroupMember::getGroupMemberNum($val->gid);
            $students[]=array('gid'=>$val->gid,'name'=>$val->g->name,'sid'=>$val->g->sid,'state'=>$val->g->state,
                'type'=>$val->g->type,'creationtime'=>$val->g->creationtime,'shares'=>1,'member'=>$num,'createname'=>$val->createname);
        }
		foreach($students as $k=>$val){
			$sid = isset($val['sid'])?$val['sid']:'';
			if($sid){
				$schoolinfo=School::model()->findByPk($sid);
				$students[$k]['schoolname']=$schoolinfo?$schoolinfo->name:'';
			}else{
				$students[$k]['schoolname'] = '';
			} 
        }
		$sql = "CALL php_xiaoxin_GetTeacherGroupList('".$userid."','1')";
		$teachers = UCQuery::queryAll($sql);
        $shareTeacherGroups=GroupPermission::getShareGids($userid,0,1);
        foreach($shareTeacherGroups as $k=>$val){
            $num=GroupMember::getGroupMemberNum($val->gid);
            $teachers[]=array('gid'=>$val->gid,'name'=>$val->g->name,'sid'=>$val->g->sid,'state'=>$val->g->state,
                'type'=>$val->g->type,'creationtime'=>$val->g->creationtime,'shares'=>1,'member'=>$num,'createname'=>$val->createname);
        }
        //D($teachers);
        foreach($teachers as $k=>$val){
        	$sid = isset($val['sid'])?$val['sid']:'';
			if($sid){
	            $schoolinfo=School::model()->findByPk($sid);
	            $teachers[$k]['schoolname']=$schoolinfo?$schoolinfo->name:'';
	        }else{
	        	$teachers[$k]['schoolname'] = '';
	        }
        }
		$this->render('index',array('students'=>$students,'teachers'=>$teachers));
	}

	/**
	 * 自定义分组-创建
	 * panrj 2014-08-09
	 */
	public function actionCreate()
	{
		$userid = Yii::app()->user->id;
		$schools = UCQuery::getTeacherSchool($userid);
        $userinfo=Yii::app()->user->getInstance();
		if(isset($_POST['Group'])){
			$name = $_POST['Group']['name'];
			$type = $_POST['Group']['type'];
			$members = isset($_POST['Group']['uid'])?$_POST['Group']['uid']:array();
			$sid = $_POST['Group']['sid'];
			$sql = "CALL php_xiaoxin_CreateUserGroup('".$name."','".$userid."','".$type."','".$sid."',".(int)USER_BRANCH.")";
			$gid = UCQuery::queryScalar($sql);
			foreach($members as $uid){
				$sql = "CALL php_xiaoxin_AddUserGroupMember('".$gid."','".$uid."')";
				$rid = UCQuery::queryScalar($sql);
			}
            //保定指定访问人
            $accessids=isset($_POST['Group']['accessids'])?$_POST['Group']['accessids']:array();
            foreach($accessids as $val){
                if($val==$userid) continue;//排除自己
                $groupPermission=new GroupPermission();
                $groupPermission->gid=$gid;
                $groupPermission->userid=$val;
                $groupPermission->createor=$userid;
                $groupPermission->createname=$userinfo?$userinfo->name:'';
                $groupPermission->save();
            }
			Yii::app()->msg->postMsg('success', '操作成功');
			$this->redirect(Yii::app()->createUrl('xiaoxin/group/index'));
		}
		$this->render('create',array('schools'=>$schools));
	}

	/**
	 * 自定义分组-删除
	 * panrj 2014-08-09
	 */
	public function actionDelete($id)
	{
		$sql = "CALL php_xiaoxin_DeleteUserGroup('".$id."')";
		$errors = UCQuery::updateTrans($sql);
		if(!$errors)
			Yii::app()->msg->postMsg('success', '操作成功');
		$this->redirect(Yii::app()->createUrl('xiaoxin/group/index'));
	}

	/**
	 * 自定义分组-修改
	 * panrj 2014-08-09
	 */
	public function actionUpdate($id)
	{
		$userid = Yii::app()->user->id;
        $userinfo=Yii::app()->user->getInstance();
		$schools = UCQuery::getTeacherSchool($userid);
		$group = UCQuery::loadTableRecord('tb_group',$id);
		$school = School::model()->findByPk($group->sid);
		$sql = "CALL php_xiaoxin_GetGroupMemberList('".$id."')";
		$members = UCQuery::queryAll($sql);
        $shareMembers=GroupPermission::getGidShareUserArr($id); //指定给哪些用户可以访问

		if(isset($_POST['Group'])){
			$name = $_POST['Group']['name'];
			$members = $_POST['Group']['uid'];
			$sql = "CALL php_xiaoxin_UpdateUserGroup('".$id."','".$name."')";
			UCQuery::execute($sql);
			$sql = "CALL php_xiaoxin_DeleteUserGroupMember('".$id."')";
			UCQuery::execute($sql);
			foreach($members as $uid){
				$sql = "CALL php_xiaoxin_AddUserGroupMember('".$id."','".$uid."')";
				$rid = UCQuery::queryScalar($sql);
			}

            //保定指定访问人
            $accessids=isset($_POST['Group']['accessids'])?array_unique($_POST['Group']['accessids']):array();
            GroupPermission::deletePermissionByGid($id);
            foreach($accessids as $val){
                if($val==$userid) continue;//排除自己
                $groupPermission=new GroupPermission();
                $groupPermission->gid=$id;
                $groupPermission->userid=$val;
                $groupPermission->createor=$userid;
                $groupPermission->createname=$userinfo->name;
                $groupPermission->save();
            }

			Yii::app()->msg->postMsg('success', '操作成功');
			$this->redirect(Yii::app()->createUrl('xiaoxin/group/index'));
		}
		$this->render('update',array('shareMembers'=>$shareMembers,'schools'=>$schools,'group'=>$group,'members'=>$members,'school'=>$school));
	}

	/**
	 * 自定义分组-添加成员
	 * panrj 2014-08-09
	 */
	public function actionMember()
	{
		$ty = Yii::app()->request->getParam('ty');
		$sid = Yii::app()->request->getParam('sid');
		$userid = Yii::app()->user->id;
		$classArr = array();
		$departArr = array();
		$studentArr = array();
		$teacherArr = array();
		if($ty=='0'){//添加学生
            $classArr=NoticeService::getClassBySidUid($sid,$userid);
		}else{//添加老师
			$sql = "CALL php_xiaoxin_getTeacherDepartmentInSchool('0','".$sid."')";
			$departArr = UCQuery::queryAll($sql);
		}
		$con = $this->renderPartial('member',array(
				'classes'=>$classArr,
				'departs'=>$departArr,
				'students'=>$studentArr,
				'teachers'=>$teacherArr,
				'ty'=>$ty
			),true);
		echo $con;
	}

	public function actionGetmember()
	{
		$ty = Yii::app()->request->getParam('ty');
		$tid = (int)Yii::app()->request->getParam('tid');
        $sid = (int)Yii::app()->request->getParam('sid');
        $uid=Yii::app()->user->id;
        $members = array();
        $schoolinfo=School::model()->findByPk($sid);
        if($tid=="allTeacher"){

                 if($schoolinfo->enableddirectsend){
                     //开启定向发送
                     $teacherconfig = TeachersRelation::getTeachersRelation($uid,$sid);
                     if ($teacherconfig&&$teacherconfig->teachers) {
                         $userlist = Member::getUsersByUids(explode(",", $teacherconfig->teachers));
                         if (is_array($userlist)) {
                             foreach ($userlist as $val) {
                                 $members[] = array('userid' => $val->userid, 'name' => $val->name);
                             }
                         }
                     }
                 }else{
                     //不是定向开启的，直接查学校所有老师
                     $allTeacher = SchoolTeacherRelation::getSchoolTeachers(array('sid'=>$sid));
                     foreach($allTeacher as $k =>$v){
                         if($v&&$v->teacher&&$v->teacher0){
                           $members[$k]['userid'] =$v->teacher;
                           $members[$k]['name']=$v->teacher0->name;
                         }
                     }
                 }
        }else{
            if($ty=='0'){
                $sql = "CALL php_xiaoxin_getClassStudent('".$tid."')";
                $members = UCQuery::queryAll($sql);
            }else{
                $sql = "CALL php_xiaoxin_getDepartmentTeacher('".$tid."')";
                $members=array();
                $tempmember = UCQuery::queryAll($sql);
                if($schoolinfo->enableddirectsend){
                    $teacherconfig = TeachersRelation::getTeachersRelation($uid,$sid);
                    if($teacherconfig&&$teacherconfig->teachers){
                        $myteachers=explode(",",$teacherconfig->teachers);
                        foreach($tempmember as $val){
                            if(in_array($val['userid'],$myteachers)){
                                $members[]=$val;
                            }
                        }
                    }

                }else{
                    $members=$tempmember;
                }
            }
        }
		$con = $this->renderPartial('members',array('members'=>$members),true);
		echo $con;
	}
}