<?php

/**
 * This is the model class for table "{{log_credits}}".
 *
 * The followings are the available columns in table '{{log_credits}}':
 * @property integer $log_id
 * @property string $user_id
 * @property integer $credits
 * @property integer $eventtype
 * @property string $logtime
 * @property string $source
 * @property string $comment
 */
class LogCredits extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{log_credits}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, credits, eventtype, logtime, source, comment', 'required'),
			array('credits, eventtype', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			array('source', 'length', 'max'=>16),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('log_id, user_id, credits, eventtype, logtime, source, comment', 'safe', 'on'=>'search'),
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
			'log_id' => '日志的唯一编号',
			'user_id' => '用户编号',
			'credits' => '变化的积分数(负数为消费)',
			'eventtype' => '事件类型',
			'logtime' => '变化时间',
			'source' => '事件源头',
			'comment' => '事件描述',
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

		$criteria->compare('log_id',$this->log_id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('credits',$this->credits);
		$criteria->compare('eventtype',$this->eventtype);
		$criteria->compare('logtime',$this->logtime,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
    * panrj 2014-12-09
    * 获取昨日商品兑换记录
    * @return UserOnline records
    */
    public static function getYesterdayRecord($date)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('credits','<0');
        $criteria->addCondition("TO_DAYS('".$date."')-TO_DAYS(logtime)=0",'and');
        $criteria->addCondition("source LIKE '商品ID:%'","and");
        return self::model()->findAll($criteria);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LogCredits the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
