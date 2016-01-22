<?php

/**
 * This is the model class for table "{{mall_goods_kind}}".
 *
 * The followings are the available columns in table '{{mall_goods_kind}}':
 * @property integer $mgkid
 * @property string $name
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property MallGoods[] $mallGoods
 */
class MallGoodsKind extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mall_goods_kind}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, creationtime', 'required'),
			array('state, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mgkid, name, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'mallGoods' => array(self::HAS_MANY, 'MallGoods', 'mgkid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mgkid' => '商品种类ID',
			'name' => '种类名称',
			'state' => '状态（保留字段暂未启用）',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除：0未删除；1已删除',
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

		$criteria->compare('mgkid',$this->mgkid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 返回商户键值数组
	 * panrj 2014-05-20
	 * @return array $arr 
	 */
	public static function getDataArr()
	{
		$criteria = new CDbCriteria();
		$criteria->scopes='normal';
		$criteria->order = 'name';
		$data = self::model()->findAll($criteria);
		$arr = array();
		foreach($data as $d){
			$arr[$d->mgkid] = $d->name;
		}
		return $arr;
	}

	/**
	 * 返回商品种类名称
	 * panrj 2014-06-13
	 * @return string $name
	 */
	public static function getMallGoodsKindName($mgkid)
	{
		$mgk = self::model()->loadByPk($mgkid);
		return $mgk->name;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MallGoodsKind the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
