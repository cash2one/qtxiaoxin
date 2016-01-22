<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $uid
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $lastlogintime
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Advertisement[] $advertisements
 * @property Business[] $businesses
 * @property Contract[] $contracts
 * @property Focus[] $focuses
 */
class User extends MasterActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, name, mail', 'required'),
			array('state, deleted, type', 'numerical', 'integerOnly'=>true),
			array('username, name, qq, mobile', 'length', 'max'=>20),
			// array('username', 'unique', 'message'=>'用户已存在'),
			array('password, mail, logo', 'length', 'max'=>64),
			array('lastlogintime, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uid, username, password, name, lastlogintime, state, creationtime, updatetime, deleted, qq, mobile, mail, logo', 'safe', 'on'=>'search'),
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
			'advertisements' => array(self::HAS_MANY, 'Advertisement', 'uid'),
			'businesses' => array(self::HAS_MANY, 'Business', 'uid'),
			'contracts' => array(self::HAS_MANY, 'Contract', 'uid'),
			'focuses' => array(self::HAS_MANY, 'Focus', 'uid'),
            'configs' => array(self::HAS_ONE, 'WorkParam', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uid' => '用户ID',
			'username' => '用户名',
			'password' => '密码',
			'name' => '真实姓名',
			'mobile' => '手机',
			'qq' => 'qq号码',
			'mail' => '公司邮箱',
			'logo' => '头像',
			'lastlogintime' => '最后登录时间',
			'state' => '状态',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '停用',
			'type' => '账号类型',
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

		$criteria->compare('uid',$this->uid);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lastlogintime',$this->lastlogintime,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		// $criteria->scopes='normal';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 记录用户登录日期
	 * panrj 2014-05-16
	 * @return model 
	 */
	public function setLoginTime()
    {
        $this->lastlogintime = date("Y-m-d H:i:s");
        $this->save();
        return $this;
    }

    /**
	 * 增加用户删除记录
	 * panrj 2014-05-16
	 * @return none 
	 */
    public function addDeleteRecord()
    {
    	$delete_model = new UserDelete;
    	$delete_model->attributes = $this->attributes;
    	$delete_model->uid = $this->uid;
    	$delete_model->save();
    }

    /**
	 * 返回用户停用启用状态数组
	 * panrj 2014-05-16
	 * @return array 
	 */
    public static function getDisableArr()
    {
    	$arr = array(
    		'1'=>'启用',
    		'0'=>'停用',
    	);
    	return $arr;
    }

    /**
	 * 返回用户停用启用状态
	 * panrj 2014-05-16
	 * @param bool $reverse 取反
	 * @return string 
	 */
    public function getDisableState($reverse=false)
    {
    	$arr = self::getDisableArr();
    	if($reverse){
    		$state = $this->state==0 ? 1 : 0;
    		return $arr[$state];
    	}else{
    		return $arr[$this->state];
    	}
    	
    }

    /**
	 * 检查用户是否被停用
	 * panrj 2014-05-16
	 * @param int $pk 用户主键
	 * @return bool (停用)true 
	 */
    public static function checkUserDisable($pk)
    {
    	$umodel = self::model()->findByPk($pk);
    	if($umodel->state==1){
    		return false;
    	}
    	return true;
    }

    /**
	 * 检查用户是否存在
	 * panrj 2014-07-08
	 * @param int $pk 用户主键
	 * @return int $count 
	 */
    public static function countUserExsit($uname,$pk='')
    {
    	$criteria = new CDbCriteria();
    	$criteria->compare('username',$uname,true);
    	if($pk)
        	$criteria->addCondition('uid!='.$pk);
    	$criteria->scopes='normal'; 
        $count = self::model()->count($criteria);
    	return $count;
    }

    /**
	 * 检查用户是否被停用或删除
	 * panrj 2014-07-07
	 * @param int $pk 用户主键
	 * @return bool (停用)true 
	 */
    public static function checkUserDisableOrDeleted($pk)
    {
    	$umodel = self::model()->findByPk($pk);
    	if(!$umodel){
    		return true;
    	}
    	if($umodel->state==1 && $umodel->deleted==0){
    		return false;
    	}
    	return true;
    }

    /**
	 * 根据id获取用户名称
	 * panrj 2014-05-16
	 * @param int $pk 用户主键
	 * @return bool 
	 */
    public static function getUserName($pk)
    {
    	$umodel = self::model()->findByPk($pk);
    	return $umodel->name;
    }

    public static function getLastUserUid()
    {
    	$sql = "SELECT MAX(uid) muid FROM `tb_user`";
		$result = yii::app()->db->createCommand($sql);
        $query = $result->queryRow();
        return $query['muid'];
    }

    public static function getLastUsername()
    {
    	$lastuid = self::getLastUserUid();
		$luid = $lastuid + 1;
		$luname = 'q'.$luid.rand(0,99);
		return $luname;
    }


    /**
     * 获取绩效用户配置信息
     * @param array $parms
     * @return array
     */
    public function getUserConfigs($parms = array())
    {
        $result = array();

        $criteria = new CDbCriteria();
        $criteria->with = array('configs');

        $criteria->compare('t.deleted', 0);
        $criteria->compare('t.state', 1);
        $criteria->compare('t.type', 0);

        $criteria->order = 't.creationtime DESC';
        $count = self::model()->count($criteria);
        $pager = new CPagination($count);

        if(isset($parms['size']) && $parms['size']){
            $pager->pageSize = $parms['size'];
        }else{
            $pager->pageSize = 200;
        }

        $pager->applyLimit($criteria);

        $datalist = self::model()->findAll($criteria);

        usort($datalist, function($a, $b){
            if( true == isset($a['name']) && true == isset($b['name']) ){
                if (preg_match('/^\d+/', $a['name'], $match1) || preg_match('/^\d+/', $b['name'], $match2)) {
                    if (!empty($match1) || !empty($match2)) {
                        if ($a['name'] > $b['name']) return 1;
                        if ($a['name'] == $b['name']) return 0;
                        if ($a['name'] < $b['name']) return -1;
                    }
                    return 0;
                }
                $aword = MainHelper::getFirstCharter($a['name']);
                $bword = MainHelper::getFirstCharter($b['name']);
                if( $aword > $bword ){
                    return 1;
                }

                if( $aword == $bword ){
                    return 0;
                }

                if( $aword < $bword ){
                    return -1;
                }
            }

            return 0;
        });

        $result['model'] = $datalist;
        $result['pages'] = $pager;
        $result['pagerConfig'] = array('perPage' => 200, 'total' => $count);
        return $result;
    }

    /**
	 * 用户列表分页数据
	 * panrj 2014-05-19
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
    public function pageData($parms=array())
	{
		$result = array();
		$criteria = new CDbCriteria();
		//关键词模糊查询
		if(isset($parms['name']) && $parms['name']!=''){
        	$criteria->compare('name',$parms['name'],true);
        	$criteria->compare('username',$parms['name'],true,'OR');
        }
        //创建时间查询
        if(isset($parms['creationtime']) && $parms['creationtime']){
        	$criteria->compare('creationtime','>='.$parms['creationtime'],true);
        }
        if(isset($parms['deleted'])){
        	// var_dump($parms['deleted']);exit;
        	$criteria->compare('deleted',$parms['deleted'],true);
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
	 * 返回后台账号类型数组
	 * panrj 2014-11-12
	 * @return array
	 */
	public static function getTypeArr()
	{
		$arr = array('0'=>'后台账号','1'=>'机构账号','2'=>'商户账号','3'=>'机构商户通用账号');
		return $arr;
	}

	/**
	 * 账号类型查询账号
	 * panrj 2014-11-13
	 * @param array $parms 查询条件
	 * @return ar $result 
	 */
	public static function getUserArr($parms=array())
	{
		$criteria = new CDbCriteria();
		if(isset($parms['type']) && $parms['type']!=''){
			$type = array($parms['type'],3);
			$criteria->compare('type',$type);
		}
    	$criteria->compare('deleted',0);
        $data = self::model()->findAll($criteria);
        return $data;
	}
}
