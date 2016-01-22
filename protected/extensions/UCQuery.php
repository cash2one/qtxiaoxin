<?php
/**
* @author panrj 2014-08-09 
* 查询辅助类，提供常用方法
*/

class UCQuery
{
    public static $_mem=null;
    public static function getDb()
    {
        return Yii::app()->db_member;
    }

    /**
    * @author panrj 2014-08-09 
    * 查询一条数据并作为对象返回
    */
    public static function queryRow($sql)
    {
        $db = self::getDb();
        $result = $db->createCommand($sql);
        $record = (object)$result->queryRow();
        return $record;
    }

    /**
    * @author panrj 2014-08-09 
    * 查询返回结果中的第一列
    */
    public static function queryColumn($sql)
    {
        $db = self::getDb();
        $result = $db->createCommand($sql);
        // $records = (object)$result->queryAll();
        $records = $result->queryColumn();
        return $records;
    }

    /**
    * @author panrj 2014-08-09 
    * 查询多条数据
    */
    public static function queryAll($sql)
    {
        $db = self::getDb();
        $result = $db->createCommand($sql);
        // $records = (object)$result->queryAll();
        $records = $result->queryAll();
        return $records;
    }

    /**
    * @author panrj 2014-08-09 
    * 查询一条数据并直接返回第一列的值
    */
    public static function queryScalar($sql)
    {
        $db = self::getDb();
        $result = $db->createCommand($sql);
        $data = $result->queryScalar();
        return $data;
    }

    /**
    * @author panrj 2014-08-09 
    * 更新用户资料
    */
    public static function updateUser($sql)
    {
        $result = self::updateTrans($sql);
        return $result;
    }

    /**
    * @author panrj 2014-08-09 
    * 插入数据结果处理
    */
    public static function insertTrans($sql)
    {
        $connection=self::getDb(); 
        $lastid = $connection->createCommand($sql)->queryScalar();
        return $lastid;
    }

    /**
    * @author panrj 2014-08-09 
    * 执行sql语句，没有返回值
    */
    public static function execute($sql)
    {
        $connection=self::getDb();
        $connection->createCommand($sql)->execute();
    }

    /**
    * @author panrj 2014-08-09 
    * 更新数据结果处理
    */
    public static function updateTrans($sql)
    {
        $connection=self::getDb(); 
        // $transaction=$connection->beginTransaction();
        // $error = '';
        // try
        // {
        //     if(is_array($sql)){
        //         foreach($sql as $q){
        //             $connection->createCommand($q)->execute();
        //         }
        //     }else{
               $error = $connection->createCommand($sql)->queryScalar();
        //     }
        //     $transaction->commit();
        // }
        // catch(Exception $e) // 如果有一条查询失败，则会抛出异常
        // {
        //     $transaction->rollBack();
        //     $error = $e->getMessage();
        //     print $error;exit;
        // }
        return $error;
    }

    /**
    * @author panrj 2014-08-09 
    * 根据表名和主键值查询一条数据
    */
    public static function loadTableRecord($tablename,$pk)
    {
        $sql = "CALL php_xiaoxin_GetTableRecordByPk('".$tablename."','".$pk."')";
        $record = self::queryRow($sql);
        return $record;
    }

    /**
    * @author panrj 2014-08-09 
    * 查询学生监护人
    */
    public static function getStudentGuradian($sid,$deleted=0)
    {
        $sql = "CALL php_xiaoxin_GetStudentGuardian('".$sid."','".$deleted."')";
        $records = self::queryAll($sql);
        return $records;
    }

    /**
    * @author panrj 2014-08-28 
    * 获取学生监护人手机
    */
    public static function getStudentGuradianMobile($sid)
    {
        $guardians = self::getStudentGuradian($sid);
        if(count($guardians))
            return $guardians[0]['mobilephone'];
        return '';
    }

    /**
    * @author panrj 2014-08-09 
    * 查询班级所在学校
    */
    public static function getSchoolByClassPk($cid)
    {
        $class = self::loadTableRecord('tb_class',$cid);
        $sid = $class->sid;
        $school = self::loadTableRecord('tb_school',$sid);
        return $school;
    }

    /**
    * @author panrj 2014-08-09 
    * 主键查询学校
    */
    public static function loadSchool($id)
    {
        $sql = "CALL php_xiaoxin_getSchoolByPk('".$id."')";
        $school = self::queryRow($sql);
        return $school;
    }  

    /**
    * @author panrj 2014-08-09 
    * 主键查询用户
    */
    public static function loadUser($id)
    {
       //下面这样做有严重性能问题，先要去查系统表，获取主键，再去目标表查，一条查询要60ms,直接改从主键获取10,2ms
        //$user = UCQuery::loadTableRecord('tb_user',$id);
        //直接改从主键获取10
        $user=Member::model()->findByPk($id);
        return $user;
    }  

    /**
    * @author panrj 2014-08-09 
    * 主键查询班级
    */
    public static function loadClass($id)
    {
        $sql = "CALL php_xiaoxin_getClassByPk('".$id."')";
        $class = self::queryRow($sql);
        return $class;
    }  

    /**
    * @author panrj 2014-08-09 
    * 查询班级所在年级
    */
    public static function getClassGrade($class)
    {
        $age = MainHelper::getGradeAge($class->year);
        $stid = $class->stid;
        $sql = "CALL php_xiaoxin_getGradeByAttr('".$age."','".$stid."')";
        $grade = self::queryRow($sql);
        return $grade;
    }  

    public static function countClassTeacher($id)
    {
        $sql = "CALL php_xiaoxin_countClassTeacher('".$id."')";
        $rel = self::queryRow($sql);
        return $rel->num;
    }  

    /**
    * @author panrj 2014-08-09 
    * 查询老师所在学校
    */
    public static function getTeacherSchool($id)
    {
        $sql = "CALL php_xiaoxin_getTeacherSchool('".$id."')";
        $schools = self::queryAll($sql);
        return $schools;
        
        $sql = "select DISTINCT t.teacher AS `userid`,c.sid,s.name,s.aid,s.stid from tb_class_teacher_relation t ";
        $sql.=" inner join tb_class c on t.cid=c.cid left join tb_school s on c.sid=s.sid where t.deleted=0 and c.deleted=0 and s.deleted=0 and t.teacher=$id";
        $schools1 = self::queryAll($sql);
        if(!is_array($schools1)){
            $schools1=array();
        }
        return $schools1;
    }

    /**
    * @author panrj 2014-08-09 
    * 查询学校年级
    */
    public static function getSchoolGrade($id)
    {
        $sql = "CALL php_xiaoxin_getSchoolGrade('".$id."')";
        $grades = self::queryAll($sql);
        return $grades;
    }

    /**
     * 初始化一个分页插件
     * panrj 2014-08-018
     * @var int $count 总数
     * @var int $size 每页数目
     * @return obj CPagination  $pages
     */
    public static function loadCPagination($count,$size=10)
    {
        $criteria=new CDbCriteria();
        $pages=new CPagination($count);
        $pages->pageSize=$size;
        $pages->applyLimit($criteria);
        return $pages;
    }   

    /**
     * 分页数据
     * panrj 2014-08-18
     * @var array $datas 要分页的数据
     * @var int $page 第几页
     * @var int $size 每页数目
     * @return array
     */
    public static function PageData($datas,$page=1,$size=10)
    {
        // conlog($page);
        $count = count($datas);
        $pager = self::loadCPagination($count,$size);
        $datas = array_chunk($datas,$size);
        $data = count($datas)?$datas[$page-1]:array();
        return array('datas'=>$data,'pager'=>$pager);
    }

    /**
     * 手机密码，验证码发送(xw_sms)
     * panrj 2014-11-04
     * @var string $mobile 手机号码
     * @var string $msg 发送内容
     */
    public static function sendMobileMsg($mobile,$msg,$dataType=12)
    {
       // $sql = "CALL fn_AddSmsMessage('".$mobile."','10001','101','".$msg."','".SMS_SIGN."',0,1)";
        $sql = "CALL fn_sendSmsType('".$mobile."',0,'".$msg."','".SMS_SIGN."',$dataType)";
        $connection = Yii::app()->db_msg;
        $connection->createCommand($sql)->execute();
    }

    /**
     * 发送手机密码
     * panrj 2014-11-04
     * @var string $mobile 手机号码,
     * @var string $password 密码
     */
    public static function sendMobilePasswordMsg($mobile,$password)
    {
        $code = '你好！感谢您使用'.SITE_NAME.'（'.SITE_URL.'）,平台有家校沟通丶成绩管理等功能。您的账号:' . $mobile . '，密码:'.$password.'。客服电话:4001013838，工作时间:08:00-20:00';
        self::sendMobileMsg($mobile,$code);
    }

    /**
     * 校信通知发送(qtxx_sms)
     * panrj 2014-11-04
     * @var string $mobile 手机号码
     * @var string $msg 发送内容
     */
    public static function sendQtxxMsg($mobile,$msg,$dataType=98)
    {
        //$sql = "CALL fn_AddSmsMessage('".$mobile."','10001','101','".$msg."','".SMS_SIGN."',0,1)";
        $sql = "CALL fn_sendSmsType('".$mobile."',0,'".$msg."','".SMS_SIGN."',$dataType)";
        $connection = Yii::app()->db_msg_qtxx;
        $connection->createCommand($sql)->execute();
    }

    /**
     * 检测手机号码是否为用户绑定手机
     * panrj 2014-08-21
     * @var int $uid 用户userid
     * @var string $mobile 手机号码
     * @return bool
     */
    public static function checkUserMobile($uid,$mobile)
    {
        $user = self::loadUser($uid);
        if($mobile==$user->mobilephone){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 检测用户是否为校信客户端用户
     * panrj 2014-08-21
     * @var int $uid 用户userid
     * @return bool
     */
    public static function checkUserClient($uid)
    {
        $user = Member::model()->findByPk($uid);
        $client = explode(",",$user->client);
        if(in_array('1',$client)){
            return true;
        }else{
            return false;
        }
    }

    public static function getUserSex($sex)
    {
        if($sex=='1')
            return '男';
        if($sex=='2')
            return '女';
        return '';
    }

    public static function getGuardianRelationArr()
    {
        $Arr = array(
            '爸爸'=>'爸爸',
            '妈妈'=>'妈妈',
            '爷爷'=>'爷爷',
            '奶奶'=>'奶奶',
            '外公'=>'外公',
            '外婆'=>'外婆',
            '家长'=>'家长',
        );
        return $Arr;
    }

    public static function getPhotoByUserid($userid,$empty=false)
    {
        $ext = UCQuery::loadTableRecord('tb_user_ext',$userid);
        $default = $empty?'':Yii::app()->request->baseUrl.'/image/xiaoxin/pic_ioc.jpg';
        $photo = property_exists($ext,'photo')&&$ext->photo?$ext->photo:$default;
        return $photo;
    }

    public static function getStudentPhotoByUserid($userid,$empty=false)
    {
        $ext = UCQuery::loadTableRecord('tb_user_ext',$userid);
        $student = Member::model()->findByPk($userid);
        if($student->sex==0)
            $default= Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';
        if($student->sex==1)
            $default=  Yii::app()->request->baseUrl.'/image/xiaoxin/man_pic.jpg';
        if($student->sex==2)
            $default=  Yii::app()->request->baseUrl.'/image/xiaoxin/woman_pic.jpg';
        $default = $empty?'':$default;
        $photo = property_exists($ext,'photo')&&$ext->photo?$ext->photo:$default;
        return $photo;
    }

    /*
    * zhoujsh 2014-09-12
     * 批量生成邀请码,num最大个数
     * 规则:类型type+随机码(3)+微妙
     * type 0-老师 1--家长
     */
    public static function generateInviteCode($cid,$num,$type){
        $role = $type + 1;//第一位不能为0
        // $sid = $role.sprintf("%05d", $sid);//学校ID保持五位
        // $scid = sprintf("%06d", $cid);//学校ID保持六位'
        $successNum=0;
        for($i=0;$i<$num;$i++){
            $r1 = rand(0,999);
            $time = explode (" ", microtime());
            $t = $time[0]*1000*1000;
            $r2 = (int)$t;
            $msgid=$r1.$r2;
            $hash = $role.$msgid;
            // $code = MainHelper::enid($hash);
            $password=MainHelper::generate_password(6);
            $sql="call php_xiaoxin_insert_cdkey('$hash','$password',$type,$cid)";
            $success=UCQuery::execute($sql);
            if($success){
                $successNum++;
            }
        }
        return $successNum==$num?true:false;
    }

    /**
     * 根据邀请码反解出邀请学校，班级，身份
     * panrj 2014-09-15
     * @var string $code 邀请码
     * @return array $info
     */
    public static function deidInviteCode($code)
    {

        // $num = MainHelper::deid($code);
        if($code=='')
            return $code;
        $info = array();
        $info['type'] = substr($code,0,1) - 1;
        // $info['sid'] = (int)substr($num,1,5);
        // $info['cid'] = (int)substr($num,6,6);
        return $info;
    }

    /**
     * 生成ID
     * panrj 2014-09-18
     * @var int $type 类型,0：用户 1：班级 2：学校 3：部门
     * @var bool $full 是否返回完整用ID（带用户版本，USER_BRANCH常量）
     * @return int $uid
     */
    public static function makeMaxId1($type,$full=false)
    {
        $version = (int)USER_BRANCH;
        self::execute("LOCK TABLE `tb_user_maxid` WRITE;");
        $sql = "SELECT maxID FROM `tb_user_maxid` WHERE `type`='".$type."' AND `version`='".$version."' LIMIT 1 ;";
        $uid = self::queryScalar($sql);
        $uid = $uid + 1;
        $sql = "UPDATE `tb_user_maxid` SET maxID=".$uid." WHERE `type`='".$type."' AND `version`='".$version."';UNLOCK TABLES;";
        $result = self::execute($sql);
        return $full?($uid*100)+$version:$uid;
    }

    public static function getMemcache(){
        $array=Yii::app()->params['memcache'];
        if(is_null(self::$_mem)){
            if(is_array($array)&&(extension_loaded("memcache")||extension_loaded("memcached"))){
                if(extension_loaded("memcached")){
                    self::$_mem = new Memcached;
                }else{
                    self::$_mem = new Memcache;
                }
                self::$_mem->addserver($array['host'],$array['port']);
            }
        }
        return self::$_mem;
    }

    public static function makeMaxId($type,$full=false)
    {
        $version = (int)USER_BRANCH;
        $mem=self::getMemcache();
        if($mem){
            $key="INCREMENT_ID".$type.$version;
            $key_max="INCREMENT_ID".$type.$version."max";
            $vallue=$mem->get($key);
            if(!$vallue){
                self::execute("LOCK TABLE `tb_user_maxid` WRITE;");
                $sql = "SELECT maxID FROM `tb_user_maxid` WHERE `type`='".$type."' AND `version`='".$version."' LIMIT 1 ;";
                $uid = self::queryScalar($sql);
                $uid = $uid + 1;
                $mem->set($key,$uid);
                $max=$uid+99;
                $mem->set($key_max,$max);
               // error_log("database uid:$uid".",max:$max");
                $sql = "UPDATE `tb_user_maxid` SET maxID=maxID+100 WHERE `type`='".$type."' AND `version`='".$version."';UNLOCK TABLES;";
                self::execute($sql);
                return $full?($uid*100)+$version:$uid;
            }
            $uid=$mem->increment($key,1);
            $max=$mem->get($key_max);
            if($uid&&$max){
                if($uid<$max){
                    //error_log("mem uid:$uid".",max:$max");
                    return $full?($uid*100)+$version:$uid;
                }else{
                    self::execute("LOCK TABLE `tb_user_maxid` WRITE;");
                    $sql = "SELECT maxID FROM `tb_user_maxid` WHERE `type`='".$type."' AND `version`='".$version."' LIMIT 1 ;";
                    $uid = self::queryScalar($sql);
                    $uid = $uid + 1;
                    $max=$uid+99;
                    $mem->set($key,$uid);
                    $mem->set($key_max,$max);
                  //  error_log("database gt100 uid:$uid".",max:$max");
                    $sql = "UPDATE `tb_user_maxid` SET maxID=maxID+100 WHERE `type`='".$type."' AND `version`='".$version."';UNLOCK TABLES;";
                    self::execute($sql);
                    return $full?($uid*100)+$version:$uid;
                }
            }else{
                self::execute("LOCK TABLE `tb_user_maxid` WRITE;");
                $sql = "SELECT maxID FROM `tb_user_maxid` WHERE `type`='".$type."' AND `version`='".$version."' LIMIT 1 ;";
                $uid = self::queryScalar($sql);
                $uid = $uid + 1;
                $sql = "UPDATE `tb_user_maxid` SET maxID=".$uid." WHERE `type`='".$type."' AND `version`='".$version."';UNLOCK TABLES;";
                $result = self::execute($sql);
                return $full?($uid*100)+$version:$uid;
            }

        }else{
            self::execute("LOCK TABLE `tb_user_maxid` WRITE;");
            $sql = "SELECT maxID FROM `tb_user_maxid` WHERE `type`='".$type."' AND `version`='".$version."' LIMIT 1 ;";
            $uid = self::queryScalar($sql);
            $uid = $uid + 1;
            $sql = "UPDATE `tb_user_maxid` SET maxID=".$uid." WHERE `type`='".$type."' AND `version`='".$version."';UNLOCK TABLES;";
            $result = self::execute($sql);
            return $full?($uid*100)+$version:$uid;
        }
    }
} 