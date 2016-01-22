<?php

/**
 * This is the model class for table "{{mall_goods}}".
 *
 * The followings are the available columns in table '{{mall_goods}}':
 * @property integer $mgid
 * @property string $name
 * @property string $summery
 * @property string $image
 * @property string $bigimage
 * @property string $remark
 * @property string $package
 * @property string $guide
 * @property integer $bid
 * @property integer $uid
 * @property integer $mgkid
 * @property integer $type
 * @property integer $number
 * @property integer $integration
 * @property double $price
 * @property double $marketprice
 * @property integer $hot
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property integer $total
 * @property double $discount
 * @property integer $sale
 * @property string $starttime
 * @property string $endtime
 * @property double $salediscount
 * @property integer $salenumber
 *
 * The followings are the available model relations:
 * @property Business $b
 * @property MallGoodsKind $mgk
 * @property User $u
 * @property MallGoodsCard[] $mallGoodsCards
 * @property MallOrdersGoodsRelation[] $mallOrdersGoodsRelations
 */
class MallGoods extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mall_goods}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, summery, image, bid, uid, mgkid, type, integration', 'required'),
			array('bid, uid, mgkid, type, number, integration, hot, state, deleted, total, sale, salenumber, sort, quotas, subtype', 'numerical', 'integerOnly'=>true),
			array('price, marketprice, discount, salediscount,visible', 'numerical'),
			array('name', 'length', 'max'=>50),
			array('image', 'length', 'max'=>100),
			array('summery', 'length', 'max'=>30),
			array('bigimage, remark, package, guide, updatetime, starttime, endtime, creationtime, mallstarttime, mallendtime, range, condition, quotas', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mgid, name, summery, image, bigimage, remark, package, guide, bid, uid, mgkid, type, number, integration, price, marketprice, hot, state, creationtime, updatetime, deleted, total, discount, sale, starttime, endtime, salediscount, salenumber, sort, range, condition, quotas', 'safe', 'on'=>'search'),
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
			'mgk' => array(self::BELONGS_TO, 'MallGoodsKind', 'mgkid'),
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
			'mallGoodsCards' => array(self::HAS_MANY, 'MallGoodsCard', 'mgid'),
			'mallOrdersGoodsRelations' => array(self::HAS_MANY, 'MallOrdersGoodsRelation', 'mgid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mgid' => '商品ID',
			'name' => '商品名称',
			'summery' => '摘要',
			'image' => '图片',
			'bigimage' => '商品大图',
			'remark' => '商品描述',
			'package' => '套餐说明',
			'guide' => '兑换指引',
			'bid' => '所属商家',
			'uid' => '创建者',
			'mgkid' => '商品种类',
			'type' => '商品类型',
			'number' => '库存',
			'integration' => '花费积分',
			'price' => '价格',
			'marketprice' => '市场价格',
			'hot' => '推荐',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除',
			'total' => '兑换人次',
			'discount' => '折扣',
			'sale' => '特卖状态',
			'starttime' => '特卖开售时间',
			'endtime' => '特卖停售时间',
			'salediscount' => '特卖折扣',
			'sort' => '推荐排序编号',
			'salenumber' => '特卖数量',
			'mallstarttime' => '商品上架时间',
			'mallendtime' => '商品下架时间',
			'range' => '区域',
			'condition' => '协议',
			'visible' => '可见范围',
			'quotas' => '限额:0无限制',
			'subtype' => '商品子类型',
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

		$criteria->compare('mgid',$this->mgid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('summery',$this->summery,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('bigimage',$this->bigimage,true);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('package',$this->package,true);
		$criteria->compare('guide',$this->guide,true);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('mgkid',$this->mgkid);
		$criteria->compare('type',$this->type);
		$criteria->compare('number',$this->number);
		$criteria->compare('integration',$this->integration);
		$criteria->compare('price',$this->price);
		$criteria->compare('marketprice',$this->marketprice);
		$criteria->compare('hot',$this->hot);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('total',$this->total);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('sale',$this->sale);
		$criteria->compare('starttime',$this->starttime,true);
		$criteria->compare('endtime',$this->endtime,true);
		$criteria->compare('salediscount',$this->salediscount);
		$criteria->compare('salenumber',$this->salenumber);
		$criteria->compare('quotas',$this->quotas);
		$criteria->compare('subtype',$this->subtype);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 商品列表分页数据
	 * panrj 2014-06-12
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageData($parms=array())
	{
		$result = array();
		$criteria = new CDbCriteria();
		if(isset($parms['name']) && $parms['name']!=''){
        	$criteria->compare('t.name',$parms['name'],true);
        }
        if(isset($parms['type'])){
        	$criteria->compare('t.type',$parms['type']);
        }
        if(isset($parms['state'])){
        	$criteria->compare('t.state',$parms['state']);
        }
        if(isset($parms['bid']) && $parms['bid']){
        	$criteria->compare('t.bid',$parms['bid']);
        }
        if(isset($parms['mgkid']) && $parms['mgkid']){
        	$criteria->compare('t.mgkid',$parms['mgkid']);
        }

        $criteria->compare( 't.deleted', 0 );  
        //begin add by panrj 2014-07-26 过滤已删除商家的商品
		$criteria->with = array('b');
		$criteria->compare('b.deleted',0);
		//end add by panrj 2014-07-26
		$criteria->order = 't.sort DESC, t.creationtime DESC';     
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
	 * 商品类型字典
	 * panrj 2014-06-13
	 * @return array $arr
	 */
	public static function getGoodTypeArr()
	{
		$arr = array(
			'0'=>'实物','1'=>'虚拟'
		);
		return $arr;
	}

	/**
	 * 商品子类型字典
	 * panrj 2014-12-10
	 * @return array $arr
	 */
	public static function getSubGoodTypeArr()
	{
		$arr = array(
			'0'=>'消费类','1'=>'取货类'
		);
		return $arr;
	}

	/**
	 * 商品类型名称
	 * panrj 2014-06-13
	 * @return string $name
	 */
	public static function getGoodTypeName($type)
	{
		$arr = self::getGoodTypeArr();
		return $arr[$type];
	}

	/**
	 * 获取商品大图数组
	 * panrj 2014-06-13
	 * @return string $arr
	 */
	public function getGoodBigImages()
	{
		$bigimg = $this->bigimage;
		if($bigimg){
			return json_decode($bigimg,true);
		}else{
			return array();
		}
	}

	/**
	 * 返回商品种类名称
	 * panrj 2014-06-13
	 * @return string $name
	 */
	public static function getMallGoodsName($mgid,$ty='')
	{
		$mg = self::model()->findByPk($mgid);
		if(!$mg->deleted){
			if($ty=='card' && $mg->type==0){
				return $mg->name.'(实物)';
			}else{
				return $mg->name;
			}
		}else{
			return $mg->name.'(已删除)';
		}
	}

	/**
	 * 返回商品键值数组
	 * panrj 2014-06-13
	 * @return array $arr 
	 */
	public static function getDataArr($ty='')
	{
		$criteria = new CDbCriteria();
		if($ty=='card'){
			$criteria->compare('type',1);
		}
		$criteria->scopes='normal';
		$criteria->order = 'name';
		$data = self::model()->findAll($criteria);
		$arr = array();
		foreach($data as $d){
			$arr[$d->mgid] = $d->name;
		}
		return $arr;
	}

	public function getDisableState($reverse=false)
	{
		$arr = array('1'=>'上架','0'=>'下架');
		if($reverse){
    		$state = $this->state==1 ? 0 : 1;
    		return $arr[$state];
    	}else{
    		return $arr[$this->state];
    	}
	}

	/**
	 * 返回商品虚拟卡数量
	 * panrj 2014-06-13
	 * @return array $arr 
	 */
	public function countGoodsCards($eff=false)
	{
		if($this->mgid && $this->type==1){
			$criteria = new CDbCriteria();
			$criteria->compare('mgid',$this->mgid);
			if($eff){
				$dt = date('Y-m-d H:i:s',time());
	        	$criteria->compare('starttime','<'.$dt);
	        	$criteria->compare('endtime','>'.$dt);
			}
			$criteria->scopes='normal';
			$count = MallGoodsCard::model()->count($criteria);
			return $count;
		}else{
			return 0;
		}
	}
	
	public static function countGoodsName($bid,$name,$mgid='')
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('bid',$bid);
        $criteria->compare('name',$name);
        if($mgid)
        	$criteria->addCondition('mgid!='.$mgid);
        $criteria->compare( 'deleted', 0);
        $count = self::model()->count($criteria); 
        return $count;
	}

	/**
	 * 查询商品日志记录
	 * panrj 2014-07-09
	 * @param string $action 日志记录动作
	 * @return queryset $data 
	 */
	public function getClientLogData($action='Browse')
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('tid',$this->mgid);
        $criteria->compare('target','Mall',true);
        $criteria->compare('action',$action,true);
        $data = ClientLogSchoolRelation::model()->findAll($criteria); 
        return $data;
	}

	/**
	 *返回商品可见字段数组
	 * panrj 2014-11-18
	 * @return array $data 
	 */
	public static function getVisibleArr()
	{
		$data = array(
			'1'=> '老师家长均可见',
			'2'=> '老师可见',
			'3'=> '家长可见',
			'4'=> '圣诞活动',
			'5'=> '祝福语',
		);
        return $data;
	}

	/**
	 * 返回商品浏览量
	 * panrj 2014-07-09
	 * @return int
	 */
	public function countBrowse()
	{
		$data = $this->getClientLogData('Browse');
        return count($data);
	}
	
	/**
	 * 返回商品浏览量
	 * panrj 2014-07-09
	 * @return int
	 */
	public function showStockWarring()
	{
		if($this->type==1){
		    $num = $this->countGoodsCards(true);
			return $num<=10;
		}else{
		    return $this->number<=10;
		}
        return true;
	}

	/**
	 * 返回商品评价数
	 * panrj 2014-07-09
	 * @return int
	 */
	public function countComment()
	{
		$data = $this->getClientLogData('Comment');
        return count($data);
	}

	/**
	 * 返回商品兑换数
	 * panrj 2014-07-09
	 * @return int
	 */
	public function countBuy()
	{
		$data = $this->getClientLogData('Buy');
        return count($data);
	}

	/**
	 * 返回每日统计数据
	 * panrj 2014-07-09
	 * @return queryset
	 */
	public function getDailyLog($parms=array())
	{
		// $sql = "SELECT DATE_FORMAT( `creationtime`, '%Y-%m-%d') `date` , COUNT(IF(`action`='Buy',TRUE,NULL)) `buy`, COUNT(IF(`action`='Browse',TRUE,NULL)) `browse`, COUNT(IF(`action`='Comment',TRUE,NULL)) `commemt` FROM `tb_client_log_school_relation` WHERE `target`='Mall' GROUP BY DATE_FORMAT( `creationtime`, '%Y-%m-%d')";
		// $data = $this->getClientLogData('Buy');
		$date = date('Y-m-d',time()).' 00:00:00';
        $criteria = new CDbCriteria();
        $criteria->select = "DATE_FORMAT( `creationtime`, '%Y-%m-%d') `date` , COUNT(IF(`action`='Buy',TRUE,NULL)) `buy`, COUNT(IF(`action`='Browse',TRUE,NULL)) `browse`, COUNT(IF(`action`='Comment',TRUE,NULL)) `commemt`";
        $criteria->compare('target','Mall',true);
        $criteria->compare('tid',$this->mgid);
        if(isset($parms['sdate']) && $parms['sdate']){
        	$sdate = $parms['sdate'].' 00:00:00';
        	$criteria->compare('creationtime','>='.$sdate);
        }
        if(isset($parms['edate']) && $parms['edate']){
        	$edate = $parms['edate'].' 23:59:59';
        	$criteria->compare('creationtime','<='.$edate);
        }
        // $criteria->compare("creationtime","<".$date);
        $criteria->group = "DATE_FORMAT( `creationtime`, '%Y-%m-%d')";
        $criteria->order = 'date DESC' ;
        $data = ClientLogSchoolRelation::model()->findAll($criteria); 
        return $data;
	}

	/**
    * panrj 2014-12-18
    * 获取祝福语商品ID
    * @return array
    */
	public static function getWishPrizeMgids()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('visible',5);
		$criteria->compare('number','>0');
		$criteria->compare('deleted',0);
		$records = self::model()->findAll($criteria);
		$pks = array();
		foreach($records as $r){
			$pks[] = $r->mgid;
		}
		return $pks;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MallGoods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
