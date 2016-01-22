<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
class TeacherControllerTest extends CWebTestCase {   	
	protected function setUp() {   	  
		//$this->setBrowser("*iexplore");
		$this->setBrowser("*firefox");
		//$this->setBrowser("*chrome");
		$this->setBrowserUrl("http://localxiaoxin");
	}

	/**************创建教师***************************/
	
	// //不填写教师名称
	// public function testTeacherCreateTestCase1()
	// {
	// 	$this->open("/admin.php/teacher/create/");
	// 	//$this->type("name=Teacher[name]", "");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=红苹果"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// }


	// //不填写绑定手机
	// public function testTeacherCreateTestCase2()
	// {
	// 	$this->open("/admin.php/teacher/create/");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=红苹果"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// }



	// //不选择学校部门部门
	// public function testTeacherCreateTestCase3()
	// {
	// 	$this->open("/admin.php/teacher/create/");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=全部"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	//$this->select("name=did[]","label=全部"); //部门
	//     $this->click("//input[@type='submit']");
	// 	 //$this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// }


	// //选择学校不选择部门
	// public function testTeacherCreateTestCase4()
	// {
	// 	$this->open("/admin.php/teacher/create/");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=全部"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择部门！");
	// }



	// //选择学校部门
	// public function testTeacherCreateTestCase5()
	// {
	// 	$this->open("/admin.php/teacher/create/");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=红苹果"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择部门！");
	// }




	// //删除一个部门创建
	// public function testTeacherCreateTestCase6()
	// {
	// 	$this->open("/admin.php/teacher/create/");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师2");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->click("//a[@id='del']");
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择部门！");
	// }




	// //添加部门创建(暂时未测试)
	// public function testTeacherCreateTestCase7()
	// {
	// 	$this->open("/admin.php/teacher/create/");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=红苹果"); //部门
	// 	$this->clickAndWait("name=Teacher[did]"); //点击添加
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=绿苹果"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// }






	/**************查找教师***************************/



	// //全部
	// public function testTeacherListTestCase1()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->select("name=Teacher[sid]","label=全部"); //学校
	// 	$this->fireEvent("name=Teacher[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=Teacher[did]","label=全部"); //部门
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }

	// //学校
	// public function testTeacherListTestCase2()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->select("name=Teacher[sid]","label=A:AAAA"); //学校
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //学校、部门
	// public function testTeacherListTestCase3()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->select("name=Teacher[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Teacher[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=Teacher[did]","label=红苹果"); //部门
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //姓名
	// public function testSchoolListTestCase4()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->type("name=Teacher[name]", "dongdong是");   //姓名
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("暂无数据");
	// }


	// //绑定手机
	// public function testSchoolListTestCase5()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->type("name=Teacher[mobilephone]", "18948750132");   //绑定手机
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("暂无数据");
	// }


	// //学校、部门、姓名、绑定手机
	// public function testSchoolListTestCase6()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->select("name=Teacher[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Teacher[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=Teacher[did]","label=红苹果"); //部门
	// 	$this->type("name=Teacher[name]", "校信");   //姓名
	// 	$this->type("name=Teacher[mobilephone]", "18948750132");   //绑定手机
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("暂无数据");
	// }


	/**************修改教师***************************/

	// //教师名称修改为空
	// public function testTeacherUpdateTestCase1()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156301']");
	//     $this->type("name=Teacher[name]", "");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=红苹果"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择部门！");
	// }


	// //绑定手机为空
	// public function testTeacherUpdateTestCase2()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156301']");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=红苹果"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择部门！");
	// }



	// //部门学校修改为空
	// public function testTeacherUpdateTestCase3()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156301']");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=全部"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=全部"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择部门！");
	// }



	// //选择学校不选择部门
	// public function testTeacherUpdateTestCase4()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156301']");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=全部"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择部门！");
	// }



	// //选择学校部门
	// public function testTeacherUpdateTestCase5()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156301']");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=红苹果"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择部门！");
	// }



	// //删除部门
	// public function testTeacherUpdateTestCase6()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156301']");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师2");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->click("//a[@id='del']");    //页面需要加个id=del在删除按钮上
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择部门！");
	// }


	// //添加部门(暂时未测试)
	// public function testTeacherUpdateTestCase7()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156301']");
	// 	$this->type("name=Teacher[name]", "这是一个测试教师");   //教师名称
	// 	$this->type("name=Teacher[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=Teacher[sid][]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Teacher[sid][]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=Teacher[did]","label=部门1"); //部门
	// 	$this->clickAndWait("name=Teacher[did]"); //点击添加
	// 	$this->select("name=Teacher[sid][]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Teacher[sid][]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=Teacher[did]","label=部门1"); //部门
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("教师名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// }


	/**************编辑页里面的删除*********************/
	// //取消删除科目
	// public function testTeacherUpdateDelTestCase1()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156701']"); 
	// 	$this->click("//a[@data-href='/admin.php/teacher/delete/156701?list=1']");
	// 	$this->click("//a[@class='btn btn-default']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("删除成功");
	// }


	// //确定删除科目
	// public function testTeacherUpdateDelTestCase2()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156701']"); 
	// 	$this->click("//a[@data-href='/admin.php/teacher/delete/156701?list=1']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }


	// //是否已删除
	// public function testTeacherUpdateDelTestCase3()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/teacher/update/156701']"); 
	// 	$this->click("//a[@data-href='/admin.php/teacher/delete/156701?list=1']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }






	/**************删除教师***************************/

	// //取消删除教师
	// public function testTeacherListTestCase1()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->click("//a[@data-href='/admin.php/teacher/delete/156901']");
	// 	$this->click("//a[@class='btn btn-default']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("删除成功");
	// }


	// //确定删除教师
	// public function testTeacherListTestCase2()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->click("//a[@data-href='/admin.php/teacher/delete/156901']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }

	// //是否已经删除
	// public function testTeacherListTestCase3()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->click("//a[@data-href='/admin.php/teacher/delete/156901']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }

	/**************重置密码******************/

	
	// public function testTeacherPasswordTestCase1()
	// {
	// 	$this->open("/admin.php/teacher/index/");
	// 	$this->click("//a[@data-href='/admin.php/range/initmemberpwd/155701']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("修改成功");
	// }
}