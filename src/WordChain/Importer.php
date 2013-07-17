<?php

namespace WordChain;

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
     * @param string $word
     */
    public function addWord($word)
    {
        $this->dictionary->addWord($word);
    }

    /**
     * @param array $words
     */
    public function addWords(array $words)
    {
        $this->dictionary->addWords($words);
    }

    public function processAdjacentWords()
    {
        $words = $this->dictionary->getWords();

        foreach ($words as $word) {
            $this->dictionary->setAdjacentWords($word, $this->adjacentWordFinder->getAdjacentWords($word, $words));
        }
    }

    public function reset()
    {
        $this->dictionary->setWords(array());
    }
}
