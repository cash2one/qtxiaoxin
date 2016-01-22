<?php

class MySiteTest extends CWebTestCase {   	
	protected function setUp() {   	  
		$this->setBrowser("*iexplore");
		$this->setBrowserUrl("http://localhost/xiaoxxin/");

	}
	public function testMyTestCase()
	{
		$this->open("/xiaoxin/");
		$this->type("id=username", "xiaoxin");
		$this->type("id=password", "123456");
		$this->click("id=lbtnLogin");
		// $this->waitForPageToLoad("30");
		$this->assertEquals(0,0);
	}
}