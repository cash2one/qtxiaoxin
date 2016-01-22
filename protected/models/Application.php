<?php

/**
 * This is the model class for table "{{application}}".
 *
 * The followings are the available columns in table '{{application}}':
 * @property integer $appid
 * @property string $name
 * @property string $url
 * @property string $desc
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property string $icon
 * @property integer $type
 */
class Application extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{application}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('state, deleted, type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('url', 'length', 'max'=>256),
			array('desc', 'length', 'max'=>500),
			array('icon', 'length', 'max'=>255),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('appid, name, url, desc, state, creationtime, updatetime, deleted, icon, type', 'safe', 'on'=>'search'),
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
			'appid' => '应用ID',
			'name' => '应用名称',
			'url' => '应用地址',
			'desc' => '描述',
			'state' => '状态：暂未使用',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'icon' => 'Icon',
			'type' => '0--公用的菜单 1:老师的菜单 2--家长的菜单',
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

		$criteria->compare('appid',$this->appid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('icon',$this->icon,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getClientApp($type=array(0,1))
	{
		$criteria=new CDbCriteria;
        $criteria->compare('type',$type);
        $criteria->compare('deleted',0);
        $criteria->compare('client',1);
        return self::model()->findAll($criteria);
	}


    public static function getAppsByIds($ids)
    {
        $criteria=new CDbCriteria;
        $criteria->addInCondition("appid",$ids);
        $criteria->compare('deleted',0);
        $criteria->addInCondition("client",array(0,1));
        return self::model()->findAll($criteria);
    }

    /*
     * 获取客户端老师应用
     * panrj,zengp 2014-11-02
     */
    public static function getTeacherClientApp($userid,$guid='')
    {
    	$dutyids = SchoolTeacherRelation::getTeacherDutyPks($userid);
    	$arr=array();
    	if(count($dutyids)){
    		$data = DutyApplicationRelation::getClientDutyApp($dutyids);
    		$pks = array();
    		foreach($data as $d){
    			
    			if(!in_array($d->appid, $pks)){
    				if($guid){
    					$arr[] = $d;
    				}else{
    					if($d->state==1){
    						$arr[] = $d;
    					}
    				}
    				
    			}
    			$pks[] = $d->appid;
    		}
    	}
    	return $arr;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Application the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
