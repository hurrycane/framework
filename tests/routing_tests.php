<?php
include_once(EGGS_PATH."routing.php");

class TestOfRoutingEngine extends UnitTestCase{
	function testRoutingDumpToFile(){
		$routes = new Routes;
		$routes->connect("login/:ceva",
		                 ":controller=>login",
				 ":action=>show");

		$routes->connect("login/:id/altceva",
				 ":controller=>login",
				 ":action=>show");

		$routes->dump_to_file("routes");
		include_once(SITE_PATH."config/routes.tmp.php");
		$this->assertIdentical($routes->routing_tree,$root);
		unlink(SITE_PATH."config/routes.tmp.php");

	}

	function testRoutingConnectDoubleIdentityPoint(){
		$routes = new Routes;
		$routes->connect("login/:ceva",
		                 ":controller=>login",
				 ":action=>show");

		$routes->connect("login/:id/altceva",
				 ":controller=>login",
				 ":action=>show");
		$this->assertTrue(count($routes->routing_tree[0][0]["name"])==2);
	}
}
?>
