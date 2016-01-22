<?php

/**
 * This is the model class for table "{{duty_application_relation}}".
 *
 * The followings are the available columns in table '{{duty_application_relation}}':
 * @property integer $id
 * @property integer $dutyid
 * @property integer $appid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class DutyApplicationRelation extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{duty_application_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dutyid, appid', 'required'),
			array('dutyid, appid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dutyid, appid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'app' => array(self::BELONGS_TO, 'Application', 'appid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '自增ID',
			'dutyid' => '职务',
			'appid' => '应用',
			'state' => '暂未使用',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
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
		$criteria->compare('dutyid',$this->dutyid);
		$criteria->compare('appid',$this->appid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static  function  getAppidByDutyId($dutyid){
        $criteria = new CDbCriteria();
        $criteria->compare('dutyid',$dutyid);
        $criteria->compare('deleted',0);
        $result = self::model()->findAll($criteria);
        return $result;
    }

    public static  function  getDelDeleted($dutyid){
       $sql = "update tb_duty_application_relation set deleted = 1 where dutyid = ".$dutyid;
       $isbool = NoticeQuery::execute($sql);
        return $isbool;
    }
    public static function getDutyApp($dutyIds)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
        $criteria->with=array("app");
        $criteria->distinct=true;
        $criteria->select ="appid";
        $criteria->compare("t.deleted",0);
        $criteria->compare("app.deleted",0);
        $criteria->addInCondition('dutyid',$dutyIds);
        return self::model()->findAll($criteria);
    }

    public static function getDutyAppIdArr($dutyIds)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $apps=self::getDutyApp($dutyIds);
        $appIds=array();
        foreach($apps as $val){
            $appIds[]=$val->appid;
        }
        return $appIds;
    }

    /*
     * 获取客户端老师应用
     * panrj,zengp 2014-11-02
     */
    public static function getClientDutyApp($dutyIds,$type=array(0,1))
    {
        $criteria=new CDbCriteria;
        $criteria->with = array('app');
        $criteria->compare('app.type',$type);
        $criteria->compare('app.deleted',0);
        $criteria->compare('app.client',array(0,2));
        $criteria->compare('t.dutyid',$dutyIds);
        $criteria->compare('t.deleted',0);
        $criteria->order="app.appid";
        $data = self::model()->findAll($criteria);
        $arr = array();
        foreach($data as $d){
        	$arr[] = $d->app;
        }
        return $arr;
    }

    public static  function  getDutyApplication($dutyid,$appid){
        $criteria = new CDbCriteria();
        $criteria->compare('dutyid',$dutyid);
        $criteria->compare('appid',$appid);
        $criteria->compare('deleted',0);
        $result = self::model()->find($criteria);
        return $result;
    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DutyApplicationRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
