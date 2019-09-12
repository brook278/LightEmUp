<?php
/**
 * General purpose view base class, where we put generic formatting.
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * General purpose view base class, where we put generic formatting.
 */
class View {
    /**
     * View constructor.
     * @param Lights $lights The Lights object
     */
	public function  __construct(Lights $lights) {
		$this->lights = $lights;
	}

    /**
     * Get the Lights object
     * @return Lights object
     */
	public function getLights() {
	    return $this->lights;
    }

    /**
     * Get the current game.
     * @return Game object
     */
	public function getGame() {
		return $this->lights->getGame();
	}

    /**
     * Set any redirect page
     * @param string $redirect Redirect page
     */
    public function setRedirect($redirect) {
        $this->redirect = $redirect;
    }

    /**
     * Get any redirect page
     * @return string Redirect page
     */
    public function getRedirect() {
        return $this->redirect;
    }

    /**
     * Present the entire page using one function.
     * @return string HTML
     */
	public function present() {
		return $this->present_header() .
			$this->present_body() .
			$this->present_footer();
	}

    /**
     * Present the page header.
     * @return string HTML
     */
	public function present_header() {
		$html = <<<HTML
		<header>
<p class="center"><img src="images/lightemup-800.png" width="800" height="140" alt="Header image"/></p>
HTML;
		return $html;
	}

    /**
     * Present the page footer.
     * @return string
     */
	public function present_footer() {
		$html = <<<HTML
<footer>
	<p class="center"><img src="images/lightemup1-800.png" width="800" height="93" alt="Footer image"/></p>
</footer>
HTML;

		return $html;
	}

	private $redirect = null;
}