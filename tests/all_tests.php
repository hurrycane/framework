<?php
require_once('simpletest/autorun.php');

$site_path = str_replace("\\", "/", realpath(dirname(__FILE__)));
define(TESTS_PATH,$site_path);

// site variables
define(SITE_PATH,substr($site_path,0,strrpos($site_path,"/"))."/");

$eggs_folder = "eggs";
$apps_folder = "app";

# define constants with the path to the folders
define("EGGS_PATH", SITE_PATH . $eggs_folder . "/");
define("APP_FOLDER",SITE_PATH . $apps_folder . "/");

class AllTests extends TestSuite {
    function AllTests() {
        $this->TestSuite('All tests');
        $this->addFile(TESTS_PATH."/common_tests.php");
        $this->addFile(TESTS_PATH."/log_tests.php");
        $this->addFile(TESTS_PATH."/benchmark_tests.php");

    }
    
}

?>
