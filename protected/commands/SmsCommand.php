<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-5
 * Time: 上午11:08
 */

class SmsCommand extends CConsoleCommand
{
    public function run($args)
    {
        $smsconfig = NoticeQuery::queryAll("select * from tb_sms_config");
        $sids = array();
        foreach ($smsconfig as $val) {
            $sids[] = $val['sid'];
        }
        $list1=array();
        $list2=array();

        if (count($sids) > 0) {
            //没在禁用名单的消息
            $list1 = NoticeQuery::queryAll("select * from tb_notice_message where state=0 and deleted=0  and receiver like '%".USER_BRANCH."' and sid not in(" . implode(",", $sids) . ") limit 50; ");
            //在禁用名单中
            $list2 = NoticeQuery::queryAll(" select f.* from tb_notice_message f inner join tb_sms_config t on f.sid=t.sid where
                      state=0 and  receiver like '%".USER_BRANCH. "' and deleted=0  and (t.starttime<now() or t.endtime>now()) and !FIND_IN_SET(f.noticetype,t.noticetype ) limit 50
                    ");
        }else{
            $list1 = NoticeQuery::queryAll("select * from tb_notice_message where state=0 and deleted=0 and receiver like '%".USER_BRANCH."'  limit 500; ");
        }

//          $list1 = NoticeQuery::queryAll("select * from tb_notice_message where state=0 and deleted=0   limit 500; ");
//          //新的方法,效率快点，不要join
//          foreach($list1 as $val){
//              //判断是否在黑名单中，如果不在就发消息，便将状态改为1
//              if(!$this->inBlack($val,$sids){
//                 $ids[]=$val['msgid'];
//              }else{ //在的话，就将状态改为2
//                $ids2[]=$val['msgid'];
//              }
//          }


        $all=array();
        $all = $list1 + $list2;

        $ids=array(); //保存有手机号码的用户
        $connection = Yii::app()->db_msg; //这句加上报错 .连不上数据库所致
        $ids_2=array(); //保存无手机号码的用户
        foreach($all as $val){
            $receiveId=$val['receiver'];//接收者id;
            if($receiveId){
                $userInfo=UCQuery::loadUser($receiveId);
                $mobile=array();
                if(!property_exists($userInfo,"name")){ //用户不存在
                    $ids_2[]=$val['msgid'];
                    continue;
                }
                if($userInfo->identity==2){ //如果是学生，要找其监护人
                    if(!empty($val['rguardian'])){
                        $familyList=UCQuery::queryAll(" select mobilephone from tb_user where userid in(".$val['rguardian'].')');
                        if(!empty($familyList)){
                            foreach($familyList as $mobileval){
                                if(!empty($mobileval['mobilephone'])){
                                    $mobile[]=$mobileval['mobilephone'];
                                }
                            }
                        }
                    }

                }else{
                    $mobilephone=$userInfo->mobilephone;
                    $mobile[]=$mobilephone;
                }

                $data=json_decode($val['content'],true);
                $content=$data['content'];
                if(!empty($mobile)){
                    foreach($mobile as $mobilenum){
                        $code = $content;
                        $sql = "CALL fn_AddSmsMessage('".$mobilenum."','10001','101','".$code."','【蜻蜓校信】',0,1)";

                        $connection->createCommand($sql)->execute();
                        $ids[]=$val['msgid'];
                    }

                }else{
                    //有很多无手机号的用户,怎么处理
                   // echo $receiveId,"</br>";
                    $ids_2[]=$val['msgid']; //如果用户没有手机号，也将状态改
                }
            }else{ //大部分情况下有receiver，就是有错误数据情况下，防止定时器停止

            }
        }

        if(count($ids)>0){
            $sql="update tb_notice_message set state=1  where msgid in(".implode(",",$ids).")";
            NoticeQuery::execute($sql);
        }
        //如果接收人没有手机号，或接收人在用户表不存在
        if(count($ids_2)>0){
            $sql="update tb_notice_message set state=2  where msgid in(".implode(",",$ids_2).")";
            NoticeQuery::execute($sql);
        }

    }
}