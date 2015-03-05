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
    protected $lineCount;
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
                    $this->hashes[$lineCount + 1][] = $pos;
                }

                // Set the line length the first time (assumes each line is same).
                if ($lineCount === 0) {
                    $this->lineLength = strlen(trim($line));
                }

                // Next line.
                $lineCount++;
            }

            // Save lineCount for future output.
            $this->lineCount = $lineCount;

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

        // Open the output file for writing.
        $handle = fopen($this->outputName, 'w');

        // Get line of last hash.
        end($this->hashes);
        $last = key($this->hashes);

        // Loop through each line.
        for ($i = 1; $i < $this->lineCount; $i++) {
            $txt = '';

            // If there are no hashes, print only dots.
            if (!isset($this->hashes[$i]) && !isset($star)) {
                $txt = str_repeat('.', $this->lineLength);

            // Row with hash(s).
            } elseif (isset($this->hashes[$i])) {
                $count = count($this->hashes[$i]);

                // For each hash.
                foreach ($this->hashes[$i] as $key => $hash) {
                    $reverseStar = false;
                    // First hash.
                    if ($hash > 0 && $key === 0 && !isset($star)) {
                        $txt .= str_repeat('.', $hash);
                        $txt .= '#';

                    // If row is only hash.
                    } elseif ($hash > 0 && $key === 0 && isset($star) && $hash === $star) {
                        $txt .= str_repeat('.', $hash);
                        $txt .= '#';

                        // Unset for last in line.
                        if ($i === $last && $key === $count - 1) {
                            unset($star);
                        }

                    // If star row and hash is last.
                    } elseif (isset($star) && $hash > $star) {
                        // Account for last char as hash.
                        if (!isset($this->hashes[$i][$key - 1])) {
                            $txt .= str_repeat('.', $star);
                            $starLength = $hash - $star;
                        } else {
                            $starLength = $hash - $star -1;
                        }

                        $txt .= str_repeat('*', $starLength);
                        $txt .= '#';
                        unset($star);

                    // If star row and star is before hash.
                    } elseif (isset($star) && $hash < $star) {
                        $txt .= str_repeat('.', $hash);
                        $txt .= '#';
                        $txt .= str_repeat('*', $star - $hash);

                        // Account for 2 hashes on the same row.
                        if (!isset($this->hashes[$i][$key + 1])) {
                             $txt .= str_repeat('.', $this->lineLength - $star - 1);
                        }

                        $reverseStar = true;
                        unset($star);

                    // Else fill b/w hashes.
                    } elseif ($key > 0) {
                        $currentLength = strlen($txt);
                        $txt .= str_repeat('*', $hash - $currentLength);
                        $txt .= '#';
                    }

                    // End row.
                    if ($key === $count - 1 && $hash !== $this->lineLength && !$reverseStar) {
                        $txt .= str_repeat('.', $this->lineLength - $hash - 1);
                    }

                    // If next row should have only a star.
                    if ($i !== $last && $key === $count - 1) {
                        $star = $hash;
                    }
                }

            // Star only row.
            } elseif (!isset($this->hashes[$i]) && isset($star)) {
                $txt = str_repeat('.', $star);
                $txt .= '*';
                $txt .= str_repeat('.', $this->lineLength - $star - 1);
            }

            // Add line break.
            $txt .= "\n";

            // Write line.
            fwrite($handle, $txt);
        }

        fclose($handle);
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
