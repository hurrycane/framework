<?php
include_once(EGGS_PATH."request.php");
class TestOfRequest extends UnitTestCase{
	function testRequestMethod(){
		$request = new Request;
		$this->assertEqual($request->request_method,strtolower($_SERVER["REQUEST_METHOD"]));
	}

	function testRequestFormat(){
		$request = new Request;
		$this->assertEqual($request->format,"html");
	}

	function testRequestRemoteIp(){
		$request = new Request;
		$this->assertEqual($request->remote_ip,$_SERVER["REMOTE_ADDR"]);
	}

	function testRequestHostPortUrl(){
		$request = new Request;
		$this->assertEqual($request->host,$_SERVER["SERVER_NAME"]);
		$this->assertEqual($request->port,$_SERVER["SERVER_PORT"]);
		$this->assertEqual($request->host_with_port,$_SERVER["HTTP_HOST"]);
	}
	function testRequestPathQuery(){
		$request = new Request;
		$this->assertEqual($request->query_string,$_SERVER["QUERY_STRING"]);
		$this->assertEqual($request->path,$_SERVER["REQUEST_URI"]);
	}
}
	
?>
