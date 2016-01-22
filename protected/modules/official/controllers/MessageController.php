<?php

class MessageController extends Controller
{
    public function actionIndex()
    {
        $param = isset($_GET['param']) ? $_GET['param'] : array();
        $message = new Message();

        $merged_param = array_merge($param, array(
            'size' => 10,
            'infoid' => Yii::app()->getModule('official')->user->getInfo('infoid')
        ));
        $data = $message->pageData($merged_param);

        $this->render('index', array('message' => $data, 'param' => $param));
    }

    /**
    * 消息的列表接收post及视图
    */
    public function actionList()
    {
        $this->render('list');
    }

    /**
    * 接收删除消息的post
    * @param did [要删除的信息ID]
    */
    public function actionDelete()
    {
        if (!isset($_GET['did'])) {
            Yii::app()->msg->postMsg('error', '参数出错!');
            $this->redirect(Yii::app()->createUrl('/official/message/index'));
        }

        $message = new Message();
        $result = $message->delMsg($_GET['did']);
        if ($result > 0) {
            Yii::app()->msg->postMsg('success', '删除成功!');
        } else {
            Yii::app()->msg->postMsg('error', '删除失败!');
        }
        $this->redirect('index');
    }

    /**
     * 编辑消息的视图
     */
    public function actionEditmsgform()
    {
        $infoid = (int)Yii::app()->getModule('official')->user->getInfo('infoid');
        $message = Message::getAppointMsg($infoid, (int)$_GET['eid']);

        if ($message === null) {
            Yii::app()->msg->postMsg('failed', '信息不存在!');
            $this->redirect('index');
        }
        // 空消息停止
        /*if (false == $message ) {
            Yii::app()->end();
        }*/
        $send = new Send();
        $sendFreq = new SendFreq();
        if (isset($message->con->content) && $message->con->content != '') {
            $temp = $message->con->content;
            $temp = json_decode($temp ,true);
            $str = '';
            if( true == isset($temp['item']) && true == $temp['item'] ){
                foreach ($temp['item'] as $v) {
                    if (!isset($v['content'])) {
                        continue;
                    }
                    if ( true == isset($v['type']) && $v['type'] == 'image') {
                        isset($v['width']) ? $v['width'] : $v['width'] = 0;
                        isset($v['height']) ? $v['height'] : $v['height'] = 0;
                        $str .= '<p><img src="'.$v['content'].'?'.Message::IMAGE_INFO_URL_MARK.'='.$v['width'].'_'.$v['height'].'"></p>';
                    }
                    if ( true == isset($v['type']) && $v['type'] == 'text')
                        $str .= '<p>' . $v['content'] . '</p>';
                }
            }
            $message->con->content = str_replace(array("\r\n", "\r", "\n"), "", addslashes($str));
        }
        $this->render('editmsgform', array('message' => $message, 'send' => $send, 'sendFreq' => $sendFreq));
    }

    /**
    * 接收封住消息的post
    */
    public function actionBlock()
    {
        $this->render('block');
    }

    /**
     * Ajax获取封贴理由
     */
    public function actionGetCloseReason()
    {
        if (isset($_GET['msgid']) && $_GET['msgid'] != '') {
            $closeLog = new CloseLog();
            $data = $closeLog->getLastReason((int)$_GET['msgid']);
            $arr = array();
            if ($data !== false) {
                $arr = array('cbid' => $_GET['msgid'], 'reason' => $data['reason']);
            } else {
                $arr = array('cbid' => $_GET['msgid'], 'reason' => '获取失败，没有该记录');
            }
            exit(json_encode($arr));
        }

        $arr = array('cbid' => 404, 'reason' => '参数不完整');
        exit(json_encode($arr));
    }

    public function actionBackup()
    {
        Yii::import('application.extensions.mysqlBr', TRUE);//导入Mysql备份类库
        $connect_str = parse_url(Yii::app()->db_official->connectionString);
        $re_str = explode('=', implode('=', explode(';', $connect_str['path'])));//取得数据库IP,数据库名
        $config = array( //设置参数
            'host' => $re_str[1],
            'dbname'=> $re_str[3],
            'port' => 3306,
            'username' => Yii::app()->db_official->username,
            'userPassword' => Yii::app()->db_official->password,
            'dbprefix' => Yii::app()->db_official->tablePrefix,
            'charset' => Yii::app()->db_official->charset,
            'path' => './protected/data/backup/',    //定义备份文件的路径
            'isCompress' => 0,             //是否开启gzip压缩{0为不开启1为开启}
            'isDownload' => 0               //压缩完成后是否自动下载{0为不自动1为自动}
        );
        $mysql = new MysqlBackupAndRestore();
    }
}