<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
class ClassControllerTest extends CWebTestCase {   	
	protected function setUp() {   	  
		//$this->setBrowser("*iexplore");
		$this->setBrowser("*firefox");
		//$this->setBrowser("*chrome");
		$this->setBrowserUrl("http://localxiaoxin");
	}

	/**************创建班级***************************/
	
	// //班级名称为空
	// public function testClassCreateTestCase1()
	// {
	// 	$this->open("/admin.php/class/create/");
	// 	$this->type("name=Class[name]", "");   //班级名称
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Class[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=grade","label=一年级"); //年级
	// 	$this->select("name=Class[master]","label=校信"); //班主任
	// 	$this->type("name=Class[info]", "");   //班级介绍
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("班级名称不能为空！");
	// }


	// //不选择学校
	// public function testClassCreateTestCase2()
	// {
	// 	$this->open("/admin.php/class/create/");
	// 	$this->type("name=Class[name]", "这是一个测试班级918");   //班级名称
	// 	$this->select("name=Class[sid]","label=全部"); //学校
	// 	$this->fireEvent("name=Class[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=grade","label=全部"); //年级
	// 	$this->select("name=Class[master]","label=请选择班主任"); //班主任
	// 	$this->type("name=Class[info]", "");   //班级介绍
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// }

	
	// //不选择年级
	// public function testClassCreateTestCase3()
	// {
	// 	$this->open("/admin.php/class/create/");
	// 	$this->type("name=Class[name]", "这是一个测试班级918");   //班级名称
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Class[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=grade","label=全部"); //年级
	// 	$this->select("name=Class[master]","label=校信"); //班主任
	// 	$this->type("name=Class[info]", "");   //班级介绍
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择年级！");
	// }



	// //创建成功
	// public function testClassCreateTestCase4()
	// {
	// 	$this->open("/admin.php/class/create/");
	// 	$this->type("name=Class[name]", "这是一个测试班级918");   //班级名称
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Class[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=grade","label=二年级"); //年级
	// 	$this->select("name=Class[master]","label=校信"); //班主任
	// 	$this->type("name=Class[info]", "");   //班级介绍
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择年级！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("班级名称不能为空！");
	// }





	/**************查找班级***************************/

	// //学校
	// public function testClassListTestCase1()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //学校、年级
	// public function testClassListTestCase2()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->select("name=Class[grade]","label=二年级"); //年级
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //班级名称
	// public function testSchoolListTestCase3()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->type("name=Class[name]", "我爱我有祖国");   //班级名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("暂无数据");
	// }




	/**************修改班级***************************/

	// //班级名称修改为空
	// public function testClassUpdateTestCase1()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/class/update/162']");
	// 	$this->type("name=Class[name]", "");   //班级名称
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Class[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=grade","label=一年级"); //年级
	// 	$this->select("name=Class[master]","label=校信"); //班主任
	// 	$this->type("name=Class[info]", "dddddd");   //班级介绍
	//  $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("班级名称不能为空！");
	// }


	// //学校修改为空
	// public function testClassUpdateTestCase2()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/class/update/162']");
	// 	$this->type("name=Class[name]", "这是一个测试班级6");   //班级名称
	// 	$this->select("name=Class[sid]","label=全部"); //学校
	// 	$this->fireEvent("name=Class[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=grade","label=全部"); //年级
	// 	$this->select("name=Class[master]","label=请选择班主任"); //班主任
	// 	$this->type("name=Class[info]", "");   //班级介绍
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// }



	// //年级修改为空
	// public function testClassUpdateTestCase3()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/class/update/162']");
	// 	$this->type("name=Class[name]", "这是一个测试班级6");   //班级名称
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Class[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=grade","label=全部"); //年级
	// 	$this->select("name=Class[master]","label=校信"); //班主任
	// 	$this->type("name=Class[info]", "dddddd");   //班级介绍
	//   $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("请选择年级！");
	// }



	// //修改成功
	// public function testClassUpdateTestCase4()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/class/update/162']");
	// 	$this->type("name=Class[name]", "这是一个测试班级666");   //班级名称
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Class[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=grade","label=二年级"); //年级
	// 	$this->select("name=Class[master]","label=校信"); //班主任
	// 	$this->type("name=Class[info]", "");   //班级介绍
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择年级！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("班级名称不能为空！");
	// }



	/**************删除班级***************************/

	// //取消删除班级
	// public function testClassListTestCase1()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->click("//a[@data-href='/admin.php/class/delete/145']");
	// 	$this->click("//a[@class='btn btn-default']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("删除成功");
	// }


	// //确定删除班级
	// public function testClassListTestCase2()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->click("//a[@data-href='/admin.php/class/delete/145']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }

	// //是否已经删除
	// public function testClassListTestCase3()
	// {
	// 	$this->open("/admin.php/class/index/");
	// 	$this->click("//a[@data-href='/admin.php/class/delete/145']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }
}