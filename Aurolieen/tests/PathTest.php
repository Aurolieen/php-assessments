<?php

namespace Aurolieen\Tests;

use Aurolieen\Path;
use PHPUnit\Framework\TestCase;

/**
 * Test suite for the Path assessment class.
 *
 * Class PathTest
 * @package Aurolieen\Tests
 */
class PathTest extends TestCase
{
    /**
     * Tests that the constructor sets the currentPath attribute to the same string as the input path.
     */
    public function testBasePath()
    {
        $base = new Path('/a/b/c/d');
        $this->assertEquals('/a/b/c/d', $base->currentPath);
    }

    /**
     * Tests that absolute paths get appended to the current path.
     *
     * @depends testBasePath
     */
    public function testAbsolutePaths()
    {
        $base = new Path('/');
        $base->cd('a/b/c/d');
        $this->assertEquals('/a/b/c/d', $base->currentPath);
        $base = new Path('/a/b/c/d');
        $base->cd('x');
        $this->assertEquals('/a/b/c/d/x', $base->currentPath);
    }

    /**
     * Tests that relative paths traverse up the path when needed.
     *
     * @depends testBasePath
     */
    public function testRelativePaths()
    {
        $base = new Path('/');
        $base->cd('a/b/../d');
        $this->assertEquals('/a/d', $base->currentPath);
        $base = new Path('/a/b/c/d');
        $base->cd('../x');
        $this->assertEquals('/a/b/c/x', $base->currentPath);
        $base = new Path('/a/b/c/d');
        $base->cd('../../../../x');
        $this->assertEquals('/x', $base->currentPath);
    }

    /**
     * Tests that some of the weirder valid paths produce the correct results.
     *
     * @depends testBasePath
     */
    public function testOddPaths()
    {
        $base = new Path('/');
        $base->cd('///////////////////a');
        $this->assertEquals('/a', $base->currentPath);
        $base = new Path('/');
        $base->cd('../x/../x/../a');
        $this->assertEquals('/a', $base->currentPath);
        $base = new Path('/');
        $base->cd('a/..//..//a//b//cde');
        $this->assertEquals('/a/b/cde', $base->currentPath);
    }
}
