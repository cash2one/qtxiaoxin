<?php

/**
 * This is the model class for table "{{mall_orders}}".
 *
 * The followings are the available columns in table '{{mall_orders}}':
 * @property string $moid
 * @property string $userid
 * @property integer $mcaid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property ClientLog[] $clientLogs
 * @property MallClientAddress $mca
 * @property MallOrdersGoodsRelation[] $mallOrdersGoodsRelations
 */
class MallOrders extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mall_orders}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('moid, userid', 'required'),
			array('mcaid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('moid, userid', 'length', 'max'=>20),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('moid, userid, mcaid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'clientLogs' => array(self::HAS_MANY, 'ClientLog', 'moid'),
			'mca' => array(self::BELONGS_TO, 'MallClientAddress', 'mcaid'),
			'mallOrdersGoodsRelations' => array(self::HAS_MANY, 'MallOrdersGoodsRelation', 'moid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'moid' => '订单ID',
			'userid' => '用户ID',
			'mcaid' => '邮寄地址',
			'state' => '状态：0待确认；1待发货；2待收货；3已收货',
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

		$criteria->compare('moid',$this->moid,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('mcaid',$this->mcaid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getState()
	{
		$stateArr = array(
			'0'=>'待确认',
			'1'=>'待发货',
			'2'=>'待收货',
			'3'=>'已收货',
		);
		return $stateArr[$this->state];
	}

	/**
    * panrj 2014-12-17
    * @param $mgid 商品ID
    * 生成订单编号
    * @return String
    */
	public static function generalOrderPk($mgid)
	{
		$time = date('YmdHis',time());
		$number = rand(100,999);
		$code = $time.$number.$mgid;
		$moid = MainHelper::enid($code,12);
		return $moid;
	}

	/**
    * panrj 2014-12-17
    * @param $userid 用户ID
    * 用户有无抽中实物奖品
    * @return String
    */
	public static function checkWinPrize($userid)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('userid',$userid);
		$criteria->compare('state',1);
		$criteria->compare('deleted',0);
		$count = false;
		$records = self::model()->findAll($criteria);
		if(count($records)){
			foreach($records as $r){
				$relation = $r->mallOrdersGoodsRelations;
				$good = count($relation)?$relation[0]->mg:false;
				if($good && $good->type==0 && in_array($good->visible,array(4,5))){
					return true;
				}else{
					continue;
				}

			}
		}
		return $count;
	}

	/**
    * panrj 2014-12-09
    * 获取昨日新增订单记录
    * @return UserOnline records
    */
    public static function getYesterdayRecord($lastid=0)
    {
        $criteria = new CDbCriteria();
        if($lastid>0){
        	$criteria->compare('moid','>'.$lastid);
        }
        $criteria->addCondition('TO_DAYS(NOW())-TO_DAYS(creationtime)=1','and');
        return self::model()->findAll($criteria);
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MallOrders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
