<?php
if(!defined("SITE_PATH") || !defined("APP_FOLDER")){
  exit("No route is defined");
}
 
 
// initialize array variable
$config = array();
 
$config["env"] = "development";
// database configuration for production
$config["database"] = array();
// adapter is not yet implemented
$config["database"]["adapter"] = "mysql";
$config["database"]["host"] = "localhost";
$config["database"]["db_name"] = "ceva";
$config["database"]["db_user"] = "root";
$config["database"]["db_pass"] = "";
$config["database"]["models"] = array("test","account");
 
 
// development configuration
$config["development"] = array();
$config["development"]["database"] = $config["database"];
// log is written directly to the hard drive
$config["development"]["log_directly"] = true;
// the caching is disabled
$config["development"]["cache"] = false;
// if cache enabled flush the cache on every request
$config["development"]["flush_cache"] = true;
// generate the routing tree at every request - takes time
$config["development"]["gen_routing_tree"] = true;
 
 
?>
