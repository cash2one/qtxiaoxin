<?php

/**
 * This is the model class for table "{{client}}".
 *
 * The followings are the available columns in table '{{client}}':
 * @property string $mobilephone
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property integer $userid
 * @property integer $vtid
 *
 * The followings are the available model relations:
 * @property VipType $vt
 * @property ClientLog[] $clientLogs
 * @property FocusAnswer[] $focusAnswers
 * @property InformationComment[] $informationComments
 * @property MallClientAddress[] $mallClientAddresses
 * @property MallOrders[] $mallOrders
 */
class Client extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{client}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mobilephone, creationtime, userid', 'required'),
			array('state, deleted, userid, vtid', 'numerical', 'integerOnly'=>true),
			array('mobilephone', 'length', 'max'=>20),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mobilephone, state, creationtime, updatetime, deleted, userid, vtid', 'safe', 'on'=>'search'),
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
			'vt' => array(self::BELONGS_TO, 'VipType', 'vtid'),
			'clientLogs' => array(self::HAS_MANY, 'ClientLog', 'mobilephone'),
			'focusAnswers' => array(self::HAS_MANY, 'FocusAnswer', 'mobilephone'),
			'informationComments' => array(self::HAS_MANY, 'InformationComment', 'mobilephone'),
			'mallClientAddresses' => array(self::HAS_MANY, 'MallClientAddress', 'mobilephone'),
			'mallOrders' => array(self::HAS_MANY, 'MallOrders', 'mobilephone'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mobilephone' => '注册手机',
			'state' => '状态（保留字段暂未启用）',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除：0未删除；1已删除',
			'userid' => '用户ID',
			'vtid' => 'vip类型',
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

		$criteria->compare('mobilephone',$this->mobilephone,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('userid',$this->userid);
		$criteria->compare('vtid',$this->vtid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
