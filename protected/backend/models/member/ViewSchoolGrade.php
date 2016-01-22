<?php

/**
 * This is the model class for table "view_school_grade".
 *
 * The followings are the available columns in table 'view_school_grade':
 * @property string $sid
 * @property string $sname
 * @property integer $aid
 * @property integer $stid
 * @property integer $gid
 * @property string $gname
 * @property integer $age
 */
class ViewSchoolGrade extends MemberViewActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'view_school_grade';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sid, sname, aid, stid, gid, gname, age', 'required'),
			array('aid, stid, gid, age', 'numerical', 'integerOnly'=>true),
			array('sid, gname', 'length', 'max'=>10),
			array('sname', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('sid, sname, aid, stid, gid, gname, age', 'safe', 'on'=>'search'),
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
			'sid' => '学校ID',
			'sname' => '学校名称',
			'aid' => '地区',
			'stid' => '学校类型',
			'gid' => '年级ID',
			'gname' => '年级',
			'age' => '当前年份与入学年份之间的差值',
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

		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('sname',$this->sname,true);
		$criteria->compare('aid',$this->aid);
		$criteria->compare('stid',$this->stid);
		$criteria->compare('gid',$this->gid);
		$criteria->compare('gname',$this->gname,true);
		$criteria->compare('age',$this->age);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ViewSchoolGrade the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
