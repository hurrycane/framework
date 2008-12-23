<?php
error_reporting(E_ALL);

# determine the path where the site is running
$site_path = str_replace("\\", "/", realpath(dirname(__FILE__)));

# make a constant from the site path
define("SITE_PATH",$site_path."/");

# include more paths and requirments
include_once(SITE_PATH . "config/boot.php");
# include environment specific settings
include_once(SITE_PATH . "config/environment.php");

?>
