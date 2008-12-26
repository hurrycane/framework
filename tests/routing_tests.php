<?php
include_once(EGGS_PATH."routing.php");

class TestOfRoutingEngine extends UnitTestCase{
	function testRoutingConnect(){
		$routes = new Routes;
		$routes->connect("login/:ceva",
		                 ":controller=>login",
				 ":action=>show");

		$routes->connect("login/:id/altceva",":controller=>login",":action=>show");
		print_r($routes->routing_tree);
		$routes->dump_to_file("routes");

	}
}
?>
