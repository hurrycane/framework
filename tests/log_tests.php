<?php
# Tests for log functions
include_once(EGGS_PATH."log.php");
class TestOfLog extends UnitTestCase{
	function testLogConstructorCreatesFileInLogFolder(){
		$log = new Log("test");
		$path_to_log = TESTS_PATH."/log/test.log";
		$this->assertTrue(file_exists($path_to_log));
		unlink($path_to_log);
	}

	function testLogTriggersErrorOnDifferentFolder(){
		$this->expectError();
		$log = new Log("../test");
		
	}

	function testLogTriggersErrorOnRestrictedName(){
		$this->expectError();
		$log = new Log("access");
		
	}

	function testLogAddLineToLog(){
		$log = new Log("test");
		unset($log);
		$handle = fopen(TESTS_PATH."/log/test.log","r");
		$r = fgets($handle);
		$this->assertNotNull(r);
		unlink(TESTS_PATH."/log/test.log");
	}

}
?>
