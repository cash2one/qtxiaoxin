<?php
/**
* @author panrj 2014-08-16
* 校信管理菜单配置文件
*/
class XiaoxinMenu
{
	/**
	* @author panrj 2014-08-16 
	* 返回应用对应子菜单配置数组
	*/
	public static function appTip($key='')
	{
		$arr = array(
			'1'=>array('code'=>'homework','ico'=>'pIco1',),//布置作业
			'2'=>array('code'=>'noticeparent','ico'=>'pIco2',),//通知家长
			'3'=>array('code'=>'noticeteacher','ico'=>'pIco3',),//通知老师
			'4'=>array('code'=>'conduct','ico'=>'pIco4',),//点评学生
			'5'=>array('code'=>'eduinfo','ico'=>'pIco5',),//教育资讯
			'6'=>array('code'=>'schedule','ico'=>'pIco6',),//课程表
			'7'=>array('code'=>'foodmenu','ico'=>'pIco7',),//餐单管理
			'8'=>array('code'=>'newmenu','ico'=>'pIco8',),//新菜单
			'9'=>array('code'=>'emergency','ico'=>'pIco9',),//紧急通知
			'10'=>array('code'=>'mall','ico'=>'pIco10',),//蜻豆商城
			'11'=>array('code'=>'classnotice','ico'=>'pIco11',),//班级通知
			'12'=>array('code'=>'schoolnotice','ico'=>'pIco12',),//学校通知
			'13'=>array('code'=>'score','ico'=>'pIco13',),//成绩管理
			'14'=>array('code'=>'mybaby','ico'=>'pIco14',),//我的宝贝
			'15'=>array('code'=>'usergroup','ico'=>'pIco15',),//自定义分组
			'16'=>array('code'=>'approvelist','ico'=>'pIco16',),//消息审核
            '17'=>array('code'=>'phonebook','ico'=>'pIco17',),//花名册
            '19'=>array('code'=>'monitoring','ico'=>'pIco19',),//老师消息监管 
            '20'=>array('code'=>'sign','ico'=>'pIco20',),//自定义签名
            '21'=>array('code'=>'teacherconfig','ico'=>'pIco21',),//定向发送设置
            '22'=>array('code'=>'directsend','ico'=>'pIco22',),//定向发送设置
		);
		if($key){
			return isset($arr[$key])?$arr[$key]:'';
		}
		return $arr;
	}

	/**
	* @author panrj 2014-08-16 
	* 返回应用对应子菜单配置数组
	*/
	public static function appTipCode($key)
	{
		$arr = self::appTip($key);
		return isset($arr['code'])?$arr['code']:'';
	}

	/**
	* @author panrj 2014-08-16 
	* 返回点亮应用编码
	*/
	public static function appTipCodeArr($keys)
	{
		$codeArr = array();
		foreach($keys as $key){
			array_push($codeArr,self::appTipCode($key));
		}
		return $codeArr;
	}

	/**
	* @author panrj 2014-08-16 
	* 返回应用对应子菜单配置数组
	*/
	public static function appTipIco($key)
	{
		$arr = self::appTip($key);
		return isset($arr['ico'])?$arr['ico']:'';
	}

	/**
	* @author panrj 2014-08-16 
	* 返回顶级菜单配置数组
	*/
	public static function top()
	{
		$arr = array(
			//校信首页
			'home' => array('home',),
			//日常工作
			'daily' => array('dailylist','homework','noticeparent','noticeteacher','conduct','eduinfo','schedule','foodmenu','newmenu','emergency','mall','classnotice','schoolnotice','score','mybaby','usergroup','approvelist','phonebook','monitoring','sign','teacherconfig','directsend'),
			//我的班级
			'myclass' => array('myclass',),
			//消息中心
			'notices' => array('noticecenter',),
			'mybaby' => array('baby',),
		);
		return $arr;
	}

	/**
	* @author panrj 2014-05-21 
	* 返回子菜单配置数组
	*/
	public static function sub()
	{
		$arr = array(
		//日常工作(按照appTip中的配置取键值)--------------------------------------------------------------
			//布置作业
			'homework' => array(
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'homework','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'unsendlist','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'sendlist','name'=>'','ico'=>'',
				),
			),
             
			//通知家长
			'noticeparent'=>array(
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'noticefamily','name'=>'','ico'=>'',
				),
			),
			//通知老师
			'noticeteacher'=>array(
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'noticeteacher','name'=>'','ico'=>'',
				),
			),
			//点评学生
			'conduct'=>array(
                 array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'conduct','name'=>'','ico'=>'',
				),
			),
            //老师消息监管
			'monitoring'=>array(
                 array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'monitoring','name'=>'','ico'=>'',
				),
			),
			//教育资讯
			'eduinfo'=>array(

			),
			//课程表
			'schedule'=>array(

			),
			//定向发送设置
            'teacherconfig'=>array(
                array(
					'module'=>"xiaoxin",'controller'=>'teacherconfig','action'=>'index','name'=>'','ico'=>'',
				),
			),
            //定向发送
			'directsend'=>array(
                array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'directsend','name'=>'','ico'=>'',
				),
			), 
			//餐单管理
			'monitoring'=>array(
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'monitoring','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'monitoringsenddetail','name'=>'','ico'=>'',
				),
			),

            //餐单管理
            'foodmenu'=>array(
                array(
                    'module'=>"xiaoxin",'controller'=>'foodmenu','action'=>'index','name'=>'','ico'=>'',
                ),
                array(
                    'module'=>"xiaoxin",'controller'=>'foodmenu','action'=>'search','name'=>'','ico'=>'',
                ),
            ),
			//新菜单
			'newmenu'=>array(

			),
            //自定义签名
			'sign'=>array(
                 array(
                    'module'=>"xiaoxin",'controller'=>'sign','action'=>'index','name'=>'','ico'=>'',
                ),
			),
			//紧急通知
			'emergency'=>array(
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'noticerush','name'=>'','ico'=>'',
				),
			),
			//蜻豆商城
			'mall'=>array(

			),
			//班级通知
			'classnotice'=>array(

			),
			//学校通知
			'schoolnotice'=>array(

			),
            //花名册
			'phonebook'=>array(
                array(
					'module'=>"xiaoxin",'controller'=>'phonebook','action'=>'index','name'=>'','ico'=>'',
				),
                 array(
					'module'=>"xiaoxin",'controller'=>'phonebook','action'=>'studentlist','name'=>'','ico'=>'',
				),
			),
			//成绩管理
			'score'=>array(
				array(
					'module'=>"xiaoxin",'controller'=>'exam','action'=>'index','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'exam','action'=>'create','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'exam','action'=>'update','name'=>'','ico'=>'',
				),
			),
			//我的宝贝
			'mybaby'=>array(

			),
			//自定义分组
			'usergroup' => array(
				array(
					'module'=>"xiaoxin",'controller'=>'group','action'=>'index','name'=>'','ico'=>'pIco15',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'group','action'=>'create','name'=>'','ico'=>'pIco15',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'group','action'=>'update','name'=>'','ico'=>'pIco15',
				),
			),
			//消息审核
			'approvelist'=>array(
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'approvelist','name'=>'','ico'=>'',
				),
			),

		//日常工作--------------------------------------------------------------


			//其他主菜单——————————————————————————————————————————————————————————————————————————————————————————————————
			//校信首页
			'home' => array(
				array(
					'module'=>"xiaoxin",'controller'=>'default','action'=>'index','name'=>'校信首页','ico'=>'',
				),
			),
			'dailylist' => array(
				array(
					'module'=>"xiaoxin",'controller'=>'application','action'=>'index','name'=>'','ico'=>'',
				),
			),
			//我的班级
			'myclass' => array(
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'index','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'create','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'update','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'apply','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'view','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'teachers','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'pinvite','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'students','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'sinvite','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'invites','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'deleted','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'supload','name'=>'','ico'=>'',
				),
                array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'scfinish','name'=>'','ico'=>'',
				),
                array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'scupload','name'=>'','ico'=>'',
				),
                array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'tupload','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'simport','name'=>'','ico'=>'',
				),
                array(
                    'module'=>"xiaoxin",'controller'=>'class','action'=>'timport','name'=>'','ico'=>'',
                ),
                array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'scimport','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'generatecode','name'=>'','ico'=>'',
				),
                array(
					'module'=>"xiaoxin",'controller'=>'class','action'=>'updatestudent','name'=>'','ico'=>'',
				), 
			),
			//我的孩子
			'baby' => array(
				array(
					'module'=>"xiaoxin",'controller'=>'baby','action'=>'index','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'baby','action'=>'account','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'baby','action'=>'group','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'baby','action'=>'parent','name'=>'','ico'=>'',
				),
			),
			//消息中心
			'noticecenter' => array(
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'noticecenter','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'senddetail','name'=>'','ico'=>'',
				),
				array(
					'module'=>"xiaoxin",'controller'=>'notice','action'=>'detail','name'=>'','ico'=>'',
				),
			),
		);
		return $arr;
	}

	/**
	* @author panrj 2014-08-16
	* @var obj $controller 控制器对象
	* 获取控制器所属子菜单
	*/
	public static function getSubMenu($con)
	{
		$menu = self::sub();
		$module = $con->module ? $con->module->id : '';
		if($module=='srbac')
			return 'srbac';
		$controller = $con->id;
		$action = $con->getAction()->getId();
		foreach($menu as $key=>$val){
			foreach($val as $m){
				if($module==$m['module'] && $controller==$m['controller'] && $action==$m['action'])
					return $key;
			}
		}
		return '';
	}

	/**
	* @author panrj 2014-08-16
	* @var obj $controller 控制器对象
	* 获取控制器所属子菜单
	*/
	public static function getSubName($con)
	{
		$menu = self::sub();
		$module = $con->module ? $con->module->id : '';
		if($module=='srbac')
			return '权限管理';
		$controller = $con->id;
		$action = $con->getAction()->getId();
		foreach($menu as $key=>$val){
			foreach($val as $m){
				if($module==$m['module'] && $controller==$m['controller'] && $action==$m['action'])
					return $m['name'];
			}
		}
		return '';
	}

	/**
	* @author panrj 2014-08-16
	* @var obj $controller 控制器对象
	* 获取控制器所属子菜单
	*/
	public static function getSubIco($con)
	{
		$menu = self::sub();
		$module = $con->module ? $con->module->id : '';
		$controller = $con->id;
		$action = $con->getAction()->getId();
		foreach($menu as $key=>$val){
			foreach($val as $m){
				if($module==$m['module'] && $controller==$m['controller'] && $action==$m['action'])
					return isset($m['ico'])?$m['ico']:'';
			}
		}
		return '';
	}

	/**
	* @author panrj 2014-08-16
	* @var obj $controller 控制器对象
	* 获取控制器所属子菜单
	*/
	public static function getReturnState($con)
	{
		$menu = self::sub();
		$module = $con->module ? $con->module->id : '';
		if($module=='srbac')
			return false;
		$controller = $con->id;
		$action = $con->getAction()->getId();
		foreach($menu as $key=>$val){
			foreach($val as $m){
				if($module==$m['module'] && $controller==$m['controller'] && $action==$m['action'])
					return isset($m['showreturn'])?$m['showreturn']:false;
			}
		}
		return '';
	}

	/**
	* @author panrj 2014-08-16
	* @var obj $controller 控制器对象
	* 获取控制器所属子菜单
	*/
	public static function getReturnDefine($con)
	{
		$menu = self::sub();
		$module = $con->module ? $con->module->id : '';
		if($module=='srbac')
			return false;
		$controller = $con->id;
		$action = $con->getAction()->getId();
		foreach($menu as $key=>$val){
			foreach($val as $m){
				if($module==$m['module'] && $controller==$m['controller'] && $action==$m['action'])
					return isset($m['returnurl'])?$m['returnurl']:'';
			}
		}
		return '';
	}

	/**
	* @author panrj 2014-08-16
	* @var obj $controller 控制器对象
	* 获取控制器所属顶级菜单
	*/
	public static function getTopMenu($con)
	{
		$menu = self::top();
		$sub = self::getSubMenu($con);
		if($sub){
			foreach($menu as $key=>$val){
				if(in_array($sub,$val))
					return $key;
			}
		}
		return '';
	}

	/**
	* @author panrj 2014-08-16
	* @var obj $controller 控制器对象
	* 获取控制器所属顶级菜单活动css
	*/
	public static function getTopCss($con,$key,$appid='')
	{
		$menu = self::getTopMenu($con);
		if($menu==$key)
			return 'focus';
		return '';
	}

	/**
	* @author panrj 2014-08-16
	* @var obj $controller 控制器对象
	* 获取控制器所属顶级菜单活动style
	*/
	public static function getTopStyle($con,$key)
	{
		$menu = self::getTopMenu($con);
		if($menu==$key)
			return 'display:block;';
		return '';
	}

	/**
	* @author panrj 2014-08-16
	* @var obj $controller 控制器对象
	* 获取控制器所属子菜单活动css
	*/
	public static function getSubCss($con,$key)
	{
		$menu = self::getSubMenu($con);
		if($menu==$key)
			return 'focus';
		return '';
	}

	public static function getSubTag($con)
	{
		$menu = self::getSubMenu($con);
		return $menu;
	}

	public static function getTopTag($con)
	{
		$menu = self::getTopMenu($con);
		return $menu;
	}
}