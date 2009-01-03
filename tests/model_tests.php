<?php
include_once(EGGS_PATH."common.php");
include_once(EGGS_PATH."model.php");
class TestOfModel extends UnitTestCase{
	function setUp(){
		if(file_exists(SITE_PATH."/config/config.php")){
			rename(SITE_PATH."/config/config.php",SITE_PATH."/config/config.bkp.php");
		}
		copy(SITE_PATH."tests/fixtures/config_model.fixture.php",SITE_PATH."config/config.php");

	}

	function tearDown(){
		if(filesize(SITE_PATH."/config/config.php")==filesize(SITE_PATH."/tests/fixtures/config_model.fixture.php")){
			unlink(SITE_PATH."/config/config.php");
		}

		if(file_exists(SITE_PATH."/config/config.bkp.php")){
			rename(SITE_PATH."/config/config.bkp.php",SITE_PATH."/config/config.php");
		}

	}
	function testModel(){
		#$model=new Model;
		#$config=load_config();
		#$model->config=$config["database"];
		#$model->load();

	#	global $test;
	#	$test->test();
	}

	function testModelConnection(){
		$model=new Model;
		$config=load_config();
		$model->config=$config["database"];
		$model->load();

		global $test;
		echo "<br />";
		$test->show();
	}

}
?>
