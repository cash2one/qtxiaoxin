<?php

/**
 * 每分钟定时自动化执行 发布消息 命令行模式
 */
class MsgpublishCommand extends CConsoleCommand
{

    public function run($args)
    {
        $sendTimer = new SendTimer();

        $criteria = new CDbCriteria();

        $criteria->compare('forward', Message::MSG_NOT_PUBLISH); // 未发布条件
        $criteria->compare('deleted', Message::LOGIC_NOT_DELETE); // 不删除条件
        //$criteria->compare('sendtime', '>=' . date('Y-m-d H:i:s', time() - 58) ); // 过去58秒以为的条件
        $criteria->compare('sendtime', '<=' . date('Y-m-d H:i:s', time() + 2) ); // 将来2秒以为的条件

        $count = $sendTimer->count($criteria);

        for ($i=0;$i<$count;$i++){
            $criteria->limit = 1000;
            $criteria->offset = $i*1000;
            $list = $sendTimer->findALL($criteria);     // 分页查询所有的准发布记录，防止一次查询大量的数据

            foreach ($list as $v) {
                if ($v instanceof SendTimer) {
                    // 查询存在消息表和发布表中
                    $message = Message::model()->findByPk($v->msgid);
                    $send = Send::model()->findByAttributes(array(
                        'infoid' => $v->infoid,
                        'msgid' => $v->msgid
                    ));

                    // 发布表中不存在，则改为新增
                    if( false == $send ){
                        $send = new Send();
                    }

                    // 不存在消息表或存在发布表时跳过，并更改定时发送表记录为异常
                    if (false == $message || (true == $send && Message::MSG_PUBLISH == $send->forward)) {
                        $v->forward = Message::MSG_PUBLISH_ERROR; // 定时发布异常
                        $v->save(false);
                        continue;
                    }

                    if( $message->close == Message::MSG_CLOSE ) {
                        $v->forward = 4; // 定时发布的消息被封贴
                        $v->save(false);
                        continue;
                    }

                    if( $message->deleted == Message::LOGIC_DELETE ) {
                        $v->forward = 5; // 定时发布的消息被逻辑删除
                        $v->save(false);
                        continue;
                    }

                    // 更改发布表、定时发布表、消息表的发布状态
                    $send->publishtime = $message->publishtime = date('Y-m-d H:i:s');
                    $send->forward  = Message::MSG_PUBLISH; // 设置先为发布状态
                    $v->forward     = Message::MSG_PUBLISH;
                    $message->send  = Message::MSG_PUBLISH;
                    $send->infoid   = $v->infoid;           // 如果是新增发布表中，这里就必须赋值发布表字段
                    $send->msgid    = $v->msgid;

                    $transaction = $v->getDbConnection()->beginTransaction();

                    try {
                        $message->save(false);
                        $send->save(false);
                        $v->save(false);
                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
        }
    }
}