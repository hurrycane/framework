<?php
# Test for the common functions
include_once(EGGS_PATH."common.php");

class TestOfCommon extends UnitTestCase {

	function testLoadingEgg(){
		$url = load_egg("url",1);
		$this->assertNotNull($url);
	}

	function testLoadEggCache(){
		$url = load_egg("url",1);
		$url2 = load_egg("url",1);
		$this->assertIdentical(spl_object_hash($url),spl_object_hash($url2));

	}

	function testLoadEggNonInit(){
		$url = load_egg("url");
		$this->assertNull($url);
	}

	function testLoadNonExistingEgg(){
		$this->expectError();
		$url = load_egg(rand()%100);
	}

	function testLoadedArray(){
		global $loaded_eggs;
		$url = load_egg("url",1);
		$this->assertNotNull(array_search("url",$loaded_eggs));
	}

	function testLoadConfig(){
		$config = load_config();
		$this->assertIsA($config,array());
	}

	function testLoadConfigCache(){
		$config = load_config();
		$config2 = load_config();
		$this->assertEqual($config,$config2);
	}

	function testLoadConfigErrorAndResetFunction(){
		$path_to_config = SITE_PATH . "config/";
		if(file_exists($path_to_config."config.php")) {
			rename($path_to_config."config.php",$path_to_config."config.bkp.php");
			$handle = fopen($path_to_config."config.php","w");
			$content = '
			<?php
				$config = 2;	
			?>
			';
			fwrite($handle,$content);
			fclose($handle);
			$this->expectError();
			$config = load_config(1);
			$cfg=$path_to_config."config.php";
			unset($cfg);
			rename($path_to_config."config.bkp.php",$path_to_config."config.php");

		}
	}

}
?>
