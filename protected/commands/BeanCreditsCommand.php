<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-10
 * Time: 下午3:41
 */

class BeanCreditsCommand extends CConsoleCommand{

    public function run($args)
    {
        $date = date("Y-m-d",strtotime("-1 day"));
        if(count($args)){
            $date = date($args[0],strtotime("day"));
        }

        $ruleid = 16;
        $rule = BeanRule::model()->findByPk($ruleid);
        $content = json_decode($rule->content,true);

        $records = LogCredits::getYesterdayRecord($date);
        $user_bean = array();
        foreach($records as $r){
            $bean = $r->credits;
            if(isset($user_bean[$r->user_id])){
                $user_bean[$r->user_id]['bean'] += $bean;
                $user_bean[$r->user_id]['number'] += 1;
            }else{
                $user_bean[$r->user_id]['bean'] = $bean;
                $user_bean[$r->user_id]['number'] = 1;
                $user_bean[$r->user_id]['deal']=BeanAcquire::countByConditation($date,array('userid'=>$r->user_id,'ruleid'=>$ruleid));
                
            }
        }

        foreach($user_bean as $userid=>$data){
            if($data['deal']==0){
                $model = new BeanAcquire;
                $model->userid = $userid;
                $model->notedate = $date;
                $model->ruleid = $ruleid;
                $model->number = $data['number'];
                $model->bean = $data['bean'];
                $model->beanfrom = 1;
                $model->isdeal = 1;
                $model->save();
            }
        }
    }

    // public function findNum($str=''){
    //     $str=trim($str);
    //     if(empty($str)){return '';}
    //     $reg='/(\d{3}(\.\d+)?)/is';//匹配数字的正则表达式
    //     preg_match_all($reg,$str,$result);
    //     if(is_array($result)&&!empty($result)&&!empty($result[1])&&!empty($result[1][0])){
    //         return $result[1][0];
    //     }
    //     return '';
    // }
    
}