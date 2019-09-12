<?php
require_once "lib/game.inc.php";
$view = new Lights\OptionsView($lights);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Light Em Up! Options</title>
	<link href="game.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php echo $view->present(); ?>
</body>
</html>
