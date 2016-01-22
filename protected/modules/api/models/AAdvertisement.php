<?php
class AAdvertisement extends Advertisement
{
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Advertisement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 查询符合条件的ContractAdvertisementRelation
	 * panrj 2014-06-23
	 * @param array $parms 查询参数
	 * @return queryset $data
	 */
	public static function getConAdvRelations($parms=array())
	{
		$date = date('Y-m-d',time()).' 00:00:00';
		$criteria = new CDbCriteria();
		$criteria->compare('alid',$parms['alid']);
		$criteria->compare("startdate","<=".$date);
		$criteria->compare("enddate",">=".$date);
		$criteria->scopes='normal';  
		$criteria->order = 'startdate';
		$data = ContractAdvertisementRelation::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 查询符合条件的ContractAdvertisementRange
	 * panrj 2014-06-23
	 * @param array $parms 查询参数
	 * @return queryset $data
	 */
	public static function getConAdvRanges($carid,$parms=array())
	{
		$date = date('Y-m-d',time()).' 00:00:00';
		$criteria = new CDbCriteria();
		$criteria->compare('carid',$carid);
		$criteria->compare("startdate","<=".$date);
		$criteria->compare("enddate",">=".$date);
		$criteria->compare('sid',$parms['sid']);
		$criteria->compare('gid',$parms['gid']);
		$criteria->scopes='normal';  
		$criteria->order = 'startdate';
		$data = ContractAdvertisementRange::model()->findAll($criteria);
		return $data;
	}

	/**
	 * 查询广告接口数据
	 * panrj 2014-06-23
	 * @param array $parms 查询参数
	 * @return array $arr
	 */
	public static function getBuniessAdv($parms=array())
	{
		//返回合同广告数据
		$relations = self::getConAdvRelations($parms);
		if(count($relations)){
			foreach($relations as $r){
				$contract = $r->c;
				if($contract->state == 2){
					$ranges = self::getConAdvRanges($r->carid,$parms);
					if(count($ranges)){
						$adv = $r->a;
						$arr = array(
							"Title"=>str_replace('"','\"',$adv->title),
							"Position"=>$r->alid,
							"Image"=>$adv->image ? Yii::app()->request->hostInfo.$adv->image : '',
							"Url"=> Yii::app()->createAbsoluteUrl('api/adv/view/'.$adv->aid).'?Uid='.$parms['uid'],
							"Remark"=>str_replace('"','\"',$adv->summery),
						);
						return $arr;
					}	
				}
			}
		}
		//返回开放广告数据
		return self::getPublicAdv($parms['alid'],$parms['uid']);
	}

	/**
	 * 查询符合条件的开放广告
	 * panrj 2014-06-23
	 * @param int $alid 广告位主键
	 * @param string $mobile 用户手机号码
	 * @return array $arr
	 */
	public static function getPublicAdv($alid,$uid)
	{
		$criteria=new CDbCriteria;
		$criteria->addCondition("bid IS NULL");
		$criteria->compare('state',1);
		$criteria->scopes='normal';
		$adv=self::model()->find($criteria);
		$arr = array();
		if($adv){
			$arr = array(
				"Title"=>str_replace('"','\"',$adv->title),
				"Position"=>$alid,
				"Image"=>$adv->image ? Yii::app()->request->hostInfo.$adv->image : '',
				"Url"=>Yii::app()->createAbsoluteUrl('api/adv/view/'.$adv->aid).'?Uid='.$uid,
				"Remark"=>str_replace('"','\"',$adv->summery),
			);
		}
		return $arr;
	}
}
