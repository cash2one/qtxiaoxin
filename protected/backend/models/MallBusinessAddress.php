<?php

/**
 * This is the model class for table "{{mall_business_address}}".
 *
 * The followings are the available columns in table '{{mall_business_address}}':
 * @property integer $mbaid
 * @property string $address
 * @property string $phone
 * @property integer $bid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property string $name
 */
class MallBusinessAddress extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mall_business_address}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mbaid, bid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('address', 'length', 'max'=>100),
			array('phone', 'length', 'max'=>20),
			array('name', 'length', 'max'=>50),
			array('creationtime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mbaid, address, phone, bid, state, creationtime, updatetime, deleted, name', 'safe', 'on'=>'search'),
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
			'mbaid' => '取货地址ID',
			'address' => '取货地址',
			'phone' => '联系电话',
			'bid' => '商户编号',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'name' => '分店名称',
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

		$criteria->compare('mbaid',$this->mbaid);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 获取商家地址信息
	 * @author zengp 2014-12-12
	 * @param int $bid 商家id
	 * @return ar
	 */
	public static function getByBusinessPk($bid)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('bid',$bid);
		$criteria->compare('deleted',0);
		$criteria->order='creationtime desc';
		$data = self::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 根据商品已分配的商家地址id(mbaid)获取商家bid
	 * @author zengp 2014-12-12
	 * @param int $mbaid 商品地址id
	 * @return ar
	 */
	public static function getBuAddrIdByMgAddrId($mbaid){

		return self::model()->findByPk($mbaid);
	}


	/**
	 * 根据商品已分配分店信息（mbaid）获取商家地址信息
	 * @author zengp 2014-12-12
	 * @param array $mbaids 商品地址ids(已分配给当前产品的商家地址id)
	 * @return ar
	 */
	public static function getByMbaids($mbaids){

		$criteria=new CDbCriteria;
		$criteria->compare('mbaid',$mbaids);
		$criteria->compare('deleted',0);
		$criteria->order='creationtime desc';
		$data = self::model()->findAll($criteria);
		return $data;

	}

	/**
	 * 删除商家地址信息
	 * @author panrj,zengp 2014-12-11
	 * @param $bid 商家id
	 */
	public static function deleteBusinessAddress($bid)
	{	
		$criteria=new CDbCriteria;
		$criteria->compare('bid',$bid);
		$criteria->compare('deleted',0);
		self::model()->updateAll(array('deleted' => 1), $criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MallBusinessAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
