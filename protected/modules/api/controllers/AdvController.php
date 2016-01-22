<?php

class AdvController extends Controller
{
	public function actionIndex()
	{
		$alids = Yii::app()->request->getParam('Adids');
		$uid = Yii::app()->request->getParam('Uid');
		if(!$alids){
			JsonHelper::Notify("Ads","Adids");
		}
		$alids = explode(",",$alids);

		
		$msgr = UserSchoolGradeRelation::getByUserId($uid);
		$sid = $msgr?$msgr->sid:0;
		$gid = $msgr?$msgr->gid:0;
		
		$data = array("Ads"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		
		// $sid = 1287;
		// $gid = 14;
		foreach($alids as $alid){
			$parms = array("alid"=>$alid,'sid'=>$sid,'gid'=>$gid,"uid"=>$uid);
			$result = AAdvertisement::getBuniessAdv($parms);
			if($result)
				array_push($data['Ads'],$result);
		}
		
		if(count($data['Ads'])){
			$data["Result"] = "0";
			$data["Message"] = "操作成功";
		}
        echo JsonHelper::JSON($data);
	}

	public function actionView($id)
	{
		$model = Advertisement::model()->loadByPk($id);
		$uid = Yii::app()->request->getParam('Uid');
		if($uid){
			ClientLog::addClientLog($uid,'Advertisement',$id,'Browse');
		}
		if($model->url){
			 $this->redirect($model->url);
		}
		$this->renderpartial('view',
			array(
				'model'=>$model,
			)
		);
	}
}