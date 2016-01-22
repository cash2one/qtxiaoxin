<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
class SubjectControllerTest extends CWebTestCase {   	
	protected function setUp() {   	  
		//$this->setBrowser("*iexplore");
		$this->setBrowser("*firefox");
		//$this->setBrowser("*chrome");
		$this->setBrowserUrl("http://localxiaoxin");
	}

	/**************创建科目***************************/
	
	// //科目名称为空
	// public function testSubjectCreateTestCase1()
	// {
	// 	$this->open("/admin.php/subject/create/");
	// 	$this->type("name=Subject[name]", "");   //科目名称
	// 	$this->select("name=Subject[schoolid]", "label=A:AAAA");   //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("科目名称不能为空！");
	// }

	// //学校为空
	// public function testSubjectCreateTestCase2()
	// {
	// 	$this->open("/admin.php/subject/create/");
	// 	$this->type("name=Subject[name]", "这是一个测试科目9.18");   //科目名称
	// 	$this->select("name=Subject[schoolid]", "label=全部");   //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// }
	


	// //创建成功
	// public function testSubjectCreateTestCase3()
	// {
	// 	$this->open("/admin.php/subject/create/");
	// 	$this->type("name=Subject[name]", "这是一个测试科目9.18");   //科目名称
	// 	$this->select("name=Subject[schoolid]", "label=A:AAAA");   //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("科目名称不能为空！");
	// }



	/**************查找科目***************************/

	// //不选择学校
	// public function testSubjectListTestCase1()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->select("name=Subject[schoolid]","label=全部"); //学校
	// 	$this->type("name=Subject[name]","这是一个测试科目9.18"); //科目名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }



	// //不选择科目名称 
	// public function testSubjectListTestCase2()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->select("name=Subject[schoolid]","label=A:AAAA"); //学校
	// 	$this->type("name=Subject[name]",""); //科目名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //选择学校、科目名称 
	// public function testSubjectListTestCase3()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->select("name=Subject[schoolid]","label=A:AAAA"); //学校
	// 	$this->type("name=Subject[name]","这是一个测试科目9.18"); //科目名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }




	/**************修改科目***************************/
	// //科目名称修改为空
	// public function testSubjectUpdateTestCase1()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/subject/update/31']");
	// 	$this->type("name=Subject[name]", "");   //科目名称
	// 	$this->select("name=Subject[schoolid]", "label=A:AAAA");   //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("科目名称不能为空！");
	// }


	// //学校修改为空
	// public function testSubjectUpdateTestCase2()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/subject/update/31']");
	// 	$this->type("name=Subject[name]", "这是一个测试科目");   //科目名称
	// 	$this->select("name=Subject[schoolid]", "label=全部");   //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("请选择学校！");
	// }


	// //修改成功
	// public function testSubjectUpdateTestCase3()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/subject/update/31']");
	// 	$this->type("name=Subject[name]", "这是一个测试科目修改过");   //科目名称
	// 	$this->select("name=Subject[schoolid]", "label=A:AAAA");   //学校
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("科目名称不能为空！");
	// }


	/**************编辑页删除科目***************************/
	// //取消删除科目
	// public function testSubjectUpdateDelTestCase1()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/subject/update/11']"); 
	// 	$this->click("//a[@data-href='/admin.php/subject/delete/11?list=1']");
	// 	$this->click("//a[@class='btn btn-default']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("删除成功");
	// }


	// //确定删除科目
	// public function testSubjectUpdateDelTestCase2()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/subject/update/11']"); 
	// 	$this->click("//a[@data-href='/admin.php/subject/delete/11?list=1']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }


	// //是否已删除
	// public function testSubjectUpdateDelTestCase3()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/subject/update/11']"); 
	// 	$this->click("//a[@data-href='/admin.php/subject/delete/11?list=1']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }


	/**************列表页删除科目***************************/

	// //取消删除科目
	// public function testSubjectListTestCase1()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->click("//a[@data-href='/admin.php/subject/delete/10']");
	// 	$this->click("//a[@class='btn btn-default']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("删除成功");
	// }


	// //确定删除科目
	// public function testSubjectListTestCase2()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->click("//a[@data-href='/admin.php/subject/delete/10']");
	// 	$this->clickAndWait("id=isOk");
	// 	$this->assertTextPresent("删除成功");
	// }

	// //是否已经删除
	// public function testSubjectListTestCase3()
	// {
	// 	$this->open("/admin.php/subject/index/");
	// 	$this->click("//a[@data-href='/admin.php/subject/delete/10']");
	// 	$this->clickAndWait("id=isOk");
	// 	$this->assertTextPresent("删除成功");
	// }
}