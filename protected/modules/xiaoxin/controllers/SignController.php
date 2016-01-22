<?php
//自定义前面
class SignController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            // 'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('scheck'),
                'users' => array('*'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'insert', 'del', 'update','test'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function  actionIndex()
    {
        $uid = Yii::app()->user->id;
        $data = Sign::getUserSign($uid); //自定义的签名

        $arr = array(); //固定的签名不可修改的
        $member = Member::model()->findByPk($uid);
        $arr[] = $member->name;
        $arr[] = $member->name . '老师';
        $xing = MainHelper::getXing($member->name);
        if (!empty($xing)) {
            $arr[] = $xing . '老师';
        }
        $this->render('index', array('signs' => $data, 'arr' => $arr));
    }

    public function  actionInsert()
    {
        if (isset($_POST['name'])) {
            $name = trim(MainHelper::safe_string(trim($_POST['name'])));
            $signArr=Sign::getUserSignArr(Yii::app()->user->id);
            if(in_array($name,$signArr)){
                die(json_encode(array('status' => '0', 'msg' => '保存失败,已存在相同签名')));
            }
            $sign = new Sign;
            $sign->userid = Yii::app()->user->id;
            $sign->name = $name;
            $sign->creationtime=date("Y-m-d H:i:s");
            $sign->updatetime=date("Y-m-d H:i:s");
            if ($sign->save()) {
                die(json_encode(array('status' => '1', 'id' => $sign->id)));
            } else {
                die(json_encode(array('status' => '0', 'msg' => '保存失败')));
            }

        }

    }


    public function  actionDel()
    {
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            if ($id) {
                $sign = Sign::model()->findByPk($id);
                if ($sign) {
                    $sign->deleted = 1;
                    if ($sign->save()) {
                        die(json_encode(array('status' => '1')));
                    } else {
                        die(json_encode(array('status' => '0', 'msg' => '删除失败')));
                    }
                } else {
                    die(json_encode(array('status' => '0', 'msg' => '删除失败,参数错误')));
                }
            } else {
                die(json_encode(array('status' => '0', 'msg' => '参数错误')));
            }
        }

    }
    public function actionTest(){
        $starttime = explode(' ',microtime());
       // for($i=0;$i<1000000;$i++){

        //}
        $key=Yii::app()->request->getParam("key");
        $m = new Memcache();
        $m->addServer('localhost', 11211);
       // $m->increment("a",1);
        //$version = (int)USER_BRANCH;
        //$key="INCREMENT_ID0".$version;
        $m->delete($key);
        var_dump($m->get($key));
        die;

        UCQuery::makeMaxIdByCache("1");
        die;
        $parentid = UCQuery::makeMaxId(0, true);
        $endtime = explode(' ',microtime());
        $thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
        $thistime = round($thistime,3);
        error_log("this time:".$thistime);

       // error_log("2:".$s2);
       //error_log("2:".($s2-$s1));
        D('sss');
        $redis = new Predis\Client(Yii::app()->params['redis']);
        $redis->zadd("test_zadd",10,"list1");
        $redis->zadd("test_zadd",12,"list2");
        D($redis->zrangebyscore("test_zadd",11,21));
    }
}