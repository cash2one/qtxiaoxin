<?php

/**
 * This is the model class for table "{{group}}".
 *
 * The followings are the available columns in table '{{group}}':
 * @property integer $gid
 * @property integer $sid
 * @property string $name
 * @property string $creater
 * @property integer $type
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property User $creater0
 * @property School $s
 * @property GroupMember[] $groupMembers
 */
class Group extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, name, creater, type', 'required'),
			array('sid, type, state, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('creater', 'length', 'max'=>20),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('gid, sid, name, creater, type, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'creater0' => array(self::BELONGS_TO, 'Member', 'creater'),
			's' => array(self::BELONGS_TO, 'School', 'sid'),
			'groupMembers' => array(self::HAS_MANY, 'GroupMember', 'gid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gid' => '群组ID',
			'sid' => '学校',
			'name' => '群组名称',
			'creater' => '创建者',
			'type' => '组类型：0学生组；1老师组',
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

		$criteria->compare('gid',$this->gid);
		$criteria->compare('sid',$this->sid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('creater',$this->creater,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getUserGroup($uid,$sid=false,$type='')
    {
        $criteria=new CDbCriteria;
        $criteria->compare('creater',$uid);
        $criteria->compare('deleted',0);
        if($type!==''){
        	$criteria->compare('type',$type);
        }
        if($sid){
        	$criteria->compare('sid',$sid);
        }
        return self::model()->findAll($criteria);
    }

    public static function getUserGroupWithShare($uid,$sid=false,$type='')
    {
    	$ty = $type==''?-1:$type;
    	$share_groups = GroupPermission::getShareGidsArr($uid,$sid,$ty);
        $criteria=new CDbCriteria;
        $criteria->compare('creater',$uid);
        $criteria->compare('deleted',0);
        if(count($share_groups)){
        	$pks = array();
        	foreach($share_groups as $g){
        		$pks[] = $g['gid'];
        	}
        	$criteria->addCondition('gid in ('.implode(",",$pks).')','OR');
        }
        if($type!==''){
        	$criteria->compare('type',$type);
        }
        if($sid){
        	$criteria->compare('sid',$sid);
        }
        return self::model()->findAll($criteria);
    }

    /**
     * 组分页数据
     * panrj 2014-06-12
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
        if(isset($parms['teacher']) && !empty($parms['teacher'])){
            $criteria->compare('creater',$parms['teacher']);
        }
        if(isset($parms['type']) && $parms['type']!=-1){
            $criteria->compare('type',(int)$parms['type']);
        }
        $criteria->compare('deleted',0);
        $criteria->order = 'creationtime desc';
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

    public static function deleteGroup($id){
        $f=GroupMember::deleteGroup($id);
        GroupPermission::deletePermissionByGid($id);
        $data=self::model()->findByPk($id);
        if($data){
            $data->deleted=1;
            return $data->save();
        }
        return true;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Group the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
