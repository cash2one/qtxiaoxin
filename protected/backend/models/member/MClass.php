<?php

/**
 * This is the model class for table "{{class}}".
 *
 * The followings are the available columns in table '{{class}}':
 * @property integer $cid
 * @property string $name
 * @property integer $year
 * @property integer $sid
 * @property integer $stid
 * @property integer $type
 * @property string $master
 * @property string $info
 * @property string $teachers
 * @property integer $total
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property School $s
 * @property User $master0
 * @property ClassStudentRelation[] $classStudentRelations
 * @property ClassTeacherRelation[] $classTeacherRelations
 */
class MClass extends MemberActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public $schoolname;
    public $gradename;
    public $mastername;
    public $courses;
    public $gid;
    public $seqno;

    public function tableName()
    {
        return '{{class}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, year, sid, stid', 'required'),
            array('year, sid, stid, type, total, state, deleted', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('master', 'length', 'max' => 20),
            array('info', 'length', 'max' => 1024),
            array('teachers', 'length', 'max' => 11),
            array('updatetime,creationtime,seqno,pingyin', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cid, name, year, sid, stid, type, master, info, teachers, total, state, creationtime, updatetime, deleted, seqno', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            's' => array(self::BELONGS_TO, 'School', 'sid'),
            'master0' => array(self::BELONGS_TO, 'Member', 'master'),
            'classStudentRelations' => array(self::HAS_MANY, 'ClassStudentRelation', 'cid'),
            'classTeacherRelations' => array(self::HAS_MANY, 'ClassTeacherRelation', 'cid'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'cid' => '班级ID',
            'name' => '班级名称',
            'year' => '入学年份',
            'sid' => '学校id',
            'stid' => '所属类型',
            'type' => '类型',
            'master' => '班主任',
            'info' => '班级介绍',
            'teachers' => '老师人数',
            'total' => '总人数',
            'state' => '状态：保留字段',
            'creationtime' => '创建时间',
            'updatetime' => '更新时间',
            'deleted' => '已删除',
            'seqno' => '序号',
            'pingyin' => '班级拼音',
        );
    }

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('sid', $this->sid);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('aid', $this->aid);
        $criteria->compare('stid', $this->stid, true);
        $criteria->compare('longitude', $this->longitude);
        $criteria->compare('latitude', $this->latitude);
        $criteria->compare('state', $this->state);
        $criteria->compare('creationtime', $this->creationtime, true);
        $criteria->compare('updatetime', $this->updatetime, true);
        $criteria->compare('deleted', $this->deleted);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    public function beforeSave()
    {

        $py=new py_class();
        $this->name=trim($this->name);
        $this->pingyin=substr($py->str2py($this->name),0,10);
       // $this->pingyin=substr(Pingyin::Pinyin($this->name,"1"),0,10);
        return parent::beforeSave();
    }
    /**
     * 学校列表分页数据
     * panrj 2014-06-12
     * @param array $parms 查询条件及分页参数
     * @return array $result
     */
    public function pageData($parms = array())
    {
        $result = array();
        $criteria = new CDbCriteria();
        //用户权限过滤
        $uid = Yii::app()->user->id;
        $sids = UserAccess::getUserAccessTargetPks($uid,$type=1);
        if(!empty($sids)){
            $criteria->compare('sid',$sids);
        }

        if (isset($parms['name']) && $parms['name'] != '') {
            $criteria->compare('name', $parms['name'], true);
        }
        $gradeId = isset($parms['grade']) ? $parms['grade'] : '0';
        if ($gradeId == 'interest') {
          //  $criteria->compare('stid', 0);
          //  $criteria->compare('year', 0);
            $criteria->compare('type', 1);
        } else {
            if ($gradeId > 0) {
                $gradeInfo = Grade::model()->findByPk($gradeId);
                $stid = $gradeInfo->stid;
                $year = MainHelper::getClassYearByGradeAge($gradeInfo->age);
                $criteria->compare('stid', $stid);
                $criteria->compare('year', $year);
                $criteria->compare('type', 0);
            }
        }

        if (isset($parms['sid']) && !empty($parms['sid'])) {
            $criteria->compare('sid', $parms['sid']);
        }
        $criteria->compare('deleted', 0);
        $criteria->order = 'seqno ,pingyin asc';
        $count = self::model()->count($criteria);
        $pager = new CPagination($count);
        if (isset($parms['size']) && $parms['size']) {
            $pager->pageSize = $parms['size'];
        } else {
            $pager->pageSize = 15;
        }
        $pager->applyLimit($criteria);
        $datalist = self::model()->findAll($criteria);
        $result['model'] = $datalist;
        $result['pages'] = $pager;

        return $result;
    }

    
    public function getClassGrade()
    {
        if ($this->type == 0) {
            $gradeArr['age'] = MainHelper::getGradeAge($this->year);
            $gradeArr['stid'] = $this->stid;
            $grade = Grade::getGradeInfo($gradeArr);
        } else {
            $grade = new Grade();
            $grade->gid = 0;
            $grade->name = '兴趣班';
        }
        return $grade;
    }


    /**
     * 班级列表返回年级分组班级数据
     * panrj,lvxj 2014-09-30
     * @param array $classes 班级对象数组
     * @return array $gradeArr
     */
    public static function getGradeClassArr($classes)
    {
        $list = array();
        foreach ($classes as $gc) {
            if ($gc instanceof MClass) {
                $class = $gc;
                $grade = $class->getClassGrade();
            }else if (is_array($gc)){
                $class = $gc;
                $grade = self::getClassGradeArr($class['year'],$class['stid']);
            }else {
                $class = $gc->c;
                $grade = $class->getClassGrade();
            }
         if ($grade) {
                $class->gid = $grade->gid;
                $class->gradename = $grade->name;
                $list[] = $class;
            }
        }
        $gradeArr = array();
        foreach ($list as $class) {
            $gradeArr[$class->gid] = array('gid' => $class->gid, 'gname' => $class->gradename, 'classes' => $list);
        }
        foreach ($gradeArr as $k => $v) {
            $classArr = array();
            foreach ($v['classes'] as $c) {
                if ($k == $c->gid) {
                    $classArr[$c->cid] = $c->name;
                }
            }
            $gradeArr[$k]['classes'] = $classArr;
        }
        return $gradeArr;
    }

    //花名册根据班级获得年级
    public static function getGradeClassPhoneBook($classes)
    {
        $list = array();
        foreach ($classes as $gc) {
           if (is_array($gc)){
                $class = $gc;
                $grade = self::getClassGradeArr($class['year'],$class['stid']);
            }
            if ($grade) {
                $class['gid'] = $grade->gid;
                $class['gradename'] = $grade->name;
                $list[] = $class;
            }else if($class['stid']==0&&$class['year']==0&&$class['type']==1){
                $class['gid'] = 'interest';
                $class['gradename'] = '兴趣班';
                $list[] = $class;
            }
        }

        $gradeArr = array();
        $classdata = array();
        foreach ($list as $class) {
            $gradeArr[$class['gid']] = array('gid' => $class['gid'], 'gname' => $class['gradename'], 'classes' => array());
            if( $gradeArr[$class['gid']]['gname']==$class['gradename']){
                $classdata[$gradeArr[$class['gid']]['gname']][] = $class;
            }
        }
        foreach ($gradeArr as $k => $v) {
            $gradeArr[$k]['classes'] = $classdata[$v['gname']];
        }
        return $gradeArr;
    }

    /*
     * $gcinfo是一个数组，保存年级信息，及年级下的班级数据
     * 此方法，根据班级id返回年级信息,减少数据库查询而已
     */
    public static function getGradeNameByCid($gcinfo, $cid)
    {
        foreach ($gcinfo as $k => $val) {
            if (is_array($val['classes'])) {
                foreach ($val['classes'] as $cc => $cv) {
                    if ($cc == $cid) {
                        return $val['gname'];
                    }
                }
            }
        }
    }


    public function getClassSubject($sid)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('cid', $this->cid);
        $criteria->compare('sid', $sid);
        $criteria->compare('deleted', 0);
        $subject = ClassTeacherRelation::model()->find($criteria);
        return $subject ? $subject->teacher : '';
    }

    public static function getSchoolClass($sid)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('sid',$sid);
        $criteria->compare('deleted',0);
        $criteria->order="seqno asc,pingyin asc";
        return MClass::model()->findAll($criteria);
    }
    public static function getSchoolClassAfter($sid)
    {
          $result =  self::getSchoolClass($sid);
           $classArr = array();
          foreach($result as $key=>$val){
              $classArr[] = $val->name;
          }
          return $classArr;
    }

    public static function getClassByCids($cids)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition(' cid in(' . $cids . ')');
        $criteria->compare('deleted', 0);
        return MClass::model()->findAll($criteria);
    }
    /*
        *
        */
    public static function getClassByName($name,$sid)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('name', $name);
        $criteria->compare('sid', $sid);
        $criteria->compare('deleted', 0);
        $criteria->compare('state', 1);
        return MClass::model()->find($criteria);
    }
    /*
     *
     */
    public static function getClassByPosition($sid, $isseeallclass, $year = 0, $stid = 0)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('sid', $sid);
        $criteria->compare('deleted', 0);
        if ($isseeallclass == 1) { //年级主任
            $criteria->compare('year', $year);
            $criteria->compare('stid', $stid);
        }

        $criteria->order="seqno ,pingyin ";
        return MClass::model()->findAll($criteria);
    }
   //根据学校schoolid,uid,得到老师所在兴趣班
    public static function getAllInterestClass($schoolid,$uid)
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('classTeacherRelations');
        $criteria->compare('t.sid',$schoolid);
        $criteria->compare('t.stid',0);
        $criteria->compare('classTeacherRelations.teacher',$uid);
        $criteria->compare('classTeacherRelations.deleted',0);
        $criteria->compare('t.year',0);
        $criteria->compare('t.type',1);
        $criteria->compare('t.deleted', 0);
        $criteria->compare('t.state', 1);
        $criteria->order="seqno asc,pingyin asc";
        $allClass = self::model()->findAll($criteria);
        $result = array();
        foreach ($allClass as $key => $val) {
            $result[$key]['cid'] = $val['cid'];
            $result[$key]['name'] = $val['name'];
        }
        return $result;
    }
//根据学校schoolid,uid,得到老师所在兴趣班
    public static function getAllInterestClass2($schoolid)
    {
        $criteria = new CDbCriteria();

        $criteria->compare('t.sid',$schoolid);
        $criteria->compare('t.stid',0);
       // $criteria->compare('t.year',0);
        $criteria->compare('t.type',1);
        $criteria->compare('t.deleted', 0);
        $criteria->compare('t.state', 1);
        $criteria->order="seqno asc,pingyin asc";
        $allClass = self::model()->findAll($criteria);
        $result = array();
        foreach ($allClass as $key => $val) {
            $result[$key]['cid'] = $val['cid'];
            $result[$key]['name'] = $val['name'];
        }
        return $result;
    }
    //根据学校schoolid,stid,year查询所有班级
    public static function getAllClass($schoolid, $stid, $year,$uid)
    {   //echo $schoolid."----".$stid."----".$year."----".$uid;die();
        //32701----4----2012----1699901
        $teachers = SchoolTeacherRelation::getSchoolTeachersRelation(array('teacher' => $uid, 'sid' => $schoolid));
        $result = array();
        $cids = array();
        if ($teachers && isset($teachers->duty)) {
            $val=Duty::model()->findByPk($teachers->duty);
            if(!$val||$val->deleted==1){
                return null;
            }
            if ($val->isseeallclass == 0) {
                //查询对应的班级
                $sql_text = "select t.* from tb_class t,tb_class_teacher_relation r where r.teacher =$uid and year=$year and stid=$stid  and t.cid=r.cid and  t.sid = $schoolid and t.deleted=0 and r.deleted=0  order by seqno,pingyin";
                $classes = UCQuery::queryAll($sql_text);
            } else if ($val->isseeallclass == 1) {
                //查询对应年级下所有班级
                $year = $teachers->year;
                $stid = $teachers->stid;
                $sql_text = " select * from tb_class where sid=$schoolid and deleted=0 and year=$year and stid=$stid order by seqno,pingyin";
                $classes = UCQuery::queryAll($sql_text);


            } else if ($val->isseeallclass == 2) {
                //查询整个学校的班级
                $sql_text = "select * from tb_class where sid = $schoolid and deleted=0 and year=$year and stid=$stid order by seqno,pingyin";
                $classes = UCQuery::queryAll($sql_text);
            }
        }
        foreach($classes as $key => $val){
            if(!in_array($val['cid'],$cids)){
                $result[] = $val;
                $cids[]=$val['cid'];
            }
        }
        return $result;
    }


    public static  function getClassGradeArr($year,$stid)
    {
        $gradeArr['age'] = MainHelper::getGradeAge($year);
        $gradeArr['stid'] = $stid;
        $grade = Grade::getGradeInfo($gradeArr);
        return $grade;
    }

    /**
     * 创建自注册班级
     * zengp 2014-12-25
     * @param string $cname 班级名
     * @param int $sid 学校id
     * @param string $userid 用户id，用作班主任id
     * @return boolean
     */
    public static function createClassByOpenReg($cname,$info,$sid,$userid)
    {
        $classname =  MClass:: getClassByName($cname,$sid);
        if(!$classname){
            //自注册默认为兴趣班
            $openclass = new MClass;
            $openclass->name = $cname;
            $openclass->info = $info;
            $openclass->year = date('Y');
            $openclass->sid = $sid;
            $openclass->type = 1;
            $openclass->stid = 0;
            $openclass->master = $userid;
            $openclass->teachers = 1;
            $openclass->cid = UCQuery::makeMaxId(1, true);
            if($openclass->save()){
                $ctrelation = new ClassTeacherRelation;
                $ctrelation->cid = $openclass->cid;
                $ctrelation->teacher = $openclass->master;
                $ctrelation->state = 1;
                $ctrelation->subject = '';
                $ctrelation->type = 1;
                if($ctrelation->save()){
                    return $openclass->cid;
                }
            }
        }else{
            return "exist";
        }

        return false;
    }


    public static function Isexist($cname,$sid)
    {
        $classname =  MClass:: getClassByName($cname,$sid);
        if($classname){
            return $classname;
        }else{
            return false;
        }
    }
    /**
     * 根据班级id查询班级总人数
     * zengp 2014-12-28
     * @param string $cid 班级id    
     * @return int
     */    
    public static function getClassNumsByCid($cid){

        $class = self::model()->findByPk($cid);
        $teachers = $class->teachers;
        $students = $class->total;
        $total = $teachers + $students;        
        return $total;
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MClass the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
