<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-25
 * Time: 上午9:42
 */

class FoodmenuController extends Controller
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
                'actions' => array('index', 'search', 'publish', 'save'),
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
        $tempSchool= SchoolTeacherRelation::getTeachersSchoolRaletion($uid); //获取登陆老师的学校列表
        $schoollist=array();
        foreach($tempSchool as $k=>$v){
            if(NoticeService::checkMonitorRight($v->sid,$uid,Constant::APPID7)){
                $schoollist[]=$v;
            }
        }
        if(isset($_GET['sid'])){
            $sid=$_GET['sid'];
        }else{
            $sid=isset($schoollist[0])?$schoollist[0]->sid:-1;
        }
       // $sid = isset($_GET['sid']) ? $_GET['sid'] : (isset($schoollist[0]) ? ($schoollist[0]->sid) : 0); //如果不是选择学校查询，则默认第一个学校

        $year = isset($_GET['year']) ? $_GET['year'] : date('Y'); //如果没选择年，选择当年
        $weekNum = isset($_GET['week']) ? $_GET['week'] : MainHelper::getWeekNow(); ////如果没选择周，选择当前周
       //翻页上一年最大周，下一年第一周
        if ($weekNum == 0) {
            $year = $year - 1;
            $weekNum = MainHelper::getWeeks($year);    //如果向左翻页到第0周就获取上一年的最大周
        } else if ($weekNum > MainHelper::getWeeks($year)) { //如果大于
            $weekNum = 1;
            $year = $year + 1;   //如果向右翻页到比当年的最大周还大了就获取下一年的第一周
        }

        $startend = MainHelper::getWeekDate($year, $weekNum); //获取周一和周日（周末起至）
        $ss = $startend[1]; //这个为这周的周日，中国人习惯
        for ($i = 1; $i < 6; $i++) { //填上周二到周六
            $startend[$i] = date("Y-m-d", strtotime("+$i day", strtotime($startend[0])));
        }
        $startend[6] = $ss;
        $weekName = array('星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日');
        $dateArr = array();
        $weekFoodContent = null;
        $content = array();
        if ($sid) {
            $weekFoodContent = Foodmenu::getFoodContent(array('sid' => $sid, 'week' => $weekNum, 'year' => $year));
            if ($weekFoodContent && $weekFoodContent->content) {
                $content = json_decode($weekFoodContent->content, true); //保存到数据库的内容为{'1':'茄子',"2":'豆角'}
            }
        }
        $today = time();
        $end = $startend[6];
        $isEdit = $today > strtotime($end) ? false : true; //判断是否可编辑,如果当前时间大于该周的最后一天，即不可编辑
        $this->render('index', array('weekName' => $weekName, 'sid' => $sid, 'schools' => $schoollist,
            'dates' => $startend, 'isEdit' => $isEdit, 'week' => $weekNum, 'content' => $content, 'weekFoodContent' => $weekFoodContent, 'year' => $year));
    }


    /*
     *发布
     */
    public function actionPublish()
    {
        $uid = Yii::app()->user->id;

        if (isset($_POST['id'])) {
            $isok=isset($_POST['isok'])?(int)($_POST['isok']):0;
            $model = Foodmenu::model()->findByPk((int)$_POST['id']);
            $userinfo = Yii::app()->user->getInstance();
            if ($model) {
                $sid = $model->sid;
                $username = $userinfo->name;
                $sql_text = " call php_xiaoxin_getSchoolGrade($sid)";
                $grades = UCQuery::queryAll($sql_text); //获取学校所有年级
                $allGrades = array();
                foreach ($grades as $vv) {
                    $allGrades[] = $vv['gid'];
                }
//                $allIntersClass=MClass::getAllInterestClass2($sid);//获取所有兴趣班,兴趣班不在年级中//
//                $allIntersCid=array();
//                if(is_array($allIntersClass)){
//                    foreach($allIntersClass as $k=>$val){
//                        $allIntersCid[]=$val['cid'];
//                    }
//                }

                if (!empty($allGrades)) { //只给学生发,给全校的所有年级
                    $receive = array("3" => implode(",", $allGrades));
//                    if(!empty($allIntersCid)){
//                        $receive['1']=implode(",",$allIntersCid);
//                    }
                } else {
                    Yii::app()->msg->postMsg('error', '发布失败，没有年级');
                    $this->redirect($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : array('index'));
                }

                $data = array();
                $data['uid'] = $uid; //发布者
                $data['sendertitle'] = $username; //发送者签名
                $data['receiver'] = json_encode($receive); //接收人集合

                $data['noticeType'] = 8; //通知类型
                $data['isSendsms'] = 1;//isset($_POST['isSendsms'])?(int)$_POST['isSendsms']:0; //是否给自己发短信
                $data['receiveTitle'] = "xxx"; //接收者称呼
                $data['fixed_time'] = isset($_POST['fixed_time']) ? $_POST['fixed_time'] : ''; //定时发送时间
                //$data['fixed_time'] = ''; //定时发送时间
                $data['receivename'] = "全校学生"; //接收人名称集合();
                $data['sid'] = $model->sid; //学校id
                $data['uname'] = $username; //发送人真实姓名
                $weekName = array('星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日');

                $tmp = array();
                $startend = MainHelper::getWeekDate($model->year, $model->week);
                $str = "第".$model->week."周 (".$startend[0]."~".$startend[1].")";
                $textstr=$str."\r\n";
                $con=array();
                $con['title']=$str;
                $weektmp=json_decode($model->content,true);
                foreach($weektmp as $k=>$v){
                    $con['menu'][]=array('weekday'=>$k,'text'=>$v);
                    if($v == "早餐：\r\n午餐：\r\n晚餐："){
                        $v = "";
                    }
                    $textstr .= ($weekName[$k - 1] . "：" . $v . "\r\n");
                }
                $data['data'] = json_encode(array('text' => $con,'content'=>$textstr), JSON_UNESCAPED_UNICODE);
                $success = NoticeQuery::publishNotice($data, $uid, 0);
                if ($success) {
                    $model->ispublish = 1;
                    $model->save();
                    if ($isok) { //是否给自己发确认短信
                        $mobile = $userinfo->mobilephone;
                        if (!empty($mobile)) {
                            $code = '你于:' . date("Y-m-d H:i:s") . '发布:'  . Constant::getNoticeTypeById(8) . ",接收对象为:全校学生" ;
                            UCQuery::sendQtxxMsg($mobile,$code);
                        }
                    }
                    Yii::app()->msg->postMsg('success', '发布成功');
                } else {
                    Yii::app()->msg->postMsg('error', '发布失败');
                }
                $this->redirect($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : array('index'));
            }

        }

        $tempSchool = SchoolTeacherRelation::getTeachersSchoolRaletion($uid);
        $schoollist=array();
        $mysids=array();
        foreach($tempSchool as $k=>$v){
            if(NoticeService::checkMonitorRight($v->sid,$uid,Constant::APPID7)){
                $schoollist[]=$v;
                $mysids[]=$v->sid;
            }
        }
        $isshowsendsms=SmsConfig::checkSendsmsBySidAndNoticeType($mysids,Constant::NOTICE_TYPE_8);
        $weekName = array('星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日');
        $dateArr = array();
        $weekFoodContent = null;
        $content = array();
        $sid = isset($_GET['sid']) ? $_GET['sid'] : (isset($schoollist[0]) ? $schoollist[0]->sid : 0);
        $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
        $weekNum = isset($_GET['week']) ? $_GET['week'] : MainHelper::getWeekNow();


        if ($weekNum == 0) {
            $year = $year - 1;
            $weekNum = MainHelper::getWeeks($year);
        } else if ($weekNum > MainHelper::getWeeks($year)) {
            $weekNum = 1;
            $year = $year + 1;
        }
        $startend = MainHelper::getWeekDate($year, $weekNum);
        $ss = $startend[1];
        for ($i = 1; $i < 6; $i++) {
            $startend[$i] = date("Y-m-d", strtotime("+$i day", strtotime($startend[0])));
        }
        $startend[6] = $ss;
        if ($sid) {
            $weekFoodContent = Foodmenu::getFoodContent(array('sid' => $sid, 'week' => $weekNum, 'year' => $year));
            if ($weekFoodContent && $weekFoodContent->content) {
                $content = json_decode($weekFoodContent->content, true);
            }
        }
        $nextweek = $weekNum + 1;
        $nextweekFoodContent = Foodmenu::getFoodContent(array('sid' => $sid, 'week' => $nextweek, 'year' => $year));
        $today = time();
        $end = $startend[6];
        $isEdit = $today > strtotime($end) ? false : true;
        $this->render('publish', array('weekName' => $weekName, 'isshowsendsms'=>$isshowsendsms,'sid' => $sid, 'schools' => $schoollist,
            'dates' => $startend, 'nextweekFoodContent' => $nextweekFoodContent, 'week' => $weekNum, 'isEdit' => $isEdit, 'weekFoodContent' => $weekFoodContent, 'content' => $content, 'year' => $year));
    }

    /*
     * 保存
     */
    public function actionSave()
    {

        if (isset($_POST['sid'])) {

            $sid = $_POST['sid'];
            $week = $_POST['week'];
            $year = $_POST['year'];
            $content = $_POST['content'];
            $id = (int)$_POST['id'];
            $tmp = array();
            foreach ($content as $k => $val) {
                $tmp[$k + 1] = $val;
            }
            $con = json_encode($tmp, JSON_UNESCAPED_UNICODE);
            $model_food = Foodmenu::model()->findByPk($id);
            if (!$model_food || $model_food->deleted == 1) {
                $model = new Foodmenu;
            } else {
                $model = $model_food;
            }
            if ($model_food) {
                //如果是编辑,判断是否修改过餐单内容
                $oldContent = json_decode($model_food->content, true);
                $samenum = 0;
                foreach ($tmp as $k => $val) {
                    if ($tmp[$k] == $oldContent[$k]) {
                        $samenum++;
                    }
                }
                if ($samenum == 7) {
                    Yii::app()->msg->postMsg('error', '未修改餐单内容');
                    $this->redirect($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : array('index'));
                }
            }
            $model->week = $week;
            $model->year = $year;
            $model->sid = $sid;
            $model->content = $con;
            if ($model->save()) {
                Yii::app()->msg->postMsg('success', '保存成功');
            } else {
                Yii::app()->msg->postMsg('error', '保存失败');
            }
            $this->redirect($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : array('index'));

        }
    }


}