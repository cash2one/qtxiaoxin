<?php

class SiteTest extends WebTestCase
{
	// protected function setUp()
 //    {
 //        $this->setBrowser('firefox');
 //        $this->setBrowserUrl('/xiaoxin/');
 //    }
    
	public function testIndex()
	{
		$this->open('http://dev.abc.com/xiaoxin/');
		if(Yii::app()->user->isGuest){
			//$this->assertTextPresent('了解更多');
		}else{
			//$this->assertTextPresent('首页');
		}
	}

	// public function testLogin()
	// {
	// 	$this->open('xiaoxin/default/login');
	// 	// $this->assertTextPresent('Contact Us');
	// 	$this->assertElementPresent('name=ULoginForm[username]');

	// 	$this->type('name=ULoginForm[username]','xiaoxin');
	// 	$this->type('name=ULoginForm[password]','123456');
	// 	$this->type('name=ULoginForm[role]','1');
		
	// 	// $this->type('name=ContactForm[subject]','test subject');
	// 	// $this->click("//input[@value='Submit']");
	// 	$this->click("id=lbtnLogin");
	// 	$this->click("class=name");
	// 	$this->waitForTextPresent('Body cannot be blank.');
	// }

	// public function testLoginLogout()
	// {
	// 	$this->open('xiaoxin');
	// 	// ensure the user is logged out
	// 	if($this->isTextPresent('Logout'))
	// 		$this->clickAndWait('link=Logout (demo)');

	// 	// test login process, including validation
	// 	$this->clickAndWait('link=Login');
	// 	$this->assertElementPresent('name=LoginForm[username]');
	// 	$this->type('name=LoginForm[username]','demo');
	// 	$this->click("//input[@value='Login']");
	// 	$this->waitForTextPresent('Password cannot be blank.');
	// 	$this->type('name=LoginForm[password]','demo');
	// 	$this->clickAndWait("//input[@value='Login']");
	// 	$this->assertTextNotPresent('Password cannot be blank.');
	// 	$this->assertTextPresent('Logout');

	// 	// test logout process
	// 	$this->assertTextNotPresent('Login');
	// 	$this->clickAndWait('link=Logout (demo)');
	// 	$this->assertTextPresent('Login');
	// }
}
