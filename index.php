<?php
require_once "lib/game.inc.php";
//$_SESSION[LIGHTS_SESSION] = new Lights\Lights(__DIR__);
//$lights = $_SESSION[LIGHTS_SESSION];
$view = new Lights\IndexView($lights);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Light Em Up!</title>
    <script src="dist/main.js"></script>
	<link href="game.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php echo $view->present(); ?>
</body>
</html>
