<?php
/**
 * View class for the instructions page
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * View class for the instructions page
 */
class InstructionsView extends View {
	public function __construct(Lights $lights) {
		parent::__construct($lights);
	}

	/**
	 * Present the page header
	 * @return string HTML
	 */
	public function present_header() {
		$html = parent::present_header();

		$html .= <<<HTML
<nav><p><a href="./">NEW GAME</a>
HTML;

		if($this->getGame() !== null) {
            $html .= ' <a href="game.php">RETURN TO GAME</a>';
		}

		$html .= <<<HTML
</p></nav>
<h1 class="center">Light Em Up! Instructions</h1>
</header>
HTML;

		return $html;
	}
}