<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-10
 * Time: 下午3:41
 */

class ClientlogCommand extends CConsoleCommand{
    public function run($args)
    {
        $lastid = ClientLogSchoolRelation::getMaxLogPk();
        $logs = ClientLogSchoolRelation::LoadClientLog($lastid);

        $result = array('lastid'=>$lastid,'total'=>count($logs),'success'=>0);
        foreach($logs as $log){
            // $psg_relation = PhoneSchoolGradeRelation::getByUserId($log->mobilephone);
            $psg_relation = UserSchoolGradeRelation::getByUserId($log->userid);

            if(!$psg_relation){
                continue;
            }
            $school = School::model()->findByPk($psg_relation->sid);
            if(!$school){
                continue;
            }

            $grade = $psg_relation->g;
            $area = $school->a;
            // $city = $area->c;
            $city =  Area::model()->findByPk($area->parentid);
            if(!$area || !$city){
                continue;
            }
            // $model = new ClientLogSchoolRelation;
            $model = new ClientLogSchoolRelation;

            $model->clid = $log->clid;
            // $model->mobilephone = $log->mobilephone;
            $model->userid = $log->userid;

            $model->target = $log->target;
            $model->tid = $log->tid;
            $model->action = $log->action;
            $model->moid = $log->moid;
            $model->creationtime = $log->creationtime;
            $model->sid = $school->sid;
            $model->sname = $school->name;
            $model->gid = $grade->gid;
            $model->gname = $grade->name;
            $model->aid = $area->aid;
            $model->aname = $area->name;
            $model->cid = $city->aid;//$city->cid;
            $model->cname = $city->name;
            if($log->target=='Mall' && $log->action=='Comment' && $log->moid){
                // $commentrecord = MallOrdersGoodsRelation::getCommentByMobile($log->moid,$log->tid,$log->mobilephone);
                $commentrecord = MallOrdersGoodsRelation::getCommentByUserid($log->moid,$log->tid,$log->userid);
                $model->comment = $commentrecord?$commentrecord->comment:'';
            }
            $model->save();
            $result['success'] += 1;
        }
        var_dump($result);
    }
}