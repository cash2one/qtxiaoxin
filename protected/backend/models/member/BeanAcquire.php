<?php

/**
 * This is the model class for table "{{bean_acquire}}".
 *
 * The followings are the available columns in table '{{bean_acquire}}':
 * @property integer $acquireid
 * @property string $userid
 * @property string $notedate
 * @property integer $ruleid
 * @property integer $number
 * @property integer $bean
 * @property integer $beanfrom
 */
class BeanAcquire extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{bean_acquire}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, notedate, ruleid, number, bean', 'required'),
			array('ruleid, number, bean, beanfrom, isdeal', 'numerical', 'integerOnly'=>true),
			array('userid', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('acquireid, userid, notedate, ruleid, number, bean, beanfrom', 'safe', 'on'=>'search'),
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
			'rule' => array(self::BELONGS_TO, 'BeanRule', 'ruleid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'acquireid' => 'Acquireid',
			'userid' => 'Userid',
			'notedate' => 'Notedate',
			'ruleid' => 'Ruleid',
			'number' => 'Number',
			'bean' => 'Bean',
			'beanfrom' => 'Beanfrom',
			'isdeal' => 'Isdeal',
		);
	}


	public static function getBeans($userid, $lastdate){
		
		$dateSql = "SELECT LEFT(notedate,10) as notedate FROM tb_bean_acquire WHERE userid = " . $userid . " AND beanfrom = 1 AND notedate < '".$lastdate."' GROUP BY TO_DAYS(notedate) ORDER BY notedate DESC limit 0,2";
		
		$dateRows = self::model()->findAllBySql($dateSql);
		$startDate = isset($dateRows[0]->notedate) ? $dateRows[0]->notedate : '';
		$endDate = isset($dateRows[1]->notedate) ? $dateRows[1]->notedate : '';		

		$criteria = new CDbCriteria();
		$criteria->with = 'rule';
        $criteria->compare('t.userid', $userid);
        $criteria->compare('t.beanfrom', 1);
        if(!empty($endDate))
        	$criteria->addCondition("t.notedate >= '".$endDate."'"); 
        if(!empty($startDate))
       	 	$criteria->addCondition("t.notedate <= '".$startDate."'");       	        	 
       	 $criteria->order = 't.notedate DESC';

       	if(empty($startDate) && empty($endDate))
       		$data = array();
       	else
        	$data = self::model()->findAll($criteria);

       	$arr = array();
        foreach ($data as $item) {
        	if(isset($arr[$item->notedate])){
				if($item->bean > 0){
					$arr[$item->notedate]['getTotal'] += $item->bean;
					$arr[$item->notedate]['getBeans'][] = $item;
				}else{ 
					$arr[$item->notedate]['expendTotal'] += $item->bean;
					$arr[$item->notedate]['expendBeans'][] = $item;
				}
				
			}else{
				$arr[$item->notedate]['getTotal'] = 0;
				$arr[$item->notedate]['expendTotal'] = 0;
				if($item->bean > 0){
					$arr[$item->notedate]['getTotal'] = $item->bean;
					$arr[$item->notedate]['getBeans'][] = $item;
				}else{
					$arr[$item->notedate]['expendTotal'] = $item->bean;
					$arr[$item->notedate]['expendBeans'][] = $item;
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

	public static function countByConditation($date,$parms=array())
	{
		$criteria = new CDbCriteria();
        if(isset($parms['userid']) && $parms['userid']){
        	$criteria->compare('userid',$parms['userid']);
        }
        if(isset($parms['ruleid']) && $parms['ruleid']){
        	$criteria->compare('ruleid',$parms['ruleid']);
        }
        $criteria->compare('beanfrom',1);
        $criteria->addCondition("TO_DAYS('".$date."')-TO_DAYS(notedate)=0",'and');
        return self::model()->count($criteria);
	}

	public static function updateDealState($pks)
	{	
		$criteria=new CDbCriteria;
		$criteria->compare('acquireid',$pks);
		self::model()->updateAll(array('isdeal' => 1), $criteria);
	}

	/**
    * panrj 2014-12-09
    * 获取昨日青豆记录
    * @return BeanAcquire records
    */
    public static function getYesterdayRecord($date)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('beanfrom',1);
        $criteria->compare('isdeal',0);
        $criteria->addCondition("TO_DAYS('".$date."')-TO_DAYS(notedate)=0",'and');
        return self::model()->findAll($criteria);
    }

    /**
    * panrj 2014-12-09
    * 获取昨日青豆记录
    * @return BeanAcquire records
    */
    public static function getOrCreate($userid,$ruleid)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('beanfrom',1);
        $criteria->compare('isdeal',1);
        $criteria->compare('ruleid',$ruleid);
        $criteria->compare('notedate',date('Y-m-d'));
        $criteria->compare('userid',$userid);
        $record = self::model()->find($criteria);
        if($record){
        	return $record;
        }else{
        	$record = new BeanAcquire;
        	$record->userid = $userid;
        	$record->beanfrom = 1;
        	$record->isdeal = 1;
        	$record->ruleid = $ruleid;
        	$record->notedate = date('Y-m-d');
        	$record->save();
        	return $record;
        }
    }


    /**
    * panrj 2014-12-17
    * 统计记录数
    * @return int
    */
    public static function countBeanAcquire($arr=array())
    {
    	if(empty($arr)){
    		return 0;
    	}
    	$criteria = new CDbCriteria();
        $criteria->compare('beanfrom',1);
        if(isset($arr['userid']) && $arr['userid']){
        	$criteria->compare('userid',$arr['userid']);
        }
        if(isset($arr['ruleid']) && $arr['ruleid']){
        	$criteria->compare('ruleid',$arr['ruleid']);
        }
        return self::model()->count($criteria);
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

		$criteria->compare('acquireid',$this->acquireid);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('notedate',$this->notedate,true);
		$criteria->compare('ruleid',$this->ruleid);
		$criteria->compare('number',$this->number);
		$criteria->compare('bean',$this->bean);
		$criteria->compare('beanfrom',$this->beanfrom);
		$criteria->compare('isdeal',$this->isdeal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BeanAcquire the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
