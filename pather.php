<?php
/**
 * @file(pather.php)
 *
 * Calls path class for inputs from cli.
 */

// If running in the cli, process input through.
if (php_sapi_name() == 'cli') {
    // Error if no args.
    if (!isset($argv[1]) || !isset($argv[2])) {
        throw new Exception('One or both input arguments were not set.');
        return;
    }

    // Grab Path class.
    require_once 'classes/path.php';

    // Get new Path class and pass in file inputs.
    $path = new Path\Path($argv[1], $argv[2]);

    // Process the inputs.
    $path->init();
} else {
    throw new Exception('This is meant to be run via cli only.');
}
