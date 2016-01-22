<?php

/**
 * This is the model class for table "{{information}}".
 *
 * The followings are the available columns in table '{{information}}':
 * @property integer $iid
 * @property string $title
 * @property string $summery
 * @property string $text
 * @property string $image
 * @property string $bigimage
 * @property string $source
 * @property string $url
 * @property integer $ikid
 * @property integer $bid
 * @property integer $uid
 * @property integer $head
 * @property integer $headtop
 * @property integer $kindtop
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property ContractInfomationRelation[] $contractInfomationRelations
 * @property InformationKind $ik
 * @property User $u
 * @property Business $b
 * @property InformationComment[] $informationComments
 */
class Information extends MasterActiveRecord
{
	public $contype;
	public $startdate;
	public $enddate;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{information}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, summery, image, bigimage, ikid, uid', 'required'),
			array('ikid, bid, uid, head, headtop, kindtop, state, deleted, total', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>256),
			array('summery', 'length', 'max'=>256),
			array('image, bigimage, source, url', 'length', 'max'=>256),
			array('text, updatetime, url, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('iid, title, summery, text, image, bigimage, source, url, ikid, bid, uid, head, headtop, kindtop, state, creationtime, updatetime, deleted, total', 'safe', 'on'=>'search'),
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
			'contractInfomationRelations' => array(self::HAS_MANY, 'ContractInfomationRelation', 'iid'),
			'ik' => array(self::BELONGS_TO, 'InformationKind', 'ikid'),
			'u' => array(self::BELONGS_TO, 'User', 'uid'),
			'b' => array(self::BELONGS_TO, 'Business', 'bid'),
			'informationComments' => array(self::HAS_MANY, 'InformationComment', 'iid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'iid' => '资讯ID',
			'title' => '标题',
			'summery' => '摘要',
			'text' => '正文',
			'image' => '图片',
			'bigimage' => '大图片',
			'source' => '来源',
			'url' => '外链地址',
			'ikid' => '资讯种类',
			'bid' => '商家',
			'uid' => '创建者',
			'head' => '头条',
			'headtop' => '头条置顶',
			'kindtop' => '种类置顶',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '已删除',
			'total' => '评论条数',
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

		$criteria->compare('iid',$this->iid);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('summery',$this->summery,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('bigimage',$this->bigimage,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('ikid',$this->ikid);
		$criteria->compare('bid',$this->bid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('head',$this->head);
		$criteria->compare('headtop',$this->headtop);
		$criteria->compare('kindtop',$this->kindtop);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getKindTopArr()
	{
		$arr = array(
			'1'=>'置顶','0'=>'不置顶',
		);
		return $arr;
	}

	/**
	 * 资讯列表分页数据
	 * panrj 2014-06-17
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageData($parms=array(),$ty='')
	{
		$result = array();
		$criteria = new CDbCriteria();
		$criteria->addCondition('bid IS NOT NULL');
		if(isset($parms['title']) && $parms['title']!=''){

        	$criteria->compare('title',$parms['title'],true);
        }
		if(isset($parms['bid']) && $parms['bid']){
        	$criteria->compare('bid',$parms['bid']);
        }
        if(isset($parms['ikid']) && $parms['ikid']){
        	$criteria->compare('ikid',$parms['ikid']);
        }
        if(isset($parms['head'])){
        	$criteria->compare('head',$parms['head']);
        }
        if(isset($parms['contype']) && $parms['contype']){
  			if($parms['contype']=='1'){
  				$criteria->compare('connum',0);
  			}
  			if($parms['contype']=='2'){
  				$criteria->compare('connum','>0');
  			}
        }

        if(isset($parms['kindtop']) && $parms['kindtop']){
			$criteria->compare('kindtop',1);
		}
		if(isset($parms['headtop']) && $parms['headtop']){
			$criteria->compare('head',1);
			$criteria->compare('headtop',1);
		}

        $criteria->scopes='normal';
		$criteria->order = 'creationtime DESC';  
		
        $count = ViewInformationRelationCount::model()->count($criteria); 
        $pager = new CPagination($count);
        if(isset($parms['size']) && $parms['size']){
        	$pager->pageSize = $parms['size']; 
        }else{
        	$pager->pageSize = 15;  
        }               
        $pager->applyLimit($criteria);

        $datalist = ViewInformationRelationCount::model()->findAll($criteria);

        $result['model'] = $datalist;
        $result['pages'] = $pager;
        
        return $result;
	}

	/**
	 * 开放资讯列表分页数据
	 * panrj 2014-06-17
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageDataPublic($parms=array(),$ty='')
	{
		$result = array();
		$criteria = new CDbCriteria();
		$criteria->addCondition('ISNULL(bid)');
		if(isset($parms['state']) && $parms['state']){
			$criteria->compare('state',$parms['state']);
		}
		if(isset($parms['title']) && $parms['title']!=''){

        	$criteria->compare('title',$parms['title'],true);
        }
        if(isset($parms['ikid']) && $parms['ikid']){
        	$criteria->compare('ikid',$parms['ikid']);
        }
        if(isset($parms['head'])){
        	$criteria->compare('head',$parms['head']);
        }

        if(isset($parms['kindtop']) && $parms['kindtop']){
			$criteria->compare('kindtop',1);
		}
		if(isset($parms['headtop']) && $parms['headtop']){
			$criteria->compare('head',1);
			$criteria->compare('headtop',1);
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

	public static function getConTypeArr()
	{
		$arr = array(
			'1'=>'未配置',
			'2'=>'已配置',
		);
		return $arr;
	}

	/**
	 * 获取资讯合同关联记录
	 * panrj 2014-06-17
	 * @return int $num 
	 */
	public function getConInfoRelation()
	{
		$criteria=new CDbCriteria;
		$criteria->scopes='normal';
		$criteria->compare('iid',$this->iid);
		$data = ContractInfomationRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 资讯关联合同数量
	 * panrj 2014-06-17
	 * @return int $num 
	 */
	public function countConInfoRelation()
	{
		$data = $this->getConInfoRelation();
		return count($data);
	}

	public static function getDisableArr()
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

	public function getHeadStatus()
	{
		if($this->head){
			if($this->headtop){
				return '是 (置顶)';
			}else{
				return '是';
			}
		}else{
			return '否';
		}
	}

	public function getKindStatus()
	{
		$kname = InformationKind::getInfoKindName($this->ikid);
		if($this->kindtop){
			$kname .= ' (置顶)';
		}
		return $kname;
	}

	/**
	 * 获取热点名称
	 * panrj 2014-05-20
	 * @return string $name 
	 */
	public static function getInfoTitle($iid)
	{
		$info = Self::model()->loadByPk($iid);
		return $info->title;
	}

	public function addPublicInfoRelation($s)
    {
    	$relation = new ContractInfomationRelation;
    	$relation->startdate = $s;
    	$relation->iid = $this->iid;
    	$relation->save();
    }

    public function getPublicInfoRelation()
    {
    	$criteria=new CDbCriteria;
    	$criteria->compare('iid',$this->iid);
    	$criteria->addCondition('ISNULL(cid)');
    	$relation = ContractInfomationRelation::model()->find($criteria);
    	return $relation;
    }

    public function setPublicInfoRelation($s)
    {
    	$relation = $this->getPublicInfoRelation();
    	$relation->startdate = $s;
    	$relation->save();
    }

    public function getPublicInfoStartdate()
    {
    	if($this->iid){
    		$relation = $this->getPublicInfoRelation();
    		return $relation->startdate;
    	}else{
    		return date('Y-m-d H:i:s',time());
    	}
    }

    /**
	 * 查询资讯日志记录
	 * panrj 2014-07-09
	 * @param string $action 日志记录动作
	 * @return queryset $data 
	 */
	public function getClientLogData($action='Browse')
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('tid',$this->iid);
        $criteria->compare('target','Information',true);
        $criteria->compare('action',$action,true);
        $data = ClientLogSchoolRelation::model()->findAll($criteria); 
        return $data;
	}
	
	/**
	 * 获取分类置顶条数
	 * panrj 2014-07-31
	 * @param int $ikid 分类ID
	 * @return int
	 */
	public static function countKindTop($ikid,$iid='')
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('ikid',$ikid);
        $criteria->compare('kindtop',1);
		if($iid){
			$info = self::model()->findByPk($iid);
			if($info->ikid==$ikid)
				$criteria->addCondition('iid!='.$iid);
		}
		$criteria->scopes='normal';
        $data = self::model()->count($criteria); 

        return $data;
	}
	
	/**
	 * 获取分类置顶条数
	 * panrj 2014-07-31
	 * @param int $ikid 分类ID
	 * @return int
	 */
	public static function countHeadTop()
	{
		$criteria = new CDbCriteria();
    	$criteria->compare('head',1);
        $criteria->compare('headtop',1);
		$criteria->scopes='normal';
        $data = self::model()->count($criteria); 
        return $data;
	}

	/**
	 * 返回资讯浏览量
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
        $criteria->compare('target','Information',true);
        $criteria->compare('tid',$this->iid);
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
	 * @return Information the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
