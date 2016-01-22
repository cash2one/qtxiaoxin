<?php

/**
 * This is the model class for table "{{sms_config}}".
 *
 * The followings are the available columns in table '{{sms_config}}':
 * @property integer $id
 * @property integer $sid
 * @property string $noticetype
 * @property string $starttime
 * @property string $endtime
 */
class SmsConfig extends XiaoXinActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{sms_config}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sid, noticetype', 'required'),
            array('sid', 'numerical', 'integerOnly' => true),
            array('starttime, endtime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sid, noticetype, starttime, endtime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'sid' => 'Sid',
            'noticetype' => 'Noticetype',
            'starttime' => 'Starttime',
            'endtime' => 'Endtime',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('sid', $this->sid);
        $criteria->compare('noticetype', $this->noticetype, true);
        $criteria->compare('starttime', $this->starttime, true);
        $criteria->compare('endtime', $this->endtime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SmsConfig the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /*
     * 根据学校id(数组)和通知类型，决定是否给出是否发送短信按扭
     */
    public static function checkSendsmsBySidAndNoticeType($sids, $noticeType)
    {
        $isshow = false;
        $criteria = new CDbCriteria;
        if (empty($sids)) {
            return $isshow;
        }
        $criteria->addInCondition('sid', $sids);
        $list = self::model()->findAll($criteria);
        if(count($list)!=count($sids)){
            return true;
        }
        return $isshow;
//        if (is_array($list)) {
//            foreach ($list as $data) {
//                $allowNotice = $data->noticetype;
//                if ($allowNotice) {
//                    $allowNoticeArr = explode(",", $allowNotice);
//                    if (time() >= strtotime($data->starttime) && time() <= strtotime($data->endtime) && in_array($noticeType, $allowNoticeArr)) {
//                        $isSendSms = false;
//                    }
//                }
//            }
//        }

    }
}
