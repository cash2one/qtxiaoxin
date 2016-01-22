<?php

/**
 * This is the model class for table "{{account}}".
 *
 * The followings are the available columns in table '{{account}}':
 * @property string $acid
 * @property string $mobile
 * @property string $pwd
 * @property string $infoid
 * @property string $lastip
 * @property string $updatetime
 * @property integer $deleted
 * @property string $logintime
 * @property string $creationtime
 */
class Account extends OfficialActiveRecord
{

    public $oldPassword;

    public $inputOldPassword;

    public $newPassword;

    public $passwordConfirmation;

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{account}}';
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
                'mobile, pwd, infoid',
                'required'
            ),
            array(
                'deleted',
                'numerical',
                'integerOnly' => true
            ),
            array(
                'mobile',
                'length',
                'max' => 20
            ),
            array(
                'pwd, newPassword, oldPassword, passwordConfirmation',
                'length',
                'max' => 32
            ),
            array(
                'newPassword',
                'compare',
                'compareAttribute' => 'passwordConfirmation'
            ),
            array(
                'inputOldPassword',
                'compare',
                'compareAttribute' => 'oldPassword',
                'message' => '输入的旧密码不正确'
            ),
            array(
                'infoid',
                'length',
                'max' => 10
            ),
            array(
                'lastip',
                'length',
                'max' => 15
            ),
            array(
                'updatetime, logintime, creationtime, lastip',
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
        return array(
            'info' => array(
                self::BELONGS_TO,
                'OfficialInfo',
                'infoid'
            )
        );
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'acid' => '主键',
            'mobile' => '手机',
            'pwd' => '密码',
            'infoid' => '信息外键',
            'lastip' => '上次登陆ip',
            'updatetime' => '更新时间',
            'deleted' => '已删除',
            'logintime' => '上次登陆时间',
            'creationtime' => '创建时间'
        );
    }

    /*
     * 查询唯一用户数据
     * zengp 2014-11-26
     * @parms string $mobile 用户手机号码
     */
    public static function getUniqueAccount($mobile)
    {
        $account = self::model()->findByAttributes(array(
            'mobile' => (double)$mobile,
            'deleted' => 0
        ));
        if ($account) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 删除账号
     * zengp 2014-12-03
     * @parms string $infoid 公众号id
     */
    public static function deleteOfficial($infoid)
    {
        $model = OfficialInfo::model()->loadByPk($infoid);
        $result = $model->deleteMark();
        // $result = Account::deleteByInfoId($info);

        return $result;
    }

    public static function deleteByInfoId($infoid)
    {
        $account = self::model()->findByAttributes(array(
            'infoid' => $infoid,
            'deleted' => 0
        ));
        $account->deleted = 1;
        if ($account->save()) {
            return true;
        } else {
            return false;
        }
        
    }


    /**
     * 用手机验证码修改用户的密码
     * @param string $mobile
     * @param string $pwd
     * @param string $pwdRepeat
     * @param string $authCode
     * @return number | boolean
     */
    public function mobileChangePwd( $mobile, $authCode, $pwd, $pwdRepeat )
    {
        if( $pwd != $pwdRepeat ) {
            $this->addError(get_class($this), '两次密码不一致');
            return false;
        }

        if( $authCode != $this->safeGetAuth($mobile, false) ) {
             $this->addError(get_class($this), '验证码输入错误');
             return false;
        }

        $sql = 'UPDATE '.$this->tableName().' SET pwd = \''
                .MainHelper::encryPassword($pwd).'\' WHERE mobile =:mobile LIMIT 1';

        $command = $this->dbConnection->createCommand($sql);

        $command->bindParam( ":mobile", $mobile, PDO::PARAM_STR );

        $command->execute();
        
        return true;
    }

    /**
     * 修改密码保存
     *
     * @return boolean
     */
    public function changePwd($inputOldPassword, $newPassword, $passwordConfirmation)
    {
        $this->inputOldPassword = MainHelper::encryPassword($inputOldPassword);
        $this->oldPassword = $this->pwd;
        $this->newPassword = $newPassword;
        $this->passwordConfirmation = $passwordConfirmation;
        $this->pwd = MainHelper::encryPassword($newPassword);

        return $this->save();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className
     *            active record class name.
     * @return Account the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }



    /**
     * 获取当天该限制次数的手机的验证码，每次调用，当天的次数少1
     * @author ld
     * @since 2014-12-26 15:13
     * @param string $key
     * @param string $authKey
     * @return string|null
     */
    protected function getRandPwd( $key, $authKey )
    {
        $cache          = Yii::app()->cache;
        $mobileCount    = $cache->get( $key );         // 手机每天发送次数记录

        $remainTodayTime = strtotime(date('Y-m-d',strtotime('+1 day'))) - time();    // 今天的剩下时间戳
        $remainTodayTime = $remainTodayTime > 30*60 ? $remainTodayTime: 30*60;   // 如果凌晨前30分钟不到，则30分钟缓存时间

        if( false == $mobileCount ){
            $newAuthCode = MainHelper::generate_code(6);                             // 缓存四位验证码
            $cache->set( $key, '1', $remainTodayTime );                          // 缓存当天的手机发送次数
            $cache->set( $authKey,  $newAuthCode, 30*60 );

            return $newAuthCode;
        }
        else if( $mobileCount < 3 ){
            $authCode = MainHelper::generate_code(6);
            $cache->set( $authKey,  $authCode, 30*60 );    // 缓存四位验证码

            $mobileCount = $mobileCount + 1;
            $cache->set( $key, $mobileCount , $remainTodayTime );                // 缓存当天的手机发送次数

            return $authCode;
        }
        // 次数已用完或者服务失败
        else{
            if( $mobileCount >= 3 ){
                $this->addError(get_class($this), '每天最多能发三次');
            }
            else
            {
                $this->addError(get_class($this), '获取服务失败');
            }

            return null;
        }

    }

    /**
     * 重复获取有效手机验证码，当验证码过期或者次数超过限制，返回空
     * @param string $mobile
     * @param boolean $record
     * @return string| null
     */
    public function safeGetAuth( $mobile, $record = true )
    {
        $key            = 'offic_pwd' .substr( trim($mobile), 0, 20 );
        $authKey        = $key.'_t';

        if( true == $record )
        {
            return $this->getRandPwd( $key, $authKey );
        }
        else
        {
            $cache          = Yii::app()->cache;
            $authCode       = $cache->get( $authKey );    // 验证码缓存记录，30分钟超时设置
            return $authCode;
        }
    }
}
