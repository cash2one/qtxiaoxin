<?php
/**
* @author panrj 2014-04-29 
* 主帮助类，提供常用方法
*/
class MainHelper
{
	/**
	* @author panrj 2014-04-29 
	* @var string $phone 手机号码或电话号码
	* 隐藏手机号码或电话号码的中间4位
	*/
	public static function hideTel($phone)
	{
		$IsWhat = preg_match('/(0[0-9]{2,3}[\-]?[2-9][0-9]{6,7}[\-]?[0-9]?)/i',$phone); //固定电话
		if($IsWhat == 1){
			return preg_replace('/(0[0-9]{2,3}[\-]?[2-9])[0-9]{3,4}([0-9]{3}[\-]?[0-9]?)/i','$1****$2',$phone);
		}else{
			return  preg_replace('/(1[358]{1}[0-9])[0-9]{4}([0-9]{4})/i','$1****$2',$phone);
		}
	}

	/**
	*@author panrj 2014-04-29 
	*@var $path 路径，前面不加'/'
	*如果目录不存在则创建目录，
	*/
	public static function createFolder($path)
	{
		if (!file_exists($path)){
			MainHelper::createFolder(dirname($path));
			mkdir($path, 0777);
		}
	}

	/**
	*@author panrj 2014-05-04
	*@var $start_time 起始时间
	*@var $end_time 结束时间
	*算取时间差返回单位为妙
	*/
	public static function getTimeInterval($start_time,$end_time)
	{
		$time1 = strtotime($start_time);
		$time2 = strtotime($end_time);
		$time = $time2-$time1;
		return $time;
	}

	/**
	* 发送邮件
	* panrj 2014-05-19
	* @var string  $to            email address of the recipient
	* @var string  $subject       the subject
	* @var string  $message          the email body
	* @var string  $from          email address of sender
	* @return bool 
	*/
	public static function mailSend($to,$from,$subject,$message){
        $mail=Yii::app()->Smtpmail;
        $mail->SetFrom($from, 'qthd');
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to, "");
        if(!$mail->Send()) {
            // echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        }else {
            // echo "Message sent!";
            return true;
        }
    }

    public static function copyImg($filename,$dir='')
	{
		if(!$filename)
			return '';
		$webroot = YiiBase::getPathOfAlias('webroot');
        $oldfile = $webroot.$filename;
		if (file_exists($oldfile)) {
			$pathinfo = pathinfo($oldfile);
			if($dir){
				$folder='storage/'.$dir.'/'.date('Ym').'/';
			}else{
				$folder='storage/'.date('Ym').'/';
			}
			MainHelper::createFolder($folder);
			copy($oldfile,$webroot.'/'.$folder.$pathinfo['basename']);
            // $filename->saveAs($webroot.'/'.$folder.$pathinfo['basename']);
            return '/'.$folder.$pathinfo['basename'];
        }else{
        	return '';
        }
	}

    /**
	 * 上传图片
	 * panrj 2014-05-16
	 * @var fileobj $filename 要上传的文件
	 * @var string $dir 文件保存目录
	 * @return string 
	 */
	public static function uploadImg($filename,$dir='')
	{
		$webroot = YiiBase::getPathOfAlias('webroot');
		if (is_object($filename)) {
			$exts = is_object($filename)?$filename->extensionName:"jpg";
			$newName=date('YmdHis').rand(1000,9999).'.'.$exts;
			if($dir){
				$folder='storage/'.$dir.'/'.date('Ym').'/';
			}else{
				$folder='storage/'.date('Ym').'/';
			}
			MainHelper::createFolder($folder);
            $filename->saveAs($webroot.'/'.$folder.$newName);
            return '/'.$folder.$newName;
        }else{
        	return '';
        }
	}

	/**
	 * 上传图片返回绝对地址
	 * panrj 2014-07-07
	 * @var fileobj $filename 要上传的文件
	 * @var string $dir 文件保存目录
	 * @return string 
	 */
	public static function uploadImgAbsolute($filename,$dir='')
	{
		$webroot = YiiBase::getPathOfAlias('webroot');
		if (is_object($filename)) {
			$exts = is_object($filename)?$filename->extensionName:"jpg";
			$newName=date('YmdHis').rand(1000,9999).'.'.$exts;
			if($dir){
				$folder='storage/'.$dir.'/'.date('Ym').'/';
			}else{
				$folder='storage/'.date('Ym').'/';
			}
			MainHelper::createFolder($folder);
            $filename->saveAs($webroot.'/'.$folder.$newName);
            return Yii::app()->request->hostInfo.'/'.$folder.$newName;
        }else{
        	return '';
        }
	}

	/**
	 * 文件流生成文件
	 * panrj 2014-10-31
	 * @var string $filename 文件名
	 * @var string $data 文件流
	 * @var string $dir 文件保存目录
	 * @return string 
	 */
	public function stream2Image($filename,$data,$dir=''){  
		$filename = rand(1000,9999).$filename;
        $webroot = YiiBase::getPathOfAlias('webroot');
        if(!empty($data)){  
        	if($dir){
				$folder='storage/client/'.$dir.'/'.date('Ymd').'/';
			}else{
				$folder='storage/client/'.date('Ymd').'/';
			}
			MainHelper::createFolder($folder);
			$save_fullpath = $webroot.'/'.$folder.$filename;

            //创建并写入数据流，然后保存文件  
            if(@$fp=fopen($save_fullpath,'w+')){
                fwrite($fp,$data);  
                fclose($fp);  
                return Yii::app()->request->hostInfo.'/'.$folder.$filename;
            }else{  
  				return '';
            }  
        }else{  
            //没有接收到数据流  
            return '';
        }  
    }  

	public static function generate_password($length=8)
	{  
    // 密码字符集，可任意添加你需要的字符  
	    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';  
	    $password = '';  
	    for($i=0;$i<$length;$i++){  
	    	$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];  
	    }  
    	return $password;  
    }

    public static function generate_code($length=8)
	{  
    // 验证码符集，可任意添加你需要的字符  
	    $chars = '0123456789';  
	    $code = '';  
	    for($i=0;$i<$length;$i++){  
	    	$code .= $chars[ mt_rand(0, strlen($chars) - 1) ];  
	    }  
    	return $code;  
    }

    /**
	 * 密码加密算法
	 * panrj 2014-08-09
	 * @var string $password 未加密的密码
	 * @return string 
	 */
    public static function encryPassword($password)
    {
    	$result = md5(strtolower(md5(strtolower($password)."CK2012")) . "DBK_0715");
    	return strtolower($result);
    } 

    public static function DateAdd($part, $number, $date)
	{
		$date_array = getdate(strtotime($date));
		$hor = $date_array["hours"];
		$min = $date_array["minutes"];
		$sec = $date_array["seconds"];
		$mon = $date_array["mon"];
		$day = $date_array["mday"];
		$yar = $date_array["year"];
		switch($part)
		{
		case "y": $yar += $number; break;
		case "q": $mon += ($number * 3); break;
		case "m": $mon += $number; break;
		case "w": $day += ($number * 7); break;
		case "d": $day += $number; break;
		case "h": $hor += $number; break;
		case "n": $min += $number; break;
		case "s": $sec += $number; break;
		}
		return date("Y-m-d H:i:s", mktime($hor, $min, $sec, $mon, $day, $yar));
	}

	/**
	* 截取中文字符串
	* panrj 2014-07-18
	* 中文截取，支持gb2312,gbk,utf-8,big5 
	* @param string $str 要截取的字串 
	* @param int $start 截取起始位置 
	* @param int $length 截取长度 
	* @param string $charset utf-8|gb2312|gbk|big5 编码 
	* @param $suffix 是否加尾缀  
	* @return string 
	*/
	public static function csubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) 
	{ 
	   	if(function_exists("mb_substr")) 
	   	{ 
			if(mb_strlen($str, $charset) <= $length) return $str; 
			$slice = mb_substr($str, $start, $length, $charset); 
	   	}else{ 
			$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/"; 
			$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/"; 
			$re['gbk']          = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/"; 
			$re['big5']          = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/"; 
			preg_match_all($re[$charset], $str, $match); 
			if(count($match[0]) <= $length) return $str; 
			$slice = join("",array_slice($match[0], $start, $length)); 
	   	} 
	   	if($suffix) return $slice."…"; 
	   	return $slice; 
	}

	
  
	//十进制转换三十六进制  
	public static function enid($int, $format = 8) { 
	    $dic = array(  
		    0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9',  
		    10 => 'A', 11 => 'B', 12 => 'C', 13 => 'D', 14 => 'E', 15 => 'F', 16 => 'G', 17 => 'H', 18 => 'I',  
		    19 => 'J', 20 => 'K', 21 => 'L', 22 => 'M', 23 => 'N', 24 => 'O', 25 => 'P', 26 => 'Q', 27 => 'R',  
		    28 => 'S', 29 => 'T', 30 => 'U', 31 => 'V', 32 => 'W', 33 => 'X', 34 => 'Y', 35 => 'Z'  
		);  
	    $arr = array();  
	    $loop = true;  
	    while ($loop)   
	    {  
	        $arr[] = $dic[bcmod($int, 36)];  
	        $int = floor(bcdiv($int, 36));  
	        if($int == 0){  
	            $loop = false;  
	        }  
	    }  
	    array_pad($arr, $format, $dic[0]);  
	    return implode('', array_reverse($arr));  
	}

	//三十六进制转换十进制  
	public static function deid($id) {  
	    $dic = array(  
		    0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9',  
		    10 => 'A', 11 => 'B', 12 => 'C', 13 => 'D', 14 => 'E', 15 => 'F', 16 => 'G', 17 => 'H', 18 => 'I',  
		    19 => 'J', 20 => 'K', 21 => 'L', 22 => 'M', 23 => 'N', 24 => 'O', 25 => 'P', 26 => 'Q', 27 => 'R',  
		    28 => 'S', 29 => 'T', 30 => 'U', 31 => 'V', 32 => 'W', 33 => 'X', 34 => 'Y', 35 => 'Z'  
		);
	    // 键值交换  
	    $dedic = array_flip($dic);  
	    // 去零  
	    $id = ltrim($id, $dic[0]);  
	    // 反转  
	    $id = strrev($id);  
	    $v = 0;  
	    for($i = 0, $j = strlen($id); $i < $j; $i++)   
	    {
	    	if(!isset($dedic[$id{$i}]))
	    		return '';
	        $v = bcadd(bcmul($dedic[$id{$i}] , bcpow(36, $i)) , $v);  
	    }  
	    return $v;  
	}  
  
	// 遍历三位所有的三十六进制数  
	// $i = deid('ZZZ');  
	// $b = array();  
	// while ($i > 0) {  
	//     $id_dym = str_pad(enid($i), 3, 0, STR_PAD_LEFT);  
	//     echo strtolower($id_dym), '<br>';  
	//     $i--;  
	// }  

	/**
	 * 当前年份与入学年份之间的差值-（当前月<9?1:0）
	 * panrj 2014-08-08
	 * @var int $year 入学年份
	 * @return int $age 
	 */
	public static function getGradeAge($year)
	{
		$y = (int)Date("Y");
		$m = (int)Date("m");
		$d = (int)Date("d");
		$age = $y-$year;
		$age = ($m<8 || ($m==8 && $d<25))?$age-1:$age;
		return $age;
	}

	/**
	 * 二维数组滤重
	 * panrj 2014-10-27
	 * @var array $array
	 * @return array $array
	 */
	public static function multi_unique($array)
	{
        $new=array();
        $new1=array();
   		foreach ($array as $k=>$na){
   			$new[$k] = serialize($na);
   		}
        if(count($new)){
   		   $uniq = array_unique($new);
        }else{
            $uniq=array();
        }
   		foreach($uniq as $k=>$ser){
   			$new1[$k] = unserialize($ser);
   		}
   		return ($new1);
	}

	/**
	 * 根据年级计算入学年份
	 * panrj 2014-08-08
	 * @var int $age 当前年份与入学年份之间的差值-（当前月<9?1:0）
	 * @return int $year 
	 */
	public static function getClassYearByGradeAge($age)
	{
		$y = (int)Date("Y");
		$m = (int)Date("m");
		$d = (int)Date("d");
		// $age = $m<9?$age:$age-1;
		$year = $y-$age;
		$year = ($m<8 || ($m==8 && $d<25))?$year-1:$year;
		return $year;
	}

	/**
	 * 返回当前学期
	 * panrj 2014-09-30
	 * @return string $term 
	 */
	public static function getTermArr()
	{
		$y = (int)Date("Y");
		$m = (int)Date("m");
		$d = (int)Date("d");
		$year = ($m<8 || ($m==8 && $d<25))?($y-1).'至'.$y:$y.'至'.($y+1);
		$term = array(
			$year.'第一学期'=>$year.'第一学期',
			$year.'第二学期'=>$year.'第二学期',
		);
		return $term;
	}

    public  static function safe_string($str){ //过滤安全字符
        $str=str_replace("'","",$str);
        $str=str_replace('"',"",$str);
        $str=str_replace(" ",'&nbsp;',$str);
        $str=str_replace("\n;","<br/>",$str);
        $str=str_replace("<","<",$str);
        $str=str_replace("%","",$str);
        $str=str_replace("{","",$str);
        $str=str_replace("}","",$str);
        $str=str_replace(">",">",$str);
        $str=str_replace("\t"," ",$str);
        $str=str_replace("\r","",$str);
        $str=str_replace("/[\s\v]+/"," ",$str);
        return addslashes($str);
    }

    /**
	 * 多维数组按照子数组指定键值排序
	 * panrj 2014-08-22
	 * @var array $arr 要排序的数组
	 * @var string $keys 键名
	 * @var string $type 排序规则
	 * @return array $new_array 
	 */
    public static function array_subkey_sort($arr, $keys, $type='desc'){    
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v) {
			$keysvalue[$k] = $v[$keys];    
       	}  
		if($type=='asc'){  
			asort($keysvalue);     
		} else {   
			arsort($keysvalue);    
		}    
		reset($keysvalue);   
		foreach($keysvalue as $k=>$v){  
			$new_array[$k] = $arr[$k];    
		}    
		return $new_array; 
	}

	/** 
     * @desc 根据生日获取年龄 
     * @param     string $birthday 
     * @return    integer  
     */  
    public static function getAge($birthday) {  
    	if(!$birthday)
    		return 0;

        if($birthday<'1900-00-00'){
            return 0;
        }
        $date1 = new DateTime($birthday);
	    $date2 = new DateTime("now");
	    $interval = $date1->diff($date2);
	    $years = $interval->format('%y');
	    return $years;
    }
    
    //php获取中文字符拼音首字母
	public static function getFirstCharter($str){
	    if (empty($str))
            return '';
        $str = ltrim($str);
        $py = new PinYin();
        $pingying = $py->getFirstPY($str);
        if(!empty($pingying)){
            return strtoupper(substr($pingying, 0, 1));
        }
        return '';
	    $fchar = ord($str{0});
	    if($fchar>=ord('A') && $fchar<=ord('z')) return strtoupper($str{0});
	    $s1 = iconv('UTF-8', 'GBK', $str);
	    $s2 = iconv('GBK//IGNORE', 'UTF-8', $s1);
	    $s = $s2 == $str ? $s1 : $str;
        if (isset($s{1})) {
	        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        } else {
            $asc = ord($s{0}) * 256 - 65536;
        }
	    if($asc>=-20319&&$asc<=-20284) return 'A';
	    if($asc>=-20283&&$asc<=-19776) return 'B';
	    if($asc>=-19775&&$asc<=-19219) return 'C';
	    if($asc>=-19218&&$asc<=-18711) return 'D';
	    if($asc>=-18710&&$asc<=-18527) return 'E';
	    if($asc>=-18526&&$asc<=-18240) return 'F';
	    if($asc>=-18239&&$asc<=-17923) return 'G';
	    if($asc>=-17922&&$asc<=-17418) return 'H';
	    if($asc>=-17417&&$asc<=-16475) return 'J';
	    if($asc>=-16474&&$asc<=-16213) return 'K';
	    if($asc>=-16212&&$asc<=-15641) return 'L';
	    if($asc>=-15640&&$asc<=-15166) return 'M';
	    if($asc>=-15165&&$asc<=-14923) return 'N';
	    if($asc>=-14922&&$asc<=-14915) return 'O';
	    if($asc>=-14914&&$asc<=-14631) return 'P';
	    if($asc>=-14630&&$asc<=-14150) return 'Q';
	    if($asc>=-14149&&$asc<=-14091) return 'R';
	    if($asc>=-14090&&$asc<=-13319) return 'S';
	    if($asc>=-13318&&$asc<=-12839) return 'T';
	    if($asc>=-12838&&$asc<=-12557) return 'W';
	    if($asc>=-12556&&$asc<=-11848) return 'X';
	    if($asc>=-11847&&$asc<=-11056) return 'Y';
	    if($asc>=-11055&&$asc<=-10247) return 'Z';
	    return null;
	}

    public static function getCookie($name){
        $cookie = Yii::app()->request->getCookies();
        return $cookie[$name]?$cookie[$name]->value:'';
    }

    public static function setCookie($name,$value,$expire=2592000){
        $cookie = new CHttpCookie($name,$value);
        $cookie->expire = time()+$expire;
        Yii::app()->request->cookies[$name]=$cookie;
    }
    /*
     * 获取当天是当年的多少周
     */
   public static  function getWeekNow(){
    $datearr = getdate();
    $year = strtotime($datearr['year'].'-1-1');
    $startdate = getdate($year);
    $firstweekday = 7-$startdate['wday'];//获得第一周几天
    $yday = $datearr['yday']+1-$firstweekday;//今年的第几天
    return ceil($yday/7)+1;//取到第几周
}
    public static function getWeekDate($year,$weeknum){
        $firstdayofyear=mktime(0,0,0,1,1,$year);
        $firstweekday=date('N',$firstdayofyear);
        $firstweenum=date('W',$firstdayofyear);
        if($firstweenum==1){
            $day=(1-($firstweekday-1))+7*($weeknum-1);
            $startdate=date('Y-m-d',mktime(0,0,0,1,$day,$year));
            $enddate=date('Y-m-d',mktime(0,0,0,1,$day+6,$year));
        }else{
            $day=(9-$firstweekday)+7*($weeknum-1);
            $startdate=date('Y-m-d',mktime(0,0,0,1,$day,$year));
            $enddate=date('Y-m-d',mktime(0,0,0,1,$day+6,$year));
        }

        return array($startdate,$enddate);
    }
    /**
     * 获得当前年有多少个自然周
	     * @param year 输入的年份
	     * @return 总共的周数
     */
    public static function getWeeks($year) {
        $week = 0;
        $days = 365;
        if ($year % 400 == 0 || ($year % 4 == 0 && $year % 100 != 0))
        {//判断是否闰年，闰年366天
            $days = 366;
        }
       //得到一年所有天数然后除以7
        $week = $days / 7;//得到多少周
        return floor($week);
    }
    /*
     * 获取姓，排除复姓，英文这些
     */
    public static function getXing($name){

        $first=self::csubstr($name,0,1,"utf-8",false);
        if($first){
            if(preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$first)){
                return $first;
            }else{
                return '';
            }
        }
        return '';
    }

    public static function weekDay()
    {
    	$arr = array(
    		'1'=>'Mon',
			'2'=>'Tue',
			'3'=>'Wed',
			'4'=>'Thu',
			'5'=>'Fri',
			'6'=>'Sat',
			'7'=>'Sun',
    	);
    	return $arr;
    }

    /**
    *阿拉伯数字转换成中文数字
    *panrj,zengp 2014-11-11
    * @param num 输入的数字
    * @return 转换结果
    */
    function ToChinaseNum($num)
    {
	    $char = array("零","一","二","三","四","五","六","七","八","九");
	    $dw = array("","十","百","千","万","亿","兆");
	    $retval = "";
	    $proZero = false;
	    for($i = 0;$i < strlen($num);$i++){
 			if($i > 0)
 				$temp = (int)(($num % pow (10,$i+1)) / pow (10,$i));
 			else
 				$temp = (int)($num % pow (10,1));

		    if($proZero == true && $temp == 0) continue;

		    if($temp == 0)
		    	$proZero = true;
		    else 
		    	$proZero = false;

		    if($proZero){
		    	if($retval == "") continue;
		    	$retval = $char[$temp].$retval;
		    }else{
	    		$retval = $char[$temp].$dw[$i].$retval;
		    } 
	    }
	    if($retval == "一十")
			$retval = "十";
		
	    return $retval;
    }


    /**
    *获取当前登陆用户IP
    *zengp 2014-11-27
    * @return IP地址
    */
	public static function get_client_ip()
	{
		if ($_SERVER['REMOTE_ADDR']) {
			$cip = $_SERVER['REMOTE_ADDR'];
		} elseif (getenv("REMOTE_ADDR")) {
			$cip = getenv("REMOTE_ADDR");
		} elseif (getenv("HTTP_CLIENT_IP")) {
			$cip = getenv("HTTP_CLIENT_IP");
		} else {
			$cip = "unknown";
		}
		return $cip;
	}
    /*
     * 导入学生老师时，截取姓名
     * 全汉字 --8个
     * 否则<=20个
     */
    public static function getExportName($exportname){
        $name=trim($exportname);
        if(preg_match("/^[\x{4e00}-\x{9fa5}]+/u",trim($name))){ //全是汉字,最多取8个
            $name=self::csubstr($name,8);
        }else{
            $name=self::csubstr($name,20);
        }
    }
}