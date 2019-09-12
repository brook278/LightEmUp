<?php

require __DIR__ . "/../vendor/autoload.php";

// Start the PHP session system
session_start();

define("LIGHTS_SESSION", 'lights');

// If there is a system in the session, use that. Otherwise, create one
if(!isset($_SESSION[LIGHTS_SESSION])) {
	$_SESSION[LIGHTS_SESSION] = new Lights\Lights(__DIR__ . '/..');
}

// $_SESSION[LIGHTS_SESSION] = new Lights\Lights(__DIR__ . '/..');

$lights = $_SESSION[LIGHTS_SESSION];