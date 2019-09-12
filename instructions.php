<?php
require_once "lib/game.inc.php";
$view = new Lights\InstructionsView($lights);
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Light Em Up! Instructions</title>
	<link href="game.css" type="text/css" rel="stylesheet" />
</head>

<body>
<?php
echo $view->present_header();
?>
<div class="body">

<div class="instructions">
<h2>Rules</h2>
<p>The game of Light Em Up! (sometimes called Lights Up or just Lights) is played on a rectangular grid of cells.
    Initially the game presents some squares that are shaded black and represent <em>walls</em>. Of those squares,
    some have numbers in them. This is an example of an initial game presentation:</p>

<figure><img src="images/initial.png" width="346" height="346" alt="Example of an initial game presentation"></figure>

    <p>The unshaded squares are the playing area and are clickable. Each square can be <em>unset</em>, a <em>light</em>, or an <em>unlight</em>:</p>
    <figure class="noshadow"><img src="images/shaded.png" width="478" height="382" alt="Type of cells"></figure>
    <p>When the game starts, even playable square is <em>unset</em>. Clicking a square once changes it to a <em>light</em>, which is indicated by a light bulb image. Clicking a cell a second time changes it to an <em>unlight</em>, which is represented by a black dot (HTML &amp;bull;). Clicking the cell again returns it to <em>unset</em>. The object is to place lights so that:</p>
    <ul>
        <li>Each numbered square has exactly that many lights adjacent to it.</li>
        <li>Every playable square is lit by a light.</li>
        <li>No two lights shine on each other.</li>
    </ul>

    <p>Lights are considered to cast light horizontally and vertically only. The light is stopped by a wall. Unlights are not part of the solution. An unlight is a convenience for the player, since it provides a way to indicate a square the user knows cannot be a light at all.</p>


	<p>Light Em Up! solutions are unique. There is only one possible solution to any given game.</p>
	<h2>How to Play</h2>
<p>Game play proceeds by clicking on cells. Each click toggles a cell value. Click on an unset cell
    toggles it to a light. Clicking on a light toggles it to an unlight. Clicking on an unlight toggles it back
    to unset.</p>

	<h2>Links</h2>
	<ul>
		<li><a href="https://en.wikipedia.org/wiki/Light_Up_(puzzle)">Wikipedia page on Light Up</a></li>
		<li><a href="http://mountainvistasoft.com/docs/lightup-is-np-complete.pdf">Computational Complexity of Light Up</a></li>
	</ul>
</div>

</div>

<?php
echo $view->present_footer();
?>
</body>
</html>
