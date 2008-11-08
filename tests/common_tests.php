<?php
class TestOfCommon extends UnitTestCase {
	function testLogCreatesNewFileOnFirstMessage() {
		$urlegg = load_egg("url",1);
        $this->assertTrue($urlegg);
    }

}
?>