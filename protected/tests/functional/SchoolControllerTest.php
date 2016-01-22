<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
class SchoolControllerTest extends CWebTestCase {   	
	protected function setUp() {   	  
		//$this->setBrowser("*iexplore");
		$this->setBrowser("*firefox");
		//$this->setBrowser("*chrome");
		$this->setBrowserUrl("http://localxiaoxin");
	}

	/**************创建学校***************************/
	
	// //学校名称为空
	// public function testSchoolCreateTestCase1()
	// {
	// 	$this->open("/admin.php/school/create/");
	// 	$this->type("name=School[name]", "");   //学校名称
	// 	$this->check("id=Information_kindtop_0"); //类型
	// 	$this->select("name=city","label=深圳"); //城市
	// 	$this->select("name=School[aid]","label=南山区"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学校名称不能为空！");
	// }


	// //不选择学校类型
	// public function testSchoolCreateTestCase2()
	// {
	// 	$this->open("/admin.php/school/create/");
	// 	$this->type("name=School[name]", "这是一个测试学校9.18");   //学校名称
	// 	//$this->check("id=Information_kindtop_0"); //类型
	// 	$this->select("name=city","label=深圳"); //城市
	// 	$this->select("name=School[aid]","label=南山区"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择您的类型！");
	// }

	
	// //不选择城市
	// public function testSchoolCreateTestCase3()
	// {
	// 	$this->open("/admin.php/school/create/");
	// 	$this->type("name=School[name]", "这是一个测试学校9.18");   //学校名称
	// 	$this->check("id=Information_kindtop_0"); //类型
	// 	$this->select("name=city","label=全部"); //城市
	// 	$this->select("name=School[aid]","label=全部"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择城市！");
	// }


	// //不选择地区
	// public function testSchoolCreateTestCase4()
	// {
	// 	$this->open("/admin.php/school/create/");
	// 	$this->type("name=School[name]", "这是一个测试学校9.18");   //学校名称
	// 	$this->check("id=Information_kindtop_0"); //类型
	// 	$this->select("name=city","label=深圳"); //城市
	// 	$this->select("name=School[aid]","label=全部"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择地区！");
	// }


	// //创建成功
	// public function testSchoolCreateTestCase5()
	// {
	// 	$this->open("/admin.php/school/create/");
	// 	$this->type("name=School[name]", "这是一个测试学校9.18");   //学校名称
	// 	$this->check("id=Information_kindtop_0"); //类型
	// 	$this->select("name=city","label=深圳"); //城市
	// 	$this->select("name=School[aid]","label=南山区"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择地区！");
	// 	$this->assertTextNotPresent("请选择城市！");
	// 	$this->assertTextNotPresent("请选择您的类型！");
	// 	$this->assertTextNotPresent("学校名称不能为空！");
	// }





	/**************查找学校***************************/

	// //类别
	// public function testSchoolListTestCase1()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->select("name=School[type]","label=幼儿园"); //类别
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //类别、城市
	// public function testSchoolListTestCase2()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->select("name=School[type]","label=幼儿园"); //类别
	// 	$this->select("name=School[city]","label=深圳"); //城市
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //类别、城市、地区
	// public function testSchoolListTestCase3()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->select("name=School[type]","label=幼儿园"); //类别
	// 	$this->select("name=School[city]","label=深圳"); //城市
	// 	$this->select("name=School[area]","label=南山区"); //地区
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //类别、城市、地区、学校名
	// public function testSchoolListTestCase4()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->select("name=School[type]","label=幼儿园"); //类别
	// 	$this->select("name=School[city]","label=深圳"); //城市
	// 	$this->select("name=School[area]","label=南山区"); //地区
	// 	$this->type("id=project", "这是一个测试学校5");   //学校名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //学校名称
	// public function testSchoolListTestCase5()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->type("id=project", "这是一个测试学校6");   //学校名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("暂无数据");
	// }




	/**************修改学校***************************/
	// //学校名称修改为空
	// public function testSchoolUpdateTestCase1()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/school/update/1400']");
	// 	$this->type("name=School[name]", "");   //学校名称
	// 	$this->check("id=Information_kindtop_1"); //类型
	// 	$this->select("name=city","label=深圳"); //城市
	// 	$this->select("name=School[aid]","label=罗湖区"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学校名称不能为空！");
	// }


	// //学校类型修改为空
	// public function testSchoolUpdateTestCase2()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/school/update/1400']");
	// 	$this->type("name=School[name]", "这是一个测试学校new变old");   //学校名称
	// 	$this->uncheck("id=Information_kindtop_0"); //类型
	// 	$this->select("name=city","label=深圳"); //城市
	// 	$this->select("name=School[aid]","label=罗湖区"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("请选择您的类型！");
	// }



	// //城市修改为空
	// public function testSchoolUpdateTestCase3()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/school/update/1400']");
	// 	$this->type("name=School[name]", "这是一个测试学校new变old");   //学校名称
	// 	$this->check("id=Information_kindtop_1"); //类型
	// 	$this->select("name=city","label=全部"); //城市
	// 	$this->select("name=School[aid]","label=全部"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择城市！");
	// }



	// //地区修改为空
	// public function testSchoolUpdateTestCase4()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/school/update/1400']");
	// 	$this->type("name=School[name]", "这是一个测试学校new变old");   //学校名称
	// 	$this->check("id=Information_kindtop_1"); //类型
	// 	$this->select("name=city","label=深圳"); //城市
	// 	$this->select("name=School[aid]","label=全部"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择地区！");
	// }


	// //修改成功
	// public function testSchoolUpdateTestCase5()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/school/update/1400']");
	// 	//$this->open("/admin.php/school/update/1365");
	// 	$this->type("name=School[name]", "这是一个测试学校new变old");   //学校名称
	// 	$this->check("id=Information_kindtop_1"); //类型
	// 	$this->select("name=city","label=深圳"); //城市
	// 	$this->select("name=School[aid]","label=罗湖区"); //地区
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择地区！");
	// 	$this->assertTextNotPresent("请选择城市！");
	// 	$this->assertTextNotPresent("请选择您的类型！");
	// 	$this->assertTextNotPresent("学校名称不能为空！");
	// }



	/**************删除学校***************************/

	// //取消删除学校
	// public function testSchoolListTestCase1()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->click("//a[@data-href='/admin.php/school/delete/1400']");
	// 	$this->click("//a[@class='btn btn-default']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("删除成功");
	// }


	// //确定删除学校
	// public function testSchoolListTestCase2()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->click("//a[@data-href='/admin.php/school/delete/1400']");
	// 	$this->clickAndWait("id=isOk");
	// 	$this->assertTextPresent("删除成功");
	// }

	// //是否已经删除
	// public function testSchoolListTestCase3()
	// {
	// 	$this->open("/admin.php/school/index/");
	// 	$this->click("//a[@data-href='/admin.php/school/delete/1400']");
	// 	$this->clickAndWait("id=isOk");
	// 	$this->assertTextPresent("删除成功");
	// }
}