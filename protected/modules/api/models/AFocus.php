<?php

class AFocus extends Focus
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Focus the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 查询符合条件的ContractFocusRange
	 * panrj 2014-06-23
	 * @param array $parms 查询参数
	 * @return queryset $data
	 */
	public static function getUserFocRelations($parms=array())
	{
		$criteria = new CDbCriteria();
		$criteria->compare('sid',$parms['sid']);
		$criteria->compare('gid',$parms['gid']);
		$criteria->scopes='normal';  
		$data = ContractFocusRange::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 返回符合条件的ContractFocusRelation主键集合
	 * panrj 2014-06-23
	 * @param array $parms 查询参数
	 * @return string $pks
	 */
	public static function getUserFocRelationPks($parms=array())
	{
		$data = self::getUserFocRelations($parms);
		$arr = array();
		foreach($data as $d){
			if(!in_array($d->cfrid,$arr))
				array_push($arr,$d->cfrid);
		}
		return implode(',',$arr);
	}


	/**
	 * 查询热点接口数据
	 * panrj 2014-06-23
	 * @param string $pks ContractFocusRelation主键集合
	 * @param array $parms 查询参数
	 * @return queryset $data
	 */
	public static function getAFocResult($pks,$parms=array())
	{
		$date = date('Y-m-d H:i:s',time());
		$criteria = new CDbCriteria();
		if($pks){
			$criteria->addCondition("cid IS NULL OR cfrid IN (".$pks.")");
		}else{
			$criteria->addCondition("cid IS NULL");
		}
		$criteria->compare("startdate","<=".$date);
		if($parms['lastdate']){
			$lastdate = date('Y-m-d H:i:s',$parms['lastdate']);
			if($parms['lastid']){
				//panrj 2014-07-24 去旧数据该为取新数据
				$criteria->addCondition("startdate>'".$lastdate."' OR (startdate='".$lastdate."' AND cfrid>".$parms['lastid'].")");
				// $criteria->addCondition("startdate<'".$lastdate."' OR (startdate='".$lastdate."' AND cfrid<".$parms['lastid'].")");
			}else{
				$criteria->addCondition("startdate<'".$lastdate."'");
			}
		}
		$criteria->compare("enddate",">=".$date);
		$criteria->addCondition("fstate=1 OR cstate=2");
		$criteria->limit=30;
		$data = ViewApiFocusRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 完成投票后添加用户积分
	 * panrj 2014-06-23
	 * @param int $fid 热点主键
	 * @param string $mobile 用户手机号码
	 * @return none
	 */
	public static function addPointAfterVote($fid,$uid)
	{
		$point = PointRelation::getRelationPoint('Focus',$fid);
		$userid = $uid;
		$source = "热点ID:".$fid;
		$comment = "参与问卷调查获取积分".$point."热点ID:".$fid;
		$sql = "CALL fn_Acquire(".$userid.",".$point.",4002,'".$source."','".$comment."')";
		$result = yii::app()->db_credits->createCommand($sql);
        $query = $result->query();
	}
}
