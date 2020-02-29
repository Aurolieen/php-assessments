<?php

namespace Aurolieen\Tests;

use Aurolieen\Palindrome;
use PHPUnit\Framework\TestCase;

/**
 * Test suite for the Palindrome assessment class.
 *
 * Class PalindromeTest
 * @package Aurolieen\Tests
 */
class PalindromeTest extends TestCase
{
    protected $palindrome;

    /**
     * Instantiates a Palindrome object on which the tests are executed.
     */
    public function setUp(): void
    {
        $this->palindrome = new Palindrome();
    }

    /**
     * Tests that a word with an even amount of letters that is a palindrome results in true.
     */
    public function testEvenPalindrome()
    {
        $this->assertTrue($this->palindrome->isPalindrome('tattarrattat'), 'tattarrattat is a palindrome');
        $this->assertTrue($this->palindrome->isPalindrome('doggod'), 'doggod is a palindrome');
    }

    /**
     * Tests that a word with an odd amount of letters that is a palindrome results in true.
     */
    public function testOddPalindrome()
    {
        $this->assertTrue($this->palindrome->isPalindrome('deleveled'), 'deleveled is a palindrome');
        $this->assertTrue($this->palindrome->isPalindrome('racecar'), 'racecar is a palindrome');
    }

    /**
     * Tests that a word that isn't a palindrome, results in false.
     */
    public function testNonPalindrome()
    {
        $this->assertFalse($this->palindrome->isPalindrome('abc'), 'abc is not a palindrome');
        $this->assertFalse($this->palindrome->isPalindrome('delevueled'), 'delevueled is not a palindrome');
    }

    /**
     * Tests that differences in casing doesn't reflect the outcome of the result.
     */
    public function testCasingInvariance()
    {
        $this->assertEquals($this->palindrome->isPalindrome('DELEVeled'),
            $this->palindrome->isPalindrome('delevELED'));
    }

    /**
     * Tests that several input values that are invalid return false as output.
     *
     * @param mixed $input Invalid input.
     * @dataProvider invalidInputProvider
     */
    public function testInvalidInput($input)
    {
        $this->assertFalse($this->palindrome->isPalindrome($input));
    }

    /**
     * Provides invalid input data.
     *
     * @return array Array of arrays containing invalid input parameters.
     */
    public function invalidInputProvider()
    {
        return [
            [null],
            [''],
            ['a']
        ];
    }
}
