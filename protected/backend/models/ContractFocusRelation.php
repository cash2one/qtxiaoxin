<?php

/**
 * This is the model class for table "{{contract_focus_relation}}".
 *
 * The followings are the available columns in table '{{contract_focus_relation}}':
 * @property integer $cfrid
 * @property integer $cid
 * @property integer $fid
 * @property string $startdate
 * @property string $enddate
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property integer $school
 * @property integer $person
 *
 * The followings are the available model relations:
 * @property ContractFocusRange[] $contractFocusRanges
 * @property Focus $f
 * @property Contract $c
 */
class ContractFocusRelation extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{contract_focus_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fid, school, person', 'required'),
			array('cid, fid, state, deleted, school, person', 'numerical', 'integerOnly'=>true),
			array('startdate, enddate, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('cfrid, cid, fid, startdate, enddate, state, creationtime, updatetime, deleted, school, person', 'safe', 'on'=>'search'),
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
			'contractFocusRanges' => array(self::HAS_MANY, 'ContractFocusRange', 'cfrid'),
			'f' => array(self::BELONGS_TO, 'Focus', 'fid'),
			'c' => array(self::BELONGS_TO, 'Contract', 'cid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cfrid' => '关系ID',
			'cid' => '合同',
			'fid' => '热点',
			'startdate' => '开始时间',
			'enddate' => '结束时间',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
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

		$criteria->compare('cfrid',$this->cfrid);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('fid',$this->fid);
		$criteria->compare('startdate',$this->startdate,true);
		$criteria->compare('enddate',$this->enddate,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('school',$this->school);
		$criteria->compare('person',$this->person);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getRelationRangeSchools()
	{
		$criteria=new CDbCriteria;
		$criteria->select = 'DISTINCT sid';  
		$criteria->compare('cfrid',$this->cfrid);
		$criteria->scopes='normal';
		$criteria->order = 'sid';
		$data = ContractFocusRange::model()->findAll($criteria);
		return $data;
	}

	public function getRelationRangeGrades()
	{
		$gids = array();
		$grades = array();
		$ranges = $this->contractFocusRanges;
		foreach($ranges as $r){
			if(!in_array($r->g->gid,$gids)){
				array_push($gids,$r->g->gid);
				array_push($grades,$r->g);
			}
		}
		return $grades;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ContractFocusRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
