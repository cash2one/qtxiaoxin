<?php

class PublishController extends Controller
{
    /**
     * 新增消息视图
     */
    public function actionIndex()
    {
        $send = new SendFreq();
        $this->render('index',array('send'=>$send));
    }

    /**
     * 使用ajax把正文内容数据json化
     */
    public function actionImgjson()
    {
        if (Yii::app()->request->isPostRequest && true == Yii::app()->request->getParam('content')) {

            $data = Message::model()->formtContentArray( Yii::app()->request->getParam('content') );

            header('Content-type: application/json');
            echo json_encode($data);
        }

        Yii::app()->end();
    }

    /**
     * 发布一条消息
     */
    public function actionPublish()
    {
        $result = Message::model()->publishMsg( Yii::app()->request->getParam('msgid') );

        if( true == $result && false == Message::model()->hasErrors() ){
            Yii::app()->msg->postMsg('success', '发布成功!');
        }else{
            $errors = Message::model()->getErrors();
            $error = !empty($errors) ? array_shift($errors) : "数据保存失败";
            $msg = true == is_array($error) && !empty($error) ? array_shift($error) : '数据保存失败！';
            Yii::app()->msg->postMsg('failed', $msg);
        }

       $this->redirect( $this->createUrl( 'message/index' ) );
    }

    /**
     * 保存消息接收post
     */
    public function actionSavemsg()
    {
        $message = '';

        if( true == Yii::app()->request->getParam('msgid') ) {
            $message = Message::model()->findByPk( (int)Yii::app()->request->getParam('msgid') );
        }
        else {
            $message = new Message();
        }

        if(  true == Yii::app()->request->getParam('timer')
            && true == Yii::app()->request->getParam('publish') ){

            $sendtime = Yii::app()->request->getParam('sendtime');

        }else {
            $sendtime = 0;
        }

        $result = $message->saveMsg(
            Yii::app()->request->getParam('title'),
            Yii::app()->request->getParam('subhead'),
            Yii::app()->request->getParam('cover'),
            Yii::app()->request->getParam('msgfrom'),
            Yii::app()->request->getParam('content'),
            $sendtime,
            Yii::app()->request->getParam('publish')
        );

        if (true == $result && false == $message->hasErrors() ) {
            Yii::app()->msg->postMsg('success', '操作成功!');
        }
        else {
            $errors = $message->getErrors();
            $error = !empty($errors) ? array_shift($errors) : "数据保存失败";
            $msg = true == is_array($error) && !empty($error) ? array_shift($error) : '数据保存失败！';
            Yii::app()->msg->postMsg('failed', $msg);
        }
        if (true == Yii::app()->request->getParam('msgid')) {
            $this->redirect(  array('message/editmsgform', 'eid'=>Yii::app()->request->getParam('msgid')) );
        }
        else {
            $this->redirect('index');
        }
    }

    /**
     * 编辑消息的视图
     */
    public function actionEditmsgform()
    {
        $message = Message::getMsgById( (int)$_GET['eid'] );
        $send = new Send();
        if (isset($message->con->content) && $message->con->content != '') {
            $temp = $message->con->content;
            $temp = json_decode($temp ,true);
            $str = '';
            if( true == isset($temp['item']) && true == $temp['item'] ){
                foreach ($temp['item'] as $v) {
                    if ( true == isset($v['type']) && $v['type'] == 'image')
                        $str .= '<p><img src="'.$v['content'].'"></p>';
                    if ( true == isset($v['type']) && $v['type'] == 'text')
                        $str .= '<p>' . $v['content'] . '</p>';
                }
            }
            $message->con->content = $str;
        }
        $this->render('editmsgform', array('message' => $message,'send'=>$send));
    }

}