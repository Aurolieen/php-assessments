<?php

namespace Aurolieen;

/**
 * Assessment 1. File Owners
 *
 * Class FileOwners
 * @package Aurolieen
 */
class FileOwners
{
    /**
     * Groups the provided files by their owners.
     *
     * @param array $files Map containing file keys and owner values.
     * @return array The input files grouped by their owners.
     */
    public function groupByOwners($files)
    {
        if (empty($files) || !is_array($files)) return [];
        $grouped = [];
        foreach ($files as $file => $owner)
        {
            if (!is_string($file) || !is_string($owner)) continue;
            if (!key_exists($owner, $grouped)) $grouped[$owner] = [];
            $grouped[$owner][] = $file;
        }
        return $grouped;
    }
}

$files = [
    "Input.txt" => "Randy",
    "Code.py" => "Stan",
    "Output.txt" => "Randy"
];
$fileOwners = new FileOwners;
var_dump($fileOwners->groupByOwners($files));
