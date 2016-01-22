<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-9-9
 * Time: 下午4:51
 */

class SchoolTypeTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {

    }

    public function testGetSchoolTypeData()
    {
        $typeArr=SchoolType::getSchoolTypeData();
        $this->assertEquals(6,count($typeArr));
    }

} 