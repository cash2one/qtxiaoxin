<?php
/**
 * Class FansConfigCommand
 */
class ImportFansCommand extends CConsoleCommand
{
    const OPEN_TYPE_SYSTEM = 1; //公众号类型
    const IDENTITY_TEACHER = 1;
    const IDENTITY_PARENT  = 4;
    const IDENTITY_UNKONW  = 5;
    const IS_FLLOW_STATUS  = 1;

    public function run($args)
    {
        //set_time_limit(5);
        $timeStart = time();
        $dbMember = Yii::app()->db_member;
        $dbOfficial = Yii::app()->db_official;

        $dbOfficialName = preg_match("/dbname=(.*)/", $dbOfficial->connectionString, $officialMatch);
        $dbMemberName = preg_match("/dbname=(.*)/", $dbMember->connectionString, $memberMatch);

        $sql = "SELECT infoid FROM op_official_info WHERE opentype = " . self::OPEN_TYPE_SYSTEM;
        $systemUser = $dbOfficial->createCommand($sql)->queryAll(); //获取所有系统公众号

        foreach ($systemUser As $row) {
            $tmpid = (int)$row['infoid'];
            while (true) {
                //55秒后终止程序
                if (time() - $timeStart >= 55)
                    exit("Run Time:" . (time() - $timeStart) . " seconds");
                //每次取1000条记录
                $sql = "SELECT t.userid FROM ". $memberMatch[1] .".tb_user AS t WHERE t.userid NOT IN (SELECT f.userid FROM ". $officialMatch[1] .".op_fans AS f WHERE f.infoid = " . $tmpid . ") AND t.deleted = 0 AND t.identity IN (" . self::IDENTITY_TEACHER . ", " . self::IDENTITY_PARENT . ", " . self::IDENTITY_UNKONW . ") LIMIT 1000;";
                $cnt = $dbMember->createCommand($sql)->queryAll();
                if (empty($cnt))
                    break;
                $insertSQL = "INSERT INTO op_fans (infoid, follow ,userid, creationtime) VALUES ";
                $values = "";
                $creationtime = date("Y-m-d H:i:s");
                //组成values 一次性插入 1000条记录
                foreach ($cnt as $crow) {
                    $values .= "(" . $tmpid . ",1," . $crow['userid'] . ",'" . $creationtime . "'),";
                }
                $values = substr($values, 0, strlen($values)-1); //去掉最后的逗号(,)
                $insertSQL .= $values . ";";
                $result = $dbOfficial->createCommand($insertSQL)->execute();
                if (!$result) exit;
            }
        }
        echo "All Data Imported!";
    }
}