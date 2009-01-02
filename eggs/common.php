<?php
if(!defined("SITE_PATH") || !defined("APP_FOLDER")){
	exit("No route is defined");
}

function load_egg($egg_name,$init = FALSE, $param = FALSE){
	# egg cache
	static $obj_cache = array();
	# check egg cache for object
	if(isset($obj_cache[$egg_name])){
		if($init == FALSE) return ;
		return $obj_cache[$egg_name];
	}
	
	$path_to_egg = EGGS_PATH . $egg_name . ".php";
	
	# include egg file
	if(file_exists($path_to_egg)){
		include_once($path_to_egg);
	
		# updated loaded eggs array
		global $loaded_eggs;
		if(!is_array($loaded_eggs)) $loaded_eggs = array();
		array_push($loaded_eggs,$egg_name);

		if($init){
			$egg_init = & new $egg_name($param);
			
			$obj_cache[$egg_name] = $egg_init;
			return $egg_init;
		}
	}else{
		trigger_error("No class to load from", E_USER_ERROR);
	}
}

function load_config($reset = false){

	# config cache
	static $cfg_cache;
	# if reset empty the cfg_cache
	if($reset) $cfg_cache = array();
	# check if confi is already loaded
	if(!empty($cfg_cache)){
		return $cfg_cache;
	}
	
	# include the config file
	include(SITE_PATH."config/config.php");

	# check if is not damaged
	if(is_array($config)) $cfg_cache = $config;
	else trigger_error("You`re configuration file is damaged",E_USER_ERROR);
	return $config;
}

?>
