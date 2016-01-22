<?php

/**
 * This is the model class for table "{{focus_answer}}".
 *
 * The followings are the available columns in table '{{focus_answer}}':
 * @property integer $faid
 * @property string $userid
 * @property integer $fqid
 * @property integer $fqiid
 * @property string $text
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property FocusQuestionItem $fqi
 * @property Client $userid0
 */
class FocusAnswer extends MasterActiveRecord
{
	public $items;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{focus_answer}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, fqid', 'required'),
			array('userid, fqid, fqiid, state, deleted', 'numerical', 'integerOnly'=>true),
			array('text, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('faid, userid, fqid, fqiid, text, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'fq' => array(self::BELONGS_TO, 'FocusQuestion', 'fqid'),
			'fqi' => array(self::BELONGS_TO, 'FocusQuestionItem', 'fqiid'),
			'userid0' => array(self::BELONGS_TO, 'Client', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'faid' => '活动回馈ID',
			'userid' => '用户ID',
			'fqid' => '问题',
			'fqiid' => '选项',
			'text' => '用户输入内容',
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

		$criteria->compare('faid',$this->faid);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('fqid',$this->fqid);
		$criteria->compare('fqiid',$this->fqiid);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 记录选项投票数据
	 * panrj 2014-06-23
	 * @param int $tid FocusQuestionItem主键
	 * @param string $uid 用户ID
	 */
	public static function setFocusVoteItem($tid,$uid)
	{
		$item = FocusQuestionItem::model()->LoadByPk($tid);
		$qid = $item->fqid;
		$model = new FocusAnswer;
		$model->fqid = $qid;
		$model->fqiid = $tid;
		$model->userid = $uid;
		$model->save();
	}

	/**
	 * 记录投票问卷数据
	 * panrj 2014-06-23
	 * @param int $qid FocusQuestion主键
	 * @param string $uid 用户ID
	 * @param string $text 问卷答复内容
	 */
	public static function setFocusVoteAnswer($qid,$uid,$text)
	{
		$model = new FocusAnswer;
		$model->fqid = $qid;
		$model->text = $text;
		$model->userid = $uid;
		$model->save();
	}

	/**
	 * 查询用户投票记录
	 * panrj 2014-06-23
	 * @param int $fid Focus主键
	 * @param string $uid 用户ID
	 * @return int $count 返回0表示用户尚未投票
	 */
	public static function countUserVote($fid,$uid)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('userid',$uid);
    	$criteria->with = array('fq');
		$criteria->compare('fq.fid',$fid);
		$criteria->compare('fq.deleted',0);
        $count = self::model()->count($criteria);
        return $count;
	}

	/**
	 * 返回用户问卷回复内容
	 * panrj 2014-06-23
	 * @param int $qid FocusQuestion主键
	 * @param string $uid 用户ID
	 * @return string
	 */
	public static function getVoteQuestionAnswer($qid,$uid)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('userid',$uid);
		$criteria->compare('fqid',$qid);
        $result = self::model()->find($criteria);
        if($result)
        	return $result->text;
        return '';
	}

	/**
	 * 返回单个选项在投票结果中的百分比
	 * panrj 2014-06-23
	 * @param int $tid FocusQuestionItem主键
	 * @param string $uid 用户uid
	 * @return float
	 */
	public static function getVoteItemPercentage($tid)
	{
		$item = FocusQuestionItem::model()->LoadByPk($tid);
		$qid = $item->fqid;

		$criteria = new CDbCriteria();
		// $criteria->compare('userid',$uid);
		$criteria->compare('fqid',$qid);
        $qn = self::model()->count($criteria);

        $criteria = new CDbCriteria();
		// $criteria->compare('userid',$uid);
		$criteria->compare('fqiid',$tid);
        $tn = self::model()->count($criteria);

        if($qn)
        	return round(($tn*100)/$qn, 2);
        	// return $tn*100/$qn;
        return 0;
	}

	/**
	 * 返回单个问题的投票人数
	 * panrj 2014-07-11
	 * @param int $qid FocusQuestion主键
	 * @return int
	 */
	public static function getQuestionJoinNumber($qid,$type='')
	{
		$criteria = new CDbCriteria();
		$criteria->compare('fqid',$qid);
		if($type=='answer'){
			$criteria->addCondition('ISNULL(fqiid)');
		}else{
			$criteria->addCondition('fqiid IS NOT NULL');
		}
		$criteria->group = "userid";
        $qn = self::model()->count($criteria);
        return $qn;
	}

	public static function getQuestionJoinResult($qid)
	{
		$qn = self::getQuestionJoinNumber($qid);
		$items = self::getItemJoinByQuestion($qid);
		$itemArr = array();
		foreach($items as $t){
			$itemArr[$t->fqiid] = $t->items;
		}
		return array('question'=>$qn,'items'=>$itemArr);
	}

	public static function getItemJoinByQuestion($qid)
	{
		$criteria = new CDbCriteria();
		$criteria->select = "fqiid, COUNT(fqiid) `items`";
		$criteria->compare('fqid',$qid);
		$criteria->addCondition('fqiid IS NOT NULL');
		$criteria->group = "fqiid";
		$data = self::model()->findAll($criteria);
        return $data;
	}

	public static function getItemJoinPercentage($data,$tid)
	{
		// conlog($data);
		$qn = isset($data['question'])?$data['question']:0;
		$tn = isset($data['items'][$tid])?$data['items'][$tid]:0;
		if($qn)
        	return round(($tn*100)/$qn, 2);
        return 0;
	}

	/**
	 * 返回单个问答问题的回复分页数据
	 * panrj 2014-07-11
	 * @param int $qid FocusQuestion主键
	 * @return int
	 */
	// public static function getQuestionAnswerReplaies($qid)
	// {
	// 	$criteria = new CDbCriteria();
	// 	$criteria->compare('fqid',$qid);
	// 	$criteria->addCondition('ISNULL(fqiid)');
 //        $data = self::model()->findAll($criteria);
 //        return $data;
	// }

	public function getQuestionAnswerReplaies($parms)
	{
		$result = array();
		$criteria = new CDbCriteria();
		$criteria->compare('fqid',$parms['fqid']);
		$criteria->addCondition('ISNULL(fqiid)'); 
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
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FocusAnswer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
