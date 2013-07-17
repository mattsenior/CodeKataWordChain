<?php

namespace WordChain\Comparator;

class LengthComparator
{
    public function areTheSameLength($a, $b)
    {
        return (mb_strlen($a) === mb_strlen($b));
    }
}
