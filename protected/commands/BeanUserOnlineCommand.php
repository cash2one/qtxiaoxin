<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-10
 * Time: 下午3:41
 */

class BeanUserOnlineCommand extends CConsoleCommand{

    public function run($args)
    {
        $date = date("Y-m-d",strtotime("-1 day"));
        if(count($args)){
            $date = date($args[0],strtotime("day"));
        }

        $invite_hist = UserOnline::getYesterdayRecord($date);
        $master_arr = array();
        $teachers = array();
        $teacher_bean = array();
        $ruleid = 15;
        $rule = BeanRule::model()->findByPk($ruleid);
        $content = json_decode($rule->content,true);
        // $max = $content['bean'];
        // $bean = $content['number'];
        $bean = $content['bean'];
        $max = $content['number'];
        foreach($invite_hist as $inv){
            if(!isset($master_arr[$inv->userid])){
                $master_arr[$inv->userid] =array('master'=>array(),'beans'=>0);
                $sql = "SELECT DISTINCT `master` FROM tb_class WHERE cid IN (SELECT DISTINCT cid FROM tb_class_student_relation WHERE student IN (SELECT child FROM tb_guardian WHERE guardian=".$inv->userid.")) AND `master` IS NOT NULL";
                $masters = UCQuery::queryAll($sql);
                foreach($masters as $m){
                    $teachers[] = $m['master'];
                }
            }
        }
        
        foreach($teachers as $t){

            if(!isset($teacher_bean[$t])){
                $teacher_bean[$t]['bean']=0;
                $teacher_bean[$t]['number']=0;
                $teacher_bean[$t]['deal']=BeanAcquire::countByConditation($date,array('userid'=>$t,'ruleid'=>$ruleid));
            }
            if($max==0 || $teacher_bean[$t]['number']<$max){
                $teacher_bean[$t]['bean']+=$bean;
                $teacher_bean[$t]['number']+=1;
            }


            // if(isset($teacher_bean[$t])){
            //     $teacher_bean[$t]['bean']+=$bean;
            //     $teacher_bean[$t]['number']+=1;
            // }else{
            //     $teacher_bean[$t]['bean']=$bean;
            //     $teacher_bean[$t]['number']=1;
            //     $teacher_bean[$t]['deal']=BeanAcquire::countByConditation(array('userid'=>$t,'ruleid'=>$ruleid));
            // }
        }
        foreach($teacher_bean as $userid=>$data){
            if($data['deal']==0){
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