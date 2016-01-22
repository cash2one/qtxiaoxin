<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
class CoursesControllerTest extends CWebTestCase {   	
	protected function setUp() {   	  
		//$this->setBrowser("*iexplore");
		$this->setBrowser("*firefox");
		//$this->setBrowser("*chrome");
		$this->setBrowserUrl("http://localxiaoxin");
	}

	

	/**************查找课程***************************/

	// //学校、年级、班级名称
	// public function testCoursesListTestCase4()
	// {
	// 	$this->open("/admin.php/courses/index/");
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->select("name=Class[grade]","label=二年级"); //年级
	// 	$this->type("name=Class[name]","邀请码测试"); //班级名称
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	// $this->waitForPageToLoad("30");
	// 	$this->assertTextNotPresent("暂无数据");
	// }



	// //修改班主任
	// public function testCoursesUpdateTestCase1()
	// {
	// 	$this->open("/admin.php/courses/index/");
	// 	$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 	$this->fireEvent("name=Class[sid]","change");  
	//  	$this->pause(1000);  
	//  	$this->select("name=Class[grade]","label=一年级"); //年级
	// 	$this->clickAndWait("//input[@type='submit']");
	// 	$this->select("id=teacher_3","label=老爷爷"); //学校
	// 	$this->assertTextPresent("修改成功");
	// }



	// //修改课程1
	// public function testCoursesUpdateTestCase2()
	// {
	// 		$this->open("/admin.php/courses/index/");
	// 		$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 		$this->fireEvent("name=Class[sid]","change");  
	// 	 	$this->pause(1000);  
	// 	 	$this->select("name=Class[grade]","label=一年级"); //年级
	// 		$this->clickAndWait("//input[@type='submit']");
	// 		$this->select("id=courses_7","label=老爷爷"); //学校
	// 		$this->assertTextPresent("修改成功");
	// }

	// //修改课程2
	// public function testCoursesUpdateTestCase3()
	// {
	// 		$this->open("/admin.php/courses/index/");
	// 		$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 		$this->fireEvent("name=Class[sid]","change");  
	// 	 	$this->pause(1000);  
	// 	 	$this->select("name=Class[grade]","label=一年级"); //年级
	// 		$this->clickAndWait("//input[@type='submit']");
	// 		$this->select("id=courses_8","label=老爷爷"); //学校
			
	// 		$this->assertTextPresent("修改成功");
	// }


	// //修改课程3
	// public function testCoursesUpdateTestCase4()
	// {
	// 		$this->open("/admin.php/courses/index/");
	// 		$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 		$this->fireEvent("name=Class[sid]","change");  
	// 	 	$this->pause(1000);  
	// 	 	$this->select("name=Class[grade]","label=一年级"); //年级
	// 		$this->clickAndWait("//input[@type='submit']");
	// 		$this->select("id=courses_9","label=老爷爷"); //学校
			
	// 		$this->assertTextPresent("修改成功");
	// }


	// //修改课程4
	// public function testCoursesUpdateTestCase5()
	// {
	// 		$this->open("/admin.php/courses/index/");
	// 		$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 		$this->fireEvent("name=Class[sid]","change");  
	// 	 	$this->pause(1000);  
	// 	 	$this->select("name=Class[grade]","label=一年级"); //年级
	// 		$this->clickAndWait("//input[@type='submit']");
	// 		$this->select("id=courses_10","label=老爷爷"); //学校
			
	// 		$this->assertTextPresent("修改成功");
	// }


	// //修改课程5
	// public function testCoursesUpdateTestCase6()
	// {
	// 		$this->open("/admin.php/courses/index/");
	// 		$this->select("name=Class[sid]","label=A:AAAA"); //学校
	// 		$this->fireEvent("name=Class[sid]","change");  
	// 	 	$this->pause(1000);  
	// 	 	$this->select("name=Class[grade]","label=一年级"); //年级
	// 		$this->clickAndWait("//input[@type='submit']");
	// 		$this->select("id=courses_11","label=老爷爷"); //学校
			
	// 		$this->assertTextPresent("修改成功");
	// }

	
}