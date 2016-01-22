<?php

/**
 * This is the model class for table "{{official_info}}".
 *
 * The followings are the available columns in table '{{official_info}}':
 * @property string $infoid
 * @property string $openid
 * @property string $openname
 * @property integer $opentype
 * @property string $summary
 * @property integer $sendlevel
 * @property string $sendcount
 * @property integer $deleted
 * @property integer $block
 * @property string $updatetime
 * @property string $sendtime
 * @property string $creationtime
 */
class OfficialInfo extends OfficialActiveRecord
{

    const DELETE = 1; // 删除

    const BLOCK = 2; // 封号

    const NOT_DELETE = 0;

    const NOT_BLOCK = 1;

    const OPEN_TYPE_SYSTEM = 1;     // 公众号系统类型

    const OPEN_TYPE_NORMAL = 2;     // 公众号普通类型

    public $openname;

    public $summary;

    public $logo;

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{official_info}}';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'openid, openname, opentype, summary, freqid, sendcount, block',
                'required'
            ),
            array(
                'opentype, freqid, deleted, block',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'openid, openname',
                'length',
                'max' => 50
            ),
            array(
                'logo',
                'length',
                'max' => 100
            ),
            array(
                'summary',
                'length',
                'max' => 800
            ),
            array(
                'sendcount',
                'length',
                'max' => 10
            ),
            array(
                'updatetime, sendtime, creationtime, logo',
                'safe'
            )
        );
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array()

        ;
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'infoid' => '主键',
            'openid' => '公众号',
            'openname' => '名称',
            'opentype' => '公众号类型',
            'summary' => '简介',
            'freqid' => '频率外键',
            'sendcount' => '发送次数',
            'deleted' => '已删除',
            'block' => '查封状态',
            'updatetime' => '更新时间',
            'sendtime' => '发送时间',
            'creationtime' => '创建时间',
            'logo' => '头像'
        );
    }

    /*
     * 查询唯一公众号数据
     * zengp 2014-11-26
     * @parms string $openid 公众号id
     */
    public static function getUniqueOfficial($openid)
    {
        $official = self::model()->findByAttributes(array(
            'openid' => $openid,
            'deleted' => 0
        ));
        if ($official) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取单条公众号资料
     *
     * @param number $infoId
     * @return Ambiguous
     */
    public function getOfficialById($infoId)
    {
        $data = $this->findByPk($infoId, array(
            'deleted' => self::DELETE
        ));

        return $data;
    }

    /**
     * 公众号列表分页数据
     * panrj,zengp 2014-11-27
     * @param array $parms
     * 查询条件及分页参数
     * @return array $result
     */
    public function pageData($parms = array())
    {
        $result = array();
        $criteria = new CDbCriteria();
        if (isset($parms['name']) && $parms['name'] != '') {
            $criteria->addSearchCondition('openid', $parms['name']);
        }
        if (isset($parms['openname']) && $parms['openname'] != '') {
            $criteria->addSearchCondition('openname', $parms['openname']);
        }
        if (isset($parms['opentype']) && $parms['opentype'] != '') {
            $criteria->addSearchCondition('opentype', $parms['opentype']);
        }

        $criteria->scopes = 'normal';
        $criteria->order = 'openid';
        $count = self::model()->count($criteria);
        $pager = new CPagination($count);
        if (isset($parms['size']) && $parms['size']) {
            $pager->pageSize = $parms['size'];
        } else {
            $pager->pageSize = 50;
        }
        $pager->applyLimit($criteria);

        $datalist = self::model()->findAll($criteria);

        $result['model'] = $datalist;
        $result['pages'] = $pager;

        return $result;
    }

    /**
     * 查询公众号账号
     * @author zengp 2014-11-26
     * @param string $infoid 公众号id
     */
    public static function getOfficialAccount($infoid)
    {
        $account = Account::model()->findByAttributes(array(
            'infoid' => $infoid,
            'deleted' => 0
        ));
        return $account;
    }

    /**
     * 查询是否存在可用公众号
     * @author zengp 2014-12-03
     * @param string $infoid 公众号id
     */
    public static function getOfficialNoBlock($infoid)
    {
        $account = OfficialInfo::model()->findByAttributes(array(
            'infoid' => $infoid
        ));
        if ($account) {
            return $account;
        } else {
            return false;
        }
    }

    /**
     * 封号
     * @author zengp 2014-12-03
     * @param string $infoid 公众号id
     * @param string $reason 封/解号原因
     */
    public static function setBlock($infoid, $reason)
    {
        $result = array(
            'state' => false,
            'type' => '',
            'block' => ''
        );
        $model = OfficialInfo::model()->findByPk($infoid);

        if ($model) {
            $log = new BlockLog();
            $log->infoid = $infoid;
            $log->reason = $reason;

            if ($model->block == 1) {
                $model->block = 2;
                $log->block = 2;
                $result['type'] = '封号';
                $result['block'] = '2';
            } else {
                $model->block = 1;
                $log->block = 1;
                $result['type'] = '解封';
                $result['block'] = '1';
            }
            $model->save();
            $log->save();
            $result['state'] = true;
        }
        return json_encode($result);
    }

    /**
     * 获取公众号发送等级
     * zengp 2014-12-15
     * @parms string $freqid 等级 1，2，3
     */
    public static function getSendLevel($freqid)
    {
        $info = SendFreq::model()->findByPk($freqid);
        return $info['sendleve']. '级 (每天'.$info->freqlimit.'次)';
    }

    /**
     * 新增或编辑资料保存
     *
     * @param string $inputFileName
     * @param string $openName
     * @param string $summary
     * @return boolean
     */
    public function saveInfo($inputFileName, $openName, $summary)
    {
        $this->openname = $openName;
        $this->summary = $summary;
        $this->logo = $inputFileName;

        return $this->save();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return OfficialInfo the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
