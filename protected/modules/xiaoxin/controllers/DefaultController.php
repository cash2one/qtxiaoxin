<?php

class DefaultController extends Controller
{
    /**
     * Declares class-based actions.
     */
    // public function actions()
    // {
    // 	return array(
    // 		// captcha action renders the CAPTCHA image displayed on the contact page
    // 		'captcha'=>array(
    // 			'class'=>'CCaptchaAction',
    // 			'backColor'=>0xFFFFFF,
    // 		),
    // 		// page action renders "static" pages stored under 'protected/views/site/pages'
    // 		// They can be accessed via: index.php?r=site/page&view=FileName
    // 		'page'=>array(
    // 			'class'=>'CViewAction',
    // 		),
    // 	);
    // }

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

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('login', 'setpwd', 'sendcode', 'getpwd', 'remote', 'findmobile', 'activeverify', 'activeuser', 'searchaccount', 'updateaccount','checkparentmobile'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'account', 'password', 'logout', 'uploadfile', 'mobile', 'checkcode', 'getpwd', 'setpwd','gotonewplatform'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * 校信老师登陆页面
     * panrj 2014-08-09
     */
    public function actionLogin()
    {
       // $this->redirect(NEW_PLATFORM_DOMAIN);
        $model = new ULoginForm;
        $userinfo = '';
        // collect user input data
        // $_POST['ULoginForm']['username']='xiaoxin';
        // $_POST['ULoginForm']['password']='123456';
        // conlog($_POST['ULoginForm']);
        if (isset($_POST['ULoginForm'])) {
            $model->attributes = $_POST['ULoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $uid = Yii::app()->user->id;
                $userinfo = Yii::app()->user->getInstance();
                $identity = Yii::app()->user->getIdentity(); //获取是老师还是家长方式登录,只有1(老师方式登录才执行下面)
                //获取我在学校的职务
                if ($identity == 1) {
                    $schoolTeachers = SchoolTeacherRelation::getTeachersSchoolRaletion($uid);
                    $dutys = array();
                    foreach ($schoolTeachers as $val) {
                        if ($val->duty) {
                            $dutys[] = $val->duty;
                        }
                    }
                    $appid = array();
                    if (count($dutys)) {
                        $appid = DutyApplicationRelation::getDutyAppIdArr($dutys);

                    }


                }
                Yii::app()->getRequest()->redirect(Yii::app()->user->getReturnUrl());
                // $this->redirect('index');
            }

        }
        // display the login form
        $this->renderPartial('login', array('model' => $model));
    }
    
    /**
     * 旧用户跳转到新平台(班班)
     * zengp 2015-02-02
     */
    public function actionGotonewplatform(){
        
        $userid = Yii::app()->user->id;
        $time = date('Y-m-d H:i:s', time());
        $pass = md5(md5($userid . $time . 'qtbanban'));
        $identity = Yii::app()->user->getIdentity();
        $url = NEW_PLATFORM_DOMAIN . '/index.php/site/remote?userid='.$userid.'&time='.$time.'&pass='.$pass.'&identity='.$identity;
        Yii::app()->controller->redirect($url);
        
    }

    /**
     * 校信用户登录接口
     * panrj 2014-08-23
     */
    public function actionRemote()
    {
        //userid=1&time=2014-08-23%2016:40:31&pass=023799cd5a5dee094f0766480a64dbc4
        $userid = Yii::app()->request->getParam('userid');
        $time = Yii::app()->request->getParam('time');
        $pass = Yii::app()->request->getParam('pass');
        $role = Yii::app()->request->getParam('identity', '');
        $url = Yii::app()->request->getParam('url');
        if (!$role) {
            echo '<html><head><meta charset="UTF-8"></head>请确认用户身份后再登陆</html>';
            exit;
        }

        $pre_site = Yii::app()->request->getParam('plant');
        if ($pre_site == 'backend') {
            $time = date('Y-m-d H:i:s', time());
            $pass = md5(md5($userid . $time . 'cdds'));
        }
        $now = time();
        $past = strtotime($time);
        $t = $now - $past;

        if ($t < 1800) {
            $hash = md5(md5($userid . $time . 'cdds'));
            if ($hash == $pass) {
                // $model = new ULoginForm;
                $user = Member::model()->findBypk($userid);
                if ($user) {
                    if ($pre_site != 'backend') {
                        $user->lastlogintime = date("Y-m-d H:i:s");
                        $user->lastloginip = Yii::app()->request->getUserHostAddress();
                        $user->save();
                    }

                    $identity = new RemoteUserIdentity($user, $role);
                    Yii::app()->user->login($identity);
                    if($url){
                        $this->redirect($url);
                    }else{
                        $this->redirect(Yii::app()->createUrl('xiaoxin/default/index'));    
                    }
                    
                } else {
                    echo '<html><head><meta charset="UTF-8"></head>该用户不存在,请验证后再登陆</html>';
                    exit;
                }
            }
        } else {
            echo '<html><head><meta charset="UTF-8"></head>请求数据已过期,请重新登陆</html>';
            exit;
        }
    }

    /**
     * 校信老师首页
     * panrj 2014-08-09
     */
    public function actionIndex()
    {
        $NoticeType = Constant::noticeTypeArray();
        // conlog(Yii::app()->user->getRealName());
        $userinfo = Yii::app()->user->getInstance();
        $uid = Yii::app()->user->id;
        $identity = Yii::app()->user->getIdentity(); //获取是老师还是家长登录
        if (!$identity || empty($identity) || empty($uid)) {
            $this->redirect(Yii::app()->createUrl("xiaoxin/default/login"));
        }
        $receiver = $uid;
        if ($identity == 4) { //如果家长方式登录，改先查我的孩子，再用in查询，用find_in_set,sguardian太慢，数据大点，完蛋
            $myChilds = Guardian::getChilds($uid);
            $myChildUids = array();
            foreach ($myChilds as $guardian) {
                $myChildUids[] = $guardian->child;
            }
            if (count($myChildUids)) {
                $receiver = implode(",", $myChildUids);
            } else { //没有孩子
                $receiver = 0;
            }

        }
        $data = array();
        $isApproveRight = false;
        $time = date("Y-m-d");

        //获取学校id
        if ($identity == 1) { //如果是老师方式登录，再判断有没有审核权限
            $sids = array();
            $isApprove = false;
            $approvePersonList = NoticeQuery::checkApprove($uid); //获取有审核权限的学校id
            if (!empty($approvePersonList)) {
                $isApproveRight = true;
                foreach ($approvePersonList as $val) {
                    $sids[] = $val['sid'];
                }
                $sid = implode(",", $sids);


                //待审核数
                $time = date("Y-m-d H:i:s");

                $data['unApproveNum'] = NoticeQuery::getNum("tb_notice_fixedtime", " and sid in($sid) and `status`=0  and deleted=0 ");
            }

            //获取我在学校的职务
            $schoolTeachers = SchoolTeacherRelation::getTeachersSchoolRaletion($uid);
            $dutys = array();

            foreach ($schoolTeachers as $val) {
                if ($val->duty) {
                    $dutys[] = $val->duty;
                }
            }


        }
        // $data['hasApproveNum'] = NoticeQuery::getNum("tb_notice_fixedtime", " status>0  approveid=$uid and deleted=0");
        //未读消息数;a

        if ($identity == 4) {
            $data['unReadNum'] = NoticeQuery::getNum("tb_notice_message", " and receiver in($receiver)    and deleted=0 and `read`=0 ");
        } else {
            $data['unReadNum'] = NoticeQuery::getNum("tb_notice_message", " and receiver=$uid   and deleted=0 and `read`=0 ");
        }
        if ($identity == 4) {
            $data['inviteNum'] = NoticeQuery::getNum("tb_notice_message", " and receiver in($receiver)    and deleted=0 and noticetype in(6) ");
        } else {
            $data['inviteNum'] = NoticeQuery::getNum("tb_notice_message", " and receiver=$uid    and deleted=0 and noticetype in(6) ");
        }
        //待已发通知数
        // $data['sendNum'] = NoticeQuery::getNum("tb_notice", " and  sender=$uid and deleted=0  ");
        //最新通知  取3条;
        $newsNotice = NoticeQuery::getNewsMessage($receiver, 3, $identity);

        foreach ($newsNotice as $k => $val) {
            $newsNotice[$k] = $this->assemblyNotice($val);
        }
        foreach ($newsNotice as $k => $val) {
            if ($val['noticetype'] == 2 || $val['noticetype'] == 7) {
                $newsNotice[$k]['typedesc'] = '通知';
            }
        }
        if ($identity == 1) { //老师端收到的最新评论，自己发的
            $newsReply = NoticeQuery::getNewsReply($identity, $uid, 4);
        } else { //家长端收到的最新评论，孩子消息的
            $newsReply = NoticeQuery::getNewsReplyByChild($receiver);
        }

        $userIds = array();
        if ($newsReply) {
            foreach ($newsReply as $k => $v) {
                //if(isset($v['creationtime'])&&$v['sendtime']){
                $newsReply[$k]['showtime'] = (substr($v['creationtime'], 0, 10) == date("Y-m-d")) ? ('今天 ' . substr($v['creationtime'], 11, 5)) : substr($v['creationtime'], 0, 16);
                $newsReply[$k]['typedesc'] = $NoticeType[$v['noticetype']] ? $NoticeType[$v['noticetype']] : '';
                // }
                if ($v['nameless'] == 1) {
                    $newsReply[$k]['showusername'] = '匿名';
                } else {
                    $userIds[] = $v['sender'];
                }
            }
        }


        $userIds[] = $uid;
        if (count($userIds) > 0) {
            //去uc获取用户头像及名称
            $replyUser = NoticeQuery::getUserNamePhoto(implode(",", ($userIds)));
        }

        $userrelation = array();
        if (!empty($replyUser)) {
            foreach ($replyUser as $v) {
                $userrelation[$v['userid']] = $v;
            }
        }

        foreach ($newsReply as $k => $v) {

            if ($v['nameless']) {
                $newsReply[$k]['photo'] = Yii::app()->request->baseUrl . '/image/xiaoxin/default_pic.jpg'; //匿名
            } else {
                if ($newsReply[$k]['sguardian']) {
                    $newsReply[$k]['photo'] = Member::defaultPhoto($newsReply[$k]['sguardian']);
                } else {
                    $newsReply[$k]['photo'] = Member::defaultPhoto($newsReply[$k]['sender']);
                }
            }
            if ($v['nameless'] == 1) {
                $newsReply[$k]['username'] = '匿名人';
            } else {
                $guardian_one = null;
                if ($v['sguardian']) {
                    $guardian = (int)$v['sguardian'];
                    $guardian_one = Guardian::getRelationByChildGuardian($guardian, $v['sender']);
                }
                $newsReply[$k]['username'] = isset($userrelation[$v['sender']]['name']) ? $userrelation[$v['sender']]['name'] : '';
                if ($guardian_one) {
                    $newsReply[$k]['username'] .= "&nbsp;的&nbsp;" . ($guardian_one->role ? $guardian_one->role : '家长'); //显示小明的爸爸说：hi,这孩子好熊
                }
                // $newsReply[$k]['username'] = $v['nameless']?"匿名人":(isset($userrelation[$v['sender']])?$userrelation[$v['sender']]['name']:'');
            }

        }

        $systemNotice = array();
        $this->render('index', array('identity' => $identity, 'data' => $data, 'isApproveRight' => $isApproveRight, 'newsNotice' => $newsNotice, 'newsReply' => $newsReply, 'systemNotice' => $systemNotice));
    }

    /**
     * 账号设置-基本信息
     * panrj 2014-08-09
     */
    public function actionAccount()
    {
        $model = Yii::app()->user->getInstance();
        $ext = Yii::app()->user->getExtInstance();

        if (isset($_POST['Account'])) {
            $info = $_POST['Account'];
            $model->name = $info['name'] ? $info['name'] : $model->name;
            $model->sex = $info['sex'] ? $info['sex'] : $model->sex;
            $model->save();
            $ext->photo = $info['photo'] ? $info['photo'] : $ext->photo;
            $ext->save();
            Yii::app()->msg->postMsg('success', '操作成功');
            $this->redirect('account');
        }
        $this->render('account', array('model' => $model));
    }

    /**
     * 账号设置-修改密码
     * panrj 2014-08-09
     */
    public function actionPassword()
    {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->logout();
            $this->redirect('login');
        }
        $user = Yii::app()->user->getInstance();
        if ($user->deleted) {
            Yii::app()->user->logout();
            $this->redirect(Yii::app()->login);
        }

        $model = new UChangePasswordForm;
        // collect user input data
        if (isset($_POST['UChangePasswordForm'])) {
            $model->attributes = $_POST['UChangePasswordForm'];
            if ($model->validate() && $model->changePassword()) {
                Yii::app()->msg->postMsg('success', '操作成功');
                $this->redirect($this->action->id);
            }
        }
        $this->render('password', array('model' => $model));
        // $this->render('password');
    }

    public function actionFindmobile()
    {
        $this->render('findmobile');
    }

    /**
     * 账号设置-绑定手机
     * panrj 2014-08-09
     */
    public function actionMobile()
    {
        if (isset($_POST['Account']['mobile']) && $_POST['Account']['mobile']) {
            $userid = Yii::app()->user->id;
            $sql = "CALL php_xiaoxin_UpdateUserMobilephone('" . $userid . "','" . $_POST['Account']['mobile'] . "')";
            $errors = UCQuery::updateTrans($sql);
            if (!$errors) {
                Yii::app()->msg->postMsg('success', '操作成功');
            } else {
                if ($errors == 2) {
                    Yii::app()->msg->postMsg('error', '该号码已被绑定');
                } else {
                    Yii::app()->msg->postMsg('error', '操作失败');
                }
            }
            $this->redirect($this->action->id);
        }
        $this->render('mobile');
    }

    /**
     * 账号设置-绑定手机-发送验证码
     * panrj 2014-08-14
     * $ty 验证码类型：旧密码，新密码，重置密码
     */
    public function actionSendcode()
    {
        $mobile = Yii::app()->request->getParam('mobile');
        $ty = Yii::app()->request->getParam('ty');
        $role = Yii::app()->request->getParam('role');
        $userid = Yii::app()->user->id;
        if (Yii::app()->user->isGuest && $role && $mobile) {
            // $sql = "CALL php_xiaoxin_GetUserByAttributes('" . $mobile . "','mobilephone','" . $role . "')";
            // $user = UCQuery::queryRow($sql);
            $user = Member::getUniqueMember($mobile);
            if ($user === null) {
                echo '该手机号码尚未绑定用户！';
                exit;
            }
            $userid = $user->userid;
        }
        if ($mobile && $ty) {
            if ($ty == 'old') {
                $is_usermobile = UCQuery::checkUserMobile($userid, $mobile);
                if (!$is_usermobile) {
                    echo '当前手机号码有误！';
                    exit;
                }
            }
            $cache = Yii::app()->cache;
            // $key = "ucmobile_".$ty.'_'.$mobile;
            $key = "ucmobile_" . $ty . '_' . $userid;
            $timekey = $key . '_' . date('Ymd');
            $time = $cache->get($timekey);
            if ($time && $time >= 3) {
                echo '每天最多能发三次';
                exit;
            }

            $code = MainHelper::generate_code(6);
            // $code = '123456';
            $msg = "尊敬的用户，您本次获得的验证码是：" . $code."，请勿告诉他人。";
            UCQuery::sendMobileMsg($mobile, $msg,11);

            // $sql = "CALL fn_AddSmsMessage('".$mobile."','10001','101','".$code."','【蜻蜓校信】',0,1)";
            // $connection = Yii::app()->db_msg;
            // $connection->createCommand($sql)->execute();

            $time = $time ? $time + 1 : 1;
            $cache->set($timekey, $time, 172800);
            $cache->set($key, $code, 1800);

            echo 'success';
        } else {
            echo '发送失败';
        }
    }

    /**
     * 账号设置-绑定手机-检验验证码
     * panrj 2014-08-14
     * $ty 验证码类型：旧密码，新密码，重置密码
     */
    public function actionCheckcode()
    {
        $mobile = Yii::app()->request->getParam('mobile');
        $code = Yii::app()->request->getParam('code');
        $ty = Yii::app()->request->getParam('ty');
        $userid = Yii::app()->user->id;
        // $key = "ucmobile_".$ty.'_'.$mobile;
        $key = "ucmobile_" . $ty . '_' . $userid;
        $cache = Yii::app()->cache;
        $cachecode = $cache->get($key);
        $msg = $cachecode ? '验证码有误，请输入正确验证码' : '验证码已过期，请重新获取验证码';
        if ($mobile && $code && $ty) {
            if ($cachecode == $code) {
                $msg = 'success';
            }
        }
        echo $msg;
    }

    public function actionUrl()
    {
        $this->render('url');
    }

    public function actionGetpwd()
    {
        $mobile = Yii::app()->request->getParam('mobile');
        $code = Yii::app()->request->getParam('code');
        $ty = 'pwd';
        if ($mobile && $code) {
            $result = array('state' => 'error', 'msg' => '验证失败');
            // $sql = "CALL php_xiaoxin_GetUserByAttributes('" . $mobile . "','mobilephone','" . $role . "')";
            // $user = UCQuery::queryRow($sql);
            $user = Member::getUniqueMember($mobile);
            if ($user !== null) {
                $cache = Yii::app()->cache;
                // $key = "ucmobile_".$ty.'_'.$mobile;
                $key = "ucmobile_" . $ty . '_' . $user->userid;
                $cachecode = $cache->get($key);
                $result['msg'] = $cachecode ? '验证码有误，请输入正确验证码' : '验证码已过期，请重新获取验证码';
                if ($cachecode == $code) {
                    $result = array('state' => 'success', 'msg' => $user->userid);
                }
            } else {
                $result['msg'] = '手机号码无效';
            }
            echo JsonHelper::JSON($result);
            exit;
        }
        $this->renderPartial('getpwd');
    }

    public function actionSetpwd()
    {

        if (isset($_POST['User'])) {
            $uid = $_POST['User']['uid'];
            $pwd = $_POST['User']['pwd'];
            $newpwd = MainHelper::encryPassword($pwd);
            $sql = "CALL php_xiaoxin_UpdateUserPwd('" . $uid . "','" . $newpwd . "')";
            $errors = UCQuery::updateTrans($sql);
            if (!$errors) {
                Yii::app()->msg->postMsg('success', '操作成功');
                $this->redirect(Yii::app()->createUrl('xiaoxin/default/login'));
            }
        }
        $this->renderPartial('setpwd');
    }

    public function actionUploadfile()
    {
        $root = YiiBase::getPathOfAlias('webroot');
        $filename = CUploadedFile::getInstanceByName("upload_file");
        if (is_object($filename)) {
            $exts = is_object($filename) ? $filename->extensionName : "jpg";
            $newName = date('YmdHis') . rand(1000, 9999) . '.' . $exts;
            $folder = 'storage/images/upload/' . date('Ym') . '/';
            MainHelper::createFolder($folder);
            $filename->saveAs($root . '/' . $folder . $newName);
            echo Yii::app()->request->hostInfo . '/' . $folder . $newName;
        } else {
            echo '';
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        
        $this->redirect('/index.php/xiaoxin/default/login');
    }

    private function assemblyNotice($data)
    {
        $noticeType = Constant::noticeTypeArray();
        $data['typedesc'] = $noticeType[strval($data['noticetype'])] ? $noticeType[strval($data['noticetype'])] : ''; //通知中文说明
        $evaluatetypeArr = Constant::evaluatetypeArr();
        if ($data['noticetype'] == Constant::NOTICE_TYPE_3) {
            $data['typedesc'] .= "<span class='conduct'>（<font>" . $evaluatetypeArr[(int)$data['evaluatetype']] . "</font>）</span>";
        }
        $data['showtime'] = (substr($data['sendtime'], 0, 10) == date("Y-m-d")) ? ('今天 ' . substr($data['sendtime'], 11, 5)) : substr($data['sendtime'], 0, 16);
        $data['content'] = str_replace("\r\n", "<br/>", $data['content']);
        $data['content'] = str_replace("\t", "&nbsp;&nbsp;", $data['content']);
        $content = json_decode($data['content'], true);
        if (is_string($content['content'])) {
            $data['content'] = nl2br($content['content']);
            $data['content'] = str_replace("\t", "&nbsp;&nbsp;", $data['content']);
        }
        if (isset($content['text']) && is_array($content['text']) && $data['noticetype'] == Constant::NOTICE_TYPE_8) { //新的餐单保存方式
            $weekArr = array('1' => '星期一', '2' => '星期二', '3' => '星期三', '4' => '星期四', '5' => '星期五', '6' => '星期六', '7' => '星期天');
            $data['content'] = $content['text']['title'] . "</br>";
            foreach ($content['text']['menu'] as $kk => $vv) {
                $vv = array_change_key_case($vv);
                $data['content'] .= $weekArr[$vv['weekday']] . "：" . str_replace("\r\n", "&nbsp;", $vv['text']) . "</br>";
            }
        } else if (isset($content['text']) && is_array($content['text']) && $data['noticetype'] == Constant::NOTICE_TYPE_5) {
            if(isset($content['text']['showtype'])){
                $str = "<span style='width:70px; display:inline-block; '>学校</span>：</span>" .$data['schoolname'] . "</br><span style='width:70px; display:inline-block; '>班级</span>：" . $content['text']['classname'] . "".(isset($content['text']['term'])?("<span style='width:70px; display:inline-block; '>学期</span>：" . $content['text']['term']):''). "</br> <span style='width:70px; display:inline-block; '>考试类型</span>：" . $content['text']['examtype'] . "</br><span style='width:70px; display:inline-block; '>考试名称</span>：" . $content['text']['name'] . "</br>";
                $str.="</br>（成绩通知单）</br><span style='width:70px; display:inline-block; '>姓名</span>：" . (isset($content['text']['studentname'])?$content['text']['studentname']:'') . "</br> ";
                if(isset($content['text']['exam'])&&is_array($content['text']['exam'])){
                    $str.="<span style='width:70px; display:inline-block; '>成绩</span>：";
                    foreach($content['text']['exam'] as $kk=>$exam){
                        $str.=$exam['subject']."：".($content['text']['showtype']==1?$exam['score']:$exam['level'])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    }
                    if(isset($content['text']['showave'])&&$content['text']['showave']){
                        $str.="</br><span style='width:70px; display:inline-block; '>班级平均分</span>：";
                        foreach($content['text']['exam'] as $exam){
                            $str.=$exam['subject']."：".$exam['average']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        }

                    }
                    if(isset($content['text']['evaluation'])&&$content['text']['eval']){
                        $str.="</br><span style='width:70px; display:inline-block; '>考评</span>：".$content['text']['evaluation'];
                    }

                }
                $data['content']=$str;
            }
        }

        // $content = json_decode($data['content'], true);
        //$data['content'] = nl2br($content['content']);
        // $data['content'] = str_replace("\t", "&nbsp;&nbsp;", $data['content']);
        if ($data['noticetype'] == Constant::NOTICE_TYPE_0) { //系统通知
            $data['showclass'] = "systemNico";
        } else if ($data['noticetype'] == Constant::NOTICE_TYPE_4) { //紧急通知
            $data['showclass'] = "sosNico";
        } else if ($data['noticetype'] == Constant::NOTICE_TYPE_1) {
            $data['showclass'] = "homeNico";
        } else if ($data['noticetype'] == Constant::NOTICE_TYPE_6) {
            $data['showclass'] = "inviteNicio";
        } else if ($data['noticetype'] == Constant::NOTICE_TYPE_7) {
            $data['showclass'] = "classNico";
        } else if ($data['noticetype'] == Constant::NOTICE_TYPE_2 || $data['noticetype'] == Constant::NOTICE_TYPE_5 || $data['noticetype'] == Constant::NOTICE_TYPE_6) {
            $data['showclass'] = "schoolNico";
        } else if ($data['noticetype'] == Constant::NOTICE_TYPE_3) {
            $data['showclass'] = "conductNicio";
        } else if ($data['noticetype'] == Constant::NOTICE_TYPE_8) {
            $data['showclass'] = "foodNicio";
        } else {
            $data['showclass'] = ""; //通知显示的class每种通知class不同
        }
        if (!empty($data['read'])) {
            $data['readMsg'] = '';
        } else {
            $data['readMsg'] = '未读';
        }
        if (isset($content['images'])) {
            $data['images'] = $content['images'];
        } else {
            $data['images'] = array();
        }
        foreach ($data['images'] as $k => $v) {
            if (is_string($v)) {
                $data['images'][$k] = CLIENT_FILE_DOWNLOAD_URL . "?ac=getfile&Type=17&Name=" . $v;
            } else if (is_array($v)) {
                $data['images'][$k] = CLIENT_FILE_DOWNLOAD_URL . "?ac=getfile&Type=17&Name=" . $v['url'];
            }
        }
        //web上上传的图片，保存在七牛云
        if (isset($content['pictures'])) {
            $data['pictures'] = $content['pictures'];
        } else {
            $data['pictures'] = array();
        }

        foreach ($data['pictures'] as $val) {
            if(is_array($val)&&isset($val['url'])){
                $data['images'][] = STORAGE_QINNIU_XIAOXIN_XX . $val['url'];
            }else if(is_string($val)){
                $data['images'][] = STORAGE_QINNIU_XIAOXIN_XX . $val;
            }
        }

        if (isset($content['medias'])) {
            $data['medias'] = $content['medias'];
        } else {
            $data['medias'] = array();
        }
        if (isset($data['medias']['url'])) {
            $data['medias']['name'] = $data['medias']['url'];
            $data['medias']['url'] = CLIENT_FILE_DOWNLOAD_URL . "?ac=getfile&Type=18&Name=" . $data['medias']['url'];
        }

        if (isset($content['videos'])) {
            $data['videos'] = $content['videos'];
        } else {
            $data['videos'] = array();
        }
        $data['receivername'] = '';
        if (isset($data['rguardian'])) {
            if ($data['receiver'] !== $data['rguardian']) {
                if ($data['receiver'] && $data['noticetype'] != Constant::NOTICE_TYPE_6) {
                    $recerverinfo = Member::model()->findByPk($data['receiver']);
                    $data['receivername'] = '发给：&nbsp' . ($recerverinfo ? $recerverinfo->name : '');
                }
            }
        }
        //通知图片ad
        return $data;
    }

    public function actionActiveverify()
    {
        if (isset($_POST['Activity'])) {
            $code = trim($_POST['Activity']['code']);
            $password = trim($_POST['Activity']['password']);
            $type = (int)$_POST['Activity']['role'];
            if (!empty($code) && !empty($password)) {
                $codeinfo = UCQuery::deidInviteCode($code);
                if ($codeinfo == '') {
                    Yii::app()->msg->postMsg('error', '您输入的邀请码有误，请确认后再输入');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/default/activeverify/"));
                }
                if ($type != $codeinfo['type']) {
                    Yii::app()->msg->postMsg('error', '您输入的邀请码与当前身份不对应，请确认后再输入');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/default/activeverify/"));
                }

                // $sql = "call php_xiaoxin_activeverify('$code','$password',$type)";
                // $codeinfo = UCQuery::queryRow($sql);
                $codeinfo = Cdkey::activeVerify($code, $password, $type);
                if ($codeinfo) {
                    if ($codeinfo->type == 0 && !empty($codeinfo->userid)) {
                        Yii::app()->msg->postMsg('error', '该邀请码已被绑定');
                        $this->redirect(Yii::app()->createUrl("xiaoxin/default/activeverify/"));
                    } else {
                        Yii::app()->msg->postMsg('success', '校验成功');
                        $this->redirect(Yii::app()->createUrl("xiaoxin/default/activeuser/" . $codeinfo->id));
                    }
                } else {
                    Yii::app()->msg->postMsg('error', '您输入的邀请码或邀请码密码有误，请确认后再输入');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/default/activeverify/"));
                }

            }
        }
        $this->renderPartial('activeverify');
    }

    public function actionActiveuser($id)
    {
        $codeinfo = UCQuery::loadTableRecord('tb_cdkey', $id);
        if ($codeinfo->type == 1 && $codeinfo->userid) {
            $userinfo = UCQuery::loadUser($codeinfo->userid);
        } else {
            $userinfo = '';
        }
        if (isset($_POST['Activeuser'])) {
            $type = $_POST['Activeuser']['type'];
            $name = $_POST['Activeuser']['name'];

            $mobilephone = $_POST['Activeuser']['mobilephone'];
            $password = $_POST['Activeuser']['password'];
            $password2 = $_POST['Activeuser']['password2'];
            $password = MainHelper::encryPassword($password);
            $userVersion = (int)USER_BRANCH;
            if ($type == 0) { //老师
                // $sql = "CALL php_xiaoxin_Activeteacher($codeinfo->cid,'$name','$password','$mobilephone',$codeinfo->id,$userVersion)";

                UCQuery::execute("LOCK TABLE `tb_user_maxid` WRITE;");
                // $success = UCQuery::queryScalar($sql);
                $success = Cdkey::activeTeacher($codeinfo->cid, $name, $password, $mobilephone, $codeinfo->id);
                UCQuery::execute("UNLOCK TABLES;");

                if ($success == 0) {
                    Yii::app()->msg->postMsg('success', '激活老师用户成功,手机端登陆需1小时后生效');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/default/login/"));
                } else if ($success == 2) {
                    Yii::app()->msg->postMsg('error', '激活用户失败,老师手机已绑定');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/default/activeuser/$id"));
                } else {
                    Yii::app()->msg->postMsg('error', '激活用户失败了');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/default/activeuser/$id"));
                }
            } else { //家长
                $studentid = isset($_POST['Activeuser']['studentid']) ? $_POST['Activeuser']['studentid'] : '';
                // $sql = "CALL php_xiaoxin_Activestudent($codeinfo->cid,'$name','$password','$mobilephone',$codeinfo->id,$userVersion,'$studentid')";

                UCQuery::execute("LOCK TABLE `tb_user_maxid` WRITE;");
                $success = Cdkey::activeStudent($codeinfo->cid, $name, $password, $mobilephone, $codeinfo->id, $studentid);
                UCQuery::execute("UNLOCK TABLES;");

                if ($success == 0) {
                    Yii::app()->msg->postMsg('success', '激活家长用户成功,手机端登陆需1小时后生效');
                    $this->redirect(Yii::app()->createUrl("xiaoxin/default/login/"));
                } else {
                    Yii::app()->msg->postMsg('error', '激活用户失败');
                }
            }


        }
        $this->renderPartial('activeuser', array('codeinfo' => $codeinfo, 'student' => $userinfo));
    }

    public function actionCheckmobile()
    {
        $mobile = (int)Yii::app()->request->getParam("mobile", "");
        $codeid = (int)Yii::app()->request->getParam("codeid", "");
    }

    /*
   * 根据学生姓名查找学校下所有包含该名的学生
   */
    public function actionSearchaccount()
    {
        if (isset($_POST['search'])) {
            $sid = (int)Yii::app()->request->getParam("sid", '0');
            $name = trim(Yii::app()->request->getParam("name", ''));
            $studentList = array();
            if ($sid && $name) {
                $studentList = ClassStudentRelation::getStudentBySidAndName($sid, $name, true);
            } else {
                die(json_encode(array('status' => 0, 'data' => $studentList, 'num' => count($studentList), 'msg' => '参数不全')));
            }
            die(json_encode(array('status' => 1, 'data' => $studentList, 'num' => count($studentList))));
        }else{
            $this->renderPartial("searchaccount", array());
        }

    }

    public function actionUpdateaccount()
    {
        if (isset($_POST['data'])) {
            foreach ($_POST['data'] as $key => $val) {
                $member = Member::model()->findByPk($val['userid']);
                $member->account = $val['account'];
                $member->mobilephone = $val['mobilephone'];
                $password=isset($val['password'])?trim($val['password']):'';
                if(!empty($password)&&$password!="******"){
                    $member->pwd = MainHelper::encryPassword($password);
                }
                $member->save();
            }
            $cid=isset($_POST['cid'])?(int)($_POST['cid']):0;
            $userid=isset($_POST['userid'])?(int)($_POST['userid']):0;
            Yii::app()->msg->postMsg('success', '修改成功');
           // $this->redirect(Yii::app()->createUrl("xiaoxin/default/updateaccount?userid=".$userid.'&cid='.$cid));
            $this->redirect(Yii::app()->createUrl("xiaoxin/default/login"));
        }
        $userid=Yii::app()->request->getParam("userid",0);
        $cid=Yii::app()->request->getParam("cid");

        $mclass=null;
        $studentExt=null;
        $guardians=array();
        $userinfo=null;
        if($cid&&$userid){
            $userinfo=Member::model()->findByPk($userid);

            $mclass=MClass::model()->findByPk($cid);
            $studentExt=StudentExt::model()->findByPk($userid);
            $guardian_list = Guardian::getChildGuardianRelation($userid);
            foreach ($guardian_list as $guardian) {
                if($guardian->guardian0&&$guardian->guardian0->deleted==0){
                    $guardians[] = array('ext'=>$studentExt,'account' => $guardian->guardian0->account, 'mobilephone' => $guardian->guardian0->mobilephone, 'userid' => $guardian->guardian);
                }
            }

        }
        $this->renderPartial("updateaccount", array('userinfo'=>$userinfo,'guardians'=>$guardians,'class'=>$mclass,'ext'=>$studentExt));
    }
    /*
    * 校验家长手机号是否已被绑定
    *
    */
    public function actionCheckparentmobile()
    {
        $mobilephone = Yii::app()->request->getParam("mobilephone", '');
        $account = Yii::app()->request->getParam("account", '');
        $uid = Yii::app()->request->getParam("userid", '0');
        $isBind = false;
        if (isset($_GET['mobilephone'])&&$uid) {
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

            die(json_encode(array('status' => '1', 'isBind' => $isBind ? '1' : '0')));
        }
        if (isset($_GET['account'])&&$uid) {
                $member = Member::getMemberByAccount($account);
                if ($member) {
                    $info = $member;
                    if ($info->userid == $uid) { //是自己的手机
                        $isBind = false;
                    } else { //不是自己的手机号，并且已经在数据库中
                        $isBind = true;
                    }

                } else { //多于1个
                    $isBind = false;
                }
            die(json_encode(array('status' => '1', 'isBind' => $isBind ? '1' : '0')));
        }

    }


}