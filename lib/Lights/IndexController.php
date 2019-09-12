<?php
/**
 * Controller for the form on the main (index) page.
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * Controller for the form on the main (index) page.
 */

class IndexController extends Controller {
	/**
	 * IndexController constructor.
	 * @param Lights $lights Lights object
	 * @param array $post $_POST
	 */
	public function __construct(Lights $lights, array $post) {
		parent::__construct($lights);

		// Default will be to return to the home page
		$this->setRedirect("../");

		// Clear any error
		$lights->setMessage(null);

		if(!isset($post['name']) || !isset($post['game'])) {
			return;
		}

		$name = trim(strip_tags($post['name']));
		if($name === '') {
            $lights->setMessage("You must enter a name!");
			return;
		}

		$file = strip_tags($post['game']);
		if(!$lights->setGameByFile($file)) {
            $lights->setMessage("Invalid game!");
			return;
		}

        $lights->setPlayer($name);

		$this->setRedirect("../game.php");
	}
}