<?php

/**
 * This is the model class for table "{{log_new}}".
 *
 * The followings are the available columns in table '{{log_new}}':
 * @property integer $lid
 * @property string $action
 * @property integer $uid
 * @property string $table
 * @property integer $objectid
 * @property string $field
 * @property string $newdata
 * @property string $olddata
 * @property string $creationtime
 * @property integer $platform
 * @property integer $deleted
 * @property string $ip
 */
class LogNew extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{log_new}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('action, uid, table, objectid', 'required'),
			array('uid, objectid, platform, deleted', 'numerical', 'integerOnly'=>true),
			array('action, table', 'length', 'max'=>50),
			array('field', 'length', 'max'=>45),
			array('creationtime, ip', 'length', 'max'=>20),
			array('newdata, olddata, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('lid, action, uid, table, objectid, field, newdata, olddata, creationtime, platform, deleted, ip', 'safe', 'on'=>'search'),
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
			'lid' => '日志ID',
			'action' => '动作',
			'uid' => '用户',
			'table' => '操作表',
			'objectid' => '操作对象id',
			'field' => '操作字段',
			'newdata' => '新数据',
			'olddata' => '旧数据',
			'creationtime' => '操作时间',
			'platform' => '0后台日志1前台日志',
			'deleted' => '已删除',
			'ip' => 'IP地址',
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

		$criteria->compare('lid',$this->lid);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('table',$this->table,true);
		$criteria->compare('objectid',$this->objectid);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('newdata',$this->newdata,true);
		$criteria->compare('olddata',$this->olddata,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('platform',$this->platform);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('ip',$this->ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogNew the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
