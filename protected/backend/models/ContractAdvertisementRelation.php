<?php

/**
 * This is the model class for table "{{contract_advertisement_relation}}".
 *
 * The followings are the available columns in table '{{contract_advertisement_relation}}':
 * @property integer $carid
 * @property integer $cid
 * @property integer $aid
 * @property integer $alid
 * @property integer $state
 * @property string $updatetime
 * @property string $creationtime
 * @property string $startdate
 * @property string $enddate
 * @property integer $deleted
 * @property integer $school
 * @property integer $person
 *
 * The followings are the available model relations:
 * @property ContractAdvertisementRange[] $contractAdvertisementRanges
 * @property AdvertisementLocation $al
 * @property Advertisement $a
 * @property Contract $c
 */
class ContractAdvertisementRelation extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contract_advertisement_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cid, aid, alid, school, person', 'required'),
			array('cid, aid, alid, state, deleted, school, person', 'numerical', 'integerOnly'=>true),
			array('updatetime, startdate, enddate, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('carid, cid, aid, alid, state, updatetime, creationtime, startdate, enddate, deleted, school, person', 'safe', 'on'=>'search'),
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
			'contractAdvertisementRanges' => array(self::HAS_MANY, 'ContractAdvertisementRange', 'carid'),
			'al' => array(self::BELONGS_TO, 'AdvertisementLocation', 'alid'),
			'a' => array(self::BELONGS_TO, 'Advertisement', 'aid'),
			'c' => array(self::BELONGS_TO, 'Contract', 'cid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'carid' => '关系ID',
			'cid' => '合同',
			'aid' => '广告',
			'alid' => '位置',
			'state' => '状态',
			'updatetime' => '更新时间',
			'creationtime' => '创建时间',
			'startdate' => '开始时间',
			'enddate' => '结束时间',
			'deleted' => '已删除',
			'school' => '覆盖学校数',
			'person' => '覆盖人数',
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

		$criteria->compare('carid',$this->carid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('aid',$this->aid);
		$criteria->compare('alid',$this->alid);
		$criteria->compare('state',$this->state);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('school',$this->school);
		$criteria->compare('person',$this->person);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 获取合同
	 * panrj 2014-05-21
	 * @return model $con 
	 */
	public function getContract()
	{
		$con = Contract::model()->loadByPk($this->cid);
		return $con;
	}

	/**
	 * 获取合同编号
	 * panrj 2014-05-21
	 * @return string $contractid 
	 */
	public function getContractid()
	{
		$con = $this->getContract();
		return $con->contractid;
	}

	public function getAdvRangeData()
	{
		$criteria=new CDbCriteria;
		$criteria->select = 'sid,gid,SUM(DATEDIFF(enddate,startdate)) state';  
		$criteria->compare('carid',$this->carid);
		$criteria->scopes='normal';
		$criteria->group = 'sid,gid';  
		$criteria->order = 'sid,gid';
		$data = ContractAdvertisementRange::model()->findAll($criteria);
		return $data;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContractAdvertisementRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
