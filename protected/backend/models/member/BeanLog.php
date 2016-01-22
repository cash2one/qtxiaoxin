<?php

/**
 * This is the model class for table "{{bean_log}}".
 *
 * The followings are the available columns in table '{{bean_log}}':
 * @property integer $logid
 * @property string $userid
 * @property integer $bean
 * @property integer $ruleid
 * @property string $creationtime
 * @property integer $serverid
 * @property string $comment
 * @property integer $contract
 */
class BeanLog extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bean_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, bean, ruleid, creationtime, serverid, comment', 'required'),
			array('bean, ruleid, serverid, contract', 'numerical', 'integerOnly'=>true),
			array('userid', 'length', 'max'=>20),
			array('comment', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('logid, userid, bean, ruleid, creationtime, serverid, comment, contract', 'safe', 'on'=>'search'),
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
			'logid' => '日志唯一编号',
			'userid' => '用户唯一编号',
			'bean' => '青豆变化数量（负数为消费）',
			'ruleid' => '规则编号',
			'creationtime' => '事件发生时间',
			'serverid' => '服务器唯一编号',
			'comment' => '日志的备注信息',
			'contract' => '消费时的订单号',
		);
	}

	/**
     * 获取青豆积分
     * zengp 2014-12-05
     * @param string $userid 用户id
     * @param string $lastDate 日期
     * @return array 积分及操作对象列表
     */
	public static function getBeans($userid,$lastDate)
	{
		$lastDate = $lastDate == 0 ? date('Y-m-d',time() - 24*60*60) : $lastDate;
		
		$dateSql = "SELECT LEFT(creationtime,10) as creationtime FROM tb_bean_log WHERE userid = " . $userid . " AND creationtime < '".$lastDate."' GROUP BY TO_DAYS(creationtime) ORDER BY creationtime DESC limit 0,2";
		
		$dateRows = self::model()->findAllBySql($dateSql);
		$startDate = isset($dateRows[0]->creationtime) ? $dateRows[0]->creationtime : '';
		$endDate = isset($dateRows[1]->creationtime) ? $dateRows[1]->creationtime : '';

		$whereStr = '';
		if(!empty($startDate)){
			$whereStr = "and creationtime < '" . $startDate . " 24:59:59'";
			if(!empty($endDate))
				$whereStr .= " and creationtime > " . $endDate; 	
		}

		$sql = "SELECT ruleid,`comment`,contract,LEFT(creationtime,10) as creationtime,SUM(bean) bean FROM tb_bean_log WHERE userid = " . $userid . " AND serverid=0 " . $whereStr . "  GROUP BY ruleid,TO_DAYS(creationtime) ORDER BY creationtime DESC";
		

		$beans = self::model()->findAllBySql($sql);

		$arr = array();
		foreach ($beans as $item) {			
			if(isset($arr[$item->creationtime])){
				if($item->bean > 0){
					$arr[$item->creationtime]['getTotal'] += $item->bean;
					$arr[$item->creationtime]['getBeans'][] = $item;
				}else{ 
					$arr[$item->creationtime]['expendTotal'] += $item->bean;
					$arr[$item->creationtime]['expendBeans'][] = $item;
				}
				
			}else{
				$arr[$item->creationtime]['getTotal'] = 0;
				$arr[$item->creationtime]['expendTotal'] = 0;
				if($item->bean > 0){
					$arr[$item->creationtime]['getTotal'] = $item->bean;
					$arr[$item->creationtime]['getBeans'][] = $item;
				}else{
					$arr[$item->creationtime]['expendTotal'] = $item->bean;
					$arr[$item->creationtime]['expendBeans'][] = $item;
				}
			}
		}
		$resultArr = array();
		foreach ($arr as $key => $value) {
			$value['expendTotal'] = isset($value['expendTotal'])?$value['expendTotal']:0;
			$value['getTotal'] = isset($value['getTotal'])?$value['getTotal']:0;
			$value['getBeans'] = isset($value['getBeans'])?$value['getBeans']:array();
			$value['expendBeans'] = isset($value['expendBeans'])?$value['expendBeans']:array();
			$oldDate = $key;
			$newDate = date('m月d日',strtotime($key));
			$resultArr[] = array('date'=>$newDate,'oldDate'=>$oldDate,'getTotal'=>$value['getTotal'],'expendTotal'=>$value['expendTotal'],'getBeans'=>$value['getBeans'],'expendBeans'=>$value['expendBeans']);
		}
		
		return $resultArr;
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

		$criteria->compare('logid',$this->logid);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('bean',$this->bean);
		$criteria->compare('ruleid',$this->ruleid);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('serverid',$this->serverid);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('contract',$this->contract);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BeanLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
