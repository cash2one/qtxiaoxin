<?php

/**
 * This is the model class for table "{{activity_config}}".
 *
 * The followings are the available columns in table '{{activity_config}}':
 * @property integer $id
 * @property integer $mgid
 * @property string $date
 * @property double $chance
 * @property integer $total
 * @property integer $deal
 */
class ActivityConfig extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{activity_config}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, chance', 'required'),
			array('mgid, total, deal, type', 'numerical', 'integerOnly'=>true),
			array('chance', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mgid, date, chance, total, deal, type', 'safe', 'on'=>'search'),
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
			// 'mg' => array(self::BELONGS_TO, 'MallGoods', 'mgid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mgid' => '商品ID',
			'date' => '日期',
			'chance' => '概率',
			'total' => '每天奖品数',
			'deal' => '当天抽中奖品数',
			'type' => '类型'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('mgid',$this->mgid);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('chance',$this->chance);
		$criteria->compare('total',$this->total);
		$criteria->compare('deal',$this->deal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
    * panrj 2014-12-17
    * @param $userid 用户ID
    * 获取当前奖品信息
    * @return String
    */
	public static function getCurrentPrize($box_number,$mark=false)
	{
		// $criteria=new CDbCriteria;
		// $criteria->with = array('mg');
		// $criteria->compare('t.date',date('Y-m-d'));
		// $criteria->addCondition('t.deal<t.total');
		// $criteria->addCondition('mg.number>0');
		// $criteria->compare('mg.visible',4);
		// if($mark){
		// 	$criteria->compare('t.type',1);
		// }else{
		// 	$criteria->compare('t.type',0);
		// }
		// $records = self::model()->findAll($criteria);
		// $result = array();
		// foreach($records as $r){
		// 	$num = $r->total-$r->deal;
		// 	for($i=0;$i<$num;$i++){
		// 		$result[] = $r->mgid;
		// 	}
		// }
		// shuffle($result);
		// return $result;

		if($mark){
			$type = 1;
		}else{
			$type = 0;
		}
		// Yii::app()->db->createCommand("LOCK TABLE `tb_activity_config` WRITE")->execute();
		// $criteria=new CDbCriteria;
		// $criteria->addCondition('number>0');
		// $criteria->compare('visible',4);
		// $goods = MallGoods::model()->findAll($criteria);
		// $pks = array();
		// foreach($goods as $g){
		// 	$pks[] = $g->mgid;
		// }
		// $mgids = implode(",", $pks);	
		$sql = "SELECT `tb_activity_config`.`mgid`,`tb_activity_config`.`total`,`tb_activity_config`.`deal`,`tb_activity_config`.`chance` FROM `tb_activity_config`  WHERE `tb_activity_config`.`deal`<`tb_activity_config`.`total` AND `tb_activity_config`.`date`='".date('Y-m-d')."' AND `tb_activity_config`.`type`=".$type;
		// if($mgids){
		// 	$sql = $sql." AND `tb_activity_config`.`mgid` IN (".$mgids.")";
		// }
		// Yii::app()->db->createCommand("LOCK TABLE `tb_activity_config` WRITE,`tb_mall_goods` WRITE;")->execute();
		$records = Yii::app()->db->createCommand($sql)->queryAll();
		// Yii::app()->db->createCommand("UNLOCK TABLES;")->execute();
		$result = array();		
		foreach($records as $r){
			if($mark){
				$num = $r['total']-$r['deal'];	
			}else{
				$num = ceil($r['chance'] * $box_number);
			}			
			for($i=0;$i<$num;$i++){
				$result[] = $r['mgid'];
			}
		}
		shuffle($result);
		return $result;
	}

	/**
    * panrj 2014-12-17
    * @param $userid 用户ID
    * 获取当前奖品信息
    * @return String
    */
	public static function getWishPrizeMgids()
	{
		$sql = "SELECT `tb_activity_config`.`mgid` FROM `tb_activity_config`  WHERE `tb_activity_config`.`date`='".date('Y-m-d')."' AND `tb_activity_config`.`type`=2";
		$records = Yii::app()->db->createCommand($sql)->queryAll();
		$pks = array();
		foreach($records as $r){
			$pks[] = $r['mgid'];
		}
		return $pks;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ActivityConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
