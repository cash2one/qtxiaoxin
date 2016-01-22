<?php

/**
 * This is the model class for table "{{business}}".
 *
 * The followings are the available columns in table '{{business}}':
 * @property integer $bid
 * @property string $name
 * @property string $logo
 * @property string $introduction
 * @property string $phone
 * @property string $contacter
 * @property string $address
 * @property integer $uid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property User $u
 * @property Contract[] $contracts
 */
class Business extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{business}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, phone, contacter, uid', 'required'),
			array('uid, state, deleted, mall', 'numerical', 'integerOnly'=>true),
			array('name, phone, contacter', 'length', 'max'=>20),
			array('address', 'length', 'max'=>50),
			array('logo, image', 'length', 'max'=>100),
			array('updatetime,creationtime, introduction', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bid, name, logo, introduction, phone, contacter, address, uid, state, creationtime, updatetime, deleted, image', 'safe', 'on'=>'search'),
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
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
			'contracts' => array(self::HAS_MANY, 'Contract', 'bid'),
			'goods' => array(self::HAS_MANY, 'MallGoods', 'bid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bid' => '商户ID',
			'name' => '商户名称',
			'logo' => '商户logo',
			'image' => '商户大图',
			'introduction' => '商户介绍',
			'phone' => '联系电话',
			'contacter' => '联系人',
			'address' => '地址',
			'uid' => '创建者',
			'state' => '状态',
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

		$criteria->compare('bid',$this->bid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('introduction',$this->introduction,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('contacter',$this->contacter,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('state',$this->state);
		$criteria->compare('mall',$this->mall);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 商户列表分页数据
	 * panrj 2014-05-20
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
        if(isset($parms['mall']) && $parms['mall']!=''){
        	$criteria->compare('mall',$parms['mall']);
        }
        if(isset($parms['state']) && $parms['state']!=''){
        	$criteria->compare('state',$parms['state']);
        }
        $criteria->scopes='normal';  
		$criteria->order = 'creationtime DESC';     
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
	 * 返回商户键值数组
	 * panrj 2014-05-20
	 * @return array $arr 
	 */
	public static function getDataArr($mall=false)
	{
		$criteria = new CDbCriteria();
		if($mall){
			$criteria->compare('mall',1);
		}
		$criteria->scopes='normal';
		$criteria->order = 'name';
		$criteria->select = 'bid,name';
		$data = self::model()->findAll($criteria);
		$arr = array();
		foreach($data as $d){
			$arr[$d->bid] = $d->name;
		}
		return $arr;
	}

	/**
	 * 返回商户名称
	 * panrj 2014-05-26
	 * @return string $name
	 */
	public static function getBusinessName($bid)
	{	
		if(!$bid)
			return '';
		$business = Business::model()->findByPk($bid);
		if($business->state!=0){
			return $business->name;
		}else{
			if($business->mall){
				return $business->name.'(已下架)';
			}else{
				return $business->name;
			}
		}
	}

	/**
	 * 返回商户关联广告
	 * panrj 2014-05-26
	 * @return array $arr 
	 */
	public static function getAdvData($bid)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$bid);
		$criteria->scopes='normal';
		$criteria->order = 'title';
		$data = Advertisement::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 返回商户关联广告字典
	 * panrj 2014-05-26
	 * @return array $arr 
	 */
	public static function getAdvDataArr($bid)
	{
		$data = self::getAdvData($bid);
		$arr = array();
		foreach($data as $d){
			$arr[$d->aid] = $d->title;
		}
		return $arr;
	}

	/**
	 * 返回商户关联热点
	 * panrj 2014-05-26
	 * @return array $arr 
	 */
	public static function getFocData($bid)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$bid);
		$criteria->scopes='normal';
		$criteria->order = 'title';
		$data = Focus::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 返回商户关联热点字典
	 * panrj 2014-05-26
	 * @return array $arr 
	 */
	public static function getFocDataArr($bid)
	{
		$data = self::getFocData($bid);
		$arr = array();
		foreach($data as $d){
			$arr[$d->fid] = $d->title;
		}
		return $arr;
	}

	/**
	 * 返回商户关联资讯
	 * panrj 2014-06-17
	 * @return array $arr 
	 */
	public static function getInfoData($bid)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$bid);
		$criteria->scopes='normal';
		$criteria->order = 'title';
		$data = Information::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 返回商户关联资讯字典
	 * panrj 2014-06-17
	 * @return array $arr 
	 */
	public static function getInfoDataArr($bid)
	{
		$data = self::getInfoData($bid);
		$arr = array();
		foreach($data as $d){
			$arr[$d->iid] = $d->title;
		}
		return $arr;
	}

	/**
	 * 商户关联有效合同广告查询
	 * panrj 2014-06-11
	 * @return array $arr 
	 */
	public function getBusConAdvRelations()
	{
		$date = date('Y-m-d',time()).' 00:00:00';
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$this->bid);
		// $criteria->compare("startdate","<=".$date);
		$criteria->compare("enddate",">=".$date);
		$data = ViewBusinessConAdvRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 商户关联有效合同热点查询
	 * panrj 2014-06-11
	 * @return array $arr 
	 */
	public function getBusConFocRelations()
	{
		$date = date('Y-m-d',time()).' 00:00:00';
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$this->bid);
		// $criteria->compare("startdate","<=".$date);
		$criteria->compare("enddate",">=".$date);
		$data = ViewBusinessConFocRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 商户启用商品查询
	 * panrj 2014-07-26
	 * @return MallGoods records
	 */
	public function getGoodsEnable()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$this->bid);
		$criteria->compare("state",1);
		$criteria->scopes='normal';
		$data = MallGoods::model()->findAll($criteria); 
		return $data;
	}

	/**
	 * 商户启用商品数查询
	 * panrj 2014-07-26
	 * @return MallGoods records
	 */
	public function countGoodsEnable()
	{
		$data = $this->getGoodsEnable();
		return count($data);
	}

	/**
	 * 商户商品查询
	 * panrj 2014-07-26
	 * @return MallGoods records
	 */
	public function getGoods($ty='')
	{
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$this->bid);
		$criteria->scopes='normal';
		if($ty=='delete'){
			MallGoods::model()->updateAll(array('deleted'=>1),$criteria);
		}else{
			$data = MallGoods::model()->findAll($criteria); 
			return $data;
		}
	}

	/**
	 * 商户广告查询
	 * panrj 2014-07-26
	 * @return Advertisement records
	 */
	public function getAdvertisements($ty='')
	{
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$this->bid);
		$criteria->scopes='normal';
		if($ty=='delete'){
			Advertisement::model()->updateAll(array('deleted'=>1),$criteria);
		}else{
			$data = Advertisement::model()->findAll($criteria); 
			return $data;
		}
	}

	/**
	 * 商户热点查询
	 * panrj 2014-07-26
	 * @return Focus records 
	 */
	public function getFocuses($ty='')
	{
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$this->bid);
		$criteria->scopes='normal';
		if($ty=='delete'){
			Focus::model()->updateAll(array('deleted'=>1),$criteria);
		}else{
			$data = Focus::model()->findAll($criteria); 
			return $data;
		}
	}

	/**
	 * 商户资讯查询
	 * panrj 2014-07-26
	 * @return Information record
	 */
	public function getInformations($ty='')
	{
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$this->bid);
		$criteria->scopes='normal';
		if($ty=='delete'){
			Information::model()->updateAll(array('deleted'=>1),$criteria);
		}else{
			$data = Information::model()->findAll($criteria); 
			return $data;
		}
	}

	/**
	 * 商户合同查询
	 * panrj 2014-07-26
	 * @return Contract record
	 */
	public function getContracts($ty='')
	{
		$criteria = new CDbCriteria();
		$criteria->compare('bid',$this->bid);
		$criteria->scopes='normal';
		if($ty=='delete'){
			Contract::model()->updateAll(array('deleted'=>1),$criteria);
		}else{
			$data = Contract::model()->findAll($criteria); 
			return $data;
		}
	}

	/**
	 * 商户关联有效合同查询
	 * panrj 2014-06-11
	 * @return array $arr 
	 */
	public function hasBusConRelations()
	{
		$advs = $this->getBusConAdvRelations();
		$focs = $this->getBusConFocRelations();

		if(count($advs) || count($focs)){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * 商户是否满足删除条件
	 * panrj 2014-07-26
	 * @return bool 
	 */
	public function canDeleted()
	{
		$goods = count($this->getGoods()); 
		$advs = count($this->getAdvertisements());
		$focus = count($this->getFocuses());
		$infos = count($this->getInformations());
		$contracts = $this->hasBusConRelations();
		if($goods || $advs || $focus || $infos || $contracts){
			return false;
		}else{
			return true;
		}
	}

	/**
	 * 返回商城商家类型字典
	 * panrj 2014-07-09
	 * @return array $arr 
	 */
	public static function getMallDataArr()
	{
		$Arr = array('0'=>'普通商家','1'=>'商城商家');
		return $Arr;
	}

	public function getDisableState($reverse=false)
	{
		if(!$this->mall){
			return '';
		}
		$arr = array('1'=>'上架','0'=>'下架');
		if($reverse){
    		$state = $this->state==1 ? 0 : 1;
    		return $arr[$state];
    	}else{
    		return $arr[$this->state];
    	}
	}

	/**
	 * 返回商城商家类型字典
	 * panrj 2014-07-09
	 * @return array $arr 
	 */
	public function getMallDataName()
	{
		$Arr = self::getMallDataArr();
		return $Arr[$this->mall];
	}

	/**
	 * 扩展deleteMark方法,用来删除商户关联的内容
	 * panrj 2014-07-26
	 */
	public function deleteMark()
	{
		$goods = $this->getGoods('delete'); 
		$advs = $this->getAdvertisements('delete');
		$focus = $this->getFocuses('delete');
		$infos = $this->getInformations('delete');
		$contracts = $this->getContracts('delete');
		return parent::deleteMark();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Business the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
