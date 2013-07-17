<?php

namespace WordChain;

use WordChain\Comparator\LengthComparator,
    WordChain\Comparator\OneLetterDifferenceComparator;

class AdjacentWordFinder
{
    /**
     * @var LengthComparator
     */
    protected $lengthComparator;

    /**
     * @var OneLetterDifferenceComparator
     */
    protected $oneLetterDifferenceComparator;

    /**
     * @param LengthComparator              $lengthComparator
     * @param OneLetterDifferenceComparator $oneLetterDifferenceComparator
     */
    public function __construct($lengthComparator, $oneLetterDifferenceComparator)
    {
        $this->lengthComparator              = $lengthComparator;
        $this->oneLetterDifferenceComparator = $oneLetterDifferenceComparator;
    }

    /**
     * @param  string $a
     * @param  array  $dictionary
     * @return array
     */
    public function getAdjacentWords($a, $dictionary)
    {
        $adjacentWords = array();

        foreach ($dictionary as $b) {
            if ($a === $b) {
                continue; 
            }

            if (!$this->lengthComparator->areTheSameLength($a, $b)) {
                continue;
            }

            if (!$this->oneLetterDifferenceComparator->areOneLetterApart($a, $b)) {
                continue;
            }

            $adjacentWords[] = $b;
        }

        return $adjacentWords;
    }
}
