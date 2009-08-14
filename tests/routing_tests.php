<?php
include_once(EGGS_PATH."request.php");
include_once(EGGS_PATH."routes.php");
include_once(EGGS_PATH."routing.php");


class TestOfRoutingEngine extends UnitTestCase{
	function testRoutingDumpToFile(){
		$routes = new Routes;

		$routes->connect("login/:ceva",
		                 ":controller=>login",
				 ":action=>show");

		$routes->connect("login/:id/altceva",
				 ":controller=>login",
				 ":action=>show",
				 ":method=>GET");

		$routes->dump_to_file("routes");
		include_once(SITE_PATH."config/routes.tmp.php");
		$this->assertEqual($routes->routing_tree,$root);
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
	function testRESTfulRouting(){
		$routes = new Routes;
		$routes->resources("teams");
		$routes->dump_to_file("restful");
		include_once(SITE_PATH."config/restful.tmp.php");
		unlink(SITE_PATH."config/restful.tmp.php");
		$this->assertEqual($routes->routing_tree,$root);
	}
	function testNestedRoutes(){
		$routes = new Routes;
		$nested =$routes->resources("teams");
		$nested->resources("ceva");
		$routes->dump_to_file("nested");
		include_once(SITE_PATH."config/nested.tmp.php");
		$this->assertEqual($routes->routing_tree,$root);
		unlink(SITE_PATH."config/nested.tmp.php");
	}

}
?>
