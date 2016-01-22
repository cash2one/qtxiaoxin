<?php

/**
 * This is the model class for table "{{mall_goods_card}}".
 *
 * The followings are the available columns in table '{{mall_goods_card}}':
 * @property integer $mgcid
 * @property integer $mgid
 * @property string $number
 * @property string $starttime
 * @property string $endtime
 * @property integer $sold
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property MallGoods $mg
 * @property MallOrdersGoodsRelation[] $mallOrdersGoodsRelations
 */
class MallGoodsCard extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mall_goods_card}}';
	}

	public $bid;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mgid, number', 'required'),
			array('mgid, sold, state, deleted', 'numerical', 'integerOnly'=>true),
			array('number', 'length', 'max'=>20),
			array('starttime, endtime, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mgcid, mgid, number, starttime, endtime, sold, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'mg' => array(self::BELONGS_TO, 'MallGoods', 'mgid'),
			'mallOrdersGoodsRelations' => array(self::HAS_MANY, 'MallOrdersGoodsRelation', 'mgcid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mgcid' => '虚拟卡ID',
			'mgid' => '所属商品',
			'number' => '卡号',
			'starttime' => '有效起始时间',
			'endtime' => '有效结束时间',
			'sold' => '售出状态：0未售出；1已售出',
			'state' => '使用状态：0未使用；1已使用',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除：0未删除；1已删除',
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

		$criteria->compare('mgcid',$this->mgcid);
		$criteria->compare('mgid',$this->mgid);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('starttime',$this->starttime,true);
		$criteria->compare('endtime',$this->endtime,true);
		$criteria->compare('sold',$this->sold);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 虚拟卡列表分页数据
	 * panrj 2014-06-13
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageData($parms=array(),$ty='')
	{
		$result = array();
		$criteria = new CDbCriteria();
		// if($ty=='business'){
		// 	$bids = BusinessUserRelation::getUserBusinessPkArr();
		// 	$bids = $bids?$bids:-1;
		// 	$criteria->with = array('mg');
		// 	$criteria->compare('mg.bid',$bids);
		// 	$criteria->compare('mg.deleted',0);
		// }
		if(isset($parms['sold'])){
        	$criteria->compare('sold',$parms['sold']);
        }
        if(isset($parms['state'])){
        	$criteria->compare('t.state',$parms['state']);
        }
        if(isset($parms['number']) && $parms['number']!=''){
        	$criteria->compare('t.number',$parms['number']);
        }
        if(isset($parms['mgid']) && $parms['mgid']){
        	$criteria->compare('t.mgid',$parms['mgid']);
        }
		if(isset($parms['bid']) && $parms['bid']){
        	$criteria->with = array('mg');
			$criteria->compare('mg.bid',$parms['bid']);
			$criteria->compare('mg.deleted',0);
        }
        if(isset($parms['eff']) && $parms['eff']=='y'){
        	$dt = date('Y-m-d H:i:s',time());
        	$criteria->compare('t.starttime',' <'.$dt);
        	$criteria->compare('t.endtime','>'.$dt);
        }
        if(isset($parms['eff']) && $parms['eff']=='n'){
         	$dt = date('Y-m-d H:i:s',time());
         	$criteria->addCondition('t.starttime>="'.$dt.'" OR t.endtime<="'.$dt.'"');
        }
        $criteria->compare( 't.deleted', 0 );
		$criteria->order = 't.creationtime DESC';     
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

	public static function countCardNumber($mgid,$num,$mgcid)
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('mgid',$mgid);
        $criteria->compare('number',$num);
        if($mgcid)
        	$criteria->addCondition('mgcid!='.$mgcid);
        $criteria->compare( 'deleted', 0);
        $count = self::model()->count($criteria); 
        return $count;
	}

	/**
	 * 虚拟卡售出状态字典
	 * panrj 2014-06-13
	 * @return array $arr
	 */
	public static function getCardSoldArr()
	{
		$arr = array(
			'0'=>'未售出','1'=>'已售出'
		);
		return $arr;
	}

	/**
	 * 虚拟卡售出状态
	 * panrj 2014-06-13
	 * @return string $name
	 */
	public static function getCardSoldState($sold)
	{
		$arr = self::getCardSoldArr();
		return $arr[$sold];
	}

	/**
	 * 虚拟卡售出状态字典
	 * panrj 2014-06-13
	 * @return array $arr
	 */
	public static function getCardStateArr()
	{
		$arr = array(
			'0'=>'未使用','1'=>'已使用'
		);
		return $arr;
	}

	/**
	 * 虚拟卡售出状态
	 * panrj 2014-06-13
	 * @return string $name
	 */
	public static function getCardStateName($state)
	{
		$arr = self::getCardStateArr();
		return $arr[$state];
	}

	/**
	 * 虚拟卡是否过期
	 * panrj 2014-06-13
	 * @return bool 
	 */
	public function checkCardEff()
	{
		$d = date('Y-m-d H:i:s',time());
		$s = $this->starttime;
		$e = $this->endtime;
		if(strtotime($s)<strtotime($d) && strtotime($d)<strtotime($e))
			return true;
		return false;
	}

	/**
	 * 根据商品ID获取一个虚拟卡
	 * panrj 2014-12-18
	 * @return bool 
	 */
	public static function getCardByMgid($mgid)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('mgid',$mgid);
		$criteria->compare('sold',0);
		$criteria->compare('state',0);
    	$dt = date('Y-m-d H:i:s',time());
    	$criteria->compare('starttime','<'.$dt);
    	$criteria->compare('endtime','>'.$dt);
    	// $criteria->order="rand()";
		$data = self::model()->find($criteria);
		if(!$data){
			$data=new MallGoodsCard;
			$data->mgid = $mgid;
			$data->endtime = date("Y-m-d H:i:s",strtotime("30 day"));
			$data->starttime = date("Y-m-d H:i:s",time());
			$r1 = rand(0,999);
			$time = explode (" ", microtime()); 
			$t = $time[0]*1000*1000;
			$r2 = (int)$t;
			
			$hash = $r1.$r2.$mgid;
			$code = MainHelper::enid($hash);
			$data->number = $code;
			$data->save();
		}
		return $data;
	}

	/**
	 * 根据主键查询虚拟卡号
	 * panrj 2014-07-31
	 * @return string
	 */
	public static function getCardNumberByPk($mgcid)
	{
		$card = self::model()->findByPk($mgcid);
		return $card?$card->number:'';
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MallGoodsCard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 扩展beforeSave方法,用来同步商品库存
	 * panrj 2014-06-23
	 */
	public function beforeSave()
	{
		if($this->isNewRecord){
			$mg = $this->mg;
			$mg->number += 1;
			$mg->save();
		}
		//删除或出售
		if(!$this->isNewRecord && ($this->deleted || $this->sold)){
			$mg = $this->mg;
			if($mg->number>0){
				$mg->number -= 1;
				$mg->save();
			}
		}
		if($this->hasEventHandler('onBeforeSave'))
		{
			$event=new CModelEvent($this);
			$this->onBeforeSave($event);
			return $event->isValid;
		}
		return parent::beforeSave();
	}
}
