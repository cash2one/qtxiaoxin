<?php

class WebTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://localhost/xiaoxin/');
    }

    public function testTitle()
    {
        $this->url('http://localhost/xiaoxin/');
        $this->assertEquals('蜻蜓校信', $this->title());
    }

}