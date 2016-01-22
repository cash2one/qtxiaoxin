<?php

/**
 * This is the model class for table "{{subject}}".
 *
 * The followings are the available columns in table '{{subject}}':
 * @property integer $sid
 * @property string $name
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property integer $schoolid
 *
 * The followings are the available model relations:
 * @property ClassTeacherRelation[] $classTeacherRelations
 * @property School $school
 */
class Subject extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{subject}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('state, deleted, schoolid', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sid, name, state, creationtime, updatetime, deleted, schoolid', 'safe', 'on'=>'search'),
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
			'classTeacherRelations' => array(self::HAS_MANY, 'ClassTeacherRelation', 'sid'),
			'school' => array(self::BELONGS_TO, 'School', 'schoolid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'sid' => '科目ID',
			'name' => '科目名称',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'schoolid' => '学校ID',
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
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('schoolid',$this->schoolid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * 科目列表分页数据
     * panrj 2014-09-16
     * @param array $parms 查询条件及分页参数
     * @return array $result
     */
    public function pageData($parms=array())
    {
        $result = array();
        $criteria = new CDbCriteria();

        //用户权限过滤
        $uid = Yii::app()->user->id;
        $sids = UserAccess::getUserAccessTargetPks($uid,$type=1);
        if(!empty($sids)){
            $criteria->compare('schoolid',$sids);
        }

        if(isset($parms['name']) && $parms['name']!=''){
            $criteria->compare('name',$parms['name'],true);
        }

        if(isset($parms['schoolid']) && !empty($parms['schoolid'])){
            $criteria->compare('schoolid',$parms['schoolid']);
        }
        $criteria->compare('deleted',0);
        $criteria->order = 'creationtime DESC';
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
     * 获取班级科目老师关系
     * panrj 2014-09-17
     * @param $cid 班级id
     * @param $sid 科目id
     * @param $uid 老师id
     * @return $record ClassTeacherRelation
     */
    public static  function getSubjectByattr($cid,$sid,$uid,$subject)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('deleted',0);
        $criteria->compare('type',0);
        $criteria->compare('cid',$cid);
        $criteria->compare('sid',$sid);
       	$record = ClassTeacherRelation::model()->find($criteria);

       	if($record){
            if($uid){
                $record->teacher = $uid;
                $record->subject = $subject?$subject:$record->subject;
                $record->state = 1;
                $record->save();
                return $record;
            }else{ //如果未选uid，则表示删除
                $record->deleted = 1;
                $record->save();
                return $record;
            }
       	}else{
       		$record = new ClassTeacherRelation;
       		$record->cid = $cid;
       		$record->sid = $sid;
       		$record->teacher = $uid;
       		$record->state = 1;
       		$record->type = 0;
       		$record->subject = $subject;
       		$record->save();
       		return $record;
       	}
    }
    public static function getSubjects($sids){
        $criteria = new CDbCriteria();
        $criteria->compare('deleted',0);
        $criteria->addCondition("sid in(".$sids.")");
        $data=  self::model()->findAll($criteria);
        $arr=array();
        foreach($data as $val){
            $arr[$val->sid]=$val->name;
        }
        return $arr;
    }

    public static function getSubjectsBySchoolids($schoolids){
        $criteria = new CDbCriteria();
        $criteria->compare('deleted',0);
        $criteria->addCondition("schoolid in(".$schoolids.")");
        $data=  self::model()->findAll($criteria);
        $arr=array();
        foreach($data as $val){
            $arr[$val->sid]=$val->name;
        }
        return $arr;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Subject the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
