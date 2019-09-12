<?php
/**
 * View class for the Index (main) page
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * View class for the Index (main) page
 */
class IndexView extends View {
	public function __construct(Lights $lights) {
		parent::__construct($lights);

		$lights->clearGame();
	}

	/**
	 * Present the page header
	 * @return string HTML
	 */
	public function present_header() {
		$html = parent::present_header();

		$html .= <<<HTML
<nav><p><a href="instructions.php">INSTRUCTIONS</a></p></nav>
<h1 class="center">Welcome to Charles Owen's Light Em Up!</h1>
</header>
HTML;

		return $html;
	}

	/**
	 * Present the page body
	 * @return string HTML
	 */
	public function present_body() {
	    $lights = $this->getLights();
	    $games = $lights->getGames()->getGames();

		$name = $lights->getPlayer();

		$html = <<<HTML
<div class="body">
<form class="newgame" method="post" action="post/index-post.php">
	<div class="controls">
	<p class="name"><label for="name">Name </label><br><input type="text" id="name" name="name" value="$name"></p>
	<p><select name="game">
HTML;

		foreach($games as $game) {
			$title = $game->getTitle();
			$file = $game->getFile();
			$html .= "<option value=\"$file\">$title</option>";
		}

		$html .= <<<HTML
		</select></p>
	<p><button>Start or Continue Game</button></p>
HTML;
		if($lights->getMessage() !== null) {
			$html .= '<p class="message">' . $lights->getMessage() . '</p>';
		}

		$html .= <<<HTML
	</div>
</form>
</div>
HTML;

		return $html;
	}
}