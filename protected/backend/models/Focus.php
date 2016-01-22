<?php

/**
 * This is the model class for table "{{focus}}".
 *
 * The followings are the available columns in table '{{focus}}':
 * @property integer $fid
 * @property string $title
 * @property string $text
 * @property string $image
 * @property string $url
 * @property integer $bid
 * @property integer $uid
 * @property integer $type
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property ContractFocusRelation[] $contractFocusRelations
 * @property User $u
 * @property FocusQuestion[] $focusQuestions
 */
class Focus extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{focus}}';
	}

	public $point = 0;
	public $contype;
	public $startdate;
	public $enddate;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, image, summery, uid, type', 'required'),
			array('bid, uid, type, state, deleted', 'numerical', 'integerOnly'=>true),
			array('title, image, url', 'length', 'max'=>64),
			array('summery', 'length', 'max'=>256),
			array('text, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('fid, title, summery, text, image, url, bid, uid, type, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'contractFocusRelations' => array(self::HAS_MANY, 'ContractFocusRelation', 'fid'),
			'cfrCount' => array(self::STAT, 'ContractFocusRelation', 'fid'),
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
			'focusQuestions' => array(self::HAS_MANY, 'FocusQuestion', 'fid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'fid' => '热点ID',
			'title' => '标题',
			'summery' => '摘要',
			'text' => '文字',
			'image' => '图片',
			'url' => '外链地址',
			'bid' => '商户',
			'uid' => '创建者',
			'type' => '类别',
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

		$criteria->compare('fid',$this->fid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('type',$this->type);
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
        if(isset($parms['type']) && $parms['type']!==''){
        	$criteria->compare('type',$parms['type']);
        }
  		if(isset($parms['contype']) && $parms['contype']){
  			if($parms['contype']=='1'){
  				$criteria->compare('connum',0);
  			}
  			if($parms['contype']=='2'){
  				$criteria->compare('connum','>0');
  			}
        }
		$criteria->order = 'creationtime DESC';     
        $count = ViewFocusRelationCount::model()->count($criteria); 
        $pager = new CPagination($count);
        if(isset($parms['size']) && $parms['size']){
        	$pager->pageSize = $parms['size']; 
        }else{
        	$pager->pageSize = 15;  
        }               
        $pager->applyLimit($criteria);

        $datalist = ViewFocusRelationCount::model()->findAll($criteria);

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
        if(isset($parms['type']) && $parms['type']!==''){
        	$criteria->compare('type',$parms['type']);
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
	 * 资讯列表分页数据
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
		if(isset($parms['type']) && $parms['type']!==''){
        	$criteria->compare('type',$parms['type']);
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
	 * 获取热点商家名称
	 * panrj 2014-05-20
	 * @return string $name 
	 */
	public function getBusinessName()
	{
		$name = Business::getBusinessName($this->bid);
		return $name;
	}

	/**
	 * 获取热点名称
	 * panrj 2014-05-20
	 * @return string $name 
	 */
	public static function getFocTitle($fid)
	{
		$foc = Self::model()->loadByPk($fid);
		return $foc->title;
	}

	/**
	 * 获取广告合同关联记录
	 * panrj 2014-05-20
	 * @return int $num 
	 */
	public function getConFocRelation()
	{
		$criteria=new CDbCriteria;
		$criteria->scopes='normal';
		$criteria->compare('fid',$this->fid);
		$data = ContractFocusRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 热点关联合同数量
	 * panrj 2014-05-20
	 * @return int $num 
	 */
	public function countConFocRelation()
	{
		$data = $this->getConFocRelation();
		return count($data);
	}

	public static function getTypeArr()
	{
		$arr = array(
			'0'=>'新闻',
			'1'=>'问卷',
			'2'=>'链接',
		);
		return $arr;
	}

	public static function getConTypeArr()
	{
		$arr = array(
			'1'=>'未配置',
			'2'=>'已配置',
		);
		return $arr;
	}

	public function getTypeName()
	{
		$arr = $this->getTypeArr();
		return $arr[$this->type];
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
	*获取热点问题
	* panrj 2014-06-23
	*/
	public function getFocQuestions()
	{
		if($this->type!=1){
			return array();
		}else{
			$criteria=new CDbCriteria;
			$criteria->scopes='normal';
			$criteria->compare('fid',$this->fid);
			$data = FocusQuestion::model()->findAll($criteria);
			return $data;
		}
	}

	public function countFocQuestions()
	{
		$data = $this->getFocQuestions();
		return count($data);
	}

	/**
	*删除热点问题
	* panrj 2014-06-23
	*/
	public function deleteFocQuestions()
	{
		$questions = $this->getFocQuestions();
		if(count($questions)){
			foreach($questions as $q){
				$q->deleteQuestionItems();
				$q->deleteMark();
			}
		}
	}

	/**
	*返回积分值列表
	* panrj 2014-06-23
	*/
	public function getPointItemList(){
    	$list = array();
    	for($i=0;$i<=500;$i+=50){
    		$list[$i] = $i;
    	}
    	return $list;
    }

    /**
	 * 设置热点积分
	 * panrj 2014-06-23
	 */
    public function setFocPoint($point)
    {
    	$relation = PointRelation::model()->getOrCreate(get_class(self::model()),$this->fid);
    	$relation->point = $point;
    	$relation->save();
    }

    /**
	 * 查询热点积分
	 * panrj 2014-06-23
	 * @return int $point
	 */
    public function getFocPoint()
    {
    	if(!$this->fid)
    		return 0;
    	$relation = PointRelation::model()->getOrCreate(get_class(self::model()),$this->fid);
    	$point = $relation->point ? $relation->point : 0;
    	return $point;
    }

    /**
	 * 初始化公开热点对应ContractFocusRelation
	 * panrj 2014-06-23
	 * @param string $s 起始时间
	 * @param string $e 结束时间
	 * @return model ContractFocusRelation
	 */
    public function addPublicFocRelation($s,$e)
    {
    	$relation = new ContractFocusRelation;
    	$relation->startdate = $s;
    	$relation->enddate = $e;
    	$relation->fid = $this->fid;
    	$relation->school = 0;
    	$relation->person = 0;
    	$relation->save();
    	return $relation;
    }

    /**
	 * 获取公开热点对应ContractFocusRelation,若查询不到就初始化一条数据
	 * panrj 2014-06-23
	 * @return model ContractFocusRelation
	 */
    public function getPublicFocRelation()
    {
    	$criteria=new CDbCriteria;
    	$criteria->compare('fid',$this->fid);
    	$criteria->addCondition('ISNULL(cid)');
    	$relation = ContractFocusRelation::model()->find($criteria);
    	if($relation){
    		return $relation;
    	}else{
    		$date = date('Y-m-d H:i:s',time());
    		$relation = $this->addPublicFocRelation($date,$date);
    		return $relation;
    	}
    }

    /**
	 * 设置公开热点对应ContractFocusRelation
	 * panrj 2014-06-23
	 * @param string $s 起始时间
	 * @param string $e 结束时间
	 */
    public function setPublicFocRelation($s,$e)
    {
    	$relation = $this->getPublicFocRelation();
    	$relation->startdate = $s;
    	$relation->enddate = $e;
    	$relation->save();
    }

    /**
	 * 获取公开热点对应ContractFocusRelation起始时间
	 * panrj 2014-06-23
	 * @return string
	 */
    public function getPublicFocStartdate()
    {
    	$relation = $this->getPublicFocRelation();
    	if($relation)
    		return $relation->startdate;
    	return '';
    }

    /**
	 * 获取公开热点对应ContractFocusRelation结束时间
	 * panrj 2014-06-23
	 * @return string
	 */
    public function getPublicFocEnddate()
    {
    	$relation = $this->getPublicFocRelation();
    	if($relation)
    		return $relation->enddate;
    	return '';
    }

    /**
	 * 查询热点日志记录
	 * panrj 2014-07-09
	 * @param string $action 日志记录动作
	 * @return queryset $data 
	 */
	public function getClientLogData($action='Browse')
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('tid',$this->fid);
        $criteria->compare('target','Focus',true);
        $criteria->compare('action',$action,true);
        $data = ClientLogSchoolRelation::model()->findAll($criteria); 
        return $data;
	}

	/**
	 * 返回热点浏览量
	 * panrj 2014-07-09
	 * @return int
	 */
	public function countBrowse()
	{
		$data = $this->getClientLogData('Browse');
        return count($data);
	}

	/**
	 * 返回热点参与量
	 * panrj 2014-07-09
	 * @return int
	 */
	public function countJoin()
	{
		$data = $this->getClientLogData('Join');
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
        $criteria->select = "DATE_FORMAT( `creationtime`, '%Y-%m-%d') `date` , COUNT(IF(`action`='Join',TRUE,NULL)) `join`, COUNT(IF(`action`='Browse',TRUE,NULL)) `browse`";
        $criteria->compare('target','Focus',true);
        $criteria->compare('tid',$this->fid);
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
	 * @return Focus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
