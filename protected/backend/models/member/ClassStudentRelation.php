<?php

/**
 * This is the model class for table "{{class_student_relation}}".
 *
 * The followings are the available columns in table '{{class_student_relation}}':
 * @property integer $id
 * @property integer $cid
 * @property string $student
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property string $creater
 *
 * The followings are the available model relations:
 * @property Class $c
 * @property User $student0
 */
class ClassStudentRelation extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{class_student_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cid, student', 'required'),
			array('cid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('student, creater', 'length', 'max'=>20),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cid, student, state, creationtime, updatetime, deleted, creater', 'safe', 'on'=>'search'),
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
			'c' => array(self::BELONGS_TO, 'MClass', 'cid'),
			'student0' => array(self::BELONGS_TO, 'Member', 'student'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '关系ID',
			'cid' => '班级',
			'student' => '学生用户',
			'state' => '状态：0待审核；1审核通过；2拒绝；3放弃',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'creater' => '创建者',
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
		$criteria->compare('cid',$this->cid);
		$criteria->compare('student',$this->student,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('creater',$this->creater,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    /*
     * 删除学生的所有班级关系
     */
    public static  function deleteStudentClassRelation($student){
        $criteria=new CDbCriteria;
        $criteria->compare('student',$student);
        $criteria->compare('deleted',0);
        $data=self::model()->findAll($criteria);
        foreach($data as $val){
            $val->deleted=1;
            $val->save();
        }
        //self::model()->updateAll(array('deleted'=>1),$criteria);
    }
    /*
     * 获取学生的班级数据
     */
    public static  function getStudentClass($student)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('t.student',$student);
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.state',1);
        $data= self::model()->findAll($criteria);
        return $data;
    }

    /*
   * 获取班级的学生数据
   */
    public static  function getClassStudents($cid,$isNotSendStudent=0)
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('student0');
        $criteria->compare('t.cid',$cid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.state',1);
        $criteria->compare('student0.deleted',0);
        $criteria->order="student0.pingyin";

        if($isNotSendStudent==1){ //只取未发送密码的学生
            $criteria->compare('student0.issendpwd',0); //issendpwd发送过密码=1,未发送过为0
        }
        $data= self::model()->findAll($criteria);
        return $data;
    }
    /*
  * 获取班级的所有学生姓名
  */
    public static  function getClassStudentsReturnArr($cid){
        $data=self::getClassStudents($cid);
        $arr=array();
        foreach($data as $val){
            $arr[$val->student0->name]=$val->student;
        }
        return $arr;
    }
    /*
     * 按学号排序，用sql
     */
    public static  function getClassStudentsOrderbystudent($cid,$orderby='studentid')
    {

        $sql="select * from (select tc.student,t.userid,t.name,ifnull(te.studentid,'') as studentid,t.pingyin from tb_user t inner join tb_class_student_relation tc on t.userid=tc.student left join tb_student_ext te on t.userid=te.userid";
        $sql.=" where t.deleted=0 and tc.deleted=0  and tc.cid=$cid ) f order by $orderby,pingyin";
        return UCQuery::queryAll($sql);
    }
    /*
    * 获取学生的班级数据by 多个班级
    */
    public static  function getClassStudentsByCids($cids)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.cid in('.$cids.")");
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.state',1);
        $data= self::model()->findAll($criteria);
        return $data;
    }

    /*
     * 获取学生的班级,学校名
     */
    public static  function getStudentClassSchoolName($student)
    {
        $arr=array();
        $data=self::getStudentClass($student);
        foreach($data as $val){
            $a=array();
            if($val&&$val->c->deleted==1){
                continue;
            }else{
                $a['classname']=$val->c?$val->c->name:'';
                if($val->c->deleted==1) $a['classname']='';//$a['classname'].'<font color="red">(班级已删除)</font>';

                $a['cid']=$val->cid;
                if($val->c->sid){
                    $schoolInfo=School::model()->findByPk($val->c->sid);
                    $a['schoolname']=$schoolInfo?$schoolInfo->name:'';
                    if($schoolInfo->deleted==1) {
                        $a['schoolname']= '';
                        $a['classname']= '';
                    }
                    $a['sid']=$val->c->sid;
                }else{
                    $a['schoolname']=$val->c?$val->c->name:'';
                    $a['sid']=0;
                }
            }
            $arr[]=$a;

        }
        return $arr;
    }

    /**
     * 扩展afterSave方法,用来同步商品库存
     * panrj 2014-09-19
     */
    public function afterSave()
    {
        $cid = $this->cid;
        $class =Yii::app()->cache->get("mem_object_class_".$cid);
        if(!$class){
            $class=MClass::model()->findByPk($cid);
            Yii::app()->cache->set("mem_object_class_".$cid,$class,300);
        }
        $criteria=new CDbCriteria;
        $criteria->with=array("student0");
        $criteria->compare('t.cid',$cid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('student0.deleted',0);
        $criteria->compare('t.state',1);
        $studentNum= self::model()->count($criteria);
        if($studentNum!=$class->total){
            $class->updateByPk($cid,array("total"=>$studentNum));
        }
        //2015-01-22取消，入班邀请信息
        if($this->getIsNewRecord()){
//            $data['receiver'] = '{"5":"' . $this->student . '"}';
//            $data['noticeType'] = 6;
//            $data['isSendsms'] = false;
//            $desc = "欢迎加入" . $class->name;
//            $data['data'] = '{"content":"' . $desc . '"}';
//            $data['receiveTitle'] = 'xxx';
//            $platform=Yii::app()->params['platform'];
//            if($platform=='fronted'){ //目前只针对前台处理,后台发送者问题未解决
//                if(Yii::app()->user->isGuest){
//                    $userid=100+(int)USER_BRANCH;
//                }else{
//                    $userid=Yii::app()->user->id;
//                }
//                $userinfo=Yii::app()->cache->get("mem_object_user_".$userid);
//                if(!$userinfo){
//                    $userinfo =Member::model()->findByPk($userid);
//                    Yii::app()->cache->set("mem_object_user_".$userid,$userinfo,300);
//                }
//                $data['sendertitle'] = ($userinfo ? $userinfo->name : '') . '老师';
//                $data['sid'] = $class->sid;
//                $memberinfo=Member::model()->findByPk($this->student);
//                $data['receivename'] = $memberinfo?$memberinfo->name:'';
//                NoticeQuery::publishNotice($data, $userinfo->userid, false);
            }else{
//                $userid=100+(int)USER_BRANCH;
//                $userinfo=Yii::app()->cache->get("mem_object_user_".$userid);
//                if(!$userinfo){
//                    $userinfo=Member::model()->findByPk($userid); //后台默认发送者是101
//                    Yii::app()->cache->set("mem_object_user_".$userid,$userinfo,300);
//                }
//                if($userinfo&&$userinfo->deleted==0){ //找得到这个用户才发
//                    $data['sendertitle'] = ($userinfo ? $userinfo->name : '') . '老师';
//                    $data['sid'] = $class->sid;
//                   $memberinfo=UCQuery::queryRow("select name from tb_user where userid=".$this->student);
//                   $data['receivename'] = $memberinfo?$memberinfo->name:'';
//                    NoticeQuery::publishNotice($data, $userinfo->userid, false);
//                }
          //  }
        }


    }


    //查找学生及分页
    public static  function pageData($parms=array(),$cids)
    {
        if(!$cids){
            return array();
        }
        $result = array();
        $criteria = new CDbCriteria();
        $criteria->with = array('student0','c');
        if(isset($parms['schoolid']) && $parms['schoolid']!=''){
            $criteria->compare('c.sid',$parms['schoolid']);
        }
        $gradeId=isset($parms['grade'])?$parms['grade']:'0';
        if($gradeId=='interest'){
            $criteria->compare('c.stid',0);
            $criteria->compare('c.year',0);
            $criteria->compare('c.type',1);
        }else{
            if($gradeId>0){
                $gradeInfo=Grade::model()->findByPk($gradeId);
                $stid=$gradeInfo->stid;
                $year=MainHelper::getClassYearByGradeAge($gradeInfo->age);
                $criteria->compare('c.stid',$stid);
                $criteria->compare('c.year',$year);
                $criteria->compare('c.type',0);
            }
        }
        if(isset($parms['class']) && $parms['class']!=''){
            $criteria->compare('t.cid',$parms['class']);
        }
        if(isset($parms['name']) && $parms['name']!=''){
         //   $RegExp = '/^1\d{10}$/';
           // if(preg_match($RegExp, $parms['name'])){
              //  $criteria->compare('student0.mobilephone',$parms['name']);
         //   }else{
                $criteria->compare('student0.name',$parms['name'],true);
          //  }
        }
        $criteria->compare('t.deleted',0);
        $criteria->compare('student0.deleted',0);
        $criteria->compare('student0.state',1);
        if(count($cids)){
            $criteria->addInCondition("t.cid",$cids);
        }

        //$criteria->compare('student0.state',1);
        $criteria->order = 'student0.pingyin ASC';
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

    /*
     * 删除学校的所有学生
     */
    public static function deleteBySchoolPk($sid)
    {
//        $criteria=new CDbCriteria;
//        $criteria->with = array('c');
//        $criteria->compare('c.sid',$sid);
//        //D(self::model()->findAll($criteria));
//        self::model()->updateAll(array('t.deleted'=>1),$criteria);
          $sql="update tb_class_student_relation tt inner join tb_class tc on tt.cid=tc.cid set tt.deleted=1 where   tc.sid=$sid";
          UCQuery::execute($sql);
    }


    //根据班级id、学生姓名查找该班级下是否存在该学生
    public static function getStudentByName($name,$cid){
        $sql="select tt.*,t.name from tb_class_student_relation tt  inner join tb_user t on tt.student=t.userid and tt.cid=$cid and tt.state=1 and tt.deleted=0 and t.name='$name'";
        return  UCQuery::queryRow($sql);
    }

    /*
      * 原来用pageData,用视图保存所有数据查找，性能问题严重
     * 改sql;
      */
    public function pageDataBySql($params=array()){
        $data=array();
        $sql="select distinct t.* from tb_user t ";
        $sqltotal="select count(DISTINCT(t.userid)) as total from tb_user t ";
        $where1="  and t.identity=2 and deleted=0";
        if(isset($params['name']) && $params['name']!=''){
            $where1.=" and t.name like '%".$params['name']."%'";
        }
        $cidsql="";
        if(isset($params['cid']) && !empty($params['cid'])){
            $cidsql="and tc.cid=".$params['cid'];
        }

        if(isset($params['sid']) && !empty($params['sid'])){
            $sql.=" inner join (select t.student from tb_class_student_relation  t inner join tb_class tc on t.cid=tc.cid where t.deleted=0 and t.state=1 and tc.deleted=0 and  tc.sid=".$params['sid']." $cidsql) tt on t.userid=tt.student";
            $sqltotal.=" inner join (select t.student from tb_class_student_relation  t inner join tb_class tc on t.cid=tc.cid where t.deleted=0 and t.state=1 and tc.deleted=0 and  tc.sid=".$params['sid']." $cidsql) tt on t.userid=tt.student";
        }else{
            //用户权限过滤
            $uid = Yii::app()->user->id;
            $sids = UserAccess::getUserAccessTargetPks($uid,$type=1);
            if(!empty($sids)){
                $sids = implode(',', $sids);
                $sql.=" inner join (select t.student from tb_class_student_relation  t inner join tb_class tc on t.cid=tc.cid where t.deleted=0 and t.state=1 and tc.deleted=0 and  tc.sid in (".$sids.") $cidsql) tt on t.userid=tt.student";
                $sqltotal.=" inner join (select t.student from tb_class_student_relation  t inner join tb_class tc on t.cid=tc.cid where t.deleted=0 and t.state=1 and tc.deleted=0 and  tc.sid in (".$sids.") $cidsql) tt on t.userid=tt.student";
            }
        }

        $sql.=" where 1=1 and t.state=1 ";
        $sqltotal.=" where 1=1 and t.state=1 ";
        if(isset($params['mobilephone']) && !empty($params['mobilephone'])){
            $sql=$sql."   and t.userid in(select p.child  from tb_user t inner join tb_guardian p on t.userid=p.guardian where t.deleted=0 and t.state=1 and p.deleted=0 and t.mobilephone like'".$params['mobilephone']."%') ";
            $sqltotal=$sqltotal."   and t.userid in(select p.child  from tb_user t inner join tb_guardian p on t.userid=p.guardian where t.deleted=0 and t.state=1 and p.deleted=0 and t.mobilephone like'".$params['mobilephone']."%') ";
        }

        $sql.=$where1;
        $sql.=" order by t.pingyin";
        $sqltotal.=$where1;
        $data['total']=UCQuery::queryScalar($sqltotal);
        $page=$params['page']?(int)$params['page']:1;
        $page=$page<1?1:$page;
        $start=($page-1)*15;
        $sql.=" limit $start,15";
        $data['list']=UCQuery::queryAll($sql);
        return $data;

    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClassStudentRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /*
    * 查询班级学生关系
    */
    public static  function getRelationByCidStudent($cid,$student)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('cid',$cid);
        $criteria->compare('student',$student);
        $criteria->compare('deleted',0);
        $criteria->compare('state',1);
        $data= self::model()->find($criteria);
        return $data;
    }

    /*
     * 根据学校id和姓名，查找学生及家长
     */
    public static function getStudentBySidAndName($sid,$name,$returnArr=false){
        $criteria = new CDbCriteria();
        $criteria->with=array('c','student0');
        $criteria->compare('c.sid',$sid);
        $criteria->compare('student0.name',$name);
        $criteria->compare('student0.deleted',0);
        $criteria->compare('student0.state',1);
        $criteria->compare('t.state',1);
        $criteria->compare('t.deleted',0);
        $criteria->compare('c.deleted',0);
        $data= self::model()->findAll($criteria);

        if($returnArr){
           $arr=array();
           foreach($data as $val){
               if($val->c&&$val->c->sid){
                 $schoolinfo=School::model()->findByPk($val->c->sid);
               }
               $studentInfo=StudentExt::model()->findByPk($val->student);
               $arr[]=array('studentid'=>$studentInfo?$studentInfo->studentid:'','schoolname'=>$schoolinfo?$schoolinfo->name:'','sid'=>$val->c->sid,'userid'=>$val->student,'account'=>$val->student0->account,'cid'=>$val->cid,'classname'=>$val->c->name,'name'=>$val->student0->name);
           }
            return $arr;
        }
        return $data;
    }

    /*
 * 判断学生与班级是否存在关系　
 */
    public static  function countClassStudentRelation($cid,$student)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('cid',$cid);
        $criteria->compare('student',$student);
        $criteria->compare('deleted',0);
        return self::model()->count($criteria);
    }

    /*
     * sql语句插入，加快速度
     */
    public static function insertClassStudentRelation($classRelation,$class,$name=''){
        $cid=(int)$classRelation->cid;
        $student=(int)$classRelation->student;
        if($cid&&$student){
            $sql="insert into tb_class_student_relation(cid,student,deleted,state)values($cid,$student,0,1)";
            UCQuery::execute($sql);
        }
        return true;
        /*
        $data=array();
        $data['receiver'] = '{"5":"' . $student . '"}';
        $data['noticeType'] = 6;
        $data['isSendsms'] = false;
        $desc = "欢迎加入" . $class->name;
        $data['data'] = '{"content":"' . $desc . '"}';
        $data['receiveTitle'] = 'xxx';
        $userid=100+(int)USER_BRANCH;
        $userinfo=Yii::app()->cache->get("mem_object_user_".$userid);
        if(!$userinfo){
            $userinfo=Member::model()->findByPk($userid); //后台默认发送者是101
            if($userinfo){
                Yii::app()->cache->set("mem_object_user_".$userid,$userinfo,300);
            }
        }
        */
       // if($userinfo&&$userinfo->deleted==0){ //找得到这个用户才发
            /*
            $data['sendertitle'] = ($userinfo ? $userinfo->name : '') . '老师';
            $data['sid'] = $class->sid;
            if(empty($name)){
              $memberinfo=UCQuery::queryRow("select name from tb_user where userid=".$student);
              $data['receivename'] = $memberinfo?$memberinfo->name:'';
            }else{
                $data['receivename'] = $name;
            }
            NoticeQuery::publishNotice($data, $userinfo->userid, false);
            */
            //2015-1-22，入班邀请去掉
       // }

    }
    /*
     * 获取班级学生人数
     */
    public static function countClassStudentNum($cid){
        $criteria=new CDbCriteria;
        $criteria->with=array("student0");
        $criteria->compare('t.cid',$cid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('student0.deleted',0);
        $criteria->compare('t.state',1);
        return self::model()->count($criteria);
    }
}
