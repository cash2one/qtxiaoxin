<?php
/**
* panrj 2014-12-08
* 通知类青豆日志
*/

class BeanNoticeCommand extends CConsoleCommand{

    public function run($args)
    {
        $date = date("Y-m-d",strtotime("-1 day"));
        if(count($args)){
            $date = date($args[0],strtotime("day"));
        }

        $rule_pks = array(
            '11'=>array(1),
            '12'=>array(2,7),
            '13'=>array(3),
            '14'=>array(5),
        );
        $rules = BeanRule::getRuleByPks(array_keys($rule_pks));
        $user_data = array();
        $limit = 5000;
        foreach($rules as $r){
            $rule = json_decode($r->content,true);
            $bean = $rule['bean'];
            $max = $rule['number'];

            $times = 0;
            $history = NoticeMessage::getYesterdayBean($date,$rule_pks[$r->ruleid]);
            $lastid = 0;
            do{//每天数据量太大，容易内存溢出导致脚本无法执行，所以改为分批执行，一次默认5000条，直到执行完成
                $history = NoticeMessage::getYesterdayBean($date,$rule_pks[$r->ruleid],$lastid,$limit);
                if(count($history)==$limit){
                    $lastid = $history[$limit-1]->msgid;
                }
                foreach($history as $h){
                    if(!isset($user_data[$h->sender][$r->ruleid])){
                        $is_deal = BeanAcquire::countByConditation($date,array('userid'=>$h->sender,'ruleid'=>$r->ruleid));
                        $user_data[$h->sender][$r->ruleid] = array(
                            'number'=>0,
                            'bean'=>0,
                            'deal'=>$is_deal,
                        );
                    }
                    
                    if($user_data[$h->sender][$r->ruleid]['deal']==0){
                        $has_client = UserOnline::checkUserOnLine(explode(',',$h->rguardian));
                        if($has_client){//接收者安装客户端才算积分
                            if($max==0 || $user_data[$h->sender][$r->ruleid]['number']<$max){
                                $user_data[$h->sender][$r->ruleid]['number'] += 1;
                                $user_data[$h->sender][$r->ruleid]['bean'] += $bean;
                            }
                        }
                    }
                }
            }while($lastid>0 && count($history)==$limit);
        }
        foreach($user_data as $userid=>$rule_datas){
            foreach($rule_datas as $ruleid=>$data){
                if($data['deal']==0){//单个用户单个规则当天只执行一次
                    $model = new BeanAcquire;
                    $model->userid = $userid;
                    $model->notedate = $date;
                    $model->ruleid = $ruleid;
                    $model->number = $data['number'];
                    $model->bean = $data['bean'];
                    $model->beanfrom = 1;
                    $model->save();
                }
            }
        }
    }

}