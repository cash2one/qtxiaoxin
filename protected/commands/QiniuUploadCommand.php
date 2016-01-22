<?php
/**
 * 命令行下的图片上传脚本工具
 * 
 * 使用一个临时图片表，进行上传到七牛云，并把上传结果记录下来。
 * 上传完后，可使用临时表进行匹配 其他正文里的本地图片路径 转成 七牛云图片路径
 * 
 * 使用命令方法：
 *         1、 yiic qiniuupload ready         准备数据到临时表
 *         2、 yiic qiniuupload upload        把临时表中的图片数据上传到七牛,必须准备图片文件夹到本地配置目录
 *         3、 yiic qiniuupload import        导入消息数据，使用临时表中的图片映射七牛路径替换
 * 
 * 
 * 临时表结构:
 * 
    CREATE TABLE `qiniu_upload` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `fid` int(10) unsigned NOT NULL COMMENT 'business_new.tb_focus',
      `paths` varchar(200) NOT NULL COMMENT '图片路径',
      `srckey` varchar(200) NOT NULL COMMENT '完整源图片路径',
      `md5key` char(32) NOT NULL COMMENT 'MD5作为key',
      `qiniu` char(35) NOT NULL DEFAULT '' COMMENT '上传七牛的图片名称',
      `width` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传七牛图片的宽',
      `height` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传七牛图片的高',
      `upload` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否上传七牛完毕 0:未上传 1:已上传',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
 * 
 * @author ld 2015-1-8 18:02
 */


/**
 * 表名配置
 * @author ld
 *
 */
class TableImport
{
    const UPLOAD_TABLE_NAME = '`official_account`.`qiniu_upload`';  // 七牛的临时转换图片地址表名
    const TABLE_NAME_IMPORT = '`business_new`.`tb_focus`';      // 将导入的数据来源表
    const TABLE_NAME_IMPORT_RELATE = '`business_new`.`tb_contract_focus_relation`';      // 将导入的数据来源关联表
    
    const TABLE_NAME_MESSAGE = '`official_account`.`op_message`';   // 消息的标题表
    const TABLE_NAME_CONTENT = '`official_account`.`op_content`';   // 消息的正文表
    const TABLE_NAME_SEND = '`official_account`.`op_send`';         // 发布转载表
    
    const OFFICIAL_ACCOUNT_ID = '0';                         //要插入的公众号id
}

/**
 * 七牛上传导入数据表的主接口
 * @author ld
 *
 */
class QiniuUploadCommand extends CConsoleCommand
{
    const UPLOAD_DOMAIN = 'http://up.qiniu.com';        // 上传的七牛图片地址
    const IMAGE_DIR = '';                               // 读取要上传的图片本地地址目录，和表里一样名称的图片名，将上传七牛
    
    const ROW_SIZE = 5000;                              // 查询的记录最大上限
    
    const HTTP_TIME_OUT = 2 ;                          // 网络获取图片超时秒数 
    
    /*
     * 命令入口
     * @see CConsoleCommand::run()
     */
    public function run($args)
    {
        if( false == is_array($args)){
            echo 'not argument!';
            return false;
        }
        
        switch ($args)
        {
            case in_array('upload', $args):
                $this->putData();
                break;
            case in_array('ready', $args):
                $imageData = new ImportImageData();
                $imageData->import();
                break;
            case in_array('import', $args):
                $imageData = new ImportImageData();
                $imageData->insertMsgData();
                break;
            default:
                echo 'not action!';
                break;
        }

    }
    
    /**
     * 对表的最大记录数检查限定
     */
    protected function checkTableCount()
    {
        $sql = 'SELECT count(*) AS total FROM '.TableImport::UPLOAD_TABLE_NAME;
        
        $connection=Yii::app()->db_official;
        
        $command = $connection->createCommand($sql);
        
        $row = $command->queryRow();
        
        $row['total'] = true == isset($row['total']) ? $row['total'] : 0 ;
         
        if( $row['total'] >= self::ROW_SIZE ){
           exit('please fix class '.get_class($this).' ROW_SIZE max value !');            
        }
    }
    
    /**
     * 读取表里数据1000条，上传到七牛云中
     */
    protected function getImagePaths()
    {
        $this->checkTableCount();
        
        $sql = 'SELECT * FROM '.TableImport::UPLOAD_TABLE_NAME.' WHERE upload != 1 ';
        
        $connection=Yii::app()->db_official;

        $command = $connection->createCommand($sql);
        
        $dataReader=$command->query();
        
        return $dataReader->readAll();
    }
    
    /**
     * 标记上传没有成功
     * @param int $id
     * @param int $value
     */
    protected function updateImageTableFaild( $id, $value )
    {
        $sql = 'UPDATE '.TableImport::UPLOAD_TABLE_NAME.' SET  upload = \''.$value.'\' WHERE id=\''.$id.'\'';
        $connection=Yii::app()->db_official;
        $command = $connection->createCommand($sql);
        
        return $command->execute();
    }
    
    /**
     * 把每条上传七牛的图片结果存回上传临时表
     * @param int $id 原要转换的数据表中的主键
     * @param array $data 七牛返回的json解释数组
     * @return boolean
     */
    protected function updateImageTable( $id, $data )
    {
        if( false == $id || false == $data ){
            echo 'not id or qiniu json!';
            
            return false;
        }
        
        if( false == isset($data['w']) || false == isset($data['h']) ){
            echo 'not width or height in qiniu json !';
            
            return false;
        }
        
        $sql = 'UPDATE '.TableImport::UPLOAD_TABLE_NAME.' SET  qiniu=\''
                    .$data['key'].'\', upload = 1 ,width=\''.$data['w'].'\',height=\''.$data['h'].'\' WHERE id=\''.$id.'\'';
        $connection=Yii::app()->db_official;
        $command = $connection->createCommand($sql);
        
        return $command->execute();
    }
    
    protected function getRemoteLocalImg( $row )
    {
        if( false == isset( $row['srckey'] ) || false == isset( $row['paths'] ) ){
            return '';
        }
        
        $url = parse_url( $row['srckey'] );
        
        if( true == isset($url['host']) && true == $url['host'] ){
            return $this->httpGetData( $row['srckey'] );
        }
        else
        {
            if( false == self::IMAGE_DIR ){
            
                $imagePath = dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.$row['paths'];
            }
            else{
                $imagePath = self::IMAGE_DIR.$row['paths'];
            }
            
            if( true == file_exists( $imagePath ) ){
                
                return @file_get_contents( $imagePath );;
            }
            else {
                return '';
            }
        }
        
    }
    
    /**
     * 把表里的图片路径读取并进行上传到七牛云
     */
    protected function putData()
    {
        $paths = $this->getImagePaths();    // 读取图片数据
        
        foreach( $paths as $key=>$value  )
        {
            $binaryImage = $this->getRemoteLocalImg( $value );
            
            if( true == $binaryImage && true == isset($value['id']) ){
                
                if( false == $binaryImage ){
                    $this->updateImageTableFaild( $value['id'], -1 );
                }
                else  {
                    $str = $this->uploadCurl(  $value['paths'], $binaryImage );
    
                    $decodeData = json_decode( $str, true);
                    if( null !== $decodeData && true == isset( $decodeData['w'] ) 
                        && true == isset( $decodeData['h'] ) && true == isset( $decodeData['key'] )  ) {
                        $this->updateImageTable( $value['id'], $decodeData );
                    }
                    else{
                        $this->updateImageTableFaild( $value['id'], -2 );
                    }
                }
            }
            else{
                $this->updateImageTableFaild( $value['id'], -3 );
            }
            
           QiniuLoading::show($paths);
        }
    }

    /**
     * 获取七牛的上传令牌
     * @return string
     */
    protected function getToken()
    {
        require_once (Yii::app()->basePath . '/extensions/qiniu/qiniuphp/rs.php');
        require_once (Yii::app()->basePath . '/config/Constants.php');
        
        $accessKey = STORAGE_QINNIU_ACCESSKEY;
        $secretKey = STORAGE_QINNIU_SECRETKEY;
        
        Qiniu_SetKeys($accessKey, $secretKey);
        $putPolicy = new Qiniu_RS_PutPolicy(STORAGE_QINNIU_BUCKET_XX);
        
        $putPolicy->ReturnBody = '{"key": $(key),"w": $(imageInfo.width),"h": $(imageInfo.height)}';
        
        return $putPolicy->Token(null);
    }

    /**
     * http协议post数据上传文件
     * @param string $url
     * @param string $post
     * @param string $file
     * @return string
     */
    protected function sendFile($url, $post = '', $file = '')
    {
        $eol = "\r\n";
        $mime_boundary = md5(time());
        $data = '';
        $confirmation = '';
        
        date_default_timezone_set("Asia/Shanghai");
        $time = date("Y-m-d H:i:s ");
        $post["filename"] = $file['filename'];
        
        foreach ($post as $key => $value) {
            $data .= '--' . $mime_boundary . $eol;
            $data .= 'Content-Disposition: form-data; ';
            $data .= "name=" . $key . $eol . $eol;
            $data .= $value . $eol;
        }
        
        $data .= '--' . $mime_boundary . $eol;
        $data .= 'Content-Disposition: form-data; name=file; filename=' . $file['filename'] . $eol;
        $data .= 'Content-Type: text/plain' . $eol;
        $data .= 'Content-Transfer-Encoding: binary' . $eol . $eol;
        $data .= $file['filedata'] . $eol;
        $data .= "--" . $mime_boundary . "--" . $eol . $eol;
        
        $params = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: multipart/form-data;boundary=' . $mime_boundary . $eol,
                'content' => $data, 
                'timeout'=>self::HTTP_TIME_OUT
            )
        );
        
        $ctx = stream_context_create($params);
        $response = file_get_contents($url, FILE_TEXT, $ctx);
        
        if( false == $response ){    // 超时再试2次
            $cnt=0;
            while($cnt < 1 && ($response=@file_get_contents( $url, false, $ctx ))===FALSE) $cnt++;
        }
        
        return $response;
    }
    
    
    protected function uploadCurl( $imageName, $data )
    {
        file_put_contents( dirname(dirname(__FILE__)).'/runtime/img_temp.bin', $data);
        
        $uniqImageName = uniqid();
        $uniqImageName = 'c_'.substr(md5($uniqImageName . rand()), 18) . $uniqImageName . substr($imageName, - 4);
        
        $fields = array(
            'name' => $uniqImageName,
            'chunk' => '0',
            'chunks' => '1',
            'key' => $uniqImageName,
            'token' => $this->getToken()
        );
    
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_SAFE_UPLOAD, false);
        $fields ['file'] = '@' . dirname(dirname(__FILE__)).'/runtime/img_temp.bin';
        curl_setopt ( $ch, CURLOPT_URL, "http://up.qiniu.com" );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $response = curl_exec ( $ch );
        curl_close($ch);
    
        return $response;
        
    }
    
    protected function httpGetData($url)
    {
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,5);
        curl_setopt ( $ch, CURLOPT_URL, $url );
        ob_start ();
        curl_exec ( $ch );
        $return_content = ob_get_contents ();
        ob_end_clean ();
    
        $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
    
        return $return_content;
    }
    

    /**
     * 对上传七牛云的图片进行参数封装
     * @param string $imageName 图片的本地路径，方便获取后缀名
     * @param binary $data 二进制图片数据
     * @return string
     */
    protected function upload($imageName, $data)
    {
        $uniqImageName = uniqid();
        $uniqImageName = 'c_'.substr(md5($uniqImageName . rand()), 18) . $uniqImageName . substr($imageName, - 4);
        return $this->sendFile( self::UPLOAD_DOMAIN, array(
            'name' => $uniqImageName,
            'chunk' => '0',
            'chunks' => '1',
            'key' => $uniqImageName,
            'token' => $this->getToken()
        ), array(
            'filename' => 'rand.jpg',
            'filedata' => $data
        ))
        ;
    }
}

/**
 * 采集图片数据入临时七牛上传表
 * @author ld
 * @todo 导入的效率为逐条，可优化未多条合并sql导入。
 */
class ImportImageData
{

    
    protected $width = 0;
    protected $height = 0;
    
    /**
     * 导入图片数据入库
     * @param array $data
     * @return boolean
     */
    public function importData( $data , $table = TableImport::UPLOAD_TABLE_NAME )
    {
        $fields = array_keys( $data );
        $values = array_values( $data );

        $field = join(',', $fields);

        $value = join('\',\'', $values);

        $sql = 'INSERT '.$table.' ('.$field.')  VALUES(\''.$value.'\')';
    
        $connection=Yii::app()->db_official;
    
        $command = $connection->createCommand($sql);
    
        return $command->execute();
    }
    
    /**
     * 使用封面图导入入库
     * @todo 这里采用逐条insert入库，可优化采用合并多条导入入库
     * @param array $v
     */
    protected function importCover( $v )
    {
        if( true == isset($v['image']) && true == isset($v['fid']) ){
            $field = array();
            $images = parse_url( $v['image']);
    
            if( true == isset($images['path']) && true == $images['path'] ){
                $field['paths'] = trim($images['path']);
                $field['srckey'] = trim($v['image']);
                $field['md5key'] = md5($field['srckey']);
                $field['fid'] = $v['fid'];
    
                $this->importData( $field );
            }
        }
    }
    
    /**
     * 分析正文图片导入
     * @todo 这里采用逐条insert入库，可优化采用合并多条导入入库
     * @param array $v
     */
    protected function importContentImage( $v )
    {
        if(  true == isset($v['text']) && true == isset($v['fid']) ){
            $field = array();
            preg_match_all('/<img.+src=\"(.+)\".*>/isU', $v['text'], $imgMatch);
    
            if( true == isset( $imgMatch[1] ) && true == is_array( $imgMatch[1] ) ){
    
                foreach( $imgMatch[1] as $key=>$value ){
                    $images= parse_url( $value );
    
                    if( true == isset($images['path']) ){
                        $field['paths'] = trim($images['path']);
                        $field['srckey'] = trim( $value );
                        $field['md5key'] = md5($field['srckey']);
                        $field['fid'] = $v['fid'];
    
                        $this->importData( $field );
                    }
                }
            }
        }
    }
    
    /**
     * 整合导入数据，分封面图和正文图导入
     * @return boolean
     */
    public function import()
    {
        $data = $this->selectImportData();
    
        if( false == $data ){
            echo 'not table data!';
            
            return false;
        }
    
        foreach ($data as $k=>$v )
        {
            $this->importCover($v);
    
            $this->importContentImage( $v );
            
            QiniuLoading::show($data);
        }
    }
    
    /**
     * 获取 导入数据查询
     * @return array | boolean
     */
    public function selectImportData()
    {
        $sql = 'SELECT i.*, r.startdate FROM '.TableImport::TABLE_NAME_IMPORT.' i INNER JOIN '
                    .TableImport::TABLE_NAME_IMPORT_RELATE.' r ON i.fid = r.fid WHERE r.deleted = 0 AND i.deleted=0 ORDER BY r.startdate ASC';
    
        $connection=Yii::app()->db_official;
    
        $command = $connection->createCommand($sql);
    
        $dataReader=$command->query();
    
        return $dataReader->readAll();
    }
    
    /**
     * 获取映射的七牛和替换图片地址
     * @return string
     */
    public function getImageMap( $image )
    {
        if( false == $image ){
            return false;
        }
        
        $sql = 'SELECT * FROM '.TableImport::UPLOAD_TABLE_NAME.' WHERE srckey = \''.trim( $image ).'\'';
    
        $connection=Yii::app()->db_official;
    
        $command = $connection->createCommand($sql);
    
        $row = $command->queryRow();
        
        if( false == $row ){
            return $image;
        }
    
        $this->width = true == isset( $row['width'] ) ? $row['width']:0;
        $this->height = true == isset( $row['height'])? $row['height']:0;
        
        require_once (Yii::app()->basePath . '/config/Constants.php');
        
        return $row['qiniu'] = true == isset($row['qiniu'])&& true == $row['qiniu'] ? STORAGE_QINNIU_XIAOXIN_XX.$row['qiniu']:$image;
    }
    
    /**
     * 组合一个规定格式的数组
     *
     * @param array $contentArray
     * @param string $match
     * @return array
     */
    protected function generateArray($contentArray, $match)
    {
        $data = array();
        foreach ($contentArray as $k => $v) {
    
            if (true == trim(strip_tags($v))) {
                $data[] = array(
                    'type' => 'text',
                    'content' => strip_tags(html_entity_decode( $v ) )
                );
            }
    
            if (true == isset($match[1][$k]) && true == trim($match[1][$k])) {
    
                $image = $this->getImageMap( $match[1][$k] );
    
                $data[] = array(
                    'type' => 'image',
                    'content' => $image,
                    'width' => $this->width,
                    'height' => $this->height
                );
            }
        }
    
        return $data;
    }
    
    
    /**
     * 使用图片标签分隔字符串
     * @param string $inputContent
     * @return array
     */
    public function formtContentArray( $inputContent )
    {
        $data = $match = array();
        preg_match_all('/<p[^>]*>(.+)<\/p>/isU', $inputContent, $match);
    
        if (true == isset($match[1])) {
            foreach ((array) $match[1] as $content) {
                $contentArray = preg_split('/(<img).+>/isU', $content);
    
                preg_match_all('/<img.+src=\"(.+)\".*>/isU', $content, $imgMatch);
                
                $data = array_merge( $data, $this->generateArray( $contentArray, $imgMatch ) );
            }
        }
    
        return array('item'=>$data);
    }
    

    /**
     * 发布消息
     * @param int $msgid
     * @return boolean
     */
    protected function publishMsg( $msgid, $publishTime )
    {
        if( false == $msgid  ){
            return false;
        }
        
        $data['infoid'] = TableImport::OFFICIAL_ACCOUNT_ID;
        $data['msgid'] = (int)$msgid;
        $data['forward'] = 2;       // 2 已发布
        $data['publishtime'] = $publishTime;
        $data['updatetime'] = date('Y-m-d H:i:s');
        $data['creationtime'] = date('Y-m-d H:i:s');
        
        $this->importData($data, TableImport::TABLE_NAME_SEND);
    }
    
    /**
     * 插入消息内容
     * @return boolean
     */
    public function insertMsgData()
    {
        $data = $this->selectImportData();
        
        if( false == $data ){
            echo 'not table data!'; 
            
            return false;
        }
        
        foreach ( $data as $key=>$value ){
            $this->width = true == isset($value['width'])?$value['width']:0;
            $this->height = true == isset($value['height'])?$value['height']:0;
            
            $field = array();
            $field['title'] = true == isset( $value['title'] )? $value['title']:'';
            $field['subhead'] = true == isset($value['summery'])? $value['summery']:'';
            $value['image'] = true == isset($value['image'])?$value['image']:'';
            $field['cover'] = $this->getImageMap( $value['image'] );
            $field['msgfrom'] = '';
            $field['infoid'] = TableImport::OFFICIAL_ACCOUNT_ID;
            $field['send'] = 2;     // 2 已发布状态
            $publishTime = true == isset($value['startdate']) && true == $value['startdate'] ? $value['startdate']:date('Y-m-d H:i:s');
            $field['publishtime'] = $publishTime;
            $field['updatetime'] = true == isset($value['updatetime'])? $value['updatetime']:'';
            $field['creationtime'] = true == isset($value['creationtime'])? $value['creationtime']:'';
            
            
            $transaction = Yii::app()->db_official->beginTransaction();
            
            try
            {
                $this->importData($field, TableImport::TABLE_NAME_MESSAGE);
                
                $field = array();
                
                $field['msgid'] = Yii::app()->db_official->getLastInsertID();
                
                $field['content'] = json_encode( $this->formtContentArray( $value['text']) 
                                                    , JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE);
                
                $this->importData($field, TableImport::TABLE_NAME_CONTENT);
                
                $this->publishMsg( $field['msgid'], $publishTime );
                
                $transaction->commit();
            }
            catch(Exception $e)
            {
                $transaction->rollBack();
            }
            
           QiniuLoading::show($data);
        }
    }
}

/**
 *
 * 执行的进度条
 */
class QiniuLoading
{
    protected static $count = -1;
    protected static $complete = 1;
    
    public static function show( $data )
    {
        $total = count($data);
        self::$count ++;
        
        if( floor($total/10) == self::$count   ){
            self::$count = 0;
            echo '.';
        }
        
        if( self::$count == -1 ){
            echo '.';
        }
        
        self::$complete ++;
        
        if( self::$complete == $total ){
            echo 'complete!';
        }
    }
}