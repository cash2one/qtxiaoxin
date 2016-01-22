<?php

/**
 * This is the model class for table "{{advertisement}}".
 *
 * The followings are the available columns in table '{{advertisement}}':
 * @property integer $aid
 * @property string $title
 * @property string $text
 * @property string $image
 * @property string $url
 * @property integer $bid
 * @property integer $uid
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property User $u
 * @property ContractAdvertisementRelation[] $contractAdvertisementRelations
 */
class Advertisement extends MasterActiveRecord
{

	public $contype;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{advertisement}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, text, image, uid, summery', 'required','message'=>'{attribute}不能为空'),
			array('bid, uid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('title, image, url', 'length', 'max'=>64),
			array('summery', 'length', 'max'=>256),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('aid, title, summery, text, image, url, bid, uid, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
			'car' => array(self::HAS_MANY, 'ContractAdvertisementRelation', 'aid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'aid' => '广告ID',
			'title' => '广告标题',
			'summery' => '广告摘要',
			'text' => '广告文字',
			'image' => '广告图片',
			'url' => '外链地址',
			'bid' => '商户',
			'uid' => '创建者',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 广告列表分页数据
	 * panrj 2014-05-20
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageData($parms=array(),$ty='')
	{
		$result = array();
		$criteria = new CDbCriteria();
		$criteria->select = '`aid`,`title`,`summery`,`text`,`image`,`url`,`bid`,`uid`,`state`,`creationtime`,`updatetime`,`deleted`';
		if($ty=='public'){
			$criteria->addCondition('ISNULL(bid)');
			if(isset($parms['state']) && $parms['state'])
				$criteria->compare('state',$parms['state']);
		}else{
			$criteria->addCondition('bid IS NOT NULL');
		}
			
		if(isset($parms['title']) && $parms['title']!=''){
        	$criteria->compare('title',$parms['title'],true);
        }
        if(isset($parms['bid']) && $parms['bid']!==''){
        	$criteria->compare('bid',$parms['bid']);
        }
        if(isset($parms['contype']) && $parms['contype']){
  			if($parms['contype']=='1'){
  				$criteria->compare('connum',0);
  			}
  			if($parms['contype']=='2'){
  				$criteria->compare('connum','>0');
  			}
        }
        $criteria->scopes='normal';  
		$criteria->order = 'creationtime DESC';     
        $count = ViewAdvertisementRelationCount::model()->count($criteria); 
        $pager = new CPagination($count);
        if(isset($parms['size']) && $parms['size']){
        	$pager->pageSize = $parms['size']; 
        }else{
        	$pager->pageSize = 15;  
        }               
        $pager->applyLimit($criteria);

        $datalist = ViewAdvertisementRelationCount::model()->findAll($criteria);

        $result['model'] = $datalist;
        $result['pages'] = $pager;
        
        return $result;
	}

	/**
	 * 广告列表分页数据
	 * panrj 2014-05-20
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageDataPublic($parms=array(),$ty='')
	{
		$result = array();
		$criteria = new CDbCriteria();
		if($ty=='public'){
			$criteria->addCondition('ISNULL(bid)');
			if(isset($parms['state']) && $parms['state'])
				$criteria->compare('state',$parms['state']);
		}else{
			$criteria->addCondition('bid IS NOT NULL');
		}
			
		if(isset($parms['title']) && $parms['title']!=''){
        	$criteria->compare('title',$parms['title'],true);
        }
        if(isset($parms['bid']) && $parms['bid']!==''){
        	$criteria->compare('bid',$parms['bid']);
        }
        $criteria->scopes='normal';  
		$criteria->order = 'creationtime DESC';     
        $count = self::model()->count($criteria); 
        $pager = new CPagination($count);
        if(isset($parms['size']) && $parms['size']){
        	$pager->pageSize = $parms['size']; 
        }else{
        	$pager->pageSize = 20;  
        }               
        $pager->applyLimit($criteria);

        $datalist = self::model()->findAll($criteria);

        $result['model'] = $datalist;
        $result['pages'] = $pager;
        
        return $result;
	}

	/**
	 * 广告列表分页数据
	 * panrj 2014-07-10
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageDataGird($parms=array())
	{
		$result = array();
		$criteria = new CDbCriteria();
		if(isset($parms['contype']) && $parms['contype']){
			if($parms['contype']=='public'){
				$criteria->addCondition('ISNULL(bid)');
			}else{
				$criteria->addCondition('bid IS NOT NULL');
			}
		}
			
		if(isset($parms['title']) && $parms['title']){
        	$criteria->compare('title',$parms['title'],true);
        }
        if(isset($parms['bid']) && $parms['bid']!==''){
        	$criteria->compare('bid',$parms['bid']);
        }
        
        $criteria->scopes='normal';  
		$criteria->order = 'creationtime DESC';     
        $count = self::model()->count($criteria); 
        $pager = new CPagination($count);
        if(isset($parms['size']) && $parms['size']){
        	$pager->pageSize = $parms['size']; 
        }else{
        	$pager->pageSize = 15;  
        }               
        $pager->applyLimit($criteria);

        $datalist = self::model()->findAll($criteria);

        $result['model'] = $datalist;
        $result['pages'] = $pager;
        
        return $result;
	}

	/**
	 * 获取广告名称
	 * panrj 2014-05-20
	 * @return string $name 
	 */
	public static function getAdvTitle($aid)
	{
		$adv = self::model()->loadByPk($aid);
		return $adv->title;
	}

	/**
	 * 获取广告商家名称
	 * panrj 2014-05-20
	 * @return string $name 
	 */
	public function getBusinessName()
	{
		if($this->bid){
			$name = Business::getBusinessName($this->bid);
			return $name;
		}else{
			return '';
		}
		
	}

	/**
	 * 获取广告合同关联记录
	 * panrj 2014-05-20
	 * @return int $num 
	 */
	public function getConAdvRelation()
	{
		$criteria=new CDbCriteria;
		$criteria->scopes='normal';
		$criteria->compare('aid',$this->aid);
		$data = ContractAdvertisementRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 获取广告关联合同
	 * panrj 2014-05-20
	 * @return int $num 
	 */
	public function getAdvContracts()
	{
		$data = $this->getConAdvRelation();
		if(count($data)){
			$arr = array();
			foreach($data as $d){
				$con = Contract::model()->loadByPk($d->cid);
				array_push($arr,$con);
			} 
			return $arr;
		}else{
			return array();
		}
	}

	/**
	 * 广告关联合同数量
	 * panrj 2014-05-20
	 * @return int $num 
	 */
	public function countConAdvRelation()
	{
		$data = $this->getConAdvRelation();
		return count($data);
	}

	public function getDisableArr()
	{
		$arr = array(
			'1'=>'启用',
			'2'=>'停用'
		);
		return $arr;
	}

	public function getDisableState($reverse=false)
	{
		$arr = array('1'=>'启用','2'=>'停用');
		if($reverse){
    		$state = $this->state==1 ? 2 : 1;
    		return $arr[$state];
    	}else{
    		return $arr[$this->state];
    	}
	}

	/**
	 * 广告主键获取标题
	 * panrj 2014-05-20
	 * @return int $num 
	 */
	public static function getAdvTitleById($id)
	{
		$adv = self::model()->loadByPk($id);
		return $adv->title;
	}

	/**
	 * 查询广告日志记录
	 * panrj 2014-07-09
	 * @param string $action 日志记录动作
	 * @return queryset $data 
	 */
	public function getClientLogData($action='Browse')
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('tid',$this->aid);
        $criteria->compare('target','Advertisement',true);
        $criteria->compare('action',$action,true);
        $data = ClientLogSchoolRelation::model()->findAll($criteria); 
        return $data;
	}

	/**
	 * 返回广告浏览量
	 * panrj 2014-07-09
	 * @return int
	 */
	public function countBrowse()
	{
		$data = $this->getClientLogData('Browse');
        return count($data);
	}

	/**
	 * 返回每日统计数据
	 * panrj 2014-07-09
	 * @return queryset
	 */
	public function getDailyLog($parms=array())
	{
		$date = date('Y-m-d',time()).' 00:00:00';
        $criteria = new CDbCriteria();
        $criteria->select = "DATE_FORMAT( `creationtime`, '%Y-%m-%d') `date` , COUNT(IF(`action`='Buy',TRUE,NULL)) `buy`, COUNT(IF(`action`='Browse',TRUE,NULL)) `browse`, COUNT(IF(`action`='Comment',TRUE,NULL)) `commemt`";
        $criteria->compare('target','Advertisement',true);
        $criteria->compare('tid',$this->aid);
        if(isset($parms['sdate']) && $parms['sdate']){
        	$sdate = $parms['sdate'].' 00:00:00';
        	$criteria->compare('creationtime','>='.$sdate);
        }
        if(isset($parms['edate']) && $parms['edate']){
        	$edate = $parms['edate'].' 23:59:59';
        	$criteria->compare('creationtime','<='.$edate);
        }
        // $criteria->compare("creationtime","<".$date);
        $criteria->group = "DATE_FORMAT( `creationtime`, '%Y-%m-%d')";
        $criteria->order = 'date DESC' ;
        $data = ClientLogSchoolRelation::model()->findAll($criteria); 
        return $data;
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Advertisement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
