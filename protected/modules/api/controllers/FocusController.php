<?php

class FocusController extends Controller
{
	
	public function actionIndex()
	{
		$id = Yii::app()->request->getParam('Id');
		$uid = Yii::app()->request->getParam('Uid');
		$lastdate = Yii::app()->request->getParam('Lastdate');
		$lastid = Yii::app()->request->getParam('Activityid');

		$msgr = UserSchoolGradeRelation::getByUserId($uid);
		$sid = $msgr?$msgr->sid:0;
		$gid = $msgr?$msgr->gid:0;
		
		$data = array("Activitys"=>array(),"Result"=>"-6","Message"=>"暂无相关数据");
		$parms = array('lastdate'=>$lastdate,'sid'=>$sid,'gid'=>$gid,'lastid'=>$lastid);
		$rids = AFocus::getUserFocRelationPks($parms);
		$datas = AFocus::getAFocResult($rids,$parms);
		
		if(count($datas)){
			$data["Result"] = "0";
			$data["Message"] = "操作成功";  
			foreach($datas as $d) {
				$url = '';
				if($d->type==0){
					$url = Yii::app()->createAbsoluteUrl('api/focus/new/'.$d->cfrid).'?Id='.$id.'&Uid='.$uid;
				}
				if($d->type==1){
					$url = Yii::app()->createAbsoluteUrl('api/focus/vote/'.$d->cfrid).'?Id='.$id.'&Uid='.$uid;
				}
				if($d->type==2){
					$url = $d->url.'?Id='.$id.'&Uid='.$uid;
				}
				$bfoc = array(
					"Title"=>str_replace('"','\"',$d->title),
					"ActivityId"=>$d->cfrid,
					"Summary"=>str_replace('"','\"',$d->summery),
					"BigPic"=>$d->image ? Yii::app()->request->hostInfo.$d->image : $d->image,
					"Url"=>$url,
					"CreateDate"=>strtotime($d->ctime),
					"StartTime"=>strtotime($d->startdate),
					"EndTime"=>strtotime($d->enddate),
				);
	            array_push($data['Activitys'],$bfoc);
	        }
	    }

        echo JsonHelper::JSON($data);
	}

	public function actionNew($id)
	{
		$relation = ContractFocusRelation::model()->findByPk($id);
		$model = Focus::model()->loadByPk($relation->fid);
		$uid = Yii::app()->request->getParam('Uid');
		if($uid){
			ClientLog::addClientLog($uid,'Focus',$model->fid,'Browse');
		}
		$this->renderpartial('new',array('model'=>$model,'relation'=>$relation));
	}

	public function actionVote($id)
	{
		$relation = ContractFocusRelation::model()->findByPk($id);
		$model = Focus::model()->loadByPk($relation->fid);
		$uid = Yii::app()->request->getParam('Uid');
		if($uid){
			ClientLog::addClientLog($uid,'Focus',$model->fid,'Browse');
		}
		//用户有无投票记录
		$count = FocusAnswer::countUserVote($relation->fid,$uid);
		if($count){
			$this->redirect(Yii::app()->createUrl('api/focus/result/'.$id).'?Uid='.$uid);
		}else{
			if(isset($_POST['Vote'])){
				$res = $_POST['Vote'];
				// conlog($res);
				$items = isset($res['item'])?$res['item']:array();
				$answers = isset($res['answer'])?$res['answer']:array();
				if(count($items)){
					foreach($items as $tid){
						if(is_array($tid)){
							foreach($tid as $stid){
								FocusAnswer::setFocusVoteItem($stid,$uid);
							}
						}else{
							FocusAnswer::setFocusVoteItem($tid,$uid);
						}
					}
				}
				if(count($answers)){
					foreach($answers as $answer){
						$qid = $answer['qid'];
						$text = $answer['text'];
						FocusAnswer::setFocusVoteAnswer($qid,$uid,$text);
					}
				}

				if(count($items) || count($answers)){
					$model->total += 1;
					$model->save();
					ClientLog::addClientLog($uid,'Focus',$model->fid,'Join');

					AFocus::addPointAfterVote($model->fid,$uid);
				}
				$this->redirect(Yii::app()->createUrl('api/focus/result/'.$id).'?Uid='.$uid);
			}
			// ClientLog::addClientLog($uid,'Focus',$model->fid,'Browse');
			$this->renderpartial('vote',array('model'=>$model,'relation'=>$relation));
		}
	}

	public function actionResult($id)
	{
		$relation = ContractFocusRelation::model()->findByPk($id);
		$model = Focus::model()->loadByPk($relation->fid);
		$uid = Yii::app()->request->getParam('Uid');
		$this->renderpartial('result',array('model'=>$model,'relation'=>$relation,'uid'=>$uid));
	}

	public function actionReplay($id)
	{	
		$model = FocusQuestion::model()->findByPk($id);
		$data = FocusAnswer::getQuestionAnswerReplaies(array('fqid'=>$model->fqid,'size'=>50));
		$this->renderpartial('replay',array('model'=>$model,'data'=>$data));
	}
}