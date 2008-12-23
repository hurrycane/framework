<?php
# Tests for benchmark egg
include_once(EGGS_PATH."benchmark.php");
class TestOfBenchmark extends UnitTestCase{

	function testAddMarkReturnsRandomIds(){
		$benchmark = new Benchmark;
		
		while(1){
			$number = rand()%10;
			if($number != 0) break;
		}

		$ids = array();
		$found = FALSE;
		for($i=0;$i<=$number;$i++){
			$t = $benchmark->add_mark(rand()%1000);
			if(in_array($t,$ids)){
				$found = TRUE;
				break;
			}

			array_push($ids,$t);
		}
		$this->assertTrue(!$found);
	}

	function testRemoveMarkReturnsElapsedTime(){
		$benchmark = new Benchmark;
		$a = $benchmark->add_mark("Start test");
		$b = $benchmark->remove_mark($a);
		$this->assertNotNull($b);
	}

	function testRemoveMarkWithWrongId(){
		$benchmark = new Benchmark;
		$this->expectError();
		$benchmark->remove_mark("aaaaa");
	}

	function testDumpReturnArrayWithMarks(){
		$benchmark = new Benchmark;
		$a = $benchmark->add_mark("Start test");
		$b = $benchmark->remove_mark($a);
		$c = $benchmark->dump();
		$this->assertIsA($c,array());
	}

}
?>
