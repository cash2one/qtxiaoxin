<?php

/**
 * This is the model class for table "{{point_relation}}".
 *
 * The followings are the available columns in table '{{point_relation}}':
 * @property integer $piid
 * @property string $target
 * @property integer $tid
 * @property integer $point
 */
class PointRelation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{point_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('target, tid, point', 'required'),
			array('tid, point', 'numerical', 'integerOnly'=>true),
			array('target', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('prid, target, tid, point', 'safe', 'on'=>'search'),
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
			'prid' => '关系ID',
			'target' => '目标',
			'tid' => '目标ID',
			'point' => '积分',
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

		$criteria->compare('prid',$this->piid);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('tid',$this->tid);
		$criteria->compare('point',$this->point);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getOrCreate($target,$tid)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('target',$target);
		$criteria->compare('tid',$tid);
		$data = self::model()->find($criteria);
		if($data){
			return $data;
		}else{
			$new = new PointRelation;
			$new->target = $target;
			$new->tid = $tid;
			$new->save();
			return $new;
		}
	}

	public static function getRelationPoint($target,$tid)
	{
		$relation = self::getOrCreate($target,$tid);
		return $relation->point;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PointRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
