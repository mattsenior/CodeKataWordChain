<?php

namespace Seniorio\WordChain;

use Seniorio\WordChain\Comparator\LengthComparator;
use Seniorio\WordChain\Comparator\OneLetterDifferenceComparator;

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
     * Get adjacent words for a given word, from an array of words
     *
     * @param  string $a
     * @param  array  $dictionary
     * @return array
     */
    public function getAdjacentWords($a, $dictionary)
    {
        $adjacentWords = array();

        foreach ($dictionary as $b) {

            // A word cannot be adjacent to itself
            if ($a === $b) {
                continue; 
            }

            // Adjacent words must be the same length
            if (!$this->lengthComparator->areTheSameLength($a, $b)) {
                continue;
            }

            // Adjacent words must only have one letter different
            if (!$this->oneLetterDifferenceComparator->areOneLetterApart($a, $b)) {
                continue;
            }

            $adjacentWords[] = $b;
        }

        return $adjacentWords;
    }
}
