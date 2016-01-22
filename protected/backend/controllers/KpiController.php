<?php

class KpiController extends Controller
{
	public function actionIndex()
	{
	    $requst = Yii::app()->request;
	    $search = $requst->getParam( 'search' );

        if (!isset(Yii::app()->user->id))
            $this->redirect(Yii::app()->createUrl('/site/login'));

	    $workLimit = WorkLimit::model()->findAll( 'deleted = 0 AND userid =' . Yii::app()->user->id);
	    
	    $limitData = array();
	    
	    foreach ( $workLimit as $v ) {
	        if( is_object( $v ) ){
	            $limitData[] = $v->onuserid;
	        }
	    }

	    if ( true == $requst->getParam( 'submit-flag' ) ){

	        $result = Work::model()->saveUser( $requst->getParam('score'), $requst->getParam('rowids') );

	        if (true == $result && false == Work::model()->hasErrors()) {
                Yii::app()->msg->postMsg('success', '发布成功!');
            } else {
                $msg = Work::model()->getErrorMsg();
                $msg = true == $msg ? $msg  : '数据保存失败！';
                Yii::app()->msg->postMsg('failed', $msg);
            }

 	        $this->redirect(Yii::app()->createUrl('/kpi/index'));
	        Yii::app()->end();
	    }

        $config = WorkParam::model()->find('userid = :userid AND deleted = 0', array(':userid' => Yii::app()->user->id));

        $maxlimit = $config === null ?  0 : $config->maxlimit;

        $this->render('index', array(
            'users' => true == $limitData?Work::model()->getUserList($search, $limitData ): array('models'=>array(),'pages'=>array() ),
            'cusers' => Work::model()->getSelfChangeUser(0, $limitData),
            'config' => $config
            )
        );
	}

    public function actionRanking()
    {
        $param = array();
        $month = trim(Yii::app()->request->getParam('month'));
        
        if (isset($month) && $month != '') {
            $param['month'] = $month;
        }
        
        if( true == trim(Yii::app()->request->getParam('cvs')) ){
            $this->exportRanking( Work::model()->getRankingList($param), $month  );
            Yii::app()->end();
        }
        
        $this->render('ranking', array (
            'users' => Work::model()->getRankingList($param),
            'param' => $param
            )
        );
    }

    public function actionLog()
    {
        $request = Yii::app()->request;
        $this->render('log', array( 'users'=> Work::model()
                                        ->getLogUserList( $request->getParam('search')
                                            , $request->getParam('type'), $request->getParam('yearMonth') ) ));
    }

    public function actionBatchupdate()
    {
        if (!Yii::app()->request->isPostRequest) {
            Yii::app()->msg->postMsg("请使用Post提交");
            $this->redirect("index");
        }

        $config = Yii::app()->request->getParam('config');

        if ($config['minlimit'] == '' || $config['maxlimit'] == '') {
            Yii::app()->msg->postMsg("failed", "考核配置信息不能为空!");
            $this->redirect('configure');
        }

        $condition = 'deleted = '. WorkParam::CONFIG_NOT_DELETED;

        if ($config['uids'] != '') {
            $condition .= ' AND userid in ('. $config['uids'] .')';
        }

        $config['orgscore'] = 80;
        $updatetime = date("Y-m-d H:i:s");
        $workParam = new WorkParam();
        $result = $workParam->updateAll(
            array(
                'orgscore' => $config['orgscore'],
                'minlimit' => (int)$config['minlimit'],
                'maxlimit' => (int)$config['maxlimit'],
                'updatetime' => $updatetime,
            ),
            $condition
        );
        if ($result) {
            $work = new Work();
            if ($config['uids'] != '')
                $work->deleteRecordByIds($config['uids']);
            else
                $work->deleteRecordByIds();

            Yii::app()->msg->postMsg("success", "修改成功!");
            $this->redirect('configure');
        } else {
            Yii::app()->msg->postMsg("failed", "修改失败!");
            $this->redirect('configure');
        }
    }


    public function actionScorelimit()
    {
        if (Yii::app()->request->isPostRequest) {

            $this->limitset();

            $redirecturl = Yii::app()->createUrl('kpi/scorelimit');
            $this->redirect($redirecturl);
            Yii::app()->end();
        }

        $workParam = new User();
        $data = $workParam->getUserConfigs();

        $this->render('scorelimit', array (
                "user" => $data['model'],
                "type" => 1
            )
        );
    }

    public function actionConfigure()
    {
        $workParam = new User();
        $data = $workParam->getUserConfigs();

        foreach ($data['model'] as $row) {
            if ($row->configs === null) {
                $workParam = new WorkParam();
                $workParam->newConfig((int)$row->uid);
            }
        }

        $this->render('configure', array('model' => $data['model'], 'pages' => $data['pages'], 'pagerConfig' => $data['pagerConfig']));
    }

    public function actionConfig($id)
    {
        $workParam = new WorkParam();

        if (Yii::app()->request->isPostRequest) {
            $config = Yii::app()->request->getParam("config");
            $result = $workParam->updateConfig($id, $config);
            $redirecturl = Yii::app()->createUrl('kpi/index') ."/". $id;
            if ($result === true) {
                Yii::app()->msg->postMsg('success', '修改成功!');
                $this->redirect($redirecturl);
            } else if (is_array($result) && !empty($result)) {
                $error = array_shift($result);
                is_array($error) && !empty($error) ? $error = $error[0] : $error = '未知错误!';
                Yii::app()->msg->postMsg('falied', $error);
                $this->redirect($redirecturl);
            } else {
                Yii::app()->msg->postMsg('falied', '未知错误');
                $this->redirect($redirecturl);
            }
        }

        $data = $workParam->getConfig((int)$id);

        if ($data['code'] === 0) {
            Yii::app()->msg->postMsg('failed', $data['msg']);
            $redirecturl = Yii::app()->createUrl('kpi/index');
            $this->redirect($redirecturl);
        }

        $this->render('config', array('model' => $data['config'], 'user' => $data['user']));
    }

    protected function exportRanking( $models, $month )
    {
        $fileName = $month.'绩效排行榜';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
        header('Cache-Control: max-age=0');
        $fp= fopen('php://output', 'a');
        //Windows下使用BOM来标记文本文件的编码方式
        fwrite($fp,chr(0xEF).chr(0xBB).chr(0xBF));
        $head = array('排名', '姓名', '平均分', '被评次数');
        fputcsv($fp, $head );
        foreach ( $models['models'] as $k => $v ){
            $row = array();
            $row[] = $k +1;
            $row[] = isset($v['user']['name'])?$v['user']['name']:'';
            $row[] = isset($v['score'])?round($v['score'],2):'';
            $row[] = isset($v['fromuserid'])?$v['fromuserid']:'';
            
            fputcsv($fp, $row );
        }
        
        ob_flush();
        flush();
    }

    public function actionGetselected()
    {
        if (!Yii::app()->request->isPostRequest) exit;
        $uid = $_POST['uid'];
        $data = WorkLimit::model()->findAll("userid =" . $uid . " AND deleted = 0");
        $string = "";
        foreach ($data as $row) {
            $string .= $row['onuserid'] . ",";
        }
        $string = substr($string, 0 , -1);
        exit($string);
    }
    
    public function actionGetmore()
    {
        $workParam = new WorkParam();
        $data = $workParam->getUserList();
        $arr = array();
        foreach ($data['model'] as $k => $v) {
            $tmp['score'] = $v->orgscore;
            $tmp['max'] = $v->maxlimit;
            $tmp['min'] = $v->minlimit;
            $tmp['userid'] = $v->userid;
            $tmp['name'] = $v->u->name;
            $arr[] = $tmp;
        }
        echo json_encode($arr);
        exit;
    }
    
    /**
     * 对提交的用户id限制作保存处理,
     * 执行完毕后跳转回原提交处，并提示完毕
     */
    protected function limitset()
    {
        $requst = Yii::app()->request;
        
        $data = (array)$requst->getParam( 'duallistbox_demo1' );
        
        $userid = (int)$requst->getParam( 'userid' );;
    
        $data = array_filter( $data );
    
        $ids = join( '\',\'', $data );
        
        $rows = WorkLimit::model()->findAll( 'userid ='.$userid );
        
        $allData = array_map(function($v){
            if( true == is_object( $v ) ){
                return $v->onuserid;
            }
            
            return false;
        }, $rows);

        $uidData = array_diff( $allData, $data );   // 取 数据行中不是选择的逻辑删除
        
        if( true == $uidData ){
            $uids = join( '\',\'', $uidData );
        
            WorkLimit::model()->updateAll( array('deleted'=>1), 'onuserid IN(\''.$uids.'\') AND userid='.$userid ); //逻辑删除，不需要限制的用户id
        }
        
        $intersectData = array_intersect( $data, $allData);     // 取数据行中已选择的把逻辑删除全部恢复
        
        if( true == $intersectData ){
            $intersectIds = join( '\',\'', $intersectData );
            
            WorkLimit::model()->updateAll( array('deleted'=>0), 'onuserid IN(\''.$intersectIds.'\') AND userid='.$userid ); // 前端已选择的数据行中逻辑删除恢复
        }
        
        $diffData = array_diff(  $data, $allData ); // 取 数据行中不存在的插入
        $diffData = array_filter( $diffData );

        if( true == $diffData ){
            foreach ( $diffData as $v ){
                $workLimit = new WorkLimit();
                $workLimit->onuserid = (int)$v;
                $workLimit->userid = $userid;
                $workLimit->insert();
            }
        }
        
        $logicDelCriteria = new CDbCriteria();
        $logicDelCriteria->addCondition( 'fromuserid = '.$userid );
        $logicDelCriteria->addNotInCondition( 'userid', $data );
         
        Work::model()->updateAll( array('deleted'=>Work::WORK_DELETED_YES ), $logicDelCriteria ); // 逻辑删除非指定已打分的用户评分记录
        
        Yii::app()->msg->postMsg('success', '保存完毕!');
    }
}