<?php

/**
 * This is the model class for table "{{send}}".
 *
 * The followings are the available columns in table '{{send}}':
 * @property string $sid
 * @property integer $infoid
 * @property integer $msgid
 * @property string $byinfoid
 * @property integer $deleted
 * @property integer $forward
 * @property string $updatetime
 * @property string $creationtime
 */
class Send extends OfficialActiveRecord
{
    const LOGIC_FORWARD         = 2;     // 已发布
    const LOGIC_DELETE              = 1;     // 逻辑删除
    const LOGIC_NOT_DELETE     = 0;     // 非逻辑删除

    const REDIS_MSG_PUBLISH   = 'publish:queue:timer'; // redis的定时发送有序集合

    const PUBLISH_FROM_AUTHOR = 0;      // 是否原作者发布

    const TABLE_OFFICIAL_INFO = 'op_official_info';
    const TABLE_SEND_FREQ      = 'op_send_freq';

    protected static $cacheFreq = -1;
    protected static $cacheTodayMsgCount = -1;


  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return '{{send}}';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('infoid, msgid', 'required'),
      array('infoid', 'checkForward'),
      array('infoid', 'checkForwardOnlyOne'),
      array('infoid, msgid, deleted, forward', 'numerical', 'integerOnly'=>true),
      array('byinfoid', 'length', 'max'=>10),
      array('updatetime, creationtime', 'safe'),
     );
  }

  /**
   * 模型自动验证发布次数使用用完 freq 键存储错误
   * @param array $attribute
   * @param array $params
   */
  public function checkForward( $attribute, $params )
  {
     $freq = new SendFreq();

      if( 0 == $freq->limitMsgCount($this->infoid) ){
          $this->addError('freq', '已超过发送次数上限，转发失败！');
      }
  }

  /**
   * 检查原作者是发布过该条消息
   * @param array $attribute
   * @param array $params
   */
  public function checkForwardOnlyOne( $attribute, $params )
  {
      $criteria = new CDbCriteria();
      $criteria->condition='msgid=:msgid';
      $criteria->params=array(':msgid'=>$this->msgid );
      $criteria->addCondition( 'infoid='.$this->infoid  );
      $criteria->addCondition( 'byinfoid='.self::PUBLISH_FROM_AUTHOR  );

      if( true == $this->count( $criteria ) ) {
          $this->addError('forward', '信息已转发过');
      }
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
      'sid' => '发布主键',
      'infoid' => '公众号id',
      'msgid' => '消息id',
      'byinfoid' => '被转发的公众号id',
      'deleted' => '已删除',
      'forward' => '转发状态',
      'updatetime' => '更新时间',
      'creationtime' => '创建时间',
    );
  }

  /**
   * 转发消息
   * @param number $infoId
   * @param number $msgId
   * @param number $byinfoid
   * @return boolean
   */
  public function forwardMsg( $infoId, $msgId, $byinfoid )
  {
      $this->infoid = (int)$infoId;
      $this->msgid = (int)$msgId;
      $this->byinfoid = (int)$byinfoid;
      $this->forward = self::LOGIC_FORWARD;
      $this->publishtime = date('Y-m-d H:i:s');

      YII_DEBUG && Yii::trace('saveContent:' . var_export($this->attributes, true));

      if (true == $this->save()) {
          Message::model()->updateByPk($msgId, array('forward'=>self::LOGIC_FORWARD));
          $dataInfo = OfficialInfo::model()->findByPk($infoId);
          if (strtotime($dataInfo->sendtime) < strtotime(date('Y-m-d'))) {
              $dataInfo->sendcount = 0;
          }
          $dataInfo->sendtime = date("Y-m-d H:i:s");
          $dataInfo->sendcount = $dataInfo->sendcount + 1;
          $dataInfo->save();
          return true;
      }

      return false;
  }

    /**
     * 逻辑删除指定逗号分隔id串的批量或单条消息
     * @param string $ids
     * @return boolean
     */
    public function delForwardMsg( $ids )
    {
        $pks = array();

        if( true == is_string($ids) )
        {
            $pks = explode( ',', $ids);
        }
        else if( true == is_array($ids) )
        {
            $pks = $ids;
        }
        else
        {
            $pks = (int)$ids;
        }

        return $this->deleteByPk( $pks);
    }


  /**
   * Returns the static model of the specified AR class.
   * Please note that you should have this exact method in all your CActiveRecord descendants!
   * @param string $className active record class name.
   * @return Send the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
}
