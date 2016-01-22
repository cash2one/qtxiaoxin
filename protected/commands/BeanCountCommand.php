<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-10
 * Time: 下午3:41
 */

class BeanCountCommand extends CConsoleCommand{
    public function run($args)
    {
        $date = date("Y-m-d",strtotime("-1 day"));
        if(count($args)){
            $date = date($args[0],strtotime("day"));
        }
        
        $records = BeanAcquire::getYesterdayRecord($date);
        $user_bean = array();
        $deal_pks = array();
        foreach($records as $r){
            if($r->bean>0){//只算增加的积分
                if(isset($user_bean[$r->userid])){
                    $user_bean[$r->userid] += $r->bean;
                }else{
                    $user_bean[$r->userid] = $r->bean;
                }
                $deal_pks[] = $r->acquireid;
            }
        }

        foreach($user_bean as $userid=>$bean){
            $user = Member::model()->findByPk($userid);
            if($user){
                $user->bean += $bean;
                $user->save();
            }
        }

        BeanAcquire::updateDealState($deal_pks);
    }
}