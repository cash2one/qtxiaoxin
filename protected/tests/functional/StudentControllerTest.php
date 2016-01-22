<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
class StudentControllerTest extends CWebTestCase {   	
	protected function setUp() {   	  
		//$this->setBrowser("*iexplore");
		$this->setBrowser("*firefox");
		//$this->setBrowser("*chrome");
		$this->setBrowserUrl("http://localxiaoxin");
	}

	/**************创建学生***************************/
	
	// //不填写学生名称
	// public function testStudentCreateTestCase1()
	// {
	// 	$this->open("/admin.php/student/create/");
	// 	//$this->type("name=Student[name]", "");   //学生名称
	// 	$this->type("name=mobilephone[]", "18580507445");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=classId[]","label=一班"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生姓名不能为空！");
	// }


	// //不填写绑定手机（bug）
	// public function testStudentCreateTestCase2()
	// {
	// 	$this->open("/admin.php/student/create/");
	// 	$this->type("name=Student[name]", "这是一个测试学生2");   //学生名称
	// 	$this->type("name=mobilephone[]", "");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=classId[]","label=一班"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// }


	// //不填写称谓
	// public function testStudentCreateTestCase8()
	// {
	// 	$this->open("/admin.php/student/create/");
	// 	$this->type("name=Student[name]", "这是一个测试学生2");   //学生名称
	// 	$this->type("name=mobilephone[]", "18580507445");   //绑定手机
	// 	$this->type("name=role[]", "");   //称谓
	// 	$this->select("name=schoolId[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=classId[]","label=一班"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("称谓名称不能为空！");
	// }


	// //不选择学校班级
	// public function testStudentCreateTestCase3()
	// {
	// 	$this->open("/admin.php/student/create/");
	// 	$this->type("name=Student[name]", "这是一个测试学生");   //学生名称
	// 	$this->type("name=mobilephone[]", "18580507445");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=全部"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=classId[]","label=全部"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择班级！");
	// }


	// //选择学校不选择班级
	// public function testStudentCreateTestCase4()
	// {
	// 	$this->open("/admin.php/student/create/");
	// 	//$this->type("name=Student[name]", "这是一个测试学生");   //学生名称
	// 	$this->type("name=mobilephone[]", "18580507445");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=classId[]","label=全部"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("请选择班级！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// }



	// //选择学校班级
	// public function testStudentCreateTestCase5()
	// {
	// 	$this->open("/admin.php/student/create/");
	// 	$this->type("name=Student[name]", "这是一个测试学生2");   //学生名称
	// 	$this->type("name=mobilephone[]", "18580507445");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=classId[]","label=一班"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生姓名不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("称谓名称不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择班级！");
	// }





	// //添加班级创建(暂时未测试)
	// public function testStudentCreateTestCase7()
	// {
	// 	$this->open("/admin.php/student/create/");
	// 	$this->type("name=Student[name]", "这是一个测试学生");   //学生名称
	// 	$this->type("name=Student[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=红苹果"); //班级
	// 	$this->clickAndWait("name=Student[did]"); //点击添加
	// 	$this->select("name=sid[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=sid[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=did[]","label=绿苹果"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生名称不能为空！");
	// }




	// //删除一个班级创建(未测试)
	// public function testStudentCreateTestCase6()
	// {
	// 	$this->open("/admin.php/student/create/");
	// 	$this->type("name=Student[name]", "这是一个测试学生2");   //学生名称
	// 	$this->type("name=Student[mobilephone]", "18580507445");   //绑定手机
	// 	$this->click("//a[@id='del']");
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择班级！");
	// }



	/**************查找学生***************************/



	// //全部
	// public function testStudentListTestCase1()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->select("name=Student[sid]","label=全部"); //学校
	// 	$this->fireEvent("name=Student[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=Student[cid]","label=全部"); //班级
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }

	// //学校
	// public function testStudentListTestCase2()
	// {
	// 	$this->open("/admin.php/Student/index/");
	// 	$this->select("name=Student[sid]","label=A:AAAA"); //学校
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //学校、班级
	// public function testStudentListTestCase3()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->select("name=Student[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Student[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=Student[cid]","label=一班"); //班级
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }


	// //姓名
	// public function testSchoolListTestCase4()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->type("name=Student[name]", "aaa22");   //姓名
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("暂无数据");
	// }


	// //绑定手机
	// public function testSchoolListTestCase5()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->type("name=Student[mobilephone]", "11111122211112");   //绑定手机
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("暂无数据");
	// }


	// //学校、班级、姓名、绑定手机
	// public function testSchoolListTestCase6()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->select("name=Student[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Student[sid]","change");  
	// 	$this->pause(1000);  
	// 	$this->select("name=Student[cid]","label=一班"); //班级
	// 	$this->type("name=Student[name]", "aaa");   //姓名
	// 	$this->type("name=Student[mobilephone]", "11111111112");   //绑定手机
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// $this->assertTextNotPresent("暂无数据");
	// }


	/**************修改学生***************************/

	// //学生名称修改为空
	// public function testStudentUpdateTestCase1()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/164801']");
	// 	$this->type("name=Student[name]", "");   //学生名称
	// 	$this->type("name=mobilephone[]", "18500000000");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=cid[]","label=一班"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生姓名不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("称谓名称不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择班级！");
	// }


	// //绑定手机为空
	// public function testStudentUpdateTestCase2()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/164801']");
	// 	$this->type("name=Student[name]", "这是一个测试学生2");   //学生名称
	// 	$this->type("name=mobilephone[]", "");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=cid[]","label=一班"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("称谓名称不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择班级！");
	// }



	// //班级学校修改为空
	// public function testStudentUpdateTestCase3()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/164801']");
	// 	$this->type("name=Student[name]", "这是一个测试学生2");   //学生名称
	// 	$this->type("name=mobilephone[]", "18580507445");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=全部"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=cid[]","label=全部"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("称谓名称不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择班级！");
	// }



	// //选择学校不选择班级
	// public function testStudentUpdateTestCase4()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/164801']");
	// 	$this->type("name=Student[name]", "这是一个测试学生2");   //学生名称
	// 	$this->type("name=mobilephone[]", "18580507445");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=cid[]","label=全部"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("称谓名称不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择班级！");
	// }



	// //选择学校班级
	// public function testStudentUpdateTestCase5()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/164801']");
	// 	$this->type("name=Student[name]", "这是一个测试学生2变3");   //学生名称
	// 	$this->type("name=mobilephone[]", "18580507445");   //绑定手机
	// 	$this->type("name=role[]", "mother");   //称谓
	// 	$this->select("name=schoolId[]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=schoolId[]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=cid[]","label=一班"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("称谓名称不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择班级！");
	// }




	// //添加班级(暂时未测试)
	// public function testStudentUpdateTestCase7()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/156301']");
	// 	$this->type("name=Student[name]", "这是一个测试学生");   //学生名称
	// 	$this->type("name=Student[mobilephone]", "18580507445");   //绑定手机
	// 	$this->select("name=Student[sid][]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Student[sid][]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=Student[did]","label=班级1"); //班级
	// 	$this->clickAndWait("name=Student[did]"); //点击添加
	// 	$this->select("name=Student[sid][]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Student[sid][]","change");
	// 	$this->pause(1000);  
	// 	$this->select("name=Student[did]","label=班级1"); //班级
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// }



	// //删除班级(暂未测试)
	// public function testStudentUpdateTestCase6()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/156301']");
	// 	$this->type("name=Student[name]", "这是一个测试学生2");   //学生名称
	// 	$this->type("name=Student[mobilephone]", "18580507445");   //绑定手机
	// 	$this->click("//a[@id='del']");    //页面需要加个id=del在删除按钮上
	//     $this->click("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("学生名称不能为空！");
	// 	$this->assertTextNotPresent("手机号码不能为空！");
	// 	$this->assertTextNotPresent("请选择学校！");
	// 	$this->assertTextNotPresent("请选择班级！");
	// }


	/**************编辑页里面的删除*********************/
	// //取消删除科目
	// public function testStudentUpdateDelTestCase1()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/164801']"); 
	// 	$this->click("//a[@data-href='/admin.php/student/delete/164801?list=1']");
	// 	$this->click("//a[@class='btn btn-default']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("删除学生成功");
	// }


	// // //确定删除科目
	// public function testStudentUpdateDelTestCase2()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/165901']"); 
	// 	$this->click("//a[@data-href='/admin.php/student/delete/165901?list=1']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除学生成功");
	// }


	// // //确定删除科目
	// public function testStudentUpdateDelTestCase3()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->clickAndWait("//a[@href='/admin.php/student/update/165901']"); 
	// 	$this->click("//a[@data-href='/admin.php/student/delete/165901?list=1']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除学生成功");
	// }



	/**************删除学生***************************/

	// //取消删除学生
	// public function testStudentListTestCase1()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->click("//a[@data-href='/admin.php/student/delete/165801']");
	// 	$this->click("//a[@class='btn btn-default']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("删除成功");
	// }


	// //确定删除学生
	// public function testStudentListTestCase2()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->click("//a[@data-href='/admin.php/student/delete/165801']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }

	// //是否已经删除
	// public function testStudentListTestCase3()
	// {
	// 	$this->open("/admin.php/student/index/");
	// 	$this->click("//a[@data-href='/admin.php/student/delete/165801']");
	// 	$this->clickAndWait("id=isOk");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextPresent("删除成功");
	// }


}