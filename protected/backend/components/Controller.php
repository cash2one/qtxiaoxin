<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends SBaseController
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
	 * @var string 本次请求url
	 */
	public $currenturl='';

	/**
	 * @var string 上次请求url
	 */
	public $previousurl='';

	public function getIsAjaxRequest()
	{
		$ajax = false;
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
		{
		  $ajax = true;
		}
		return $ajax;
	}

	/**
	 * @var String $action . The current action
	 * 初始化控制器的本次及上次请求url
	*/
	protected function beforeAction($action) {
		//旧平台后台停用，启用新平台后台
		$this->redirect(NEW_PLATFORM_DOMAIN.'/admin.php');

		$ajax = $this->getIsAjaxRequest();
		if(!$ajax){
			$current = $_SERVER["REQUEST_URI"];
			$a = explode('?',Yii::app()->session['currenturl']);
			$b = explode('?',$current);
	    	if($a[0] != $b[0])
	    		Yii::app()->session['previousurl'] = Yii::app()->session['currenturl'];
	    	Yii::app()->session['currenturl'] = $current;
	    	$this->previousurl = Yii::app()->session['previousurl'] ? Yii::app()->session['previousurl'] : '';
	    	$this->currenturl = $current;
		}
    	return parent::beforeAction($action);
    }
	
}