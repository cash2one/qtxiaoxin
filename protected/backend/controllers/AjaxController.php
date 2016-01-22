<?php
class AjaxController extends Controller
{

    /**
     * 创建公众号手机唯一验证
     * zengp 2014-11-27
     */
    public function actionUniqueaccount()
    {
        $mobile = Yii::app()->request->getParam("mobile");
        $account = Account::getUniqueAccount($mobile);
        $result = array();
        if($account){
            $result['state'] = 1;
        }else{
            $result['state'] = 0;
        }
        echo json_encode($result);
    }

    /**
     * 创建公众号-公众号唯一验证
     * zengp 2014-11-27
     */
    public function actionUniqueofficial()
    {
        $openid = Yii::app()->request->getParam("openid");

        $official = OfficialInfo::getUniqueOfficial($openid);
        $result = array();
        if($official){
            $result['state'] = 1;
        }else{
            $result['state'] = 0;
        }
        echo json_encode($result);
    }

    
    public function actionSubbusiness()
    {
        $bid = Yii::app()->request->getParam("bid");
        $subs = MallBusinessAddress::getByBusinessPk($bid);
        $data = array();
        $result = array('state'=>0);
        foreach($subs as $s){
            $data[] = array('id'=>$s->mbaid,'name'=>$s->name,'phone'=>$s->phone,'address'=>$s->address);
        }
        if(count($data)){
            $result['state'] =1;
            $result['data'] = $data;
        }
        echo json_encode($result);
    }


}