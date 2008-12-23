<?php 
if(!defined("SITE_PATH")){
	exit("No route is defined");
}

# all folder paths are relative to the site path and must not end with a trailing slash
# core library is located in the eggs directory
$eggs_folder = "eggs";
# application folder is where you core is going to be
$apps_folder = "app";

# define constants with the path to the folders
define("EGGS_PATH", SITE_PATH . $eggs_folder . "/");
define("APP_FOLDER",SITE_PATH . $apps_folder . "/");

#include core library 
include_once(EGGS_PATH . "core.php");

?>
