<?php
/**
 * 
 */
class KpiConfigCommand extends CConsoleCommand
{
    const ACCOUNT_STATE_NORMAL = 1;
    const ACCOUNT_NOT_DELETED = 0;
    const ACCOUNT_TYPE = 0;
    const PER_PAGE_NUMBER = 0;

    public function run($args)
    {
        $db = Yii::app()->db;
        $workParam = new WorkParam();

        $sql = "SELECT COUNT(*) AS cnt FROM tb_user WHERE state = ". self::ACCOUNT_STATE_NORMAL . " AND deleted = ". self::ACCOUNT_NOT_DELETED ." AND type =". self::ACCOUNT_TYPE;

        $cnt = $db->createCommand($sql)->queryAll();

        $total = $cnt[0]['cnt'];
        unset($cnt);

        $sql = "SELECT uid,username FROM tb_user WHERE state = ". self::ACCOUNT_STATE_NORMAL . " AND deleted = ". self::ACCOUNT_NOT_DELETED ." AND type =". self::ACCOUNT_TYPE;
        $data = $db->createCommand($sql)->queryAll();
        $creationtime = date("Y-m-d H:i:s");
        $sql = "INSERT INTO tb_work_config (userid, creationtime) VALUES";
        $values = "";
        $max = count($data) - 1;
        for ($i = 0; $i < count($data); $i++) {
            $values .= "(". $data[$i]['uid'] .",'". $creationtime ."')";
            if ($i < $max) {
                $values .= ",";
            }
        }
        $sql .= $values . ";";
        echo $sql . PHP_EOL;
        $rs = $db->createCommand($sql)->query();
    }
}