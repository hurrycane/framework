<?php
$routes->resources("callback");
$routes->connect("request/twitter/:id",":controller=>req",":action=>twdo");

?>
