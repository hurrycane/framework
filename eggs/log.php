<?php
class Log{
	private $log_content = array();
	private $path_to_log;
	private $handle;

	public function __construct($file_name){
		$restricted = array("access","error");

		if(in_array($file_name,$restricted)){
			trigger_error("Log name is restricted",E_USER_ERROR);
		}elseif(strpbrk($file_name, ".")){
			trigger_error("Extension is not needed",E_USER_ERROR);
		}else{
			$this->path_to_log = SITE_PATH . "tests/log/";
			$this->handle = fopen($this->path_to_log.$file_name.".log","a");
			$this->add("Processing for ".$_SERVER["REMOTE_ADDR"] . 
			           " at " . date("Y-m-d H:i:s"). 
				   " [".$_SERVER["REQUEST_METHOD"]."]");
		}
	}

	public function add($message){
		array_push($this->log_content,$message);
	}

	function __destruct(){
		foreach($this->log_content as $line){
			fwrite($this->handle,$line."\n");
		}

		if($this->handle) fclose($this->handle);
	}

}
?>
