<?php

class OfficialController extends Controller
{

	/**
	 * 公众号管理
	 * @author panrj,zengp 2014-11-27
	 */
	public function actionIndex()
	{
		$query = isset($_GET['OfficialInfo']) ? $_GET['OfficialInfo'] : array();
		$data = OfficialInfo::model()->pageData($query);
		$model = new OfficialInfo;
        $this->render('index',array('data'=>$data,'OfficialInfo'=>$query,'model'=>$model));
	}

	/**
	 * 添加账号
	 * @author panrj,zengp 2014-11-26
	 */
	public function actionCreate()
	{
		$account = new Account;
		$official = new OfficialInfo;

		if(isset($_POST['Account']) && isset($_POST['OfficialInfo'])){
            $_POST['OfficialInfo']['logo'] = STORAGE_QINNIU_XIAOXIN_TX.$_POST['OfficialInfo']['logo'];
			$password = MainHelper::generate_code(6);
            $account->pwd = MainHelper::encryPassword($password);
			$account->attributes=$_POST['Account'];
			$official->attributes=$_POST['OfficialInfo'];
			// $official->save();
			// conlog($official->errors);
			if($official->save()){
				$account->infoid = $official->infoid;
				$account->save();
				$msgContent = SITE_NAME.'公众号创建成功。公众号名称：'.$official->openname.'，ID号：'.$official->openid.'，初始密码：'.$password.'，自助管理后台地址：'.OFFICIAL_URL;
				UCQuery::sendMobileMsg($account->mobile, $msgContent);
				Yii::app()->msg->postMsg('success', '创建成功');
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'account'=>$account,
			'official'=>$official,
		));
	}

	/**
	 * 添加账号
	 * @author panrj,zengp 2014-11-26
	 * @param $id 公众号id
	 */
	public function actionUpdate($id)
	{
		$official = OfficialInfo::model()->LoadByPk($id);
		$account = OfficialInfo::getOfficialAccount($id);
		if(isset($_POST['Account']) && isset($_POST['OfficialInfo'])){
            if (strpos($_POST['OfficialInfo']['logo'], STORAGE_QINNIU_XIAOXIN_TX) === false) {
                $_POST['OfficialInfo']['logo'] = STORAGE_QINNIU_XIAOXIN_TX.$_POST['OfficialInfo']['logo'];
            } else {
                $_POST['OfficialInfo']['logo'] = $_POST['OfficialInfo']['logo'];
            }
			$account->attributes=$_POST['Account'];
			$official->attributes=$_POST['OfficialInfo'];
			if($official->save()){
				$account->save();
				Yii::app()->msg->postMsg('success', '操作成功');
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'account'=>$account,
			'official'=>$official,
		));
	}

	/**
	 * 重置密码
	 * @author panrj,zengp 2014-11-27
	 * @param $id 公众号id
	 */
	public function actionResetpwd($id)
	{
		$official = OfficialInfo::model()->LoadByPk($id);
		$account = OfficialInfo::getOfficialAccount($id);
		$password = MainHelper::generate_code(6);

		//$result = array('state'=>0,'name'=>$official->openname,'mobile'=>$account->mobile);
        $account->pwd = MainHelper::encryPassword($password);      
        if($account->save()){
        	$msgContent = SITE_NAME.'公众号重置密码成功。公众号名称：'.$official->openname.'，ID号：'.$official->openid.'，密码：'.$password.'，自助管理后台地址：'.OFFICIAL_URL;
        	UCQuery::sendMobileMsg($account->mobile, $msgContent);
        	Yii::app()->msg->postMsg('success', '密码已发送到手机:'.$account->mobile);
        	$this->redirect(array('index'));
        	//$result['state'] = 1;
        }
        //echo json_encode($result);
	}

	/**
	 * 删除公众号&登录账号
	 * @author panrj,zengp 2014-11-27
	 * @param $id 公众号id
	 */
	public function actionDelete($id)
	{

		$model=OfficialInfo::model()->loadByPk($id);
        $model->deleteMark();
        $result = Account::deleteByInfoId($id);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			Yii::app()->msg->postMsg('success', '操作成功');
			$this->redirect(array('index'));
	}

	/**
	 * 封号/解封
	 * @author panrj,zengp 2014-11-27
	 * @param $id 公众号id
	 */
	public function actionSetblock($id)
	{
		$reason = Yii::app()->request->getParam('reason');
		$result = OfficialInfo::setBlock($id,$reason);
		echo $result;
	}

	/**
	 * 消息管理
	 * @author panrj,zengp 2014-11-28
	 */
	public function actionMessage(){

		$query = isset($_GET['Message']) ? $_GET['Message'] : array();
		$data = Message::model()->pageData($query);
		$model = new Message;
        $this->render('message',array('data'=>$data,'Message'=>$query,'model'=>$model));

	}

	/**
	 * 封贴/解封
	 * @author panrj,zengp 2014-11-28
	 */
	public function actionMsglock($id){

		$reason = Yii::app()->request->getParam('reason');
		$result = Message::msgLock($id,$reason);
		echo $result;
	}

	/**
	 * 粉丝管理
	 * @author panrj,zengp 2014-11-28
	 */
	public function actionFans(){	
		echo 'Fans';
	}

	/**
	 * 数据统计
	 * @author panrj,zengp 2014-11-28
	 */
	public function actionDatastat(){	
		echo 'Datastat';
	}
}