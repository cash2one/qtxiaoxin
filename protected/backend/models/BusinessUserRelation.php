<?php

/**
 * This is the model class for table "{{business_user_relation}}".
 *
 * The followings are the available columns in table '{{business_user_relation}}':
 * @property integer $burid
 * @property integer $bid
 * @property integer $uid
 * @property integer $state
 * @property string $updatetime
 * @property string $creationtime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property User $u
 * @property Business $b
 */
class BusinessUserRelation extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{business_user_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bid, uid, creationtime', 'required'),
			array('bid, uid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('burid, bid, uid, state, updatetime, creationtime, deleted', 'safe', 'on'=>'search'),
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
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
			'b' => array(self::BELONGS_TO, 'Business', 'bid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'burid' => '关系ID',
			'bid' => '商家',
			'uid' => '用户',
			'state' => '状态',
			'updatetime' => '更新时间',
			'creationtime' => '创建时间',
			'deleted' => '删除',
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

		$criteria->compare('burid',$this->burid);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('state',$this->state);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getUserBusinessData()
	{
		$uid = Yii::app()->user->id;
		$criteria=new CDbCriteria;
		$criteria->compare('uid',$uid);
		$data = self::model()->findAll($criteria);
		return $data;
	}
	
	public static function getUserBusinessPkArr()
	{
		$data = self::getUserBusinessData();
		$arr = array();
		foreach($data as $d){
			array_push($arr,$d->bid);
		}
		return $arr;
	}
	
	public static function getUserBusinessArr($mall=false)
	{
		$data = self::getUserBusinessData();
		$arr = array();
		foreach($data as $d){
			if($mall){
				if($d->b->mall)
					$arr[$d->bid]=$d->b->name;
			}else{
				$arr[$d->bid]=$d->b->name;
			}
		}
		return $arr;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BusinessUserRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
