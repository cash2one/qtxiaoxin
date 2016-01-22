<?php

class YiicmsHelper
{

	/**
	 * @var string $message 显示内容
	 * @var array $url 路由
	 * @var int $delay 跳转时间
	 * @var $type 显示样式
	 * 所有Controller的重定向跳转
	 */
	public function redirectMessage($message, $url = '', $delay=3, $type = 'success' , $script='')
	{
		if($this->layout == 'main_sign')
		{
			$this->layout = 'main';
		}
		//$this->layout=false;

		if(is_array($url))
		{
			$route=isset($url[0]) ? $url[0] : '';
			$url=$this->createUrl($route,array_splice($url,1));
		}
		if(empty($url))
		{
			$url = Yii::app()->request->urlReferrer;
		}
		if(empty($url))
		{
			$url = Yii::app()->request->baseUrl;
		}
		if(empty($url))
		{
			$url = '/';
		}

		Yii::app()->controller->renderpartial('//redirect', array(
			'message' => $message,
			'url' => $url,
			'delay' => $delay,
			'script' => $script,
			'type' => $type,
		));
		exit;
	}

	/**
	 * @var string $message 显示内容
	 * @var array $url 路由
	 * @var int $delay 跳转时间
	 * @var $type 显示样式
	 * 所有Controller的重定向跳转
	 */
	public function redirectMessagePartial($message, $url = '', $delay=3, $type = 'success' , $script='')
	{
		if($this->layout == 'main_sign')
		{
			$this->layout = 'main';
		}
		//$this->layout=false;

		if(is_array($url))
		{
			$route=isset($url[0]) ? $url[0] : '';
			$url=$this->createUrl($route,array_splice($url,1));
		}
		if(empty($url))
		{
			$url = Yii::app()->request->urlReferrer;
		}
		if(empty($url))
		{
			$url = Yii::app()->request->baseUrl;
		}
		if(empty($url))
		{
			$url = '/';
		}

		Yii::app()->controller->render('redirect', array(
			'message' => $message,
			'url' => $url,
			'delay' => $delay,
			'script' => $script,
			'type' => $type,
		));
		exit;
	}

	static public function ok($message,$data="",$forwardUrl="")
	{
		YiicmsHelper::responseAjax($message,$type="ok",$notification="true",$forwardUrl,$callbackType,$data);
	}
	static public function error($message,$type='error',$notification='true',$forwardUrl='',$callbackType='closeCurrent')
	{
		if ($message instanceof CModel){
			if ($message->hasErrors()){
				$message=preg_replace("/\n/",'',CHtml::errorSummary($message));
			}else
				$message='';
		}
		YiicmsHelper::responseAjax($message,$type,$notification,$forwardUrl,$callbackType);
	}

	static public function responseAjax($message,$type='ok',$notification='true',$forwardUrl='',$callbackType='',$data='')
	{

		$array = array(
			"type"=>$type,
			"message"=>$message,
			"notification"=>$notification,
			"callbackType"=>$callbackType,
			"forwardUrl"=>$forwardUrl,
			"data"=>$data,
		);
		if(Yii::app()->request->isAjaxRequest)
		{
			echo CJSON::encode($array);
			Yii::app()->end();
		}
	}



	/**
	 * 导出excel文件,
	 * 导出Excel5格式的XLS文件
	 *
	 * 在所有继承BaseController的Controller都可以调用本方法
	 *
	 * @param string $filename 文件名
	 * @param array $data 数据内容,二维数组
	 * @param array $name_arr 数据标题,与$data的二维数组的项目一一对应
	 * @return Void 无返回值,打开浏览器的下载页面
	 * -----------------------------------------------
		$static_array = array(
			1 => array('南山区','育合测试学校',0,0,0,0,0,0,0,,0,0,)
		);
		$filename = '学校vip数据';
		$name_arr = array(
			'区域','学校','总人数','定制vip人数','缴费人数','缴费金额','已审核记录数','已审核金额数','待审核记录数','待审核金额数'
		);
		$this->downloadXls($filename,$static_array,$name_arr);

	 * -----------------------------------------------
	 * @author Biner
	 * @date 2010-5-8
	 * @package PHPExcel
	 */
	public function downloadXls($filename,$data = array(),$name_arr = array(),$file_root = '',$data2=array(),$name_arr2 = array()) {

		require_once('PHPExcel/IOFactory.php');
		require_once('PHPExcel/Writer/Excel5.php');

		if(empty($data))
		{
			self::redirectMessage('空数据，无法导出！');
		}
		if(count($data[0]) != count($name_arr))
		{
			#die('导出项目标题和数据项数目不一样。');
		}

		//清掉PHP缓冲区
		ob_clean();

		// 创建一个处理对象实例
		$objExcel = new PHPExcel();
		// 创建文件格式写入对象实例, uncomment
		$objWriter = new PHPExcel_Writer_Excel5($objExcel);// 用于其他版本格式

		$objExcel ->setActiveSheetIndex(0);

		$objActSheet  = $objExcel ->getActiveSheet();
		$objActSheet->setTitle('Sheet1');

		$outputFileName  = $filename.".xls" ;

		if(!empty($data))
		{
			$row_array = array('A','B','C','D','E','F','G'

				,'H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			//excel 表格 头
			if(!empty($name_arr))
			{
				$row = 1;
				$i = 0;
				foreach($name_arr as $name)
				{
					$objActSheet ->setCellValue($row_array[$i].$row , $name);
					$i ++;
				}
			}

			foreach($data as $key => $array)
			{
				$row = $key + 2;
				$i = 0;
				foreach($array as $one)
				{
					$objActSheet ->setCellValue($row_array[$i].$row , $one);
					$i ++;
				}
			}
		}

		//卜智平添加
		if(!empty($data2))
		{
			$objExcel ->createSheet();
			$objExcel ->setActiveSheetIndex(1);

			$objActSheet2  = $objExcel->getActiveSheet();
			$objActSheet2->setTitle('Sheet2');

			$row_array2 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
			//excel 表格 头
			if(!empty($name_arr2))
			{
				$row = 1;
				$i = 0;
				foreach($name_arr2 as $name2)
				{
					$objActSheet2 ->setCellValue($row_array2[$i].$row , $name2);
					$i ++;
				}
			}

			foreach($data2 as $key => $array2)
			{
				$row = $key + 2;
				$i = 0;
				foreach($array2 as $one2)
				{
					$objActSheet2->setCellValue($row_array2[$i].$row , $one2);
					if($i==8 && str_replace('%','',$one2) > 50)
					{
						$objActSheet2->getStyle($row_array2[$i].$row)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
					}
					$i ++;
				}
			}
		}

		//到文件
		if(!empty($file_root))
		{
			$objWriter->save($file_root);
			return true;
		}

		//
		//or
		//到浏览器
		$ua = $_SERVER["HTTP_USER_AGENT"];

		$filename = $outputFileName;
		$encoded_filename = urlencode($filename);
		$encoded_filename = str_replace("+", "%20", $encoded_filename);

		header("Content-type: text/html; charset=utf-8");
		//header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		//header("Content-Type: application/download");

		//header('Content-Disposition:inline;filename="'.$outputFileName.'"');
		if (preg_match("/MSIE/", $ua)) {
		header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
		} else if (preg_match("/Firefox/", $ua)) {
		header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
		} else {
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		}


		header("Content-Transfer-Encoding: binary");

	    //header('Cache-Control: no-store, no-cache, must-revalidate');
	    $expire = 180;
	    header("Expires: " . gmdate("D, d M Y H:i:s",time()+$expire) . "GMT");
	    header("Last-Modified: " . gmdate("D, d M Y H:i:s",time()) . "GMT");

		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");

		$objWriter->save('php://output');
		exit();

	}
	/**
	 * @var string $string 内容
	 * @var boolean $purifyOutput 是否过滤HTML
	 * 格式化数据内容，过滤html
	 */
	static function CMarkdown($string,$purifyOutput = false)
	{
		$m = new CMarkdownParser;
		$output = $m->transform($string);
		if($purifyOutput)
		{
			$purifier=new CHtmlPurifier;
			$output=$purifier->purify($output);
		}
		return $output;

		Yii::app()->controller->beginWidget('CMarkdown', array('purifyOutput'=>$purifyOutput));
			echo $string;
		Yii::app()->controller->endWidget();
	}

	/**
	 +----------------------------------------------------------
	 * 下载文件
	 * 可以指定下载显示的文件名，并自动发送相应的Header信息
	 * 如果指定了参content数，则下载该参数的内容
	+----------------------------------------------------------
	 * @static
	 * @access public
	 +----------------------------------------------------------
	 * @param string $filename 下载文件名
	 * @param string $showname 下载显示的文件名
	 * @param string $content  下载的内容
	 * @param integer $expire  下载内容浏览器缓存时间
	 +----------------------------------------------------------
	 * @return void
	 +----------------------------------------------------------
	 * @throws ThinkExecption
	 +----------------------------------------------------------
	 */
	static public function download ($filename, $showname='',$content='',$expire=180) {
	    if(is_file($filename)) {
	        $length = filesize($filename);
	    }elseif(is_file(UPLOAD_PATH.$filename)) {
	        $filename = UPLOAD_PATH.$filename;
	        $length = filesize($filename);
	    }elseif($content != '') {
	        $length = strlen($content);
	    }else {
	        throw_exception($filename.L('下载文件不存在！'));
	    }
	    if(empty($showname)) {
	        $showname = $filename;
	        $showname = basename($showname);
	    }
	    if(!empty($filename)) {
	        $type = mime_content_type($filename);
	    }else{
	        $type    =   "application/octet-stream";
	    }
	    //发送Http Header信息 开始下载
	    header("Pragma: public");
	    header("Cache-control: max-age=".$expire);
	    //header('Cache-Control: no-store, no-cache, must-revalidate');
	    header("Expires: " . gmdate("D, d M Y H:i:s",time()+$expire) . "GMT");
	    header("Last-Modified: " . gmdate("D, d M Y H:i:s",time()) . "GMT");
	    header("Content-Disposition: attachment; filename=".$showname);
	    header("Content-Length: ".$length);
	    header("Content-type: ".$type);
	    header('Content-Encoding: none');
	    header("Content-Transfer-Encoding: binary" );
	    if($content == '' ) {
	        readfile($filename);
	    }else {
	        echo($content);
	    }
	    exit();
	}
}
