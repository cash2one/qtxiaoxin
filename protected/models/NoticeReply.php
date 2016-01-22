<?php

/**
 * This is the model class for table "{{notice_reply}}".
 *
 * The followings are the available columns in table '{{notice_reply}}':
 * @property string $replyid
 * @property string $noticeid
 * @property string $sender
 * @property string $sguardian
 * @property string $receiver
 * @property string $content
 * @property integer $nameless
 * @property integer $state
 * @property string $creationtime
 * @property string $updatetime
 * @property integer $deleted
 */
class NoticeReply extends XiaoXinActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{notice_reply}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('noticeid, sender, receiver', 'required'),
			array('nameless, state, deleted', 'numerical', 'integerOnly'=>true),
			array('noticeid, sender, receiver', 'length', 'max'=>20),
			array('sguardian', 'length', 'max'=>100),
			array('content, updatetime, creationtime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('replyid, noticeid, sender, sguardian, receiver, content, nameless, state, creationtime, updatetime, deleted', 'safe', 'on'=>'search'),
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
			'u' => array(self::BELONGS_TO, 'Member', 'sender'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'replyid' => '回复消息ID',
			'noticeid' => '通知',
			'sender' => '发送者（老师或学生）',
			'sguardian' => '发送者监护人：当发送者为学生时，该字段才生效。',
			'receiver' => '接收者',
			'content' => '内容',
			'nameless' => '是否匿名（只对回复类生效）',
			'state' => '状态：暂未使用',
			'creationtime' => '创建时间',
			'updatetime' => '更新时间',
			'deleted' => '是否已删除',
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

		$criteria->compare('replyid',$this->replyid,true);
		$criteria->compare('noticeid',$this->noticeid,true);
		$criteria->compare('sender',$this->sender,true);
		$criteria->compare('sguardian',$this->sguardian,true);
		$criteria->compare('receiver',$this->receiver,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('nameless',$this->nameless);
		$criteria->compare('state',$this->state);
		$criteria->compare('creationtime',$this->creationtime,true);
		$criteria->compare('updatetime',$this->updatetime,true);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NoticeReply the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
     * 组分页数据
     * panrj,zengp 2014-11-05
     * @param array $parms 查询条件及分页参数
     * @return array $result
     */
    public static function countNoticeReplaies($noticeid){
        $criteria=new CDbCriteria;
        $criteria->compare('noticeid',$noticeid);
        $criteria->compare('deleted',0);
        $data = self::model()->count($criteria);
        return $data;
    }

    /**
     * 通知评论列表
     * panrj,zengp 2014-11-05
     * @param array $parms 查询条件及分页参数
     * @return array $result
     */
    public static function getNoticeComments($noticeid,$parms=array('lasttime'=>'','lastid'=>''),$per=20){
    	$criteria=new CDbCriteria;
        $criteria->compare('noticeid',$noticeid);
        $criteria->compare('deleted',0);
        if($parms['lasttime']){
			$lasttime = date('Y-m-d H:i:s',$parms['lasttime']);
			if($parms['lastid']){
				$criteria->addCondition("creationtime<'".$lasttime."' OR (creationtime='".$lasttime."' AND replyid>".$parms['lastid'].")");
			}else{
				$criteria->addCondition("creationtime>'".$lasttime."'");
			}
		}
        $criteria->limit=$per;
        $criteria->order = 'creationtime DESC, replyid';
        $data = self::model()->findAll($criteria);
        return $data;
    }

}
