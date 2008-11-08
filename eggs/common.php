<?php
if(!defined("SITE_PATH") || !defined("APP_FOLDER")){
	exit("No route is defined");
}

function load_egg($egg_name,$init = FALSE, $param = FALSE){
	# egg cache
	static $obj_cache = array();
	
	# check egg cache for object
	if(isset($obj_cache[$egg_name])){
		return $obj_cache[$egg_name];
	}
	
	$path_to_egg = EGGS_PATH . $egg_name . ".php";
	
	# include egg file
	if(file_exists($path_to_egg)){
		include_once($path_to_egg);
		
		if($init){
			$egg_init = & new $egg_name($param);
			
			$obj_cache[$egg_name] = $egg_init;
			return $egg_init;
		}
	}else{
		trigger_error("No class to load from", E_USER_ERROR);
	}
}


?>