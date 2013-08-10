<?php

namespace Seniorio\WordChain\Comparator;

class LengthComparator
{
    /**
     * Are two strings the same length?
     *
     * @param  string $a
     * @param  string $b
     * @return bool
     */
    public function areTheSameLength($a, $b)
    {
        return (mb_strlen($a) === mb_strlen($b));
    }
}
