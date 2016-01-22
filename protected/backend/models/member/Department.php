<?php

/**
 * This is the model class for table "{{department}}".
 *
 * The followings are the available columns in table '{{department}}':
 * @property integer $did
 * @property string $name
 * @property integer $sid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property School $s
 * @property SchoolTeacherRelation[] $schoolTeacherRelations
 */
class Department extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{department}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, sid', 'required'),
			array('sid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('did, name, sid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'schoolTeacherRelations' => array(self::HAS_MANY, 'SchoolTeacherRelation', 'did'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'did' => '部门ID',
			'name' => '名称',
			'sid' => '学校',
			'state' => '状态',
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

		$criteria->compare('did',$this->did);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sid',$this->sid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
     * 部门列表分页数据
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
            $criteria->compare('sid',$sids);
        }
        
        if(isset($parms['name']) && $parms['name']!=''){
            $criteria->compare('name',$parms['name'],true);
        }
        
        if(isset($parms['sid']) && !empty($parms['sid'])){
            $criteria->compare('sid',$parms['sid']);
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
    /*
     * 获取学校的部门
     */
    public static function getSchoolDepartment($parms){
        $criteria = new CDbCriteria();
        if(isset($parms['sid']) && $parms['sid']!=''){
            $criteria->compare('sid',$parms['sid']);
        }
        $criteria->compare('deleted',0);
        $arr=self::model()->findAll($criteria);
        $returnArr=array();
        foreach($arr as $d){
            $returnArr[$d->did]= $d->name?$d->name:'';
        }
        return $returnArr;
    }

    public static function getDepartmentArr($dids){
        $criteria = new CDbCriteria();
        $criteria->compare('deleted',0);
        $returnArr=array();
        if(!empty($dids)){
            $criteria->addCondition('did in('.$dids.')');
        }else{
            return $returnArr;
        }
        $criteria->compare('deleted',0);
        $arr=self::model()->findAll($criteria);

        foreach($arr as $d){
            $returnArr[$d->did]= $d->name?$d->name:'';
        }
        return $returnArr;
    }

    /*
     * 获取组的成员数
     */
    public static function getDepartmentMemberNum($did)
    {
        $criteria = new CDbCriteria;
        $criteria->compare("did", $did);
        $criteria->compare("deleted", 0);
        $criteria->compare("state", 1);
        return SchoolTeacherRelation::model()->count($criteria);

    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Department the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
