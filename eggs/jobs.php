<?php
class Jobs{
	function add($user_id,$jobtype,$joboutput){
		global $jobs;
		$jobs->addjob($user_id,$jobtype,$joboutput);
	}
}
?>
