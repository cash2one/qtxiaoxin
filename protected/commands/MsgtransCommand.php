<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-24
 * Time: 下午1:33
 */

class MsgtransCommand extends CConsoleCommand
{
    public function run($args)
    {

        $sql = "select * from tb_notice_message where deleted=0 and istrans=0 and   receiver like '%" . USER_BRANCH . "' order by msgid limit 1000 ";
        $list = NoticeQuery::queryAll($sql);
        $msgIds = array();
        $transDb = Yii::app()->db_msg_trans;
        $sqlTrans = '';
        $insertDatas = array();

        foreach ($list as $val) {
            $data = array();
            if ($val['rguardian'] == $val['receiver']) {
                $data['nid'] = $val['noticeid'];
                $data['senderid'] = $val['sender'];
                $content = json_decode($val['content'], true);
                $data['content'] = isset($content['content']) ? $content['content'] : '';
                $data['n_type'] = $val['noticetype'];
                $data['targetid'] = $val['rguardian'];
                $data['time'] = $val['sendtime'];
                $msgIds[] = $val['msgid'];
                $insertDatas[] = $data;
            } else {
                $guardians = explode(",", $val['rguardian']);

                foreach ($guardians as $v) {
                    $data['nid'] = $val['noticeid'];
                    $data['senderid'] = $val['sender'];
                    $content = json_decode($val['content'], true);
                    $data['content'] = isset($content['content']) ? $content['content'] : '';
                    $data['n_type'] = $val['noticetype'];
                    $data['targetid'] = $v;
                    $data['time'] = $val['sendtime'];
                    $insertDatas[] = $data;
                }
                $msgIds[] = $val['msgid'];
            }


        }

        $sql = "";
        foreach ($insertDatas as $kk) {
            $sql = "INSERT into tb_info_notice(";
            $values = "";
            foreach ($insertDatas[0] as $k => $v) {
                $sql .= "`$k`,";
            }
            $sql = rtrim($sql, ",");
            $sql .= ")values";
            foreach ($insertDatas as $k => $v) {
                $row = array();
                foreach ($v as $t => $tv) {
                    $row[] = "'$tv'";
                }
                $values[] = "(" . implode(",", $row) . ")";
            }
            $sql .= (implode(",", $values));
        }

        if (!empty($sql)) {
            $command = $transDb->createCommand($sql);
            $success = $command->execute();
            if ($success) {
                if (!empty($msgIds)) {
                    $sql = "update tb_notice_message set istrans=1 where msgid in(" . implode(",", $msgIds) . ')';
                    $xianxindb = Yii::app()->db_xiaoxin;
                    $commandxiaoxin = $xianxindb->createCommand($sql);
                    $commandxiaoxin->execute();
                }
            }
        }


    }
}