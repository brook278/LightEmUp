<?php
/**
 * The main game representation class
 *
 * Represents the current state of the game.
 * @author Charles B. Owen
 */

namespace Lights;

/**
 * The main game representation class
 *
 * Represents the current state of the game.
 */
class Game {
    /// The cell is unset
    const CELL_UNSET = -1;

    /// The cell contains a wall
    const WALL = -2;

    /// The cell contains a light
    const LIGHT = -3;

    // The cell contains an "unlight"
    const UNLIGHT = -4;


    public function __construct(Lights $lights, $dir, $file) {
        $this->lights = $lights;
        $this->file = $file;

        $json = file_get_contents($dir . $file);
        $data = json_decode($json, true);

        $this->title = $data['title'];
        $this->width = $data['width'];
        $this->height = $data['height'];

        // Create the solution as initially empty
        $this->solution = [];

        for($r = 1; $r<=$this->height;  $r++) {
            $this->solution[$r] = [];

            for($c=1; $c<=$this->width;  $c++) {
                $this->solution[$r][$c] = self::CELL_UNSET;
            }
        }

        // Add any walls
        foreach($data['walls'] as $wall) {
            $this->solution[$wall['row']][$wall['col']] = $wall['value'] === null ? self::WALL : +$wall['value'];
        }

        // Add any lights
        foreach($data['lights'] as $wall) {
            $this->solution[$wall['row']][$wall['col']] = self::LIGHT;
        }

        // And clear the game board for play
        $this->clear();
    }

    /**
     * Get the game title
     * @return string Title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Get the name of the game file
     * @return string File name
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Clear the game to an initially empty state
     */
    public function clear() {
        $this->grid = $this->solution;
        for($r = 1; $r<=$this->height;  $r++) {
            for($c=1; $c<=$this->width;  $c++) {
                if($this->grid[$r][$c] === self::LIGHT) {
                    $this->grid[$r][$c] = self::CELL_UNSET;
                }
            }
        }
    }



    /**
     * Present the game as a table
     * @param BOOLEAN $buttons If true, put buttons in the cells
     * @return string HTML
     */
    public function presentGame()
    {
        $rows = $this->getRows();
        $cols = $this->getCols();

        $html = "<table>";

        /*
         * The rest of the rows
         */
        for($r=1; $r<=$rows; $r++) {
            $html .=  "<tr>";
            for($c=1; $c<=$cols; $c++) {
                $v = $this->grid[$r][$c];

                if($v === self::WALL) {
                    // Blank walls
                    $html .=  "<td class=\"wall\">&nbsp;</td>";
                } else if($v >= 0) {
                    // Wall with numbers in them
                    if($this->lights->isShowCompleted() && $this->isCompleted($r, $c)) {
                        $html .= "<td class=\"wall completed\">$v</td>";
                    } else {
                        $html .= "<td class=\"wall\">$v</td>";
                    }
                } else {
                    switch($v) {
                        case self::CELL_UNSET:
                            $cls = '';
                            $content = '&nbsp;';
                            break;

                        case self::LIGHT:
                            $cls = 'light';
                            $content = '<img src="images/light.png" width="43" height="75" alt="Light">';
                            break;

                        case self::UNLIGHT:
                            $cls = 'unshaded';
                            $content = "&bull;";
                            break;
                    }

                    if($this->lights->isShowLighted() && $this->isLighted($r, $c)) {
                        $cls = $cls == '' ? 'lighted' : $cls . ' lighted';
                    }

                    if($this->checking) {
                        switch($v) {
                            case self::LIGHT:
                                if($this->solution[$r][$c] !== self::LIGHT) {
                                    $cls = $cls == '' ? 'wrong' : $cls . ' wrong';
                                }
                                break;

                            case self::UNLIGHT:
                                if($this->solution[$r][$c] === self::LIGHT) {
                                    $cls = $cls == '' ? 'wrong' : $cls . ' wrong';
                                }
                                break;
                        }
                    }



                    if($cls !== '') {
                        $cls = 'class="' . $cls . '"';
                    }

                    $html .=  "<td $cls><button name=\"cell\" value=\"$r,$c\">$content</button></td>";
                }

            }
            $html .=  "</tr>";
        }
        $html .= "</table>";

        return $html;
    }

    /**
     * Is the clue at a given location completed?
     * @param int $r Row
     * @param int $c Column
     * @return boolean true if completed
     */
    private function isCompleted($r, $c) {
        $check = [[-1, 0], [1, 0], [0, -1], [0, 1]];
        $completed = 0; // Count how many cells around are completed
        $lights = 0;    // Count of how many lights around there are

        foreach($check as $chk) {
            $r1 = $r + $chk[0];
            $c1 = $c + $chk[1];
            if($r1 >= 1 && $r1 <= $this->height && $c1 >= 1 && $c1 <= $this->width) {
                if($this->grid[$r1][$c1] === self::LIGHT) {
                    $lights++;
                }
            }
        }

        return $lights === $this->grid[$r][$c];
    }

    /**
     * Determine if a cell is lighted by some light.
     * @param int $r Row
     * @param int $c Column
     * @return bool
     */
    private function isLighted($r, $c) {
        // Is there a light above us?
        for($r1 = $r;  $r1 >= 1;  $r1--) {
            $v = $this->grid[$r1][$c];
            if($v === self::LIGHT) {
                return true;
            }

            // Stop when we hit a wall
            if($v === self::WALL || $v >= 0) {
                break;
            }
        }

        // Is there a light below us?
        for($r1 = $r;  $r1 <= $this->height;  $r1++) {
            $v = $this->grid[$r1][$c];
            if($v === self::LIGHT) {
                return true;
            }

            // Stop when we hit a wall
            if($v === self::WALL || $v >= 0) {
                break;
            }
        }

        // Is there a light to the left?
        for($c1=$c;  $c1>=1; $c1--) {
            $v = $this->grid[$r][$c1];
            if($v === self::LIGHT) {
                return true;
            }

            // Stop when we hit a wall
            if($v === self::WALL || $v >= 0) {
                break;
            }
        }

        // Is there a light to the right?
        for($c1=$c;  $c1<=$this->width; $c1++) {
            $v = $this->grid[$r][$c1];
            if($v === self::LIGHT) {
                return true;
            }

            // Stop when we hit a wall
            if($v === self::WALL || $v >= 0) {
                break;
            }
        }

        return false;
    }

    /**
     * Get the current game grid as a PHP array.
     * @return array Grid array (2D) with 1-based indexing by rows, then columns
     */
    public function getGrid() {
        return $this->grid;
    }


    /**
     * Get the game solution as a PHP array.
     * @return array Solution array (2D) with 1-based indexing by rows, then columns
     */
    public function getSolution() {
        return $this->solution;
    }

    /**
     * Get the number of rows in the game
     * @return int Number of rows the game
     */
    public function getRows() {
        return count($this->solution);
    }

    /**
     * Get the number of columns in the game
     * @return int Number of columns in the game
     */
    public function getCols() {
        return count($this->solution[1]);
    }

    /**
     * Handle a click on a row/column of the game.
     * @param int $r Row (1-based)
     * @param int $c Column (1-based)
     */
    public function click($r, $c) {
        $this->checking = false;

        // What is the current cell state?
        $value = $this->grid[$r][$c];

        // If we click on the same location we clicked on last,
        // recover the state before we do anything
        if($r === $this->lastRow && $c === $this->lastCol) {
            $this->grid = $this->saved;
        }

        // Save a copy before we make any change
        $this->saved = $this->grid;
        $this->lastRow = $r;
        $this->lastCol = $c;

        switch($value) {
            case self::CELL_UNSET:
                $this->grid[$r][$c] = self::LIGHT;
                break;

            case self::UNLIGHT:
                $this->grid[$r][$c] = self::CELL_UNSET;
                break;

            case self::LIGHT:
                $this->grid[$r][$c] = self::UNLIGHT;
                break;
        }
    }

    /**
     * Check the status of the puzzle
     * @return false if incomplete or incorrect
     *          true if correct
     */
    public function isCorrect() {
        $rows = $this->getRows();
        $cols = $this->getCols();

        for($r=1; $r<=$rows; $r++) {
            for($c=1; $c<=$cols; $c++) {
                $solution = $this->solution[$r][$c];
                $puzzle = $this->grid[$r][$c];
                if($solution === self::LIGHT) {
                    // Must be a light
                    if($puzzle !== self::LIGHT) {
                        return false;
                    }
                } else {
                    // Must not be a light
                    if($puzzle === self::LIGHT) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * @param boolean $checking Set true to enable error checking
     */
    public function setChecking($checking) {
        $this->checking = $checking;
    }

    /**
     * Set the solving state.
     *
     * This is set to indicate the press of Solve.
     * A second Yes is then required for this to be accepted.
     * @param boolean $c Value to set
     */
    public function setSolving($c) {
        $this->solving = $c;
    }

    /**
     * @return bool Solving property
     */
    public function isSolving() {
        return $this->solving;
    }

    /**
     * Set the clearing state.
     *
     * This is set to indicate the press of Clear.
     * A second Yes is then required for this to be accepted.
     * @param boolean $c Value to set
     */
    public function setClearing($c) {
        $this->clearing = $c;
    }

    /**
     * Get the value of clearing
     * @return bool Current value
     */
    public function isClearing() {
        return $this->clearing;
    }

    /**
     * Solve the game?
     */
    public function solve() {
        $rows = $this->getRows();
        $cols = $this->getCols();

        $this->grid = $this->solution;

        for($r=1; $r<=$rows; $r++) {
            for($c=1; $c<=$cols; $c++) {
                if($this->grid[$r][$c] === self::CELL_UNSET) {
                    $this->grid[$r][$c] = self::UNLIGHT;
                }
            }
        }
    }


    private $file;      // The name of the file containing the game
    private $title;     // The game title from the file
    private $width;     // Width of the game in cells
    private $height;    // Height of the game in cells
    private $grid = null;		// Current game grid
    private $solution = null;   // The solution grid
    private $checking = false;	// True if checking the result

    private $clearing = false;	// True if we are asking if we are sure about clearing!
    private $solving = false;	// True if we are asking if we are sure about solving?

    private $lastRow = null;
    private $lastCol = null;
    private $saved = null;

    private $lights;
}