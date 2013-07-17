<?php

namespace WordChain;

class ChainMaker
{
    /**
     * @var \WordChainLengthComparator
     */
    protected $lengthComparator;

    /**
     * @var \WordChain\Dictionary
     */
    protected $dictionary;

    public function __construct($lengthComparator, $dictionary)
    {
        $this->lengthComparator = $lengthComparator;
        $this->dictionary       = $dictionary;
    }

    /**
     * @param  string $a
     * @param  string $b
     * @return array
     */
    public function getShortestChain($a, $b)
    {
        if (!$this->lengthComparator->areTheSameLength($a, $b)) {
            throw new Exception\LengthMismatchException;
        }

        return $this->dictionary->getShortestPaths($a, $b);
    }
}
