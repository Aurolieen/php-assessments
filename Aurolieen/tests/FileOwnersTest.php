<?php

namespace Aurolieen\Tests;

use Aurolieen\FileOwners;
use PHPUnit\Framework\TestCase;

/**
 * Test suite for the FilerOwners assessment class.
 *
 * Class FileOwnersTest
 * @package Aurolieen\Tests
 */
class FileOwnersTest extends TestCase
{
    protected $fileOwners;

    /**
     * Instantiates a FileOwners object on which the tests are executed.
     */
    public function setUp(): void
    {
        $this->fileOwners = new FileOwners();
    }

    /**
     * Tests that the output is an array of files grouped by their owners using a random set of file/author combinations
     * as input.
     *
     * @param array $input Well formed array of random files and owners.
     * @dataProvider randomInputProvider
     */
    public function testRandomInput($input)
    {
        $output = $this->fileOwners->groupByOwners($input);
        foreach ($input as $file => $owner)
        {
            $this->assertArrayHasKey($owner, $output);
            $this->assertContains($file, $output[$owner]);
        }
    }

    /**
     * Tests that the output is empty when the input is empty.
     */
    public function testEmptyInput()
    {
        $this->assertEquals([], $this->fileOwners->groupByOwners([]));
    }

    /**
     * Tests that any input elements that aren't strings are skipped.
     *
     * @param mixed $expected The expected output.
     * @param mixed $input Invalid input.
     * @dataProvider invalidInputProvider
     */
    public function testInvalidInput($expected, $input)
    {
        $this->assertEquals($expected, $this->fileOwners->groupByOwners($input));
    }

    /**
     * Provides invalid input data.
     *
     * @return array Array of arrays containing invalid input / expected output combinations.
     */
    public function invalidInputProvider()
    {
        return [
            [[], [1, 2, 3]],
            [
                ["Randy" => ["file.txt", ""]],
                ["file.txt" => "Randy", "file2.txt" => null, "file3.txt" => 2, null => "Randy"]
            ],
            [[], 3]
        ];
    }

    /**
     * Provides valid random input data.
     */
    public function randomInputProvider()
    {
        $randomInputArrays = [];
        for ($i = 0; $i < 5; $i++)
        {
            $randomInputArray = [];
            $randJLength = rand(4, 10);
            for ($j = 0; $j < $randJLength; $j++)
            {
                $file = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, rand(3,10));
                $owner = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, rand(3,10));
                $randomInputArray[$file] = $owner;
            }
            // Create a duplicate owner.
            $randomInputArray[substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, rand(3,10))] = reset($randomInputArray);
            $randomInputArrays[] = [$randomInputArray];
        }
        return $randomInputArrays;
    }
}
