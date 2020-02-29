<?php

namespace Aurolieen;

/**
 * Assessment 2. Palindrome
 *
 * Class Palindrome
 * @package Aurolieen
 */
class Palindrome
{
    /**
     * Checks whether or not the given word is a palindrome.
     * One-letter or zero-letter strings are not considered palindromes by this algorithm.
     *
     * @param string $word The word to check.
     * @return bool True if the word is a palindrome, false if otherwise.
     */
    public function isPalindrome($word)
    {
        if (!is_string($word)) return false;
        $length = strlen($word);
        if ($length <= 1) return false;
        $characters = str_split($word);
        $halfLength =  (int)($length / 2);
        for ($i = 0; $i < $halfLength; $i++)
        {
            if (strcasecmp($characters[$i], $characters[$length - $i - 1]) !== 0) return false;
        }
        return true;
    }
}

$palindrome = new Palindrome;
echo $palindrome->isPalindrome('Deleveled');
