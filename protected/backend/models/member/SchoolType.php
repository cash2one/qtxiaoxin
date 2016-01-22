<?php

/**
 * This is the model class for table "{{school_type}}".
 *
 * The followings are the available columns in table '{{school_type}}':
 * @property integer $stid
 * @property string $name
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class SchoolType extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{school_type}}';
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
			array('name', 'length', 'max'=>10),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('stid, name, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'stid' => '类型ID',
			'name' => '类型名称',
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

		$criteria->compare('stid',$this->stid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getSchoolTypeData()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('deleted',0);
		$data = self::model()->findAll($criteria);
		return $data;
	}

	public static function getSchoolTypeArr()
	{
		$data = self::getSchoolTypeData();
		$arr = array();
		foreach($data as $d){
			$arr[$d->stid] = $d->name;
		}
		return $arr;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SchoolType the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
