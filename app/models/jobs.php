<?php
class JobsModel extends ModelBase{
	function add($user_id,$job_type,$output=false){
		$this->query("INSERT INTO jobs (`user_id`,`job_type`,`output`,`served`) VALUES ('?','?','?','0')",$user_id,$job_type,$output);
	}
}

?>
