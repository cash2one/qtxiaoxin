<?php
/**
* @author panrj 2014-05-21
* 权限控制类
*/
Yii::import("backend.modules.srbac.components.Helper");

class Uaccess
{
	/**
	* @author panrj 2014-05-22 
	* @var int $uid 用户主键
	* 查询用户拥有角色
	*/
	public static function getRoleModels($uid)
	{
		if(!$uid)
			return array();
		return Helper::getUserAssignedRoles($uid);
	}

	/**
	* @author panrj 2014-05-22 
	* @var int $uid 用户主键
	* 获取用户拥有角色名称
	*/
	public static function getRoles($uid)
	{
		if(!$uid)
			return array();
		$data = self::getRoleModels($uid);
		$roles = array();
		if(!empty($data)){
			foreach($data as $r){
				array_push($roles,$r['name']);
			}
		}
		return $roles;
	}

	/**
	* @author panrj 2014-05-22 
	* @var string $name 角色名称
	* 查询用户拥有任务
	*/
	public static function getTaskModels($name)
	{
		if(!$name)
			return array();
		return Helper::getRoleAssignedTasks($name);
	}

	/**
	* @author panrj 2014-05-22 
	* @var string $name 角色名称
	* 获取角色拥有任务名称
	*/
	public static function getRoleTasks($name)
	{
		if(!$name)
			return array();
		$data = self::getTaskModels($name);
		$tasks = array();
		if(!empty($data)){
			foreach($data as $t){
				array_push($tasks,$t['name']);
			}
		}
		return $tasks;
	}

	/**
	* @author panrj 2014-05-22 
	* @var int $uid 用户主键
	* 获取用户拥有任务名称
	*/
	public static function getTasks()
	{
		$uid = Yii::app()->user->id;
		if(!$uid)
			return array();
		$roles = self::getRoles($uid);
		$tasks = array();
		if(!empty($roles)){
			foreach($roles as $r){
				$ts = self::getRoleTasks($r);
				if(!empty($ts)){
					foreach($ts as $t){
						array_push($tasks,$t);
					}
				}
			}
		}
		return $tasks;
	}

	public static function hasRight($name)
	{
		$tasks = self::getTasks();
		return in_array($name,$tasks);
	}
}