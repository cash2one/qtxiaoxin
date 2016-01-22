<?php

/**
 * This is the model class for table "{{area}}".
 *
 * The followings are the available columns in table '{{area}}':
 * @property integer $aid
 * @property string $name
 * @property integer $parentid
 * @property integer $type
 * @property string $postcode
 * @property string $areacode
 * @property string $path
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property School[] $schools
 */
class Area extends MemberActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{area}}';
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
			array('parentid, type, state, deleted', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>20),
			array('postcode, areacode', 'length', 'max'=>10),
			array('path', 'length', 'max'=>50),
			array('updatetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('aid, name, parentid, type, postcode, areacode, path, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'schools' => array(self::HAS_MANY, 'School', 'aid'),
            'parent' => array(self::BELONGS_TO, 'Area', 'parentid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'aid' => '区域ID',
			'name' => '区域名称',
			'parentid' => '上级目录',
			'type' => '类型：0省份；1城市；2区',
			'postcode' => '邮编',
			'areacode' => '区号',
			'path' => '路径',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除',
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

		$criteria->compare('aid',$this->aid);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parentid',$this->parentid);
		$criteria->compare('type',$this->type);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('areacode',$this->areacode,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 提取城市数据
	 * panrj 2014-07-25
	 * @return array City
	 */
	public static function getCityData($type='all')
	{
		$criteria=new CDbCriteria;
		if($type!='all'){
			$criteria->compare('type',$type);
		}
		$criteria->compare('deleted',0);
		$data = self::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 返回城市数据键值字典
	 * panrj 2014-07-25
	 * @return array $arr
	 */
	public static function getCityArr()
	{
		$data = self::getCityData(1);
		$arr = array();
		foreach($data as $d){
			$arr[$d->aid] = $d->name;
		}
		return $arr;
	}

	/**
	 * 提取区域数据
	 * panrj 2014-07-25
	 * @param array $parms 查询条件
	 * @return array Area
	 */
	public static function getAreaData($parms=array())
	{
		$criteria=new CDbCriteria;
		if(isset($parms['cid']) && $parms['cid']){
			$criteria->compare('parentid',$parms['cid']);
		}
		$criteria->compare('type',2);
		$criteria->compare('deleted',0);
		$data = self::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 区域数据转化为数组
	 * panrj 2014-07-25
	 * @param array $parms 查询条件
	 * @return array $arr
	 */
	public static function getAreaArr($parms=array())
	{
		$data = self::getAreaData($parms);
		$arr = array();
		foreach($data as $d){
			$arr[$d->aid] = $d->name;
		}
		return $arr;
	}

    public static function getCityAreas($cid){
        $criteria=new CDbCriteria;
        $criteria->compare('type',2);
        $criteria->compare('parentid',$cid);
        $criteria->compare('deleted',0);
        $data = self::model()->findAll($criteria);
        return $data;
    }

    public static function getCityAreaArr($cid){
        $data = self::getCityAreas($cid);
        $result=array();
        foreach($data as $d){
            $result[$d->aid]=$d->name;
        }
        return $result;
    }

    public static function getAreaNameWithCity($aid,$sep=' - '){
    	$area = self::model()->findByPk($aid);
    	if($area){
    		if($area->type==4 && $area->parent->parentid){
    			//$parent = self::model()->findByPk($area->parent->parentid);
    			return $area->name.$sep.$area->parent->name;
    		}else{
    			return $area->name;
    		}
    	}
    	return '';
    }

  //获取所有省份， 2015-3-2
  public static function getAllprovince(){
      $cache = Yii::app()->cache;
      $province_list = $cache->get("back_all_province_list");
      if(!$province_list){
         $province_list = Area::model()->findAllByAttributes(array('deleted' => 0, 'parentid' => 0, 'type' => 3));
         $provinces = array();
         foreach ($province_list as $key => $value) {
            $provinces[$value['aid']] = $value['name'];
         }
          $cache->set("back_all_province_list", $provinces);
          return $provinces;
      }
  	 return $province_list;
  }
//获取所有城市、地区，2015-3-2
   public static function getCity($parms=array())
    {
        $criteria=new CDbCriteria;
        if(isset($parms['cid']) && $parms['cid']){
            $criteria->compare('parentid',$parms['cid']);
        }
        $criteria->compare('deleted',0);
        $data = self::model()->findAll($criteria);
       // D($data);
        $arr=array();
        foreach($data as $val){
            $arr[]=array('aid'=>$val->aid,'name'=>$val->name,'pid'=>$val->parentid,'pname'=>$val->parent->name);
        }
        return $arr;
    }
    
    public static function getAlldata($provinceid){
        $allCity = Area::getCity(array('cid'=>$provinceid)); //单个省下的所有城市
        $allArea = array();
        foreach($allCity as $key=>$val){
            $allData= Area::getCity(array('cid'=>$val['aid']));//查询所有城市下的所有区域
            foreach($allData as $key=>$val){
                $allArea[$val['aid']]=$val['name'];
            }
        }
        return $allArea;
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MArea the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
