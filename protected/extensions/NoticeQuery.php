<?php
/**
 * Created by PhpStorm.
 * User: zhoujunsheng
 * Date: 14-7-28
 * Time: 上午9:13
 */

class NoticeQuery
{
    public static function getDb()
    {
        return Yii::app()->db_xiaoxin;
    }

    public static function queryAll($sql)
    {
        $db = self::getDb();
        $result = $db->createCommand($sql);
        // $records = (object)$result->queryAll();
        $records = $result->queryAll();
        return $records;
    }

    public static function queryRow($sql)
    {
        $db = self::getDb();
        $result = $db->createCommand($sql);
        $record = $result->queryRow();
        return $record;
    }

    public static function execute($sql)
    {
        $db = self::getDb();
        $result = $db->createCommand($sql);
        $record = $result->execute();
        return $record;
    }

    /*
     * 发布通知
     * $approve代表是否需要审核
     */
    public static function publishNotice($data, $uid, $approve)
    {
        $data['state'] = 0;
        $db = self::getDb();
        $schoolInfo =Yii::app()->cache->get("mem_object_school_".(int)$data['sid']);
        if(!$schoolInfo){
            $schoolInfo=School::model()->findByPk((int)$data['sid']);
            Yii::app()->cache->set("mem_object_school_".(int)$data['sid'],$schoolInfo,300);
        }
       // error_log('sid:'.)
        $schoolname=$schoolInfo?$schoolInfo->name:'';
        // error_log('sid:'.$data['sid'].",name;".$schoolname);
        $data['fixed_time'] = isset($data['fixed_time'])?$data['fixed_time']:'';
        if ($data['fixed_time'] || $approve) { //定时发送，或是需要审核的，，要保存到tb_notice_fixedtime表，再应用定时任务处理
            //审核时，写入到tb_notice,定时的话，到达设定的时间时，如果需要审核的，直接变成待审核，否则直接发布
            $sql = " call php_xiaoxin_insert_notice_fixedtime(:uid,:receive,:noticeType,:data,:sendTitle,:receiveTitle,:isSendsms,:sid,:schoolname,:receivename,:status,:fixed_time,:evaluatetype)";
            $status = !$approve;
            $evaluatetype=(isset($data['evaluatetype'])?(int)$data['evaluatetype']:0);
            $command = $db->createCommand($sql);
            $command->bindParam(':uid', $uid, PDO::PARAM_INT);
            $command->bindParam(':receive', $data['receiver'], PDO::PARAM_STR);
            $command->bindParam(':noticeType', $data['noticeType'], PDO::PARAM_INT);
            $command->bindParam(':isSendsms', $data['isSendsms'], PDO::PARAM_INT);
            $command->bindParam(':data', $data['data'], PDO::PARAM_STR);
            $command->bindParam(':receiveTitle', $data['receiveTitle'], PDO::PARAM_STR);
            $command->bindParam(':sendTitle', $data['sendertitle'], PDO::PARAM_STR);
            $command->bindParam(':schoolname', $schoolname, PDO::PARAM_STR);
            $command->bindParam(':receivename', $data['receivename'], PDO::PARAM_STR); //接收者名称,比如高中一年级(2),(3)班或李xx,王yy
            $command->bindParam(':sid', $data['sid'], PDO::PARAM_INT);
            $command->bindParam(':status', $status, PDO::PARAM_INT);
            $command->bindParam(':evaluatetype',$evaluatetype , PDO::PARAM_INT);
            if ($data['fixed_time']) {
                $command->bindParam(':fixed_time', $data['fixed_time'], PDO::PARAM_STR);
            } else {
                $today = date('Y-m-d H:i:s');
                $command->bindParam(':fixed_time', $today, PDO::PARAM_STR);
            }
            $return = $command->execute();
            if ($return > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $time=date("Y-m-d H:i:s");

            //不需要审核，也不是定时发送的数据，直接插入tb_notice表
            $sql = " call php_xiaoxin_insert_message(:uid,:receive,:noticeType,:data,:sendTitle,:receiveTitle,:isSendsms,:sid,:schoolname,:receivename,:sendtime,:evaluatetype)";
            $command = $db->createCommand($sql);
            $command->bindParam(':uid', $uid, PDO::PARAM_INT);
            $command->bindParam(':receive', $data['receiver'], PDO::PARAM_STR);
            $command->bindParam(':noticeType', $data['noticeType'], PDO::PARAM_INT);
            $command->bindParam(':isSendsms', $data['isSendsms'], PDO::PARAM_INT);
            $command->bindParam(':data', $data['data'], PDO::PARAM_STR);
            $command->bindParam(':receiveTitle', $data['receiveTitle'], PDO::PARAM_STR);
            $command->bindParam(':sendTitle', $data['sendertitle'], PDO::PARAM_STR);
            $command->bindParam(':schoolname', $schoolname, PDO::PARAM_STR);
            $command->bindParam(':receivename', $data['receivename'], PDO::PARAM_STR); //接收者名称,比如高中一年级(2),(3)班或李xx,王yy
            $command->bindParam(':sid', $data['sid'], PDO::PARAM_INT);
            $command->bindParam(':sendtime', $time, PDO::PARAM_STR);
            $evaluatetype=(isset($data['evaluatetype'])?(int)$data['evaluatetype']:0);
            $command->bindParam(':evaluatetype', $evaluatetype, PDO::PARAM_INT);
            $return = $command->execute();
            if ($return > 0) { //即成功添加
                return true;
            } else { //失败
                return false;
            }
        }
    }

    /*
     * 获取配置信息
     */
    public static function getConfig($sid, $configname)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_getConfig($sid,'$configname')";
        $command = $db->createCommand($sql);
        $data = $command->queryRow();
        return $data;

    }

    /*
     * 获取通知详情
     * $type=0  收件消息  type=1 发送消息  2定时发送的消息
     */
    public static function getDetail($id, $type)
    {
        $db = self::getDb();
        if ($type == 0) {
            $sql = " call php_xiaoxin_getMessageDetail($id)";
        } else if ($type == 1) {
            $sql = " call php_xiaoxin_getSendMessageDetail($id)";
        } else {
            $sql = " call php_xiaoxin_getUnSendMessageDetail($id)";
        }
        $command = $db->createCommand($sql);
        $data = $command->queryRow();
        return $data;
    }

    /*
        * 获取通知数
        *  $type=0  收件消息  type=1 发送消息  2定时发送的消息(即待发送)
        */
    public static function getMessageCount($data, $type, $uid)
    {
        $noticeType = $data['noticeType'];
        $start = $data['start'];
        $end = $data['end'];
        $page = empty($data['page']) ? 1 : $data['page'];
        $pageSize = $data['pageSize'] ? $data['pageSize'] : 15;
        $keyword = $data['keyword'];

        $db = self::getDb();
       // $command1 = $db->createCommand("set names utf8;");
       // $command1->execute();
        if ($type == 0) {
            $sql = " call php_xiaoxin_getMessage($uid,'$noticeType','$start','$end',$page,$pageSize,'$keyword',0)";
        } else if ($type == 1) {
            $sql = " call php_xiaoxin_getSendMessage($uid,'$noticeType','$start','$end',$page,$pageSize,'$keyword',0)";
        } else if($type==2) {
            $sql = " call php_xiaoxin_getUnSendMessage($uid,'$noticeType','$start','$end',$page,$pageSize,'$keyword',0,'0,2')";
        }else if($type==3){
            $sql = " call php_xiaoxin_getMessage_byfamily('$uid','$noticeType','$start','$end',$page,$pageSize,'$keyword',0)";
        }
        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        return (int)$data[0]['num'];

    }
    /*
     * 首页登录，获取最新的几条消息
     */
    public static function  getNewsMessage($uid,$n=3,$identity){
        $db = self::getDb();
        $sql = " call php_xiaoxin_getNewsMessage('$uid',$n,$identity)";
        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        return $data;
    }

    /*
     * 获取通知列表
     *  $type=0  收件消息  type=1 发送消息  2定时发送的消息(即待发送)
     */
    public static function getMessageList($data, $type, $uid)
    {
        $noticeType = $data['noticeType'];
        $start = $data['start'];
        $end = $data['end'];
        $page = $data['page'];
        $pageSize = isset($data['pageSize']) ? $data['pageSize'] : 15;
        $keyword = $data['keyword'];
        $db = self::getDb();
        // $command1 = $db->createCommand("set names utf8;");
        // $command1->execute();
        if ($type == 0) { //老师收的消息
            $sql = " call php_xiaoxin_getMessage($uid,'$noticeType','$start','$end',$page,$pageSize,'$keyword',1)";
        } else if ($type == 1) { //老师发送的消息
            $sql = " call php_xiaoxin_getSendMessage($uid,'$noticeType','$start','$end',$page,$pageSize,'$keyword',1)";
        } else if ($type == 2) { //老师未发送的消息
            $sql = " call php_xiaoxin_getUnSendMessage($uid,'$noticeType','$start','$end',$page,$pageSize,'$keyword',1,'0,2')";
        } else if ($type == 3) { //家长收的消息
            $sql = " call php_xiaoxin_getMessage_byfamily('$uid','$noticeType','$start','$end',$page,$pageSize,'$keyword',1)";
        }
        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        return $data;
    }

    /*
     * 返回待审核，已审核，等数据
     * $returnList=1表示返回列表，=0返回总数num（用户分页）
     */
    public static function getApproveList($data, $uid, $returnList = 1)
    {
        $noticeType = $data['noticeType'];
        $start = $data['start'];
        $end = $data['end'];
        $page = $data['page'];
        $pageSize = $data['pageSize'] ? $data['pageSize'] : 15;
        $keyword = $data['keyword'];
        $status = $data['status'];
        $sid = $data['sid'];
        $db = self::getDb();
        if($data['status']=='0'){
            $sql = " call php_xiaoxin_unapprove_list($sid,'$noticeType','$start','$end',$page,$pageSize,'$keyword',$returnList,'$status',$uid)";
        }else{
            $sql = " call php_xiaoxin_approve_list($sid,'$noticeType','$start','$end',$page,$pageSize,'$keyword',$returnList,'$status',$uid)";
        }
        //$sql = " call php_xiaoxin_approve_list($sid,'$noticeType','$start','$end',$page,$pageSize,'$keyword',$returnList,'$status',$uid)";

        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        return $data;
    }

    /*
     *得到我有审核权限的学校
     */
    public static function getMyApprovePersonByUid($uid)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_getapproveschool($uid)";
        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        return $data;
    }

    /*
     * 获取最新的回复,用于进入后首页，显示最新回复
     */
    public static function getNewsReply($identity,$uid,$num)
    {
        $identity=(int)$identity;
        $db = self::getDb();
        $sql = " call php_xiaoxin_getNewsReply($identity,$uid,$num)";
        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        return $data;
    }

    /*
     * 家长端获取最新评论，
     * $receivers－－ 所有孩子id,原来用find_in_set，用不到索引,所以改查孩子id,查所有孩子收到的消息的最新四条评论，校信首页
     */
    public static function getNewsReplyByChild($receivers){
        $db = self::getDb();
        $sql="select  t.*,f.noticetype from tb_notice_reply t inner join (select DISTINCT noticeid ,noticetype from tb_notice_message where receiver in(".$receivers." ) and deleted=0) f
        on t.noticeid=f.noticeid where t.deleted=0 order by creationtime desc limit 4 ;";
        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        return $data;
    }

    /*
     * 获取通知的评论信息
     */
    public static function getNoticeReply($id, $page, $pageSize)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_getNotice_reply($id,$page,$pageSize)"; //
        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        return $data;
    }

    /*
     * 插入回复评论
     */
    public static function insertReply($data)
    {
        $db = self::getDb();
        $detail = self::getDetail($data['noticeId'], 1);
        if (!$detail) {
            return false;
        }
        $content = $data['content'];

        $sql = " call php_xiaoxin_insert_notice_reply({$data['uid']},{$data['noticeId']},{$detail['sender']},'$content',{$data['nameless']},'{$data['sguardian']}')";
        $command = $db->createCommand($sql);
        $return = $command->execute();
        return $return;
    }

    /*
     * 编辑修改未发送的消息通知
     */
    public static function updateFixedNotice($data)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_update_fixedtime(:id,:receiveType,:receive,:noticeType,:data,:userName,:receiveTitle,:sendTime,:isSendsms)";
        $command = $db->execute($sql);
        $command = $db->createCommand($sql);
        $command->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $command->bindParam(':receiveType', $data['receiveType'], PDO::PARAM_INT);
        $command->bindParam(':receive', $data['receive'], PDO::PARAM_STR);
        $command->bindParam(':noticeType', $data['noticeType'], PDO::PARAM_INT);
        $command->bindParam(':isSendsms', $data['isSendsms'], PDO::PARAM_INT);
        $command->bindParam(':data', $data['data'], PDO::PARAM_STR);
        $command->bindParam(':userName', $data['userName'], PDO::PARAM_STR);
        $command->bindParam(':receiveTitle', $data['receiveTitle'], PDO::PARAM_STR);
        $command->bindParam(':sendTime', $data['fixed_time'], PDO::PARAM_STR); //发送时间
        $success = $command->execute();
        return $success;
    }

    /*
     * 修改状态为已读;  通过ajax，在打开消息列时，取出id集合，更新
     * $readState  0--未读  1--已读
     *
     */
    public static function updateReadState($ids, $readState = 1)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_update_readstate('$ids')";
        $command = $db->createCommand($sql);
        $success = $command->execute();
        return $success;
    }

    /*
   * 取消发送
   *
   */
    public static function cancelSend($id)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_update_fixedtime($id)";
        $command = $db->createCommand($sql);
        $success = $command->execute();
        return $success;
    }

    /*
     * 获取某个表的记录数
     */
    public static function getNum($table, $where)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_get_table_num(:table,:where)";
        $command = $db->createCommand($sql);
        $command->bindParam(':table', $table, PDO::PARAM_STR);
        $command->bindParam(':where', $where, PDO::PARAM_STR);
        $success = $command->queryRow();
        return $success['num'];
    }


    /*
     * 获取所有日常应用
     */
    public static function getAllApplication($identity)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_get_application($identity)";

        $command = $db->createCommand($sql);
        $data = $command->queryAll();
        return $data;
    }

    /*
  * 获取我的快捷应用
  */
    public static function getMyApplication($uid)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_get_myapplication($uid)";
        $command = $db->createCommand($sql);
        $res = $command->queryAll();
        return $res;
    }

    /**
     * @author panrj 2014-08-16
     * 获取我的快捷应用主键
     */
    public static function getMyApplicationPks($uid)
    {
        $apps = self::getMyApplication($uid);
        $pks = array();
        foreach ($apps as $app) {
            array_push($pks, $app['appid']);
        }
        return $pks;
    }

    /*
    * 将应用加入到我的快捷应用
    */
    public static function AddToMyApplication($appid, $uid, $state)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_add_myapplication($appid,$uid,$state)";
        $command = $db->createCommand($sql);
        $success = $command->execute();
        return $success;
    }

    /*
    * 将应用从我的快捷应用中移徐
    */
    public static function RemoveMyApplication($appid)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_remove_myapplication($appid)";
        $command = $db->createCommand($sql);
        $success = $command->execute();
        return $success;
    }

    /*
     *
     */
    public static function approve($uid, $status, $reason, $id)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_approve_notice($uid,$status,'$reason',$id)";

        $command = $db->createCommand($sql);
        $success = $command->execute();
        return $success;
    }

    public static function checkApprove($id)
    {
        $db = self::getDb();
        $sql = " call php_xiaoxin_getapproveschool($id)";
        $command = $db->createCommand($sql);
        return $command->queryAll();
    }

    public static function getUserNamePhoto($ids)
    {
        $db = Yii::app()->db_member;
        $sql = " call php_xiaoxin_getUserPhoto('$ids')";
        $command = $db->createCommand($sql);
        $res = $command->queryAll();
        return $res;
    }
    public static function getChildGuardian($child,$val,$array){
        foreach($array as $key=>$v){
            if($val==$v){
                $member=Member::model()->findByPk($child);
                return $member->name;
            }
        }
        return 0;

    }
    public static function inserttb_notice_Message($v, $receiveId, $familyIds, $name)
    {
            $db = self::getDb();
            $rguardian = isset($familyIds[$receiveId]) ? $familyIds[$receiveId] : $receiveId;
            $sql = " call php_xiaoxin_insertreceivemessage(:noticeId,:sender,:receiver,:noticeType,:data,:sendTitle,
            :receiveTitle,:sid,:schoolname,:uname,:rguardian,:sendtime)";
            $command = $db->createCommand($sql);
            $noticeId = $v['noticeid'];
            $command->bindParam(':noticeId', $noticeId, PDO::PARAM_INT);
            $command->bindParam(':sender', $v['sender'], PDO::PARAM_STR);
            $command->bindParam(':receiver', $receiveId, PDO::PARAM_STR);
            $command->bindParam(':noticeType', $v['noticetype'], PDO::PARAM_INT);
            $command->bindParam(':data', $v['content'], PDO::PARAM_STR);
            $command->bindParam(':sendTitle', $v['sendertitle'], PDO::PARAM_STR);
            $command->bindParam(':receiveTitle', $v['receivertitle'], PDO::PARAM_STR);
            $command->bindParam(':sid', $v['sid'], PDO::PARAM_INT);
            $command->bindParam(':sendtime', $v['sendtime'], PDO::PARAM_STR);
            $command->bindParam(':schoolname', $v['schoolname'], PDO::PARAM_STR);
            $command->bindParam(':uname', $name, PDO::PARAM_STR); //接收者名称,比如高中一年级(2),(3)班或李xx,王yy
            $command->bindParam(':rguardian', $rguardian, PDO::PARAM_INT);
            $f=$command->execute();

    }
    public static function inBadword($word,$badwordList){
        $showword=array();

        if(is_array($badwordList)){
            foreach($badwordList as $val){
                 if(strpos($word,trim($val->word))!==false){
                     $showword[]=$val->word;
                 }
            }
        }
        return $showword;
    }
}