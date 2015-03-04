<?php
/**
 * @file(pather.php)
 *
 * Calls path class for inputs from cli.
 */

require_once 'includes/path.php';

// If running in the cli, process input through.
if (php_sapi_name() == 'cli') {
    $path = new Path($argv[1], $argv[2]);
    $path->output;
}
