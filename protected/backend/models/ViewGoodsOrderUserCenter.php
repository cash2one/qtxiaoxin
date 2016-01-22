<?php

/**
 * This is the model class for table "view_goods_order_user_center".
 *
 * The followings are the available columns in table 'view_goods_order_user_center':
 * @property string $moid
 * @property integer $state
 * @property string $creationtime
 * @property string $userid
 * @property integer $mgid
 * @property string $mgname
 * @property integer $mgkid
 * @property integer $bid
 * @property string $bname
 * @property integer $point
 */
class ViewGoodsOrderUserCenter extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'view_goods_order_user_center';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('moid, userid', 'required'),
			array('state, mcaid, mgid, mgkid, bid, point, type, mgcid', 'numerical', 'integerOnly'=>true),
			array('moid, userid, bname', 'length', 'max'=>20),
			array('mgname', 'length', 'max'=>50),
			array('creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('moid, state, mcaid, creationtime, userid, mgid, mgname, mgkid, bid, bname, point, type, mgcid', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'moid' => '订单ID',
			'state' => '状态：0待确认；1待发货；2待收货；3已收货',
			'mcaid' => '邮寄地址',
			'creationtime' => '创建时间',
			'userid' => '用户ID',
			'mgid' => '商品',
			'mgname' => '商品名称',
			'mgkid' => '商品类型',
			'type' => '商品种类',
			'bid' => '商户ID',
			'bname' => '商户名称',
			'point' => '积分',
			'mgcid' => '虚拟卡号',
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

		$criteria->compare('moid',$this->moid,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('mgid',$this->mgid);
		$criteria->compare('mgname',$this->mgname,true);
		$criteria->compare('mgkid',$this->mgkid);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('bname',$this->bname,true);
		$criteria->compare('point',$this->point);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 订单列表分页数据
	 * panrj 2014-07-28
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageData($parms=array())
	{
		$result = array();
		$criteria = new CDbCriteria();
		if(isset($parms['moid']) && $parms['moid']!=''){
        	$criteria->compare('moid',$parms['moid'],true);
        }
        if(isset($parms['mobilephone']) && $parms['mobilephone']!=''){
        	$uids = Member::getUseridByMobile($parms['mobilephone']);
        	$criteria->compare('userid',$uids);
        }
        if(isset($parms['bid'])){
        	$criteria->compare('bid',$parms['bid']);
        }
        if(isset($parms['mgid'])){
        	$criteria->compare('mgid',$parms['mgid']);
        }
        if(isset($parms['state'])){
        	$criteria->compare('state',$parms['state']);
        }
		$criteria->order = 'state, creationtime DESC';     
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

	public function getState()
	{
		$stateArr = array(
			'0'=>'待确认',
			'1'=>'待发货',
			'2'=>'待收货',
			'3'=>'已收货',
		);
		return $stateArr[$this->state];
	}

	public function getOprate()
	{
		if($this->type)
			return '查看';
		$stateArr = array(
			'0'=>'确认',
			'1'=>'发货',
			'2'=>'收货',
			'3'=>'查看',
		);
		return $stateArr[$this->state];
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewGoodsOrderUserCenter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
