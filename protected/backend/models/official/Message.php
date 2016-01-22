<?php

/**
 * This is the model class for table "{{message}}".
 *
 * The followings are the available columns in table '{{message}}':
 * @property string $msgid
 * @property string $title
 * @property string $subhead
 * @property string $infoid
 * @property integer $forward
 * @property integer $deleted
 * @property integer $send
 * @property string $sendtime
 * @property string $updatetime
 * @property string $creationtime
 */
class Message extends OfficialActiveRecord
{
    const LOGIC_DELETE = 1;         // 逻辑删除
    const LOGIC_NOT_DELETE = 0;         // 逻辑没删除
    const BLOCK_MSG = 1;           //封住消息
    const UNBLOCK_MSG = 2;     // 解封消息
    const LIST_PAGE_SIZE = 10;  //消息列表的页行数
    const MSG_NOT_PUBLISH = 1;    // 未发布消息
    const MSG_PUBLISH = 2;      // 已发布消息
    const MSG_PUBLISH_ERROR = 3;        // 发布错误
    const MSG_NOT_FORWARD = 1;   // 未转发
    const MSG_FORWARD = 2;          // 已转发
    const NOT_ORIGINAL = 0;          // send表非原创发布

    const MSG_NOT_CLOSE = 1;            // 未封贴
    const MSG_CLOSE = 2;            // 已封贴

    const DEFAULT_DATE_TIME =  '2001-01-01 00:00:00';  // 数据表中的默认时间

    const IMAGE_INFO_URL_MARK = '@'; // 七牛云图片地址后接的图片宽高标识符

    protected static $nowDateTime = '';

    public $title;
    public $subhead;
    public $cover;
    public $content;
    public $sendtime;

    protected $isPublished = false;

    public function __construct($scenario='insert')
    {
        self::$nowDateTime = date('Y-m-d H:i:s');
        parent::__construct($scenario);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{message}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, infoid', 'required'),
            array('forward, deleted, send, infoid, close', 'numerical', 'integerOnly'=>true),
            array('title', 'length', 'max'=>200),
            array('subhead', 'length', 'max'=>300),
            array('infoid', 'checkPublished', 'on'=>'publish'),       // 验证是否已发布
            array('infoid', 'checkPublishFreq', 'on'=>'publish'),       // 验证是否今天发布满
            array('sendtime', 'checkTimeFormt'),
            array(' updatetime, creationtime, publishtime', 'safe'),
        );
    }

    /**
     * 模型验证发布次数使用用完 freq 键存储错误
     * @param array $attribute
     * @param array $params
     */
    public function checkPublishFreq( $attribute, $params )
    {
        $freq = new SendFreq();

        if( 0 == $freq->limitMsgCount($this->infoid) ){
            $this->addError('freq', '发送次数'.$freq->getOfficialAccoutFreq($this->infoid).'次已用完。');
        }
    }

    /**
     * 模型验证是发布过该条消息
     * @param array $attribute
     * @param array $params
     */
    public function checkPublished( $attribute, $params )
    {
        $criteria = new CDbCriteria();
        $criteria->condition = 'msgid=:msgid';
        $criteria->params=array( ':msgid' => $this->msgid );
        $criteria->addCondition( 'infoid='.(int)$this->infoid  );
        $criteria->addCondition( 'publishtime > 0');
        $criteria->addCondition( 'send = '.self::MSG_FORWARD );

        if( true == $this->count( $criteria ) ) {
            $this->addError('published', '信息已发布过');
        }
    }

    /**
     * 验证发送时间格式是否正确
     * @param array $attribute
     * @param array $params
     */
    public function checkTimeFormt( $attribute, $params )
    {
        if ( false == strtotime($this->sendtime) )
        {
            $this->addError('sendtime','发送时间格式错误!');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'offic' => array(self::BELONGS_TO, 'OfficialInfo', 'infoid'),
            'con' => array(self::HAS_ONE, 'Content', 'msgid'),
            'sen' => array(self::HAS_ONE, 'Send', 'msgid', 'on'=>'sen.byinfoid >'.Message::NOT_ORIGINAL),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'msgid' => '消息主键',
            'title' => '标题',
            'subhead' => '副标题',
            'infoid' => '公众号主键',
            'forward' => '转发状态',
            'deleted' => '已删除',
            'send' => '发布状态',
            'sendtime' => '发布时间',
            'updatetime' => '更新时间',
            'creationtime' => '创建时间',
            'close' => '封贴状态',
        );
    }

    /**
     * 消息列表分页数据
     * panrj,zengp 2014-11-28
     * @param array $parms 查询条件及分页参数
     * @return array $result
     */
    public function pageData($parms=array())
    {
        $result = array();
        $criteria = new CDbCriteria();
        $criteria->with = array('offic');
        if(isset($parms['send']) && $parms['send']!=''){
            if($parms['send'] == 4)
                $criteria->compare('t.close',2);
            else
                $criteria->compare('t.send',$parms['send']);
        }

        if(isset($parms['openid']) && $parms['openid']!=''){
            $criteria->addSearchCondition('offic.openid',$parms['openid']);
        }

        if(isset($parms['title']) && $parms['title']!=''){
            $criteria->addSearchCondition('t.title',$parms['title']);
        }
        /**
         * 添加可选参数 infoid
         * lhp 2014-12-04
         */
        if (isset($parms['infoid']) && $parms['infoid'] != '') {
            $criteria->compare('t.infoid', $parms['infoid']);
        }
        $criteria->compare( 't.deleted', 0 );
        $criteria->compare( 'offic.deleted', 0 );

        $criteria->order = 't.creationtime DESC';
        $count = self::model()->count($criteria);
        $pager = new CPagination($count);
        if(isset($parms['size']) && $parms['size']){
            $pager->pageSize = $parms['size'];
        }else{
            $pager->pageSize = 50;
        }
        $pager->applyLimit($criteria);

        $datalist = self::model()->findAll($criteria);

        $result['model'] = $datalist;
        $result['pages'] = $pager;

        return $result;
    }

    /**
     * 解/封贴
     * zengp 2014-12-01
     * @param string $msgid
     * @param string $reason 封解号理由
     * @return json $result
     */
    public static function msgLock($msgid,$reason)
    {
        $result = array('state'=>false,'type'=>'','block'=>'');
        $model=Message::model()->findByPk($msgid);

        $closelog = new CloseLog;
        $closelog->msgid = $msgid;
        $closelog->reason = $reason;
        if($model->send == 2 && $model->close == 2){
            $closelog->close = 1;
            $model->close = 1;
            $result['type'] = '1';
            $result['block'] = '2';
        }else if($model->send == 2 && $model->close == 1){
            $closelog->close = 2;
            $model->close = 2;
            $result['type'] = '2';
            $result['block'] = '1';
        }

        $model->save();
        $closelog->save();

        $result['state'] = true;

        return json_encode($result);
    }

    public function getUnForwardMsg($infoid)
    {
        $connection = Yii::app()->db_official;
        $sql = "SELECT t.msgid,t.title,t.subhead,t.infoid,t.cover,t.publishtime,ooi.openname FROM op_message AS t LEFT OUTER JOIN op_official_info AS ooi ON (t.infoid = ooi.infoid) WHERE t.msgid NOT IN (SELECT os.msgid FROM op_send AS os WHERE os.infoid != {$infoid}) AND t.infoid <> {$infoid} LIMIT 10";
        $result['data'] = $connection->createCommand($sql)->queryAll();
        return $result;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Fans the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 转换为空系统的默认时间
     * @param $dateTime
     * @return string
     */
    public static function defaultTime( $dateTime )
    {
        return strtotime( $dateTime ) == strtotime( self::DEFAULT_DATE_TIME )?'':$dateTime ;
    }

    /**
     * 把时间转换成中文提示时间，并过滤系统默认时间
     * @param $dateTime
     * @return bool|string
     */
    public static function formatTime( $dateTime )
    {
        if( strtotime( $dateTime ) == strtotime( self::DEFAULT_DATE_TIME )  )
        {
            return '';
        }
        else
        {
            return  date("Y年n月j日 H:i", strtotime( $dateTime ));
        }
    }

    /**
     * 获取指定id的消息
     * @param number $msgid
     * @return multitype: array | boolean
     */
    public static function getMsgById($msgid )
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('con');
        $criteria->compare('t.deleted', 0);
        $criteria->compare('t.msgid', $msgid);
        $data = self::model()->find($criteria);

        return $data;
    }

    public static function getAppointMsg($infoid, $msgid )
    {
        $criteria = new CDbCriteria();
        $criteria->with = array('con');
        $criteria->compare('t.deleted', 0);
        $criteria->compare('t.infoid', $infoid);
        $criteria->compare('t.msgid', $msgid);
        $data = self::model()->find($criteria);

        return $data;
    }
    
    
    protected function getListForward($infoid, $title)
    {
        $typePartSql = 'infoid = '.$infoid.' ';

        $likePartSql = true == $title ? ' AND title LIKE "%'.$title.'%"' : '';

        $bodyPartSql = ' FROM '.$this->tableName().' WHERE msgid NOT IN (SELECT msgid FROM '
            .Send::model()->tableName().' WHERE '.$typePartSql
                .' AND deleted=0 AND forward=2 AND close =0 ) AND deleted =0 AND send =2 AND close =1 AND infoid > 0 AND infoid !='.$infoid. $likePartSql . ' ORDER BY publishtime DESC' ;

        $sql = 'SELECT *'.$bodyPartSql;

        $countSql = 'SELECT COUNT(msgid) AS total '.$bodyPartSql;
        
        $countRow = $this->dbConnection->createCommand( $countSql )->queryRow();

        $total = true == isset( $countRow['total'] ) ? $countRow['total'] : 0;

        $pages = new CPagination( $total );
        
        $pages->pageSize = self::LIST_PAGE_SIZE;
        $criteria = new CDbCriteria();
        $pages->applyLimit( $criteria );
        
        $result = $this->dbConnection->createCommand( $sql." LIMIT :offset,:limit" );
        $result->bindValue(':offset', $pages->currentPage*$pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);
        
        $list = $result->queryAll();
        
        return array(
            'models' => $list,
            'pages' => $pages
        );
        
    }
    
    public function listMsg( $param )
    {
        if( true == isset($param['infoid']) && true == $param['infoid'] ) {

            $param['forward'] = true == isset( $param['forward'] )?$param['forward']:false;
            $param['title'] = true == isset( $param['title'] )?$param['title']:'';
            
            return $this->getListForward( $param['infoid'] , $param['title'] );
        }
        else{
           
        }
        
    }

    public function getOfficialInfo($data) {
        $infoids = array();
        $infoAssoc = array();
        foreach ($data as $v) {
            $infoids[] = $v['infoid'];
        }
        $infoids = array_unique($infoids);

        if (empty($infoids)) return array();

        $infoidsString = implode($infoids, ',');

        $sql = "SELECT infoid,openid,openname FROM op_official_info WHERE infoid in (".$infoidsString.")";
        $info = $this->dbConnection->createCommand($sql)->queryAll();

        foreach ($info as $iv) {
            if (isset($iv['infoid'])) {
                $infoAssoc[$iv['infoid']] = $iv;
            }
        }
        return $infoAssoc;
    }

    /**
     * 使用消息状态或匹配标题参数获取消息列表
     * @param array $param
     * @return multitype: array | boolean
     */
    public function listMsg2( $param )
    {
        $criteria = new CDbCriteria();

        // 检验发布状态
        if (true == isset($param['send'])
            && true == in_array($param['send'], array(self::MSG_NOT_PUBLISH, self::MSG_PUBLISH))) {
            $criteria->compare('send', $param);
        }

        //检验转发状态
        if(  true == isset($param['infoid']) && true == $param['infoid'] ){

            // 未转发
            if ( true == isset($param['forward']) && false ==$param['forward'] ) {
                $criteria->addCondition('sen.infoid IS NULL');   // 被依赖的 addCondition
                $criteria->addCondition('sen.infoid != '.$param['infoid'], 'or');  // 依赖 上面的 addCondition
                $criteria->addCondition('t.infoid != '.$param['infoid']);
                $criteria->addCondition('t.infoid > 0');
                $criteria->addCondition('t.close = '.self::MSG_NOT_CLOSE);
                $criteria->order = 't.publishtime DESC';
            }// 已转发
            else{
                $criteria->addCondition('sen.infoid='.$param['infoid']);
                $criteria->addCondition('t.infoid != '.$param['infoid']);
                $criteria->compare('sen.deleted', Message::LOGIC_NOT_DELETE);
                $criteria->order = 'sen.publishtime DESC';
            }
        }

        // 检验标题匹配
        if (true == isset($param['title']) && true == $param['title']) {
            $criteria->addSearchCondition('title', $param['title']);
        }

        $criteria->addCondition('t.send = '.self::MSG_FORWARD);

        $criteria->group = 't.msgid';
        $criteria->compare('t.deleted', Message::LOGIC_NOT_DELETE);
        $count = $this->with('sen')->count($criteria);
        $pages = new CPagination($count);

        $pages->pageSize = self::LIST_PAGE_SIZE;
        $pages->applyLimit($criteria);
        $models = $this->with('sen')->findAll($criteria);

        return array(
            'models' => $models,
            'pages' => $pages
        );
    }

    /**
     * parseUrl拆解的url，重组url
     * @param array $parseUrl 分析后的url数组
     * @param array $queryParams 参数查询数组
     * @return string   完整的url网址
     */
    protected function joinUrl( $parseUrl, $queryParams )
    {
        if( false == is_array( $parseUrl ) && false == is_array( $queryParams) ){
            return '';
        }

        unset($queryParams[self::IMAGE_INFO_URL_MARK]);
        unset( $parseUrl['query']);

        if( true == isset($parseUrl['scheme'] ) && true == $parseUrl['scheme'] ){
            $parseUrl['scheme'] .= '://';
        }

        if( true == $queryParams ){
            $parseUrl['query'] = '?'.http_build_query( $queryParams );
        }

        return join('', $parseUrl);
    }

    /**
     * 获取上传图片url后缀的标识宽高，图片宽高度存储
     * @param string $url
     * @return multitype:|multitype:number
     */
    protected function getImageUrlMark( $url )
    {
        $parseUrls = parse_url( $url);

        $query =  true == isset($parseUrls['query'])?$parseUrls['query']:'';

        parse_str( $query, $queryParams);

        if( true == isset( $queryParams[self::IMAGE_INFO_URL_MARK]) ){

            $widthHeight = $queryParams[self::IMAGE_INFO_URL_MARK];

            $infos = explode('_', $widthHeight);

            if( 2 <= count($infos) ){
                $infos['url'] = $this->joinUrl( $parseUrls, $queryParams);

                return $infos;
            }
        }

        return array(0,0,'url'=>$url);
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
                    'content' => strip_tags($v)
                );
            }

            if (true == isset($match[1][$k]) && true == trim($match[1][$k])) {

                $imageInfo = $this->getImageUrlMark( $match[1][$k] );

                $data[] = array(
                    'type' => 'image',
                    'content' => $imageInfo['url'],
                    'width' => $imageInfo[0],
                    'height' => $imageInfo[1]
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
        preg_match_all('/<p>(.+)<\/p>/isU', $inputContent, $match);

        YII_DEBUG && Yii::trace('<p>preg-match:' . var_export($match, true));

        if (true == isset($match[1])) {
            foreach ((array) $match[1] as $content) {
                $contentArray = preg_split('/(<img).+>/isU', $content);

                preg_match_all('/<img.+src=\"(.+)\".*>/isU', $content, $imgMatch);
                YII_DEBUG && Yii::trace('<img>preg-match:' . var_export($imgMatch, true));
                $data = array_merge( $data, $this->generateArray( $contentArray, $imgMatch ) );
            }
        }

        YII_DEBUG && Yii::trace('formtContentArray:' . var_export($data, true));

        return array('item'=>$data);
    }

    /**
     * @param $inputContent
     * @return array
     */
    public function getQiniuImage( $inputContent )
    {
        $data = $match = array();
        preg_match_all('/<p>(.+)<\/p>/isU', $inputContent, $match);

        if (true == isset($match[1])) {
            foreach ((array) $match[1] as $content) {
                $contentArray = preg_split('/(<img).+>/isU', $content);

                preg_match_all('/<img.+src=\"(.+)\".*>/isU', $content, $imgMatch);
                $data = $this->generateImageArray( $contentArray, $imgMatch );
            }
        }

        return $data;
    }

    /**
     * 事务保存消息分开的内容和标题表数据
     * @param string $content
     * @return boolean
     */
    protected function saveMsgTransaction( $content)
    {
        $contentModel  = '';

        if( true == $this->msgid ){
            $contentModel = Content::model()->findByPk( $this->msgid);

            true == isset($contentModel->msgid)?$contentModel->disableBehaviors():"";
        }

        if( false == $contentModel  ){
            $contentModel = new Content();
        }

        $contentModel->content = $content;

        $transaction = $this->dbConnection->beginTransaction();

        try {
            $this->saveMsgInTimer();

            if (false == $this->hasErrors()) {
                $contentModel->msgid = $this->msgid;
                YII_DEBUG && Yii::trace('saveContent:' . var_export($contentModel->attributes, true));
                $contentModel->save();
                $this->addCheckOtherError($contentModel);
            }

            $transaction->commit();
            $result = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            $result = false;
        }

        return $result;
    }

    /**
     * 把一个模型从另外一个模型错误提示，合并到当前模型
     *
     * @param CModel $model
     */
    protected function addCheckOtherError($model)
    {
        if ($model instanceof CModel && $model->hasErrors()) {
            $errors = $model->getErrors();
            $error = array_shift($errors);
            if (true == isset($error[0]) && true == $error[0]) {
                $this->addError(get_class($model), $error[0]);
            }
        } else if( true == YII_DEBUG ){
            $var = true == is_object($model)?get_class($model):$model;
            Yii::trace('addCheckOtherError:' . var_export($var, true));
        }
    }

    /**
     * 修改公众号当天的次数，只在当天累加
     */
    protected function updateInfoFreq()
    {
        $info = new OfficialInfo();
        $dataInfo = $info->findByPk($this->infoid);

        if( true == $dataInfo  ) {
            if( strtotime( $dataInfo->sendtime ) < strtotime( date('Y-m-d') ) ) {
                $dataInfo->sendcount = 0;
            }

            $dataInfo->sendtime = self::$nowDateTime;
            $dataInfo->sendcount = $dataInfo->sendcount +1;
            YII_DEBUG && Yii::trace('updateInfoFreq:'.var_export( $dataInfo->attributes, true));
            $dataInfo->save();

            $this->addCheckOtherError( $dataInfo );
        }
    }

    /**
     * 更新公众帐号的当天发布次数
     */
    protected function checkUpdateFreq()
    {
        $sendtime = strtotime( $this->sendtime );
        $defaultTime = strtotime('2001-01-02');      // mysql 设置的默认时间值 2001-01-01

        // 如果未发布过，并且是立刻发布或者定时发送，就计发送数量限制
        if( (self::$nowDateTime == $this->publishtime || $sendtime > $defaultTime) && false == $this->isPublished ){
            $this->updateInfoFreq();
        }
    }

    /**
     * 判断定时发送来保存消息表和定时发送表
     */
    protected function saveMsgInTimer()
    {
        YII_DEBUG && Yii::trace('saveMsg:'.var_export( $this->attributes, true));
        $result = $this->save();
    
        // 保存原始发布到记录表，只有在新发布时候才记录
        if( false == $this->isPublished && self::$nowDateTime == $this->publishtime ){
            $this->saveOriginalSend( $this->infoid );
        }

        // 定时发送记录表记录,修改或新增
        if( self::defaultTime( $this->sendtime ) > 0  && false == $this->hasErrors() ){
            $criteria = new CDbCriteria;
            $criteria->compare('infoid', $this->infoid);
            $criteria->compare('msgid', $this->msgid);
            $sendTimer = SendTimer::model()->find( $criteria );

            if( false == $sendTimer ){
                $sendTimer = new SendTimer();
                $sendTimer->infoid = $this->infoid;
                $sendTimer->msgid = $this->msgid;
            }

            $sendTimer->sendtime = $this->sendtime;
            YII_DEBUG && Yii::trace('saveMsgTimer:'.var_export( $sendTimer->attributes, true));
            $result = $result && $sendTimer->save();

            $this->addCheckOtherError($sendTimer);
        }
        
        $this->checkUpdateFreq();

        return $result;
    }

    /**
     * 编辑或新增消息，和 Content 模型 聚合，使用事务存储消息
     * @return boolean
     */
    public function saveMsg(  $title, $subhead, $cover, $msgfrom, $content, $sendtime, $publishtime )
    {
        $this->title = $title;
        $this->subhead = $subhead;
        $this->cover = $cover;
        $this->msgfrom = $msgfrom;
        $this->content = $content;
        $this->infoid = Yii::app()->getModule('official')->user->getinfo('infoid');
        $this->sendtime = self::DEFAULT_DATE_TIME;

        // 定时发布
        if (true == $sendtime) {
            $this->sendtime = $sendtime;
        } // 立刻发布
        else if( true == $publishtime ){
            $this->publishtime = self::$nowDateTime;

            // 未发布就验证
            if ( self::MSG_FORWARD != $this->send ){
                $this->scenario = 'publish';
            }
            else {
                $this->isPublished = true;
            }

            $this->send = self::MSG_PUBLISH;
        }

        $formatContent = json_encode($this->formtContentArray($content), JSON_UNESCAPED_SLASHES + JSON_UNESCAPED_UNICODE );

        return $this->saveMsgTransaction($formatContent);
    }

    /**
     * 保存原创发布
     * @param number $infoid
     */
    protected function saveOriginalSend( $infoid )
    {
        if (false == $this->hasErrors()) {
            $send = new Send();

            $send->msgid = $this->msgid;

            $send->infoid = $infoid;
            $send->forward = self::MSG_FORWARD;
            $send->publishtime = self::$nowDateTime;

            YII_DEBUG && Yii::trace('saveMsgSend:' . var_export($send->attributes, true));
            $send->save();
            $this->addCheckOtherError($send);
        }
    }

    /**
     * 原创发布消息
     *
     * @param number $msgid
     * @return boolean
     */
    public function publishMsg($msgid)
    {
        $this->scenario = 'publish';
        $this->infoid = Yii::app()->getModule('official')->user->getinfo('infoid');
        // 不会存入数据表
        $this->title = 1;
        $this->sendtime = '2001-01-01';
        $this->content = 1;
        $this->msgid = $msgid;

        // 验证发布数据是否通过发布次数
        if (true === $this->validate()) {
            YII_DEBUG && Yii::trace('publishMsg:'.var_export( $this->attributes, true));
            $transaction = $this->dbConnection->beginTransaction();
            try {
                $updateResult = $this->updateByPk($msgid, array(
                    'send' => Message::MSG_PUBLISH,
                    'publishtime' => self::$nowDateTime
                ));

                // 当更新消息表未发布成功时候,才是正确的发布。
                if( true == $updateResult ){
                    $this->saveOriginalSend( $this->infoid );
                    $this->updateInfoFreq();
                }

                $transaction->commit();
                $result = true;
            } catch (Exception $e) {
                $transaction->rollBack();
                $result = false;
            }

            return $result;
        } else {
            return false;
        }
    }


    /**
     * 封禁该条消息
     * @param string | array $id
     * @param string $reason
     * @return boolean
     */
    public function blockMsg( $ids, $reason )
    {
        $pks = array();

        if (true == is_string($ids)) {
            $pks = explode(',', $ids);
        } else
            if (true == is_array($ids)) {
                $pks = $ids;
            }

        if ( true == $this->validate()) {
            return $this->updateByPk($pks, array(
                'reason' => self::BLOCK_MSG
            ), array(
                'reason' => self::BLOCK_MSG
            ));
        } else {
            return false;
        }
    }

    /**
     * 删除传递的逗号分隔id串的批量或单条消息
     * @param string $ids
     * @return boolean
     */
    public function delMsg( $ids )
    {
        $pks = array();

        if (true == is_string($ids)) {
            $pks = explode(',', $ids);
        } else
            if (true == is_array($ids)) {
                $pks = $ids;
            }

        return $this->updateByPk($pks, array(
            'deleted' => self::LOGIC_DELETE
        ));
    }

    /**
     * 判断是否已经发布
     * @return boolean
     */
    public function getPushlishStatus()
    {
        return $this->send == self::MSG_PUBLISH;
    }
}