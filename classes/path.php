<?php
namespace Path;

use Exception;

/**
 * Path class
 */
class Path
{
    protected $inputName;
    protected $outputName;
    protected $lineLength;
    protected $hashes = array();

    /**
     * Constructor sets input and output.
     */
    public function __construct($input, $output)
    {
        $this->inputName = $input;
        $this->outputName = $output;
    }

    /**
     * Processes input file and stores # locations.
     */
    public function processInput()
    {
        // Check to make sure the file exits and is readable.
        if (file_exists($this->inputName) && is_readable($this->inputName)) {
            // Get handle and open file.
            $handle = fopen($this->inputName, "r");

            // Loop through each file and save # locations.
            $lineCount = 0;
            while (!feof($handle)) {
                // Get the line.
                $line = fgets($handle);

                // Set inital character postion for the line.
                $pos = -1;

                // Get each # position per line.
                while (($pos = strpos($line, '#', $pos + 1)) !== false) {
                    $this->hashes[$lineCount][] = $pos;
                }

                // Set the line length the first time (assumes each line is same).
                if ($line === 1) {
                    $this->lineLength = strlen($line);
                }

                // Next line.
                $lineCount++;
            }

            fclose($handle);
        } else {
            throw new Exception('File did not exist or was not readable.');
        }
    }

    /**
     * Outputs file for given # locations.
     */
    public function outputFile()
    {
        // If inputProcess was not run first throw error.
        if (!isset($this->hashes)) {
            throw new Exception('No hashes, call processInput first.');
        }


    }

    /**
     * Inits functions for cli input.
     */
    public function init()
    {
        $this->processInput();
        $this->outputFile();
    }
}
