<?php
/**
 * Send test case.
 */
class SendTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Send
     */
    private $Send;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        // TODO Auto-generated SendTest::setUp()

        $this->Send = new Send(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated SendTest::tearDown()
        $this->Send = null;

        parent::tearDown();
    }

    /**
     * Tests Send->tableName()
     */
    public function testTableName()
    {
        // TODO Auto-generated SendTest->testTableName()
        $this->markTestIncomplete("tableName test not implemented");

        $this->Send->tableName(/* parameters */);
    }

    /**
     * Tests Send->rules()
     */
    public function testRules()
    {
        // TODO Auto-generated SendTest->testRules()
        $this->markTestIncomplete("rules test not implemented");

        $this->Send->rules(/* parameters */);
    }

    /**
     * Tests Send->relations()
     */
    public function testRelations()
    {
        // TODO Auto-generated SendTest->testRelations()
        $this->markTestIncomplete("relations test not implemented");

        $this->Send->relations(/* parameters */);
    }

    /**
     * Tests Send->attributeLabels()
     */
    public function testAttributeLabels()
    {
        // TODO Auto-generated SendTest->testAttributeLabels()
        $this->markTestIncomplete("attributeLabels test not implemented");

        $this->Send->attributeLabels(/* parameters */);
    }

    /**
     * Tests Send->search()
     */
    public function testSearch()
    {
        // TODO Auto-generated SendTest->testSearch()
        $this->markTestIncomplete("search test not implemented");

        $this->Send->search(/* parameters */);
    }

    /**
     * 保存发布redis有序集的测试数据提供
     * array('帐号id','消息id','时间戳')
     * @return multitype:multitype:number
     */
    public function saveRedosSendProdiver()
    {
        return array(
            array( '12','13', '2014-12-11'),
            array( '14','11','2014-12-12' ),
            array( '11','24','2014-12-13' )
        );
    }

    /**
     * @dataProvider saveRedosSendProdiver
     */
    public function testSaveRedisSend(  $infoid, $msgid, $sendtime )
    {
        $result = $this->Send->saveRedisSend(  $infoid, $msgid, $sendtime );

        $this->assertTrue( (bool)$result  );
    }

    /**
     * 保存发布的测试数据提供
     * array('帐号id','消息id')
     * @return multitype:multitype:number
     */
    public function saveSendProdiver()
    {
        return array(
            array( '15','9' )
        );
    }

    /**
     * @dataProvider saveSendProdiver
     */
    public function testSaveSend(  $infoid, $msgid  )
    {

        $result = $this->Send->saveSend(  $infoid, $msgid  );

        $this->assertTrue( $result );
    }

    /**
     * Tests Send->forwardMsg()
     */
    public function testForwardMsg()
    {
        // TODO Auto-generated SendTest->testForwardMsg()
        $this->markTestIncomplete("forwardMsg test not implemented");

        $this->Send->forwardMsg(/* parameters */);
    }

    /**
     * Tests Send->delForwardMsg()
     */
    public function testDelForwardMsg()
    {
        // TODO Auto-generated SendTest->testDelForwardMsg()
        $this->markTestIncomplete("delForwardMsg test not implemented");

        $this->Send->delForwardMsg(/* parameters */);
    }

    /**
     * 提供剩余次数验证
     * array('帐号id','剩余次数')
     * @return multitype:multitype:number
     */
    public function limitMsgCountProdiver()
    {
        return array(
            array( '15','2' ),
            array( '28','2' )
        );
    }

    /**
     * @dataProvider limitMsgCountProdiver
     */
    public function testLimitMsgCount( $infoid, $num )
    {
        $total = $this->Send->limitMsgCount( $infoid );
        var_dump($total);
       $this->assertTrue(  $total  == $num  );
    }

    /**
     * Tests Send::model()
     */
    public function testModel()
    {
        // TODO Auto-generated SendTest::testModel()
        $this->markTestIncomplete("model test not implemented");

        Send::model(/* parameters */);
    }
}

