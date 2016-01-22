<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class SingleSignController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @var String $action . The current action
	 * 接口单点登录
	*/
	protected function beforeAction($action) {
		
		$route = $this->id . '/' . $action->id;
		$publicPages = array(
            'app/index',
            'user/account',
            'app/servertime',
            'user/sendcode',
            'user/qdreport',
            'user/qdrule',
        );

        if(!in_array($route, $publicPages)){
        	$userid = Yii::app()->request->getParam('Userid');
        	$guid = Yii::app()->request->getParam('Guid');
			if($guid && $userid){
				$single = SingleSign::model()->findByPk($userid);
				if(!$single){
					$data = array("Result"=>"-24","Message"=>"用户未登录");
					echo JsonHelper::JSON($data);
					exit;
				}
				if($single->guid!=$guid){
					$data = array("Result"=>"-99","Message"=>"您的账号已在其它地方登录");
					echo JsonHelper::JSON($data);
					exit;
				}
			}
			
        }

    	return parent::beforeAction($action);
    }
}