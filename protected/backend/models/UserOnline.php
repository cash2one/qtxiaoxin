<?php

/**
 * This is the model class for table "{{user_online}}".
 *
 * The followings are the available columns in table '{{user_online}}':
 * @property string $userid
 * @property string $server
 * @property integer $state
 * @property string $sessioncode
 * @property integer $clienttype
 * @property string $devicecode
 * @property string $iostoken
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $version
 */
class UserOnline extends MemberActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user_online}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userid, state, sessioncode, clienttype', 'required'),
            array('state, clienttype, version', 'numerical', 'integerOnly' => true),
            array('userid', 'length', 'max' => 20),
            array('server, sessioncode', 'length', 'max' => 32),
            array('devicecode', 'length', 'max' => 64),
            array('iostoken', 'length', 'max' => 255),
            array('updatetime,creationtime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('userid, server, state, sessioncode, clienttype, devicecode, iostoken, creationtime, updatetime, version', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'userid' => '用户唯一标识',
            'server' => '接入服务器的地址',
            'state' => '在线状态(0.未曾登录;1.在线;2.离线;3.注销）',
            'sessioncode' => '在线的会话码，用于保持一致',
            'clienttype' => '客户端类型（1.Android;2.IOS)',
            'devicecode' => '客户端设备编码',
            'iostoken' => 'IOS设备的Token值',
            'creationtime' => '创建时间',
            'updatetime' => '更新时间',
            'version' => '用户使用的客户端版本号',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('userid', $this->userid, true);
        $criteria->compare('server', $this->server, true);
        $criteria->compare('state', $this->state);
        $criteria->compare('sessioncode', $this->sessioncode, true);
        $criteria->compare('clienttype', $this->clienttype);
        $criteria->compare('devicecode', $this->devicecode, true);
        $criteria->compare('iostoken', $this->iostoken, true);
        $criteria->compare('creationtime', $this->creationtime, true);
        $criteria->compare('updatetime', $this->updatetime, true);
        $criteria->compare('version', $this->version);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserOnline the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getOnLineUser($userids)
    {
        $criteria = new CDbCriteria;
        $criteria->addInCondition('userid', $userids);
        $data = self::model()->findAll($criteria);
        $arr = array();
        foreach ($data as $val) {
            $arr[$val->userid] = $val;
        }
        return $arr;
    }

    /**
    * panrj 2014-12-08
    * 获取昨日新增客户端记录
    * @return UserOnline records
    */
    public static function getYesterdayRecord($date)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition("TO_DAYS('".$date."')-TO_DAYS(creationtime)=0",'and');
        return self::model()->findAll($criteria);
    }

    /**
    * panrj 2014-12-08
    * 检测用户是否安装客户端
    * @return UserOnline record
    */
    public static function checkUserOnLine($userid)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('userid', $userid);
        return self::model()->count($criteria);
    }

    /*
     *
     */
    public static function getOnLineByUserId($userid)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('userid', $userid);
        return self::model()->findAll($criteria);
    }

    /*
     * 安装量统计
     */
    public static function statistic($params)
    {
        $stepsql="DATE_FORMAT(creationtime,'%Y-%m-%d')";
        if ($params['step'] == 1) { //按天
            $stepsql="DATE_FORMAT(creationtime,'%Y-%m-%d')";;
            $useronlinesql = "select $stepsql  as dd,count(*) as num from tb_user_online s";
        } else if ($params['step'] == 2) {
            $stepsql="DATE_FORMAT(creationtime,'%Y-%u')";;
            $useronlinesql = "select $stepsql  as dd,count(*) as num from tb_user_online s";
        } else if($params['step'] == 3) {
            $stepsql="DATE_FORMAT(creationtime,'%Y-%m')";;
            $useronlinesql = "select $stepsql as dd,count(*) as num from tb_user_online s";
        }else{
            $stepsql="DATE_FORMAT(creationtime,'%Y-%m-%d')";;
            $useronlinesql = "select $stepsql  as dd,count(*) as num from tb_user_online s";
        }
        //$useronlinesql = "select DATE_FORMAT(creationtime,'%Y-%m-%d') as dd,count(*) as num from tb_user_online s";
        $where = " where 1=1 ";

        if (!empty($params['start'])) {
            $where .= (" and s.creationtime>='" . $params['start'] . "'");
        }
        if (!empty($params['end'])) {
            $where .= (" and s.creationtime<='" . $params['end'] . " 23:59:59" . "'");
        }

        if (!empty($params['deviceType'])) {
            $where .= (" and s.clienttype=" . $params['deviceType']);
        }
        $sidsql = "";
        $schoolsql = "select sid from tb_school where deleted=0 ";
        if (!empty($params['area']) || !empty($params['city'])) {
            if (!empty($params['area'])) {
                $schoolsql .= " and aid=" . $params['area'];
                $sidsql = " and t3.aid in(" .  $params['area'] . ')';
            } else if (!empty($params['city']) && empty($params['area'])) {
                $areaArr = Area::getAreaData(array('cid' => $params['city']));
                $areaIdArr = array();
                foreach ($areaArr as $val) {
                    $areaIdArr[] = $val->aid;
                }
                $areaids = count($areaIdArr) ? implode(",", $areaIdArr) : "0";
                $schoolsql .= " and aid in(" . $areaids . ")";
                $sidsql = " and t3.aid in(" .  $areaids . ')';
            }
        }
        if (!empty($params['sid'])) {

            $schoolsql .= (" and sid in(" . $params['sid'] . ") ");
            $sidsql = (" and t3.sid=" . $params['sid']);
        }

        if ($params['identity'] == 1) { //老师
            $teachersql = "  inner join ( select distinct(teacher) from tb_school_teacher_relation tr   inner join ( " . $schoolsql . ') ts on ts.sid=tr.sid where tr.deleted=0 ) g ';
            $useronlinesql .= ($teachersql . 'on s.userid=g.teacher');
            $useronlinesql .= $where;
            $useronlinesql .= " group by $stepsql";
        } else if ($params['identity'] == 2) { //学生
            $studentsql = " inner join (select DISTINCT g.guardian from tb_guardian g inner join  tb_class_student_relation t1 on g.child=t1.student inner join tb_class t2 on t1.cid=t2.cid inner join tb_school t3 on t2.sid=t3.sid where 1=1 $sidsql   and t3.deleted=0 and t1.deleted=0 and t1.state=1 and t2.deleted=0) ss";
            $useronlinesql .= ($studentsql . " on s.userid=ss.guardian ");
            $useronlinesql .= $where;
            $useronlinesql .= " group by $stepsql";
        } else { //所有
            $teachersql = "  inner join  (select teacher from tb_school_teacher_relation tr   inner join ( " . $schoolsql . ') ts on ts.sid=tr.sid where tr.deleted=0  ';
            $teachersql.= "   union  select  g.guardian as teacher from tb_guardian g inner join  tb_class_student_relation t1 on g.child=t1.student inner join tb_class t2 on t1.cid=t2.cid inner join tb_school t3 on t2.sid=t3.sid where 1=1 $sidsql   and t3.deleted=0 and t1.deleted=0 and t1.state=1 and t2.deleted=0) tu ";
            $useronlinesql = $useronlinesql . $teachersql." on s.userid=tu.teacher " .$where;
            $useronlinesql .= " group by $stepsql";
        }
      // echo $useronlinesql;
        $list = UCQuery::queryAll($useronlinesql);
        return $list;
    }
}
