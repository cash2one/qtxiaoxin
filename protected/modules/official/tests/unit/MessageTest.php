<?php

/**
 * Message test case.
 */
class MessageTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Message
     */
    private $Message;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        // TODO Auto-generated MessageTest::setUp()

        $this->Message = new Message(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated MessageTest::tearDown()
        $this->Message = null;

        parent::tearDown();
    }

    /**
     * Tests Message->tableName()
     */
    public function testTableName()
    {
        // TODO Auto-generated MessageTest->testTableName()
        $this->markTestIncomplete("tableName test not implemented");

        $this->Message->tableName(/* parameters */);
    }

    /**
     * Tests Message->rules()
     */
    public function testRules()
    {
        // TODO Auto-generated MessageTest->testRules()
        $this->markTestIncomplete("rules test not implemented");

        $this->Message->rules(/* parameters */);
    }

    /**
     * Tests Message->relations()
     */
    public function testRelations()
    {
        // TODO Auto-generated MessageTest->testRelations()
        $this->markTestIncomplete("relations test not implemented");

        $this->Message->relations(/* parameters */);
    }

    /**
     * Tests Message->attributeLabels()
     */
    public function testAttributeLabels()
    {
        // TODO Auto-generated MessageTest->testAttributeLabels()
        $this->markTestIncomplete("attributeLabels test not implemented");

        $this->Message->attributeLabels(/* parameters */);
    }

    /**
     * Tests Message->search()
     */
    public function testSearch()
    {
        // TODO Auto-generated MessageTest->testSearch()
        $this->markTestIncomplete("search test not implemented");

        $this->Message->search(/* parameters */);
    }

    /**
     * Tests Message::model()
     */
    public function testModel()
    {
        // TODO Auto-generated MessageTest::testModel()
        $this->markTestIncomplete("model test not implemented");

        Message::model(/* parameters */);
    }

    /**
     * Tests Message->pageData()
     */
    public function testPageData()
    {
        // TODO Auto-generated MessageTest->testPageData()
        $this->markTestIncomplete("pageData test not implemented");

        $this->Message->pageData(/* parameters */);
    }

    /**
     * Tests Message::msgLock()
     */
    public function testMsgLock()
    {
        // TODO Auto-generated MessageTest::testMsgLock()
        $this->markTestIncomplete("msgLock test not implemented");

        Message::msgLock(/* parameters */);
    }

    /**
     * Tests Message->getMsgById()
     */
    public function testGetMsgById()
    {
        // TODO Auto-generated MessageTest->testGetMsgById()
        $this->markTestIncomplete("getMsgById test not implemented");

        $this->Message->getMsgById(/* parameters */);
    }

    /**
     * Tests Message->listMsg()
     */
    public function testListMsg()
    {
        // TODO Auto-generated MessageTest->testListMsg()
        $this->markTestIncomplete("listMsg test not implemented");

        $this->Message->listMsg(/* parameters */);
    }


    /**
     * 修改或新增消息的测试数据提供
     * array('帐号id','标题','副标题','封面文件名','正文','发送时间')
     * @return multitype:multitype:number
     */
    public function saveMsgProdiver()
    {
        return array(
            array( '10','标题是测试','副标题也是测试','o_1982787j4n6vb6h30m1eml1o8j9.jpg','正文消息内容', date('Y-m-d H:i:s') )
        );
    }

    /**
     * @dataProvider saveMsgProdiver
     */
    public function testSaveMsg(  $infoid, $title, $subhead, $cover, $content, $sendtime )
    {
        Yii::app()->getModule('official')->user->setState('infoid',$infoid);

        echo Yii::app()->getModule('official')->user->infoid;
        $result = $this->Message->saveMsg(  $title, $subhead, $cover, $content, $sendtime );

        $this->assertTrue( $result );
    }

    /**
     * Tests Message->blockMsg()
     */
    public function testBlockMsg()
    {
        // TODO Auto-generated MessageTest->testBlockMsg()
        $this->markTestIncomplete("blockMsg test not implemented");

        $this->Message->blockMsg(/* parameters */);
    }

    /**
     * Tests Message->delMsg()
     */
    public function testDelMsg()
    {
        // TODO Auto-generated MessageTest->testDelMsg()
        $this->markTestIncomplete("delMsg test not implemented");

        $this->Message->delMsg(/* parameters */);
    }
}

