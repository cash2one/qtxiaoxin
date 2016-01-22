<?php

/**
 * This is the model class for table "{{mall_client_address}}".
 *
 * The followings are the available columns in table '{{mall_client_address}}':
 * @property integer $mcaid
 * @property string $address
 * @property string $contacter
 * @property string $phone
 * @property string $userid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property MallOrders[] $mallOrders
 */
class MallClientAddress extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mall_client_address}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address, contacter, phone, userid', 'required'),
			array('state, deleted', 'numerical', 'integerOnly'=>true),
			array('address', 'length', 'max'=>100),
			array('contacter, phone, userid', 'length', 'max'=>20),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mcaid, address, contacter, phone, userid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'mallOrders' => array(self::HAS_MANY, 'MallOrders', 'mcaid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mcaid' => '顾客地址ID',
			'address' => '邮寄地址',
			'contacter' => '联系人',
			'phone' => '联系电话',
			'userid' => '用户',
			'state' => '状态：0非默认；1默认',
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

		$criteria->compare('mcaid',$this->mcaid);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('contacter',$this->contacter,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MallClientAddress the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
