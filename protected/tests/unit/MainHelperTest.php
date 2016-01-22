<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-9
 * Time: 下午4:51
 */

class MainHelperTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    public function testLoadClass()
    {
        $cid = 90;
        $classInfo = UCQuery::loadClass($cid);
        $this->assertEquals(true,property_exists($classInfo,'cid'));
    }

    /**
     * @depends testLoadClass
     */
    public function testEnid()
    {
        $cid = 7777;
        $classInfo = UCQuery::loadClass($cid);

       // var_dump($classInfo);
        $sid = $classInfo->sid;
        $r1 = rand(0, 999);
        $time = explode(" ", microtime());
        $t = $time[0] * 1000 * 1000;
        $r2 = (int)$t;
        $msgid = $r2 . $r1;
        $hash = $sid . $cid . $msgid;
        $code = MainHelper::enid($hash);
        echo '[' . $code . ']';
        $this->assertRegExp('/[A-Z0_9]{1,20}/', $code);

    }


    public function testGetCidCode(){
        $num=10;

    }
} 