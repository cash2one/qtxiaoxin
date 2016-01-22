<?php

class InfoController extends Controller
{
	public function actionIndex()
	{
		$uid = Yii::app()->request->getParam('Uid');
		$lastid = Yii::app()->request->getParam('Newsid');
		$catid = Yii::app()->request->getParam('Cid');
		$lastdate = Yii::app()->request->getParam('Lastdate');
		$id = Yii::app()->request->getParam('Id');

		$data = array("News"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");

		$parms = array('catid'=>$catid,'uid'=>$uid,'lastdate'=>$lastdate,'lastid'=>$lastid);
		$datas = AInformation::getAInfoResult($parms);
		
		if(count($datas)){
			$data["Result"] = "0";
			$data["Message"] = "操作成功";  
			foreach($datas as $d) {
				if($catid){
					$istop = $d->kindtop?$d->kindtop:0;
				}else{
					$istop = $d->headtop?$d->headtop:0;
				}

				$info = array(
					"Title"=>trim(str_replace('"','\"',$d->title)),
					"Newsid"=>$d->cirid,
					"Desc"=>str_replace('"','\"',$d->summery),
					"Pic"=>count(explode('://',$d->bigimage))==1 ? Yii::app()->request->hostInfo.$d->bigimage : $d->bigimage,
					"Minpic"=>count(explode('://',$d->image))==1 ? Yii::app()->request->hostInfo.$d->image : $d->image,
					"Istop"=>$istop,
					"Url"=> Yii::app()->createAbsoluteUrl('api/info/view/'.$d->cirid).'?Id='.$id.'&Uid='.$uid,
					"Createtime"=>strtotime($d->startdate),
					"Commcount"=>$d->total,
				);
	            array_push($data['News'],$info);
	        }
	    }

        echo JsonHelper::JSON($data);
	}

	public function actionView($id)
	{
		$relation = ContractInfomationRelation::model()->findByPk($id);
		$model = Information::model()->loadByPk($relation->iid);
		$uid = Yii::app()->request->getParam('Uid');
		if($uid){
			ClientLog::addClientLog($uid,'Information',$model->iid,'Browse');
		}
		$this->renderpartial('view',array('model'=>$model,'relation'=>$relation));
	}

	public function actionCategories()
	{
		$cats = InformationKind::getDataArr();
		$data = array("Categories"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		if(count($cats)){
			$data["Result"] = "0";
			$data["Message"] = "操作成功";
			array_push($data['Categories'],array("Cid"=>0,"Cname"=>'头条'));
			foreach($cats as $ck=>$cv){
				$info = array("Cid"=>$ck,"Cname"=>$cv);
				array_push($data['Categories'],$info);
			}  
		}
		echo JsonHelper::JSON($data);
	}

	public function actionSendcomment()
	{
		$uid = Yii::app()->request->getParam('Uid');
		$sendname = Yii::app()->request->getParam('Sendname');
		$newsid = Yii::app()->request->getParam('Newsid');
		$content = Yii::app()->request->getParam('Content');
		$id = Yii::app()->request->getParam('Id');

		if(!$uid){
			JsonHelper::Notify("Commentid","Uid");
		}
		if(!$newsid){
			JsonHelper::Notify("Commentid","Newsid");
		}else{
			$relation = ContractInfomationRelation::model()->findByPk($newsid);
			if(!$relation){
				JsonHelper::Notify("Commentid","Newsid");
			}
			$iid = $relation->iid;
		}

		if(!$content){
			JsonHelper::Notify("Commentid","Content");
		}
		$model = InformationComment::AddComment($uid,$iid,$content);
		$data = array("Commentid"=>"","Result"=>"-6","Message"=>"暂无相关数据");
		if($model && $model->icid){
			$result = $model->icid;
			$data = array("Commentid"=>$result,"Result"=>"0","Message"=>"操作成功");
		}
		echo JsonHelper::JSON($data);
	}

	public function actionGetcomments()
	{
		$uid = Yii::app()->request->getParam('Uid');
		$icid = Yii::app()->request->getParam('Commentid');
		$newsid = Yii::app()->request->getParam('Newsid');
		$id = Yii::app()->request->getParam('Id');
		if(!$newsid){
			JsonHelper::Notify("Comments","Newsid");
		}else{
			$relation = ContractInfomationRelation::model()->findByPk($newsid);
			if(!$relation){
				JsonHelper::Notify("Comments","Newsid");
			}
			$iid = $relation->iid;
		}
		
		$data = array("Comments"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		$result = AInformation::getAInfoComments($parms=array('iid'=>$iid,'icid'=>$icid));
		if(count($result)){
			$data["Result"] = "0";
			$data["Message"] = "操作成功";
			foreach($result as $r){
				$role = $uid;
				$info = array(
					"Commentid"=>$r->icid,
					// "Postname"=>$role?$role->s->name."家长":"老师",
					"Postname"=>$role?"家长":"老师",
					"Createtime"=>strtotime($r->creationtime),
					"Content"=>$r->text,
				);
				array_push($data['Comments'],$info);
			}
		}
		echo JsonHelper::JSON($data);
	}
}