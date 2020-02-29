<?php

namespace Aurolieen;

use GuzzleHttp\Client;

/**
 * Assessment 3. Thesaurus
 *
 * @note The assessment did not specify any restraints on whether or not the dictionary actually contains any words
 * besides the ones provided as examples. So returning an empty list of synonyms for pretty much every word would have
 * been the optimal solution. However, in the spirit of the puzzle I decided against this and used the Datamuse API to
 * actually obtain real synonyms for the input words should they exist.
 *
 * Class Thesaurus
 * @package Aurolieen
 */
class Thesaurus
{
    /**
     * Obtains all synonyms for the provided word if any exist and outputs the result in JSON format.
     * Only works for words in the English language.
     *
     * @param string $word The word for which to obtain the synonyms.
     * @return string A JSON formatted string of the following layout:
     *  { "word":<input>, "synonyms":[...] }
     */
    public function getSynonyms($word)
    {
        $output = [
            'word' => $word,
            'synonyms' => []
        ];
        if (is_string($word) && strlen($word) > 0) {
            $synonyms = $this->getSynonymsFromDatamuseAPI($word);
            $output['synonyms'] = $synonyms;
        }
        return json_encode($output);
    }

    /**
     * Queries the Datamuse API to obtain synonyms for words in the English language.
     *
     * @link https://www.datamuse.com/api/
     * @param string $word The word for which to obtain the synonyms.
     * @return array Returns a list of strings that are synonyms of the input.
     */
    protected function getSynonymsFromDatamuseAPI($word)
    {
        $client = new Client();
        $options = [
            'timeout' => 5,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ];
        $response = $client->get(
            sprintf('https://api.datamuse.com/words?rel_syn=%s', rawurlencode($word)),
            $options);
        if ($response->getStatusCode() !== 200) return [];
        $decoded = json_decode($response->getBody());
        if (empty($decoded)) return [];
        return array_column($decoded, 'word');
    }
}
