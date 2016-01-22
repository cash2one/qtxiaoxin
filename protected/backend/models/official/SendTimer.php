<?php

/**
 * This is the model class for table "{{send_timer}}".
 *
 * The followings are the available columns in table '{{send_timer}}':
 * @property string $stid
 * @property integer $infoid
 * @property integer $msgid
 * @property integer $deleted
 * @property integer $forward
 * @property integer $close
 * @property string $sendtime
 * @property string $updatetime
 * @property string $creationtime
 */
class SendTimer extends OfficialActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{send_timer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('infoid, msgid', 'required'),
			array('infoid, msgid, deleted, forward, close', 'numerical', 'integerOnly'=>true),
			array('sendtime, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('stid, infoid, msgid, deleted, forward, close, sendtime, updatetime, creationtime', 'safe', 'on'=>'search'),
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
			'stid' => 'Stid',
			'infoid' => 'Infoid',
			'msgid' => 'Msgid',
			'deleted' => 'Deleted',
			'forward' => 'Forward',
			'close' => 'Close',
			'sendtime' => 'Sendtime',
			'updatetime' => 'Updatetime',
			'creationtime' => 'Creationtime',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SendTimer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
