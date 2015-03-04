<?php
namespace includes\path;

/**
 * Path class
 */
class Path
{
    protected $inputName;
    protected $outputName;

    /**
     * Constructor sets input and output.
     */
    public function __construct($input, $output)
    {
        $this->$inputName = $input;
        $this->$outputName = $output;
    }

    /**
     * Output Method.
     *
     * Outputs file for input.
     */
    public function output()
    {
        echo $this->inputName;
    }
}
