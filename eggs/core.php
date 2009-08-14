<?php
if(!defined("SITE_PATH") || !defined("APP_FOLDER")){
	exit("No route is defined");
}

# include common functions
include_once(EGGS_PATH ."common.php");

# FIXME enviornment specific log
$log = load_egg("log",1,"application");

# loading request info
$request=load_egg("request",1);
# loading routing info
$routing=load_egg("routing",1,$request);
$request_info=$routing->climb();
$request->request_info=$request_info;

$controller=load_egg("controller",1);
$controller->load($request);
# -> determines error in routing 
#$controller->post_controller();
# -> if error in routing/if page is cached
# $controller->load($routing_info);
# $controller->post_controller();
?>
