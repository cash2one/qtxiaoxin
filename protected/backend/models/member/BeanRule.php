<?php

/**
 * This is the model class for table "{{bean_rule}}".
 *
 * The followings are the available columns in table '{{bean_rule}}':
 * @property integer $ruleid
 * @property integer $type
 * @property string $name
 * @property string $content
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class BeanRule extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bean_rule}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ruleid, type, name, content, creationtime', 'required'),
			array('ruleid, type, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('content', 'length', 'max'=>150),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ruleid, type, name, content, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'ruleid' => '规则编号',
			'type' => '规则类型(1.独立;2.活动;3.日常;4.限定)',
			'name' => '规则的描述说明',
			'content' => '规则的内容（JSON格式，每种类型不同）',
			'creationtime' => '规则创建时间',
			'updatetime' => '更新时间',
			'deleted' => '规则是否已经删除',
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

		$criteria->compare('ruleid',$this->ruleid);
		$criteria->compare('type',$this->type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getRuleByPks($pks)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('ruleid',$pks);
        return self::model()->findAll($criteria);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BeanRule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
