<?php
session_start();
include_once(EGGS_PATH."common.php");
include_once(EGGS_PATH."controller.php");
include_once(SITE_PATH."tests/fixtures/test_controller.fixture.php");


class TestOfController extends UnitTestCase{
	function testControllerFlash(){
		session_unset();
		$controller = new Controller();
		# sets the ceva from the flash to altceva
		$test = new TestController();
		$this->assertTrue(empty($test->flash));
		$test->index();
		$this->assertEqual($test->flash["ceva"],"altceva");
		# calls the destruct method that puts the flash into the session
		unset($test);
		# reinit test
		$test = new TestController();
		$this->assertEqual($test->flash["ceva"],"altceva");
		$test->index();
		$test->flash["altceva"]="ceva";
		$this->assertEqual($test->flash["ceva"],"altceva");
		$this->assertEqual($test->flash["altceva"],"ceva");
		# the flash remainds unmodified
		unset($test);
		# the flash is now destroyed
		$test = new TestController();
		$this->assertEqual($test->flash["altceva"],"ceva");
		session_destroy();
	}

	function testAfterBefore(){
		$controller = new Controller();
		ob_start();
		$test=new TestController();
		$output=ob_get_contents();
		ob_end_clean();
		$this->assertEqual($output,"before");
		ob_start();
		unset($test);
		$output=ob_get_contents();
		ob_end_clean();
		$this->assertEqual($output,"after");
	}

	function testHeader(){
		ob_start();
		$test=new TestController();
		$test->update();
		$output=ob_get_contents();
		ob_end_clean();
		$this->assertTrue(in_array("Location: http://google.com",$test->header));
	}
	function testController(){
		copy(SITE_PATH."tests/fixtures/controller_routes.fixture.php",SITE_PATH."config/_routes.php");
		# test connect
		$request=load_egg("request",1);
		$request->uri_parts=explode("/","testz/25/delete");
		$request->request_method="post";
		$routing=new Routing($request,"_routes");
		$request_info=$routing->climb();
		$request->request_info=$request_info;
		$controller = new Controller();

		ob_start();
		$controller->load($request);
		$output=ob_get_contents();
		ob_end_clean();
		$this->assertEqual($output,"Hello World");

		unlink(SITE_PATH."config/_routes.php");
		unlink(SITE_PATH."config/_routes.tmp.php");


	}


}
?>
