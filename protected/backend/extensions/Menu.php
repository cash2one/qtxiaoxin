<?php
/**
* @author panrj 2014-05-21
* 后台管理菜单配置文件
*/
class Menu
{
	/**
	* @author panrj 2014-05-21
	* 返回顶级菜单配置数组
	*/
	public static function top()
	{
		$arr = array(
			//商户管理
			'business' => array('business_list','business_admin','business_create',),
			//合同管理
			'contract' => array('contract_list','contract_create','contract_admin','contract_document','contract_adv'),
			//广告管理
			'advertisement' => array('adv_list','adv_create','adv_admin','adv_public',),
			//热点管理
			'focus' => array('focus_list','focus_admin','focus_create','focus_public',),
			//资讯管理
			'info' => array('info_list','info_admin','info_create','info_public',),
			//商品管理
			'goods' => array('goods_list','goods_admin','goods_create','gcard_index','gcard_create','gcard_admin','gcard_business','mg_order',),
			//账号管理
			'user' => array('user_list','user_create','user_admin',),
			//权限管理
			'srbac' => array('srbac','user_access',),
			//个人设置
			'account' => array('account_set','account_password',),
			//数据分析
			'gird' => array('girdgoods','girdadvs','girdinfos','girdfocs','statistic'),
			//校园管理
			'schoolmanage' => array('school','class','department','subject','courses','duty','group',''),
			//用户管理
			'member' => array('teacher','student',),
		    //公众号管理
		    'official' => array('official_create','official_list','official_message','official_datastat','official_fans'),
		    //绩效管理
		    'kpi' => array('kpi_index','kpi_ranking', 'kpi_configure', 'kpi_log', 'kpi_scorelimit'),
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
			//数据分析
			'girdgoods' => array(
				array(
					'module'=>"gird",'controller'=>'goods','action'=>'index','name'=>'商品统计列表',
				),
				array(
					'module'=>"gird",'controller'=>'goods','action'=>'daily','name'=>'查看每日统计','showreturn'=>true,
				),
				array(
					'module'=>"gird",'controller'=>'goods','action'=>'sold','name'=>'兑换记录','showreturn'=>true,
				),
				array(
					'module'=>"gird",'controller'=>'goods','action'=>'browse','name'=>'浏览记录','showreturn'=>true,
				),
				array(
					'module'=>"gird",'controller'=>'goods','action'=>'comment','name'=>'评价记录','showreturn'=>true,
				),
			),

			'girdadvs' => array(
				array(
					'module'=>"gird",'controller'=>'advs','action'=>'index','name'=>'广告统计列表',
				),
				array(
					'module'=>"gird",'controller'=>'advs','action'=>'daily','name'=>'查看每日统计','showreturn'=>true,
				),
				array(
					'module'=>"gird",'controller'=>'advs','action'=>'browse','name'=>'浏览记录','showreturn'=>true,
				),
			),

			'girdinfos' => array(
				array(
					'module'=>"gird",'controller'=>'infos','action'=>'index','name'=>'资讯统计列表',
				),
				array(
					'module'=>"gird",'controller'=>'infos','action'=>'daily','name'=>'查看每日统计','showreturn'=>true,
				),
				array(
					'module'=>"gird",'controller'=>'infos','action'=>'browse','name'=>'浏览记录','showreturn'=>true,
				),
			),

			'girdfocs' => array(
				array(
					'module'=>"gird",'controller'=>'focs','action'=>'index','name'=>'热点统计列表',
				),
				array(
					'module'=>"gird",'controller'=>'focs','action'=>'daily','name'=>'查看每日统计','showreturn'=>true,
				),
				array(
					'module'=>"gird",'controller'=>'focs','action'=>'browse','name'=>'浏览记录','showreturn'=>true,
				),
				array(
					'module'=>"gird",'controller'=>'focs','action'=>'answer','name'=>'问卷结果','showreturn'=>true,'returnurl'=>Yii::app()->createUrl('gird/focs/index/'),
				),
				array(
					'module'=>"gird",'controller'=>'focs','action'=>'replay','name'=>'问答详情','showreturn'=>true,
				),
				array(
					'module'=>"gird",'controller'=>'focs','action'=>'join','name'=>'参与记录','showreturn'=>true,
				),
			),

			//商户管理
			'business_list' => array(
				array(
					'module'=>"",'controller'=>'business','action'=>'index','name'=>'商家列表',
				),
				array(
					'module'=>"",'controller'=>'business','action'=>'view','name'=>'商家详情','showreturn'=>true,
				),
			),

			'business_admin' => array(
				array(
					'module'=>"",'controller'=>'business','action'=>'admin','name'=>'编辑列表',
				),
				array(
					'module'=>"",'controller'=>'business','action'=>'update','name'=>'编辑商家','showreturn'=>true,
				),
			),
			'business_create' => array(
				array(
					'module'=>"",'controller'=>'business','action'=>'create','name'=>'创建商家',
				),
			),

			//合同管理
			'contract_list' => array(
				array(
					'module'=>"",'controller'=>'contract','action'=>'index','name'=>'合同列表',
				),
				array(
					'module'=>"",'controller'=>'contract','action'=>'view','name'=>'合同详情','showreturn'=>true,
				),
			),
			'contract_create' => array(
				array(
					'module'=>"",'controller'=>'contract','action'=>'create','name'=>'创建合同',
				),
			),

			'contract_admin' => array(
				array(
					'module'=>"",'controller'=>'contract','action'=>'admin','name'=>'编辑列表',
				),
				array(
					'module'=>"",'controller'=>'contract','action'=>'update','name'=>'编辑合同','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'contract','action'=>'updateview','name'=>'查看合同','showreturn'=>true,
				),
			),

			'contract_document' => array(
				array(
					'module'=>"",'controller'=>'contract','action'=>'document','name'=>'审核列表',
				),
				array(
					'module'=>"",'controller'=>'contract','action'=>'docview','name'=>'合同详情','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'contract','action'=>'approval','name'=>'审批合同','showreturn'=>true,
				),
			),

			'contract_adv' => array(
				array(
					'module'=>"",'controller'=>'contract','action'=>'adv','name'=>'广告位查询',
				),
			),

			//广告管理
			'adv_list' => array(
				array(
					'module'=>"",'controller'=>'adv','action'=>'index','name'=>'广告列表',
				),
				array(
					'module'=>"",'controller'=>'adv','action'=>'view','name'=>'广告详情','showreturn'=>true,
				),
			),

			'adv_create' => array(
				array(
					'module'=>"",'controller'=>'adv','action'=>'create','name'=>'创建广告',
				),
			),

			'adv_admin' => array(
				array(
					'module'=>"",'controller'=>'adv','action'=>'admin','name'=>'编辑列表',
				),
				array(
					'module'=>"",'controller'=>'adv','action'=>'update','name'=>'编辑广告','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'adv','action'=>'detail','name'=>'广告详情','showreturn'=>true,
				),
			),

			'adv_public' => array(
				array(
					'module'=>"",'controller'=>'adv','action'=>'public','name'=>'开放广告列表',
				),
				array(
					'module'=>"",'controller'=>'adv','action'=>'publicedit','name'=>'编辑开放广告','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'adv','action'=>'publicview','name'=>'开放广告详情','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'adv','action'=>'publicadd','name'=>'创建开放广告','showreturn'=>true,
				),
			),

			//热点管理
			'focus_list' => array(
				array(
					'module'=>"",'controller'=>'focus','action'=>'index','name'=>'热点列表',
				),
				array(
					'module'=>"",'controller'=>'focus','action'=>'view','name'=>'热点详情','showreturn'=>true,
				),
			),
			'focus_create' => array(
				array(
					'module'=>"",'controller'=>'focus','action'=>'create','name'=>'创建热点',
				),
			),
			'focus_admin' => array(
				array(
					'module'=>"",'controller'=>'focus','action'=>'admin','name'=>'编辑列表',
				),
				array(
					'module'=>"",'controller'=>'focus','action'=>'update','name'=>'编辑热点','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'focus','action'=>'updateview','name'=>'热点详情','showreturn'=>true,
				),
			),
			'focus_public' => array(
				array(
					'module'=>"",'controller'=>'focus','action'=>'public','name'=>'开放热点列表',
				),
				array(
					'module'=>"",'controller'=>'focus','action'=>'publicadd','name'=>'创建开放热点','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'focus','action'=>'publicedit','name'=>'编辑开放热点','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'focus','action'=>'publicview','name'=>'开放热点详情','showreturn'=>true,
				),
			),

			//资讯管理
			'info_list' => array(
				array(
					'module'=>"",'controller'=>'information','action'=>'index','name'=>'资讯列表',
				),
				array(
					'module'=>"",'controller'=>'information','action'=>'view','name'=>'资讯详情','showreturn'=>true,
				),
			),
			'info_admin' => array(
				array(
					'module'=>"",'controller'=>'information','action'=>'admin','name'=>'编辑列表',
				),
				array(
					'module'=>"",'controller'=>'information','action'=>'update','name'=>'编辑资讯','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'information','action'=>'detail','name'=>'资讯详情','showreturn'=>true,
				),
			),
			'info_create' => array(
				array(
					'module'=>"",'controller'=>'information','action'=>'create','name'=>'创建资讯',
				),
			),
			'info_public' => array(
				array(
					'module'=>"",'controller'=>'information','action'=>'public','name'=>'开放资讯列表',
				),
				array(
					'module'=>"",'controller'=>'information','action'=>'publicadd','name'=>'创建开放资讯','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'information','action'=>'publicview','name'=>'开放资讯详情','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'information','action'=>'publicedit','name'=>'编辑开放资讯','showreturn'=>true,
				),
			),
			//商品管理
			'goods_list' => array(
				array(
					'module'=>"",'controller'=>'goods','action'=>'index','name'=>'商品列表',
				),
				array(
					'module'=>"",'controller'=>'goods','action'=>'view','name'=>'商品详情','showreturn'=>true,
				),
			),
			'goods_admin' => array(
				array(
					'module'=>"",'controller'=>'goods','action'=>'admin','name'=>'编辑列表',
				),
				array(
					'module'=>"",'controller'=>'goods','action'=>'update','name'=>'编辑商品','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'goods','action'=>'detail','name'=>'商品详情','showreturn'=>true,
				),
			),
			'goods_create' => array(
				array(
					'module'=>"",'controller'=>'goods','action'=>'create','name'=>'创建商品',
				),
			),
			'gcard_index' => array(
				array(
					'module'=>"",'controller'=>'gcard','action'=>'index','name'=>'虚拟卡列表',
				),
				array(
					'module'=>"",'controller'=>'gcard','action'=>'view','name'=>'虚拟卡详情','showreturn'=>true,
				),
			),
			'gcard_create' => array(
				array(
					'module'=>"",'controller'=>'gcard','action'=>'create','name'=>'创建虚拟卡',
				),
			),
			'gcard_admin' => array(
				array(
					'module'=>"",'controller'=>'gcard','action'=>'admin','name'=>'编辑列表',
				),
				array(
					'module'=>"",'controller'=>'gcard','action'=>'detail','name'=>'虚拟卡详情','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'gcard','action'=>'update','name'=>'编辑虚拟卡','showreturn'=>true,
				),
			),
			'gcard_business' => array(
				array(
					'module'=>"",'controller'=>'gcard','action'=>'business','name'=>'商家专区',
				),
				array(
					'module'=>"",'controller'=>'gcard','action'=>'busdetail','name'=>'虚拟卡详情','showreturn'=>true,
				),
			),
			'mg_order' => array(
				array(
					'module'=>"",'controller'=>'order','action'=>'index','name'=>'订单列表',
				),
				array(
					'module'=>"",'controller'=>'order','action'=>'deal','name'=>'订单操作',
				),
			),

			//账号管理
			'user_list' => array(
				array(
					'module'=>"",'controller'=>'user','action'=>'index','name'=>'账号列表',
				),
				array(
					'module'=>"",'controller'=>'user','action'=>'view','name'=>'账号详情','showreturn'=>true,
				),
			),
			'user_create' => array(
				array(
					'module'=>"",'controller'=>'user','action'=>'create','name'=>'创建账号',
				),
			),
			'user_admin' => array(
				array(
					'module'=>"",'controller'=>'user','action'=>'admin','name'=>'编辑列表',
				),
				array(
					'module'=>"",'controller'=>'user','action'=>'update','name'=>'编辑账号','showreturn'=>true,
				),
				array(
					'module'=>"",'controller'=>'user','action'=>'delete','name'=>'删除账号',
				),
			),
			'user_access' => array(
				array(
					'module'=>"",'controller'=>'user','action'=>'access','name'=>'管理范围',
				),
			),


			//权限管理
			'srbac' => array(
				array(
					'module'=>"srbac",'controller'=>'*','action'=>'*','name'=>'功能权限',
				),
			),


			//个人设置
			'account_set' => array(
				array(
					'module'=>"",'controller'=>'user','action'=>'account','name'=>'个人资料',
				),
			),
			'account_password' => array(
				array(
					'module'=>"",'controller'=>'user','action'=>'password','name'=>'修改密码',
				),
			),

			//学校管理
			'school' => array(
				array(
					'module'=>"",'controller'=>'school','action'=>'index','name'=>'学校列表',
				),
				array(
					'module'=>"",'controller'=>'school','action'=>'create','name'=>'创建学校',
				),
				array(
					'module'=>"",'controller'=>'school','action'=>'update','name'=>'编辑学校',
				),

			),
            //职务管理
            'duty'=>  array(
                array(
                    'module'=>"",'controller'=>'duty','action'=>'index','name'=>'职务列表',
                ),
                array(
                    'module'=>"",'controller'=>'duty','action'=>'create','name'=>'创建职务',
                ),
                array(
                    'module'=>"",'controller'=>'duty','action'=>'update','name'=>'编辑职务',
                ),
            ),

			//班级管理
			'class' => array(
				array(
					'module'=>"",'controller'=>'class','action'=>'index','name'=>'班级列表',
				),
				array(
					'module'=>"",'controller'=>'class','action'=>'create','name'=>'创建班级',
				),
				array(
					'module'=>"",'controller'=>'class','action'=>'update','name'=>'编辑班级',
				),
                array(
					'module'=>"",'controller'=>'class','action'=>'import','name'=>'班级批量导入',
				),
			),

			//部门管理
			'department' => array(
				array(
					'module'=>"",'controller'=>'part','action'=>'index','name'=>'部门列表',
				),
				array(
					'module'=>"",'controller'=>'part','action'=>'create','name'=>'创建部门',
				),
				array(
					'module'=>"",'controller'=>'part','action'=>'update','name'=>'编辑部门',
				),
			),

			//科目管理
			'subject' => array(
				array(
					'module'=>"",'controller'=>'subject','action'=>'index','name'=>'科目列表',
				),
				array(
					'module'=>"",'controller'=>'subject','action'=>'create','name'=>'创建科目',
				),
				array(
					'module'=>"",'controller'=>'subject','action'=>'update','name'=>'编辑科目',
				),
			),

			//课程分配
			'courses' => array(
				array(
					'module'=>"",'controller'=>'courses','action'=>'index','name'=>'课程分配',
				),
                array(
					'module'=>"",'controller'=>'courses','action'=>'import','name'=>'课程批量导入',
				),
			),

           //分组管理
		   'group' => array(
				array(
					'module'=>"",'controller'=>'group','action'=>'index','name'=>'分组管理',
				),
                array(
					'module'=>"",'controller'=>'group','action'=>'create','name'=>'创建分组',
				),
				 array(
					'module'=>"",'controller'=>'group','action'=>'update','name'=>'编辑分组',
				),
            ),
            //安装量统计
            'statistic' => array(
                array(
                    'module'=>"",'controller'=>'statistic','action'=>'index','name'=>'安装量统计',
                ),
            ),

			//教师管理
			'teacher' => array(
				array(
					'module'=>"",'controller'=>'teacher','action'=>'index','name'=>'教师列表',
				),
				array(
					'module'=>"",'controller'=>'teacher','action'=>'create','name'=>'创建教师',
				),
				array(
					'module'=>"",'controller'=>'teacher','action'=>'update','name'=>'编辑教师',
				),
                array(
					'module'=>"",'controller'=>'teacher','action'=>'importteacher','name'=>'教师批量导入',
				),
			),

			//学生管理
			'student' => array(
				array(
					'module'=>"",'controller'=>'student','action'=>'index','name'=>'学生列表',
				),
				array(
					'module'=>"",'controller'=>'student','action'=>'create','name'=>'创建学生',
				),
				array(
					'module'=>"",'controller'=>'student','action'=>'update','name'=>'编辑学生',
				),
                array(
					'module'=>"",'controller'=>'student','action'=>'importstudent','name'=>'学生批量导入',
				),
			),

		    //创建公众号
		    'official_create' => array(
		        array(
		            'module'=>"",'controller'=>'official','action'=>'create','name'=>'创建公众号',
		        ),
		    ),

		    //公众号管理
		    'official_list' => array(
		        array(
    		        'module'=>"",'controller'=>'official','action'=>'index','name'=>'公众号管理',
    		    ),
    		    array(
    		        'module'=>"",'controller'=>'official','action'=>'update','name'=>'编辑公众号',
    		    ),
		    ),

		    //消息管理
		    'official_message' => array(
		        array(
     		        'module'=>"",'controller'=>'official','action'=>'message','name'=>'消息管理',
     		    ),
		    ),

		    //绩效积分
		    'kpi_index' => array(
		        array(
    		        'module'=>"",'controller'=>'kpi','action'=>'index','name'=>'绩效积分',
    		    ),
		    ),

		    //绩效排行榜
		    'kpi_ranking' => array(
		        array(
		            'module'=>"",'controller'=>'kpi','action'=>'ranking','name'=>'排行榜',
		        ),
		    ),

            'kpi_scorelimit' => array(
                array(
                    'module'=>"",'controller'=>'kpi','action'=>'scorelimit','name'=>'考核人数限制',
                ),
            ),

            'kpi_configure' => array(
                array(
                    'module'=>"",'controller'=>'kpi','action'=>'configure','name'=>'考核人数配置',
                ),
            ),

		    'kpi_log' => array(
		        array(
		            'module'=>"",'controller'=>'kpi','action'=>'log','name'=>'历史评分',
		        ),
		    ),

		    //数据统计
		    'official_datastat' => array(
		        array(
    		        'module'=>"",'controller'=>'official','action'=>'datastat','name'=>'数据统计',
    		    ),
		    ),

		    //粉丝管理
		    'official_fans' => array(
		         array(
    		        'module'=>"",'controller'=>'official','action'=>'fans','name'=>'粉丝管理',
    		    ),
		    ),

		);
		return $arr;
	}

	/**
	* @author panrj 2014-05-21
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
	* @author panrj 2014-05-21
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
	* @author panrj 2014-05-21
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
	* @author panrj 2014-07-22
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
	* @author panrj 2014-05-21
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
	* @author panrj 2014-05-21
	* @var obj $controller 控制器对象
	* 获取控制器所属顶级菜单活动css
	*/
	public static function getTopCss($con,$key)
	{
		$menu = self::getTopMenu($con);
		if($menu==$key)
			return 'active';
		return '';
	}

	/**
	* @author panrj 2014-05-21
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
	* @author panrj 2014-05-21
	* @var obj $controller 控制器对象
	* 获取控制器所属子菜单活动css
	*/
	public static function getSubCss($con,$key)
	{
		$menu = self::getSubMenu($con);
		if($menu==$key)
			return 'active';
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