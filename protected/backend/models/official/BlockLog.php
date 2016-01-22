<?php

/**
 * This is the model class for table "{{block_log}}".
 *
 * The followings are the available columns in table '{{block_log}}':
 * @property string $bid
 * @property string $infoid
 * @property integer $block
 * @property string $reason
 * @property string $creationtime
 */
class BlockLog extends OfficialActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{block_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('infoid, block, reason', 'required'),
			array('block', 'numerical', 'integerOnly'=>true),
			array('infoid', 'length', 'max'=>10),
			array('reason', 'length', 'max'=>600),
			array('creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bid, infoid, block, reason, creationtime', 'safe', 'on'=>'search'),
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
			'bid' => 'Bid',
			'infoid' => 'Infoid',
			'block' => 'Block',
			'reason' => 'Reason',
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

		$criteria->compare('bid',$this->bid,true);
		$criteria->compare('infoid',$this->infoid,true);
		$criteria->compare('block',$this->block);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('creationtime',$this->creationtime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BlockLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
