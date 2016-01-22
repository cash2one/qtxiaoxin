<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
class BackLoginTest extends CWebTestCase {   	
	protected function setUp() {   	  
		//$this->setBrowser("*iexplore");
		$this->setBrowser("*firefox");
		//$this->setBrowser("*chrome");
		$this->setBrowserUrl("http://localxiaoxin");
	}

	//后台登陆

	//账号不能为空
	public function testLoginTestCase1()
	{
		$this->open("/admin.php/");
		$this->type("id=LoginForm_username", "");
		$this->type("id=LoginForm_password", "123456");
		//$this->check("id=LoginForm_rememberMe"); //记住密码
		$this->click("name=yt0");
	    $this->waitForPageToLoad("3000");
		$this->assertTextNotPresent("用户名为必填项");
	}

	//密码不能为空
	public function testLoginTestCase2()
	{
		$this->open("/admin.php/");
		$this->type("id=LoginForm_username", "test");
		$this->type("id=LoginForm_password", "");
		//$this->check("id=LoginForm_rememberMe"); //记住密码
		$this->click("name=yt0");
	    $this->waitForPageToLoad("3000");
		$this->assertTextNotPresent("密码为必填项");
	}
	
	//账号停用或不存在
	public function testLoginTestCase3()
	{
		$this->open("/admin.php/");
		$this->type("id=LoginForm_username", "testwe");
		$this->type("id=LoginForm_password", "123456");
		//$this->check("id=LoginForm_rememberMe"); //记住密码
		$this->click("name=yt0");
	    $this->waitForPageToLoad("3000");
		$this->assertTextNotPresent("账号停用或不存在.");
	}

	//密码错误
	public function testLoginTestCase4()
	{
		$this->open("/admin.php/");
		$this->type("id=LoginForm_username", "test");
		$this->type("id=LoginForm_password", "12345689");
		//$this->check("id=LoginForm_rememberMe"); //记住密码
		$this->click("name=yt0");
	    $this->waitForPageToLoad("3000");
		$this->assertTextNotPresent("密码错误.");
	}


	//登陆成功
	public function testLoginTestCase5()
	{
		$this->open("/admin.php/");
		$this->type("id=LoginForm_username", "test");
		$this->type("id=LoginForm_password", "123456");
		//$this->check("id=LoginForm_rememberMe"); //记住密码
		$this->click("name=yt0");
	    $this->waitForPageToLoad("3000");
	    $this->assertTextNotPresent("用户名为必填项");
	    $this->assertTextNotPresent("密码为必填项");
	    $this->assertTextNotPresent("密码错误.");
		$this->assertTextNotPresent("账号停用或不存在.");
	}

}