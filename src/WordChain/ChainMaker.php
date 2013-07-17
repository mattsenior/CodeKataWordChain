<?php

namespace WordChain;

class ChainMaker
{
    /**
     * @var WordChain\Comparator\LengthComparator
     */
    protected $lengthComparator;

    public function __construct($lengthComparator)
    {
        $this->lengthComparator = $lengthComparator;
    }

    public function getShortestChain($a, $b)
    {
    }
}
