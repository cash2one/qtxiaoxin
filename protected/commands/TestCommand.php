<?php
/**
 * 自动化执行 命令行模式
 */
class TestCommand extends CConsoleCommand
{
    public function run($args)
    {
        $smsconfig = NoticeQuery::queryAll("select * from tb_sms_config");
        $sids = array();
        foreach ($smsconfig as $val) {
            $sids[] = $val['sid'];
        }
        if (count($sids) > 0) {
            $list1 = NoticeQuery::queryAll("select * from tb_notice_message where state=0 and deleted=0  and sid not in(" . implode(",", $sids) . ") limit 1000; ");

        }

        $list2 = NoticeQuery::queryAll(" select f.* from tb_notice_message f inner join tb_sms_config t on f.sid=t.sid where
                  state=0 and deleted=0  and (t.starttime<now() or t.endtime>now()) and !FIND_IN_SET(f.noticetype,t.noticetype)
                ");
        $all=$list1+$list2;
    }
}