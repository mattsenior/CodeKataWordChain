<?php

namespace spec\Seniorio\WordChain\Comparator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LengthComparatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('\Seniorio\WordChain\Comparator\LengthComparator');
    }

    function it_should_know_whether_two_strings_are_the_same_length()
    {
        $this->areTheSameLength('a', 'a')->shouldReturn(true);
        $this->areTheSameLength('a', 'b')->shouldReturn(true);
        $this->areTheSameLength('aa', 'b')->shouldReturn(false);
        $this->areTheSameLength('abcdef', 'abcde')->shouldReturn(false);
    }
}
