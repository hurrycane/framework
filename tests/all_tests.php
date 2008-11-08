<?php
require_once('simpletest/autorun.php');
require_once('../index.php');

class AllTests extends TestSuite {
    function AllTests() {
        $this->TestSuite('All tests');
        $this->addFile(SITE_PATH."tests/common_tests.php");
    }
}
?>