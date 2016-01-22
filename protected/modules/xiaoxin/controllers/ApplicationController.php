<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-8-9
 * Time: 上午9:47
 * 日常应用
 */

class ApplicationController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            // 'postOnly + delete', // we only allow deletion via POST request
        );
    }
    public function init(){
        $identity = Yii::app()->user->getIdentity(); //获取是老师还是家长登录
        if($identity==Constant::FAMILY_IDENTITY){
            $this->redirect(Yii::app()->createUrl("xiaoxin/default/index"));
            exit();
        }
    }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'add'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /*
     * 所有应用列表
     */
    public function actionIndex()
    {
        $uid = Yii::app()->user->id;
        $userinfo=Yii::app()->user->getInstance();
        $identity=Yii::app()->user->getIdentity(); //根据身份去获取各自的菜单,家长有家长的，老师有老师的
        if($identity==4){
            $allapp = NoticeQuery::getAllApplication($identity);
        }else{
            $allapp = NoticeService::getAppByUid($uid);
        }
        $myapp = NoticeQuery::getMyApplication($uid);
        $temp=array();
        foreach ($myapp as $v) {
            $temp[]=(int)$v['appid'];
        }

        foreach ($allapp as $k => $val) {
            if(in_array((int)$val['appid'],$temp)){
                $allapp[$k]['have']=1;
            }else{
                $allapp[$k]['have']=0;
            }
        }
        $isApproveRight=false;
        $approvePersonList=NoticeQuery::checkApprove($uid); //获取有审核权限的学校id
        if(!empty($approvePersonList)){
            $isApproveRight=true;
        }
        $temp=array();
        foreach($allapp as $k=>$val){
            if(strpos($val['url'],"approvelist")!==false){
                if($isApproveRight){
                    $temp[]=$val;
                }
            }else{
                $temp[]=$val;
            }
        }
        //ss
        $this->render("index", array('data' => $temp,'isApproveRight'=>$isApproveRight));
    }

    /*
    * 加到我的快捷
    */
    public function actionAdd()
    {
       // $data = array();
        $uid = Yii::app()->user->id;
        $appid = Yii::app()->request->getParam('appid');
        $state=(int)Yii::app()->request->getParam('state');

        if ($uid && $appid) {
            $success = NoticeQuery::AddToMyApplication($appid,$uid,$state);
           // $myapp = NoticeQuery::getMyApplication($uid);
            if ($success) {
                die(json_encode(array('status' => '1')));
            } else {
                die(json_encode(array('status' => '0')));
            }
        }
        //$this->render("create", array('data' => $data));
    }

    /*
   * 我的快捷应用列表
   */
    public function actionIndexself()
    {
        $data = array();
        $this->render("indexself", array('data' => $data));
    }


}