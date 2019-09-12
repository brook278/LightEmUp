<?php
/**
 * Main game controller. Handles post from the game page.
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * Main game controller. Handles post from the game page.
 */
class GameController extends Controller {
	/**
	 * GameController constructor.
     * @param Lights $lights Lights object
     * @param array $post $_POST
     */
    public function __construct(Lights $lights, array $post) {
        parent::__construct($lights);

        $game = $lights->getGame();

		// Default will be to return to the game page
		$this->setRedirect("../game.php");

		if(isset($post['check'])) {
            $game->setChecking(true);
            $this->result = json_encode(['check' => true, 'view' => $game->presentGame()]);
        }

		// Clear any messages
		$lights->setMessage(null);

		// Handle clicks on cells
		if(isset($post['cell'])) {
			$s = explode(',', strip_tags($post['cell']));
			$row = $post['row'];
			$col = $post['col'];
			$game->click($row, $col);
            $this->result = json_encode(['clicked' => true, 'view' => $game->presentGame()]);
//			if($game->solved()) {
//				$this->setRedirect("../solved.php");
//				return;
//			}
		}

		//
		// Clearing logic
		//
		if($game->isClearing()) {
			if(isset($post['yes'])) {
				$game->clear();
			}
			$game->setClearing(false);
            $gameview = New GameView($lights);
            $this->result = json_encode(['yes' => true, 'view' => $gameview->present_body()]);
		}

		if(isset($post['clear'])) {
			$game->setClearing(true);
			$gameview = New GameView($lights);
            $this->result = json_encode(['clear' => true, 'view' => $gameview->present_body()]);
		}

		//
		// Solving logic
		//
		if($game->isSolving()) {
			if(isset($post['yes'])) {
				$game->solve();
			}

			$game->setSolving(false);
            $gameview = New GameView($lights);
            $this->result = json_encode(['yes' => true, 'view' => $gameview->present_body()]);
		}

		if(isset($post['solve'])) {
			$game->setSolving(true);
            $gameview = New GameView($lights);
            $this->result = json_encode(['solve' => true, 'view' => $gameview->present_body()]);
		}
        if(isset($post['no'])) {
            $gameview = New GameView($lights);
            $this->result = json_encode(['no' => true, 'view' => $gameview->present_body()]);
        }
	}
}