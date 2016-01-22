<?php

/**
 * This is the model class for table "{{mall_orders_goods_relation}}".
 *
 * The followings are the available columns in table '{{mall_orders_goods_relation}}':
 * @property integer $mogrid
 * @property string $moid
 * @property integer $mgid
 * @property integer $mgcid
 * @property integer $score
 * @property string $comment
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property string $commenttime
 *
 * The followings are the available model relations:
 * @property MallOrders $mo
 * @property MallGoods $mg
 * @property MallGoodsCard $mgc
 */
class MallOrdersGoodsRelation extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mall_orders_goods_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('moid, mgid, score', 'required'),
			array('mgid, mgcid, score, state, deleted', 'numerical', 'integerOnly'=>true),
			array('moid', 'length', 'max'=>20),
			array('comment, updatetime, commenttime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mogrid, moid, mgid, mgcid, score, comment, state, creationtime, updatetime, deleted, commenttime', 'safe', 'on'=>'search'),
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
			'mo' => array(self::BELONGS_TO, 'MallOrders', 'moid'),
			'mg' => array(self::BELONGS_TO, 'MallGoods', 'mgid'),
			'mgc' => array(self::BELONGS_TO, 'MallGoodsCard', 'mgcid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mogrid' => '关系ID',
			'moid' => '订单',
			'mgid' => '商品',
			'mgcid' => '虚拟卡号',
			'score' => '评分：满分100，20=1星。',
			'comment' => '评论',
			'state' => '状态：0未评价；1已评价',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除：0未删除；1已删除',
			'commenttime' => '评论时间',
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

		$criteria->compare('mogrid',$this->mogrid);
		$criteria->compare('moid',$this->moid,true);
		$criteria->compare('mgid',$this->mgid);
		$criteria->compare('mgcid',$this->mgcid);
		$criteria->compare('score',$this->score);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('commenttime',$this->commenttime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 返回一条商品评论数据
	 * panrj 2014-07-10
	 * @param string $moid 订单号
	 * @param int $mgid 商品ID
	 * @param string $mobile 手机号码
	 * @return record 
	 */
	public static function getCommentByMobile($moid,$mgid,$mobile)
	{
		$criteria = new CDbCriteria();
        $criteria->compare('t.moid',$moid,true);
        $criteria->compare('mgid',$mgid);
    	$criteria->with = array('mo');
		$criteria->compare('mo.mobilephone',$mobile);
		$criteria->compare('mo.deleted',0);
		$criteria->compare( 't.deleted', 0 );
        $record = self::model()->find($criteria);
        return $record;
	}

	/**
	 * 返回一条商品评论数据
	 * panrj 2014-07-10
	 * @param string $moid 订单号
	 * @param int $mgid 商品ID
	 * @param string $userid 用户ID
	 * @return record 
	 */
	public static function getCommentByUserid($moid,$mgid,$userid)
	{
		$criteria = new CDbCriteria();
        $criteria->compare('t.moid',$moid,true);
        $criteria->compare('mgid',$mgid);
    	$criteria->with = array('mo');
		$criteria->compare('mo.userid',$userid);
		$criteria->compare('mo.deleted',0);
		$criteria->compare( 't.deleted', 0 );
        $record = self::model()->find($criteria);
        return $record;
	} 

	/**
	 * 返回用户中奖次数
	 * panrj 2014-12-19
	 * @param string $userid 用户ID
	 * @return int 
	 */
	public static function countPrizeWin($userid)
	{
		$criteria = new CDbCriteria();
    	$criteria->with = array('mo','mg');
		$criteria->compare('mo.userid',$userid);
		$criteria->compare('mo.deleted',0);
		$criteria->compare('t.deleted', 0 );
		$criteria->compare('mg.deleted', 0 );
		$criteria->compare('mg.visible', array(4,5));
        $count = self::model()->count($criteria);
        return $count;
	} 

	/**
	 * 返回已中奖品ID
	 * panrj 2014-12-19
	 * @return array 
	 */
	public static function getPrizeGoodMsgids()
	{
		$criteria = new CDbCriteria();
    	$criteria->with = array('mg');
		$criteria->compare('t.deleted', 0 );
		$criteria->compare('mg.deleted', 0 );
		$criteria->compare('mg.visible', array(4));
		$criteria->group = 't.mgid';
        $records = self::model()->findAll($criteria);
        $pks = array();
        foreach($records as $r){
        	if(!in_array($r->mgid, $pks)){
        		$pks[] = $r->mgid;
        	}
        }	
        return $pks;
	}

	/**
	 * 返回单个奖品的中奖信息
	 * panrj 2014-12-19
	 * @param int $mgid 奖品ID
	 * @return objs 
	 */
	public static function getPrizeWinRealtionByMgid($mgid,$limit=0)
	{
		$criteria = new CDbCriteria();
    	$criteria->with = array('mg');
		$criteria->compare('t.deleted', 0 );
		$criteria->compare('t.mgid', $mgid );
		$criteria->compare('mg.visible', array(4));
		$criteria->order = 't.creationtime DESC';
		if($limit>0){
			$criteria->limit = $limit;
		}
        $datas = self::model()->findAll($criteria);
        return $datas;
	} 

	/**
	 * 返回最新的几条中奖信息
	 * panrj 2014-12-19
	 * @param int $limit 返回数量
	 * @return objs 
	 */
	public static function getPrizeWinRealtions($limit=0)
	{
		$criteria = new CDbCriteria();
    	$criteria->with = array('mg');
		$criteria->compare('t.deleted', 0 );
		$criteria->compare('mg.visible', array(4));
		$criteria->order = 't.creationtime DESC';
		if($limit>0){
			$criteria->limit = $limit;
		}
        $datas = self::model()->findAll($criteria);
        return $datas;
	}   

	/**
	 * 返回用户的中奖信息
	 * zengp 2014-12-19
	 * @param int $userid 用户id
	 * @return objs 
	 */
	public static function getUserPrizeWinRealtions($userid)
	{
		$criteria = new CDbCriteria();
    	$criteria->with = array('mg','mo');
    	$criteria->compare('mo.userid', $userid);
		$criteria->compare('t.deleted', 0 );
		$criteria->compare('mg.visible', array(4,5));
		$criteria->order = 't.creationtime DESC';
        $datas = self::model()->findAll($criteria);
        return $datas;
	}   
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MallOrdersGoodsRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
