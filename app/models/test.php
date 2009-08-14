<?php

class TestModel extends ModelBase{
	function test(){
		echo "test";
	}

	function show(){
	#	$this->query("SELECT * FROM `dummy` WHERE `ceva` = '?' and `altceva`='?'",5,"aa");
#		$ar = $this->fetch_object();
#		echo $ar->altceva;
		
	}
}

?>
