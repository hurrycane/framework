<?php
class TestzController extends Controller{
	function __construct(){
		$this->init();
	}

	function delete(){
		$this->view->data("test","World");
	}
}
?>
