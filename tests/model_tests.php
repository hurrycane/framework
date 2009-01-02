<?php
include_once(EGGS_PATH."common.php");
include_once(EGGS_PATH."model.php");
class TestOfModel extends UnitTestCase{
	function testModel(){
		$model=new Model;
		$config=load_config();
		$config["database"]["models"]=array("test");
		$model->config=$config["database"];
		$model->load();

		global $test;
		$test->test();
	}
}
?>
