<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-12
 * Time: 上午10:10
 */
/*
 *     assertArrayHasKey()
    assertClassHasAttribute()
    assertClassHasStaticAttribute()
    assertContains()
    assertContainsOnly()
    assertContainsOnlyInstancesOf()
    assertCount()
    assertEmpty()
    assertEqualXMLStructure()
    assertEquals()
    assertFalse()
    assertFileEquals()
    assertFileExists()
    assertGreaterThan()
    assertGreaterThanOrEqual()
    assertInstanceOf()
    assertInternalType()
    assertJsonFileEqualsJsonFile()
    assertJsonStringEqualsJsonFile()
    assertJsonStringEqualsJsonString()
    assertLessThan()
    assertLessThanOrEqual()
    assertNull()
    assertObjectHasAttribute()
    assertRegExp()
    assertStringMatchesFormat()
    assertStringMatchesFormatFile()
    assertSame()
    assertStringEndsWith()
    assertStringEqualsFile()
    assertStringStartsWith()
    assertThat()
    assertTrue()
    assertXmlFileEqualsXmlFile()
    assertXmlStringEqualsXmlFile()
    assertXmlStringEqualsXmlString()

B. 标注

    @author
    @after
    @afterClass
    @backupGlobals
    @backupStaticAttributes
    @before
    @beforeClass
    @codeCoverageIgnore*
    @covers
    @coversDefaultClass
    @coversNothing
    @dataProvider
    @depends
    @expectedException
    @expectedExceptionCode
    @expectedExceptionMessage
    @expectedExceptionMessageRegExp
    @group
    @large
    @medium
    @preserveGlobalState
    @requires
    @runTestsInSeparateProcesses
    @runInSeparateProcess
    @small
    @test
    @testdox
    @ticket
    @uses
 */
class AreaTest extends PHPUnit_Framework_TestCase{
    public function setUp()
    {

    }

    public function testGetCityArr()
    {
        $cityArr = Area::getCityArr();
        $this->assertGreaterThan(0,count($cityArr));
    }

    public function testGetAreaArr()
    {
        $areaArr = Area::getAreaArr(array('cid'=>1));
        $this->assertGreaterThan(0,count($areaArr));
    }

} 