<?php

/**
 * This is the model class for table "{{contract}}".
 *
 * The followings are the available columns in table '{{contract}}':
 * @property integer $cid
 * @property string $contractid
 * @property string $name
 * @property integer $bid
 * @property integer $uid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Business $b
 * @property User $u
 * @property ContractAdvertisementRelation[] $contractAdvertisementRelations
 */
class Contract extends MasterActiveRecord
{
	public $ctype = '';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contract}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contractid, name, bid, uid', 'required'),
			array('bid, uid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('contractid', 'length', 'max'=>20),
			array('name', 'length', 'max'=>50),
			array('updatetime, creationtime, checker', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cid, contractid, name, bid, uid, state, creationtime, updatetime, deleted, checker', 'safe', 'on'=>'search'),
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
			'b' => array(self::BELONGS_TO, 'Business', 'bid'),
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
			'contractAdvertisementRelations' => array(self::HAS_MANY, 'ContractAdvertisementRelation', 'cid'),
			'contractFocusRelations' => array(self::HAS_MANY, 'ContractFocusRelation', 'cid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cid' => '合同ID',
			'contractid' => '合同编号',
			'name' => '合同名称',
			'bid' => '所属商户',
			'uid' => '创建者',
			'state' => '状态',
			'checker' => '审批人',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除',
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

		$criteria->compare('cid',$this->cid);
		$criteria->compare('contractid',$this->contractid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('state',$this->state);
		$criteria->compare('checker',$this->checker);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 合同列表分页数据
	 * panrj 2014-05-26
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageData($parms=array(),$ty='')
	{
		$result = array();
		$criteria = new CDbCriteria();
			
		if(isset($parms['contractid']) && $parms['contractid']!=''){
        	$criteria->compare('contractid',$parms['contractid'],true);
        }
        if(isset($parms['bid']) && $parms['bid']!==''){
        	$criteria->compare('bid',$parms['bid']);
        }
        if(isset($parms['uid']) && $parms['uid']){
        	$criteria->compare('uid',$parms['uid']);
        }
        if(isset($parms['state']) && $parms['state']!==''){
        	$criteria->compare('state',$parms['state']);
        }
        if($ty=='doc'){
        	$criteria->compare('state','>0');
        }
        $criteria->scopes='normal';  
		$criteria->order = 'state ASC,creationtime DESC';     
        $count = self::model()->count($criteria); 
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
	 * 获取合同商家名称
	 * panrj 2014-05-26
	 * @return string $name 
	 */
	public function getBusinessName()
	{
		$name = Business::getBusinessName($this->bid);
		return $name;
	}

	/**
	 * 获取合同合作类型字典
	 * panrj 2014-05-26
	 * @return string $arr 
	 */
	public static function getTypeArr()
	{
		$arr = array('adv'=>'广告','foc'=>'热点','info'=>'资讯');
		return $arr;
	}

	/**
	 * 获取合同状态字典
	 * panrj 2014-05-26
	 * @return string $arr 
	 */
	public static function getStateArr($ty='')
	{
		if($ty=='doc'){
			$arr = array('1'=>'待审批','2'=>'已通过','3'=>'未通过',);
		}else{
			$arr = array('0'=>'未提交','1'=>'待审批','2'=>'已通过','3'=>'未通过',);
		}
		return $arr;
	}

	/**
	 * 获取合同状态名称
	 * panrj 2014-05-26
	 * @return string $name 
	 */
	public function getStateName($ty='')
	{
		$arr = $this->getStateArr();
		return $arr[$this->state];
	}

	/**
	 * 提取不同状态的合同数据
	 * panrj 2014-06-05
	 * @return array Contract
	 */
	public static function getConStateData($state=1)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('state',$state);
		$criteria->order = 'creationtime';
		$criteria->scopes='normal';
		$data = self::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 统计不同状态的合同数量
	 * panrj 2014-06-05
	 * @return array Contract
	 */
	public static function countConStateData($state=1)
	{
		$data = self::getConStateData($state);
		return count($data);
	}

	/**
	 * 提取广告合同关系数据
	 * panrj 2014-06-05
	 * @return array ContractAdvertisementRelation
	 */
	public function getAdvRelationData()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('cid',$this->cid);
		$criteria->order = 'startdate';
		$criteria->scopes='normal';
		$data = ContractAdvertisementRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 提取热点关系数据
	 * panrj 2014-06-05
	 * @return array ContractFocusRelation
	 */
	public function getFocRelationData()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('cid',$this->cid);
		$criteria->order = 'startdate';
		$criteria->scopes='normal';
		$data = ContractFocusRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 提取资讯点关系数据
	 * panrj 2014-06-05
	 * @return array ContractFocusRelation
	 */
	public function getInfoRelationData()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('cid',$this->cid);
		$criteria->order = 'startdate';
		$criteria->scopes='normal';
		$data = ContractInfomationRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 删除ContractAdvertisementRelation同时删除ContractAdvertisementRange
	 * panrj 2014-06-05
	 */
	public static function deleteConAdvRelations($rids)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('carid',$rids);
		$criteria->scopes='normal';
		ContractAdvertisementRelation::model()->updateAll(array('deleted'=>1),$criteria);
		self::model()->deleteConAdvRanges($rids);
	}

	/**
	 * 删除ContractAdvertisementRange
	 * panrj 2014-06-05
	 */
	public static function deleteConAdvRanges($rids)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('carid',$rids);
		$criteria->scopes='normal';
		ContractAdvertisementRange::model()->updateAll(array('deleted'=>1),$criteria);
	}

	/**
	 * 删除ContractFocusRelation同时删除ContractFocusRange
	 * panrj 2014-06-05
	 */
	public static function deleteConFocRelations($rids)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('cfrid',$rids);
		$criteria->scopes='normal';
		ContractFocusRelation::model()->updateAll(array('deleted'=>1),$criteria);
		self::model()->deleteConFocRanges($rids);
	}

	/**
	 * 删除ContractFocusRange
	 * panrj 2014-06-05
	 */
	public static function deleteConFocRanges($rids)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('cfrid',$rids);
		$criteria->scopes='normal';
		ContractFocusRange::model()->updateAll(array('deleted'=>1),$criteria);
	}

	/**
	 * 删除ContractInfomationRelation
	 * panrj 2014-06-05
	 */
	public static function deleteConInfoRelations($rids)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('cirid',$rids);
		$criteria->scopes='normal';
		ContractInfomationRelation::model()->updateAll(array('deleted'=>1),$criteria);
	}

	public function getConAdvRelationPks()
	{
		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(carid) AS carid";
		$criteria->compare('cid',$this->cid);
		$criteria->scopes='normal';
		$relations = ContractAdvertisementRelation::model()->find($criteria);
		// $carids = $relations->carid;
		$carids = explode(",",$relations->carid);
		return $carids;
		// conlog($carids);
	}

	public function getConFocRelationPks()
	{
		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(cfrid) AS cfrid";
		$criteria->compare('cid',$this->cid);
		$criteria->scopes='normal';
		$relations = ContractFocusRelation::model()->find($criteria);
		$cfrids = explode(",",$relations->cfrid);
		return $cfrids;
	}

	public function getConInfoRelationPks()
	{
		$criteria=new CDbCriteria;
		$criteria->select = "GROUP_CONCAT(cirid) AS cirid";
		$criteria->compare('cid',$this->cid);
		$criteria->scopes='normal';
		$relations = ContractInfomationRelation::model()->find($criteria);
		$cirids = explode(",",$relations->cirid);
		return $cirids;
	}

	/**
	 * 扩展deleteMark方法,用来同时删除合同关联关系
	 * panrj 2014-07-29
	 */
	public function deleteMark()
	{
		$arpks = $this->getConAdvRelationPks();
		$this->deleteConAdvRelations($arpks);
		$frpks = $this->getConFocRelationPks();
		$this->deleteConFocRelations($frpks);
		$irpks = $this->getConInfoRelationPks();
		$this->deleteConInfoRelations($irpks);
		return parent::deleteMark();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contract the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
