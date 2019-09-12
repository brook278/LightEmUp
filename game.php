<?php
require_once "lib/game.inc.php";
$view = new Lights\GameView($lights);
if($view->getRedirect() !== null) {
	header("location: " . $view->getRedirect());
	exit;
}
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
<?php
echo $view->present();
?>
</body>
</html>
