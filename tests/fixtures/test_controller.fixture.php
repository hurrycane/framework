<?php
class TestController extends Controller{
	function __construct(){
		$this->init();
	}

	function index(){
		$this->flash["ceva"]="altceva";
	}

	function show(){
		$this->setcookie("test_cookie","lakete",time()+3600);
	}

	function check_show(){
		return $this->cookie["test_cookie"];
	}

	function before(){
		echo "before";
	}

	function after(){
		echo "after";
	}

	function update(){
		$this->header("Location: http://google.com");
	}

	function edit(){
	}
}
?>
