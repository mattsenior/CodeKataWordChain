<?php

namespace WordChain\Comparator;

class OneLetterDifferenceComparator
{
    public function areOneLetterApart($a, $b)
    {
        $a = mb_strtolower($a);
        $b = mb_strtolower($b);

        // Levenshtein with a cost of 1 for replace, but 2 for insert/delete should give a result of 1 for one letter difference
        return levenshtein($a, $b, 2, 1, 2) === 1;
    }
}
