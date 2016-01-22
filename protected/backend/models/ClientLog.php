<?php

/**
 * This is the model class for table "{{client_log}}".
 *
 * The followings are the available columns in table '{{client_log}}':
 * @property integer $clid
 * @property string $userid
 * @property string $target
 * @property integer $tid
 * @property string $action
 * @property string $creationtime
 *
 * The followings are the available model relations:
 * @property Client $userid0
 */
class ClientLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{client_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, target, tid, action', 'required'),
			array('userid, tid', 'numerical', 'integerOnly'=>true),
			array('target, moid', 'length', 'max'=>20),
			array('action', 'length', 'max'=>50),
			array('creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('clid, userid, target, tid, action, creationtime, moid', 'safe', 'on'=>'search'),
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
			'userid0' => array(self::BELONGS_TO, 'Client', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'clid' => '日志ID',
			'userid' => '用户ID',
			'target' => '目标：Focus热点；Advertisement广告；Information资讯；mall商品',
			'tid' => '目标id',
			'action' => '动作：Browse浏览；Buy购买兑换；Join参与',
			'creationtime' => '创建时间',
			'moid' => '订单号：只针对商品评论生效',
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

		$criteria->compare('clid',$this->clid);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('tid',$this->tid);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('moid',$this->moid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function addClientLog($uid,$target,$tid,$action)
	{
		$model = new ClientLog;
		$model->userid = $uid;
		$model->target = $target;
		$model->tid = $tid;
		$model->action = $action;
		$model->save();
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClientLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
