<?php

/**
 * This is the model class for table "{{contract_infomation_relation}}".
 *
 * The followings are the available columns in table '{{contract_infomation_relation}}':
 * @property integer $cirid
 * @property integer $cid
 * @property integer $iid
 * @property string $startdate
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Information $i
 * @property Contract $c
 */
class ContractInfomationRelation extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contract_infomation_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('iid, startdate', 'required'),
			array('cid, iid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cirid, cid, iid, startdate, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'i' => array(self::BELONGS_TO, 'Information', 'iid'),
			'c' => array(self::BELONGS_TO, 'Contract', 'cid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cirid' => '关系ID',
			'cid' => '合同',
			'iid' => '资讯',
			'startdate' => '开始时间',
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

		$criteria->compare('cirid',$this->cirid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('iid',$this->iid);
		$criteria->compare('startdate',$this->startdate,true);
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
	 * @return ContractInfomationRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
