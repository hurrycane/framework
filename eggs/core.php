<?php
if(!defined("SITE_PATH") || !defined("APP_FOLDER")){
	exit("No route is defined");
}

# include common functions
include_once(EGGS_PATH ."common.php");

# FIXME enviornment specific log
$log = load_egg("log",1,"application");

# base controller has the table list 
# controller db_#{table_name}
# $this->db_users->find("Gigel");
# $this->db_users->auth("gigel","password");
# dinamic loading of models and database resources

# $controller = load_egg("controller",1);
# $request = $controller->request();
# $routing = load_egg("routing",1);
# $routing_info = $routing->route();
# -> determines error in routing 
# $controller->post_controller();
# -> if error in routing/if page is cached
# $controller->load($routing_info);
# $controller->post_controller();
?>
