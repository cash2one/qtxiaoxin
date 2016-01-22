<?php
class NoticeCommand extends CConsoleCommand
{
    public function run($args)
    {
        $list = NoticeQuery::queryAll("select * from tb_notice_fixedtime where  `status`=1 and sendtime<now() and state=0 and sender like '%".USER_BRANCH."' limit 100;");
        $db = Yii::app()->db_xiaoxin;
        //$transaction = $db->beginTransaction();

        if (is_array($list)) {
            foreach ($list as $data) {
                try {
                    $sql = " call php_xiaoxin_insert_message(:uid,:receive,:noticeType,:data,:sendTitle,:receiveTitle,:isSendsms,:sid
                    ,:schoolname,:receivename,:sendtime)";
                    $db->createCommand("start TRANSACTION; ")->execute();
                    $command = $db->createCommand($sql);
                    $command->bindParam(':uid', $data['sender'], PDO::PARAM_INT);
                    $command->bindParam(':receive', $data['receiver'], PDO::PARAM_STR);
                    $command->bindParam(':noticeType', $data['noticetype'], PDO::PARAM_INT);
                    $command->bindParam(':isSendsms', $data['isSendsms'], PDO::PARAM_INT);
                    $command->bindParam(':data', $data['content'], PDO::PARAM_STR);
                    $command->bindParam(':receiveTitle', $data['receivertitle'], PDO::PARAM_STR);
                    $command->bindParam(':sendTitle', $data['sendertitle'], PDO::PARAM_STR);
                    $command->bindParam(':schoolname', $data['schoolname'], PDO::PARAM_STR);
                    $command->bindParam(':receivename', $data['receivename'], PDO::PARAM_STR); //接收者名称,比如高中一年级(2),(3)班或李xx,王yy
                    $command->bindParam(':sendtime', $data['sendtime'], PDO::PARAM_STR); //接收者名称,比如高中一年级(2),(3)班或李xx,王yy
                    $command->bindParam(':sid', $data['sid'], PDO::PARAM_INT);
                    $command->execute();
                    $sql2 = " update tb_notice_fixedtime set state=1 where id=" . $data['id'];
                    $command2 = NoticeQuery::execute($sql2);
                    $db->createCommand("commit; ")->execute();
                } catch (Exception $e) {
                    $db->createCommand("rollback; ")->execute();
                }
            }
        }
    }

}

?>