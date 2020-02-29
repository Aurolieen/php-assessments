<?php

namespace Aurolieen\Tests;

use Aurolieen\Thesaurus;
use PHPUnit\Framework\TestCase;

/**
 * Test suite for the Thesaurus assessment class.
 *
 * Class ThesaurusTest
 * @package Aurolieen\Tests
 */
class ThesaurusTest extends TestCase
{
    protected $thesaurus;

    /**
     * Instantiates a Thesaurus object on which the tests are executed.
     */
    public function setUp(): void
    {
        $this->thesaurus = new Thesaurus();
    }

    /**
     * Tests that a valid JSON string is returned and that all required attributes are present.
     */
    public function testValidJson()
    {
        $result = $this->thesaurus->getSynonyms('');
        $decoded = json_decode($result);
        $this->assertNotNull($decoded, "{$result} is not valid JSON.");
        $this->assertObjectHasAttribute('word', $decoded);
        $this->assertObjectHasAttribute('synonyms', $decoded);
        $this->assertIsArray($decoded->synonyms);
        $this->assertEquals('', $decoded->word);
    }

    /**
     * Tests that the result contains at least one synonym for words known to have synonyms.
     *
     * @depends testValidJson
     */
    public function testAtLeastOneSynonym()
    {
        $result = $this->thesaurus->getSynonyms('big');
        $decoded = json_decode($result);
        $this->assertNotEmpty($decoded->synonyms);
        $result = $this->thesaurus->getSynonyms('buy');
        $decoded = json_decode($result);
        $this->assertNotEmpty($decoded->synonyms);
    }

    /**
     * Tests that zero-character strings and non-existing words result in zero synonyms.
     *
     * @depends testValidJson
     */
    public function testZeroSynonyms()
    {
        $result = $this->thesaurus->getSynonyms('');
        $decoded = json_decode($result);
        $this->assertEmpty($decoded->synonyms);
        $result = $this->thesaurus->getSynonyms('agelast');
        $decoded = json_decode($result);
        $this->assertEmpty($decoded->synonyms);
    }

    /**
     * Tests that invalid input results in zero synonyms.
     *
     * @depends testValidJson
     */
    public function testInvalidInput()
    {
        $result = $this->thesaurus->getSynonyms(null);
        $decoded = json_decode($result);
        $this->assertEmpty($decoded->synonyms);
    }
}
