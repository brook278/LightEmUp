<?php
/**
 * Controller for the form on the options page.
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * Controller for the form on the options page.
 */

class OptionsController extends Controller {
	/**
	 * OptionsController constructor.
	 * @param Lights $lights Lights object
	 * @param array $post $_POST
	 */
	public function __construct(Lights $lights, array $post) {
		parent::__construct($lights);

        if($lights->getGame() === null) {
            $this->setRedirect("../");
        } else {
            $this->setRedirect("../game.php");
        }

        if(isset($post['submit'])) {
            $lights->setShowLighted(isset($post['lighted']));
            $lights->setShowCompleted(isset($post['completed']));
        }

	}
}