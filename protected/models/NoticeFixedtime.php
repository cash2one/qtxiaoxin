<?php

/**
 * This is the model class for table "{{notice_fixedtime}}".
 *
 * The followings are the available columns in table '{{notice_fixedtime}}':
 * @property string $id
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
 * @property integer $status
 * @property string $reason
 * @property string $approveid
 * @property string $approvetime
 * @property string $sid
 * @property string $schoolname
 * @property string $receivename
 */
class NoticeFixedtime extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{notice_fixedtime}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sender, noticetype, creationtime', 'required'),
			array('noticetype, cid, issendsms, state, deleted, status', 'numerical', 'integerOnly'=>true),
			array('sender, sendertitle, receivertitle, approveid, sid', 'length', 'max'=>20),
			array('reason, receivename', 'length', 'max'=>1000),
			array('schoolname', 'length', 'max'=>100),
			array('receiver, content, sendtime, updatetime, approvetime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sender, sendertitle, receiver, receivertitle, noticetype, content, sendtime, cid, issendsms, state, creationtime, updatetime, deleted, status, reason, approveid, approvetime, sid, schoolname, receivename', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'sender' => '发送者',
			'sendertitle' => '发送者称谓',
			'receiver' => '接收者集合，用json表示:如
{5:"1,2,3",1:"2,3"}代表接收者个人id(1,2,3),和班级id(2,3),如果是全体老师默认是4:"1"
前面key（）5个人；1班级；2群组,3年级4.全体老师)',
			'receivertitle' => '接收者称呼',
			'noticetype' => '通知类型：0系统消息；1家庭作业；2家长学校通知；3在校表现；4紧急通知；5成绩通知；6邀请;7:老师学校通知',
			'content' => '',
			'sendtime' => '发送时间',
			'cid' => '班级（仅对邀请类消息有效）',
			'issendsms' => '是否给自己发送短信(0--no  1 yes)',
			'state' => '状态(保留)1:转到消息  2：异常',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
			'status' => '审核状态(0--未审核,1--已审核 2--审核不通过',
			'reason' => '审核不通过原因',
			'approveid' => '审核人',
			'approvetime' => '审核时间',
			'sid' => '学校id',
			'schoolname' => '学校名称',
			'receivename' => '接收者名称集合',
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
		$criteria->compare('status',$this->status);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('approveid',$this->approveid,true);
		$criteria->compare('approvetime',$this->approvetime,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('schoolname',$this->schoolname,true);
		$criteria->compare('receivename',$this->receivename,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NoticeFixedtime the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
