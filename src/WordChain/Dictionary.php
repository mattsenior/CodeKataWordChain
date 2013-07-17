<?php

namespace WordChain;

use Everyman\Neo4j\Client       as Database;
use Everyman\Neo4j\Index        as Index;
use Everyman\Neo4j\Cypher\Query as Query;

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
    }

    /**
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
     * @param  string $word
     * @return array
     */
    public function getAdjacentWords($word)
    {
        $q = new Query($this->db, <<<EOHD
START n=node:words(word='$word')
MATCH (n)-[:IS_ADJACENT_TO]-(m)
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
     * @param string $word
     * @param array  $adjacentWords
     */
    public function setAdjacentWords($word, array $adjacentWords)
    {
        $wordNode = $this->dbIndex->findOne('word', $word);

        if (!$wordNode) {
            $this->addWord($word);
            $wordNode = $this->dbIndex->findOne('word', $word);
        }

        foreach ($adjacentWords as $adjacentWord) {
            $adjacentWordNode = $this->dbIndex->findOne('word', $adjacentWord);

            if (!$adjacentWordNode) {

                $this->addWord($adjacentWord);

                $adjacentWordNode = $this->dbIndex->findOne('word', $adjacentWord);
            }

            $wordNode->relateTo($adjacentWordNode, 'IS_ADJACENT_TO')->save();
        }
    }

    /**
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
