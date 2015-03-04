<?php
/**
 * @file(pather.php)
 *
 * Calls path class for inputs from cli.
 */

// Grab Path class.
require_once 'classes/path.php';

// If running in the cli, process input through.
if (php_sapi_name() == 'cli') {
    // Get new Path class and pass in file inputs.
    $path = new Path\Path($argv[1], $argv[2]);

    // Process the inputs.
    $path->init();
}
