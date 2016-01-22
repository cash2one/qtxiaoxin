<?php

/**
 * This is the model class for table "{{guardian}}".
 *
 * The followings are the available columns in table '{{guardian}}':
 * @property integer $id
 * @property string $child
 * @property string $guardian
 * @property string $role
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property integer $main
 *
 * The followings are the available model relations:
 * @property User $child0
 * @property User $guardian0
 */
class Guardian extends MemberActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{guardian}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('child, guardian', 'required'),
            array('state, deleted, main', 'numerical', 'integerOnly' => true),
            array('child, guardian', 'length', 'max' => 20),
            array('role', 'length', 'max' => 10),
            array('updatetime,creationtime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, child, guardian, role, state, creationtime, updatetime, deleted, main', 'safe', 'on' => 'search'),
        );
    }

    public function afterSave()
    {
        //2015-01-22取消关注短信　
        /*
        if($this->getIsNewRecord()){
            $data['receiver'] = '{"5":"' . $this->child . '"}';
            $data['noticeType'] = 6;
            $data['isSendsms'] = 0;
            $data['isSendsms'] = 0;
            $data['receiveTitle'] = 'xxx';
            $platform=Yii::app()->params['platform'];
            $parent=UCQuery::queryRow("select name,createtype,deleted,userid,issendpwd,mobilephone from tb_user where userid=".$this->guardian);
            $mobile=$parent?$parent->mobilephone:'';
            if($platform=='fronted'){ //目前只针对前台处理,后台发送者问题未解决
                $childinfo=UCQuery::queryRow("select name,createtype,deleted,userid,issendpwd from tb_user where userid=".$this->child);
                $count=Guardian::countGuardianChild($this->guardian);
                if($count>1){ //注册的不发,只发系统的
                    $desc = $childinfo->name."家长您好：您孩子".$childinfo->name."所在班级开通".SITE_NAME."了，后续日常作业和学校通知都通过该平台发送，老师和家长都在用了，赶快关注加入吧！";
                    UCQuery::sendMobileMsg($mobile,$desc);
                }
            }else{
                $count=Guardian::countGuardianChild($this->guardian);
                if($count>1&&$parent&&$parent->issendpwd==1){
                    $childinfo=UCQuery::queryRow("select name,createtype,deleted,userid,issendpwd from tb_user where userid=".$this->child);
                    $userid=100+(int)USER_BRANCH;
                    $userinfo=Yii::app()->cache->get("mem_object_user_".$userid);
                    if(!$userinfo){
                        $userinfo=Member::model()->findByPk($userid);
                        Yii::app()->cache->set("mem_object_user_".$userid,$userinfo,300);
                    }
                    if($userinfo&&$userinfo->deleted==0){ //找得到这个用户才发
                       // $desc = $userinfo->name."邀请您关注".$childinfo->name ;
                        $desc = $childinfo->name."家长您好：您孩子".$childinfo->name."所在班级开通".SITE_NAME."了，后续日常作业和学校通知都通过该平台发送，老师和家长都在用了，赶快关注加入吧！";
                        UCQuery::sendMobileMsg($mobile,$desc);
                    }
                    if($mobile){
                        UCQuery::sendMobileMsg($mobile,$desc);
                    }
                }

            }


        }
        */

    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'child0' => array(self::BELONGS_TO, 'Member', 'child'),
            'guardian0' => array(self::BELONGS_TO, 'Member', 'guardian'),
        );
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'child' => '孩子',
            'guardian' => '监护人',
            'role' => '角色：如“爸爸”，“妈妈”',
            'state' => '状态',
            'creationtime' => '创建时间',
            'updatetime' => '更新时间',
            'deleted' => '是否已删除',
            'main' => '是否第一监护',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('child', $this->child, true);
        $criteria->compare('guardian', $this->guardian, true);
        $criteria->compare('role', $this->role, true);
        $criteria->compare('state', $this->state);
        $criteria->compare('creationtime', $this->creationtime, true);
        $criteria->compare('updatetime', $this->updatetime, true);
        $criteria->compare('deleted', $this->deleted);
        $criteria->compare('main', $this->main);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*
     * 删除学生家长关系
     */
    public static function deleteStudentGrardianRelation($student)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('child', $student);
        self::model()->updateAll(array('deleted' => 1), $criteria);
    }


    /*
     * 删除学生家长关系
     */
    public static function deleteStudentGrardianRelations($guardian)
    {
        $criteria = new CDbCriteria;
        $criteria->addInCondition('guardian', $guardian);
        self::model()->updateAll(array('deleted' => 1), $criteria);
    }
    /*
     * 删除学生家长关系
     */
    public static function getDeleteStudentGrardianRelation($student)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('child', $student);
        $data=self::model()->findAll($criteria);
        return $data;
    }

    public static function getChilds($uid)
    {
        $criteria = new CDbCriteria;
        $criteria->with=array("child0");
        $criteria->compare('t.guardian', $uid);
        $criteria->compare('t.deleted', 0);
        $criteria->compare('child0.deleted', 0);
        return self::model()->findAll($criteria);
    }


    /**
     * 返回第一监护人
     * panrj 2014-10-31
     * @return array $arr 
     */
    public static function getChildFirstGuardian($child)
    {
        $criteria = new CDbCriteria;
        $criteria->with= array('guardian0');
        $criteria->compare('t.child', $child);
        $criteria->compare('t.deleted', 0);
        $criteria->compare('guardian0.deleted', 0);
        $criteria->order = 't.main desc';
        return self::model()->find($criteria);
    }

    /*
     *返回学生所有监护人关系;
     */
    public static function getChildGuardianRelation($child){
        $criteria = new CDbCriteria;
        $criteria->with=array("guardian0");
        $criteria->compare('t.child', $child);
        $criteria->compare('t.deleted', 0);
        $criteria->compare('guardian0.deleted', 0);
        $data= self::model()->findAll($criteria);
        return $data;
    }

    /*
    *返回学生所有监护人关系;
    */
    public static function countChildGuardian($child){
        $criteria = new CDbCriteria;
        $criteria->compare('t.child', $child);
        $criteria->compare('t.deleted', 0);
        $data= self::model()->count($criteria);
        return $data;
    }

     /**
     * 返回所有监护人
     * panrj 2014-10-31
     * @return array $arr 
     */
    public static function getChildGuardian($child)
    {
        $data= self::getChildGuardianRelation($child);
        $guardians=array();
        foreach($data as $val){
            $guardians[]=$val->guardian0;
        }
        return $guardians;
    }
    /*
     * 判断学生与家长关系
     */
    public static function getRelationByChildGuardian($guardian,$child)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('guardian', $guardian);
        $criteria->compare('child', $child);
        $criteria->compare('deleted', 0);
        return self::model()->find($criteria);
    }

    /**
     * 检查家长学生姓名
     * panrj 2014-11-17
     * @param int $guardian 监护人ID
     * @param string $name 姓名
     */
    public static function getParentChildByName($guardian,$name)
    {
        $criteria = new CDbCriteria;
        $criteria->with=array("child0");
        $criteria->compare('t.guardian', $guardian);
        $criteria->compare('child0.name', $name);
        $criteria->compare('t.deleted', 0);
        $criteria->compare('child0.deleted', 0);
        return self::model()->find($criteria);
    }

    /*
    * 删除学生不在学生家长的家长关系
    */
    public static function deleteStudentGrardianByGuardians($student,$guardians)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('child', $student);
        if(count($guardians)){
            $criteria->addCondition("guardian not in(".implode(",",$guardians).")");
        }
        self::model()->updateAll(array('deleted' => 1), $criteria);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Guardian the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    /*
     * 查看孩子姓名与监护人关系　
     */
    public static function checkGuardianChildByName($guardian,$childname)
    {
        $criteria = new CDbCriteria;
        $criteria->with=array("child0");
      //  $criteria->select=array("t.child,t.guardian");
        $criteria->compare('t.guardian', $guardian);
        $criteria->compare('t.deleted', 0);
        $criteria->compare('child0.deleted', 0);
        $criteria->compare('child0.name', $childname);
        return self::model()->find($criteria);
    }
    /*
     * 统计监护人的孩子
     */
    public static function countGuardianChild($uid)
    {
        $criteria = new CDbCriteria;
        $criteria->with=array("child0");
        $criteria->compare('t.guardian', $uid);
        $criteria->compare('t.deleted', 0);
        $criteria->compare('child0.deleted', 0);
        return self::model()->count($criteria);
    }
}
