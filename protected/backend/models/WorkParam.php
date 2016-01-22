<?php

/**
 * This is the model class for table "{{work_config}}".
 *
 * The followings are the available columns in table '{{work_config}}':
 * @property string $id
 * @property string $userid
 * @property integer $orgscore
 * @property integer $minlimit
 * @property integer $maxlimit
 * @property integer $deleted
 * @property string $updatetime
 * @property string $creationtime
 */
class WorkParam extends MasterActiveRecord
{

    const CONFIG_NOT_DELETED = 0;
    const ACCOUNT_TYPE = 0;
    const ACCOUNT_STATE = 1;
    const ACTION_ERROR_CODE = 0;
    const ACTION_SUCCESS_CODE = 1;
    const PER_PAGE_NUM = 200;
    const DEFAULT_MIN_LIMIT = 2;
    const DEFAULT_MAX_LIMIT = 3;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{work_config}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid', 'required'),
			array('orgscore, minlimit, maxlimit, deleted', 'numerical', 'integerOnly'=>true),
			array('userid', 'length', 'max' => 20),
            array('orgscore, minlimit, maxlimit', 'numerical', 'min' => 0, 'max' => 100),
			array('updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userid, orgscore, minlimit, maxlimit, deleted, updatetime, creationtime', 'safe', 'on'=>'search'),
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
            'u' => array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '配置主键',
			'userid' => '用户id',
			'orgscore' => '原始分数',
			'minlimit' => '最少打分人数',
			'maxlimit' => '最多打分人数',
			'deleted' => '删除 0:正常 1:已删除',
			'updatetime' => '更新时间',
			'creationtime' => '创建时间',
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

		$criteria->compare('id', $this->id,true);
		$criteria->compare('userid', $this->userid,true);
		$criteria->compare('orgscore', $this->orgscore);
		$criteria->compare('minlimit', $this->minlimit);
		$criteria->compare('maxlimit', $this->maxlimit);
		$criteria->compare('deleted', $this->deleted);
		$criteria->compare('updatetime', $this->updatetime,true);
		$criteria->compare('creationtime', $this->creationtime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * [获取账号]
     * @param $userid [用户ID]
     * @return bool|object
     */
    public function getConfig($userid)
    {
        $user = User::model()->findByPk($userid,
            "deleted = ". self::CONFIG_NOT_DELETED ." AND type = ". self::ACCOUNT_TYPE . " AND state = ". self::ACCOUNT_STATE);
        if ($user === null) {
            return array('code' => self::ACTION_ERROR_CODE, 'msg' => '用户ID{'. $userid .'}不是合法的操作对象');
        }
        $data = array();
        $config = self::model()->find('userid = :userid AND deleted = :deleted', array(':userid' => $userid, ':deleted' => self::CONFIG_NOT_DELETED));
        if ($config === null) {
            $id = $this->newConfig($userid);
            if ($id !== false) {
                $config = self::model()->findByPk($id);
                $data['code'] = self::ACTION_SUCCESS_CODE;
                $data['config'] = $config;
                $data['user'] = array('username' => $user->username, 'logo' => $user->logo);
                return $data;
            } else {
                return array('code' => self::ACTION_ERROR_CODE, 'msg' => '创建用户绩效配置失败!');
            }
        }
        $data['code'] = self::ACTION_SUCCESS_CODE;
        $data['config'] = $config;
        $data['user'] = array('username' => $user->username, 'logo' => $user->logo);
        return $data;
    }

    /**
     * [新建用户配置信息]
     * @param $userid
     * @return bool|string
     */
    public function newConfig($userid)
    {
        $creationtime = date("Y-m-d H:i:s");
        $this->userid = $userid;
        $this->creationtime = $creationtime;
        $this->minlimit = self::DEFAULT_MIN_LIMIT;
        $this->maxlimit = self::DEFAULT_MAX_LIMIT;
        $result = $this->save();
        if ($result === true)
            return $this->id;
        return false;
    }

    /**
     * [更新用户配置信息]
     * @param $userid
     * @param $config
     * @return bool
     */
    public function updateConfig($userid, $config)
    {
        $updatetime = date("Y-m-d: H:i:s");
        $workParm = self::model()->find('userid = :userid AND deleted = :deleted', array(':userid' => $userid, ':deleted' => self::CONFIG_NOT_DELETED));
        $workParm->orgscore = (int)$config['orgscore'];
        $workParm->minlimit = (int)$config['minlimit'];
        $workParm->maxlimit = (int)$config['maxlimit'];
        $workParm->updatetime = $updatetime;
        if ($workParm->save()) {
            return true;
        } else if ($workParm->hasErrors()) {
            return $workParm->getErrors();
        } else {
            return false;
        }
    }

    /**
     * [获取用户列表]
     * @param array $parms
     * @return array
     */
    public function getUserList($parms = array())
    {
        $result = array();
        $criteria = new CDbCriteria();
        $criteria->with = array('u');

        $criteria->compare('t.deleted', self::CONFIG_NOT_DELETED);
        $criteria->compare('u.state', self::ACCOUNT_STATE);
        $criteria->compare('u.deleted', 0);

        $criteria->order = 't.creationtime DESC';
        $count = self::model()->count($criteria);
        $pager = new CPagination($count);

        if(isset($parms['size']) && $parms['size']){
            $pager->pageSize = $parms['size'];
        }else{
            $pager->pageSize = self::PER_PAGE_NUM;
        }

        $pager->applyLimit($criteria);

        $datalist = self::model()->findAll($criteria);

        usort($datalist, function($a, $b){
            if( true == isset($a['u']['name']) && true == isset($b['u']['name']) ){
                $aword = MainHelper::getFirstCharter($a['u']['name']);
                $bword = MainHelper::getFirstCharter($b['u']['name']);
        
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
        $result['pagerConfig'] = array('perPage' => self::PER_PAGE_NUM, 'total' => $count);

        return $result;
    }

    /**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WorkConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
