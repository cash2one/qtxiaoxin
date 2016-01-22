<?php 
/**
* @author panrj 2014-08-09 
* Check类，检测一些数据的合法性
*/
Class CheckHelper{
	/**
	* @author panrj 2014-08-09 
	* IsUsername函数:检测是否符合用户名格式
	* $Argv是要检测的用户名参数
	* $RegExp是要进行检测的正则语句
	* 返回值:符合用户名格式返回用户名,不是返回false
	*/
	public static function IsUsername($Argv){
		$RegExp='/^[a-zA-Z0-9_]{3,16}$/'; //由大小写字母跟数字组成并且长度在3-16字符直接
		return preg_match($RegExp,$Argv)?$Argv:false;
	}
	
	/**
	* @author panrj 2014-08-09 
	* IsMail函数:检测是否为正确的邮件格式
	* 返回值:是正确的邮件格式返回邮件,不是返回false
	*/
	public static function IsMail($Argv){
		$RegExp='/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i';
		return preg_match($RegExp,$Argv)?$Argv:false;
	}
	
 	/**
 	* @author panrj 2014-08-09 
	* IsSmae函数:检测参数的值是否相同
	* 返回值:相同返回true,不相同返回false
	*/
	public static function IsSame($ArgvOne,$ArgvTwo,$Force=false){
		return $Force?$ArgvOne===$ArgvTwo:$ArgvOne==$ArgvTwo;
	}
 	
	/**
	* @author panrj 2014-08-09 
	* IsQQ函数:检测参数的值是否符合QQ号码的格式
 	* 返回值:是正确的QQ号码返回QQ号码,不是返回false
	*/
	public static function IsQQ($Argv){
		$RegExp='/^[1-9][0-9]{5,11}$/';
		return preg_match($RegExp,$Argv)?$Argv:false;
	}
	
 	/**
 	* @author panrj 2014-08-09 
	* IsMobile函数:检测参数的值是否为正确的中国手机号码格式
	* 返回值:是正确的手机号码返回手机号码,不是返回false
 	*/
	public static function IsMobile($Argv){
		$RegExp='/^1\d{10}$/';
		return preg_match($RegExp,$Argv)?$Argv:false;
	}
	
	/**
	* @author panrj 2014-08-09 
	* IsTel函数:检测参数的值是否为正取的中国电话号码格式包括区号
	* 返回值:是正确的电话号码返回电话号码,不是返回false
	*/
	public static function IsTel($Argv){
		$RegExp='/[0-9]{3,4}-[0-9]{7,8}$/';
		return preg_match($RegExp,$Argv)?$Argv:false;
	}
	
	/**
	* @author panrj 2014-08-09 
	* IsNickname函数:检测参数的值是否为正确的昵称格式(Beta)
	* 返回值:是正确的昵称格式返回昵称格式,不是返回false
	*/
	public static function IsNickname($Argv){
		$RegExp='/^\s*$|^c:\\con\\con$|[%,\*\"\s\t\<\>\&\'\(\)]|\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8/is'; //Copy From DZ
 		return preg_match($RegExp,$Argv)?$Argv:false;
	}
	
	/**
	* @author panrj 2014-08-09 
	* IsChinese函数:检测参数是否为中文
	* 返回值:是返回参数,不是返回false
	*/
	public static function IsChinese($Argv,$Encoding='utf8'){
		$RegExp = $Encoding=='utf8'?'/^[\x{4e00}-\x{9fa5}]+$/u':'/^([\x80-\xFF][\x80-\xFF])+$/';
		return preg_match($RegExp,$Argv)?$Argv:false;
	}
}