<?php

class OpenregisterController extends Controller
{

	//开放注册-验证手机
	// public function actionIndex()
	// {
	// 	$phone = Yii::app()->request->getParam('phone');
 //        $sendcode = Yii::app()->request->getParam('code');
 //        $uid = Yii::app()->request->getParam('uid');

 //        if ($phone && $sendcode) {
 //            $key = "openregister_" . $phone;
 //            $cache = Yii::app()->cache;
 //            $cachecode = $cache->get($key);
 //            if ($cachecode == $sendcode) {//测试
 //               $cache->delete($key);                
 //                Yii::app()->session['open_register_num'] = md5($phone);
 //               $this->redirect(array('openreginfo','phone'=>$phone,'uid'=>$uid));
 //            }
 //        }else{
 //            $this->renderPartial('index');
 //        }
	// }


    //开放注册-创建用户，学校
    public function actionOpenreginfo()
    {
        $cache=Yii::app()->cache;

        $phone = Yii::app()->request->getParam('phone');
        $key="openregister_" . $phone.date("Y-m-d");
        if(!$cache->get($key)){ //直接输入地址进来的，没有发送通过发送验证码那步
            Yii::app()->msg->postMsg("error",'请先验证手机');
            $this->redirect('index');
            exit();
        }

        $cookiephone=isset(Yii::app()->session['open_register_num'])?Yii::app()->session['open_register_num']:'';
        
        if(md5($phone)!==$cookiephone){
            Yii::app()->msg->postMsg("error",'请先验证手机');
            $this->redirect('index');
            exit();
        }
        $name = Yii::app()->request->getParam('name');
        $schoolName = Yii::app()->request->getParam('schoolName');
        $password = Yii::app()->request->getParam('password');
        $uid = Yii::app()->request->getParam('uid');
        $sid = Yii::app()->request->getParam('sid');

        if($phone && $name && $schoolName && $password){
            
           // if($uid){ //验证手机如果手机存在但身份为4（家长）就用此记录，不重新生成用户
                $member=Member::getUniqueMember($phone);
                if($member&&($member->identity==1||$member->identity==5)){
                    Yii::app()->msg->postMsg("error",'该手机已注册');
                    $this->redirect('index');
                    exit();
                }
            	//$userid = $uid;
                //$member=Member::model()->findByPk($userid);
                if($member){
                    $newIdentiry=Member::transIdentity(Constant::TEACHER_IDENTITY,$member->identity);
                    $member->identity=$newIdentiry;
                    $member->state=1;
                    $member->name = $name;
                    $member->pwd = MainHelper::encryPassword($password);
                    $member->createtype = 1; //自注册
                    $member->save();
                }else{
                    $userid = UCQuery::makeMaxId(0, true);
                    $member = new Member;
                    $member->createtype = 1; //自注册
                    $member->state = 1;
                    $member->userid = $userid;
                    $member->name = $name;
                    $member->mobilephone = $phone;
                    $member->identity = Constant::TEACHER_IDENTITY; //默认老师身份;
                    $member->account = "t" . $userid;
                    $member->issendpwd=1;
                    $member->pwd = MainHelper::encryPassword($password);
                    $member->save();
                }
//            }else{
//            	//创建老师
//            	$userid = UCQuery::makeMaxId(0, true);
//            	$member = new Member;
//	            $member->createtype = 1; //自注册
//	            $member->state = 1;
//	            $member->userid = $userid;
//	            $member->name = $name;
//	            $member->mobilephone = $phone;
//	            $member->identity = Constant::TEACHER_IDENTITY; //默认老师身份;
//	            $member->account = "t" . $userid;
//                $member->issendpwd=1;
//	            $member->pwd = MainHelper::encryPassword($password);
//	            $member->save();
//            }
            $sid = School::getSchoolByName($schoolName);
            if($sid==1){ //学校已存在
                Yii::app()->msg->postMsg("error",'该学校已存在');
                $this->redirect('index');
                exit();
            }
            if($sid>1){
            	$schoolid = $sid;  //如果学校已存并且是自注册学校，用此学校id
                $school=School::model()->findByPk($schoolid);
            }else{
            	//创建学校
	            $school = new School;
	            $school->createtype = 1; //自注册
	            $school->name = $schoolName;
	            $school->aid = 5; //地区默认为深圳南山区
	            $school->stid = '1,2,3,4,5,6,7'; //学校类型默认为所有类型
	            $school->sid = UCQuery::makeMaxId(2, true);
	            $school->save();
	            $schoolid = $school->sid;
            }

            //创建教师学校关系
            if($schoolid){
                $strelation = new SchoolTeacherRelation;
                $strelation->sid = $schoolid;
                $strelation->teacher = $member->userid;
                $strelation->duty = 58;
                $strelation->save();
            }else{
                $this->redirect('index');
                exit();
            }
            unset(Yii::app()->session['open_register_num']);
            $this->redirect(array('openregsuccess','phone'=>$phone,'userid'=>$member->userid,'sid'=>$school->sid));
        
        }else if($phone){
            $this->renderPartial('openreginfo',array('phone'=>$phone,'uid'=>$uid));
        }else{
        	$this->redirect('index');
        }
    }

    //开放注册-创建成功
    public function actionOpenregsuccess()
    {
    	$phone = Yii::app()->request->getParam('phone');
    	$userid = Yii::app()->request->getParam('userid');
    	$sid = Yii::app()->request->getParam('sid');
    	// $userid = '58457101';
    	// $sid = '46101';
    	$time = date('Y-m-d H:i:s',time());
    	$pass = md5(md5($userid . $time . 'cdds'));
    	$redirectUrl = Yii::app()->createUrl('xiaoxin/class/create?sid='.$sid);
    	$url = Yii::app()->request->baseUrl . '/index.php/xiaoxin/default/remote?userid='.$userid.'&pass=' . $pass . '&identity=' . 1 . '&time=' . $time . '&url='.$redirectUrl;
    	if($phone){    		
    		$this->renderPartial('openregsuccess',array('url'=>$url));	
    	}else{
    		$this->redirect('index');	
    	}
        
    }
}