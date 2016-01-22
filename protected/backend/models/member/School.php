<?php

/**
 * This is the model class for table "{{school}}".
 *
 * The followings are the available columns in table '{{school}}':
 * @property integer $sid
 * @property string $name
 * @property integer $aid
 * @property string $stid
 * @property double $longitude
 * @property double $latitude
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property Area $a
 * @property SchoolTeacherRelation[] $schoolTeacherRelations
 */
class School extends MemberActiveRecord
{
    public $stype;
    public $city;
    public $area;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{school}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, aid, stid', 'required'),
			array('aid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('longitude, latitude', 'numerical'),
			array('name', 'length', 'max'=>20),
			array('stid', 'length', 'max'=>50),
			array('updatetime,creationtime,pingyin,enableddirectsend', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sid, name, aid, stid, longitude, latitude, state, creationtime, updatetime, deleted,createtype', 'safe', 'on'=>'search'),
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
			'classes' => array(self::HAS_MANY, 'Class', 'sid'),
			'a' => array(self::BELONGS_TO, 'Area', 'aid'),
			'schoolTeacherRelations' => array(self::HAS_MANY, 'SchoolTeacherRelation', 'sid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sid' => '学校ID',
			'name' => '学校名称',
			'aid' => '地区',
			'stid' => '学校类型：逗号分隔的字符串；如：1,2,3',
			'longitude' => '经度',
			'latitude' => '纬度',
			'state' => '状态：保留字段',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除',
			'pingyin' => '学校拼音',
            'enableddirectsend'=>'是否开启定向发送',
            'createtype' => '创建类型'
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

		$criteria->compare('sid',$this->sid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('aid',$this->aid);
		$criteria->compare('stid',$this->stid,true);
		$criteria->compare('longitude',$this->longitude);
		$criteria->compare('latitude',$this->latitude);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /*
     *
     */
    public function afterSave()
    {
        $mem=UCQuery::getMemcache();
        if($mem){
            $mem->delete(Constant::CACHE_SCHOOL_LIST);
            $mem->delete(Constant::CACHE_SCHOOL_LIST."1");
            $mem->delete(Constant::CACHE_SCHOOL_LIST."3");
        }
        return parent::afterSave();
    }

    /**
     * 学校列表分页数据
     * panrj 2014-06-12
     * @param array $parms 查询条件及分页参数
     * @return array $result
     */
    public function pageData($parms=array())
    {
        $result = array();
        $criteria = new CDbCriteria();
        if(isset($parms['name']) && $parms['name']!=''){
            $criteria->compare('name',$parms['name'],true);
        }
        if(isset($parms['type']) && $parms['type']!=''){
            $criteria->addCondition('FIND_IN_SET('.$parms['type'].',stid)');
        }
        //用户权限过滤
        $uid = Yii::app()->user->id;
        $sids = UserAccess::getUserAccessTargetPks($uid,$type=1);
		if(!empty($sids)){
			$criteria->compare('sid',$sids);
		}

        if(isset($parms['area']) && $parms['area']!=''){
            $criteria->compare('aid',$parms['area']);
        }
        if(isset($parms['city']) && $parms['city']!=''){
                $criteria->addCondition(" aid like'".substr($parms['city'],0,4)."%'");
        }
        if(isset($parms['province']) && $parms['province']!=''){
            $criteria->addCondition(" aid like'".substr($parms['province'],0,2)."%'");
        }
        $criteria->compare('deleted',0);
        $criteria->order = 'pingyin ';
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

        return $result;
    }

	/**
	 * 返回学校键值数组
	 * panrj 2014-07-25
	 * @return array $arr 
	 */
	public static function getDataArr($fc=false)
	{
		$criteria = new CDbCriteria();
        $data=UCQuery::queryAll("select sid,name,pingyin from tb_school where deleted=0 order by pingyin");
		$arr = array();
		foreach($data as $d){
			$arr[$d['sid']] = $fc?strtoupper(substr($d['pingyin'],0,1)).':'.$d['name']:$d['name'];
		}
		return $arr;
	}

	public static function getViewSchoolGradeData($parms=array())
	{
		$criteria=new CDbCriteria;
		if(isset($parms['aid']) && $parms['aid']){
			$criteria->compare('aid',$parms['aid']);
		}
		if(isset($parms['aids']) && $parms['aids']){
			$criteria->compare('aid', $parms['aids']);
		}

		if(isset($parms['gids']) && $parms['gids']){
			$criteria->compare('gid', $parms['gids']);
		}
		$data = ViewSchoolGrade::model()->findAll($criteria);
		return $data;
	}

	public static function getSchoolData($parms=array())
	{
		$schools = array();
		$arr = array();
		$datas = self::getViewSchoolGradeData($parms);
		// conlog($datas);
		foreach($datas as $d){
			if(!in_array($d->sid,$schools))
				array_push($schools,$d->sid);
		}
		if(count($schools)){
			$criteria=new CDbCriteria;
			$criteria->compare('sid',$schools);
			$criteria->compare('deleted',0);
			$arr = self::model()->findAll($criteria);
		}
		return $arr;
	}

	public static function getSchoolArr($parms=array())
	{
		//$data = self::getSchoolData($parms);
        $data=UCQuery::queryAll("select sid,name from tb_school where deleted=0 order by pingyin");
		$arr = array();
		foreach($data as $d){
			//$arr[$d->sid] = $d->name;
			$arr[$d['sid']] = $d['name'];
		}
		return $arr;
	}

	public function getSchoolGradeData($gid=0,$ty='')
	{
		$sql = "SELECT `sid`,`sname`,`aid`,`stid`,`gid`,`gname`,`age` FROM `view_school_grade` WHERE sid=".$this->sid;
		if($gid){
			if($ty=='schooltype'){
				$sql.= " AND stid=".$gid;
			}else{
				$sql.= " AND gid=".$gid;
			}
		}
		$result = yii::app()->db_member->createCommand($sql);
        $query = $result->queryAll();
        return $query;
	}

	public function getSchoolGradeArr($gid=0)
	{
        $query = $this->getSchoolGradeData($gid,$ty='schooltype');
        $arr = array();
        foreach($query as $q){
        	$arr[$q['gid']] = $q['gname'];
        }
        return $arr;
	}

	public static function getSchoolTypeData($parms=array())
	{	
		$sql = "SELECT `sid`,`sname`,`aid`,`stid`,`gid`,`gname`,`age` FROM `view_school_grade` WHERE 1=1";
		if(isset($parms['stid']) && $parms['stid']){
			$sql.= " AND stid=".$parms['stid'];
		}
		if(isset($parms['aid']) && $parms['aid']){
			$sql.= " AND aid=".$parms['aid'];
		}
		$sql.= " ORDER BY sname";
		$result = yii::app()->db_member->createCommand($sql);
        $query = $result->queryAll();
        return $query;
	}

	public function getSchoolAdvRelationData($sid,$gid,$alid,$startdate,$enddate)
	{
		$sql = "SELECT `aid`,`cid`,`alid`,`sid`,`gid`,`startdate`,`enddate` FROM `view_contract_adv_relation_range` WHERE 1=1";
		$sql.= " AND sid=".$sid;
		$sql.= " AND gid=".$gid;
		$sql.= " AND alid=".$alid;
		$sql.= " AND startdate<='".$enddate."'";
		$sql.= " AND enddate>='".$startdate."'";
		// if($aid){
		// 	$sql.= " AND aid=".$aid;
		// }
		$sql.= " ORDER BY startdate";
		$result = yii::app()->db->createCommand($sql);
        $query = $result->queryAll();
        return $query;
	}

	public function getAvailableDate($sid,$gid,$alid,$s,$e)
	{
		$relations = $this->getSchoolAdvRelationData($sid,$gid,$alid,$s,$e);
		$num = count($relations);
		$zone = array();
		if(!$num){
			array_push($zone,array('sdate'=>$s,'edate'=>$e));
			$data = array('type'=>'empty','dates'=>$zone);
			return $data;
		}
		$date_min = $relations[0]['startdate'];
		$date_max = $relations[$num-1]['enddate'];

		if(strtotime($s)<strtotime($date_min)){
			array_push($zone,array('sdate'=>$s,'edate'=>self::DateAdd('d',-1,$date_min)));
		}
		for($n=0;$n<$num-1;$n++){
			$r = $relations[$n];
			$rn = $relations[$n+1];
			$sdata_n = self::DateAdd('d',1,$r['enddate']);
			$edata_n = self::DateAdd('d',-1,$rn['startdate']);
			if(strtotime($edata_n)>strtotime($sdata_n)){
				array_push($zone,
					array('sdate'=>self::DateAdd('d',1,$r['enddate']),
						'edate'=>self::DateAdd('d',-1,$rn['startdate'])
					)
				);
			}
		}
		if(strtotime($e)>strtotime($date_max)){
			array_push($zone,array('sdate'=>self::DateAdd('d',1,$date_max),'edate'=>$e));
		}
		if(count($zone)){
			$data = array('type'=>'part','dates'=>$zone);
		}else{
			$data = array('type'=>'full','dates'=>$zone);
		}
		return $data;
	}

	public function countSchoolGradeConDays($arr)
	{
		$day = 0;
		foreach($arr as $a){
			$s = strtotime($a['sdate']);
			$e = strtotime($a['edate']);
			$day += ceil(($e-$s)/86400);
			$day += 1;
		}
		return $day;
	}

	public function getSchoolGradeInfo($gid,$alid,$s,$e)
	{
		$info = array();
		$is_match = $this->getSchoolGradeData($gid);
		if(count($is_match)){
			$dates = $this->getAvailableDate($this->sid,$gid,$alid,$s,$e);
			$info['type'] = $dates['type'];
			$info['days'] = $this->countSchoolGradeConDays($dates['dates']);
			$info['person'] = UserSchoolGradeCount::getSchoolGradePerson($this->sid,$gid);
			//$info['person'] = 0;
		}else{
			$info['type'] = 'disable';
			$info['days'] = 0;
			$info['person'] = 0;
		}
		return $info;
	}

	public static function getSchoolName($sid)
	{
		$school = self::model()->findByPk($sid);
		return $school->name;
	}

	public static function DateAdd($part, $number, $date)
	{
		$date_array = getdate(strtotime($date));
		$hor = $date_array["hours"];
		$min = $date_array["minutes"];
		$sec = $date_array["seconds"];
		$mon = $date_array["mon"];
		$day = $date_array["mday"];
		$yar = $date_array["year"];
		switch($part)
		{
		case "y": $yar += $number; break;
		case "q": $mon += ($number * 3); break;
		case "m": $mon += $number; break;
		case "w": $day += ($number * 7); break;
		case "d": $day += $number; break;
		case "h": $hor += $number; break;
		case "n": $min += $number; break;
		case "s": $sec += $number; break;
		}
		return date("Y-m-d H:i:s", mktime($hor, $min, $sec, $mon, $day, $yar));
	}

    public static function getCityNameByAid($aid){
        $areainfo=Area::model()->findByPk($aid);
        if($areainfo->parentid){
            $parentInfo=$areainfo->parent;
            return  $parentInfo->name;
        }
         return '';
    }

    public static  function getSchoolGradesArr($sid,$deleted=false)
    {
        $gradeArr=array();
        if($deleted){
            $school = School::model()->findByPk($sid);
        }else{
            $school = School::model()->loadByPk($sid);
        }
        if($school && $school->stid){
            $stid=explode(",",$school->stid);
            foreach($stid as $v){
                $gradetemp=Grade::getGradeData(array('stid'=>$v));
                if(is_array($gradetemp)){
                   foreach($gradetemp as $val){
                       $gradeArr[$val->gid]=$val->name;
                   }
                }
            }
        }
        return $gradeArr;
    }
    public static  function getSchoolGradesData($uid,$sid,$deleted=false)
    {

        $teachers = SchoolTeacherRelation::getSchoolTeachersRelation(array('teacher' => $uid, 'sid' => $sid));
        $result = array();
        if ($teachers && isset($teachers->duty)) {
            $val=Duty::model()->findByPk($teachers->duty);
            if(!$val||$val->deleted==1){
                return null;
            }
            if ($val->isseeallclass == 0) {
                //查询对应的班级
                if($sid>0){
                	$sql_text = "select distinct t.* from tb_class t,tb_class_teacher_relation r where  r.teacher =$uid  and t.cid=r.cid and  t.sid = $sid and t.deleted=0 and r.deleted=0  order by seqno,pingyin";
                }else{
                	$sql_text = "select distinct t.* from tb_class t,tb_class_teacher_relation r where  r.teacher =$uid  and t.cid=r.cid and  t.deleted=0 and r.deleted=0  order by seqno,pingyin";
                }
                $classes = UCQuery::queryAll($sql_text);

                //获取该老师，该学校下的班级
                $tmp = array();
                foreach ($classes as $v) {
                    $tmp[] = $v;
                }
                //获取年级信息，年级下面的班级数组
                $gcinfo = MClass::getGradeClassPhoneBook($tmp);
                foreach($gcinfo as $key=>$val){
                        $result[$val['gid']] =$val['gname'];
                }
            } else if ($val->isseeallclass == 1) {
                //查询对应年级下所有班级
                $year = $teachers->year;
                $stid = $teachers->stid;
                $sql_text = " select * from tb_class where sid=$sid and deleted=0 and year=$year and stid=$stid order by seqno,`pingyin`";
                $classes = UCQuery::queryAll($sql_text);
                $sql_text = "select t.* from tb_class t,tb_class_teacher_relation r where  r.teacher =$uid  and t.cid=r.cid and  t.sid = $sid and t.deleted=0 and r.deleted=0  order by seqno,pingyin";
                $classes_result = UCQuery::queryAll($sql_text);

                foreach($classes_result as $key=>$val){
                    if(!self::isInClassObject($val['cid'],$classes)){
                        $classes[]=$val;
                    }
                }
                //获取该老师，该学校下的班级
                $tmp = array();
                foreach ($classes as $v) {
                    $tmp[] = $v;
                }
                //获取年级信息，年级下面的班级数组
                $gcinfo = MClass::getGradeClassPhoneBook($tmp);
                foreach($gcinfo as $key=>$val){
                        $result[$val['gid']] =$val['gname'];
                }

            } else if ($val->isseeallclass == 2) {
                //查询整个学校的班级
                $sql_text = "select distinct * from tb_class where sid = $sid and deleted=0 order by seqno,`pingyin`";
                $classes = UCQuery::queryAll($sql_text);
                $tmp = array();
                foreach ($classes as $v) {
                    $tmp[] = $v;
                }
                //获取年级信息，年级下面的班级数组
                $gcinfo = MClass::getGradeClassPhoneBook($tmp);
                foreach($gcinfo as $key=>$val){
                        $result[$val['gid']] =$val['gname'];
                }
            }
        }
        $cache = Yii::app()->cache;
        $cache->set("grade_class", $gcinfo);
        return $result;
    }
    /*
     * 获取学校的老师列表
     * $sortFirst  是否按首字母排序
     */
    public static function getSchoolTeacherArr($sid,$sortFirst=false)
    {
        $teacherArr = array();
        $teachers=SchoolTeacherRelation::getSchoolTeachers(array('sid'=>$sid));
        if(is_array($teachers)){
            foreach($teachers as $d){
                $teacherArr[$d->teacher]=$d->teacher0?$d->teacher0->name:'';
            }
        }
        return $teacherArr;
    }
    /*
     * 上面的方法是返回键值 数组，在ajax调用时，json会成对像,所以要改成数组
     */
    public static function getSchoolTeacherReturnArr($sid,$sortFirst=false){
        $data=self::getSchoolTeacherArr($sid,$sortFirst);
        $arr=array();
        foreach($data as $k=>$val){
            $arr[]=array('userid'=>$k,'name'=>$val);
        }
        return $arr;
    }

    public static function deleteSchool($sid){
        try{
            self::deleteSchoolClass($sid);
            self::deleteSchoolDepartment($sid);
            self::deleteSchoolSubject($sid);
            ClassStudentRelation::deleteBySchoolPk($sid);
            ClassTeacherRelation::deleteBySchoolPk($sid);
            SchoolTeacherRelation::deleteBySchoolPk($sid);
            $school = self::model()->findByPk($sid);
            if($school->sid==MainHelper::getCookie(Yii::app()->params['xxschoolid'])){
                MainHelper::setCookie(Yii::app()->params['xxschoolid'],'');
            }
            $school->deleteMark();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public static function deleteSchoolClass($sid)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('sid',$sid);
        MClass::model()->updateAll(array('deleted'=>1),$criteria);
    }
    /*
     * 删除班级
     */
    public static function deleteClass($sid){
        //删除class与学生关系表
        //删除class与老师关系表
       // $criteria=new CDbCriteria;
       // $criteria->compare('sid',$sid);
       // MClass::model()->updateAll(array('deleted'=>1),$criteria);
    }

    public static function deleteSchoolDepartment($sid)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('sid',$sid);
        Department::model()->updateAll(array('deleted'=>1),$criteria);
    }

    public static function deleteSchoolSubject($sid)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('schoolid',$sid);
        Subject::model()->updateAll(array('deleted'=>1),$criteria);
    }

    public static  function getSchoolSubjectArr($sid)
    {
        $arr = array();
        $criteria=new CDbCriteria;
        $criteria->compare('schoolid',$sid);
        $criteria->compare('deleted',0);
        $subjectArr = Subject::model()->findAll($criteria);
        foreach($subjectArr as $val){
            $arr[$val->sid]=$val->name;
        }
        return $arr;
    }

    public static function getSchoolDid($sid){
        return Department::getSchoolDepartment(array('sid'=>$sid));
    }

    public static function getSchoolClass($sid){
        return MClass::getSchoolClass($sid);
    }
    public static function getSchoolClassArr($sid){
        $list=self::getSchoolClass($sid);

        $arr=array();
        foreach($list as $val){
            $arr[$val->cid]=$val->name;
        }
        return $arr;
    }

	// /**
	//  * 返回商品键值数组
	//  * panrj 2014-06-13
	//  * @return array $arr 
	//  */
	// public static function getDataArr()
	// {
	// 	$criteria = new CDbCriteria();
	// 	$criteria->scopes='normal';
	// 	$criteria->order = 'name';
	// 	$data = self::model()->findAll($criteria);
	// 	$arr = array();
	// 	foreach($data as $d){
	// 		$arr[$d->sid] = $d->name;
	// 	}
	// 	return $arr;
	// }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return School the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function beforeSave()
    {

        $py=new py_class();
        $this->name=trim($this->name);
        $this->pingyin=substr($py->str2py($this->name),0,10);
        return parent::beforeSave();
    }

    /*
 *查年级主任权限时，合并年级主任的任教班级，去重班级处理
 */
    public static function isInClassObject($cid,$result){
        $isExists=false;
        foreach($result as $val){
            if($val['cid']==$cid){
                $isExists=true;
                break;
            }
        }
        return $isExists;
    }

    /*
     * 根据地区id获取该地区学校
     */
    public static function getSchoolArrByArea($param){
        $arr = array();
        $criteria=new CDbCriteria;
        if($param['area']){
         $criteria->compare('aid',$param['area']);
        }
        $criteria->compare('deleted',0);
        $criteria->order="pingyin";
        $data = School::model()->findAll($criteria);
        foreach($data as $val){
            $arr[]=array('sid'=>$val->sid,'name'=>$val->name);
        }
        return $arr;
    }

    //根据学校名称查询是否存在
    public static function getSchoolByName($schoolName){

    	$school = self::model()->findByAttributes(array('name'=>$schoolName,'deleted'=>0));
    	if($school){
    		$createtype = $school->createtype;
    		if($createtype == 1){ //如果学校名是已注册类型存在，则返回此学校id
    			return $school->sid;
    		}else{
    			return 1;
    		}
    	}else{    		
    		return 0;
    	}
    }
}
