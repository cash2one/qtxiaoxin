<?php

/**
 * This is the model class for table "{{manager}}".
 *
 * The followings are the available columns in table '{{manager}}':
 * @property string $mid
 * @property string $username
 * @property string $pwd
 * @property integer $deleted
 * @property string $updatetime
 * @property string $creationtime
 */
class Manager extends OfficialActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{manager}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, pwd', 'required'),
			array('deleted', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
			array('pwd', 'length', 'max'=>32),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mid, username, pwd, deleted, updatetime, creationtime', 'safe', 'on'=>'search'),
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
			'mid' => 'Mid',
			'username' => 'Username',
			'pwd' => 'Pwd',
			'deleted' => 'Deleted',
			'updatetime' => 'Updatetime',
			'creationtime' => 'Creationtime',
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

		$criteria->compare('mid',$this->mid,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('pwd',$this->pwd,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('creationtime',$this->creationtime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Manager the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
