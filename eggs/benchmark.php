<?php
class Benchmark{
	public $marks = array();

	public function add_mark($msg){
		# get formated microtime 
		$time = sprintf("%2.7f",microtime(1));
		# generate random 5 char string
		$hash = substr(md5(rand()%100000),0,5);
		# check if hash is unique
		if(empty($this->marks[$hash])){
			# put hash in array
			$this->marks[$hash]=array("m"=>$msg,"t"=>$time);
		}else{
			# if hash is not unique try again
			return add_mark($msg);
		}

		return $hash;
	}

	public function remove_mark($id){
		# get again the formatted microtime
		$time = sprintf("%2.7f",microtime(1));
		# check if id is ok
		if(empty($this->marks[$id])){
			# if id is not found trigger error
			trigger_error("The ID provided is invalid. You must first add a mark and then with the right id remove it",E_USER_ERROR);
			return false;
		}

		$time = sprintf("%2.7f",$time-$this->marks[$id]["t"]);
		$this->marks[$id]["f"] = $time;
		return $time;
	}

	public function dump(){
		return $this->marks;
	}

}
?>
