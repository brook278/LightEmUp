<?php
/**
 * The collection of available games.
 */

namespace Lights;

/**
 * The collection of available games.
 */
class Games {
    /**
     * Games constructor.
     * @param string $dir Root directory for the site.
     */
    public function __construct(Lights $lights, $dir) {
        $this->lights = $lights;
        $this->load($dir);
    }

    /**
     * Load the games from disk.
     * @param string $dir Root directory for the site.
     */
    private function load($dir) {
        $this->games = [];

        $files = scandir($dir . '/games');
        foreach($files as $file) {
            $len = strlen($file);
            if(substr($file, $len-5) === '.json') {
                // We have found a file!
                $this->games[$file] = new Game($this->lights, $dir . '/games/', $file);
            }
        }
    }

    /**
     * Get available games.
     * @return array of Game objects
     */
    public function getGames() {
        return array_values($this->games);
    }

    /**
     * Get a game by the filename
     * @param string $file
     * @return Game object or null
     */
    public function getGame($file) {
        if(isset($this->games[$file])) {
            return $this->games[$file];
        }

        return null;
    }

    private $lights;
    private $games = [];
}