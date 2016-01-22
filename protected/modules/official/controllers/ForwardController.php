<?php

/**
 * 消息转载列表功能
 * @author ld
 *
 */
class ForwardController extends Controller
{

    public function filterCheckOpenType($filterChain)
    {
        // 普通类型公众号结束
        if (OfficialInfo::OPEN_TYPE_SYSTEM == Yii::app()->getModule('official')->user->getinfo('opentype')) {
            $filterChain->run();
        } else {
            Yii::app()->end();
        }
    }

    public function filters()
    {
        return array(
            'checkOpenType'
        );
    }

    public function actionIndex()
    {
        $param = isset($_GET['param']) ? $_GET['param'] : array();

        $message = new Message();

        $merged_param = array_merge($param, array(
            'forward' => false,
            'infoid' => Yii::app()->getModule('official')->user->getinfo('infoid')
        ));

        $data = $message->listMsg($merged_param);

        $info = $message->getOfficialInfo($data['models']);

        $this->render('index', array(
            'forward' => $data,
            'param' => $param,
            'info' => $info,
        ));
    }

    /**
     * 转载列表中，查阅消息正文
     */
    public function actionView()
    {
        $message = Message::getMsgById((int) $_GET['eid']);

        if ($message === null) {
            Yii::app()->msg->postMsg('failed', '信息不存在!');
            $this->redirect('index');
        }

        $send = new Send();
        if (isset($message->con->content) && $message->con->content != '') {
            $temp = $message->con->content;
            $temp = json_decode($temp, true);
            $str = '';
            if (true == isset($temp['item']) && true == $temp['item']) {
                foreach ($temp['item'] as $v) {
                    if (true == isset($v['type']) && $v['type'] == 'image') {
                        isset($v['width']) ? $v['width'] : $v['width'] = 0;
                        isset($v['height']) ? $v['height'] : $v['height'] = 0;
                        $str .= '<p><img src="' . $v['content'].'?'.Message::IMAGE_INFO_URL_MARK.'='.$v['width'].'_'.$v['height'].'"></p>';
                    }
                    if (true == isset($v['type']) && $v['type'] == 'text')
                        $str .= '<p>' . $v['content'] . '</p>';
                }
            }
            $message->con->content = $str;
        }
        $this->render('viewmsgform', array(
            'message' => $message,
            'send' => $send
        ));
    }

    /**
     * 转发的消息列表接收post及视图
     */
    public function actionList()
    {
        $param = isset($_GET['param']) ? $_GET['param'] : array();

        $message = new Message();

        $merged_param = array_merge($param, array(
            'forward' => true,
            'infoid' => Yii::app()->getModule('official')->user->getinfo('infoid')
        ));

        $data = $message->listMsg2($merged_param);

        $this->render('forward', array(
            'forward' => $data,
            'param' => $param,
        ));
    }

    /**
     * 接收消息转发的post
     */
    public function actionDo()
    {
        $byinfoid = isset($_GET['byinfoid']) ? $_GET['byinfoid'] : 0;
        $msgid = isset($_GET['msgid']) ? $_GET['msgid'] : 0;

        if ($byinfoid <= 0 || $msgid <= 0) {
            Yii::app()->msg->postMsg('error', '转发失败，参数出错!');
            $this->redirect('index');
        }

        $send = new Send();
        $result = $send->forwardMsg(Yii::app()->getModule('official')->user->getinfo('infoid'), $msgid, $byinfoid);

        if ($result > 0) {
            Yii::app()->msg->postMsg('success', '转发成功!');
        } else {
            if ($send->hasErrors()) {
                $errors = $send->getErrors();
                $error = !empty($errors) ? array_shift($errors) : "转发失败!";
                $msg = true == is_array($error) && !empty($error) ? array_shift($error) : '转发失败!';
                Yii::app()->msg->postMsg('error', $msg);
            } else {
                Yii::app()->msg->postMsg('error', '转发失败!');
            }
        }

        $this->redirect('index');
    }

    /**
     * 接收删除转发消息的post
     */
    public function actionDelete()
    {
        if (! isset($_GET['sid'])) {
            Yii::app()->msg->postMsg('error', '参数出错!');
            $this->redirect(Yii::app()->createUrl('/official/forward/list'));
        }

        $send = new Send();
        $result = $send->delForwardMsg((int) $_GET['sid']);

        if ($result > 0) {
            Yii::app()->msg->postMsg('success', '删除成功!');
        } else {
            Yii::app()->msg->postMsg('error', '删除失败!');
        }

        $this->redirect('list');
    }
}