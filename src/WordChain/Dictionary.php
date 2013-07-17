<?php

namespace WordChain;

class Dictionary
{
    /**
     * @var array
     */
    protected $words = array();

    public function addWord($word)
    {
        if (!in_array($word, $this->words)) {
            $this->words[] = $word;
        }
    }

    public function getWords()
    {
        return $this->words;
    }
}
