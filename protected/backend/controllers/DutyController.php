<?php
class DutyController extends Controller
{
    public function  actionCreate(){
        $allApplication = Application::model()->findAll('deleted=:deleted',array(':deleted'=>0));
        if(isset($_POST['Duty'])&&isset($_POST['applicationid'])){
                   $appid = $_POST['applicationid'];
                   $isseeallclass = $_POST['Duty']['isseeallclass'];
                   $num = count($appid);
                   $name = $_POST['Duty']['name'];
                   $model = new Duty;
                   $model->name = $name;
                   $model->isseeallclass = $isseeallclass;
                   $model->state = 1;
                   $model->deleted = 0;
                   $sign = 0;
                   if($model->save()){
                        //创建关系
                       foreach($appid as $key=>$val){
                           $DutyApplicationRelation = new DutyApplicationRelation;
                           $DutyApplicationRelation->appid = $val;
                           $DutyApplicationRelation->dutyid = $model->dutyid;
                           $DutyApplicationRelation->state = 1;
                           $DutyApplicationRelation->deleted = 0;
                           $DutyApplicationRelation->save();
                           $sign++;
                       }
                       if($sign==$num){
                           Yii::app()->msg->postMsg('success', '操作成功');
                       }else{
                           Yii::app()->msg->postMsg('error', '操作失败');
                       }
                       $this->redirect(Yii::app()->createUrl('duty/index'));
                   }else{
                       $this->redirect(Yii::app()->createUrl('duty/index'));
                   }

        }
        $this->render("create",array('allApplication'=>$allApplication));
    }
    public function  actionUpdate(){
        $allApplication = Application::model()->findAll('deleted=:deleted',array(':deleted'=>0));
        if(isset($_POST['Duty'])&&isset($_POST['applicationid'])){
            $dutyid = isset($_POST['dutyid'])?$_POST['dutyid']:"";
            $appid = $_POST['applicationid'];
            $isseeallclass = $_POST['Duty']['isseeallclass'];
            $num = count($appid);
            $name = isset($_POST['Duty']['name'])?$_POST['Duty']['name']:"";
            $model = Duty::model()->findByPk($dutyid); // 找到这个数据
            if($model->deleted == 0){ //
                $model->name = $name;
                $model->isseeallclass = $isseeallclass;
                $model->state = 1;
            }
            $sign = 0;
            if($model->save()){
                $oldApp = DutyApplicationRelation::getAppidByDutyId($dutyid);//之前存在的应用
                if(!empty($oldApp)){
                    //存在删除之前的应用
                   $isbool =  DutyApplicationRelation:: getDelDeleted($dutyid);
                    //创建新应用
                    foreach($appid as $key=>$val){
                        $DutyApplicationRelation = new DutyApplicationRelation;
                        $DutyApplicationRelation->appid = $val;
                        $DutyApplicationRelation->dutyid = $dutyid;
                        $DutyApplicationRelation->state = 1;
                        $DutyApplicationRelation->deleted = 0;
                        $DutyApplicationRelation->save();
                        $sign++;
                    }
                }else{
                    foreach($appid as $key=>$val){
                        $DutyApplicationRelation = new DutyApplicationRelation;
                        $DutyApplicationRelation->appid = $val;
                        $DutyApplicationRelation->dutyid = $dutyid;
                        $DutyApplicationRelation->state = 1;
                        $DutyApplicationRelation->deleted = 0;
                        $DutyApplicationRelation->save();
                        $sign++;
                    }
                }
                if($sign==$num){
                    Yii::app()->msg->postMsg('success', '操作成功');
                }else{
                    Yii::app()->msg->postMsg('error', '操作失败');
                }
                $this->redirect(Yii::app()->createUrl('duty/index'));
            }else{
                $this->redirect(Yii::app()->createUrl('duty/index'));
            }

        }
        $dutyid = Yii::app()->request->getParam('dutyid');

        $duty = Duty::model()->findByPk($dutyid);
        $allApp  = DutyApplicationRelation::getAppidByDutyId($dutyid);

        if($duty&&$duty->deleted==0){
            $this->render("update",array('allApplication'=>$allApplication,'model'=>$duty,"allApp"=>$allApp));
        }
    }
    public function  actionIndex(){
        $DutyModel =  Duty::model()->findAll(array('select' => '*',
        'order' => 'dutyid DESC',
        'condition' => 'deleted=:deleted',
        'params' => array(':deleted'=>0),));
       // $DutyModel = Duty::pageData();

        $allDuty = array();
        foreach($DutyModel as $key=>$val){
            $allDuty[$key]['dutyid'] =$DutyModel[$key]['dutyid'];
            $allDuty[$key]['name'] =$DutyModel[$key]['name'];
            $allDuty[$key]['state'] =$DutyModel[$key]['state'];
            $allDuty[$key]['creationtime'] =$DutyModel[$key]['creationtime'];
            $allDuty[$key]['updatetime'] =$DutyModel[$key]['updatetime'];
            $allDuty[$key]['deleted'] =$DutyModel[$key]['deleted'];
            $allDuty[$key]['isseeallclass'] =$DutyModel[$key]['isseeallclass'];
            if($allDuty[$key]['isseeallclass']==0){
                $allDuty[$key]['range'] = "班级";
            }else  if($allDuty[$key]['isseeallclass']==1){
                $allDuty[$key]['range'] = "年级";
            }else if($allDuty[$key]['isseeallclass']==2){
                $allDuty[$key]['range'] = "全校";
            }else{
                $allDuty[$key]['range'] = "";
            }
            $Result  = DutyApplicationRelation::getAppidByDutyId($allDuty[$key]['dutyid']);
            $appNames  = array();
            foreach($Result as $k=>$v){
                $result=Application::model()->findByPk($v['appid']);
                if($result->deleted==0){
                    $appNames[] = $result['name'];
                }
            }
            $appNames=  implode(",",$appNames);
            $allDuty[$key]['appname'] =$appNames;
        }
        $this->render("index",array('allDuty'=>$allDuty));
    }

    public  function  actionDelete(){
        $id = Yii::app()->request->getParam("dutyid");
        if(isset($id)){
           $duty =  Duty::model()->findByPk($id);
           if($duty->deleted==0){
               $duty->deleted=1;
               if($duty->save()){
                   Yii::app()->msg->postMsg('success', '删除成功');
               }else{
                   Yii::app()->msg->postMsg('error', '删除失败');
               }
           }else{
               Yii::app()->msg->postMsg('error', '删除失败，改权限已被删除');
           }
        }else{
            Yii::app()->msg->postMsg('error', '删除失败，传入参数不正确');
        }
        $this->redirect(Yii::app()->createUrl("duty/index"));
    }

}