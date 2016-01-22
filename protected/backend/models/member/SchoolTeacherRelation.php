<?php

/**
 * This is the model class for table "{{school_teacher_relation}}".
 *
 * The followings are the available columns in table '{{school_teacher_relation}}':
 * @property integer $id
 * @property integer $sid
 * @property string $teacher
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property integer $did
 *
 * The followings are the available model relations:
 * @property School $s
 * @property User $teacher0
 * @property Department $d
 */
class SchoolTeacherRelation extends MemberActiveRecord
{
    public $chooldeptarr;
    public $grade;
    public $grade_id;
    public $gradeArr;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{school_teacher_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, teacher', 'required'),
			array('sid, state, deleted, did', 'numerical', 'integerOnly'=>true),
			array('teacher', 'length', 'max'=>20),
			array('updatetime,creationtime,duty', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sid, teacher, state, creationtime, updatetime, deleted, did,duty', 'safe', 'on'=>'search'),
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
			'teacher0' => array(self::BELONGS_TO, 'Member', 'teacher'),
			'd' => array(self::BELONGS_TO, 'Department', 'did'),
            'role' => array(self::BELONGS_TO, 'Duty', 'duty'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sid' => '学校',
			'teacher' => '教师用户',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'did' => '部门',
			'duty' => '学校职务',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('sid',$this->sid);
		$criteria->compare('teacher',$this->teacher,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('did',$this->did);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /*
     * 查询学校的老师
     */
    public static function getSchoolTeachers($param){
        $criteria=new CDbCriteria;
        $criteria->with = array('teacher0');
        if(isset($param['sid']) && $param['sid']){
            $criteria->compare('t.sid',$param['sid']);
        }
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.state',1);
        $criteria->compare('teacher0.deleted',0);
        $criteria->order="pingyin";
        $data = self::model()->findAll($criteria);
        return $data;
    }
   /*
    * 根据sid和老师，获取关联信息
    */
    public static function getSchoolTeachersRelation($param){
        $criteria=new CDbCriteria;
        if(isset($param['sid']) && $param['sid']){
            $criteria->compare('sid',$param['sid']);
        }
        if(isset($param['teacher']) && $param['teacher']){
            $criteria->compare('teacher',$param['teacher']);
        }
        $criteria->compare('deleted',0);
        $criteria->compare('state',1);
        $data = self::model()->find($criteria);
        return $data;
    }
    /*
     * 获取老师的学校数组
     */
    public static function getTeacherSchools($uid)
    {
    	$criteria=new CDbCriteria;
    	$criteria->with = array('s');
        $criteria->compare('t.teacher',$uid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.state',1);
        $criteria->compare('s.deleted',0);
        $data = self::model()->findAll($criteria);
        $arr = array();
        foreach($data as $d){
        	$arr[$d->sid] = $d->s->name;
        }
        return $arr;
    }

    /*
     * 获取老师的学校关联信息
     */
    public static function getTeachersSchoolRaletion($teachers){
        $criteria=new CDbCriteria;
        if(isset($teachers) && $teachers){
            $criteria->compare('teacher',$teachers);
        }
        $criteria->compare('deleted',0);
        $criteria->compare('state',1);
        $data = self::model()->findAll($criteria);
        return $data;
    }
    /*
    * 获取老师的学校关联信息
    */
    public static function getTeachersSchoolRaletion2($schoolid,$teachers){
        $criteria=new CDbCriteria;
        if(isset($teachers) && $teachers){
            $criteria->compare('teacher',$teachers);
        }
        if(isset($schoolid) && $schoolid){
            $criteria->compare('sid',$schoolid);
        }
        $criteria->compare('deleted',0);
        $criteria->compare('state',1);
        $data = self::model()->findAll($criteria);
        return $data;
    }

     /**
     * 统计老师学校数量
     * panrj 2014-11-14
     * @param int $uid 老师Id
     * @param int $sid 学校Id
     * @return int $result
     */
    public static function countTeacherSchoolRelation($uid,$sid)
    {   
        $criteria = new CDbCriteria;
        $criteria->compare('teacher', $uid);
        $criteria->compare('sid', $sid);
        $criteria->compare('deleted', 0);
        $criteria->compare('state', 1);
        $data = self::model()->count($criteria);
        return $data;
    }

    /*
    * 获取老师的职务
    */
    public static function getTeachersJob($teachers){
       $sql = "select ts.*,td.name from tb_school_teacher_relation ts,tb_duty td where ts.duty = td.dutyid and ts.teacher = ".$teachers;
       $result = UCQuery::queryAll($sql);
        $temp = array();
       foreach($result as $key => $val){
           $temp[$val['sid']]=$val['name'];
       }
       return $temp;
    }

    /*
     * 获取老师所在部门
     * panrj 2014-10-30
     */
    public static function getTeachersDepartments($uid){
        $criteria=new CDbCriteria;
        $criteria->with = array('d');
        $criteria->compare('t.teacher',$uid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.state',1);
        $criteria->compare('d.deleted',0);
        $data = self::model()->findAll($criteria);
        return $data;
    }

    /*
     * 获取老师所在职务
     * panrj 2014-10-30
     */
    public static function getTeacherSchoolDuties($uid){
        $criteria=new CDbCriteria;
        $criteria->with = array('role');
        $criteria->compare('t.teacher',$uid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.state',1);
        $criteria->compare('role.deleted',0);
        $data = self::model()->findAll($criteria);
        return $data;
    }

    /*
     * 获取老师所在学校职务
     * panrj 2014-10-30
     */
    public static function getTeacherSchoolDuty($uid,$sid){
        $criteria=new CDbCriteria;
        $criteria->with = array('role');
        $criteria->compare('t.teacher',$uid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.sid',$sid);
        $criteria->compare('t.state',1);
        $criteria->compare('role.deleted',0);
        $data = self::model()->find($criteria);
        return $data;
    }


    /*
     * 获取老师的所有学校名，部门名
     */
    public static function getSchoolNameByTeachers($teachers){
        $arr=array();
        $data = self::getTeachersSchoolRaletion($teachers);
        $jobs = self::getTeachersJob($teachers);
        foreach($data as $k=>$val){
                if($val->d&&$val->d->deleted==0){
                    $arr[]=array('schoolname'=>$val->s?$val->s->name:'','deptname'=>$val->d?$val->d->name:'无部门','duty'=>isset($val['sid'])?(isset($jobs[$val['sid']])?$jobs[$val['sid']]:"无职务"):"无职务");
                }else{
                    $arr[]=array('schoolname'=>$val->s?$val->s->name:'','deptname'=>'无部门','duty'=>isset($val['sid'])?(isset($jobs[$val['sid']])?$jobs[$val['sid']]:"无职务"):"无职务");
                }
        }
        return $arr;
    }
    public function deleteTeachersRelation($teacher){
        $criteria=new CDbCriteria;
        $criteria->compare('teacher',$teacher);
        self::model()->updateAll(array('deleted'=>1),$criteria);
    }

    public static function deleteBySchoolPk($sid)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('sid',$sid);
        self::model()->updateAll(array('deleted'=>1),$criteria);
    }

    /*
     * 获取老师所在部门
     * panrj,zengp 2014-11-02
     */
    public static function getTeacherDuty($userid)
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('teacher0');
        $criteria->compare('t.teacher',$userid);
        $criteria->compare('t.state',1);
        $criteria->compare('t.deleted',0);
        $criteria->compare('teacher0.deleted',0);
        $data = self::model()->findAll($criteria);
        return $data;
    }

    /*
     * 获取老师所在部门
     * panrj,zengp 2014-11-02
     */
    public static function getTeacherDutyPks($userid)
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('teacher0');
        $criteria->compare('t.teacher',$userid);
        $criteria->compare('t.state',1);
        $criteria->compare('t.deleted',0);
        $criteria->compare('teacher0.deleted',0);
        $data = self::model()->findAll($criteria);
        $arr = array();
        foreach($data as $d){
            $arr[] = $d->duty;
        }
        return array_unique($arr);
    }
    //获取老师所在部门
    public static function getDepartmentByTeachers($schoolid,$teachers){
        $arr=array();
        $data = self::getTeachersSchoolRaletion2($schoolid,$teachers);
        foreach($data as $k=>$val){
            if($val->d&&$val->d->deleted==0){
                $arr[]=array('deptname'=>$val->d?$val->d->name:'无部门');
            }else{
                $arr[]=array('deptname'=>'无部门');
            }
        }
        $result = array();
        foreach($arr as $key=>$val){
            $result[] = $val['deptname'];
        }
        return $result;
    }

    public function pageData($parms=array())
    {
        $result = array();
        $criteria = new CDbCriteria();
        $criteria->with = array('teacher0');
        if(isset($parms['schoolid']) && $parms['schoolid']!=''){
            $criteria->compare('t.sid',$parms['schoolid']);
        }
        if(isset($parms['did']) && $parms['did']!=''){
            $criteria->compare('t.did',$parms['did']);
        }
        if(isset($parms['name']) && $parms['name']!=''){
          //  $RegExp = '/^1\d{10}$/';
           // if(preg_match($RegExp, $parms['name'])){
              //  $criteria->compare('teacher0.mobilephone',$parms['name']);
          //  }else{
                $criteria->compare('teacher0.name',$parms['name'],true);
         //   }
        }
        $criteria->compare('t.deleted',0);
        $criteria->compare('teacher0.deleted',0);
        $criteria->compare('teacher0.state',1);
        $criteria->order = 'teacher0.pingyin ASC';
        $count = self::model()->count ($criteria);
        $pager = new CPagination($count);
        if(isset($parms['size']) && $parms['size']){
            $pager->pageSize = $parms['size'];
        }else{
            $pager->pageSize = 15;
        }
        $pager->applyLimit($criteria);
        $datalist = self::model()->findAll($criteria);
        $result['model'] = $datalist;
        $result['pages'] = $pager;
        $result['count'] = $count;
        return $result;
    }

    public static function getSchoolTeacherMobilesArr($schoolid){
        $criteria=new CDbCriteria;
        $criteria->with = array('teacher0');
        $criteria->compare('t.state',1);
        $criteria->compare('t.sid',$schoolid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('teacher0.deleted',0);
        $data = self::model()->findAll($criteria);
        $arr = array();
        foreach($data as $d){
            $arr[$d->teacher] = $d->teacher0?$d->teacher0->mobilephone:'';
        }
        return $arr;
    }

    /*
     * 判断教师是否在某地区
     * panrj,zengp 2014-12-25
     */
    public static function getAreaByUser($userid,$aid){

        $area_pks = Area::getCityAreaArr($aid);
        $area_pks = array_keys($area_pks);
        $criteria=new CDbCriteria;
        $criteria->with = array('s');
        $criteria->compare('t.teacher',$userid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.state',1);
        $criteria->compare('s.aid',$area_pks);
        $criteria->compare('s.deleted',0);
        $count = SchoolTeacherRelation::model()->count($criteria);
        return $count;
    }

    /*
     * zengp 2014-12-27
     * 是否为自注册用户
     */
    public static function isSelfReg(){

        $userid = Yii::app()->user->id;

        $criteria=new CDbCriteria;
        $criteria->with = array('s');
        $criteria->compare('t.teacher',$userid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('s.createtype',0);
        $criteria->compare('s.deleted',0);
        
        return SchoolTeacherRelation::model()->count($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SchoolTeacherRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
