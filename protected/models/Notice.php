<?php

/**
 * This is the model class for table "{{notice}}".
 *
 * The followings are the available columns in table '{{notice}}':
 * @property string $noticeid
 * @property string $sender
 * @property string $sendertitle
 * @property string $receiver
 * @property string $receivertitle
 * @property integer $noticetype
 * @property string $content
 * @property string $sendtime
 * @property integer $cid
 * @property integer $issendsms
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property string $sid
 * @property string $schoolname
 * @property string $receivename
 *
 * The followings are the available model relations:
 * @property NoticeMessage[] $noticeMessages
 */
class Notice extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{notice}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender, noticetype, sendtime', 'required'),
			array('noticetype, cid, issendsms, state, deleted', 'numerical', 'integerOnly'=>true),
			array('sender, sendertitle, receivertitle, sid', 'length', 'max'=>20),
			array('schoolname', 'length', 'max'=>100),
			array('receivename', 'length', 'max'=>5000),
			array('receiver, content, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('noticeid, sender, sendertitle, receiver, receivertitle, noticetype, content, sendtime, cid, issendsms, state, creationtime, updatetime, deleted, sid, schoolname, receivename', 'safe', 'on'=>'search'),
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
			'noticeMessages' => array(self::HAS_MANY, 'NoticeMessage', 'noticeid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'noticeid' => '通知ID',
			'sender' => '发送者',
			'sendertitle' => '发送者称谓',
			'receiver' => '接收者集合',
			'sendtime' => '发送时间',
			'cid' => '班级（仅对邀请类消息有效）',
			'issendsms' => '是否给自己发送短信(0--no  1 yes)',
			'state' => '状态 0:未转换  1:已转到tb_notice_message  2:找不到接受者  3:异常',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'sid' => '发送给哪个学校的',
			'schoolname' => '学校名称',
			'receivename' => '接收者名称集合(李某x,王xx 三班，四班)',
			'evaluatetype' => '评论类型(0--表扬  1--批评)只有点评学生时有用',
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

		$criteria->compare('noticeid',$this->noticeid,true);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('sendertitle',$this->sendertitle,true);
		$criteria->compare('receiver',$this->receiver,true);
		$criteria->compare('receivertitle',$this->receivertitle,true);
		$criteria->compare('noticetype',$this->noticetype);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('sendtime',$this->sendtime,true);
		$criteria->compare('cid',$this->cid);
		$criteria->compare('issendsms',$this->issendsms);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('schoolname',$this->schoolname,true);
		$criteria->compare('receivename',$this->receivename,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getSendMessage($parms=array(),$page=1,$pageSize=15){

        $result = array();
        $criteria = new CDbCriteria();
        if(isset($parms['sid']) && $parms['sid']){
            $criteria->compare('t.sid',$parms['sid']);
        }
        if(isset($parms['teacher']) && $parms['teacher']){
            $criteria->compare('t.sender',$parms['teacher']);
        }
        if(isset($parms['noticeType'])){
            if(empty($parms['noticeType'])){

            }else{
                $criteria->addCondition("noticetype in(".$parms['noticeType'].")");
            }
        }
        if(isset($parms['keyword']) && $parms['keyword']!=''){
            $criteria->compare('t.content',$parms['keyword'],true);
        }
        if(isset($parms['start']) && $parms['start']!=''){
            $criteria->compare('t.sendTime',">=".$parms['start']);
        }
        if(isset($parms['end']) && $parms['end']!=''){
            $criteria->compare('t.sendTime',"<=".$parms['end']);
        }
        $criteria->compare('t.deleted',0);
        //$criteria->compare('t.state',1);
        $criteria->order = 't.sendTime DESC';
        $count = self::model()->count ($criteria);
        $pager = new CPagination($count);
        if(isset($parms['size']) && $parms['size']){
            $pager->pageSize = $parms['size'];
        }else{
            $pager->pageSize = 4;
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
	 * @return Notice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
