<?php
class ReqController extends Controller{
	function __construct(){
		$this->init();
	}

	function twdo(){
		switch($this->request->uri_parts[2]){
			case "update":
				global $jobs;
				$jobs->add(1,"facebook_get_stream","yeetalx");
			break;
			default:
				echo "a";
			break;
		}
	}

}
?>
