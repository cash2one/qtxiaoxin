<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-10
 * Time: 下午3:41
 */

class PingyinCommand extends CConsoleCommand
{
    public function run($args)
    {
        //找用户
        $userList = UCQuery::queryAll("select userid,name from tb_user where deleted=0 and  (length(pingyin)<1 or pingyin is null) and identity in(1,2,5)    limit 1000");
        $py = new py_class();
        foreach ($userList as $val) {
            $pingyin = $py->str2py(trim($val['name']));
            UCQuery::execute("update tb_user set pingyin='" . substr($pingyin, 0, 10) . "' where userid=" . $val['userid']);
        }

        //转学校
        $schoolList = UCQuery::queryAll("select sid,name from tb_school where deleted=0  and (length(pingyin)<1 or pingyin is null)  order by sid limit 100");
        foreach ($schoolList as $val) {
            $schoolpingyin=$py->str2py(trim($val['name']));
            if($schoolpingyin){
                UCQuery::execute("update tb_school set pingyin='".substr($schoolpingyin,0,10)."' where sid=".$val['sid']);
            }
        }

        //转班级
        $classList = UCQuery::queryAll("select cid,name from tb_class where deleted=0  and (length(pingyin)<1 or pingyin is null)  order by cid limit 100 ");
        foreach ($classList as $val) {
            $classpingyin=$py->str2py(trim($val['name']));
            if($classpingyin){
                UCQuery::execute("update tb_class set pingyin='".substr($classpingyin,0,10)."' where cid=".$val['cid']);
            }
        }

    }
}