<?php

/**
 * This is the model class for table "{{notice_message}}".
 *
 * The followings are the available columns in table '{{notice_message}}':
 * @property string $msgid
 * @property string $noticeid
 * @property string $sender
 * @property string $sendertitle
 * @property string $receiver
 * @property string $rguardian
 * @property string $receivertitle
 * @property integer $noticetype
 * @property string $content
 * @property string $sendtime
 * @property integer $read
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 * @property string $sid
 * @property string $schoolname
 * @property string $uname
 * @property integer $istrans
 * @property string $rmobilephone
 * @property integer $appstate
 * @property integer $iosstate
 * @property integer $evaluatetype
 */
class NoticeMessage extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{notice_message}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('noticeid, sender, receiver, noticetype, sendtime', 'required'),
			array('noticetype, read, state, deleted, istrans, appstate, iosstate, evaluatetype, issendsms', 'numerical', 'integerOnly'=>true),
			array('noticeid, sender, receiver, sid', 'length', 'max'=>20),
			array('sendertitle, receivertitle, uname', 'length', 'max'=>50),
			array('rguardian, schoolname', 'length', 'max'=>100),
			array('rmobilephone', 'length', 'max'=>200),
			array('content, updatetime,creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('msgid, noticeid, sender, sendertitle, receiver, rguardian, receivertitle, noticetype, content, sendtime, read, state, creationtime, updatetime, deleted, sid, schoolname, uname, istrans, rmobilephone, appstate, iosstate, evaluatetype, issendsms', 'safe', 'on'=>'search'),
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
			'msgid' => '消息ID',
			'noticeid' => '通知',
			'sender' => '发送者',
			'sendertitle' => '发送者称谓',
			'receiver' => '接收者（老师或学生）',
			'rguardian' => '接收者监护人：当接收者为学生时，该字段才生效。',
			'receivertitle' => '接收者称呼',
			'noticetype' => '通知类型：0系统消息；1家庭作业；2家长学校通知；3在校表现；4紧急通知；5成绩通知；6邀请;7:老师学校通知;8:工作餐单',
			'content' => '',
			'sendtime' => '发送时间',
			'read' => '是否已读',
			'state' => '短信处理状态：0待处理；1已处理并发送短信；2已处理未发送短信: 3学校黑名单中的短信: 4不在白名单中用户发送的短信: 5异常',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'sid' => '学校id',
			'schoolname' => '学校名称',
			'uname' => '发送者名称 uid相对应的username',
			'istrans' => '是否同步到ios,android客户端(1--已转换,0--未转换,2--转换异常)',
			'rmobilephone' => '监护人手机号码逗分字符',
			'appstate' => 'APP 服务状态(0.未处理;1.已处理;2.有客户端且已经发送)',
			'iosstate' => 'ios补发短信处理状态',
			'evaluatetype' => '评论类型(0--表扬  1--批评)只有点评学生时有用',
			'issendsms' => '是否将此消息发送短信(0--no  1 yes)',
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

		$criteria->compare('msgid',$this->msgid,true);
		$criteria->compare('noticeid',$this->noticeid,true);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('sendertitle',$this->sendertitle,true);
		$criteria->compare('receiver',$this->receiver,true);
		$criteria->compare('rguardian',$this->rguardian,true);
		$criteria->compare('receivertitle',$this->receivertitle,true);
		$criteria->compare('noticetype',$this->noticetype);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('sendtime',$this->sendtime,true);
		$criteria->compare('read',$this->read);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('schoolname',$this->schoolname,true);
		$criteria->compare('uname',$this->uname,true);
		$criteria->compare('istrans',$this->istrans);
		$criteria->compare('rmobilephone',$this->rmobilephone,true);
		$criteria->compare('appstate',$this->appstate);
		$criteria->compare('iosstate',$this->iosstate);
		$criteria->compare('evaluatetype',$this->evaluatetype);
		$criteria->compare('issendsms',$this->issendsms);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NoticeMessage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /*
     * 置一批msgid为已读
     */
    public static function updateReadState($ids,$state=1){
        $criteria=new CDbCriteria;
        $criteria->addInCondition("msgid",$ids);
        return self::model()->updateAll(array('read'=>$state),$criteria);
    }
    /*
  * 将登录人所有消息设为已读
  */
    public static function updateReadStateByUidNoticeType($uid,$noticeType,$update=1){
        $criteria = new CDbCriteria();
        $criteria->addInCondition("receiver",explode(",",$uid));
        if(!empty($noticeType)){
            $criteria->addCondition("noticetype in(".$noticeType.")");
        }else{
            if($noticeType==='0'){
                $criteria->addCondition("noticetype in(".$noticeType.")");
            }
        }
        $criteria->compare("`read`",0);
        if($update==1){ //更新
            return self::model()->updateAll(array('read'=>1),$criteria);
        }else if($update==2){
            return self::model()->count($criteria);
        }else{
            return self::model()->findAll($criteria);
        }
    }

    /*
  * 根据家长id和消息id获取message的单条信息
  */
    public static function getMessageByFamily($uid,$noticeid){
        $criteria = new CDbCriteria();
        $criteria->compare("noticeid",$noticeid);
        $criteria->addCondition(" find_in_set(".$uid.",rguardian)");
        return self::model()->find($criteria);

    }

    public static function getYesterdayBean($date,$ty=-1,$lastid=0,$limit=5000)
    {
    	$criteria = new CDbCriteria();
        $criteria->compare("appstate",">0");
        $criteria->addCondition("msgid>".$lastid,'and');
        // $criteria->compare("state","!=1");
        $criteria->addCondition("state!=1",'and');
        $criteria->compare("issendsms",0);
        $criteria->compare("noticetype",$ty);
        $criteria->addCondition("TO_DAYS('".$date."')-TO_DAYS(sendtime)=0",'and');
        $criteria->order = 'msgid ASC'; 
        $criteria->limit = $limit;
        return self::model()->findAll($criteria);
    }
}
