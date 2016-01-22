<?php 
/**
* @author panrj 2014-04-29 
* JSON类，用于返回接口数据
*/
class JsonHelper
{
	/**
	* @author panrj 2014-04-29 
	* 遍历数组对象
	*/
	public static function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
	{
	    static $recursive_counter = 0;
	    if (++$recursive_counter > 1000) {
	        die('possible deep recursion attack');
	    }
	    foreach ($array as $key => $value) {
	        if (is_array($value)) {
	            JsonHelper::arrayRecursive($array[$key], $function, $apply_to_keys_also);
	        } else {
	            $array[$key] = $function($value);
	        }
	 
	        if ($apply_to_keys_also && is_string($key)) {
	            $new_key = $function($key);
	            if ($new_key != $key) {
	                $array[$new_key] = $array[$key];
	                unset($array[$key]);
	            }
	        }
	    }
	    $recursive_counter--;
	}
	 
	/**************************************************************
	 *  @author panrj 2014-04-29 
	 *	将数组转换为JSON字符串（兼容中文）
	 *	@param	array	$array		要转换的数组
	 *	@return string		转换得到的json字符串
	 *	@access public
	 *
	 *************************************************************/
	public static function JSON($array,$escape=false) {
		JsonHelper::arrayRecursive($array, 'urlencode', true);
		if($escape){
			$json = json_encode($array,JSON_UNESCAPED_UNICODE);
		}else{
			$json = json_encode($array);
		}
		return urldecode($json);
	}

	public static function Notify($contype,$item)
	{
		if($contype){
			$data = array($contype=>array(),"Result"=>"-100","Message"=>"无效参数".$item);
		}else{
			$data = array("Result"=>"-100","Message"=>"无效参数".$item);
		}
		echo JsonHelper::JSON($data);
		exit;
	}

	/**
	* @author panrj 2014-07-23 
	* 将字符串中英文状态的双引号转换成中文状态的双引号 注意双引号要成对出现
	* @param string $str 字符串 
	* @return string 转换后的字符串 
	*/
	public static function QuotesEnToCn($str){  
	    return preg_replace('/"([^"]*)"/', '“${1}”', $str);  
	}



	/** Json数据格式化
	* @author panrj 2014-10-29
	* @param  Mixed  $data   数据
	* @param  String $indent 缩进字符，默认4个空格
	* @return JSON
	*/
	public static function jsonFormat($data, $indent=null){

	    // 对数组中每个元素递归进行urlencode操作，保护中文字符
	    array_walk_recursive($data, 'self::jsonFormatProtect');
	    // json encode
	    $data = json_encode($data);
	    // 将urlencode的内容进行urldecode
	    $data = urldecode($data);
	    // 缩进处理
	    $ret = '';
	    $pos = 0;
	    $length = strlen($data);
	    $indent = isset($indent)? $indent : '    ';
	    $newline = "\n";
	    $prevchar = '';
	    $outofquotes = true;

	    for($i=0; $i<=$length; $i++){
	        $char = substr($data, $i, 1);
	        if($char=='"' && $prevchar!='\\'){
	            $outofquotes = !$outofquotes;
	        }elseif(($char=='}' || $char==']') && $outofquotes){
	            $ret .= $newline;
	            $pos --;
	            for($j=0; $j<$pos; $j++){
	                $ret .= $indent;
	            }
	        }

	        $ret .= $char;
	        if(($char==',' || $char=='{' || $char=='[') && $outofquotes){
	            $ret .= $newline;
	            if($char=='{' || $char=='['){
	                $pos ++;
	            }
	            for($j=0; $j<$pos; $j++){
	                $ret .= $indent;
	            }
	        }
	        $prevchar = $char;
	    }
	    return $ret;
	}

	/** 将数组元素进行urlencode
	* @author panrj 2014-10-29
	* @param String $val
	*/
	public static function jsonFormatProtect(&$val){
	    if($val!==true && $val!==false && $val!==null){
	        $val = urlencode($val);
	    }
	}

}