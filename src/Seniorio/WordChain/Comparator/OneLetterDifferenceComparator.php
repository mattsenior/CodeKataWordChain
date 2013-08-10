<?php

namespace Seniorio\WordChain\Comparator;

class OneLetterDifferenceComparator
{
    /**
     * Are two strings one letter apart?
     *
     * @param  string $a
     * @param  string $b
     * @return bool
     */
    public function areOneLetterApart($a, $b)
    {
        $a = mb_strtolower($a);
        $b = mb_strtolower($b);

        // Levenshtein with a cost of 1 for replace, but 2 for insert/delete will give a result of 1 for one letter difference
        return levenshtein($a, $b, 2, 1, 2) === 1;
    }
}
