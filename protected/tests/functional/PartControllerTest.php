<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
class PartControllerTest extends CWebTestCase {   	
	protected function setUp() {   	  
		//$this->setBrowser("*iexplore");
		$this->setBrowser("*firefox");
		//$this->setBrowser("*chrome");
		$this->setBrowserUrl("http://localxiaoxin");
	}

	/**************创建部门***************************/
	
	// //部门名称为空
	// public function testPartCreateTestCase1()
	// {
	// 	$this->open("/admin.php/part/create/");
	// 	$this->type("name=Department[name]", "");   //部门名称
	// 	$this->select("name=Department[sid]","label=A:AAAA"); //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("部门名称不能为空！");
	// }


	// //不选择学校
	// public function testPartCreateTestCase2()
	// {
	// 	$this->open("/admin.php/part/create/");
	// 	$this->type("name=Department[name]", "这是一个测试部门9.18");   //部门名称
	// 	$this->select("name=Department[sid]","label=全部"); //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// }


	// //创建成功
	// public function testPartCreateTestCase3()
	// {
	// 	$this->open("/admin.php/part/create/");
	// 	$this->type("name=Department[name]", "这是一个测试部门9.18");   //部门名称
	// 	$this->select("name=Department[sid]","label=A:AAAA"); //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("部门名称不能为空！");
	// }





	/**************查找部门***************************/

	// //不选择学校
	// public function testPartListTestCase1()
	// {
	// 	$this->open("/admin.php/part/index/");
	// 	$this->select("name=Department[sid]","label=全部"); //学校
	// 	$this->type("name=Department[name]","这是一个测试部门"); //部门名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }



	// //不选择部门 
	// public function testPartListTestCase2()
	// {
	// 	$this->open("/admin.php/part/index/");
	// 	$this->select("name=Department[sid]","label=A:AAAA"); //学校
	// 	$this->type("name=Department[name]",""); //部门名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //选择学校、部门 
	// public function testPartListTestCase3()
	// {
	// 	$this->open("/admin.php/part/index/");
	// 	$this->select("name=Department[sid]","label=A:AAAA"); //学校
	// 	$this->type("name=Department[name]","这是一个测试部门"); //部门名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }



	/**************修改部门***************************/
	// //部门名称修改为空
	// public function testPartUpdateTestCase1()
	// {
	// 	$this->open("/admin.php/part/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/part/update/38']");
	// 	$this->type("name=Department[name]", "");   //部门名称
	// 	$this->select("name=Department[sid]","label=A:AAAA"); //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("部门名称不能为空！");
	// }


	// //学校修改为空
	// public function testPartUpdateTestCase2()
	// {
	// 	$this->open("/admin.php/part/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/part/update/38']");
	// 	$this->type("name=Department[name]", "这是一个测试部门");   //部门名称
	// 	$this->select("name=Department[sid]","label=全部"); //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("请选择学校！");
	// }


	// //修改成功
	// public function testPartUpdateTestCase3()
	// {
	// 	$this->open("/admin.php/part/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/part/update/38']");
	// 	$this->type("name=Department[name]", "这是一个测试部门");   //部门名称
	// 	$this->select("name=Department[sid]","label=A:AAAA"); //学校
	//   $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("部门名称不能为空！");
	// }



	/**************删除部门***************************/

	//取消删除部门
	// public function testPartListTestCase1()
	// {
	// 	$this->open("/admin.php/part/index/");
	// 	$this->click("//a[@data-href='/admin.php/part/delete/23']");
	// 	$this->click("//a[@class='btn btn-default']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("删除成功");
	// }


	// //确定删除部门
	// public function testPartListTestCase2()
	// {
	// 	$this->open("/admin.php/part/index/");
	// 	$this->click("//a[@data-href='/admin.php/part/delete/23']");
	// 	$this->clickAndWait("id=isOk");
	// 	$this->assertTextPresent("删除成功");
	// }


	// //是否已经删除
	// public function testPartListTestCase3()
	// {
	// 	$this->open("/admin.php/part/index/");
	// 	$this->click("//a[@data-href='/admin.php/part/delete/23']");
	// 	$this->clickAndWait("id=isOk");
	// 	$this->assertTextPresent("删除成功");
	// }
}