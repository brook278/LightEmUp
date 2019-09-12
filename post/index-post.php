<?php
require_once "../lib/game.inc.php";
$controller = new \Lights\IndexController($lights, $_POST);
//echo $controller->showRedirect();
header("location: " . $controller->getRedirect());