<?php

/**
 * This is the model class for table "{{duty}}".
 *
 * The followings are the available columns in table '{{duty}}':
 * @property integer $dutyid
 * @property string $name
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property integer $isseeallclass
 */
class Duty extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{duty}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('state, deleted, isseeallclass', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('dutyid, name, state, creationtime, updatetime, deleted, isseeallclass', 'safe', 'on'=>'search'),
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
			'dutyid' => 'Dutyid',
			'name' => 'Name',
			'state' => 'State',
			'creationtime' => 'Creationtime',
			'updatetime' => 'Updatetime',
			'deleted' => 'Deleted',
			'isseeallclass' => 'Isseeallclass',
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

		$criteria->compare('dutyid',$this->dutyid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('isseeallclass',$this->isseeallclass);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    //职务管理列表
    public static  function getDutyByName($name)
    {
        $result = array();
        $criteria = new CDbCriteria();
        $criteria->compare('name',$name);
        $criteria->compare('deleted',0);
        $criteria->compare('state',1);
        $result = self::model()->find($criteria);
        return $result;
    }
    //职务管理列表
    public static  function getDutyList()
    {
        $result = array();
        $criteria = new CDbCriteria();
        $criteria->compare('deleted',0);
        $criteria->compare('state',1);
        $result = self::model()->findAll($criteria);
        return $result;
    }
    
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Duty the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
