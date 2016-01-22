<?php

/**
 * This is the model class for table "{{teacher_ext}}".
 *
 * The followings are the available columns in table '{{teacher_ext}}':
 * @property string $userid
 * @property string $teacherid
 * @property string $teacherinfo
 * @property string $faceurl
 * @property string $subjects
 * @property string $address
 * @property string $info
 * @property string $duties
 * @property string $activatedate
 *
 * The followings are the available model relations:
 * @property User $user
 */
class TeacherExt extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{teacher_ext}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid', 'required'),
			array('userid, duties', 'length', 'max'=>20),
			array('teacherid, faceurl', 'length', 'max'=>64),
			array('subjects', 'length', 'max'=>128),
			array('address', 'length', 'max'=>256),
			array('teacherinfo, info, activatedate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('userid, teacherid, teacherinfo, faceurl, subjects, address, info, duties, activatedate', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userid' => '用户ID',
			'teacherid' => '教师ID',
			'teacherinfo' => '教师介绍',
			'faceurl' => '身份照片URL',
			'subjects' => '任教科目ID.用","分隔',
			'address' => '家庭地址',
			'info' => '个人介绍',
			'duties' => '职务',
			'activatedate' => '老师激活日期',
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

		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('teacherid',$this->teacherid,true);
		$criteria->compare('teacherinfo',$this->teacherinfo,true);
		$criteria->compare('faceurl',$this->faceurl,true);
		$criteria->compare('subjects',$this->subjects,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('info',$this->info,true);
		$criteria->compare('duties',$this->duties,true);
		$criteria->compare('activatedate',$this->activatedate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TeacherExt the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
