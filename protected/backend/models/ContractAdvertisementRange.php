<?php

/**
 * This is the model class for table "{{contract_advertisement_range}}".
 *
 * The followings are the available columns in table '{{contract_advertisement_range}}':
 * @property integer $careid
 * @property string $sid
 * @property integer $gid
 * @property integer $state
 * @property string $updatetime
 * @property string $creationtime
 * @property string $startdate
 * @property string $enddate
 * @property integer $deleted
 * @property integer $carid
 *
 * The followings are the available model relations:
 * @property ContractAdvertisementRelation $car
 * @property School $s
 * @property Grade $g
 */
class ContractAdvertisementRange extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contract_advertisement_range}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, gid, carid', 'required'),
			array('gid, state, deleted, carid', 'numerical', 'integerOnly'=>true),
			array('sid', 'length', 'max'=>10),
			array('updatetime, startdate, enddate, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('careid, sid, gid, state, updatetime, creationtime, startdate, enddate, deleted, carid', 'safe', 'on'=>'search'),
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
			'car' => array(self::BELONGS_TO, 'ContractAdvertisementRelation', 'carid'),
			's' => array(self::BELONGS_TO, 'School', 'sid'),
			'g' => array(self::BELONGS_TO, 'Grade', 'gid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'careid' => '关系ID',
			'sid' => '学校',
			'gid' => '年级',
			'state' => '状态',
			'updatetime' => '更新时间',
			'creationtime' => '创建时间',
			'startdate' => '开始时间',
			'enddate' => '结束时间',
			'deleted' => '已删除',
			'carid' => '合同广告关系ID',
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

		$criteria->compare('careid',$this->careid);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('gid',$this->gid);
		$criteria->compare('state',$this->state);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('carid',$this->carid);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContractAdvertisementRange the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
