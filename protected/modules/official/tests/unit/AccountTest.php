<?php

/**
 * Account test case.
 */
class AccountTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Account
     */
    private $Account;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->Account = new Account(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AccountTest::tearDown()
        $this->Account = null;

        parent::tearDown();
    }


    /**
     * Tests Account->tableName()
     */
    public function testTableName()
    {
        // TODO Auto-generated AccountTest->testTableName()
        $this->markTestIncomplete("tableName test not implemented");

        $this->Account->tableName(/* parameters */);
    }

    /**
     * Tests Account->rules()
     */
    public function testRules()
    {
        // TODO Auto-generated AccountTest->testRules()
        $this->markTestIncomplete("rules test not implemented");

        $this->Account->rules(/* parameters */);
    }

    /**
     * Tests Account->relations()
     */
    public function testRelations()
    {
        // TODO Auto-generated AccountTest->testRelations()
        $this->markTestIncomplete("relations test not implemented");

        $this->Account->relations(/* parameters */);
    }

    /**
     * Tests Account->attributeLabels()
     */
    public function testAttributeLabels()
    {
        // TODO Auto-generated AccountTest->testAttributeLabels()
        $this->markTestIncomplete("attributeLabels test not implemented");

        $this->Account->attributeLabels(/* parameters */);
    }

    /**
     * Tests Account->search()
     */
    public function testSearch()
    {
        // TODO Auto-generated AccountTest->testSearch()
        $this->markTestIncomplete("search test not implemented");

        $this->Account->search(/* parameters */);
    }

    /**
     * Tests Account::getUniqueAccount()
     */
    public function testGetUniqueAccount()
    {
        // TODO Auto-generated AccountTest::testGetUniqueAccount()
        $this->markTestIncomplete("getUniqueAccount test not implemented");

        Account::getUniqueAccount(/* parameters */);
    }


    /**
     * 修改密码的测试数据提供
     * array('帐号id','原始密码','新密码','确认的新密码')
     * @return multitype:multitype:number
     */
    public function changePwdProdiver()
    {
        return array(
            array('1','124455','124451','124451')
        );
    }

    /**
     * @dataProvider changePwdProdiver
     */
    public function testChangePwd( $acid, $old, $new, $confirmation )
    {
        $model = $this->Account->findByPk($acid);
        $result = $model->changePwd(  $old, $new, $confirmation );

       $this->assertTrue(  $result );
    }

    /**
     * Tests Account::model()
     */
    public function testModel()
    {
        // TODO Auto-generated AccountTest::testModel()
        $this->markTestIncomplete("model test not implemented");

        Account::model(/* parameters */);
    }
}

