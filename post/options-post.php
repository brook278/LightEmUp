<?php
require_once "../lib/game.inc.php";
$controller = new \Lights\OptionsController($lights, $_POST);
//echo $controller->showRedirect();
header("location: " . $controller->getRedirect());