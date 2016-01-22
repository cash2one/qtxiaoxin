<?php

/**
 * This is the model class for table "{{cdkey}}".
 *
 * The followings are the available columns in table '{{cdkey}}':
 * @property integer $id
 * @property string $cdkey
 * @property string $password
 * @property integer $type
 * @property string $userid
 * @property integer $cid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Class $c
 */
class Cdkey extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cdkey}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cdkey, password, type, cid', 'required'),
			array('type, cid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('cdkey, password, userid', 'length', 'max'=>20),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cdkey, password, type, userid, cid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'userid'),
			'c' => array(self::BELONGS_TO, 'Class', 'cid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'cdkey' => '激活码',
			'password' => '激活码密码',
			'type' => '类型：0老师；1家长',
			'userid' => '绑定的老师ID或学生ID',
			'cid' => '班级ID',
			'state' => '状态：暂未使用',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
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
		$criteria->compare('cdkey',$this->cdkey,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function checkTeacherInClass($uid,$cid)
	{
		$criteria = new CDbCriteria;
        $criteria->compare('userid', $uid);
        $criteria->compare('cid', $cid);
        $criteria->compare('type', 0);
        $criteria->compare('deleted', 0);
        $count = self::model()->count($criteria);
        return $count;
	}

	/**
     * 邀请码邀请老师
     * panrj 2014-11-17
     * @param int $cid 班级ID
     * @param string $name 姓名
     * @param string $password 密码
     * @param string $mobilephone 手机
     * @param int $cdkid 邀请码ID
     * @return int $result
     */
	public static function activeVerify($cdkey,$pwd,$type)
	{
		$criteria = new CDbCriteria;
        $criteria->compare('cdkey', $cdkey);
        $criteria->compare('password', $pwd);
        $criteria->compare('type', $type);
        $criteria->compare('deleted', 0);
        $cdkey = self::model()->find($criteria);
        return $cdkey;
	}

	/**
     * 邀请码邀请老师
     * panrj 2014-11-14
     * @param int $cid 班级ID
     * @param string $name 姓名
     * @param string $password 密码
     * @param string $mobilephone 手机
     * @param int $cdkid 邀请码ID
     * @return int $result
     */
	public static function activeTeacher($cid,$name,$password,$mobilephone,$cdkid)
	{
		$transaction = Yii::app()->db_member->beginTransaction();
		$userVersion = (int)USER_BRANCH;
		$result = 1;
		try{
			$class = MClass::model()->findByPk($cid);
			$t = Member::getUniqueMember($mobilephone);
	
			if($t){/*老师用户已存在 */
				$is_exist = self::checkTeacherInClass($t->userid,$cid);
				if($is_exist){
					$result = 2;
				}else{
					if($t->identity==1 || $t->identity==5){
						$t->pwd = $password;
						$t->save();
					}else{
						$t->pwd = $password;
						$t->identity = 5;
						$t->save();
					}

					$class_relation_num = ClassTeacherRelation::countTeacherClassRelation($t->userid,$cid);
					if($class_relation_num==0){/*新建老师班级关系*/
						$class_relation = new ClassTeacherRelation;
						$class_relation->teacher = $t->userid;
						$class_relation->cid = $cid;
						$class_relation->state = 1;
						$class_relation->save();
					}

					$school_relation_num = SchoolTeacherRelation::countTeacherSchoolRelation($t->userid,$class->sid);
					if($class_relation_num==0){/*新建老师学校关系*/
						$teacher_relation = new SchoolTeacherRelation;
						$teacher_relation->teacher = $t->userid;
						$teacher_relation->sid = $class->sid;
						$teacher_relation->state = 1;
						$teacher_relation->save();
					}

					/* 更新tb_cdkey */
					$cdk = self::model()->findByPk($cdkid);
					$cdk->userid = $t->userid;
					$cdk->save();
				}
				
			}else{
				/*创建用户 */
				$teacherid = UCQuery::makeMaxId(0, true);
				$teacher = new Member;
				$teacher->name = '用户'.substr($mobilephone, -4);
				$teacher->userid = $teacherid;
				$teacher->account = "t" . $teacherid;
				$teacher->pwd = $password;
				$teacher->identity = 1;
				$teacher->mobilephone = $mobilephone;
				$teacher->state = 1;
				$teacher->version = $userVersion;
				$teacher->save();
				
				/*老师班级关系 */
				$class_relation = new ClassTeacherRelation;
				$class_relation->teacher = $teacherid;
				$class_relation->creater = $teacherid;
				$class_relation->cid = $cid;
				$class_relation->state = 1;
				$class_relation->subject = '';
				$class_relation->save();
				
				/*老师学校关系 */
				$teacher_relation = new SchoolTeacherRelation;
				$teacher_relation->teacher = $teacherid;
				$teacher_relation->sid = $class->sid;
				$teacher_relation->state = 1;
				$teacher_relation->save();
				
				/* 更新tb_cdkey */
				$cdk = self::model()->findByPk($cdkid);
				$cdk->userid = $teacher->userid;
				$cdk->save();
			}


			$transaction->commit();
			$result = 0;
        }catch(Exception $e){
            $transaction->rollback();
        }
        return $result;
	}

	/**
     * 邀请码邀请学生
     * panrj 2014-11-17
     * @param int $cid 班级ID
     * @param string $name 姓名
     * @param string $password 密码
     * @param string $mobilephone 手机
     * @param int $cdkid 邀请码ID
     * @param string $studentid 学号
     * @return int $result
     */
	public static function activeStudent($cid,$name,$password,$mobilephone,$cdkid,$studentid)
	{
		$transaction = Yii::app()->db_member->beginTransaction();
		$userVersion = (int)USER_BRANCH;
		$result = 1;
		try{
			$cdk = self::model()->findByPk($cdkid);
			$class = MClass::model()->findByPk($cid);
			$t = Member::getUniqueMember($mobilephone);
			if(!$cdk->userid){
				//学生用户不存在,创建学生
				$sid = UCQuery::makeMaxId(0, true);
				$student = new Member;
				$student->name = $name;
				$student->userid = $sid;
				$student->account = "s" . $sid;
				$student->pwd = $password;
				$student->identity = 2;
				$student->mobilephone = '';
				$student->state = 1;
				$student->version = $userVersion;
				$student->save();

				$student_ext = StudentExt::getOrCreate($sid);
				$student_ext->studentid = $studentid;
				$student_ext->save();

				if(!$t){//监护人不存在，创建监护人
					$pid = UCQuery::makeMaxId(0, true);
					$parent = new Member;
					$parent->name = '用户'.substr($mobilephone, -4);
					$parent->userid = $pid;
					$parent->account = "p" . $pid;
					$parent->pwd = $password;
					$parent->identity = 4;
					$parent->mobilephone = $mobilephone;
					$parent->state = 1;
					$parent->version = $userVersion;
					$parent->save();
					//添加监护人关系
					$g = new Guardian;
					$g->child = $student->userid;
					$g->guardian = $parent->userid;
					$g->main = 1;
					$g->save();
				}else{//监护人已存在
					if($t->identity!=4 && $t->identity!=5){
						$t->identity = 5;
					}
					$t->pwd = $password;
					$t->save();
					$pid = $t->userid;
				}
				//判断监护人关系
				$guardian = Guardian::getParentChildByName($pid,$name);
				if(!$guardian){//没有同名孩子
					$g = new Guardian;
					$g->child = $student->userid;
					$g->guardian = $pid;
					$g->main = 1;
					$g->save();
				}
				//添加班级学生关系
				$relation = new ClassStudentRelation;
				$relation->cid = $cid;
				$relation->student = $student->userid;
				$relation->state = 1;
				$relation->creater = $pid;
				$relation->save();	
				//更新邀请码
				$cdk->userid = $student->userid;
				$cdk->save();
			}else{
				/*学生用户已存在 */
				if(!$t){//监护人不存在，创建监护人
					/*家长用户不存在 */
					$pid = UCQuery::makeMaxId(0, true);
					$parent = new Member;
					$parent->name = '用户'.substr($mobilephone, -4);
					$parent->userid = $pid;
					$parent->account = "p" . $pid;
					$parent->pwd = $password;
					$parent->identity = 4;
					$parent->mobilephone = $mobilephone;
					$parent->state = 1;
					$parent->version = $userVersion;
					$parent->save();

					$g = new Guardian;
					$g->child = $cdk->userid;
					$g->guardian = $pid;
					$g->save();
				}else{	
					/*家长用户已存在 */
					$guardian = Guardian::getRelationByChildGuardian($t->userid,$cdk->userid);
					if(!$guardian){
						$g = new Guardian;
						$g->child = $cdk->userid;
						$g->guardian = $t->userid;
						$g->save();
					}

					if($t->identity!=4 && $t->identity!=5){
						$t->identity = 5;
					}
					$t->pwd = $password;
					$t->save();
				}
				
				$student_ext = StudentExt::getOrCreate($cdk->userid);
				$student_ext->studentid = $studentid;
				$student_ext->save();
			}
			$transaction->commit();
			$result = 0;
        }catch(Exception $e){
            $transaction->rollback();
        }
        return $result;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cdkey the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
