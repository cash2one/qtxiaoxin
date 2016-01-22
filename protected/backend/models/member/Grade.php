<?php

/**
 * This is the model class for table "{{grade}}".
 *
 * The followings are the available columns in table '{{grade}}':
 * @property integer $gid
 * @property string $name
 * @property integer $age
 * @property integer $stid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class Grade extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{grade}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gid, name, age, stid, creationtime', 'required'),
			array('gid, age, stid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>10),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('gid, name, age, stid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'gid' => '年级ID',
			'name' => '年级',
			'age' => '当前年份与入学年份之间的差值',
			'stid' => '类型',
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

		$criteria->compare('gid',$this->gid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('stid',$this->stid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getGradeData($parms=array())
	{
		$criteria=new CDbCriteria;
		if(isset($parms['stid']) && $parms['stid']){
			$criteria->compare('stid',$parms['stid']);
		}
		$criteria->compare('deleted',0);
		$data = self::model()->findAll($criteria);
		return $data;
	}

    public static function getGradeDataByName($name)
    {
        $criteria=new CDbCriteria;
        $criteria->compare('name',$name);
        $criteria->compare('deleted',0);
        $criteria->compare('state',1);
        $data = self::model()->find($criteria);
        return $data;
    }
	public static function getGradeArr($parms=array())
	{
		$data = self::getGradeData($parms);
		$arr = array();
		foreach($data as $d){
			$arr[$d->gid] = $d->name;
		}
		return $arr;
	}

	public static function getGradeName($gid)
	{
		$school = Self::model()->findByPk($gid);
		return $school->name;
	}

    public static function getGradeInfo($parms=array())
    {
        $criteria=new CDbCriteria;
        if(isset($parms['stid']) && $parms['stid']){
            $criteria->compare('stid',$parms['stid']);
        }
        if(isset($parms['age']) && $parms['age']){
            $criteria->compare('age',$parms['age']);
        }
        $criteria->compare('deleted',0);
        $data = self::model()->find($criteria);
        return $data;
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Grade the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
