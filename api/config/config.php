<?php
//Variable to get name of root folder project dinamic
$root = "http://".$_SERVER['HTTP_HOST']."/";
//write name of directory from project ej* if your projects is "c:>xampp/htdocs/camelTest" you need to set $name_project = "camelTest" *
$name_project = "camelTest";
$root .= $name_project;


//DEFINES
define("BASE_URL", $root);
define("EXPIRE_MINS_INAC", 3);


?>