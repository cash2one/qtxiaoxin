<?php

class ParentController extends Controller
{
	public function actionIndex()
	{
		$this->renderpartial('index');
	}

	public function actionFoodmenu()
	{
		$id = Yii::app()->request->getParam('uid');
		$sid = Yii::app()->request->getParam('sid');
		$year = Yii::app()->request->getParam('year','');
		$week = Yii::app()->request->getParam('week','');
		$year = $year!=''?$year:date('Y');
		$week = $week!=''?$week:MainHelper::getWeekNow();

		if ($week == 0) {
            $year = $year - 1;
            $week = MainHelper::getWeeks($year);    //如果向左翻页到第0周就获取上一年的最大周
        } else if ($week > MainHelper::getWeeks($year)) { //如果大于
            $week = 1;
            $year = $year + 1;   //如果向右翻页到比当年的最大周还大了就获取下一年的第一周
        }

		$childs = Guardian::getChilds($id);
		$childPks = array();
		foreach($childs as $item){
			$childPks[] = $item->child;
		}
		$childPks = count($childPks)?$childPks:'0';
		$relations = ClassStudentRelation::getStudentClass($childPks);

		$schools = array();
		$schoolPks = array();
		foreach($relations as $r){
			if(!in_array($r->c->sid, $schoolPks)){
				$schoolPks[] = $r->c->sid;
				$schools[] = $r->c->s;
			}
		}
		if(count($schools)){
			$sid = $sid?$sid:$schools[0]->sid;
			$school = School::model()->findByPk($sid);
			$menu = Foodmenu::getFoodContent(array('sid'=>$sid,'week'=>$week,'year'=>$year));
			$new_content = array();
			if($menu){
				$content = json_decode($menu->content,true);
				$new_content = array();
				foreach($content as $k=>$v){
					$new_content[] = array('day'=>$k,'text'=>$v);
				}
			}
			$new_content = MainHelper::array_subkey_sort($new_content, 'day', $type='asc');
		}else{
			$school = null;
			$new_content = array();
			$menu = '';
		}
		$startend = MainHelper::getWeekDate($year, $week);
		$this->renderpartial('foodmenu',
			array(
				'schools'=>$schools,
				'menu'=>$menu,
				'school'=>$school,
				'week'=>$week,
				'year'=>$year,
				'startend'=>$startend,
				'weekmenu'=>$new_content,
				'uid'=>$id,
			));
	}

	public function actionSchools($id)
	{
		$year = Yii::app()->request->getParam('year');
		$week = Yii::app()->request->getParam('week');
		$year = $year?$year:date('Y');
		$week = $week?$week:Mainhelper::getWeekNow();

		$childs = Guardian::getChilds($id);
		$childPks = array();
		foreach($childs as $item){
			$childPks[] = $item->child;
		}
		$relations = ClassStudentRelation::getStudentClass($childPks);
		$schools = array();
		$schoolPks = array();
		foreach($relations as $r){
			if(!in_array($r->c->sid, $schoolPks)){
				$schoolPks[] = $r->c->sid;
				$schools[] = $r->c->s;
			}
		}
		$this->renderpartial('schools',
			array(
				'schools'=>$schools,
				'uid'=>$id,
				'week'=>$week,
				'year'=>$year,
			));
	}
}