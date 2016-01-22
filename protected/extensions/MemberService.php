<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-21
 * Time: 下午1:42
 */

class MemberService
{
    /*
    * 根据手机号,学生姓名，添加学生
    * $$issendinvite 是否发送邀请 1,发， 0－－不发
     * $desc 邀请的欢迎信息
     * $userinfo 发送者信息
     * $front 前台还是后台,前台与后台处理方式有点不一样
    * 返回学生id及要发送密码的数组
    */
    public static function addStudentByMobileAndName($mobile, $name, $cid, $role = '家长', $classInfo=null)
    {
        //$success=false;
        return Member::addStudentByMobileAndName($mobile, $name, $cid, $role,$classInfo);
//         if (isset($result['student']) && $result['student']) {
//             $success=true;
//             //发送邀请
// //            if ($isdendinvite) {
// //                $class = MClass::model()->findByPk($cid);
// //                $data['receiver'] = '{"5":"' . $result['student'] . '"}';
// //                $data['noticeType'] = 6;
// //                $data['isSendsms'] = false;
// //                if (empty($desc)) {
// //                    $data['desc'] = "欢迎加入" . $class->name;
// //                }
// //                $data['data'] = '{"content":"' . $desc . '"}';
// //                $data['receiveTitle'] = 'xxx';
// //                $data['sendertitle'] = ($userinfo ? $userinfo->name : '') . '老师';
// //                $data['sid'] = $class->sid;
// //                $data['receivename'] = $name;
// //                NoticeQuery::publishNotice($data, $userinfo->userid, false);
// //            }
//             //发送密码
//             // if (isset($result['password']) && $result['password']) {
//             //     if (is_array($result['password'])) {
//             //         foreach ($result['password'] as $val) {
//             //             UCQuery::sendMobilePasswordMsg($val['mobile'], $val['password']);
//             //         }
//             //     }
//             // }

//         }
       // return $success;

    }

    
       /*
    * 根据手机号,学生姓名，添加老师
    *  $issendinvite 是否发送邀请 1,发， 0－－不发
    * $desc 邀请的欢迎信息
    * $userinfo 发送者信息
    * $front 前台还是后台,前台与后台处理方式有点不一样
    * 返回学生id及要发送密码的数组
    */
    public static function addTeacherByMobileAndName($mobile, $name, $cid, $role = '老师', $classInfo=null)
    {
        return  Member::addTeacherByMobileAndName($mobile, $name, $cid, $role, $classInfo);

    }

} 