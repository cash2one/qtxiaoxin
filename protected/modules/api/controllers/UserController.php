<?php
/**
 * 前台用户接口数据
 * panrj 2014-10-14
 */
class UserController extends SingleSignController
{
	protected function beforeAction($action) {
		$data = array("Result"=>"-6","Message"=>"暂无相关数据");
		echo JsonHelper::JSON($data);
		exit;
		return parent::beforeAction($action);
    }
    
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
     * 认证账号与密码
     * panrj 2014-10-14
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionAccount()
	{
		$uname = Yii::app()->request->getParam('Username');
		$pwd = Yii::app()->request->getParam('Pwd');
		$role = Yii::app()->request->getParam('Identity','1');
		$guid = Yii::app()->request->getParam('Guid');

		if(!$uname){
			JsonHelper::Notify("","Username");
		}
		if(!$pwd){
			JsonHelper::Notify("","Pwd");
		}
		if(!$role){
			JsonHelper::Notify("","Identity");
		}
		// if(!$time){
		// 	JsonHelper::Notify("","Time");
		// }

		// $now = time();
  //       $t = $now - $time;

  //       if($t>=1800){
  //       	$data = array("Result"=>"-18","Message"=>"登陆超时");
  //   		echo JsonHelper::JSON($data);exit;
  //       }

		$is_mobile = is_numeric($uname) && strlen($uname)==11;
    	if($is_mobile){
    		$account = 'mobilephone';
    	}else{
    		$is_email = CheckHelper::IsMail($uname);
    		if($is_email){
    			$account = 'email';
    		}else{
    			$account = 'account';
    		}
    	}
    	// $users=Member::model()->findByAttributes(array($account=>$uname,'identity'=>$role,'deleted'=>0));
    	$users = Member::getUniqueMember($uname,$role,$account);
    	if($users===null){
    		$data = array("Result"=>"-18","Message"=>"您的账号不存在或者已经被删除");
    		echo JsonHelper::JSON($data);exit;
    	}
    	$pwd = strtolower(md5(strtolower($pwd) . "DBK_0715"));
    	$record=$users;
    	if($record->pwd!=$pwd){
    		$data = array("Result"=>"-5","Message"=>"您输入的密码不正确");
    	}else{
    		if($guid){
    			$single = SingleSign::setGuidByUserid($record->userid,$guid);
    		}
    		$record->lastlogintime = date("Y-m-d H:i:s");
            $record->save(); 
    		$ext = $record->getUserExt();
    		$school_relations = SchoolTeacherRelation::getTeacherSchoolDuties($record->userid);
    		$schoolArr = array();

    		foreach($school_relations as $sr){
    			$schoolArr[] = array('Schoolid'=>$sr->sid,'Schoolname'=>$sr->s->name,'Role'=>$sr->role->name);
    		}
    		$data = array(
    			"Userid"=>$record->userid,
    			"Name"=>$record->name,
    			"Photo"=>$ext->photo?$ext->photo:Yii::app()->request->hostInfo.'/image/xiaoxin/pic_ioc.jpg',
    			"Sex"=>$record->sex,
    			"Schools" =>$schoolArr,
    			"Result"=>"0",
    			"Message"=>"操作成功"
    		);
    	}
    	$data['Timestamp'] = time();
        echo JsonHelper::JSON($data);
	}

	/**
     * 修改密码
     * panrj 2014-10-14
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionChangepwd()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$old = Yii::app()->request->getParam('Old');
		$new = Yii::app()->request->getParam('New');
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		if(!$old){
			JsonHelper::Notify("","Old");
		}
		if(!$new){
			JsonHelper::Notify("","New");
		}

		$user = Member::model()->findByPk($userid);
		if($user && $user->deleted==0){
			$old = strtolower(md5(strtolower($old) . "DBK_0715"));
			if($user->pwd==$old){
				$new = strtolower(md5(strtolower($new) . "DBK_0715"));
				$user->pwd = $new;
				if($user->save()){
					$data = array(
		    			"Result"=>"0",
		    			"Message"=>"操作成功"
		    		);
				}else{
					$data = array(
		    			"Result"=>"-1",
		    			"Message"=>"服务器异常"
		    		);
				}
			}else{
				$data = array(
	    			"Result"=>"-20",
	    			"Message"=>"旧密码不正确"
	    		);
			}
		}else{
			$data = array("Result"=>"-18","Message"=>"您的账号不存在或者已经被删除");
		}
		echo JsonHelper::JSON($data);
	}

	/**
	 * 发送验证码
	 * panrj 2014-10-14
	 */
	public function actionSendcode()
	{
		$mobile = Yii::app()->request->getParam('Mobile');
		$ty = Yii::app()->request->getParam('Ty','pwd');
		$role = Yii::app()->request->getParam('Identity','1');
		if(!$mobile){
			JsonHelper::Notify("","Mobile");
		}
		$user = Member::getUniqueMember($mobile);
		if($user){
			$userid = $user->userid;
			$cache=Yii::app()->cache;
			$key = "ucmobile_".$ty.'_'.$userid;
			$timekey = $key.'_'.date('Ymd');
			$time = $cache->get($timekey);
			if($time && $time>=3){
				$data = array(
	    			"Result"=>"-3",
	    			"Message"=>"每天最多能发三次"
	    		);
	    		echo JsonHelper::JSON($data);
	    		exit;
			}

			$code = MainHelper::generate_code(6);
			$msg = "尊敬的用户，您本次获得的验证码是:".$code."，请勿告诉他人。";
			UCQuery::sendMobileMsg($mobile,$msg);
			
			$time = $time?$time+1:1;
			$cache->set($timekey,$time,172800);
			$cache->set($key,$code,1800);
			$data = array(
    			"Result"=>"0",
    			"Message"=>"操作成功"
    		);

		}else{
			$data = array(
    			"Result"=>"-4",
    			"Message"=>"手机号无效"
    		);
		}
		echo JsonHelper::JSON($data);
	}

	/**
	 * 重置密码
	 * panrj 2014-10-14
	 */
	public function actionResetpwd()
	{
		$mobile = Yii::app()->request->getParam('Mobile');
		$ty = Yii::app()->request->getParam('Ty','pwd');
		$code = Yii::app()->request->getParam('Verifycode');
		$role = Yii::app()->request->getParam('Identity','1');
		$pwd = Yii::app()->request->getParam('Pwd');
		if(!$mobile){
			JsonHelper::Notify("","Mobile");
		}
		if(!$code){
			JsonHelper::Notify("","Verifycode");
		}
		if(!$pwd){
			JsonHelper::Notify("","pwd");
		}

		$user = Member::getUniqueMember($mobile);
		if($user){
			$userid = $user->userid;
			$key = "ucmobile_" . $ty . '_' . $userid;
	        $cache = Yii::app()->cache;
	        $cachecode = $cache->get($key);
            if ($cachecode == $code){
            	$user->pwd = strtolower(md5(strtolower($pwd) . "DBK_0715"));;
            	if($user->save()){
            		$data = array(
		    			"Result"=>"0",
		    			"Message"=>"操作成功"
		    		);
            	}else{
            		$data = array(
		    			"Result"=>"-1",
		    			"Message"=>"服务器异常"
		    		);
            	} 
            }else{
            	$data = array(
	    			"Result"=>"-23",
	    			"Message"=>"验证码错误"
	    		);
            }

		}else{
			$data = array(
    			"Result"=>"-4",
    			"Message"=>"手机号无效"
    		);
		}
		echo JsonHelper::JSON($data);
	}

	/**
     * 个人设置
     * panrj 2014-10-29
     * @param string $REQUST 客户端请求参数
     * @return string json
     */
	public function actionSetting()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$name = Yii::app()->request->getParam('Name','');
		$sex = Yii::app()->request->getParam('Sex','');
		if(!$userid){
			JsonHelper::Notify("","Userid");
		}
		// if(!$name){
		// 	JsonHelper::Notify("","Name");
		// }
		if($name!='' || $sex!=''){
			$user = Member::model()->findByPk($userid);
			if($user && $user->deleted==0){
				$user->name = $name?$name:$user->name;
				$user->sex = $sex?$sex:$user->sex;
				if($user->save()){
					$data = array(
		    			"Result"=>"0",
		    			"Message"=>"操作成功"
		    		);
				}else{
					$data = array(
		    			"Result"=>"-1",
		    			"Message"=>"服务器异常"
		    		);
				}
			}else{
				$data = array("Result"=>"-18","Message"=>"您的账号不存在或者已经被删除");
			}
		}else{
			$data = array("Result"=>"-8","Message"=>"操作失败本次操作没有执行");
		}
		
		echo JsonHelper::JSON($data);
	}

	/**
	 * 使用帮助
	 * panrj 2014-10-14
	 */
	public function actionHelper()
	{
		$data = array("Url"=>XIAOXIN_CLIENT_TOOL_TEACHER_HELPER,"Result"=>"0","Message"=>"操作成功");
		echo JsonHelper::JSON($data);
	}

	/**
	 * 使用条款
	 * panrj 2014-10-14
	 */
	public function actionProvision()
	{
		$url = USER_BRANCH=='03'?CDDS_CLIENT_TOOL_TEACHER_PROVISION:XIAOXIN_CLIENT_TOOL_TEACHER_PROVISION;
		$data = array("Url"=>$url,"Result"=>"0","Message"=>"操作成功");
		echo JsonHelper::JSON($data);
	}

	/**
	 * 版本更新
	 * panrj 2014-10-14
	 */
	public function actionVersion()
	{
		
		$type = Yii::app()->request->getParam('Client','1');	
		
		$version = ClientVersion::getVersion($type);
		$info = array();
		if($version){
			
			$info['Need'] = $version->need;
			$info['Url'] = $version->url;
			$info['Remark'] = $version->remark;
			$info['Size'] = sprintf('%.1f',$version->size/1024) . 'M';
			$info['Date'] = date('Y-m-d',strtotime($version->creationtime));
			if(isset($version['imgs']) && $version['imgs']){
				$imgArr = explode(',',$version['imgs']);
				$imgs = array();
				foreach ($imgArr as $item) {
					// $imgs[] = Yii::app()->request->hostInfo . $item;
					$imgs[] = $item;
				}
				$info['Imgs'] = $imgs;
			}
			$info['Version'] = $version->version;
		}
		$data = array("Info"=>$info,"Result"=>"0","Message"=>"操作成功");
		echo JsonHelper::JSON($data);
	}

	/**
	 * 青豆快报
	 * panrj,zengp 2014-12-05
	 */
	public function actionQdreport()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$lastdate = Yii::app()->request->getParam('Lastdate');
		$lastdate = !isset($lastdate) ? date('Y-m-d',time() - 24*60*60) . ' 24' : $lastdate;

		$user = Member::model()->findByPk($userid);
		//$beans = BeanLog::getBeans($userid,$lastdate);
		$beans = BeanAcquire::getBeans($userid,$lastdate);


		$score = $user->bean;
		if(strlen($score) < 6){
			$len = 5 - strlen($score);
			for($i = 0; $i< $len; $i++){
				$score = '0' . $score;
			}
		}		
		$scoreArr = str_split($score);

		//$nextDate = isset($beans[0]['oldDate'])?date('Y-m-d',strtotime($beans[0]['oldDate'])+24*60*60):date('Y-m-d',strtotime($lastdate)+48*60*60);
        $preDate = isset($beans[1]['oldDate'])?date('Y-m-d',strtotime($beans[1]['oldDate'])):'';
       // $nextUrl = $nextDate ? Yii::app()->createUrl('/api/user/qdreport?Userid='.$userid.'&Lastdate=') . $nextDate : '';
        $preUrl = $preDate ? Yii::app()->createUrl('/api/user/qdreport?Userid='.$userid.'&Lastdate=') . $preDate : '';

		$this->renderpartial('qdreport',array('userid'=>$userid,'beans'=>$beans,'score'=>$scoreArr,'preUrl'=>$preUrl,'lastdate'=>$lastdate));
	}

	/**
	 * 青豆积分规则
	 * panrj,zengp 2014-12-05
	 */
	public function actionQdrule()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$this->renderpartial('qdrule',array('userid'=>$userid));
	}

	/**
	 * 青豆商城
	 * panrj,zengp 2014-12-08
	 */
	public function actionQdmall()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$this->renderpartial('qdmall',array('userid'=>$userid));
	}

}