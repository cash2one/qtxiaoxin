<?php
/**
 * 应用级接口数据
 * panrj 2014-10-14
 */
class AppController extends SingleSignController
{
	protected function beforeAction($action) {
		$data = array("Result"=>"-6","Message"=>"暂无相关数据");
		echo JsonHelper::JSON($data);
		exit;
		return parent::beforeAction($action);
    }
    
	public function actionIndex()
	{
		$data = array(
			"获取服务器时间"=>Yii::app()->createAbsoluteUrl('api/app/servertime'),
			"认证账号与密码"=>Yii::app()->createAbsoluteUrl('api/user/account')."?Username=&Pwd=",
			"修改密码"=>Yii::app()->createAbsoluteUrl('api/user/changepwd')."?Userid=&Old=&New=",
			"获取验证码"=>Yii::app()->createAbsoluteUrl('api/user/sendcode')."?Mobile=",
			"重置密码"=>Yii::app()->createAbsoluteUrl('api/user/resetpwd')."?Mobile=&Verifycode=&Pwd=",
			"个人设置(暂时只提供修改姓名)"=>Yii::app()->createAbsoluteUrl('api/user/setting')."?Userid=&Name=&Sex=",
			"获取功能列表"=>Yii::app()->createAbsoluteUrl('api/app/getapps')."?Userid=",
			"获取班级列表[通知家长]"=>Yii::app()->createAbsoluteUrl('api/app/getclasses')."?Userid=",
			"获取部门列表[通知老师]"=>Yii::app()->createAbsoluteUrl('api/app/departments')."?Userid=",
			"获取自定义分组"=>Yii::app()->createAbsoluteUrl('api/app/getgroups')."?Userid=&Type=",
			"获取年级列表[紧急通知]"=>Yii::app()->createAbsoluteUrl('api/app/getgrades')."?Userid=",
			"发送通知"=>Yii::app()->createAbsoluteUrl('api/app/sendnotice')."?Userid=&Receiver=&Noticetype=&Content=&Images=&Media=&Evaluatetype=",
			"获取学校老师列表[电话本]"=>Yii::app()->createAbsoluteUrl('api/app/schoolteachers')."?Sid=",
			"获取班级学生家长列表[在校表现，电话本]"=>Yii::app()->createAbsoluteUrl('api/app/classstudents')."?Cid=",
			"发布餐单"=>Yii::app()->createAbsoluteUrl('api/app/foodmenu')."?Sid=&Userid=&Year=&Week=&Content=",
			"读取餐单"=>Yii::app()->createAbsoluteUrl('api/app/getfoodmenu')."?Sid=&Year=&Week=",
			"获取评论数"=>Yii::app()->createAbsoluteUrl('api/app/getreplaynum')."?Noticeid=",
			"发送评论"=>Yii::app()->createAbsoluteUrl('api/app/addreplay')."?Noticeid=&Userid=&Content=",
			"通知评论列表"=>Yii::app()->createAbsoluteUrl('api/app/noticecoments')."?Noticeid=&Unit=&Lasttime=&Lastid=",
			"模版类型列表"=>Yii::app()->createAbsoluteUrl('api/app/templatekinds'),
			"保存模版"=>Yii::app()->createAbsoluteUrl('api/app/savetemplate')."?Userid=&Type=&Content=&Kind=",
			"模版列表"=>Yii::app()->createAbsoluteUrl('api/app/gettemplates')."?Userid=&Type=&Kind=&Unit=&Lasttime=&Lastid=",
			"上传文件"=>Yii::app()->createAbsoluteUrl('api/app/uploadfile'),
			"意见反馈"=>Yii::app()->createAbsoluteUrl('api/app/feedback')."?Userid=&Content=&Clienttype=",
			"删除模板"=>Yii::app()->createAbsoluteUrl('api/app/deletetemplate')."?Tid=",
			"使用帮助"=>Yii::app()->createAbsoluteUrl('api/user/helper'),
			"使用条款"=>Yii::app()->createAbsoluteUrl('api/user/provision'),
			"版本更新"=>Yii::app()->createAbsoluteUrl('api/user/version?Type='),
		);
		$html = '<html><head><meta charset="UTF-8"></head>';
		foreach($data as $k=>$v){
			$html .= '<p>'.$k.':   <a href="'.$v.'" target="_blank">'.$v.'</a></p>';
		}
		$html .= '</html>';
		echo $html;
	}

	/**
     * 获取服务器时间
     * panrj 2014-10-14
     * @return string json
     */
	public function actionServertime()
	{
		$data = array(
    			"Timestamp"=>time(),
    			"Result"=>"0",
    			"Message"=>"操作成功"
    		);
        echo JsonHelper::JSON($data);
	}

	/**
     * 获取功能列表
     * panrj 2014-10-30
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionGetapps()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$guid = Yii::app()->request->getParam('Guid','');
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		// $roles = SchoolTeacherRelation::getTeacherDutyPks($userid);
		// var_dump($roles);exit;
		$apps = Application::getTeacherClientApp($userid,$guid);
		$appArr = array();
		if(count($apps)){
			foreach($apps as $app){
				$img = $app->icon ? Yii::app()->request->hostInfo.$app->icon : $app->icon;
				if($app->appid==24){
					$url = strpos($app->url,"?")?$app->url.'&uid='.$userid:$app->url.'?uid='.$userid;
				}else{
					$url = Yii::app()->request->hostInfo.$app->url.'?Userid='.$userid;
				}
				$appArr[] = array('Id'=>$app->appid,'Name'=>$app->name,'Image'=>$img,'Url'=>$url);
			}
			$appArr[] = array('Id'=>0,'Name'=>'已发信息','Image'=>'');
			$data = array("Functions"=>$appArr,"Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Functions"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

     /**
     * 获取班级列表
     * panrj 2014-10-30
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionGetclasses()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$appid = Yii::app()->request->getParam('Appid',0);
		$guid = Yii::app()->request->getParam('Guid','');		
		if(!$userid){
			JsonHelper::Notify("","Userid");			
		}
		$dataArr = array();
		$schools = SchoolTeacherRelation::getTeacherSchools($userid);	
		if(count($schools)){
			foreach($schools as $ks=>$vs){
				if($appid){
					if(!NoticeService::checkMonitorRight($ks,$userid,$appid)){
	                    continue;
	                }
				}
				$schoolArr = array('Name'=>$vs,'Sid'=>$ks,'Classes'=>array());
				$classes = ClassTeacherRelation::getDutyClassByTeacher($ks,$userid);
				if($guid){
					$groups = Group::getUserGroupWithShare($userid,$sid=$ks,$type=0);
				}else{//旧版本由于IOS有BUG，不提供分组数据
					$groups = array();
				}
				
				if(count($classes)){
					$schoolClassArr = array();
					foreach($classes as $class){
						$schoolClassArr[] = array('Cid'=>$class->cid,'Name'=>addslashes($class->name),'Master'=>$class->master,'Type'=>1,'Total'=>$class->total);
					}
					if(count($schoolClassArr)){
						$schoolArr['Classes'] = $schoolClassArr;
					}
				}

				if(count($groups)){
					$schoolGroupArr = array();
					foreach($groups as $g){
						$schoolGroupArr[] = array('Cid'=>$g->gid,'Name'=>$g->name.'(分组)','Master'=>$g->creater,'Type'=>2,'Total'=>GroupMember::getGroupMemberNum($g->gid));
					}
					if(count($schoolGroupArr)){
						$schoolArr['Classes'] = array_merge($schoolArr['Classes'],$schoolGroupArr);
					}
				}
				// if(count($schoolArr['Classes'])){
					$dataArr[] = $schoolArr;
				// }
			}
			if(count($dataArr)){
				$data = array("Classes"=>$dataArr,"Result"=>"0","Message"=>"操作成功");
			}else{
				$data = array("Classes"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
			}
		}else{
			$data = array("Classes"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 获取部门列表
     * panrj 2014-10-30
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionDepartments()
	{
		$guid = Yii::app()->request->getParam('Guid','');
		$userid = Yii::app()->request->getParam('Userid');
		$appid = Yii::app()->request->getParam('Appid',0);
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		$dataArr = array();		
		$relations = SchoolTeacherRelation::getTeacherSchools($userid);
		if(count($relations)){
			foreach($relations as $ks=>$kv){
				if($appid){
					if(!NoticeService::checkMonitorRight($ks,$userid,$appid)){
	                    continue;
	                }
				}
				$depArr['Name'] = $kv;
				$depArr['Sid'] = $ks;
				$dep_data = array();
				$relations = SchoolTeacherRelation::getSchoolTeachers(array('sid'=>$ks));
				$dep_data[] = array('Did'=>0,'Name'=>'全体老师','Type'=>4,'Total'=>count($relations));
				//返回学校所有部门
				$departments = Department::getSchoolDepartment(array('sid'=>$ks));
				if(count($departments)){
					foreach($departments as $dk=>$ds){
						$dep_data[] = array('Did'=>$dk,'Name'=>$ds,'Type'=>6,'Total'=>Department::getDepartmentMemberNum($dk));
					}
				}
				
				if($guid){
					$groups = Group::getUserGroupWithShare($userid,$sid=$ks,$type=1);
				}else{//旧版本由于IOS有BUG，不提供分组数据
					$groups = array();
				}

				if(count($groups)){
					$schoolGroupArr = array();
					foreach($groups as $g){
						$dep_data[] = array('Did'=>$g->gid,'Name'=>$g->name.'(分组)','Type'=>2,'Total'=>GroupMember::getGroupMemberNum($g->gid));
					}
				}
				$depArr['Departments'] = $dep_data;
				$dataArr[] = $depArr;
			}
			if(count($dataArr)){
				$data = array("Departments"=>$dataArr,"Result"=>"0","Message"=>"操作成功");
			}else{
				$data = array("Departments"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
			}
		}else{
			$data = array("Departments"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 获取全校老师
     * panrj 2014-10-31
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionSchoolteachers()
	{
		$sid = Yii::app()->request->getParam('Sid');
		if(!$sid){
			JsonHelper::Notify("","Sid");
		}
		$dataArr = array();
		$relations = SchoolTeacherRelation::getSchoolTeachers(array('sid'=>$sid));
		if(count($relations)){
			foreach($relations as $rel){
				$teacherArr = array('Userid'=>$rel->teacher,'Name'=>$rel->teacher0->name,'Mobile'=>$rel->teacher0->mobilephone,'Sex'=>$rel->teacher0->sex);
				$dataArr[] = $teacherArr;
			}
			if(count($dataArr)){
				$data = array("Teachers"=>$dataArr,"Result"=>"0","Message"=>"操作成功");
			}else{
				$data = array("Teachers"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
			}
		}else{
			$data = array("Teachers"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 获取班级学生
     * panrj 2014-10-31
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionClassstudents()
	{
	
		$cid = Yii::app()->request->getParam('Cid');
		if(!$cid){
			JsonHelper::Notify("","Cid");
		}
		$dataArr = array();
		$relations = ClassStudentRelation::getClassStudents($cid);
		if(count($relations)){
			foreach($relations as $rel){
				$guardian = Guardian::getChildFirstGuardian($rel->student);
				if($guardian){
					$studentArr = array('Userid'=>$guardian->child,'Name'=>$guardian->child0->name,'Mobile'=>$guardian->guardian0->mobilephone,'Sex'=>$guardian->child0->sex);
					$dataArr[] = $studentArr;
				}
			}
			if(count($dataArr)){
				$data = array("Guardians"=>$dataArr,"Result"=>"0","Message"=>"操作成功");
			}else{
				$data = array("Guardians"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
			}
		}else{
			$data = array("Guardians"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 获取自定义分组信息
     * panrj 2014-10-30
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionGetgroups()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$type = Yii::app()->request->getParam('Type','');
		$appid = Yii::app()->request->getParam('Appid',0);
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		if($type==''){
			JsonHelper::Notify("","Type");
		}

		$dataArr = array();
		$schools = SchoolTeacherRelation::getTeacherSchools($userid);

		if(count($schools)){
			foreach($schools as $ks=>$vs){
				if($appid){
					if(!NoticeService::checkMonitorRight($ks,$userid,$appid)){
	                    continue;
	                }
				}
				$schoolArr = array('Name'=>$vs,'Sid'=>$ks,'Groups'=>array());
				$groups = Group::getUserGroupWithShare($userid,$ks,$type);
				if(count($groups)){
					$schoolGroupArr = array();
					foreach($groups as $group){
						$schoolGroupArr[] = array('Gid'=>$group->gid,'Name'=>$group->name);
					}
					if(count($schoolGroupArr)){
						$schoolArr['Groups'] = $schoolGroupArr;
						$dataArr[] = $schoolArr;
					}
				}
			}
			
			if(count($dataArr)){
				$data = array("Groups"=>$dataArr,"Result"=>"0","Message"=>"操作成功");
			}else{
				$data = array("Groups"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
			}
		}else{
			$data = array("Groups"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 获取年级列表
     * panrj 2014-10-30
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionGetgrades()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$appid = Yii::app()->request->getParam('Appid',0);
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}

		$dataArr = array();
		$schools = SchoolTeacherRelation::getTeacherSchools($userid);
		if(count($schools)){
			foreach($schools as $ks=>$vs){
				if($appid){
					if(!NoticeService::checkMonitorRight($ks,$userid,$appid)){
	                    continue;
	                }
				}
				$schoolArr = array('Name'=>$vs,'Sid'=>$ks,'Grades'=>array());
				$grades = School::getSchoolGradesArr($ks);
				// if(count($grades)){
					$schoolGradeArr = array();
					$schoolGradeArr[] = array('Gid'=>0,'Name'=>'全体老师','Type'=>4);
					foreach($grades as $gk=>$gv){
						$schoolGradeArr[] = array('Gid'=>$gk,'Name'=>$gv.'学生','Type'=>3);
					}
					// if(count($schoolGradeArr)){
						$schoolArr['Grades'] = $schoolGradeArr;
						$dataArr[] = $schoolArr;
					// }
				// }
			}
			
			if(count($dataArr)){
				$data = array("Grades"=>$dataArr,"Result"=>"0","Message"=>"操作成功");
			}else{
				$data = array("Grades"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
			}
		}else{
			$data = array("Grades"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 发送通知
     * panrj 2014-10-31
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionSendnotice()
	{
		// $xmlstr = file_get_contents('C:\Users\admin\Desktop\test.jpg'); 
		// conlog($xmlstr);
		// MainHelper::stream2Image('test.jpg',$xmlstr);exit;

		$userid = Yii::app()->request->getParam('Userid');
		$receiver = Yii::app()->request->getParam('Receiver');
		$noticetype = Yii::app()->request->getParam('Noticetype');
		$content = Yii::app()->request->getParam('Content','');
		$images = Yii::app()->request->getParam('Images');
		$media = Yii::app()->request->getParam('Voice');
		$media = $media?$media:Yii::app()->request->getParam('Media');
		$evaluatetype = Yii::app()->request->getParam('Evaluatetype','0');
		$client = Yii::app()->request->getParam('Client','0');
		$imgs = $images;
		$receivertitle = in_array($noticetype,array(1,2))?'xxx家长':'xxx';
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		if(!$receiver){
			JsonHelper::Notify("","Receiver");
		}
		if($noticetype == ''){
			JsonHelper::Notify("","Noticetype");
		}
		// if(!$content){
		// 	JsonHelper::Notify("","Content");
		// }
		// conlog($receiver);
		$con = json_decode($receiver,true);
		// conlog($con);
		$resultArr = array();
		$noticeid = '';
		foreach($con as $k=>$rec){
			$sid = $rec['Sid'];
			$receivernames = isset($rec['Receivernames'])?$rec['Receivernames']:'';
			$rec_data = $rec['Receivers'];
			$result = array();
			foreach($rec_data as $r){
				if($r['Value'] || $r['Key']==4){
					$p = '"'.$r['Key'].'":"'.$r['Value'].'"';
					$result[] = $p;
				}
				if(count($result)){
					$resultArr[$k]['data'] = $result;
					$resultArr[$k]['sid'] = $sid;
					$resultArr[$k]['receivernames'] = $receivernames;
				}
			}
		}
		foreach($resultArr as $kr=>$ra){
			$recv = implode(",", $ra['data']);
			$receiver = '{'.$recv.'}';
			$body = array('content'=>$content);
			$imgcontent = '';
			if($imgs){
				$imagesArr = json_decode($imgs,true);
				$urlArr = array();  
				foreach($imagesArr as $img){
					$url = $img['Url'];
					if($url){
						$urlArr[] = array('url'=>$url);
					}
				}
				if(count($urlArr)){
					$body['images'] = $urlArr;
				}
			}

			if($media){
				$body['medias'] = array_change_key_case(json_decode($media,true));
				// $body['medias'] = array($media);
			}
			$body = json_encode($body, JSON_UNESCAPED_UNICODE);
			
			$user = Member::model()->findByPk($userid);
			$sid = $ra['sid'];
			$school = School::model()->findByPk($sid);
			$notice = new Notice;
			$notice->sender = $userid;
			$notice->receiver = $receiver;
			$notice->noticetype = $noticetype;
			$notice->sendertitle = $user->name;
			$notice->receivertitle = $receivertitle;
			$notice->content = $body;
			$notice->sendtime = date('Y-m-d H:i:s',time());
			$notice->issendsms = 1;
			$notice->state = 0;
			$notice->sid = $sid;
			$notice->schoolname = $school->name;
			$notice->receivename = $ra['receivernames'];
			$notice->evaluatetype = $evaluatetype;
			$notice->platform = $client;
			if($notice->save()){
				$noticeid = $notice->noticeid;
			}
		}
		if($noticeid){
			$data = array("Noticeid"=>$noticeid,"Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Result"=>"-8","Message"=>"操作失败本次操作没有执行");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 发布餐单
     * panrj,zengp 2014-11-02
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionFoodmenu()
	{
		$sid = Yii::app()->request->getParam('Sid');
		$year = Yii::app()->request->getParam('Year');
		$week = Yii::app()->request->getParam('Week');
		$content = Yii::app()->request->getParam('Content');
		$userid = Yii::app()->request->getParam('Userid');
		$client = Yii::app()->request->getParam('Client','0');
		if(!$sid){
			JsonHelper::Notify("","Sid");
		}
		if(!$year){
			JsonHelper::Notify("","Year");
		}
		if(!$week){
			JsonHelper::Notify("","Week");
		}
		if(!$content){
			JsonHelper::Notify("","Content");
		}
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		$menu = Foodmenu::getFoodContent(array('sid'=>$sid,'week'=>$week,'year'=>$year));
		$menu = $menu?$menu:new Foodmenu;
		$menu->sid = $sid;
		$menu->year = $year;
		$menu->week = $week;
		
		$itemArr = array();
		$tmpContent = json_decode($content,true);		
		foreach ($tmpContent as $item) {
			$itemArr[$item['Weekday']] = $item['Text'];
		}
		
		$menu->content = json_encode($itemArr,JSON_UNESCAPED_UNICODE);
		
		$user = Member::model()->findByPk($userid);
		$school = School::model()->findByPk($sid);

		if($menu->save()){
            $grades = School::getSchoolGradesArr($sid);
            $allGrades = array();
            foreach($grades as $gk=>$gv){
				$allGrades[] = $gk;
			}
            if(!empty($allGrades)){ //只给学生发,给全校的所有年级
                $receive = array("3" => implode(",", $allGrades));
                $weekName = array('星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日');
                
                $content = json_decode($content, true);
                $itemArr = array();
                foreach ($content as $item) {
                	$itemArr[$item['Weekday']] = $item['Text'];
                }

                $tmp = array();
                $startend = MainHelper::getWeekDate($menu->year, $menu->week);
                $str = "第".$menu->week."周 (".$startend[0]."~".$startend[1].")\r\n";
                $con = array();
                $con['title'] = "第".$menu->week."周 (".$startend[0]."~".$startend[1].")";
                foreach($content as $c){
                	$con['menu'][] = array_change_key_case($c);
                }
                foreach ($itemArr as $k => $val) {
                    if($val == "早餐：\r\n午餐：\r\n晚餐："){
                        $val = "";
                    }
                    $str .= $weekName[$k - 1] . "：" . $val . "\r\n";
                }
                $notice = new Notice;
				$notice->sender = $userid;
				$notice->receiver = json_encode($receive);
				$notice->noticetype = 8;
				$notice->sendertitle = $user->name.'老师';
				$notice->receivertitle = '';
				$notice->content = json_encode(array('content'=>$str,'text'=>$con), JSON_UNESCAPED_UNICODE);
				$notice->sendtime = date('Y-m-d H:i:s',time());
				$notice->issendsms = 1;
				$notice->state = 0;
				$notice->sid = $sid;
				$notice->schoolname = $school->name;
				$notice->receivename = '全校学生';
				$notice->platform = $client;
				$notice->save();
            }else{

            }
            $menu->ispublish = 1;
            $menu->publishnum = $menu->publishnum + 1;
            $menu->save();
            $data = array("Noticeid"=>$notice->noticeid,"Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Result"=>"-8","Message"=>"操作失败本次操作没有执行");
		}
		echo JsonHelper::JSON($data);
	}

	public function actionUploadfile()
	{
		$file= '';
		if(isset($_FILES['upfile'])){
			$filename = CUploadedFile::getInstanceByName("upfile");
            $newfile = MainHelper::uploadImg($filename,$dir='client/teacherclient');
            if($newfile){
            	$file = $newfile;
            }
		}
		if($file){
			$data = array("Filename"=>Yii::app()->request->hostInfo.$file,"Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Result"=>"-8","Message"=>"操作失败本次操作没有执行");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 读取餐单
     * panrj,zengp 2014-11-05
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionGetfoodmenu()
	{
		$sid = Yii::app()->request->getParam('Sid');
		$year = Yii::app()->request->getParam('Year');
		$week = Yii::app()->request->getParam('Week');
		if(!$sid){
			JsonHelper::Notify("","Sid");
		}
		if(!$year){
			JsonHelper::Notify("","Year");
		}
		if(!$week){
			JsonHelper::Notify("","Week");
		}
		$menu = Foodmenu::getFoodContent(array('sid'=>$sid,'week'=>$week,'year'=>$year));
		if($menu){
			$content = json_decode($menu->content,true);
			$new_content = array();
			foreach($content as $k=>$v){
				$new_content[] = array('Weekday'=>$k,'Text'=>$v);
			}
			$menuArr = array('Id'=>$menu->id,'Year'=>$menu->year,'Week'=>$menu->week,'Content'=>$new_content);
			$data = array("Foodmenu"=>$menuArr,"Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Foodmenu"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 通知评论数
     * panrj,zengp 2014-11-05
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionGetreplaynum()
	{
		$noticeid = Yii::app()->request->getParam('Noticeid');
		if(!$noticeid){
			JsonHelper::Notify("","Noticeid");
		}
		$pks = explode(',',$noticeid);
		$arr = array();
		foreach($pks as $nid){
			$replays = NoticeReply::countNoticeReplaies($nid);
			$arr[] = array('Noticeid'=>$nid,'Number'=>$replays);
		}
		$data = array("Comments"=>$arr,"Result"=>"0","Message"=>"操作成功");
		echo JsonHelper::JSON($data);
	}

	/**
     * 添加点评
     * panrj,zengp 2014-11-05
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionAddreplay()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$noticeid = Yii::app()->request->getParam('Noticeid');
		$content = Yii::app()->request->getParam('Content');
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		if(!$noticeid){
			JsonHelper::Notify("","Noticeid");
		}
		if(!$content){
			JsonHelper::Notify("","Content");
		}

		$replay = new NoticeReply;
		$replay->sender = $userid;
		$replay->noticeid = $noticeid;
		$replay->content = $content;
		$replay->receiver = 0;
		if($replay->save()){
			$data = array("Replyid"=>$replay->replyid,"Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Result"=>"-8","Message"=>"操作失败本次操作没有执行");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 返回模版类型列表
     * panrj,zengp 2014-11-05
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionTemplatekinds()
	{
		$arr = array();
		$arr[] = array('Id'=>0,'Name'=>'系统模版');
		$arr[] = array('Id'=>1,'Name'=>'自定义模版');
		$data = array("Kinds"=>$arr,"Result"=>"0","Message"=>"操作成功");
		echo JsonHelper::JSON($data);
	}

	/**
     * 返回模版类型列表
     * panrj,zengp 2014-11-05
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionSavetemplate()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$kind = Yii::app()->request->getParam('Kind','');
		$content = Yii::app()->request->getParam('Content');
		$type = Yii::app()->request->getParam('Type','');
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		if(!$content){
			JsonHelper::Notify("","Content");
		}
		if($kind==''){
			JsonHelper::Notify("","Kind");
		}
		if($type==''){
			JsonHelper::Notify("","Type");
		}

		$template = new Template;
		$template->creater = $userid;
		$template->kind = $kind;
		$template->type = $type;
		$template->content = $content;
		if($template->save()){
			$data = array("Id"=>$template->tid,"Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Result"=>"-8","Message"=>"操作失败本次操作没有执行");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 返回模版类型列表
     * panrj,zengp 2014-11-05
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionGettemplates()
	{
		$userid = Yii::app()->request->getParam('Userid','');
		$kind = Yii::app()->request->getParam('Kind','');
		$type = Yii::app()->request->getParam('Type','');
		$lasttime = Yii::app()->request->getParam('Lasttime','');
		$lastid = Yii::app()->request->getParam('Lastid','');
		$unit = Yii::app()->request->getParam('Unit','20');

		if($kind==''){
			JsonHelper::Notify("","Kind");
		}
		if($kind==1 && !$userid){
			JsonHelper::Notify("","Userid");
		}

		$tempaltes = Template::getTemplates(array('creater'=>$userid,'kind'=>$kind,'type'=>$type,'lasttime'=>$lasttime,'lastid'=>$lastid),$unit);
		if(count($tempaltes)){
			$arr = array();
			foreach($tempaltes as $t){
				$arr[] = array('Type'=>$t->type,'Kind'=>$t->kind,'Content'=>addslashes($t->content),'Time'=>strtotime($t->creationtime),'Tid'=>$t->tid);
			}
			$data = array("Tempaltes"=>$arr,"Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Tempaltes"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 返回通知评论列表
     * panrj,zengp 2014-11-05
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionNoticecoments()
	{
		$noticeId = Yii::app()->request->getParam('Noticeid');
		$lasttime = Yii::app()->request->getParam('Lasttime','');
		$lastid = Yii::app()->request->getParam('Lastid','');
		$unit = Yii::app()->request->getParam('Unit','20');
		if(!$noticeId){
			JsonHelper::Notify("","Noticeid");
		}

		$comments = NoticeReply::getNoticeComments($noticeId,array('lasttime'=>$lasttime,'lastid'=>$lastid),$unit);
		if(count($comments)){
			$arr = array();
			foreach ($comments as $item) {
				$arr[] = array('Replyid'=>$item->replyid,'Userid'=>$item->sender,'Name'=>$item->u->name,'Content'=>$item->content,'Time'=>strtotime($item->creationtime));
			}	
			$data = array("Comments"=>$arr,"Result"=>"0","Message"=>"操作成功");	
		}else{
			$data = array("Comments"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 意见反馈
     * panrj,zengp 2014-11-11
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionFeedback()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$content = Yii::app()->request->getParam('Content','');
		$type = Yii::app()->request->getParam('Clienttype','');
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		if($content==''){
			JsonHelper::Notify("","Content");
		}
		if($type==''){
			JsonHelper::Notify("","Clienttype");
		}

		$model = new Feedback;
		$model->userid = $userid;
		$model->clientside = 1;
		$model->content = $content;
		$model->clienttype = $type;
		if($model->save()){
			$data = array("Id"=>$model->fid,"Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Result"=>"-8","Message"=>"操作失败本次操作没有执行");
		}
		echo JsonHelper::JSON($data);

	}

	/**
     * 删除模板
     * panrj,zengp 2014-11-18
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionDeletetemplate(){
		$tid = Yii::app()->request->getParam('Tid');
		if(!$tid){
			JsonHelper::Notify("","Tid");
		}
		$tmplate = Template::model()->findByPk($tid);
		$tmplate->deleted = 1;
		if($tmplate->save()){
			$data = array("Result"=>"0","Message"=>"操作成功");
		}else{
			$data = array("Result"=>"-8","Message"=>"操作失败本次操作没有执行");
		}
		echo JsonHelper::JSON($data);
	}

}