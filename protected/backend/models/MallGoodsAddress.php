<?php

/**
 * This is the model class for table "{{mall_goods_address}}".
 *
 * The followings are the available columns in table '{{mall_goods_address}}':
 * @property integer $id
 * @property string $mbaid
 * @property integer $mgid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class MallGoodsAddress extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mall_goods_address}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, mgid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('mbaid', 'length', 'max'=>100),
			array('creationtime, updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mbaid, mgid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'id' => '自增ID',
			'mbaid' => '取货地址',
			'mgid' => '商品编号',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('mbaid',$this->mbaid,true);
		$criteria->compare('mgid',$this->mgid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 获取商品所分配的商家地址信息
	 * @author panrj,zengp 2014-12-11
	 * @param int $mgid 商品id
	 * @return ar
	 */
	public static function getByMallGoodPk($mgid)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('mgid',$mgid);
		$criteria->compare('deleted',0);
		$criteria->order='creationtime desc';
		$data = self::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 获取商品已分配的商家地址信息的外键(mbaid)
	 * @author panrj,zengp 2014-12-11
	 * @param int $mgid 商品id
	 * @return ar
	 */
	public static function getGoodBusinessAddressPks($mgid)
	{
		$adds = self::getByMallGoodPk($mgid);
		$pks = array();
		foreach($adds as $val){
			$pks[] = $val->mbaid;
		}
		return $pks;
	}

	/**
	 * 删除商品分配的商家分店信息
	 * @author zengp 2014-12-11
	 * @param int $mgid 商品id
	 * @return ar
	 */
	public static function deleteMallGoodAddress($mgid)
	{	
		$criteria=new CDbCriteria;
		$criteria->compare('mgid',$mgid);
		$criteria->compare('deleted',0);
		self::model()->updateAll(array('deleted' => 1), $criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MallGoodsAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
