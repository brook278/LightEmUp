<?php
/**
 * Base class for controllers
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * Base class for controllers
 *
 * Every controller needs to know the system it is
 * a part of and any redirect page. This class makes that easier.
 */
class Controller {
	/**
	 * Controller constructor.
	 * @param Lights $lights Lights object this is a part of
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
	 * Debug option to display the redirect page instead of redirecting to it.
	 * @return string HTML
	 */
	public function showRedirect() {
		return "<p><a href=\"$this->redirect\">$this->redirect</a>";
	}

    /**
     * Get any AJAX response
     * @return JSON result for AJAX
     */
    public function getResult() {
        return $this->result;
    }

	private $lights;
	private $redirect = "./";
    protected $result = null;	///< Result for AJAX operations
}