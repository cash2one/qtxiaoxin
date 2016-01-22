<?php

/**
 * This is the model class for table "{{apply_try}}".
 *
 * The followings are the available columns in table '{{apply_try}}':
 * @property integer $id
 * @property string $schoolname
 * @property string $personname
 * @property string $mobile
 * @property string $job
 * @property string $address
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class ApplyTry extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{apply_try}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('schoolname,personname,mobile', 'required'),
			array('state, deleted', 'numerical', 'integerOnly'=>true),
			array('schoolname, address', 'length', 'max'=>100),
			array('personname, job', 'length', 'max'=>50),
			array('mobile', 'length', 'max'=>15),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, schoolname, personname, mobile, job, address, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'id' => '通知ID',
			'schoolname' => '申请学校名',
			'personname' => '联系人',
			'mobile' => '联系人电话',
			'job' => '联系人职务',
			'address' => '联系地址',
			'state' => '保留：暂未使用',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('schoolname',$this->schoolname,true);
		$criteria->compare('personname',$this->personname,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('job',$this->job,true);
		$criteria->compare('address',$this->address,true);
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
	 * @return ApplyTry the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
