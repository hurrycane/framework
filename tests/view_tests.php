<?php
include_once(EGGS_PATH."view.php");
class TestOfView extends UnitTestCase{

	function testView(){
		$view = new View;
		$view->no_layout=true;
		$view->load("test_view");
		$view->data("test","World");
		ob_start();
		$view->dump(array("controller"=>"test","action"=>"test"));
		$output=ob_get_contents();
		ob_end_clean();
		$this->assertEqual($output,"Hello World");
	}
}

?>
