<?php

class ActivityController extends SingleSignController
{

	/**
	 * 圣诞活动初始页
	 * @author panrj,zengp 2014-12-20
	 * @param $uid 用户id
	 */
	public function actionIndex()
	{
		$userid = Yii::app()->request->getParam('uid');
		$timing = strtotime('2015-01-13 00:00:00');
		if(time()>=$timing){
			$url = "http://shop.qtxiaoxin.com/api.aspx?uid=".$userid;
			$this->redirect($url);
		}
		
		$area_pks = Area::getCityAreaArr(1);
		$area_pks = array_keys($area_pks);
		$criteria=new CDbCriteria;
        $criteria->with = array('s');
        $criteria->compare('t.teacher',$userid);
        $criteria->compare('t.deleted',0);
        $criteria->compare('t.state',1);
        $criteria->compare('s.aid',$area_pks);
        $criteria->compare('s.deleted',0);
        $count = SchoolTeacherRelation::model()->count($criteria);

		if($count==0){
			$url = "http://shop.qtxiaoxin.com/api.aspx?uid=".$userid;
			$this->redirect($url);
		}
		$this->renderPartial('index',array('userid'=>$userid));
	}

	/**
	 * 圣诞活动-活动页面
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 */
	public function actionView()
	{
		$ruleid = 17;
		$rule = BeanRule::model()->findByPk($ruleid);
    	$content = json_decode($rule->content,true);
    	$bean = $content['bean'];

		$userid = Yii::app()->request->getParam('Userid');
		$user = Member::model()->findByPk($userid);
		$first_view = BeanAcquire::countBeanAcquire(array('userid'=>$userid,'ruleid'=>$ruleid));
		if($first_view==0){
			$model = new BeanAcquire;
            $model->userid = $userid;
            $model->notedate = date("Y-m-d");
            $model->ruleid = $ruleid;
            $model->number = 1;
            $model->bean = $bean;
            $model->beanfrom = 1;
            $model->isdeal = 1;
            $model->save();
 
            $user->bean += $bean;
            $user->save();
		}

		$latest = MallOrdersGoodsRelation::getPrizeWinRealtions(6);

		$this->renderPartial('view',
			array(
				'userid'=>$userid,
				'firsttime'=>$first_view,
				'user'=>$user,
				'latest'=>$latest,
				'bean'=>$bean,
			)
		);
	}

	/**
	 * 圣诞规则
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 */
	public function actionRule()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$user = Member::model()->findByPk($userid);
		$this->renderPartial('rule',
			array(
				'userid'=>$userid,
				'user'=>$user
			)
		);
	}

	/**
	 * 获奖页面
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 */
	public function actionList()
	{
		$pks = MallOrdersGoodsRelation::getPrizeGoodMsgids();
		$userid = Yii::app()->request->getParam('Userid');
		$user = Member::model()->findByPk($userid);
		$dateArr = array();
		foreach($pks as $pk){
			$records = MallOrdersGoodsRelation::getPrizeWinRealtionByMgid($pk,5);
			if(count($records)){
				// $good = MallGoods::model()->findByPk($pk);				
				$data = array('mgid'=>$pk,'name'=>$records[0]->mg->name,'records'=>$records);
				$dateArr[] = $data;
			}
			
		}
		$this->renderPartial('list',
			array(
				'userid'=>$userid,
				'user'=>$user,
				'datas'=>$dateArr,
			)
		);
	}

	/**
	 * 更多获奖
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 * @param $Mgid 产品id
	 */
	public function actionMorelist()
	{
		
		$userid = Yii::app()->request->getParam('Userid');
		$mgid = Yii::app()->request->getParam('Mgid');
		$user = Member::model()->findByPk($userid);
		$dateArr = array();
		$records = MallOrdersGoodsRelation::getPrizeWinRealtionByMgid($mgid,500);
		if(count($records)){
			$good = MallGoods::model()->findByPk($mgid);
			$data = array('mgid'=>$mgid,'name'=>$good->name,'records'=>$records);
			$dateArr[] = $data;
		}
		$this->renderPartial('morelist',
			array(
				'userid'=>$userid,
				'user'=>$user,
				'datas'=>$dateArr,
			)
		);
	}

	/**
	 * 电影通兑劵详情
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 */
	public function actionMovieinfo()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$user = Member::model()->findByPk($userid);
		$this->renderPartial('movieinfo',
			array(
				'userid'=>$userid,
				'user'=>$user
			)
		);
	}

	/**
	 * 我的奖品
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 */
	public function actionPrize()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$user = Member::model()->findByPk($userid);

		// $prizes = MallOrders::model()->findAllByAttributes(array('userid'=>$userid, 'deleted'=>0));
		$prizes = MallOrdersGoodsRelation::getUserPrizeWinRealtions($userid);
		$results = array();
		foreach ($prizes as $prize) {
			$result = array('name'=>'','time'=>'','address'=>'#','remark'=>'','phone'=>'','type'=>'');
			$good = $prize->mg;
			$goodName = $good['name'];
			$result['name'] = $goodName;
			$result['time'] = date('m-d', strtotime($prize->creationtime));
			if($goodName == '祝福语'){
				$result['remark'] = strip_tags($good->summery);				
				$result['type'] = 1;
			}
			if($goodName == '移动电源' || $goodName == 'IPHONE6'){
				$result['type'] = 2;
				$mo = $prize->mo;
				if(empty($mo->mcaid)){
					$result['address']= Yii::app()->createUrl('api/activity/address',array("Userid"=>$userid,"Mcaid"=>'',"Mogrid"=>$prize['mogrid']));
				}else{
					$result['address']= Yii::app()->createUrl('api/activity/address',array("Userid"=>$userid,"Mcaid"=>$mo->mcaid));
				}
			}
			if($goodName == '电影通兑券'){
				$result['type'] = 3;
				$result['address']= Yii::app()->createUrl('api/activity/movieinfo',array("Userid"=>$userid));
			}

			if($goodName == '10元电话卡'){
				$result['type'] = 4;
				$result['phone'] = $user->mobilephone;
			}
			// $result['morid'] = $prize['mogrid'];
			$results[] = $result;
		}
		$this->renderPartial('prize',
			array(
				'prizes'=>$results,
				'userid'=>$userid,
				'user'=>$user
			)
		);
	}

	/**
	 * 抽奖-ajax
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 */
	public function actiondraw()
	{
		$result = array('state'=>0,'msg'=>'','rid'=>0,'phone'=>'','mogrid'=>'');
		$ruleid = 17;
		$userid = Yii::app()->request->getParam('Userid');
		$user = Member::model()->findByPk($userid);
		$rule_model = BeanRule::model()->findByPk($ruleid);
		$rule = json_decode($rule_model->content,true);
		$bean_need = $rule['bean'];

		if($user->bean < 50){
			$result['state'] = 0;
			$result['msg'] = '亲，青豆不足，赶快了解青豆获取规则，获取青豆再来兑奖吧！';
			echo json_encode($result);exit;
		}

		// $draw_count = MallOrdersGoodsRelation::countPrizeWin($userid);	
		// if($draw_count>=20){
		// 	$result['state'] = 0;
		// 	$result['msg'] = '亲，把机会留一点给别人吧';
		// 	echo json_encode($result);exit;
		// }
		
		$cache = Yii::app()->cache;
		$date = date('Y-m-d');
		$cache_key = 'christmas_prize_mark_'.$date;
		$cache_date = $cache->get($cache_key);
		$relation = false;

		$box_number = Activity::getBoxNumber($userid);
		
		Yii::app()->db->createCommand("LOCK TABLE `tb_activity_config` WRITE")->execute();
		$prizeMarkArr = ActivityConfig::getCurrentPrize($box_number,true);
		if(count($prizeMarkArr)){//抽奖必中情况
			$cache_date = $cache->get($cache_key);
			if($cache_date && $cache_date<time()){
				$mgid = $prizeMarkArr[array_rand($prizeMarkArr)];
				$relation = $this->winning($userid,$mgid,true);
				$cache->set($cache_key,rand(time(),time()+600));
			}else{
				$relation = $this->drawUnsure($userid,$box_number);
			}
			if(!$cache_date){
				$cache->set($cache_key,rand(time(),time()+600));
			}
		}else{//抽奖非必中情况
			$relation = $this->drawUnsure($userid,$box_number);
		}
		// Yii::app()->db->createCommand("UNLOCK TABLES;")->execute();

		$mgood = $relation->mg;
		$result['rid'] = $relation->mogrid;
		$result['mogrid'] = $relation->mogrid;
		$result['phone'] = $user->mobilephone;
		if($mgood->name=='10元电话卡'){
			$result['state'] = 1;
			$result['msg'] = '恭喜你获得10元手机充值卡一张，我们将会在*个工作日内充值到以下手机号，请注意查收。';
		}
		if($mgood->name=='电影通兑券'){
			$result['state'] = 2;
			$result['msg'] = '恭喜你获得电影通兑券一张，我们将会在*个工作日内发送兑换短信到以下手机号，请注意查收。';
		}
		if($mgood->name=='移动电源'){
			$result['state'] = 3;
			$result['msg'] = '恭！喜！你！获得移动电源一个！';
		}
		if($mgood->name=='IPHONE6'){
			$result['state'] = 4;
			$result['msg'] = '恭！喜！你！获得IPHONE 6 手机一台！';
		}
		if($mgood->name=='祝福语'){
			$result['state'] = 5;
			$result['msg'] = '圣诞祝福';
			$result['text'] = $mgood->summery;
		}

		$user->bean = $user->bean - 50;
		$user->save();

		$beanlog = BeanAcquire::getOrCreate($userid,18);
        $beanlog->bean -= 50;
		$beanlog->number +=1;
		$beanlog->save();
		echo json_encode($result);exit;
	}

	/**
	 * 实物中奖填写地址
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 * @param $Mogrid 关系表id
	 * @param $Mcaid 邮寄地址表id
	 */
	public function actionAddress()
	{
		$userid = Yii::app()->request->getParam('Userid');
		$mogrid = Yii::app()->request->getParam('Mogrid');
		$mcaid = Yii::app()->request->getParam('Mcaid');
		if(!empty($mcaid)){
			$address = MallClientAddress::model()->findByPk($mcaid);
		}else{
			$address = '';
		}
		if(isset($_POST['Address']) && $mogrid){
			$mogr = MallOrdersGoodsRelation::model()->findByPk($mogrid);
			//保存地址
			$address = new MallClientAddress;
			// $place = $_POST['Address']['province'].$_POST['Address']['city'].$_POST['Address']['address'];
			// $place = $_POST['Address']['postcode']?$place.'('.$_POST['Address']['postcode'].')':$place;
			$place = $_POST['Address']['address'];
			$address->userid = $userid;
			$address->address = $place;
			$address->contacter = $_POST['Address']['contacter'];
			$address->phone = $_POST['Address']['phone'];
			$address->state = 0;
			$address->save();
			//修改订单邮寄地址
			$order = $mogr->mo;
			$order->mcaid = $address->mcaid;
			$order->save();

			$this->redirect(array('prize','Userid'=>$userid));
		}
		$this->renderPartial('address',array('address'=>$address));
	}

	/**
	 * 中奖处理
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 * @param $mgid 产品id
	 * @param $mark 是否必中
	 */
	public function winning($userid,$mgid,$mark=false)
	{
		Yii::app()->db->createCommand("UNLOCK TABLES;")->execute();
		$good = MallGoods::model()->findByPk($mgid);
		$moid = MallOrders::generalOrderPk($mgid);
		$mark = $mark?1:array(0,2);
		//同步当天奖品数量
		$activity_config = ActivityConfig::model()->findByAttributes(array('date'=>date('Y-m-d'),'mgid'=>$mgid,'type'=>$mark));
		// if(!$activity_config){
		// 	conlog(array('date'=>date('Y-m-d'),'mgid'=>$mgid,'type'=>$mark));
		// }
		$activity_config->deal += 1;
		$activity_config->save();
		//生成订单
		$order = new MallOrders;
		$order->moid = $moid;
		$order->userid = $userid;
		$order->state = 1;
		$order->save();
		//生成商品订单关系
		$relation = new MallOrdersGoodsRelation;
		if($good->type==1){
			$card = MallGoodsCard::getCardByMgid($mgid);

			$card->sold = 1;
			if($card->mg->name=='祝福语'){
				$card->state = 1;
			}
			$card->save();
			$relation->mgcid = $card->mgcid;
		}
		//同步商品库存
		$good->number -= 1;
		$good->save();

		$relation->moid = $moid;
		$relation->mgid = $mgid;
		$relation->score = 0;
		$relation->save();
		// Yii::app()->db->createCommand("UNLOCK TABLES;")->execute();
		return $relation;
	}

	/**
	 * 非必中处理
	 * @author panrj,zengp 2014-12-20
	 * @param $Userid 用户登录ID
	 */
	public function drawUnsure($userid,$box_number)
	{
		$prizeArr = ActivityConfig::getCurrentPrize($box_number);

		if(count($prizeArr)<$box_number){
			$empty_box_num = $box_number-count($prizeArr);
			$wish_prize_pks = ActivityConfig::getWishPrizeMgids();
			for($i=0;$i<$empty_box_num;$i++){
				$prizeArr[] = $wish_prize_pks[array_rand($wish_prize_pks)];
			}
		}else{
			do{
				array_pop($prizeArr);
			}while(count($prizeArr)<=$box_number);
		}
		shuffle($prizeArr);

		$mgid = $prizeArr[array_rand($prizeArr)];
		$relation = $this->winning($userid,$mgid);
		return $relation;
	}
}