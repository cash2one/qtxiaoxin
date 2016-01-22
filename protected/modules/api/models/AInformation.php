<?php

class AInformation extends Information
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
	 * 查询资讯接口数据
	 * panrj 2014-06-23
	 * @param array $parms 查询参数
	 * @return queryset $data
	 */
	public static function getAInfoResult($parms=array())
	{
		$date = date('Y-m-d H:i:s',time());
		$criteria = new CDbCriteria();
		if($parms['catid']){
			$criteria->compare('ikid',$parms['catid']);
			if($parms['lastid']){
				$criteria->compare('kindtop',0);
			}
		}else{
			$criteria->compare('head',1);
			if($parms['lastid']){
				$criteria->compare('headtop',0);
			}
		}
		$criteria->compare("startdate","<=".$date);
		if($parms['lastdate']){
			$lastdate = date('Y-m-d H:i:s',$parms['lastdate']);
			if($parms['lastid']){
				$criteria->addCondition("startdate<'".$lastdate."' OR (startdate='".$lastdate."' AND cirid<".$parms['lastid'].")");
			}else{
				$criteria->addCondition("startdate<'".$lastdate."'");
			}
		}
		$criteria->addCondition("istate=1 OR cstate=2");
		if($parms['catid']){
			$criteria->order = 'kindtop DESC, startdate DESC,cirid DESC'; 
		}else{
			$criteria->order = 'headtop DESC,startdate DESC,cirid DESC'; 
		}
		 
		$criteria->limit=10;
		$data = ViewApiInfomrationRelation::model()->findAll($criteria);
		return $data;
	}

	public static function getAInfoComments($parms=array())
	{
		$criteria = new CDbCriteria();
		$criteria->compare('iid',$parms['iid']);
		if($parms['icid']){
			$criteria->compare('icid','<'.$parms['icid']);
		}
		$criteria->order = 'icid DESC';
		$criteria->limit=20;
		$data = InformationComment::model()->findAll($criteria);
		return $data;
	}
}
