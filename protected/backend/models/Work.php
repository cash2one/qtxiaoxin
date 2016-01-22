<?php

/**
 * This is the model class for table "{{work}}".
 *
 * The followings are the available columns in table '{{work}}':
 * @property string $id
 * @property string $userid
 * @property integer $score
 * @property string $fromuserid
 * @property string $scoredate
 * @property string $deleted
 * @property string $creationtime
 * @property string $updatetime
 */
class Work extends MasterActiveRecord
{
    const USER_STATE_YES = 1;        // 关联用户表的状态，为启用状态
    const USER_DELETED_NOT = 0;      // 关联用户表的删除，为未删除
    const USER_TYPE_BACK = 0;        // 关联用户表的类型，未后台添加

    const RANKING_PAGE_SITE = 500;   // 排名列表分页行数
    const WORK_DELETED_NOT = 0;     // 该打分记录未删除
    const WORK_DELETED_YES = 1;     // 该打分记录已删除

    const LOG_PAGE_SITE = 30;       // 操作日志分页行数

    static $cacheUserMap = array();     // 缓存用户id为key，用户名为value的数组

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{work}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, score, fromuserid, scoredate', 'required'),
			array('score', 'numerical', 'integerOnly'=>true),
			array('userid, fromuserid', 'length', 'max'=>20),
			array('deleted', 'length', 'max'=>10),
			array('creationtime, updatetime', 'safe'),
			array('score', 'authInput'), // 打分人数检验
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, userid, score, fromuserid, scoredate, deleted, creationtime, updatetime', 'safe', 'on'=>'search'),
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
		    'user' => array(self::BELONGS_TO, 'User', 'userid', 'on'=>'user.state ='
		                  .self::USER_STATE_YES.' AND user.deleted = '.self::USER_DELETED_NOT.' AND user.type ='.self::USER_TYPE_BACK),
		);
	}

	/**
	 * 认证打分限制人次
	 * @param unknown $attribute
	 * @param unknown $params
	 */
	public function authInput( $attribute, $params )
	{
	    if( false == $this->fromuserid ){
	        $this->addError('fromuserid', '用户id为空，失败!');
	    }
	    else{
    	    $row = WorkParam::model()->find( 'userid=:userid AND deleted = :deleted'
    	                                       , array(':userid'=>$this->fromuserid, ':deleted'=>self::USER_DELETED_NOT) );

    	    if( true == isset( $row['maxlimit'] ) && $row['maxlimit'] > 0 ){
    	        $criteria = new CDbCriteria();
    	        $todayMonth = date('Y-m');   // 这个月

    	        $criteria->compare('DATE_FORMAT(t.scoredate,\'%Y-%m\')', $todayMonth);
    	        $criteria->compare('fromuserid', $this->fromuserid);
    	        $criteria->compare('t.deleted', self::WORK_DELETED_NOT);
    	        $criteria->select = 'COUNT( DISTINCT(t.userid) ) AS userid';

    	        $model = $this->find($criteria);

    	        if( true == isset($model['userid']) && ( $row['maxlimit'] - $model['userid'] ) <= 0  ){
    	           $this->addError('score', '超过了限定的'.$row['maxlimit'].'次, 失败！');
    	        }
    	        else{
//     	            $criteria->select = 'userid';
//     	            $criteria->compare('fromuserid', $this->fromuserid);
//     	            $model = $this->find($criteria);

//     	            if( null !== $model ){
//     	                $this->addError('fromuserid', '用户id值'.$this->userid.'本月已评分，失败！');
//     	            }

    	            // 通过验证
    	            return true;
    	        }
    	    }
    	    else{
    	        $this->addError('score', '没有用户id值'.$this->userid.'的验证, 失败！');
    	    }
	    }
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '主键',
			'userid' => '用户id',
			'score' => '得分',
			'fromuserid' => '打分用户id',
			'scoredate' => '分数作用月份的日期',
			'deleted' => '删除 0:正常 1:已删除',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('score',$this->score);
		$criteria->compare('fromuserid',$this->fromuserid,true);
		$criteria->compare('scoredate',$this->scoredate,true);
		$criteria->compare('deleted',$this->deleted,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Work the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	/**
	 * 获取后台所有人员的映射关系数组
	 * @return array 一个id为key，用户名为value的数组
	 */
	public function getAllUsersMap()
	{
	    if( false == self::$cacheUserMap ){
    	    $user = User::model();
    	    $criteria = new CDbCriteria;
    	    $criteria->compare('type', self::USER_TYPE_BACK);
    	    $criteria->limit = 500;    // 目前考核人数为40，已经适用

    	    $models = $user->findAll($criteria);

    	    foreach ( $models as $key => $value ){
                if( true == isset($value['uid']) && true == isset($value['name'])  ){
                    self::$cacheUserMap[$value['uid']] = $value['name'];
                }
    	    }
	    }

	    return self::$cacheUserMap;
	}


	/**
	 * 使用用户id获取用户名称
	 * @param number $userid
	 * @return string|Ambigous <CActiveRecord>
	 */
	public function getNameByUserId( $userid )
	{
        if( false == $userid ){
            return '';
        }

        $usersMap = $this->getAllUsersMap();

        if( true == isset($usersMap[ $userid ]) ){
            return $usersMap[ $userid ];
        }

        return '';
	}

	/**
	 * 获取所有用户的分页记录
	 * @return multitype:CActiveRecord
	 */
	public function getLogUserList( $search = '', $fromUser = false , $otherMath = false )
	{
	    $user = new User();
	    $criteria = new CDbCriteria;

	    $criteria->order = 't.id DESC';

	    if( false == $fromUser ){
	        $joinKey = 't.userid=user.uid';
	    }
	    else{
            $joinKey = 't.fromuserid=user.uid';
	    }

	    if( false == $otherMath ){
	        $otherMath  = date('Y-m');   // 这个月
	    }

	    $criteria->compare('t.deleted', self::WORK_DELETED_NOT);
	    $criteria->compare('DATE_FORMAT(t.scoredate,\'%Y-%m\')', $otherMath);

	    $criteria->join = 'left join '.$user->tableName().' user on('.$joinKey.')'; //连接表

	    if( true == trim($search) ){
	        $criteria->addSearchCondition('user.name', $search );
	    }

	    $count = $this->count($criteria);
	    $pages = new CPagination($count);

	    $pages->pageSize = self::LOG_PAGE_SITE;
	    $pages->applyLimit($criteria);
	    $models = $this->findAll($criteria);

	    return array('models'=>$models,'pages'=>$pages);
	}


	/**
	 * 获取所有用户的分页记录
	 * @return multitype:CActiveRecord
	 */
	public function getUserList( $search = '', $limitUserId = array() )
	{
	    $user = User::model();
	    $criteria = new CDbCriteria;

	    if( true == trim($search) ){
	        $criteria->addSearchCondition('name', $search );
	    }
	    
	    if( true == $limitUserId ){
	        $criteria->addInCondition( 'uid', $limitUserId );
	    }

	    $criteria->compare('deleted', self::USER_DELETED_NOT);
	    $criteria->compare('state', self::USER_STATE_YES);
	    $criteria->compare('type', self::USER_TYPE_BACK);
	    $criteria->compare('uid', '<>'.Yii::app()->user->id);
	    $count = $user->count($criteria);
	    $pages = new CPagination($count);

	    $pages->pageSize = self::RANKING_PAGE_SITE;
	    $pages->applyLimit($criteria);

	    $criteria->order = 'name DESC';

	    $models = $user->findAll($criteria);

	    usort($models, function($a, $b){
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

	    return array('models'=>$models,'pages'=>$pages);
	}

	/**
	 * 获取当月的分数排名记录
	 * @return multitype:CActiveRecord
	 */
	public function getRankingList($param = array())
	{
        if (!empty($param) && isset($param['month']))
            $todayMonth = $param['month'];
        else
	        $todayMonth = date('Y-m');   // 这个月

	    $criteria = new CDbCriteria;

	    $criteria->order = 't.score DESC';
	    $criteria->group = 't.userid';
	    $criteria->select = 'COUNT(DISTINCT(t.fromuserid)) AS fromuserid, AVG(t.score) AS score';
	    $criteria->order = 'score DESC';
	    $criteria->compare('DATE_FORMAT(t.scoredate,\'%Y-%m\')', $todayMonth);

	    $criteria->compare('t.deleted', self::WORK_DELETED_NOT);
	    $count = $this->with('user')->count($criteria);
	    $pages = new CPagination($count);

	    $pages->pageSize = self::RANKING_PAGE_SITE;
	    $pages->applyLimit($criteria);
	    $models = $this->with('user')->findAll($criteria);

	    return array('models'=>$models,'pages'=>$pages);
	}

	/**
	 * 获取自身打分过的用户数据
	 * @return multitype:CPagination multitype:CActiveRecord
	 */
	public function getSelfChangeUser($limit = 0, $limitUserId = array() )
	{
	    $criteria = new CDbCriteria;
	    $todayMonth = date('Y-m');   // 这个月
	    $criteria->compare('DATE_FORMAT(t.scoredate,\'%Y-%m\')', $todayMonth);

	    $criteria->compare('t.deleted', self::USER_DELETED_NOT);
	    $criteria->compare('t.fromuserid', Yii::app()->user->id );
	    
	    if( true == $limitUserId ){
	        $criteria->addInCondition( 't.userid', $limitUserId );
	    }

	    $count = $this->with('user')->count($criteria);
	    
	    $pages = new CPagination($count);
	    if ($limit === 0) {
            $pages->pageSize = self::RANKING_PAGE_SITE;
        } else {
            $pages->pageSize = $limit;
        }
	    $pages->applyLimit($criteria);
	    $models = $this->with('user')->findAll($criteria);

	    return array('models'=>$models,'pages'=>$pages);
	}


	/**
	 * 计算原始总分
	 * @param array $scores
	 * @return NULL|Ambigous <NULL, unknown>
	 */
	protected function getAllOrgScore( $scores )
	{
	    if( false == $scores || false == is_array($scores) ){
	        return null;
	    }

	    $userids = array_keys($scores);
	    $criteria = new CDbCriteria();
	    $criteria->addInCondition('userid', $userids );
	    $criteria->select = 'SUM(orgscore) AS orgscore';
	    $config = WorkParam::model()->find( $criteria );

	    return isset($config['orgscore'])&&true == $config['orgscore']?$config['orgscore']:null;
	}

	/**
	 * 检查提交总分是否超过了基本分
	 * @param array $scores
	 * @return boolean
	 */
	protected function checkFormatAllScore( $scores )
	{
	    arsort( $scores );
	    $last = 0;
	    $sum  = 0;
	    $orgSum = $this->getAllOrgScore( $scores );

	    foreach ( $scores as $k => $v )
	    {
	        if( true == $last ){
	            if( $last < ($v+10)  ){
	                $this->addError('score', '每人至少要相差10分，例如70分、 80分、 90分，失败！');
	                break;
	            }
	        }
	        else{
	            $last = (int)$v;
	        }

	        $sum += (int)$v;
	    }

	    if( $sum <= $orgSum && true == $orgSum ){
	        return true;
	    }
	    else{
	        $this->addError('score', '您的总分'.$sum.'分超过总基本分'.$orgSum.'分，失败！');
	        return false;
	    }

	}


	/**
	 * 保存自身打分数据，时候逻辑删除当月历史打分数据
	 * @param array $scores 用户id为key的数组
	 * @return boolean
	 */
	public function saveUser( $scores, $rowids )
	{
        if(  false == $scores ){
            return false;
        }

        $this->checkFormatAllScore( $scores );

        $transaction = $this->dbConnection->beginTransaction();

        try {
            $this->deleteSelfChangedUser();

            foreach( $scores as $key=>$value )
            {
                $model = clone $this;
                $model->id = isset($rowids[$key])?trim($rowids[$key]):null;
                $model->fromuserid = Yii::app()->user->id;
                $model->userid = $key;
                $model->score = $value;
                $model->deleted = self::WORK_DELETED_NOT;
                $model->scoredate = date('Y-m-d');
                $model->isNewRecord = isset($rowids[$key])?!$rowids[$key]:true;
                $model->save();
                
                if( true ==$model->hasErrors() ){
                    $this->addErrors( $model->getErrors() );
                }
            }

    	    $transaction->commit();
    	    $result = true;
	    } catch (Exception $e) {
	        $transaction->rollBack();
	        $result = false;
	    }

	    return $result;
	}

    public function deleteRecordByIds($ids = null)
    {
        $criteria = new CDbCriteria;
        $todayMonth = date('Y-m');   // 这个月
        $criteria->compare('DATE_FORMAT(scoredate,\'%Y-%m\')', $todayMonth);

        if ($ids !== null) {
          $criteria->addCondition('fromuserid in ('. $ids . ')');
        }

        $data = $this->findAllByAttributes(array('deleted' => self::WORK_DELETED_NOT), $criteria);

        if (!empty($data)) {
            $this->updateAll(array('deleted' => self::WORK_DELETED_YES), $criteria);
        } else {
            return true;
        }
    }

	/**
	 * 逻辑删除自身用户id打分的数据
	 */
	public function deleteSelfChangedUser()
	{
	    $criteria = new CDbCriteria;
	    $todayMonth = date('Y-m');   // 这个月
	    $criteria->compare('DATE_FORMAT(scoredate,\'%Y-%m\')', $todayMonth);
	    $criteria->compare('fromuserid', Yii::app()->user->id);

	    $this->updateAll( array('deleted'=>self::WORK_DELETED_YES ), $criteria);
	}

	/**
	 * 获取错误消息的第一条
	 * @param array $errors
	 * @return string
	 */
	public function getErrorMsg()
	{
	    $errors = $this->getErrors();

        if( true == is_array( $errors ) ){
            $error = (array)reset( $errors);

            return reset( $error );
        }

        return '';
	}
}
