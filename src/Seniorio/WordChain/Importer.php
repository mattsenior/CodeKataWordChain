<?php

namespace Seniorio\WordChain;

class Importer
{
    /**
     * @var AdjacentWordFinder
     */
    protected $adjacentWordFinder;

    /**
     * @var Dictionary
     */
    protected $dictionary;

    /**
     * @param Dictionary         $dictionary
     * @param AdjacentWordFinder $adjacentWordFinder
     */
    public function __construct(Dictionary $dictionary, AdjacentWordFinder $adjacentWordFinder)
    {
        $this->dictionary         = $dictionary;
        $this->adjacentWordFinder = $adjacentWordFinder;
    }

    /**
     * Add single word to the dictionary
     *
     * @param string $word
     */
    public function addWord($word)
    {
        $this->dictionary->addWord($word);
    }

    /**
     * Add multiple words to the dictionary
     *
     * @param array $words
     */
    public function addWords(array $words)
    {
        $this->dictionary->addWords($words);
    }

    /**
     * Retrieve all words from the dictionary, then process & store adjacent words
     */
    public function processAdjacentWords()
    {
        $words = $this->dictionary->getWords();

        foreach ($words as $word) {
            $this->dictionary->setAdjacentWords($word, $this->adjacentWordFinder->getAdjacentWords($word, $words));
        }
    }

    /**
     * Reset the dictionary to an empty state
     */
    public function reset()
    {
        $this->dictionary->setWords(array());
    }
}
