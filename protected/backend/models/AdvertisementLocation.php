<?php

/**
 * This is the model class for table "{{advertisement_location}}".
 *
 * The followings are the available columns in table '{{advertisement_location}}':
 * @property integer $alid
 * @property string $name
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property ContractAdvertisementRelation[] $contractAdvertisementRelations
 */
class AdvertisementLocation extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{advertisement_location}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, creationtime', 'required'),
			array('state, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('alid, name, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'contractAdvertisementRelations' => array(self::HAS_MANY, 'ContractAdvertisementRelation', 'alid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'alid' => '位置ID',
			'name' => '名称',
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

		$criteria->compare('alid',$this->alid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 提取广告位置数据
	 * panrj 2014-05-20
	 * @return array AdvertisementLocation 
	 */
	public static function getLoactionData()
	{
		$criteria=new CDbCriteria;
		$criteria->scopes='normal';
		$data = AdvertisementLocation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 广告位置数据转化为数组
	 * panrj 2014-05-20
	 * @return array $arr
	 */
	public static function getLoactionArr()
	{
		$data = self::getLoactionData();
		$arr = array();
		foreach($data as $d){
			$arr[$d->alid] = $d->name;
		}
		return $arr;
	}

	/**
	 * 广告位置主键获取广告位置名称
	 * panrj 2014-05-20
	 * @return array $arr
	 */
	public static function getLoactionNameById($id)
	{
		$location = self::model()->loadByPk($id);
		return $location->name;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AdvertisementLocation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
