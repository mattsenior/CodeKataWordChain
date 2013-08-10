<?php

namespace Seniorio\WordChain;

use Everyman\Neo4j\Client       as Database;
use Everyman\Neo4j\Index        as Index;
use Everyman\Neo4j\Cypher\Query as Query;

use Seniorio\WordChain\Exception;

class Dictionary
{
    /**
     * @var Database\Client
     */
    protected $db;

    /**
     * @var Database\Index
     */
    protected $dbIndex;

    public function __construct()
    {
        $this->db      = new Database;
        $this->dbIndex = new Index\NodeIndex($this->db, 'words');
        $this->dbIndex->save();
    }

    /**
     * Remove and replace words in the dictionary 
     *
     * @param array $words
     */
    public function setWords(array $words)
    {
        // Empty db
        $q = new Query($this->db, <<<EOHD
START n=node(*)
MATCH (n)-[r?]-()
WHERE has(n.word)
DELETE n, r;
EOHD
        );

        // Execute
        $resultSet = $q->getResultSet();

        $this->db->startBatch();

        foreach ($words as $word) {
            $this->addWord($word);
        }

        $this->db->commitBatch();
    }

    /**
     * Add single word
     *
     * @param string $word
     */
    public function addWord($word)
    {
        // Don’t add if already exists
        $wordNode = $this->dbIndex->findOne('word', $word);

        if ($wordNode) {
            return;
        }

        // Add to database
        $node = $this->db->makeNode();
        $node->setProperty('word', $word)->save();

        // Add to index
        $this->dbIndex->add($node, 'word', $node->getProperty('word'));
    }

    /**
     * Add multiple words
     *
     * @param array $words
     */
    public function addWords(array $words)
    {
        $this->db->startBatch();

        foreach ($words as $word) {
            $this->addWord($word);
        }

        $this->db->commitBatch();
    }

    /**
     * Get all words
     *
     * @return array
     */
    public function getWords()
    {
        $q = new Query($this->db, <<<EOHD
START n=node(*)
WHERE has(n.word)
RETURN n.word as word;
EOHD
        );

        $words = array();

        $resultSet = $q->getResultSet();
        foreach ($resultSet as $word) {
            $words[] = $word['n'];
        }

        return $words;
    }

    /**
     * Retrieve adjacent words for given word
     *
     * @param  string $word
     * @return array
     */
    public function getAdjacentWords($word)
    {
        $q = new Query($this->db, <<<EOHD
START n=node:words(word='$word')
MATCH (n)-[:IS_ADJACENT_TO]->(m)
RETURN m.word;
EOHD
        );

        $resultSet     = $q->getResultSet();
        $adjacentWords = array();
        foreach ($resultSet as $adjacentWord) {
            $adjacentWords[] = $adjacentWord['word'];
        }

        return $adjacentWords;
    }

    /**
     * Store adjacent words for a given word
     *
     * @param string $word
     * @param array  $adjacentWords
     */
    public function setAdjacentWords($word, array $adjacentWords)
    {
        echo sprintf('Processing relationships for %s', $word);
        echo "\n";

        $this->db->startBatch();

        $wordNode = $this->dbIndex->findOne('word', $word);

        if (!$wordNode) {
            throw new Exception\WordNotFoundException(sprintf('Word not found: %s', $word));
        }

        foreach ($adjacentWords as $adjacentWord) {
            $adjacentWordNode = $this->dbIndex->findOne('word', $adjacentWord);

            if (!$adjacentWordNode) {
                throw new Exception\WordNotFoundException(sprintf('Word not found: %s', $adjacentWord));
            }

            $wordNode->relateTo($adjacentWordNode, 'IS_ADJACENT_TO')->save();
        }

        $this->db->commitBatch();
    }

    /**
     * Get the shortest paths from A to B
     *
     * @param  string $a
     * @param  string $b
     * @return array
     */
    public function getShortestPaths($a, $b)
    {
        $q = new Query($this->db, <<<EOHD
START a=node:words(word='$a'), b=node:words(word='$b')
MATCH p=allShortestPaths((a)-[:IS_ADJACENT_TO*]->(b))
RETURN p;
EOHD
        );

        $resultSet = $q->getResultSet();

        $shortestPaths = array();

        foreach ($resultSet as $row) {
            $thisPath = array();

            foreach ($row['p']->getNodes() as $node) {
                $thisPath[] = $node->getProperty('word');
            }

            $shortestPaths[] = $thisPath;
        }

        return $shortestPaths;
    }
}
