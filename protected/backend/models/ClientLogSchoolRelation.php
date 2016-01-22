<?php

/**
 * This is the model class for table "{{client_log_school_relation}}".
 *
 * The followings are the available columns in table '{{client_log_school_relation}}':
 * @property integer $clid
 * @property string $userid
 * @property string $target
 * @property integer $tid
 * @property string $action
 * @property string $sid
 * @property string $sname
 * @property integer $gid
 * @property string $gname
 * @property integer $aid
 * @property string $aname
 * @property integer $cid
 * @property string $cname
 * @property string $creationtime
 */
class ClientLogSchoolRelation extends CActiveRecord
{
	public $date;
	public $buy;
	public $browse;
	public $commemt;
	public $join;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{client_log_school_relation}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clid, userid, target, tid, action, sid, sname, gid, gname, aid, aname, cid, cname', 'required'),
			array('clid, tid, gid, aid, cid', 'numerical', 'integerOnly'=>true),
			array('userid, target, sname, gname, aname, cname, moid', 'length', 'max'=>20),
			array('action', 'length', 'max'=>50),
			array('sid', 'length', 'max'=>10),
			array('comment, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('clid, userid, target, tid, action, sid, sname, gid, gname, aid, aname, cid, cname, creationtime, moid, comment', 'safe', 'on'=>'search'),
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
			'clid' => '日志ID',
			'userid' => '客户手机号码',
			'target' => '目标：Focus热点；Advertisement广告；Information资讯；Mall商品',
			'tid' => '目标id',
			'action' => '动作：Browse浏览；Buy购买兑换；Join参与；Comment评论',
			'sid' => '学校ID',
			'sname' => '学校名称',
			'gid' => '年级ID',
			'gname' => '年级名称',
			'aid' => '区ID',
			'aname' => '区名称',
			'cid' => '城市ID',
			'cname' => '城市名称',
			'creationtime' => '创建时间',
			'moid' => '订单号：只针对商品评论生效',
			'comment' => '评论',
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

		$criteria->compare('clid',$this->clid);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('tid',$this->tid);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('sname',$this->sname,true);
		$criteria->compare('gid',$this->gid);
		$criteria->compare('gname',$this->gname,true);
		$criteria->compare('aid',$this->aid);
		$criteria->compare('aname',$this->aname,true);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('cname',$this->cname,true);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('moid',$this->moid,true);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 返回临时表中记录的最大日志ID
	 * panrj 2014-07-09
	 * @return int
	 */
	public static function getMaxLogPk()
	{
		$sql = "SELECT MAX(clid) clid FROM `tb_client_log_school_relation`";
		$model = self::model()->findBySql($sql);
		return $model->clid;
	}

	public static function LoadClientLog($lastid)
	{
		$criteria = new CDbCriteria();
		if($lastid){
			$criteria->compare('clid','>'.$lastid);
		}
		// 只同步今天以前的数据
		$date = date('Y-m-d',time()).' 00:00:00';
        $criteria->compare('creationtime','<'.$date);
        $criteria->limit=1000;
        $data = ClientLog::model()->findAll($criteria); 
        return $data;
	}

	/**
	 * 客户日志分页数据
	 * panrj 2014-07-09
	 * @param array $parms 查询条件及分页参数
	 * @return array $result 
	 */
	public function pageData($parms=array())
	{
		$result = array();
		$criteria = new CDbCriteria();
		if(isset($parms['tid'])){
        	$criteria->compare('tid',$parms['tid'],true);
        }
        if(isset($parms['action'])){
        	$criteria->compare('action',$parms['action'],true);
        }
        if(isset($parms['target'])){
        	$criteria->compare('target',$parms['target'],true);
        }
        if(isset($parms['sid']) && $parms['sid']){
        	$criteria->compare('sid',$parms['sid']);
        }
        if(isset($parms['gid']) && $parms['gid']){
        	$criteria->compare('gid',$parms['gid']);
        }
        if(isset($parms['aid']) && $parms['aid']){
        	$criteria->compare('aid',$parms['aid']);
        }
        if(isset($parms['cid']) && $parms['cid']){
        	$criteria->compare('cid',$parms['cid']);
        }
        if(isset($parms['sdate']) && $parms['sdate']){
        	$sdate = $parms['sdate'].' 00:00:00';
        	$criteria->compare('creationtime','>='.$sdate);
        }
        if(isset($parms['edate']) && $parms['edate']){
        	$edate = $parms['edate'].' 23:59:59';
        	$criteria->compare('creationtime','<='.$edate);
        }

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

	public function getMobilephone()
	{
		$userid = $this->userid;
		$user = Member::model()->findByPk($userid);
		if($user){
			return $user->mobilephone;
		}
		return '';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ClientLogSchoolRelation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
