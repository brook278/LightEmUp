<?php
/**
 * View class for the options page
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * View class for the options page
 */
class OptionsView extends View {
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
<h1 class="center">Light Em Up! Options</h1>
</header>
HTML;

		return $html;
	}

    /**
     * Present the HTML for the body of the page
     * @return string HTML
     */
    public function present_body() {
        $lights = $this->getLights();

        $check1 = $lights->isShowLighted() ? ' checked' : '';
        $check2 = $lights->isShowCompleted() ? ' checked' : '';

	    $html = <<<HTML
<div class="body">
<form class="options" method="post" action="post/options-post.php">
	<div class="controls">
	    <p class="checkbox"><label><input type="checkbox" name="lighted"$check1> Show lighted squares</label></p>
	    <p class="checkbox"><label><input type="checkbox" name="completed"$check2> Show completed clues</label></p>
	    <p><button type="submit" name="submit">Submit</button></p>
    </div>
</form>
</div>
HTML;

	    return $html;
    }
}