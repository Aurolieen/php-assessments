<?php

namespace Aurolieen;

/**
 * Assessment 4. Path
 *
 * @note I have omitted invalid input checks as per the instructions that the input will always be valid.
 *
 * Class Path
 * @package Aurolieen
 */
class Path
{
    public $currentPath;
    private $nodes = [];

    /**
     * Path constructor.
     * Traverses the path pointer to the provided base path.
     *
     * @param string $path The base path.
     */
    function __construct($path)
    {
        $this->cd($path);
    }

    /**
     * Moves the path pointer to the specified new location and updates the string representation of the current path.
     *
     * @param string $newPath New path to traverse to.
     */
    public function cd($newPath)
    {
        $newNodes = explode('/', $newPath);
        foreach ($newNodes as $index => $node) {
            switch ($node)
            {
                case '':                // If the index equals 0, reset to the root otherwise do nothing.
                    if ($index === 0) $this->nodes = [];
                    break;
                case '..':              // Move up one node.
                    array_pop($this->nodes);
                    break;
                default:                // Add a new node.
                    array_push($this->nodes, $node);
                    break;
            }
        }
        $this->currentPath = '/' . implode('/', $this->nodes);
    }
}

$path = new Path('/a/b/c/d');
$path->cd('../x');
echo $path->currentPath;
