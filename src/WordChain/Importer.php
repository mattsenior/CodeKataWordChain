<?php

namespace WordChain;

use Everyman\Neo4j\Client as Database;

class Importer
{
    /**
     * @var Dictionary
     */
    protected $dictionary;

    /**
     * @var AdjacentWordFinder
     */
    protected $adjacentWordFinder;

    /**
     * @var Database
     */
    protected $database;

    /**
     * @param Dictionary         $dictionary
     * @param AdjacentWordFinder $adjacentWordFinder
     */
    public function __construct(Dictionary $dictionary, AdjacentWordFinder $adjacentWordFinder)
    {
        $this->dictionary         = $dictionary;
        $this->adjacentWordFinder = $adjacentWordFinder;
        $this->database           = new Database;
    }

    /**
     * @param string $word
     */
    public function addWord($word)
    {
        $this->dictionary->addWord($word);
    }

    public function processAdjacentWords()
    {
        $words = $this->dictionary->getWords();
        $adjacentWords = array();

        foreach ($words as $word) {
            $adjacentWords[$word] = $this->adjacentWordFinder->getAdjacentWords($word, $words);
        }
    }

    /**
     * Save words
     */
    public function saveWords()
    {
        $words  = $this->dictionary->getWords();
        $client = $this->database;

        $client->startBatch();

        foreach ($words as $word) {
            $node = $client->makeNode();
            $node
                ->setProperty('word', $word)
                ->save();
        }

        $client->commitBatch();
    }

    /**
     * Save relationships
     */
    public function saveRelationships()
    {
    }
}
