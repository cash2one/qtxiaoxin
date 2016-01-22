<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-8-9
 * Time: 上午9:47
 */

class NoticeController extends Controller
{
    //0系统消息；1家庭作业；2学校通知家长；3在校表现；4紧急通知；5成绩通知；6邀请 7:通知老师
    const SYSTEM_NOTICE = 0;
    const HOMEWORK_NOTICE = 1;
    const SCHOOL_NOTICE_FAMILY = 2;
    const SCHOOL_CONDUCT = 3;
    const RUSH_NOTICE = 4;
    const SCORE_NOTICE = 5;
    const INVITE_NOTICE = 6;
    const SCHOOL_NOTICE_TEACHER = 7;
    const GETNOTICETYPE0 = 0; //存储过程调用收件箱消息的type
    const GETNOTICETYPE1 = 1; //存储过程调用发件箱消息的type


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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'noticecenter', 'receivelist', 'sendlist', 'unsendlist', 'publish',
                    'detail', 'senddetail', 'unsenddetail', 'reply', 'updateread', 'getmember', 'replylist', 'homework', 'homework',
                    'noticefamily', 'noticeteacher', 'noticerush', 'getmember', 'gettime', 'sendlist', 'cancelsend', 'getteacher', 'approvelist'
                , 'approvedetail', 'approve', 'showdetail', 'test','getgrade','notice','checkbadword','gettemplate','addtemplate',
                    'monitoring','deltemplate','conduct','monitoringsenddetail','setreadstate','directsend','getdirector','selectclass'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    public function actionNotice(){
        $this->render("notice");
    }

    /*
     * 进入校信的首页
     */
    public function actionIndex()
    {
        
    }

    /*
     * 消息中心,收件箱
     */
    public function actionNoticecenter()
    {
        $userinfo = Yii::app()->user->getInstance();
        $uid = Yii::app()->user->id;
        $identity = Yii::app()->user->getIdentity(); //获取是老师还是家长方式登录 //获取是老师还是家长
        $data = array();
        $timeType = (int)Yii::app()->request->getParam('timeType'); //时间段查询，用户选择时，一天内，三天内，一周内，一月内，本学期内等
        $type = (int)Yii::app()->request->getParam('type'); //待发还是已发
        $data['noticeType'] = Yii::app()->request->getParam("noticeType"); //通知类型可以是1,2这种，便in查询
        $data['keyword'] = MainHelper::safe_string(trim(Yii::app()->request->getParam("keyword"))); //查询关键字
        $page = (int)Yii::app()->request->getParam("page");
        $data['page'] = empty($page) ? 1 : $page;
        $data['pageSize'] = Yii::app()->request->getParam("pageSize");
        if (!$data['pageSize']) {
            $data['pageSize'] = 4;
        }
        $startend = $this->getTimeStartEnd($timeType);
        $data['start'] = $startend['start'];
        $data['end'] = $startend['end'];
        $uid = (int)Yii::app()->user->id;
        $notReadNum=0;
        if ($type == 0) { //收的
            if ($identity == 4) { // 家长方式登录
                //获取我的孩子uid,用find_in_set用不到索引太慢，所以改先查孩子uid,再查receriver in(孩子uid),会很快)
                $myChilds=Guardian::getChilds($uid);
                $myChildUids=array();
                foreach($myChilds as $guardian){
                    $myChildUids[]=$guardian->child;
                }
                if(count($myChildUids)){
                    $returndata = NoticeQuery::getMessageList($data, 3, implode(",",$myChildUids)); //获取列表
                    $count = NoticeQuery::getMessageCount($data, 3, implode(",",$myChildUids)); //获取记录数，用于分页
                    //家长登录获取我未读的消息记录数
                    $notReadNum=NoticeMessage::updateReadStateByUidNoticeType(implode(",",$myChildUids),$data['noticeType'],2);
                }else{
                    $returndata=array();
                    $count=0;
                }
            } else { //老师方式
                $returndata = NoticeQuery::getMessageList($data, self::GETNOTICETYPE0, $uid); //获取列表
                $count = NoticeQuery::getMessageCount($data, self::GETNOTICETYPE0, $uid); //获取记录数，用于分页
                //老师登录获取我未读的消息记录数
                $notReadNum=NoticeMessage::updateReadStateByUidNoticeType($uid,$data['noticeType'],2);
            }


        } else { //发的消息记录
            $returndata = NoticeQuery::getMessageList($data, self::GETNOTICETYPE1, $uid); //获取列表
            $count = NoticeQuery::getMessageCount($data, self::GETNOTICETYPE1, $uid); //获取记录数，用于分页
        }


            foreach ($returndata as $k => $val) {
               $returndata[$k] = $this->assemblyNotice($val);
           }

        /*
         * 在已收消息中，将通知老师，通知家长都显示为通知
         *
         */
        if($type==0){
            foreach ($returndata as $k => $val) {
                if($val['noticetype']==2||$val['noticetype']==7){
                    $returndata[$k]['typedesc'] ="通知";
                }
            }
        }

        $criteria = new CDbCriteria();
        $pages = new CPagination($count);
        $pages->pageSize = 4;
        $pages->applyLimit($criteria);

        if ($type == 0) { //已收消息
            $this->render("noticecenter", array('data' => $returndata,'notReadNum'=>$notReadNum,'identity'=>$identity, 'pages' => $pages, 'type' => $type, 'noticeType' => $data['noticeType'], 'timeType' => $timeType, 'keyword' => $data['keyword']));
        } else { //已发
            $this->render("noticecentersend", array('data' => $returndata, 'pages' => $pages, 'type' => $type, 'noticeType' => $data['noticeType'], 'timeType' => $timeType, 'keyword' => $data['keyword']));
        }
    }

    /*
     * 发送的待办列表,指定时发送的，比如当前14；00，设置成14:30发送的,可以修改的
     */
    public function actionUnsendlist()
    {
        $navClass = array('1' => 'inIco1', '2' => 'inIco2', '7' => 'inIco3', '4' => 'inIco9','3'=>'inIco4');
        $data = array();
        $timeType = (int)Yii::app()->request->getParam('timeType'); //时间段查询，用户选择时，一天内，三天内，一周内，一月内，本学期内等
        $data['noticeType'] = Yii::app()->request->getParam("noticeType");
        $data['keyword'] = MainHelper::safe_string(trim(Yii::app()->request->getParam("keyword")));
        $page = (int)Yii::app()->request->getParam("page");
        $data['page'] = empty($page) ? 1 : $page;
        $data['pageSize'] = Yii::app()->request->getParam("pageSize");
        if (!$data['pageSize']) {
            $data['pageSize'] = 4;
        }
        $startend = $this->getTimeStartEnd($timeType);
        $data['start'] = $startend['start'];
        $data['end'] = $startend['end'];
        if($timeType==0){
            $data['end'] = date("Y-m-d",strtotime("+1 years"));
        }
        $uid = (int)Yii::app()->user->id;
        $returndata = NoticeQuery::getMessageList($data, 2, $uid); //获取列表
        $count = NoticeQuery::getMessageCount($data, 2, $uid); //获取记录数，用于分页
        foreach ($returndata as $k => $val) {
            $returndata[$k] = $this->assemblyNotice($val);
        }
        $criteria = new CDbCriteria();
        $pages = new CPagination($count);
        $pages->pageSize = 4;
        $pages->applyLimit($criteria);
        $uid = Yii::app()->user->id;
        $myapplication=NoticeQuery::getMyApplication($uid);
        $link=$this->checkislink($data['noticeType'],$myapplication);
        $this->render("unsendList", array('data' => $returndata, 'pages' => $pages, 'link'=>$link,'noticeType' => $data['noticeType'], 'navClass' => $navClass, 'timeType' => $timeType, 'keyword' => $data['keyword']));
    }

    /*
     * 布置作业
     */
    public function  actionHomework()
    {
        $receiveType = (int)Yii::app()->request->getParam("receiveType"); //默认进来先显示班级 1-分级 2个人
        $username = Yii::app()->user->getInstance()->name;
        $uid = Yii::app()->user->id;

        $noticeType = self::HOMEWORK_NOTICE; //家庭作业
        //判断身份是不是老师
        $userinfo = Yii::app()->user->getInstance();
        if ($userinfo->identity != 1&&$userinfo->identity != 5) { //1代表老师身份,
            Yii::app()->msg->postMsg('error', '你没有权限操作');
            $this->redirect(Yii::app()->createUrl('xiaoxin/default/index'));
        }
        $mysids=array();
        $signArr=Sign::getUserSignArr($uid);//获取我的签名表
        if ($receiveType == 0) { //班级
            $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
            foreach ($schoolList as $k => $v) { //我每个学校下面的班级
                if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID1)){
                    unset($schoolList[$k]);
                    continue;
                }
                $mysids[]=$v['sid'];

                $schoolList[$k]['class']=NoticeService::getClassBySidUid($v['sid'],$uid,true);
                if(empty($schoolList[$k]['class'])){
                  //  unset($schoolList[$k]);
                }
            }
            $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,self::HOMEWORK_NOTICE);
        } else if ($receiveType == 1) { //分组
            $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
            foreach ($schoolList as $k => $v) { //我每个学校下面的分组
                if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID1)){
                    unset($schoolList[$k]);
                    continue;
                }

                $mysids[]=$v['sid'];
                $sql_text = " call php_xiaoxin_getTeacherGroupBySid($uid,0,{$v['sid']})";
                $schoolList[$k]['class'] = UCQuery::queryAll($sql_text);
                //D($schoolList[$k]['class']);
                $schoolList[$k]['class']=is_array($schoolList[$k]['class'])?$schoolList[$k]['class']:array();
                $shareGids=GroupPermission::getShareGidsArr($uid,$v['sid'],0); //别的人指定给他可以访问的分组,后面参数为0，表示是学生组,1是老师组
                foreach($shareGids as $val){
                    $schoolList[$k]['class'][]=array('gid'=>$val['gid'],'name'=>$val['name']);
                }
                if(empty($schoolList[$k]['class'])){
                   // unset($schoolList[$k]);
                }
            }
           // D($schoolList);
            $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,self::HOMEWORK_NOTICE);
        } else if ($receiveType == 2) { //个人
            $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
            foreach ($schoolList as $k => $v) { //我每个学校下面的班级
                if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID1)){
                    unset($schoolList[$k]);
                    continue;
                }
                $mysids[]=$v['sid'];

                $schoolList[$k]['class']=NoticeService::getClassBySidUid($v['sid'],$uid);
                if(!is_array($schoolList[$k]['class'])) $schoolList[$k]['class']=array();

                //获取我创建的分组
                $groupList=Group::getUserGroup($uid,$v['sid'],0);

                if(is_array($groupList)) foreach($groupList as $val){
                    $schoolList[$k]['class'][]=array('sid'=>$val->sid,'gid'=>$val->gid,'name'=>$val->name.'(分组)','group'=>'1');
                }

                //获取共享的分组
                $shareGroups=GroupPermission::getShareGidsArr($uid,$v['sid'],0);
                $shareGroups=is_array($shareGroups)?$shareGroups:array();
                foreach($shareGroups as $val){
                    //$groupInfo=Group::model()->findByPk($val['gid']);
                    $schoolList[$k]['class'][]=array('gid'=>$val['gid'],'name'=>$val['name'].'(分组)','group'=>1,'sid'=>$v['sid']);
                }
                //D($schoolList);
            }
            $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,self::HOMEWORK_NOTICE);
        }
        if ($receiveType == 0) { //选择班级页面
            $this->render('homework', array('username' => $username,'isshowsendsms'=>$isshowsendsms, 'signArr'=>$signArr,'schoolList' => $schoolList, 'noticeType' => $noticeType));
        } else if ($receiveType == 1) { //选择分组页面
            $this->render('homework_group', array('username' => $username, 'isshowsendsms'=>$isshowsendsms,'signArr'=>$signArr,'schoolList' => $schoolList, 'noticeType' => $noticeType));
        } else { //选择学生个人页面
            $this->render('homework_person', array('username' => $username, 'isshowsendsms'=>$isshowsendsms,'signArr'=>$signArr,'schoolList' => $schoolList, 'noticeType' => $noticeType));
        }
    }
    
    /*
        * 表扬批评
        */
    public function  actionConduct()
    {
        $receiveType = (int)Yii::app()->request->getParam("receiveType"); //默认进来先显示班级 1-分级 2个人
        $username = Yii::app()->user->getInstance()->name;
        $uid = Yii::app()->user->id;
        $noticeType = self::SCHOOL_CONDUCT; //家庭作业
        $mysids=array();
        //判断身份是不是老师
        $userinfo = Yii::app()->user->getInstance();
        if ($userinfo->identity != 1&&$userinfo->identity != 5) { //1代表老师身份,
            Yii::app()->msg->postMsg('error', '你没有权限操作');
            $this->redirect(Yii::app()->createUrl('xiaoxin/default/index'));
        }
        $signArr=Sign::getUserSignArr($uid);//获取我的签名表
            $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
            foreach ($schoolList as $k => $v) { //我每个学校下面的班级
                if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID4)){
                    unset($schoolList[$k]);
                    continue;
                }
                $mysids[]=$v['sid'];
                $schoolList[$k]['class']=NoticeService::getClassBySidUid($v['sid'],$uid);
                if(!is_array($schoolList[$k]['class'])) $schoolList[$k]['class']=array();

                //获取我创建的分组
                $groupList=Group::getUserGroup($uid,$v['sid'],0);

                if(is_array($groupList)) foreach($groupList as $val){
                    $schoolList[$k]['class'][]=array('sid'=>$val->sid,'gid'=>$val->gid,'name'=>$val->name.'(分组)','group'=>'1');
                }

                //获取共享的分组
                $shareGroups=GroupPermission::getShareGidsArr($uid,$v['sid'],0);
                $shareGroups=is_array($shareGroups)?$shareGroups:array();

                foreach($shareGroups as $val){
                    $schoolList[$k]['class'][]=array('gid'=>$val['gid'],'name'=>$val['name'].'(分组)','group'=>1,'sid'=>$v['sid']);
                }


            }
            $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,self::HOMEWORK_NOTICE);
            $this->render('conduct', array('username' => $username,'isshowsendsms'=>$isshowsendsms,'signArr'=>$signArr, 'schoolList' => $schoolList, 'noticeType' => $noticeType));
    }
    /*
     *通知家长 和面置作业基本相同
     */
    public function actionNoticefamily()
    {
        $noticeType = self::SCHOOL_NOTICE_FAMILY;
        $receiveType = (int)Yii::app()->request->getParam("receiveType"); //默认进来先显示班级 1-分级 2个人
        $username = Yii::app()->user->getInstance()->name;
        $uid = Yii::app()->user->id;
        $mysids=array();
        //判断身份是不是老师
        $userinfo = Yii::app()->user->getInstance();
        if ($userinfo->identity != 1&&$userinfo->identity != 5) { //1代表老师身份,
            Yii::app()->msg->postMsg('error', '你没有权限操作');
            $this->redirect(Yii::app()->createUrl('xiaoxin/default/index'));
        }
        $signArr=Sign::getUserSignArr($uid);//获取我的签名表
        if ($receiveType == 0) {
            $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
            foreach ($schoolList as $k => $v) { //我每个学校下面的班级
                if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID2)){
                    unset($schoolList[$k]);
                    continue;
                }
                $mysids[]=$v['sid'];
                $schoolList[$k]['class']=NoticeService::getClassBySidUid($v['sid'],$uid);
                if(empty($schoolList[$k]['class'])){
                   // unset($schoolList[$k]);
                }

            }
            $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,self::HOMEWORK_NOTICE);
        } else if ($receiveType == 1) {
            $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
            foreach ($schoolList as $k => $v) { //我每个学校下面的分组
                if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID2)){
                    unset($schoolList[$k]);
                    continue;
                }
                $mysids[]=$v['sid'];
                $sql_text = " call php_xiaoxin_getTeacherGroupBySid($uid,0,{$v['sid']})";
                $schoolList[$k]['class'] = UCQuery::queryAll($sql_text);
                $schoolList[$k]['class']=is_array($schoolList[$k]['class'])?$schoolList[$k]['class']:array();
                $shareGids=GroupPermission::getShareGidsArr($uid,$v['sid'],0); //别的人指定给他可以访问的分组,后面参数为0，表示是学生组,1是老师组
                foreach($shareGids as $val){
                    $schoolList[$k]['class'][]=array('gid'=>$val['gid'],'name'=>$val['name']);
                }
                if(empty($schoolList[$k]['class'])){
                   // unset($schoolList[$k]);
                }

            }
            $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,self::HOMEWORK_NOTICE);
        } else if ($receiveType == 2) {
            $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
            foreach ($schoolList as $k => $v) { //我每个学校下面的班级
                if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID2)){
                    unset($schoolList[$k]);
                    continue;
                }
                $mysids[]=$v['sid'];
                $schoolList[$k]['class']=NoticeService::getClassBySidUid($v['sid'],$uid);
                if(!is_array($schoolList[$k]['class'])) $schoolList[$k]['class']=array();
                //获取我的分组
                $groupList=Group::getUserGroup($uid,$v['sid'],0);
                if(is_array($groupList)) foreach($groupList as $val){
                    $schoolList[$k]['class'][]=array('sid'=>$val->sid,'gid'=>$val->gid,'name'=>$val->name.'(分组)','group'=>'1');
                }
                //获取共享的分组
                $shareGroups=GroupPermission::getShareGidsArr($uid,$v['sid'],0);
                $shareGroups=is_array($shareGroups)?$shareGroups:array();

                foreach($shareGroups as $val){
                    $schoolList[$k]['class'][]=array('gid'=>$val['gid'],'name'=>$val['name'].'(分组)','group'=>1,'sid'=>$v['sid']);
                }



            }
            $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,self::HOMEWORK_NOTICE);
        }
        if ($receiveType == 0) {
            $this->render('homework', array('username' => $username, 'isshowsendsms'=>$isshowsendsms,'signArr'=>$signArr,'schoolList' => $schoolList, 'noticeType' => $noticeType));
        } else if ($receiveType == 1) {
            $this->render('homework_group', array('username' => $username, 'isshowsendsms'=>$isshowsendsms,'signArr'=>$signArr,'schoolList' => $schoolList, 'noticeType' => $noticeType));
        } else {
            $this->render('homework_person', array('username' => $username, 'isshowsendsms'=>$isshowsendsms,'signArr'=>$signArr,'schoolList' => $schoolList, 'noticeType' => $noticeType));
        }
    }

    /*
     * 通知老师
     */
    public function actionNoticeteacher()
    {
        $noticeType = self::SCHOOL_NOTICE_TEACHER;
        $username = Yii::app()->user->getInstance()->name;
        $uid = Yii::app()->user->id;
        //判断身份是不是老师
        $userinfo = Yii::app()->user->getInstance();

        if ($userinfo->identity != 1&&$userinfo->identity != 5) { //1代表老师身份,
            Yii::app()->msg->postMsg('error', '你没有权限操作');
            $this->redirect(Yii::app()->createUrl('xiaoxin/default/index'));
        }
        $signArr=Sign::getUserSignArr($uid);//获取我的签名表
        $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
        $mysids=array();
        foreach ($schoolList as $k => $v) { //我每个学校下面的部门
            if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID3)){
                unset($schoolList[$k]);
                continue;
            }
            $mysids[]=$v['sid'];
            $sql_text = " call php_xiaoxin_getTeacherDepartmentInSchool(0,{$v['sid']})";
            $depts = UCQuery::queryAll($sql_text);
            /*  再获取我在这个学校的分组 */
            $sql_text1 = " call php_xiaoxin_getTeacherGroupBySid($uid,1,{$v['sid']})";
            $groups = UCQuery::queryAll($sql_text1);
            $shareGroups=GroupPermission::getShareGidsArr($uid,$v['sid'],1);
            $groups=is_array($groups)?$groups:array();
            $shareGroups=is_array($shareGroups)?$shareGroups:array();
            foreach($shareGroups as $val){
                $groups[]=array('gid'=>$val['gid'],'name'=>$val['name']);
            }
            $schoolList[$k]['depts'] = $depts;
            $schoolList[$k]['groups'] = $groups;
        }
        $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,self::SCHOOL_NOTICE_TEACHER);
        $this->render('noticeteacher', array('username' => $username, 'isshowsendsms'=>$isshowsendsms,'signArr'=>$signArr, 'schoolList' => $schoolList, 'noticeType' => $noticeType));
    }

    /*
    * 通知老师
    */
    public function actionDirectsend()
    {
        $noticeType = self::SCHOOL_NOTICE_TEACHER;
        $username = Yii::app()->user->getInstance()->name;
        $uid = Yii::app()->user->id;
        //判断身份是不是老师
        $userinfo = Yii::app()->user->getInstance();

        if ($userinfo->identity != 1&&$userinfo->identity != 5) { //1代表老师身份,
            Yii::app()->msg->postMsg('error', '你没有权限操作');
            $this->redirect(Yii::app()->createUrl('xiaoxin/default/index'));
        }
        $signArr=Sign::getUserSignArr($uid);//获取我的签名表
        $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表
        foreach ($schoolList as $k => $v) { //我每个学校下面的部门
            if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID3)){
                unset($schoolList[$k]);
                continue;
            }
        }
        $this->render('directsend', array('username' => $username,'signArr'=>$signArr, 'schoolList' => $schoolList, 'noticeType' => $noticeType));
    }

    /*
     * 紧急通知
     */
    public function actionNoticerush()
    {
        $noticeType = self::RUSH_NOTICE;
        $username = Yii::app()->user->getInstance()->name;
        $uid = Yii::app()->user->id;
        //判断身份是不是老师
        $userinfo = Yii::app()->user->getInstance();
        if ($userinfo->identity != 1&&$userinfo->identity != 5) { //1代表老师身份,
            Yii::app()->msg->postMsg('error', '你没有权限操作');
            $this->redirect(Yii::app()->createUrl('xiaoxin/default/index'));
        }
        $signArr=Sign::getUserSignArr($uid);//获取我的签名表
        $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表


        foreach ($schoolList as $k => $v) { //我每个学校下面的年级
            if(!NoticeService::checkMonitorRight($v['sid'],$uid,Constant::APPID9)){
                unset($schoolList[$k]);
                continue;
            }
        }


        $this->render('noticerush', array('username' => $username, 'signArr'=>$signArr,'schoolList' => $schoolList, 'noticeType' => $noticeType));
    }
    public function actionGetgrade(){
        $uid = Yii::app()->user->id;
        $sid = (int)Yii::app()->request->getParam("sid");
        $sql_text = " call php_xiaoxin_getSchoolGrade($sid)";
        $grades= UCQuery::queryAll($sql_text);
        die(json_encode(array('status'=>'1','data'=>$grades)));

    }

    /*
     *
     */
    /*
     *选择班级时输出该班级或分组学生
     */
    public function actionGetmember()
    {
        $uid = Yii::app()->user->id;
        $classId = (int)Yii::app()->request->getParam("classId");// 班级或分组id
        $group = (int)Yii::app()->request->getParam("group");//传1表示是请求分组，传0表示为班级
        $returnType=Yii::app()->request->getParam("returnType","json");
        $member=array();
        if($group==1){
            $groupMembers = GroupMember::getGroupMembersArrName($classId);
            $groupInfo=Group::model()->findByPk($classId);
            foreach($groupMembers as $val){
                $member[]=array('userid'=>$val['userid'],'name'=>$val['name'],'sid'=>$groupInfo?$groupInfo->sid:'');
            }

        }else{
            $classInfo=MClass::model()->findByPk($classId);
            $sql_text = " call php_xiaoxin_getClassStudent($classId)";
            $member = UCQuery::queryAll($sql_text);
            foreach($member as $k=>$val){
                $member[$k]['sid']=$classInfo?$classInfo->sid:'';
            }
        }
        if (!$member) {
            $member = array();
        }
        if($returnType=="html"){
            $this->renderPartial("selectclassstudent", array("classs"=>$member));
        }else{
            die(json_encode(array('status' => '1', 'data' => $member)));
        }

    }

    /*
     * 通知老师时，选择部门后，显示部门老师，选择老师或分组
     */
    public function actionGetteacher()
    {
        $uid = Yii::app()->user->id;
        $id = (int)Yii::app()->request->getParam("id");
        $type = Yii::app()->request->getParam("type");
        $sid=(int)Yii::app()->request->getParam("sid");
        $school =  School::model()->findByPk($sid);
        $member=array();
        $teacherIds=array();
        if($sid&&$type=='school'){
            if($school->enableddirectsend){
                //开启定向发送
                $list = TeachersRelation::getTeachersRelation($uid,$sid);
                if ($list&&$list->teachers) {
                    $userlist = Member::getUsersByUids(explode(",", $list->teachers));
                    if (is_array($userlist)) {
                        foreach ($userlist as $val) {
                            $member[] = array('userid' => $val->userid, 'name' => $val->name);
                        }
                    }
                }

            }else{
                //没有开启定向发送
                $list=SchoolTeacherRelation::getSchoolTeachers(array('sid'=>$sid));
                if(is_array($list)){
                    foreach($list as $val){
                        if($val->teacher&&$val->teacher0){
                            if(!in_array($val->teacher,$teacherIds)){
                                $member[]=array('userid'=>$val->teacher,'name'=>$val->teacher0?$val->teacher0->name:'');
                                $teacherIds[]=$val->teacher;
                            }

                        }

                    }

                }
            }

            die(json_encode(array('status' => '1', 'data' => $member)));
        }

        if ($type == 'dept') { //找出该部门所有老师
            $sql_text = " call php_xiaoxin_getDepartmentTeacher($id)";
        } else if ($type == 'group') { //找出老师分组的同事
            $sql_text = " call php_xiaoxin_GetGroupMemberList($id)";
        }
        $list = UCQuery::queryAll($sql_text);
        if (!$list) {
            $list = array();
        }
        $allTeacher = TeachersRelation::getTeachersRelation($uid,$sid);
        if($allTeacher&&$allTeacher->teachers){
            $tempteacherIds = explode(",", $allTeacher->teachers);
        }else{
            $tempteacherIds = array();
        }

        $member=array();
        if(is_array($list)){
            foreach($list as $val){
                    if($type=="dept"){
                        if($school->enableddirectsend){
                            //开启定向发送
                            if(!in_array($val['userid'],$teacherIds)&&in_array($val['userid'],$tempteacherIds)){
                                $member[]=array('userid'=>$val['userid'],'name'=>$val['name']);
                                $teacherIds[]=$val['userid'];
                            }
                        }else{
                            //没有开启定向发送
                            if(!in_array($val['userid'],$teacherIds)){
                                $member[]=array('userid'=>$val['userid'],'name'=>$val['name']);
                                $teacherIds[]=$val['userid'];
                            }
                        }
                    }else{
                        if($school->enableddirectsend){
                            if(!in_array($val['member'],$teacherIds)&&in_array($val['member'],$tempteacherIds)){
                                $member[]=array('userid'=>$val['member'],'name'=>$val['name']);
                                $teacherIds[]=$val['member'];
                            }
                        }else{
                            if(!in_array($val['member'],$teacherIds)){
                                $member[]=array('userid'=>$val['member'],'name'=>$val['name']);
                                $teacherIds[]=$val['member'];
                            }
                        }
                    }
            }
        }
        die(json_encode(array('status' => '1', 'data' => $member)));
    }

    /*
     * 已发列表
     */
    public function actionSendlist()
    {
        $navClass = array('1' => 'inIco1', '2' => 'inIco2', '7' => 'inIco3', '4' => 'inIco9','3'=>'inIco4');
        $data = array();
        $timeType = (int)Yii::app()->request->getParam('timeType'); //时间段查询，用户选择时，一天内，三天内，一周内，一月内，本学期内等

        $data['noticeType'] = Yii::app()->request->getParam("noticeType");
        $data['keyword'] = MainHelper::safe_string(trim(Yii::app()->request->getParam("keyword")));
        $page = (int)Yii::app()->request->getParam("page");
        $data['page'] = empty($page) ? 1 : $page;
        $data['pageSize'] = Yii::app()->request->getParam("pageSize");
        if (!$data['pageSize']) {
            $data['pageSize'] = 4;
        }
        $startend = $this->getTimeStartEnd($timeType);

        $data['start'] = $startend['start'];
        $data['end'] = $startend['end'];
        $uid = (int)Yii::app()->user->id;
        $returndata = NoticeQuery::getMessageList($data, self::GETNOTICETYPE1, $uid); //获取列表
        $count = NoticeQuery::getMessageCount($data, self::GETNOTICETYPE1, $uid); //获取记录数，用于分页
        foreach ($returndata as $k => $val) {
            $returndata[$k] = $this->assemblyNotice($val);
        }
        $criteria = new CDbCriteria();
        $pages = new CPagination($count);
        $pages->pageSize = 4;
        $pages->applyLimit($criteria);
        $uid = Yii::app()->user->id;
        $myapplication=NoticeQuery::getMyApplication($uid);
        $link=$this->checkislink($data['noticeType'],$myapplication);
        $this->render("sendList", array('data' => $returndata, 'pages' => $pages, 'link'=>$link,'noticeType' => $data['noticeType'], 'timeType' => $timeType, 'keyword' => $data['keyword'], 'navClass' => $navClass));
    }


    /*
     * 发布通知，作业
     */
    public function actionPublish()
    {

        $noticeType = $_POST['noticeType'];
        $sid = 0;

        $uids = isset($_POST['Group']['uid'])?array_unique($_POST['Group']['uid']):array();
        if(empty($uids)){
            Yii::app()->msg->postMsg('error', '发布失败,请选择接收对象');
            $this->redirect(Yii::app()->createUrl('xiaoxin/notice/sendlist?noticeType=' . $noticeType));
            exit();
        }
        $c0 = array();
        $c1 = array();
        $c2 = array();
        $c3 = array();
        $c4 = array();

        if (is_array($uids)) {
            foreach ($uids as $v) {
                $tmp = explode("-", $v);
                //1-0-id  第一个1代表学校id,第二个（0代表个人,1 班级，2分组，3年级，4全体老师)
                $sid = (int)$tmp[0]; //学校id
                if ($tmp[1] == 0) {
                    $c0[] = $tmp[2]; //个人uid
                } else if ($tmp[1] == 1) {
                    $c1[] = $tmp[2]; //班级id
                } else if ($tmp[1] == 2) {
                    $c2[] = $tmp[2]; //组id
                } else if ($tmp[1] == 3) {
                    $c3[] = $tmp[2]; //年级id
                } else if ($tmp[1] == 4) {
                    $c4[] = $tmp[2]; //全样师生
                }
            }
        }

        $receiver = array();
        $family_title='';
        if (count($c0)) { //接收者所有个人id
            $receiver['5'] = implode(",", array_unique($c0)); //保存个人的接收者集合时，为了避免[0]的情况，改为5了
            if($noticeType==2){ //通知家长
               // 这里修改主要是如果小明的家长是李李，小白的家长也是李李，改为小明，小白有家长，小三的家长（显示给老师）
                $familys=array();
                $familys_name=array();
//                foreach($c0 as $userid){
//                       $guardian = Guardian::getChildGuardian($userid); //取出对应孩子在家长id
//                       $guardianids=array();
//                       foreach($guardian as $kkval){
//                           $guardianids[]=$kkval->userid;
//                       }
//                       $familys[$userid]=implode(",",$guardianids);
//                }
//
//                $d=array();
//                $temp = array();
//
//                foreach($familys as $key=>$val){
//
//                    if(in_array($val,$d)){
//                        $temp[$val] = $temp[$val].",".NoticeQuery::getChildGuardian($key,$val,$familys);
//                    }else{
//                        $temp[$val] = NoticeQuery::getChildGuardian($key,$val,$familys);
//                    }
//                    $d[]=$val;
//                }
                if(isset($_POST['receivename'])){
                    $temp=explode(",",$_POST['receivename']);
                    $s=implode("的家长,",$temp);
                    $family_title=$s."的家长";
                }

            }
       }

        if (count($c1)) { //接收者所有班级id
            $receiver['1'] = implode(",", array_unique($c1));
        }
        if (count($c2)) { ////接收者所有分组id
            $receiver['2'] = implode(",", array_unique($c2));
        }
        if (count($c3)) { ////接收者所有年级id
            $receiver['3'] = implode(",", array_unique($c3));
        }
        if (count($c4)) { //这个是全体老师了,写入到message表时，查学校的所有老师
            $receiver['4'] = implode(",", $c4);
        }

        $applyPerson=array();
        if (!empty($noticeType) && !empty($sid)) {
            //获取是否需要审核
            $approve = 0;
            $config = NoticeQuery::getConfig($sid, "notice_approve");
            if ($config) {
                $json = json_decode($config['value'], true);
                $key = "notice_" . $noticeType;
                $approve = isset($json[$key])?(int)$json[$key]:0; //1是代表需要审核
                if($approve){ //如果需要审核，查这个学校的所有能审核的人
                    $applyPerson_temp=NoticeQuery::queryAll("select uid from tb_approve_person where sid=$sid and deleted=0;");
                    if(is_array($applyPerson_temp)){
                        foreach($applyPerson_temp as $k=>$val){
                            $member=Member::model()->findByPk($val['uid']);
                            if($member&&$member->deleted==0){
                                $applyPerson[]=array('name'=>$member->name,'mobilephone'=>$member->mobilephone);
                            }
                        }
                    }
                }
            }
        }
        $issendsms=SmsConfig::checkSendsmsBySidAndNoticeType(array($sid),0); //判断学校是否允许发短信
        if($noticeType==Constant::NOTICE_TYPE_4){ //紧急通知不管什么套餐都要发
            $issendsms=1;
        }

        if (isset($_POST['content'])) {
            $receiver = json_encode($receiver); //接收者集合
            $uid = (int)Yii::app()->user->id;
            $pictures=isset($_POST['pictures'])?$_POST['pictures']:array();
            $data = array();
            $data['uid'] = $uid; //发布者
            $data['sendertitle'] = $_POST['sendertitle']; //发送者签名
            $data['receiver'] = $receiver; //接收人集合
            $data['noticeType'] = (int)$noticeType; //通知类型
            $data['isSendsms'] = 1;//都为1,2015-02-11修改，isset($_POST['isSendsms'])&&$issendsms ? intval($_POST['isSendsms']) : 0; //是否给目标发短信
            $data['receiveTitle'] = $_POST['receivertitle']; //接收者称呼
            $data['fixed_time'] = isset($_POST['fixed_time']) ? $_POST['fixed_time'] : ''; //定时发送时间
            $data['receivename'] = $family_title?$family_title:rtrim($_POST['receivename'],","); //接收人名称集合();
            $data['sid'] = $sid; //学校id
            $data['uname'] = Yii::app()->user->getInstance()->name; //发送人真实姓名
            if(count($pictures)){
                $data['data'] = json_encode(array('content' => strip_tags($_POST['content']),'pictures'=>$pictures), JSON_UNESCAPED_UNICODE);
            }else{
                $data['data'] = json_encode(array('content' => strip_tags($_POST['content'])), JSON_UNESCAPED_UNICODE);
            }
            $data['evaluatetype']=isset($_POST['type'])?((int)($_POST['type'])-1):0;//表扬 or 批评用到，因为与模板参数问题，消息表是0 表扬 1--批评,模板是1 ,2
            $success = NoticeQuery::publishNotice($data, $uid, $approve);
            if ($success && isset($_POST['isSendToMe'])&&$_POST['isSendToMe']) { //是否给自己发送确认短信
                //获取我的手机号

                $userinfo = Yii::app()->user->getInstance();

                $mobile=$userinfo->mobilephone;
                if(!empty($mobile)){
                    $code = '你于:'.date("Y-m-d H:i:s").'发布:'.Constant::getNoticeTypeById($noticeType)."";
                    UCQuery::sendQtxxMsg($mobile,$code);
                }

            }
            if ($success) {
                //发布成功,给审核人发短信
                if($approve){
                    if(!empty($applyPerson)){
                        foreach($applyPerson as $val){
                            if(isset($val['mobilephone'])&&!empty($val['mobilephone'])){
                                $code =$data['uname']. '于:'.date("Y-m-d H:i:s").'发布一条'.Constant::getNoticeTypeById($noticeType).",需要审核，请您尽快审核";
                                UCQuery::sendQtxxMsg($val['mobilephone'],$code);
                            }
                        }
                    }
                }
                Yii::app()->msg->postMsg('success', '发布成功');
            } else {
                Yii::app()->msg->postMsg('error', '发布失败');
            }
            //如果需要审核或是定时发送的，就跳到待发送列表
            if ($approve || !empty($data['fixed_time'])) {
                $this->redirect(Yii::app()->createUrl('xiaoxin/notice/unsendlist?noticeType=' . $noticeType));
            } else {
                $this->redirect(Yii::app()->createUrl('xiaoxin/notice/sendlist?noticeType=' . $noticeType));
            }

        }else{
            Yii::app()->msg->postMsg('error', '发布失败,发送内容为空');
            $this->redirect(Yii::app()->createUrl('xiaoxin/notice/sendlist?noticeType=' . $noticeType));
        }
    }

    /*
     * 消息中心的
     * 通知详情(收件箱的)查tb_notice表
     */
    public function actionDetail($id)
    {
        $userinfo=Yii::app()->user->getInstance();
        $uid = Yii::app()->user->id;
        $identity=Yii::app()->user->getIdentity(); //获取是老师还是家长
        $data = NoticeQuery::getDetail($id, 0); //
        $page = (int)(Yii::app()->request->getParam("page"));
        $pageSize = Yii::app()->request->getParam("pageSize");
        if (!$pageSize) {
            $pageSize = 15;
        }
        $val = $this->assemblyNotice($data);
        $replyList = NoticeQuery::getNoticeReply($data['noticeid'], $page, $pageSize); //aa

        $userIds = array();
        if ($replyList) {
            foreach ($replyList as $k => $v) {
                $replyList[$k]['showtime'] = (substr($v['creationtime'], 0, 10) == date("Y-m-d")) ? ('今天 ' . substr($v['creationtime'], 11, 5)) : substr($v['creationtime'], 0, 16);

                if ($v['nameless'] == 1) {
                    $replyList[$k]['showusername'] = '匿名';
                } else {
                    $userIds[] = $v['sender'];
                }
            }
        }
        $userIds[] = Yii::app()->user->id;

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
        foreach ($replyList as $k => $v) {
            if ($v['nameless']) {
                $replyList[$k]['photo'] = Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';//匿名
            } else {
                if($replyList[$k]['sguardian']){
                    $replyList[$k]['photo'] = Member::defaultPhoto($replyList[$k]['sguardian']);
                }else{
                    $replyList[$k]['photo'] = Member::defaultPhoto($replyList[$k]['sender']);
                }

            }
            //D($replyList[$k]['photo']);
            if ($v['nameless'] == 1) {
                $replyList[$k]['username'] = '匿名人';
            } else {
                $guardian_one=null;
                if($v['sguardian']){
                   $guardian=(int)$v['sguardian'];
                   $guardian_one=Guardian::getRelationByChildGuardian($guardian,$v['sender']);
                }
                $replyList[$k]['username'] = isset($userrelation[$v['sender']]['name'])?$userrelation[$v['sender']]['name']:'';
                if($guardian_one){
                    $replyList[$k]['username'].="&nbsp;的&nbsp;".($guardian_one->role?$guardian_one->role:'家长');//显示小明的爸爸说：hi,这孩子好熊
                }
            }
        }

        if ($data['read'] == 0) { //如果状态为未读，改为已读

            NoticeQuery::updateReadState($id); //更新为已读
            if($data['isappread']==0){
                $noticeinfo=Notice::model()->findByPk($data['noticeid']);
                if($noticeinfo){
                    $noticeinfo->readers= $noticeinfo->readers+1;
                    $noticeinfo->save();
                }
            }
        }

        $info=NoticeMessage::model()->findByPk($id);
        $readusers=!empty($info->readusers)?explode(",",$info->readusers):array();
        if(!in_array($uid,$readusers)){
            $readusers[]=$uid;
            $info->readusers=implode(",",$readusers);
            $info->save();
        }


        if($val['noticetype']==2 ||$val['noticetype']==7){
            $val['typedesc']='通知';
        }

        //未读消息数;
        $replyNum = (int)$val['replyNum'];
        $criteria = new CDbCriteria();
        $pages = new CPagination($replyNum);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $this->render('detail', array('val' => $val,'identity'=>$identity, 'replylist' => $replyList, 'pages' => $pages));
    }

    /*
         * 发送的通知消息详情,主要在发送完后查看发送的详情，本想跟detail,senddetail合并，但各有点不同，还是分开了
         */
    public function actionShowdetail($id)
    {
        //$noticeType=Yii::app()->request->getParam("noticeType");
        $navClass = array('1' => 'inIco1', '2' => 'inIco2', '7' => 'inIco3', '4' => 'inIco9','3'=>'inIco4');
        $data = NoticeQuery::getDetail($id, 1);
        if (empty($data)) {

        }
        $noticeType = $data['noticetype'];
        $data['navClass'] = isset($navClass[$noticeType])?$navClass[$noticeType]:'';
        $shownav = Constant::noticeTypeArray();//array('1' => '布置作业', '2' => '通知家长', '4' => '紧急通知', '7' => '通知老师','3'=>'在校表现','5'=>'餐单管理');
        $val = $this->assemblyNotice($data);
        $page = Yii::app()->request->getParam("page");
        if (!(int)$page) $page = 1;
        $pageSize = Yii::app()->request->getParam("pageSize");
        if (!$pageSize) {
            $pageSize = 15;
        }
        $replyList = NoticeQuery::getNoticeReply($id, $page, $pageSize);
        $userIds = array();
        if ($replyList) {
            foreach ($replyList as $k => $v) {
                $replyList[$k]['showtime'] = (substr($v['creationtime'], 0, 10) == date("Y-m-d")) ? ('今天 ' . substr($v['creationtime'], 11, 5)) : substr($v['creationtime'], 0, 16);
                if ($v['nameless'] == 1) {
                    $replyList[$k]['showusername'] = '匿名';
                } else {
                    $userIds[] = $v['sender'];
                }
            }
        }
        $userIds[] = Yii::app()->user->id;
        if (count($userIds) > 0) {
            //去uc获取用户头像及名称
            $replyUser = NoticeQuery::getUserNamePhoto(implode(",", ($userIds)));
        }

        $userrelation = array();
        if (!empty($replyUser)) {
            foreach ($replyUser as $v) {
                $userrelation[$v['userid']] = $v;
            }
            foreach ($replyList as $k => $v) {
                if ($v['nameless']) {
                    $replyList[$k]['photo'] = Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';//匿名
                } else {
                    if($replyList[$k]['sguardian']){
                        $replyList[$k]['photo'] = Member::defaultPhoto($replyList[$k]['sguardian']);
                    }else{
                        $replyList[$k]['photo'] = Member::defaultPhoto($replyList[$k]['sender']);
                    }

                }
                if ($v['nameless'] == 1) {
                    $replyList[$k]['username'] = '匿名人';
                } else {
                    $guardian_one=null;
                    if($v['sguardian']){
                        $guardian=(int)$v['sguardian'];
                        $guardian_one=Guardian::getRelationByChildGuardian($guardian,$v['sender']);
                    }
                    $replyList[$k]['username'] = isset($userrelation[$v['sender']]['name'])?$userrelation[$v['sender']]['name']:'';
                    if($guardian_one){
                        $replyList[$k]['username'].="&nbsp;的&nbsp;".($guardian_one->role?$guardian_one->role:'家长');
                    }
                }
            }
        }
        $replyNum = (int)$val['replyNum'];
        $criteria = new CDbCriteria();
        $pages = new CPagination($replyNum);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $uid = Yii::app()->user->id;
        $myapplication=NoticeQuery::getMyApplication($uid);
        $link=$this->checkislink($data['noticetype'],$myapplication);
        $this->render('showdetail', array('val' => $val, 'noticeType' => $noticeType,'link'=>$link, 'type' => Constant::noticeTypeArray(), 'replylist' => $replyList,
            'shownav' => $shownav, 'pages' => $pages));
    }

    /*  消息中心
     * 发送的通知消息详情
     */
    public function actionSenddetail($id)
    {
        $userinfo=Yii::app()->user->getInstance();
        $uid = Yii::app()->user->id;
        $identity=$userinfo->identity; //获取是老师还是家长
        $data = NoticeQuery::getDetail($id, 1);
        $val = $this->assemblyNotice($data);
        $page = Yii::app()->request->getParam("page");
        if (!(int)$page) $page = 1;
        $pageSize = Yii::app()->request->getParam("pageSize");
        if (!$pageSize) {
            $pageSize = 15;
        }
        $replyList = NoticeQuery::getNoticeReply($id, $page, $pageSize);
        $userIds = array();
        if ($replyList) {
            foreach ($replyList as $k => $v) {
                $replyList[$k]['showtime'] = (substr($v['creationtime'], 0, 10) == date("Y-m-d")) ? ('今天 ' . substr($v['creationtime'], 11, 5)) : substr($v['creationtime'], 0, 16);
                if ($v['nameless'] == 1) {
                    $replyList[$k]['showusername'] = '匿名';
                } else {
                    $userIds[] = $v['sender'];
                }
            }
        }
        $userIds[] = Yii::app()->user->id;
        if (count($userIds) > 0) {
            //去uc获取用户头像及名称
            $replyUser = NoticeQuery::getUserNamePhoto(implode(",", ($userIds)));
        }

        $userrelation = array();
        if (!empty($replyUser)) {
            foreach ($replyUser as $v) {
                $userrelation[$v['userid']] = $v;
            }
            foreach ($replyList as $k => $v) {
                if ($v['nameless']) {
                    $replyList[$k]['photo'] = Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';//匿名
                } else {
                    if($replyList[$k]['sguardian']){
                        $replyList[$k]['photo'] = Member::defaultPhoto($replyList[$k]['sguardian']);
                    }else{
                        $replyList[$k]['photo'] = Member::defaultPhoto($replyList[$k]['sender']);
                    }

                }
                if ($v['nameless'] == 1) {
                    $replyList[$k]['username'] = '匿名人';
                } else {
                    $guardian_one=null;
                    if($v['sguardian']){
                        $guardian=(int)$v['sguardian'];
                        $guardian_one=Guardian::getRelationByChildGuardian($guardian,$v['sender']);
                    }
                    $replyList[$k]['username'] = isset($userrelation[$v['sender']]['name'])?$userrelation[$v['sender']]['name']:'';
                    if($guardian_one){
                        $replyList[$k]['username'].="&nbsp;的&nbsp;".($guardian_one->role?$guardian_one->role:'家长');
                    }
                }
            }
        }
        $replyNum = (int)$val['replyNum'];
        $criteria = new CDbCriteria();
        $pages = new CPagination($replyNum);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $this->render('senddetail', array('val' => $val, 'identity'=>$identity,'replylist' => $replyList, 'pages' => $pages));
    }







    /*
     * 待发送的通知详情
     */
    public function actionUnsenddetail($id)
    {
        $data = NoticeQuery::getDetail($id, 2);
        $page = Yii::app()->request->getParam("page");
        if (!$page) $page = 1;
        $pageSize = Yii::app()->request->getParam("pageSize");
        if (!$pageSize) {
            $pageSize = 15;
        }
        $replyList = NoticeQuery::getNoticeReply($id, $page, $pageSize);
        $this->render('senddetail', array('data' => $data));
    }

    /*
     * 评论
     */
    public function actionReply()
    {
        $noticeId = (int)$_POST['noticeId'];
        if (empty($noticeId)) {
            //
        } else {
            $data = array();
            $data['noticeId'] = $noticeId;
            $data['content'] = addslashes(strip_tags(trim($_POST['content'])));
            $data['nameless'] = isset($_POST['nameless']) ? (int)$_POST['nameless'] : 0; //是否匿名;
            $uid= Yii::app()->user->id;
            $userinfo=Member::model()->findByPk($uid);
            $identity = Yii::app()->user->getIdentity(); //获取是老师还是家长登录
            if($identity==4){ //家长方式登录
                $data['sguardian']=$uid;
                if(isset($_POST['msgid'])){
                    $msgid=(int)$_POST['msgid'];
                    $noticeInfo=NoticeMessage::model()->findByPk($msgid);
                    $data['uid']=$noticeInfo?$noticeInfo->receiver:$uid;
                }else{
                    $noticeInfo=NoticeMessage::getMessageByFamily($uid,$noticeId);
                    $data['uid']=$noticeInfo?$noticeInfo->receiver:$uid;
                }


            }else{
                $data['uid']=$uid;
                $data['sguardian']='';
            }

            $success = NoticeQuery::insertReply($data);
            if ($success) { //成功
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    die(json_encode(array('status' => '1')));
                } else {
                    Yii::app()->msg->postMsg('success', '回复成功');
                }

                //
            } else {
                //
                if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                    die(json_encode(array('status' => '0')));
                } else {
                    Yii::app()->msg->postMsg('error', '回复失败');
                }
            }
        }
    }


    /*
     * 取消 发送
     */
    public function actionCancelsend()
    {
        $id = (int)Yii::app()->request->getParam("id");
        if ($id) {
            $success = NoticeQuery::cancelSend($id);
            if ($success) {
                die(json_encode(array('status' => '1')));
            } else {
                die(json_encode(array('status' => '1')));
            }
        } else {
            die(json_encode(array('status' => '1', 'msg' => '参数不对')));
        }

    }


    /*
     * 修改待发送通知 ,暂时不需要修改
     */
    public function actionUpdatefixed()
    {
        if ($_POST['content']) {
            $uid = (int)Yii::app()->user->id;
            $data = array();
            $data['uid'] = $uid; //发布者
            $data['userName'] = $_POST['sign']; //发送者签名
            $data['receiveType'] = $_POST['receiveType']; //接收者类型0 个人 1-班级 2－组
            $data['receive'] = $_POST['receive']; //接收人集合
            $data['noticeType'] = $_POST['noticeType']; //通知类型
            $data['isSendsms'] = $_POST['isSendsms']; //是否给自己发短信
            $data['receiveTitle'] = $_POST['receiveTitle']; //接收人集合
            $data['fixed_time'] = $_POST['sendTime']; //定时发送时间
            $data['data'] = array('content' => $_POST['content'],
                'title' => $_POST['title'],
                'url' => $_POST['url']
            );
            $success = NoticeQuery::updateFixedNotice($data, $uid);
            if ($success) {
                //修改成功
                Yii::app()->msg->postMsg('success', '发布成功');
            } else {
                Yii::app()->msg->postMsg('error', '发布失败');
            }
        }
    }

    /*
     * 审核列表,根据status来确定是待审核还是已审核，审核不通过
     */
    public function actionApprovelist()
    {
        $data = array();
        $uid = Yii::app()->user->id;
        $approve_sid = NoticeQuery::getMyApprovePersonByUid($uid);
        if (empty($approve_sid)) {
            Yii::app()->msg->postMsg('error', '你没有权限审核');
            $this->redirect(Yii::app()->createUrl('xiaoxin/default/index'));
        }
        $sids = array();
        foreach ($approve_sid as $v) {
            $sids[] = $v['sid'];
        }
        $status = Yii::app()->request->getParam('status'); //待审核状态 0 --待审核 1--已审核  2--审核不通过
        $timeType = (int)Yii::app()->request->getParam('timeType'); //时间段查询，用户选择时，一天内，三天内，一周内，一月内，本学期内等
        $data['noticeType'] = Yii::app()->request->getParam("noticeType");
        $data['keyword'] = MainHelper::safe_string(trim(Yii::app()->request->getParam("keyword")));

        $page = Yii::app()->request->getParam("page");
        if (!$page) $page = 1;
        $data['page'] = empty($page) ? 1 : $page;
        $data['pageSize'] = (Yii::app()->request->getParam("pageSize"));
        if (!$data['pageSize']) {
            $data['pageSize'] = 4;
        }
        $startend = $this->getTimeStartEnd($timeType);
        $data['start'] = $startend['start'];
        $data['end'] = $startend['end'];

        $data['status'] = $status;
        $data['sid'] = implode(",", $sids);
        $uid = (int)Yii::app()->user->id;

        $returndata = NoticeQuery::getApproveList($data, self::GETNOTICETYPE1, 1); //获取列表
        $res = NoticeQuery::getApproveList($data, self::GETNOTICETYPE1, 0); //获取记录数
        $count = $res[0]['num'];
        foreach ($returndata as $k => $val) {
            $returndata[$k] = $this->assemblyNotice($val);
        }
        $criteria = new CDbCriteria();
        $pages = new CPagination($count);
        $pages->pageSize = 4;
        $pages->applyLimit($criteria);

        //if ($status == 0) {
        $this->render("approveList", array('data' => $returndata, 'pages' => $pages, 'status' => $status, 'noticeType' => $data['noticeType'], 'timeType' => $timeType, 'keyword' => $data['keyword']));
        // }
    }

    public function actionApprove()
    {
        $uid = Yii::app()->user->id;
        $checkApprove = NoticeQuery::checkApprove($uid);
        $status = $_POST['status']; //待审核状态 0 --待审核 1--已审核  2--审核不通过
        $reason = isset($_POST['reason']) ? $_POST['reason'] : ''; //审核不通过的原因
        $noticeIds = $_POST['id']; //通知ids,1223,2333格式
        $success = NoticeQuery::approve($uid, $status, $reason, $noticeIds);
        if($status==2){ //审核不通过，发送短信
            $ids=explode(",",$noticeIds);
            foreach($ids as $noticeid){
                $noticeInfo=NoticeFixedtime::model()->findByPk($noticeid);
                if($noticeInfo&&$noticeInfo->sender){
                    $member=Member::model()->findByPk($noticeInfo->sender);
                    if($member&&$member->mobilephone){
                        $code = '你于:'.$noticeInfo->sendtime.'发布:'.Constant::getNoticeTypeById($noticeInfo->noticetype).",审核不通过,不通过原因:".$reason;
                        UCQuery::sendQtxxMsg($member->mobilephone,$code);
                    }
                }
            }
        }
        if ($success) {
            //***
            die(json_encode(array('status' => '1')));
        } else {
            die(json_encode(array('status' => '0')));
        }
    }


    private function getTimeStartEnd($timeType)
    {
        $start = 0;
        $end = date("Y-m-d H:i:s");
        if ($timeType == 1) { //本周 从周一:00:00:00开始到今天
            $curtime=time();
            $curweekday = date('w');
            $curweekday = $curweekday?$curweekday:7;
            $curmon = $curtime - ($curweekday-1)*86400;
            $cursun = $curtime + (7 - $curweekday)*86400;
            $start = date("Y-m-d",$curmon);
            $end=date("Y-m-d",$cursun)." 23:59:59";
        } else if ($timeType == 2) { //上周一:00:00:00周上周日23:59:59
            $lflag1 = '-1';
            $lflag2 = '-2';
            $curtime=time();
            $curweekday = date('w');
            $curweekday = $curweekday?$curweekday:7;
            $end = date("Y-m-d 23:59:59", strtotime(date('Y-m-d', strtotime("$lflag1 week Sunday"))));
            if($curweekday==1){
                $start=date('Y-m-d',strtotime('-1 monday', time()));
            }else{
                $start=date('Y-m-d',strtotime('-2 monday', time()));
            }


        } else if ($timeType == 3) { //本月  本月1号 00:00:00到当天
            $start = date("Y-m-01");
        } else if ($timeType == 4) { //上月1号 00:00:00到上月底 23:59:59
            $start = date("Y-m-01", strtotime("-1 months"));
            $end = date("Y-m-t", strtotime("-1 months"));
        } else if ($timeType == 5) { //本学期 如果是9月1号后，2.1号前，则是下学期，大于9.1的消息，否则是大于2.1号的消息
            $m = (int)date("m");
            if ($m >= 9 || $m < 2) {
                $start = date("Y-09-01");
            } else {
                $start = date("Y-02-01");
            }
        } else {
            $start = date("Y-m-d", strtotime("-1000 days"));
            $end = date("Y-m-d",strtotime("+1 year"));
        }

        return array('start' => $start, 'end' => $end);
    }

    private function assemblyNotice($data)
    {
        $noticeTypedesc=Constant::noticeTypeArray();
        $data['typedesc'] = $noticeTypedesc[strval($data['noticetype'])] ? $noticeTypedesc[strval($data['noticetype'])] : ''; //通知中文说明
        $evaluatetypeArr=Constant::evaluatetypeArr();
        if($data['noticetype']==Constant::NOTICE_TYPE_3){
            $data['typedesc'].="<span class='conduct'>（<font>".$evaluatetypeArr[(int)$data['evaluatetype']]."</font>）</span>";
        }
        $data['showtime'] = (substr($data['sendtime'], 0, 10) == date("Y-m-d")) ? ('今天 ' . substr($data['sendtime'], 11, 5)) : substr($data['sendtime'], 0, 16);
        $data['content'] = str_replace("\r\n", "<br/>", $data['content']);
        $data['content'] = str_replace("\t", "&nbsp;&nbsp;", $data['content']);
        $content = json_decode($data['content'], true);

        if(isset($content['content'])&&is_string($content['content'])){
            $data['content'] = nl2br($content['content']);
            $data['content'] = str_replace("\t","&nbsp;&nbsp;",$data['content']);
        }

        if(isset($content['text'])&&is_array($content['text'])&&$data['noticetype']==Constant::NOTICE_TYPE_8){ //新的餐单保存方式
                $weekArr=array('1'=>'星期一','2'=>'星期二','3'=>'星期三','4'=>'星期四','5'=>'星期五','6'=>'星期六','7'=>'星期天');
                $data['content']=$content['text']['title']."</br>";
                foreach($content['text']['menu'] as $kk=>$vv){
                   $vv=array_change_key_case($vv);
                  $data['content'].=$weekArr[$vv['weekday']]."：".str_replace("\r\n", "&nbsp;",$vv['text'])."</br>";
                }
        }else if(isset($content['text'])&&is_array($content['text'])&&$data['noticetype']==Constant::NOTICE_TYPE_5){
            if(isset($content['text']['showtype'])){
                $str = "<span style='width:70px; display:inline-block; '>学校</span>：</span>" .$data['schoolname'] . "</br><span style='width:70px; display:inline-block; '>班级</span>：" . $content['text']['classname'] . "</br>
                ".(isset($content['text']['term'])?"<span style='width:70px; display:inline-block; '>学期</span>：" . $content['text']['term'] :''). " <span style='width:70px; display:inline-block; '>考试类型</span>：" . $content['text']['examtype'] . "</br><span style='width:70px; display:inline-block; '>考试名称</span>：" . $content['text']['name'] . "</br>";
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


        if ($data['noticetype'] == Constant::NOTICE_TYPE_0) { //系统通知
            $data['showclass'] = "systemNico";
        } else if ($data['noticetype'] == Constant::NOTICE_TYPE_4) { //紧急通知
            $data['showclass'] = "sosNico";
        } else if ($data['noticetype'] == Constant::NOTICE_TYPE_1){
            $data['showclass'] = "homeNico";
        } else if($data['noticetype'] == Constant::NOTICE_TYPE_6){
            $data['showclass'] = "inviteNicio";
        }else if($data['noticetype'] == Constant::NOTICE_TYPE_7){
            $data['showclass'] = "classNico";
        }else if($data['noticetype'] == Constant::NOTICE_TYPE_2||$data['noticetype'] == Constant::NOTICE_TYPE_5||$data['noticetype'] == Constant::NOTICE_TYPE_6) {
            $data['showclass'] = "schoolNico";
        }else if($data['noticetype'] == Constant::NOTICE_TYPE_8) {
            $data['showclass'] = "foodNicio";
        }else if($data['noticetype'] == Constant::NOTICE_TYPE_3) {
            $data['showclass'] = "conductNicio";
        }else {
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
        //手机上发的图片，保存在xiaoxin的服务器上需要换取地址
        foreach($data['images'] as $k=>$v){
           if(is_string($v)){
                $data['images'][$k]=CLIENT_FILE_DOWNLOAD_URL."?ac=getfile&Type=17&Name=".$v;
           }else if(is_array($v)){
               $data['images'][$k]=CLIENT_FILE_DOWNLOAD_URL."?ac=getfile&Type=17&Name=".$v['url'];
           }
        }
        //web上上传的图片，保存在七牛云
        if (isset($content['pictures'])) {
            $data['pictures'] = $content['pictures'];
        } else {
            $data['pictures'] = array();
        }

        foreach($data['pictures'] as $val){
            if(is_array($val)&&isset($val['url'])){
               $data['images'][]=STORAGE_QINNIU_XIAOXIN_XX.$val['url'];
            }elseif(is_string($val)){
                $data['images'][]=STORAGE_QINNIU_XIAOXIN_XX.$val;
            }
        }

        //web端七牛云
        if (isset($content['medias'])) {
            $data['medias'] = $content['medias'];
        } else {
            $data['medias'] = null;
        }
        if(isset($data['medias']['url'])){
            $data['medias']['name']=$data['medias']['url'];
            $data['medias']['url']=CLIENT_FILE_DOWNLOAD_URL."?ac=getfile&Type=18&Name=".$data['medias']['url'];
        }
//        foreach($data['medias'] as $k=>$v){
//            if(preg_match('/^http/i',$v)){ //如果是之前旧的有原来的完整url
//                $data['medias'][$k]=$v;
//            }else{
//                D($v);
//                $data['medias'][$k]=CLIENT_FILE_DOWNLOAD_URL."?ac=getfile&Type=18&Name=".$v;
//                //$data['medias'][$k]['name']['url']=CLIENT_FILE_DOWNLOAD_URL."?ac=getfile&Type=18&Name=".$v;
//            }
//        }
        if (isset($content['videos'])) {
            $data['videos'] = $content['videos'];
        } else {
            $data['videos'] = array();
        }
        $data['receivername']='';
        if(isset($data['rguardian'])){
            if($data['receiver']!==$data['rguardian']){
                if($data['receiver']&&$data['noticetype']!=Constant::NOTICE_TYPE_6){
                    $recerverinfo=Member::model()->findByPk($data['receiver']);
                    $data['receivername']='发给：&nbsp'.($recerverinfo?$recerverinfo->name:'');
                }
            }
        }
        //通知图片ad
        return $data;
    }

    public function actionGettime()
    {
        $y = date("Y");
        $m = date("m");
        $d = date("d");
        $h = date("H");
        $i = date("i");
        $s = date("s");

        $t = date('t');

        $years = array($y, $y + 1);
        $months = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
        $days = range(1, (int)($t));

        $hours = range(0, 23);
        //$minutes=array(0,5,10,15,20,25,30,35,40,45,50,55);
        //$minutes=range(0,59);

        $minutes = array(0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55);
        $secs = array();
        $this->renderPartial("fixed_time", array('y' => $y, 'm' => $m, 'd' => $d, 'h' => $h, 'i' => $i, 's' => $s, 'years' => $years, 'months' => $months, 'hours' => $hours, 'days' => $days,
            'minutes' => $minutes, 'secs' => $secs,'currentTime'=>date("Y-m-d H:i:s")));

    }

    public function actionApprovedetail()
    {
        $id = (int)Yii::app()->request->getParam("id");
        $data = NoticeQuery::getDetail($id, 2);
        $val = $this->assemblyNotice($data);
        $this->render('approvedetail', array('val' => $val));

    }
    private function checkislink($noticeType,$myapplication){
        $isLink="0";
        foreach($myapplication as $val){
            if($noticeType==1){
                if(strpos($val['url'],'homework')!==false){
                    $isLink="1";
                    break;
                }
            }elseif($noticeType==2){
                if(strpos($val['url'],'noticefamily')!==false){
                    $isLink="1";
                    break;
                }
            }elseif($noticeType==4){
                if(strpos($val['url'],'noticerush')!==false){
                    $isLink="1";
                    break;
                }
            }elseif($noticeType==7){
                if(strpos($val['url'],'noticeteacher')!==false){
                    $isLink="1";
                    break;
                }
            }else{

            }
        }
        return $isLink;

    }
    /*
     * 校验脏词，敏感词
     */
    public function actionCheckbadword(){
        $badwords= Yii::app()->cache->get(Constant::CACHE_BADWORD_LIST);
        if(empty($badwords)){
            $badwords=Badword::model()->findAll('deleted=:deleted',array("deleted"=>0));
            Yii::app()->cache->set(Constant::CACHE_BADWORD_LIST,$badwords);
        }
        $content=trim(Yii::app()->request->getParam("content",''));
        $words=NoticeQuery::inBadword($content,$badwords);
        if(is_array($words)&&count($words)>0){
            die(json_encode(array('status'=>'0','word'=>implode(",",$words))));
        }else{
            die(json_encode(array('status'=>'1','word'=>'')));
        }
    }
    /*
     * 获取我创建的模板（系统模板和我创建的）     *
     */
    public function actionGettemplate(){
        $uid=Yii::app()->user->id;
        $type=Yii::app()->request->getParam("type",0);
        $systemtemplates=Template::getTemplates(array('creater'=>$uid,'type'=>$type,'kind'=>0),100);
        $myselftemplates=Template::getTemplates(array('creater'=>$uid,'type'=>$type,'kind'=>1),100);
        $this->renderPartial("templatelist",array('systems'=>$systemtemplates,'myselfs'=>$myselftemplates,'type'=>$type));
    }
    /*
    * 获取我创建的模板（系统模板和我创建的）     *
    */
    public function actionAddtemplate(){
        $uid=Yii::app()->user->id;
        if(isset($_REQUEST['templatecontent'])&&!empty($_REQUEST['templatecontent'])){
            $tempate=new Template();
            $tempate->creater=$uid;
            $tempate->kind=1;
            $tempate->type=(int)Yii::app()->request->getParam("type",0);
            $tempate->content=trim($_REQUEST['templatecontent']);
            if($tempate->save()){
                die(json_encode(array('status'=>1,'msg'=>'保存模板成功')));
            }else{
                die(json_encode(array('status'=>0,'msg'=>'保存模板失败')));
            }

        }else{
            die(json_encode(array('status'=>0,'msg'=>'保存模板失败,模板内容为空，请检查内容')));
        }
    }

    /*
   * 获取删除模板     *
   */
    public function actionDeltemplate(){
        $templateId=(int)Yii::app()->request->getParam("id",0);
        if($templateId)
            $tempate=Template::model()->findByPk($templateId);
            if($tempate->deleted==0){
                $tempate->deleted=1;
                if($tempate->save()){
                    die(json_encode(array('status'=>1,'msg'=>'模板删除成功')));
                }else{
                    die(json_encode(array('status'=>0,'msg'=>'模板删除失败')));
                }
            }else{
                die(json_encode(array('status'=>0,'msg'=>'该模板不存在，请检查')));
            }
        }
    /*
     * 消息监控，用于监控某个学样的所有发送消息
     */
    public function actionMonitoring(){

        $userinfo = Yii::app()->user->getInstance();
        $uid = Yii::app()->user->id;
        $data = array();
        $timeType = (int)Yii::app()->request->getParam('timeType'); //时间段查询，用户选择时，一天内，三天内，一周内，一月内，本学期内等
        $schoolList = UCQuery::getTeacherSchool($uid); //我的学校列表

        $schools = array();
        $schoolArr=array();
        foreach($schoolList as $val){
            if(NoticeService::checkMonitorRight($val['sid'],$uid,Constant::APPID19)){
                $schoolArr[]=$val;
            }
        }

        $data['sid']=isset($_GET['sid'])?(int)$_GET['sid']:(!empty($schoolArr)?$schoolArr[0]['sid']:0);
        $schoolinfo=School::model()->findByPk($data['sid']);
        $sidname=$schoolinfo?$schoolinfo->name:'';
        $teacherList=School::getSchoolTeacherReturnArr($data['sid'],true);


        $type = 1;
        $data['noticeType'] = Yii::app()->request->getParam("noticeType"); //通知类型可以是1,2这种，便in查询
        $data['keyword'] = MainHelper::safe_string(trim(Yii::app()->request->getParam("keyword"))); //查询关键字
        $data['teacher'] = (int)Yii::app()->request->getParam("teacher",0); //选择的老师
        $teachername='';
        if($data['teacher']){
            $teacherinfo=Member::model()->findByPk((int)$data['teacher']);
            $teachername=$teacherinfo?$teacherinfo->name:'';

        }
        $data['timeType'] = $timeType; //选择的老师
        $startend = $this->getTimeStartEnd($timeType);

        $data['start'] = $startend['start'];
        $data['end'] = $startend['end'];
        $result = Notice::getSendMessage($data);
        $returndata=array();
        foreach ($result['model'] as $k => $val) {
            $t=array('noticeid'=>$val->noticeid,
               'sender' => $val->sender,
                'sendertitle' => $val->sendertitle,
                'receiver'=> $val->receiver,
                'receivertitle' => $val->receivertitle,
                'noticetype' =>$val->noticetype,
                'content' => $val->content,
                'sendtime'=>$val->sendtime,
                'creationtime' => $val->creationtime,
                'sid' => $val->sid,
                'schoolname' => $val->schoolname,
                'receivename' => $val->receivename,
                'evaluatetype'=>$val->evaluatetype);
               $member=Member::model()->findByPk($val['sender']);
               $t['sendertitle']=$member?$member->name:$val['sendertitle'];
               $t['replynum']=NoticeReply::countNoticeReplaies($val['noticeid']);
            $returndata[] = $this->assemblyNotice($t);
        }
        $this->render("monitoring", array('teacherList'=>$teacherList,'teachername'=>$teachername,'schoolList'=>$schoolArr,'data' => $returndata,'noticeType' => $data['noticeType'],'pages'=>$result['pages'], 'timeType' => $timeType, 'keyword' => $data['keyword'],'sid'=>$data['sid'],'sidname'=>$sidname,'teacher'=>$data['teacher']));
    }

    /*  消息中心
    * 消息监控消息详情
    */
    public function actionMonitoringSenddetail($id)
    {
        $userinfo=Yii::app()->user->getInstance();
        $uid = Yii::app()->user->id;
        $identity=$userinfo->identity; //获取是老师还是家长
        $data = NoticeQuery::getDetail($id, 1);
        $val = $this->assemblyNotice($data);
        $page = Yii::app()->request->getParam("page");
        if (!(int)$page) $page = 1;
        $pageSize = Yii::app()->request->getParam("pageSize");
        if (!$pageSize) {
            $pageSize = 15;
        }
        $replyList = NoticeQuery::getNoticeReply($id, $page, $pageSize);
        $userIds = array();
        if ($replyList) {
            foreach ($replyList as $k => $v) {
                $replyList[$k]['showtime'] = (substr($v['creationtime'], 0, 10) == date("Y-m-d")) ? ('今天 ' . substr($v['creationtime'], 11, 5)) : substr($v['creationtime'], 0, 16);
                if ($v['nameless'] == 1) {
                    $replyList[$k]['showusername'] = '匿名';
                } else {
                    $userIds[] = $v['sender'];
                }
            }
        }
        $userIds[] = Yii::app()->user->id;
        if (count($userIds) > 0) {
            //去uc获取用户头像及名称
            $replyUser = NoticeQuery::getUserNamePhoto(implode(",", ($userIds)));
        }

        $userrelation = array();
        if (!empty($replyUser)) {
            foreach ($replyUser as $v) {
                $userrelation[$v['userid']] = $v;
            }
            foreach ($replyList as $k => $v) {
                if ($v['nameless']) {
                    $replyList[$k]['photo'] = Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';//匿名
                } else {
                    if($replyList[$k]['sguardian']){
                        $replyList[$k]['photo'] = Member::defaultPhoto($replyList[$k]['sguardian']);
                    }else{
                        $replyList[$k]['photo'] = Member::defaultPhoto($replyList[$k]['sender']);
                    }

                }
                if ($v['nameless'] == 1) {
                    $replyList[$k]['username'] = '匿名人';
                } else {
                    $guardian_one=null;
                    if($v['sguardian']){
                        $guardian=(int)$v['sguardian'];
                        $guardian_one=Guardian::getRelationByChildGuardian($guardian,$v['sender']);
                    }
                    $replyList[$k]['username'] = isset($userrelation[$v['sender']]['name'])?$userrelation[$v['sender']]['name']:'';
                    if($guardian_one){
                        $replyList[$k]['username'].="&nbsp;的&nbsp;".($guardian_one->role?$guardian_one->role:'家长');
                    }
                }
            }
        }
        $member=Member::model()->findByPk((int)$val['sender']);
        $val['sendertitle']=$member?$member->name:$val['sendertitle'];
       // $val['replynum']=NoticeReply::countNoticeReplaies($val['noticeid']);
        $replyNum = (int)$val['replyNum'];
        $criteria = new CDbCriteria();
        $pages = new CPagination($replyNum);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $this->render('monitoringsenddetail', array('val' => $val, 'identity'=>$identity,'replylist' => $replyList, 'pages' => $pages));
    }
    /*
     * 设置已读
     */
    public function actionSetreadstate(){
        $uid=Yii::app()->user->id;
        $noticeType=Yii::app()->request->getParam("noticeType",'');
        $identity = Yii::app()->user->getIdentity(); //获取是老师还是家长登录
        if (!$identity || empty($identity) || empty($uid)) {
            $this->redirect(Yii::app()->createUrl("xiaoxin/default/login"));
        }
        $receiver=$uid;
        if($identity==4){ //如果家长方式登录，改先查我的孩子，再用in查询，用find_in_set,sguardian太慢，数据大点，完蛋
            $myChilds=Guardian::getChilds($uid);
            $myChildUids=array();
            foreach($myChilds as $guardian){
                $myChildUids[]=$guardian->child;
            }
            if(count($myChildUids)){
                $receiver=implode(",",$myChildUids);
            }else{ //没有孩子
                $receiver=0;
            }
        }
        $success=NoticeMessage::updateReadStateByUidNoticeType($receiver,$noticeType);
        die(json_encode(array('status'=>'1')));
        if(!empty($success)){
            die(json_encode(array('status'=>'1')));
        }else{
            die(json_encode(array('status'=>'0')));
        }
    }

    /*
     * 获取老师的定向发送配置数据
     */
    public function actionGetdirector(){
        $sid = Yii::app()->request->getParam("sid", '0');
        $uid=Yii::app()->user->id;
        $teachers = TeachersRelation::getTeachersRelation($uid, $sid);
        $members = array();
        $tmp = array();
        if ($teachers) {
            if (!empty($teachers->teachers)) {
                $userlist = Member::getUsersByUids(explode(",", $teachers->teachers));
                if (is_array($userlist)) {
                    foreach ($userlist as $val) {
                        $members[] = array('userid' => $val->userid, 'name' => $val->name);
                    }
                }
            }
        }
        die(json_encode(array('status'=>'1','data'=>$members)));
    }

    /*
     * 用于选择班级或分组，布置作业通知家长时
     */
    public function actionSelectclass11(){
        $uid=Yii::app()->user->id;
        $type=Yii::app()->request->getParam("type",'1');
        $noticeType=Yii::app()->request->getParam("noticetype",'1');
        $schools=array();
        $schools=NoticeService::getMySchool($uid,($noticeType=="1"?Constant::APPID1:Constant::APPID2));
        $this->render("selectclass", array("schools"=>$schools,'type'=>$type));
    }
    /*
     * 用于选择班级或分组，布置作业通知家长时
     */
    public function actionselectclass(){
        $uid=Yii::app()->user->id;
        $type=Yii::app()->request->getParam("type",'1');
        $sid=Yii::app()->request->getParam("sid",'0');
        $classs=array();

        if($type=="1"){
            $classs=NoticeService::getClassBySidUid($sid,$uid,true);//返回所有班级
            $this->renderPartial("selectclass", array("classs"=>$classs,'type'=>$type,'sid'=>$sid));
        }else if($type=="2"){
            //返回所有分组
            $sql_text = " call php_xiaoxin_getTeacherGroupBySid($uid,0,$sid)";
            $classs = UCQuery::queryAll($sql_text);
            $classs=is_array($classs)?$classs:array();
            $shareGids=GroupPermission::getShareGidsArr($uid,$sid,0); //别的人指定给他可以访问的分组,后面参数为0，表示是学生组,1是老师组
            foreach($shareGids as $val){
                $classs[]=array('gid'=>$val['gid'],'name'=>$val['name']);
            }
            foreach($classs as $k=>$val){
                $classs[$k]['sid']=$sid;
            }
            $this->renderPartial("selectclass", array("classs"=>$classs,'type'=>$type));
        }else if($type=="0"){ //返回班级+分组
            $classs=NoticeService::getClassBySidUid($sid,$uid);
            if(!is_array($classs)) $classs=array();
            //获取我创建的分组
            $groups=array();
            $groupList=Group::getUserGroup($uid,$sid,0);
            if(is_array($groupList)) foreach($groupList as $val){
                $groups[]=array('sid'=>$val->sid,'gid'=>$val->gid,'name'=>$val->name.'(分组)','group'=>'1');
            }

            //获取共享的分组
            $shareGroups=GroupPermission::getShareGidsArr($uid,$sid,0);
            $shareGroups=is_array($shareGroups)?$shareGroups:array();

            foreach($shareGroups as $val){
                $groups[]=array('gid'=>$val['gid'],'name'=>$val['name'].'(分组)','group'=>1);
            }
            $this->renderPartial("selectclassgroup", array("classs"=>$classs,'type'=>$type,'groups'=>$groups,'sid'=>$sid));
        }else if($type=="4"){ //获取老师的部门分组
            $sql_text = " call php_xiaoxin_getTeacherDepartmentInSchool(0,$sid)";
            $depts = UCQuery::queryAll($sql_text);
            /*  再获取我在这个学校的分组 */
            $sql_text1 = " call php_xiaoxin_getTeacherGroupBySid($uid,1,$sid)";
            $groups = UCQuery::queryAll($sql_text1);
            $shareGroups=GroupPermission::getShareGidsArr($uid,$sid,1);
            $groups=is_array($groups)?$groups:array();
            $shareGroups=is_array($shareGroups)?$shareGroups:array();
            foreach($shareGroups as $val){
                $groups[]=array('gid'=>$val['gid'],'name'=>$val['name']);
            }
            $depts = $depts;
            $groups = $groups;
            $this->renderPartial("selectclassgroup", array("classs"=>$classs,'type'=>$type,'groups'=>$groups));
        }else if($type=="5"){ //获取老师学校所在的年级
            $sql_text = " call php_xiaoxin_getSchoolGrade($sid)";
            $grades= UCQuery::queryAll($sql_text);
            $this->renderPartial("selectgrade", array("grades"=>$grades));
           // die(json_encode(array('grades'=>$grades)));
        }else if($type=="6"){

        }
       exit();

    }


}