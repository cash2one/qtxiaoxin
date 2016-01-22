<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-7-29
 * Time: 下午5:32
 */

class Constant
{

    /*
     *      "0" => '系统消息',
            '1' => '家庭作业',
            '2' => '通知家长', //这是老师发给家长的
            '3' => '在校表现',
            '4' => '紧急通知',
            '5' => '成绩通知',
            '6' => '邀请',
            '7' => '通知老师', //这是老师发给老师的
            '8' => '学校餐单'); //这是老师发给老师的
     */
    const NOTICE_TYPE_0 = "0";
    const NOTICE_TYPE_1 = "1";
    const NOTICE_TYPE_2 = "2";
    const NOTICE_TYPE_3 = "3";
    const NOTICE_TYPE_4 = "4";
    const NOTICE_TYPE_5 = "5";
    const NOTICE_TYPE_6 = "6";
    const NOTICE_TYPE_7 = "7";
    const NOTICE_TYPE_8 = "8";

    const FAMILY_IDENTITY=4; //家长身份标志
    const TEACHER_IDENTITY=1; //老师身份标志
    const STUDENT_IDENTITY=2; //学生身份标志
    const TEACHER_FAMILY_IDENTITY=5; //(老师,家长)共同身份标志

    const APPID1=1; //布置作业
    const APPID2=2; //通知家长
    const APPID3=3; //通知老师
    const APPID4=4; //在校表现
    const APPID5=5; //教育资讯
    const APPID6=6; //课程表
    const APPID7=7; //餐单管理
    const APPID8=8; //新菜单
    const APPID9=9; //紧急通知
    const APPID10=10; //蜻豆商城
    const APPID11=11; //班级通知
    const APPID12=12; //学校通知
    const APPID13=13; //成绩管理
    const APPID14=14; //我的宝贝
    const APPID15=15; //自定义分组
    const APPID16=16; //消息审核
    const APPID17=17; //花名册
    const APPID18=18; //电话本
    const APPID19=19; //消息监控
    const APPID20=20; //自定义签名
    const APPID21=21; //定向发送


    const CACHE_BADWORD_LIST="cache_badword_list";//所有敏感词缓存常量
    const CACHE_SCHOOL_LIST="cache_school_list";//所有学校缓存常量

    const ANEW_PINVITE_DAY_COUNT=1; //重新邀请每天一次
    const ANEW_PINVITE_DAY_NUMS=100; //重新邀请短信一天100次
    const CLASS_TOTAL=100;
    /*
     * 通知类型
     */
    public static function noticeTypeArray()
    {
        return array(
            "0" => '系统消息',
            '1' => '家庭作业',
            '2' => '通知家长', //这是老师发给家长的
            '3' => '在校表现',
            '4' => '紧急通知',
            '5' => '成绩通知',
            '6' => '邀请',
            '7' => '通知老师', //这是老师发给老师的
            '8' => '学校餐单', //这是老师发给老师的
            '9' => '学校通知'); //这是老师发给老师的
    }
    public static function evaluatetypeArr(){
        return array('0'=>'表扬','1'=>'批评');
    }

    /*
     * 根据通知类型id获取通知类型
     */
    public static function  getNoticeTypeById($noticeId)
    {
        $arr = self::noticeTypeArray();
        return $arr[$noticeId];
    }

    /*
 * 发送密码前台家长短信内容　
 */
    public static function getFrontFamilySendPwdSms(){
        $msg="%s家长您好：我是%s的%s老师，我刚在".SITE_NAME."创建了班级，今后日常作业和学校通知都通过该平台发放。请您免费下载使用".
            SITE_NAME."接收信息、跟其他家长交流。系统为您配置的账号是：%s，初始密码：%s。下载地址：".SITE_APP_DOWNLOAD_SHORT_URL;
        return $msg;
    }
    /*
 * 发送密码前台家长短信内容　
 */
    public static function getFrontTeacherSendPwdSms(){
        $msg='%s老师:我是%s' . '的%s' . '老师，我刚在'.SITE_NAME.'创建了班级，并为你开通了登录账号，账号：%s' . ',初始密码:%s' .  ',大家可以在上面交流了。下载地址：'.SITE_APP_DOWNLOAD_SHORT_URL;
        return $msg;
    }
    /*
    * 发送密码前台家长,老师短信内容　
    */
    public static function getBackTeacherSendPwdSms(){
        $msg='你好！感谢您使用'.SITE_NAME.'（'.SITE_URL.'）,平台有家校沟通丶成绩管理等功能，我们的手机客户端同时推出，点击（'.SITE_APP_DOWNLOAD_SHORT_URL.'） 即可下载安装。您的账号:%s'  . '，密码:%s'.'。客服电话:4001013838，工作时间:08:00-20:00';
        return $msg;
    }
}