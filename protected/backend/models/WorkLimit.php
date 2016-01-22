<?php

/**
 * This is the model class for table "{{work_limit}}".
 *
 * The followings are the available columns in table '{{work_limit}}':
 * @property string $id
 * @property string $userid
 * @property integer $onuserid
 * @property integer $deleted
 * @property string $updatetime
 * @property string $creationtime
 */
class WorkLimit extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{work_limit}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, onuserid', 'required'),
			array('onuserid, deleted', 'numerical', 'integerOnly'=>true),
			array('userid', 'length', 'max'=>10),
			array('updatetime, creationtime', 'safe')
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
			'id' => 'ID',
			'userid' => 'Userid',
			'onuserid' => 'Onuserid',
			'deleted' => 'Deleted',
			'updatetime' => 'Updatetime',
			'creationtime' => 'Creationtime',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WorkLimit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
