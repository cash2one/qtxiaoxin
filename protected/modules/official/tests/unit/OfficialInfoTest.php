<?php

/**
 * OfficialInfo test case.
 */
class OfficialInfoTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var OfficialInfo
     */
    private $OfficialInfo;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        // TODO Auto-generated OfficialInfoTest::setUp()

        $this->OfficialInfo = new OfficialInfo(/* parameters */);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated OfficialInfoTest::tearDown()
        $this->OfficialInfo = null;

        parent::tearDown();
    }

    /**
     * Tests OfficialInfo->tableName()
     */
    public function testTableName()
    {
        // TODO Auto-generated OfficialInfoTest->testTableName()
        $this->markTestIncomplete("tableName test not implemented");

        $this->OfficialInfo->tableName(/* parameters */);
    }

    /**
     * Tests OfficialInfo->rules()
     */
    public function testRules()
    {
        // TODO Auto-generated OfficialInfoTest->testRules()
        $this->markTestIncomplete("rules test not implemented");

        $this->OfficialInfo->rules(/* parameters */);
    }

    /**
     * Tests OfficialInfo->relations()
     */
    public function testRelations()
    {
        // TODO Auto-generated OfficialInfoTest->testRelations()
        $this->markTestIncomplete("relations test not implemented");

        $this->OfficialInfo->relations(/* parameters */);
    }

    /**
     * Tests OfficialInfo->attributeLabels()
     */
    public function testAttributeLabels()
    {
        // TODO Auto-generated OfficialInfoTest->testAttributeLabels()
        $this->markTestIncomplete("attributeLabels test not implemented");

        $this->OfficialInfo->attributeLabels(/* parameters */);
    }

    /**
     * Tests OfficialInfo->search()
     */
    public function testSearch()
    {
        // TODO Auto-generated OfficialInfoTest->testSearch()
        $this->markTestIncomplete("search test not implemented");

        $this->OfficialInfo->search(/* parameters */);
    }

    /**
     * Tests OfficialInfo::getUniqueOfficial()
     */
    public function testGetUniqueOfficial()
    {
        // TODO Auto-generated OfficialInfoTest::testGetUniqueOfficial()
        $this->markTestIncomplete("getUniqueOfficial test not implemented");

        OfficialInfo::getUniqueOfficial(/* parameters */);
    }

    /**
     * Tests OfficialInfo->pageData()
     */
    public function testPageData()
    {
        // TODO Auto-generated OfficialInfoTest->testPageData()
        $this->markTestIncomplete("pageData test not implemented");

        $this->OfficialInfo->pageData(/* parameters */);
    }

    /**
     * Tests OfficialInfo::getOfficialAccount()
     */
    public function testGetOfficialAccount()
    {
        // TODO Auto-generated OfficialInfoTest::testGetOfficialAccount()
        $this->markTestIncomplete("getOfficialAccount test not implemented");

        OfficialInfo::getOfficialAccount(/* parameters */);
    }

    /**
     * Tests OfficialInfo::setBlock()
     */
    public function testSetBlock()
    {
        // TODO Auto-generated OfficialInfoTest::testSetBlock()
        $this->markTestIncomplete("setBlock test not implemented");

        OfficialInfo::setBlock(/* parameters */);
    }

    /**
     * 修改资料的测试数据提供
     * array('帐号id','头像文件名','名称','简介')
     * @return multitype:multitype:number
     */
    public function saveInfoProdiver()
    {
        return array(
            array('10','124455','124451','124451')
        );
    }

    /**
     * @dataProvider saveInfoProdiver
     */
    public function testSaveInfo( $infoId, $inputFileName,  $openName, $summary )
    {
        $model = $this->OfficialInfo->findByPk($infoId);
        $result =  $model->saveInfo( $inputFileName,  $openName, $summary );
        $this->assertTrue( $result );
    }

    /**
     * Tests OfficialInfo::model()
     */
    public function testModel()
    {
        // TODO Auto-generated OfficialInfoTest::testModel()
        $this->markTestIncomplete("model test not implemented");

        OfficialInfo::model(/* parameters */);
    }
}

