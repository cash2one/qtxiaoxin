<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $userid
 * @property string $account
 * @property string $pwd
 * @property string $name
 * @property integer $sex
 * @property string $photo
 * @property integer $identity
 * @property integer $vtid
 * @property string $mobilephone
 * @property string $email
 * @property integer $version
 * @property string $lastlogintime
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Class[] $classes
 * @property ClassStudentRelation[] $classStudentRelations
 * @property ClassTeacherRelation[] $classTeacherRelations
 * @property Group[] $groups
 * @property GroupUserRelation[] $groupUserRelations
 * @property Guardian[] $guardians
 * @property Guardian[] $guardians1
 * @property SchoolTeacherRelation[] $schoolTeacherRelations
 * @property StudentExt $studentExt
 */
class Member extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account, pwd, name', 'required'),
			array('sex, identity, vtid, version, state, deleted', 'numerical', 'integerOnly'=>true),
			array('userid, name, mobilephone', 'length', 'max'=>20),
			array('account', 'length', 'max'=>12),
            array('lastloginip', 'length', 'max'=>15),
			array('pwd, email', 'length', 'max'=>50),
			array('photo', 'length', 'max'=>256),
			array('lastlogintime, updatetime,creationtime,issendpwd,pingyin,createtype', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('userid, account, pwd, name, sex, photo, identity, vtid, mobilephone, email, version, lastlogintime, state, creationtime, updatetime, deleted,createtype', 'safe', 'on'=>'search'),
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
			'classes' => array(self::HAS_MANY, 'Class', 'master'),
			'classStudentRelations' => array(self::HAS_MANY, 'ClassStudentRelation', 'student'),
			'classTeacherRelations' => array(self::HAS_MANY, 'ClassTeacherRelation', 'teacher'),
			'groups' => array(self::HAS_MANY, 'Group', 'creater'),
			'groupUserRelations' => array(self::HAS_MANY, 'GroupUserRelation', 'member'),
			'guardians' => array(self::HAS_MANY, 'Guardian', 'child'),
			'guardians1' => array(self::HAS_MANY, 'Guardian', 'guardian'),
			'schoolTeacherRelations' => array(self::HAS_MANY, 'SchoolTeacherRelation', 'teacher'),
			'studentExt' => array(self::HAS_ONE, 'StudentExt', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userid' => '用户ID',
			'account' => '登录账号',
			'pwd' => '密码',
			'name' => '姓名',
			'sex' => '性别：0无；1男；2女',
			'photo' => '头像',
			'identity' => '用户身份：1老师；2学生；3家长；4教育局',
			'vtid' => 'vip类型',
			'mobilephone' => '注册手机',
			'email' => '注册邮箱',
			'version' => '版本：0通用；1校信；2校安；3成都数字学校',
			'lastlogintime' => '最后登录时间',
			'state' => '状态：0待激活；1已激活',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除：0未删除；1已删除',
			'issendpwd' => '是否发送过初始密码,1--发送过,0,未发送',
			'pingyin' => '姓名拼音',
            'lastloginip' => '最后登录IP',
            'createtype' => '创建类型',
		);
	}



	public static function getName($userid)
	{
		$member = self::model()->findByPk($userid);
		if($member){
			return $member->name;
		}else{
			return '';
		}
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

		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('pwd',$this->pwd,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('identity',$this->identity);
		$criteria->compare('vtid',$this->vtid);
		$criteria->compare('mobilephone',$this->mobilephone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('version',$this->version);
		$criteria->compare('lastlogintime',$this->lastlogintime,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function checkteachermobilephone($mobilephone,$identity=1){
    	return self::getUniqueMember($mobilephone,$identity);
        // $criteria=new CDbCriteria;
        // $criteria->compare('mobilephone',$mobilephone);
        // $criteria->compare('identity',$identity);
        // $criteria->compare('deleted',0);
        // $data = self::model()->findAll($criteria);
        // return $data;
    }

    /*
     * 删除老师
     */
    public static function deleteMember($uid){
        try{
            SchoolTeacherRelation::model()->deleteTeachersRelation($uid);
            ClassTeacherRelation::deleteTeachersClassRelation($uid);
            $member = self::model()->loadByPk($uid);

            $mclass=MClass::model()->updateAll(array("master" => null), "master=:master", array(":master" => $uid));
            //判断是否还存在家长身份
            $guardian =  Guardian::getChilds($member->userid);
            if($guardian){
                $member->identity = Constant::FAMILY_IDENTITY;
                $member->save();
            }else{
                $member->deleteMark();
            }
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    /*
     * 删除学生
     */
    public static function deleteStudent($uid){
        try{
            ClassStudentRelation::deleteStudentClassRelation($uid);//删除班级对应关系
            Guardian::model()->deleteStudentGrardianRelation($uid);
            $member = self::model()->loadByPk($uid);
            $member->deleteMark();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    /*
     * 手机号码获取老师
     */
    public static function getMemberByMobile($mobile,$identity=3){
        $criteria=new CDbCriteria;
        $criteria->compare('mobilephone',$mobile);
        $criteria->compare('identity',$identity);
        $criteria->compare('deleted',0);
        $data = self::model()->find($criteria);
        return $data;
    }

    public static function getUseridByMobile($mobile)
    {
    	$criteria=new CDbCriteria;
        $criteria->compare('mobilephone',$mobile);
        $criteria->compare('deleted',0);
        $data = self::model()->findAll($criteria);
        $ids = array();
        if(count($data)){
        	foreach($data as $d){
        		$ids[] = $d['userid'];
        	}
        }
        return $ids;
    }

    public static function getUserMobileByUserid($uid)
    {
    	$user = Member::model()->findByPk($uid);
    	if($user){
    		return $user->mobilephone;
    	}else{
    		return '';
    	}
    }

    /*
     * 获取用户扩展信息
     * panrj 2014-10-14
     */
    public function getUserExt()
    {
    	$ext = UserExt::model()->findByPk($this->userid);
    	if($ext){
    		return $ext;
    	}else{
    		$ext = new UserExt;
    		$ext->userid = $this->userid;
    		$ext->save();
    		return $ext;
    	}
    }

    /*
     * 查询唯一用户数据
     * panrj 2014-10-18
     * @parms string $mobile 用户手机号码
     * @parms int $identity 为false：返回手机匹配用户 
     * @parms string $login_type 登录账号类型
	 * @return array $member 
     */
    public static function getUniqueMember($account,$identity=false,$login_type='mobilephone')
    {
    	$member = Member::model()->findByAttributes(array($login_type=>$account,'deleted'=>0));
    	if($member){
    		if(!$identity){
    			return $member;
    		}
    		$role = $member->identity;
    		switch ($identity){
				case 1:
					$match = in_array($role,array(1,5));
				  	break;
				case 2:
				  	$match = in_array($role,array(2));
				  	break;
				case 4:
				 	$match = in_array($role,array(4,5));
				  	break;
				default:
					$match = false;
				  	break;
			}
			return $match?$member:null;
    	}else{
    		return null;
    	}
    }

     /*
     * 开放注册-查询手机唯一用户数据，如果是老师返回userid
     * panrj 2014-10-18
     * @parms string $phone 用户手机号码
     * @return int 
     */
    public static function getUniqueByOpenReg($phone)
    {
        $member = Member::model()->findByAttributes(array('mobilephone'=>$phone,'deleted'=>0));
        if($member){
            $identity = $member->identity;
            if($identity == 1 || $identity == 5){
                return 0;
            }else if($identity == 4){
                return $member->userid;
            }else{
                return 1;
            }
        }else{
            return 1;
        }
    }

    /*
     * 换算用户身份
     * panrj 2014-10-18
     * @parms string $new_itd 新用户身份
     * @parms string $old_idt 旧用户身份
	 * @return string $idt 换算后的用户身份 
     */
    public static function transIdentity($new_itd,$old_idt=false)
    {
    	if(!$old_idt){
    		return $new_itd;
    	}
    	if($new_itd==$old_idt || $old_idt==5){
    		return $old_idt;
    	}else{
    		return $new_itd+$old_idt;
    	}
    }

    /**
     * 扩展beforeSave方法,用来同步商品库存
     * panrj 2014-09-19
     */
    public function beforeSave()
    {
        if($this->isNewRecord){
            $this->version=(int)USER_BRANCH;
            $this->state=1;
        }
        $this->name=trim($this->name);
        if($this->identity!==4){
            $py=new py_class();
            $this->pingyin=substr($py->str2py($this->name),0,10);
        }

        return parent::beforeSave();
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Member the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function defaultPhoto($uid)
    {
        if(Yii::app()->user->isGuest){
            return Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';
        }

        $user = self::model()->findByPk($uid);
        if($user&&$user->deleted==0){
            /*  成都上线。暂时屏弊，因为上传头像还有问题
            $userExt=UserExt::model()->findByPk($uid);
            if($userExt&&$userExt->photo){
                return STORAGE_QINNIU_XIAOXIN_TX.$userExt->photo;
            }
            */
        if($user->sex==0)
            return Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';
        if($user->sex==1)
            return Yii::app()->request->baseUrl.'/image/xiaoxin/man_pic.jpg';
        if($user->sex==2)
            return Yii::app()->request->baseUrl.'/image/xiaoxin/woman_pic.jpg';
        }else{
            return Yii::app()->request->baseUrl.'/image/xiaoxin/default_pic.jpg';
        }
    }

    /*
     * 根据手机号,学生姓名，添加学生
     * $$issendinvite 是否发送邀请 1,发， 0－－不发
     * 返回学生id及要发送密码的数组
     */
    public static function addStudentByMobileAndName($mobile,$name,$cid,$role='家长',$classInfo=null){
        $transaction = Yii::app()->db_member->beginTransaction();
        $class =$classInfo;

        if(!$class){
            $class=MClass::model()->findByPk($cid);
            if(!$class)
            return null;
        }
        $result=array();
        try{
            $isExists = Member::getUniqueMember($mobile);
            //家长已存在，建立对应关系
            if ($isExists) {
               // $childs = Guardian::getChilds($isExists->userid);
                //判断学生名字是否一致,是否在这个监护人的孩子中
                $child = Guardian::checkGuardianChildByName($isExists->userid,$name);
                //换算身份
                $transIdentity = Member::transIdentity(4, $isExists->identity);
                $isExists->identity = $transIdentity;
                $isExists->state = 1;  
                if($class->s->createtype == 1){
                    $isExists->createtype = 1;
                }              
                $isExists->save();
                if($child){
                    $isInclass =ClassStudentRelation::countClassStudentRelation($class->cid, $child->child);
                    if($isInclass){
                    }else{
                        $classRelation = new ClassStudentRelation;
                        $classRelation->cid = $cid;
                        $classRelation->state = 1;
                        $classRelation->student = $child->child;
                        $classRelation->save();
                        $result['status']=1;
                    }
                }else{
                    //创建学生
                    $suid = UCQuery::makeMaxId(0, true);
                    $member = new Member;
                    $member->userid = $suid;
                    $member->name =$name;
                    $member->identity = 2; //学生标志;
                    $member->account = "s" . $suid; //学生前加s;
                    $member->pwd = MainHelper::encryPassword("123456");
                    $member->state = 1;
                    $member->issendpwd = 0;
                    if($class->s->createtype == 1){
                        $member->createtype = 1;
                    }
                    $member->save();

                    $guardian = new Guardian;
                    $guardian->child = $suid;
                    $guardian->guardian = $isExists->userid;
                    $guardian->role = $role?$role : '家长';
                    $guardian->main = count(Guardian::countChildGuardian($suid)) ? 0 : 1;
                    $guardian->save();
                    //班级关系
                    $classRelation = new ClassStudentRelation;
                    $classRelation->cid = $cid;
                    $classRelation->state = 1;
                    $classRelation->student = $suid;
                    $classRelation->save();
                    $result['status']=1;
                }

            } else {
                //创建学生
                $suid = UCQuery::makeMaxId(0, true);
                $member = new Member;
                $member->userid = $suid;
                $member->name =$name;
                $member->identity = 2; //学生标志;
                $member->account = "s" . $suid; //学生前加s;
                $member->pwd = MainHelper::encryPassword("123456");
                $member->state = 1;
                $member->issendpwd = 0;
                if($class->s->createtype == 1){
                    $member->createtype = 1;
                }
                $member->save();
                //创建家长
                $userid = UCQuery::makeMaxId(0, true);
                $member = new Member;
                $member->userid = $userid;
                $member->state = 1;
                $member->name = '用户' . substr($mobile, -4); //$_POST['Student']['name'] . '的' . $roles[$i];
                $member->identity = Constant::FAMILY_IDENTITY; //家长标志;
                $member->mobilephone = $mobile;
                $member->account = "p" . $userid; //;aa
                $member->issendpwd = 0;
                $password = MainHelper::generate_code(6);
                $member->pwd = MainHelper::encryPassword($password);
                if($class->s->createtype == 1){
                    $member->createtype = 1;
                }
                if ($member->save()) {
                    $guardian = new Guardian;
                    $guardian->child = $suid;
                    $guardian->guardian = $userid;
                    $guardian->role = $role?$role:'家长';
                    $guardian->main = 1;
                    $guardian->save();
                }
                //班级关系
                $classRelation = new ClassStudentRelation;
                $classRelation->cid = $cid;
                $classRelation->state = 1;
                $classRelation->student = $suid;
                $classRelation->save();

                $result['mobile']=$mobile;
                $result['password']=$password;

            }
            $transaction->commit();


        }catch(Exception $e){
            $transaction->rollback();
        }
        return $result;
    }


    //根据uids集合,逗号分隔的,获取用户信息
    public static function getUsersByUids($uids)
    {
        $criteria=new CDbCriteria;
        if(empty($uids)) return array();
        $criteria->addInCondition("userid",$uids);
        $criteria->compare('deleted',0);
        $criteria->order="pingyin";
        $data = self::model()->findAll($criteria);
        return $data;
    }

    /*
     * 根据account查找用户
     */
    public static function getMemberByAccount($account)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('deleted',0);
        $criteria->compare('account',$account);
        return self::model()->find($criteria);
    }

     /*
     * 批量导入老师
     * zengp 2014-12-27
     * $mobile 手机号码
     * $name 老师名称
     * $cid 班级id
     */
    public static function addTeacherByMobileAndName($mobile, $name, $cid, $role='老师', $classInfo=null)
    {
        $userid = Yii::app()->user->id;
        $class = $classInfo;
        if(!$class){
            $class = MClass::model()->findByPk($cid);
            if(!$class)
                return null;
        }
        $sid = $class->sid;
        $version = (int)USER_BRANCH;
        $password=MainHelper::generate_code(6);
        $pwd = MainHelper::encryPassword($password);
        $tid = 0;
        $result=array();
        $memberEntity = Member::model()->findByAttributes(array('mobilephone'=>$mobile,'deleted'=>0));
        if(!$memberEntity){
            //老师不存在，添加老师
            $tuid = UCQuery::makeMaxId(0, true);
            $member = new Member;
            $member->userid = $tuid;
            $member->account = 't' . $tuid;
            $member->pwd = $pwd;
            $member->name = $name;
            $member->identity = 1;
            $member->mobilephone = $mobile;
            $member->state = 1;
            $member->version = $version;
            $member->issendpwd = 0;
            if($class->s->createtype == 1){
                $member->createtype = 1;
           }
            $member->save();
            $tid = $member->userid;
            $result['teacher'] = $tid;
            $result['mobile'] = $mobile;
            $result['password'] = $password;
        }else{
            //存在，修改身份
            $oldidentity = $memberEntity->identity;
            $newIdentity=Member::transIdentity(Constant::TEACHER_IDENTITY,$oldidentity);
            $memberEntity->state = 1;
            if($class->s->createtype == 1){
                $memberEntity->createtype = 1;
            }
            $memberEntity->name = $name;
            $memberEntity->identity = $newIdentity;
            $memberEntity->save();
            $tid = $memberEntity->userid;
        }

        //建立老师学校关系

        if($sid){
            $stRelation = SchoolTeacherRelation::getSchoolTeachersRelation(array('sid'=>$sid,'teacher'=>$tid));
            if(!$stRelation){
                   $stNewRecord = new SchoolTeacherRelation;
                   $stNewRecord->sid = $sid;
                   $stNewRecord->teacher = $tid;
                   $stNewRecord->state = 1;
                   if($class->s->createtype == 1){
                        $stNewRecord->duty = 58; //自注册老师 
                   }
                   
                   $stNewRecord->save();
            }
        }

        $ctRelation = ClassTeacherRelation::countTeacherClassRelation($tid,$cid);        
        if(empty($ctRelation)){            
            //建立老师班级关系
            //如果不存在老师班级关系，建立关系
            $ctNewRecord = new ClassTeacherRelation;
            $ctNewRecord->cid = $cid;
            $ctNewRecord->teacher = $tid;
            $ctNewRecord->state = 1;
            $ctNewRecord->creater = $userid;
            $ctNewRecord->subject = '';
            $ctNewRecord->save();
        }else{
            $result['isexists']=1;//已存在班级中
        }
        
        return $result;
        
    }
    /*
     * 根据一组mobiles更新是否发送密码状态,即issendpwd字段
     */
    public static function updateissendpwdStateByMobiles($mobiles){
        $criteria=new CDbCriteria;
        $criteria->compare('deleted',0);
        $criteria->addInCondition('mobilephone',$mobiles);
        self::model()->updateAll(array('issendpwd'=>1),$criteria);
    }

    /*
     * zengp 2014-12-27
     * 判断用户是否为自注册用户
     */
    public static function isSelfReg(){
        $userid = Yii::app()->user->id;
        $member = Member::model()->findByPk($userid);
        return $member->createtype;
    }

    public static function getUseridByMobileArr($mobiles)
    {
        $criteria=new CDbCriteria;
        if(count($mobiles)){
            $criteria->addInCondition('mobilephone',$mobiles);
            $criteria->compare('deleted',0);
            $data = self::model()->findAll($criteria);
        }else{
            $data=array();
        }
        $ids = array();
        foreach($data as $val){
            $ids[$val['mobilephone']]=$val;
        }
        return $ids;
    }
}
