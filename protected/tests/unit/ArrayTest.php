<?php

class ArrayTest extends PHPUnit_Framework_TestCase  
{  
     public function testNewArrayIsEmpty()  
     {  
        // $obj = new PHPUnit_Extensions_Story_TestCase(NULL, array(), '');
        // Create the Array fixture.  
        $code = MainHelper::generate_code(4);
        // $fixture = Array();  
        // Assert that the size of the Array fixture is 0.  
        $this->assertEquals(4, strlen($code));
     }  

     public function testArrayContainsAnElement()  
     {  
        // Create the Array fixture.  
        $fixture = Array();  
        // Add an element to the Array fixture.  
        $fixture[] = 'Element';  
        // Assert that the size of the Array fixture is 1.  
        $this->assertEquals(1, sizeof($fixture));  
     }  

    /**
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Right Message
     */
    public function testExceptionHasRightMessage()
    {
        throw new InvalidArgumentException('Right Message', 10);
    }

    /**
     * @expectedException              InvalidArgumentException
     * @expectedExceptionMessageRegExp /Right.
     */
    public function testExceptionMessageMatchesRegExp()
    {
        throw new InvalidArgumentException('Some Message', 10);
    }

    /**
     * @expectedException     InvalidArgumentException
     * @expectedExceptionCode 20
     */
    public function testExceptionHasRightCode()
    {
        throw new InvalidArgumentException('Some Message', 20);
    }
}  
