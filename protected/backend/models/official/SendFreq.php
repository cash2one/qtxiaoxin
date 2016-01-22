<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SendFreq
 *
 * @author Administrator
 */
class SendFreq extends OfficialActiveRecord
{
    const TABLE_OFFICIAL_INFO = 'op_official_info';
    const TABLE_SEND_FREQ      = 'op_send_freq';

    protected static $cacheFreq = -1;
    protected static $cacheTodayMsgCount = -1;




    /**
     * 获取公众帐号的发送频率限制数
     * @return number
     */
    public function getOfficialAccoutFreq( $infoid )
    {
        if (0 > self::$cacheFreq) {
            $sql = 'SELECT s.freqlimit FROM '.self::TABLE_OFFICIAL_INFO.' o INNER JOIN '.self::TABLE_SEND_FREQ.' s ON s.freqid = o.freqid WHERE o.infoid = \'' . $infoid . '\' LIMIT 1';
            $command = $this->dbConnection->createCommand($sql);
            $row = $command->queryRow();

            self::$cacheFreq = true == isset($row['freqlimit']) ? (int)$row['freqlimit'] : 0;
        }

        return self::$cacheFreq;
    }

    /**
     * 获取剩余发送消息次数
     * @param number $infoid
     * @return number
     */
    public function limitMsgCount( $infoid )
    {
        if( $infoid > 0 ){
            $freqLimit = $this->getOfficialAccoutFreq( $infoid );
        }else{
            $freqLimit = 0;
        }

        if( $freqLimit > 0 )
        {
            $info = OfficialInfo::model()->findByPk( $infoid );

            $sendTime = strtotime($info->sendtime);

            if ( strtotime( date('Y-m-d') ) > $sendTime
                || strtotime( date('Y-m-d',strtotime( '+1 day')) ) < $sendTime ) {
                return $freqLimit;
            }

            return max($freqLimit - $info->sendcount , 0);
        }
        else
        {
            return -1;
        }
    }

    /**
     * 获取当天的可发送条数
     * @return number
     */
    public function getTodayMsgCount()
    {
        if( 0> self::$cacheTodayMsgCount ){
            self::$cacheTodayMsgCount = max($this->limitMsgCount(Yii::app()->getModule('official')->user->getInfo('infoid')),0);
        }

        return self::$cacheTodayMsgCount;
    }


    /**
     * 返回公众号发送等级键值数组
     * zengp 2014-01-08
     * @return array $arr 
     */
    public static function getDataArr()
    {

        $data = self::model()->findAll();
        $arr = array();
        foreach($data as $d){
            $arr[$d->freqid] = $d->sendleve . '级 (每天'.$d->freqlimit.'次)';
        }
        return $arr;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
      return '{{send_freq}}';
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
